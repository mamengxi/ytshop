<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/2/5 18:32
 */
namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

class Order extends Api
{
    public function initialize()
    {
        parent::initialize();
        $this->checkToken();
    }

    //确认订单
    public function confirmation()
    {
        $items = $_POST;
        $info = array();
        $totalMoney=0;
        if(count($items['id'])<1){
            return $this->errorJson(400,'未知错误');
        }
        foreach ($items['id'] as $k=>$v)
        {
            $tmpGoods = db('goods')->field('id,title,img_thumb,type_id,expenses')->where('id',$v)->find();
            $tmpItem = db('goodsItem')->field('id,attr_id,attr_name,price,stock')->where('id',$items['itemid'][$k])->find();
            $info[$k]['id'] =$v;
            $info[$k]['title']=$tmpGoods['title'];
            $info[$k]['img_thumb']=$tmpGoods['img_thumb'];
            $info[$k]['type_id']=$tmpGoods['type_id'];
            $info[$k]['price']=$tmpItem['price']/100;
            $info[$k]['attr_name']=$tmpItem['attr_name'];
            $info[$k]['itemid']=$items['itemid'][$k];
            $info[$k]['num'] = $items['num'][$k];
            $totalMoney += $info[$k]['price']*$info[$k]['num'];
            $stocks = $info[$k]['num'];
            if($stocks>$tmpItem['stock']){
                $info[$k]['iscan_buy'] = '立即预订';
            }else{
                $info[$k]['iscan_buy'] = '立即租赁';
            }
        }
        // 获取默认地址
        $address = $this->getCheckAddress();
//        var_dump($tmpGoods['type_id']);exit;
        $agreement = $this->getAgreement($tmpGoods['type_id'],$tmpGoods['expenses'],$tmpItem['price']/100);
        return json(['code'=>200,'data'=>$info,'totalMoney'=>$totalMoney,'totalNum'=>count($items['id']),'address'=>$address,'agreement'=>$agreement]);
    }

    /*
     *  订单详情
     */
    public function detail()
    {
        $order_id = input('order_id','','intval');
        if(!$order_id) return $this->errorJson(400,'缺少参数');
        $check = $this->checkOrder($order_id);
        if($check['uid'] != $this->uid) return $this->errorJson(403,'非法操作');
        $list= db('orders')->field('order_id,order_sn,order_status,consignee,address,mobile,create_time,total_price,is_lease,type_id')->where('order_id',$order_id)->find();
        $list['create_time']=date('Y-m-d H:i:s',$list['create_time']);
        $list['total_price'] = unFormatMoney($list['total_price']);
        $list['detail'] = db('orderGoods')->field('goods_id,goods_name,goods_img,goods_num,goods_price,spec_key_name,is_comment,is_send')->where('order_id',$order_id)->select();
        $server = db('service')->where(['oid'=>$order_id,'uid'=>$this->uid,'status'=>1])->value('id');
        $list['server'] = $server?true:false;
        foreach ($list['detail'] as $k=>$v){
            $list['detail'][$k]['goods_price'] = unFormatMoney($v['goods_price']);
            $list[$k]['type_id'] = $v['type_id'];
        }
        return json(['code'=>200,'data'=>$list]);
    }
    /*
     *  查看物流信息
     */
    public function logistic()
    {
        $order_id = input('id','','intval');
        if(!$order_id) return $this->errorJson(400,'缺少参数');
        $check = $this->checkOrder($order_id);
        if($check['uid'] != $this->uid) return $this->errorJson(403,'非法操作');
        $info = db('orders')->field('type_id,order_id,logistics_code,logistics_name,address')->where('order_id',$order_id)->find();
//        if(!$info['logistics_code']) return $this->errorJson(400,'未发货不能确认收货');
        $info['express_company'] =db('express')->where('shipper_code',trim($info['logistics_name']))->value('express_company');
        $detail = db('orderGoods')->field('goods_name,goods_img,goods_num,goods_price,spec_key_name')->where('order_id',$order_id)->select();
        foreach ($detail as $k=>$v){
            $detail[$k]['goods_price']=unFormatMoney($v['goods_price']);
        }
        $res = \Kdniao::getOrderTracesByJson($info['logistics_name'],$info['logistics_code']);
        foreach ($res['Traces'] as $k=>$v){
            $time=explode(' ',$v['AcceptTime']);
            $res['Traces'][$k]['date']=$time[0] ;
            $res['Traces'][$k]['time']=$time[1] ;
        }
        return json(['code'=>200,'data'=>['info'=>$info,'goods'=>$detail,'express'=>array_reverse($res['Traces'])]]);
    }
    /**
     *  确认收货
     * @return \think\response\Json
     */
    public function receipt()
    {
        $order_id = input('id','','');
        if(!$order_id) return $this->errorJson(400,'缺少参数');
        $orderInfo =db('orders')->field('order_id,order_sn')->where(['order_id'=>$order_id,'deleted'=>0,'uid'=>$this->uid])->find();
        if(!$orderInfo) return $this->errorJson(400,'非法操作');
        Db::startTrans();
        try{
            // 订单修改
            db('orders')->where('order_id',$order_id)->setField(['order_status'=>5,'confirm_time'=>time()]);
            //
            $orderAction['order_id']=$order_id;
            $orderAction['log_time']=time();
            $orderAction['status_desc']='确认收货';
            $orderAction['action_note']='用户确认收到了';
            db('orderAction')->insert($orderAction);
            Db::commit();
            return json(['code'=>200,'msg'=>'确认成功']);
        }catch (\Exception $e){
            return $this->errorJson(400,'系统繁忙');
        }
    }

    /**
     * 根据状态获取对应的订单
     * @return \think\response\Json
     */
    public function show()
    {
        $step = input('id','','intval');
        switch ((int)$step){  //1、待付款 2、待发货 3、待收货 4、已完成
            case 0:
                $lists = db('orders')->field('type_id,order_id,total_price,order_status,is_service,is_lease,logistics_time,create_time')->where(['uid'=>$this->uid,'deleted'=>0])->where('order_status','neq',6)->order('create_time desc')->select();
                break;
            case 1:
                $lists = db('orders')->field('type_id,order_id,total_price,order_status,is_lease,create_time')->where(['pay_status'=>0,'uid'=>$this->uid,'order_status'=>2,'deleted'=>0])->order('create_time desc')->select();
                break;
            case 2:
                $lists = db('orders')->field('type_id,order_id,total_price,order_status,is_lease,create_time')->where(['pay_status'=>1,'uid'=>$this->uid,'order_status'=>3,'deleted'=>0])->order('create_time desc')->select();
                break;
            case 3:
                $lists = db('orders')->field('type_id,order_id,total_price,order_status,is_lease,create_time,logistics_time')->where(['pay_status'=>1,'uid'=>$this->uid,'order_status'=>4,'deleted'=>0])->order('create_time desc')->select();
                break;
            case 4:
                $lists = db('orders')->field('type_id,order_id,total_price,order_status,is_service,is_lease,logistics_time,create_time')->where(['pay_status'=>1,'uid'=>$this->uid,'order_status'=>5,'deleted'=>0])->order('create_time desc')->select();
                break;
        }
        if(!$lists){
            return json(['code'=>200,'data'=>[]]);
        }
        foreach ($lists as $k=>$v){
            $lists[$k]['goodList']= model('Order')->get_order_goods($v['order_id']);
            $lists[$k]['iscomment'] = db('orderGoods')->where('order_id',$v['order_id'])->value('is_comment');
            if($lists[$k]['goodList']){
                $lists[$k]['num']=count($lists[$k]['goodList']);
            }
            $lists[$k]['total_price'] = unFormatMoney($v['total_price']);
            $lists[$k]['days'] = $this->count_day($v['logistics_time']);
            $lists[$k]['surplus_days'] = $this->sure_receive($v['logistics_time'],$v['order_id'],$v['order_status']);
            $lists[$k]['type_id'] = $v['type_id'];
        }
        return json(['code'=>200,'data'=>$lists]);
    }

    /*
     *  取消订单
     */
    public function unOrder()
    {
        $order_id = input('order_id');
        $res =$this->checkOrder($order_id);
        if(!$res) return $this->errorJson(400,'缺少参数');
        if($res['uid'] != $this->uid) return $this->errorJson(403,'非法操作');
        if($res['order_status'] ==6) return $this->errorJson(400,'重复操作');
        $re= db('orders')->where('order_id',$order_id)->setField('order_status',6);
        $gid = db('orderGoods')->where('order_id',$order_id)->value('goods_id');
        $num = model('order')->getOrderNum($order_id);
        db('goodsItem')->where('gid',$gid)->setInc('stock',$num);
        return $this->trueOrFalse($re,'取消成功','取消失败');
    }
    /*
     *  删除订单
     */
    public function delOrder()
    {
        $order_id = input('order_id');
        $res =$this->checkOrder($order_id);
        if(!$res) return $this->errorJson(400,'缺少参数');
        if($res['uid'] != $this->uid) return $this->errorJson(403,'非法操作');
        if($res['deleted'] ==1) return $this->errorJson(400,'重复操作');
        $re= db('orders')->where('order_id',$order_id)->setField('deleted',1);
        return $this->trueOrFalse($re,'删除成功','删除失败');
    }

    public function getOrderInfo(){
        $order_id = input('order_id','','intval');
        if(!$order_id) return $this->errorJson(400,'缺少参数');
        $info = db('orders')->field('order_id,total_price')->where(['order_id'=>$order_id,'uid'=>$this->uid])->find();
        if(!$info) return $this->errorJson(400,'数据不存在');
        $info['total_price']=unFormatMoney($info['total_price']);
        $data['info']=$info;
        $suggest = db('goods')->field('id,title,img_thumb,price,original_price')->order('create_time desc')->where('status',1)->limit(0,4)->select();
        if($suggest){
            foreach ($suggest as $k=>$v){
                $suggest[$k]['price'] = unFormatMoney($v['price']);
                $suggest[$k]['original_price'] = unFormatMoney($v['original_price']);
            }
        }
        $data['suggest'] = $suggest;
        return json(['code'=>200,'data'=>$data]);
    }

    private function checkOrder($order_id)
    {
        return db('orders')->field('order_id,uid,order_status,deleted')->where('order_id',$order_id)->find();
    }

    public function comment()
    {
        $order_id=input('order_id','','intval');
        if(!$order_id) return $this->errorJson(400,'缺少参数');
        $check = $this->checkOrder($order_id);
        if($check['uid'] != $this->uid) return $this->errorJson(403,'非法操作');
        $data['gid'] = input('gid');
        $data['order_id'] = $order_id;
        $data['content'] = input('content','该用户没有写任何评论');
        if(input('image')){
            $img=$this->saveBase64(input('image'));
            $data['image'] =  $img;
        }
        $data['uid'] = $this->uid;
        $data['time'] = time();
//        var_dump($data);exit;
        Db::startTrans();
        try{
            // 写入评论表
            db('comments')->insert($data);
            // 修改order_goods 表里面的已评论
            db('orderGoods')->where('order_id',$order_id)->setField('is_comment',1);
            Db::commit();
            return json(['code'=>200,'msg'=>'评论成功!']);
        }catch (\Exception $e){
            Db::rollback();
            return json(['code'=>400,'msg'=>'评论失败!']);
        }
    }

    public function getAgreement($type,$expenses,$money)
    {
        if($type == 7){
            $content = $this->price_replace1($type,$expenses,$money);
//            $content = db('lease')->where('id',1)->value('contract_b');
        }else{
            $content = $this->price_replace($type,$expenses,$money);
//            $content = db('lease')->where('id',1)->value('contract');
        }
        return $content;
    }

    function count_day($starttime)
    {
        $endtime = time();
        $timediff = $endtime-$starttime;
        $days = intval($timediff/86400);
        if ($days<=21){
            return 1;
        }else{
            return 0;
        }
    }
    function sure_receive($starttime,$order_id,$status){
        if ($starttime){
            $endtime = $starttime+(21*86400);
//        var_dump($endtime);exit;
            $current = time();
            $surplus_days = intval(($endtime-$current)/86400);
            $data['order_status'] = 5;
            $data['confirm_time'] = $current;
            if($surplus_days<=0){
                //如果小于等于0，则超过21，更改状态为已完成（自动确认收货）
                if($status==4){
                    db('orders')->where('order_id',$order_id)->update($data);
                }
                return '已确认收货';
            }else{
                //还在计算距离到21天的时间
                return $surplus_days;
            }
        }
    }

    public function price_replace($type,$expenses,$money){
        //固定计费、总价格
//        var_dump($type);
//        var_dump($expenses);
//        var_dump($money);
//        exit;
        $lease_a = db('lease')->field('start_time,end_time,rate,contract')->where('id',1)->find();
//        var_dump($lease_a);exit;
        $a1 = $money-$expenses;
        $a2_1 = $expenses+(360-$lease_a['end_time'])*$lease_a['rate'];
        $a2_2 = $money-$a2_1;
        $a3_1 = $expenses+(720-$lease_a['end_time'])*$lease_a['rate'];
        $a3_2 = $money-$a3_1;
        $a4_1 = $expenses+(1080-$lease_a['end_time'])*$lease_a['rate'];
        $a4_2 = $money-$a4_1;
        $str = '<table data-sort="sortDisabled">
                    <tbody>
                        <tr class="firstRow">
                            <td valign="top" colspan="4" style="word-break: break-all;">
                                <p style="line-height: 1.5em;">
                                    <span style="font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: 宋体; font-size: 14px;">价格：<span style="font-size: 18px; font-family: Calibri;">'.$money.'</span>元</span></strong></span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="164" valign="top" rowspan="4" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: 宋体; font-size: 14px;">租赁期</span></strong></span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 14px;">时间（天数N）</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 18px;"><span style="font-family: 宋体; font-size: 14px;">实际花费</span><span style="font-family: Calibri; font-size: 14px;">(</span><span style="font-family: 宋体; font-size: 14px;">单位元</span><span style="font-family: Calibri; font-size: 14px;">)</span></span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: 宋体; font-size: 14px;">可退费用（单位元）</span></strong></span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="text-indent: 42px; font-family: 宋体, SimSun; font-size: 14px;">N&lt;='.$lease_a['start_time'].'</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-size: 18px; font-family: 宋体, SimSun;">0</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;">999</span></strong><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;"></span></strong></span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: Calibri; text-indent: 28px; font-size: 14px;">'.$lease_a['start_time'].'&lt;N&lt;='.$lease_a['end_time'].'</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: Calibri; font-size: 14px;">'.$expenses.'</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-size: 14px;"><strong style="white-space: normal;"><span style="font-family: Calibri;">'.$a1.'</span></strong></span><span style="font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;"></span></strong><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;"></span></strong><strong style="white-space: normal;"></strong></span>
                                </php>
                            </td>
                        </tr>
                        <tr>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: Calibri; text-indent: 56px; font-size: 14px;">'.$lease_a['end_time'].'&lt;N</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-size: 18px;"><span style="font-family: Calibri; font-size: 14px;">'.$expenses.'+</span><span style="font-family: 宋体; font-size: 14px;">（</span><span style="font-family: Calibri; font-size: 14px;">n-'.$lease_a['end_time'].'</span><span style="font-family: 宋体; font-size: 14px;">）</span><span style="font-family: Calibri; font-size: 14px;">X'.$lease_a['rate'].'</span></span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-size: 14px;"><strong style="white-space: normal;"><span style="font-family: Calibri;">'.$money.'-</span></strong><strong style="white-space: normal;"><span style="font-family: 宋体;">（</span></strong><strong style="white-space: normal;"><span style="font-family: Calibri;">'.$expenses.'+</span></strong><strong style="white-space: normal;"><span style="font-family: 宋体;">（</span></strong><strong style="white-space: normal;"><span style="font-family: Calibri;">n-'.$lease_a['end_time'].'</span></strong><strong style="white-space: normal;"><span style="font-family: 宋体;">）</span></strong><strong style="white-space: normal;"><span style="font-family: Calibri;">X'.$lease_a['rate'].'</span></strong><strong style="white-space: normal;"><span style="font-family: 宋体;">）</span></strong></span><span style="font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: 宋体;"></span></strong><strong style="white-space: normal;"><span style="font-family: 宋体;"></span></strong></span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="164" valign="top" rowspan="3"></td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-size: 18px; font-family: 宋体, SimSun;"><span style="text-indent: 56px; font-family: 宋体; font-size: 14px;">N</span><span style="text-indent: 56px; font-family: Calibri; font-size: 14px;">=360</span></span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 14px;">'.$a2_1.'</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;">'.$a2_2.'</span></strong><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;"></span></strong></span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="text-indent: 56px; font-family: 宋体, SimSun; font-size: 14px;">N=720</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 14px;">'.$a3_1.'</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;">'.$a3_2.'</span></strong><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;"></span></strong></span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="text-indent: 56px; font-family: 宋体, SimSun; font-size: 14px;">N=1080</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 14px;">'.$a4_1.'</span>
                                </p>
                            </td>
                            <td width="164" valign="top" style="word-break: break-all;">
                                <p style="line-height: normal;">
                                    <span style="font-family: 宋体, SimSun; font-size: 18px;"><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;">'.$a4_2.'</span></strong><strong style="white-space: normal;"><span style="font-family: Calibri; font-size: 14px;"></span></strong></span>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>';
        $a = $lease_a['contract'];
//        var_dump($a);exit;
        $a = str_replace('此处为合同表格展示处（管理人员切记不可删除该红色部分）',$str,$a);
        return $a;

    }

    public function price_replace1($type,$expenses,$money){
        //固定计费、总价格
//        var_dump($type);
//        var_dump($expenses);
//        var_dump($money);
//        exit;
        $lease_a = db('lease')->field('start_time,end_time,rate,contract_b')->where('id',1)->find();
//        var_dump($lease_a);exit;
        $str = '<table>
                <tbody>
                    <tr style="height:24px" class="firstRow">
                        <td width="605" valign="top" colspan="4" style="padding: 1px 7px 0px; border-width: 1px; border-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">价格：<span style="font-size: 16px; font-family: Calibri;">'.$money.'</span><span style="font-size: 16px; font-family: 宋体;">元</span></span></strong><strong><span style="font-size: 16px; font-family: 宋体;"></span></strong></span>
                            </p>
                        </td>
                    </tr>
                    <tr style="height:34px">
                        <td width="34" valign="top" rowspan="4" style="padding: 1px 7px 0px; border-left-width: 1px; border-left-color: windowtext; border-right-width: 1px; border-right-color: windowtext; border-top-style: none; border-bottom-width: 1px; border-bottom-color: windowtext; word-break: break-all;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">租赁期</span></strong><strong><span style="font-family: 宋体; font-size: 14px;"></span></strong></span>
                            </p>
                        </td>
                        <td width="124" valign="top" style="padding: 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top-width: 1px; border-top-color: windowtext; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="margin-left: 12px; line-height: normal;">
                                <span style="font-family: 宋体; font-size: 16px;">时间（天数N）</span>
                            </p>
                        </td>
                        <td width="212" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top-width: 1px; border-top-color: windowtext; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><span style="font-family: 宋体; font-size: 14px;">实际花费</span><span style="font-family: Calibri; font-size: 14px;">(</span><span style="font-family: 宋体; font-size: 14px;">单位元</span><span style="font-family: Calibri; font-size: 14px;">)</span></span>
                            </p>
                        </td>
                        <td width="208" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top-width: 1px; border-top-color: windowtext; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">可退费用（单位元）</span></strong><strong><span style="font-family: 宋体; font-size: 14px;"></span></strong></span>
                            </p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td width="168" valign="top" style="padding: 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="margin-left: 12px; text-indent: 42px; line-height: normal;">
                                <span style="font-family: Calibri; font-size: 16px;">N&lt;='.$lease_a['start_time'].'</span>
                            </p>
                        </td>
                        <td width="106" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-family: Calibri; font-size: 16px;">0</span>
                            </p>
                        </td>
                        <td width="260" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">'.$money.'</span></strong><strong><span style="font-family: 宋体; font-size: 14px;"></span></strong></span>
                            </p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td width="168" valign="top" style="padding: 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="margin-left: 12px; text-indent: 28px; line-height: normal;">
                                <span style="font-family: Calibri; font-size: 16px;">'.$lease_a['start_time'].'&lt;N&lt;='.$lease_a['end_time'].'</span>
                            </p>
                        </td>
                        <td width="106" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-family: 宋体; font-size: 16px;">0</span>
                            </p>
                        </td>
                        <td width="260" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">'.$money.'</span></strong><strong><span style="font-family: 宋体; font-size: 14px;"></span></strong></span>
                            </p>
                        </td>
                    </tr>
                    <tr style="height:24px">
                        <td width="168" valign="top" style="padding: 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="text-indent: 56px; line-height: normal;">
                                <span style="font-family: Calibri; font-size: 16px;">'.$lease_a['end_time'].'&lt;N</span>
                            </p>
                        </td>
                        <td width="106" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-family: 宋体; font-size: 16px;">0</span>
                            </p>
                        </td>
                        <td width="260" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">'.$money.'</span></strong><strong><span style="font-family: 宋体; font-size: 14px;"></span></strong></span>
                            </p>
                        </td>
                    </tr>
                    <tr style="height:19px">
                        <td width="34" valign="top" rowspan="3" style="padding: 1px 7px 0px; border-left-width: 1px; border-left-color: windowtext; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;"></td>
                        <td width="124" valign="top" style="padding: 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="text-indent: 56px; line-height: normal;">
                                <span style="font-size: 16px;"><span style="font-family: 宋体; font-size: 14px;">N</span><span style="font-family: Calibri; font-size: 14px;">=360</span></span>
                            </p>
                        </td>
                        <td width="212" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-family: 宋体; font-size: 16px;">0</span>
                            </p>
                        </td>
                        <td width="208" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">'.$money.'</span></strong><strong><span style="font-family: 宋体; font-size: 14px;"></span></strong></span>
                            </p>
                        </td>
                    </tr>
                    <tr style="height:15px">
                        <td width="168" valign="top" style="padding: 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="text-indent: 56px; line-height: normal;">
                                <span style="font-family: 宋体; font-size: 16px;">N=720</span>
                            </p>
                        </td>
                        <td width="106" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-family: 宋体; font-size: 16px;">0</span>
                            </p>
                        </td>
                        <td width="260" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">'.$money.'</span></strong><strong><span style="font-family: 宋体; font-size: 14px;"></span></strong></span>
                            </p>
                        </td>
                    </tr>
                    <tr style="height:28px">
                        <td width="168" valign="top" style="padding: 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="text-indent: 56px; line-height: normal;">
                                <span style="font-family: 宋体; font-size: 16px;">N=1080</span>
                            </p>
                        </td>
                        <td width="106" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-family: 宋体; font-size: 16px;">0</span>
                            </p>
                        </td>
                        <td width="260" valign="top" style="padding: 1px 7px 0px; border-left: none; border-right-width: 1px; border-right-color: windowtext; border-top: none; border-bottom-width: 1px; border-bottom-color: windowtext;">
                            <p style="line-height: normal;">
                                <span style="font-size: 16px;"><strong><span style="font-family: 宋体; font-size: 14px;">'.$money.'</span></strong><strong><span style="font-family: 宋体; font-size: 14px;"></span></strong></span>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>';
        $a = $lease_a['contract_b'];
//        var_dump($a);exit;
        $a = str_replace('此处为合同表格展示处（管理人员切记不可删除该红色部分）',$str,$a);
        return $a;

    }
}