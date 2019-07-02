<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/2/27
 * Time: 15:46
 */
namespace app\api\controller;

use app\common\controller\Api;

class Service extends Api
{
    public function initialize()
    {
        parent::initialize();
        $this->checkToken();
    }
    //还车、退车页面
    public function index(){
        $oid = input('oid');
        $info = db('orders')->field('type_id,logistics_time,total_price,order_id,is_lease,consignee,address,mobile')->where('order_id',$oid)->find();
        $lease = db('lease')->field('start_time,end_time,rate')->where(['id'=>1])->find();
        
        $list = db('orderGoods')->field('goods_name,goods_img,spec_key_name,goods_num,expenses')->where('order_id',$oid)->select();
        foreach ($list as $k=>$v){
            $list1['goods_num'] = $v['goods_num'];
            $list1['expenses'] = $v['expenses'];

            if($info['is_lease']==1){
                $info['day'] = $this->count_time($info['logistics_time'],$lease['start_time'],$lease['end_time'],$list1['expenses'],$lease['rate'],$info['total_price'],$info['type_id'],$list1['goods_num']);
                $info['expense'] = $this->count_expenses($info['logistics_time'],$lease['start_time'],$lease['end_time'],$list1['expenses'],$lease['rate'],$info['total_price'],$info['type_id'],$list1['goods_num']);
                $info['total_price'] = $this->Retreat_expenses($info['logistics_time'],$lease['start_time'],$lease['end_time'],$list1['expenses'],$lease['rate'],$info['total_price'],$info['type_id'],$list1['goods_num']);
                $info['days'] = $this->count_day($info['logistics_time']);
            }else{
                $info['total_price'] = unFormatMoney($info['total_price']);
            }
        }

        return json(['code'=>200,'msg'=>'获取成功','data'=>['info'=>$info,'list'=>$list]]);
    }

    //申请 || 修改 售后
    public function apply()
    {
        $data['oid'] = input('oid');    // 订单id
        $data['uid'] = $this->uid;
//        $type=input('type');
//        switch ($type) {
//            // 1退货退款，2仅退款，3换货
//            case '退货退款':
//                $data['type'] = 1;  //服务类型
//                break;
//            case '仅退款':
//                $data['type'] = 2;  //服务类型
//                break;
//            case '换货':
//                $data['type'] = 3;  //服务类型
//                break;
//
//            default:
//                return $this->errorJson(400,'非法操作');
//                break;
//        }
        $service_type=input('service_type');
        switch ($service_type) {
            // 1质量问题，2租赁订单，3未收到货，4发错货，5其他
            case '质量问题':
                $data['service_type'] = 1;  //退货原因
                break;
            case '租赁还车':
                $data['service_type'] = 2;  //退货原因
                break;
            case '未收到货':
                $data['service_type'] = 3;  //退货原因
                break;
            case '错货':
                $data['service_type'] = 4;  //退货原因
                break;
            case '其他':
                $data['service_type'] = 5;  //退货原因
                break;
            default:
                return $this->errorJson(400,'非法操作');
                break;
        }
//        $data['apply_money'] = input('apply_money');
        $data['illustrate'] = input('illustrate');  // 退款说明
        if(input('image')){
            $img=$this->saveBase64(input('image'));
            $data['image'] =  $img;
        }
        $data['is_invoice'] = input('invoice','0','intval');

        if(!$data['oid'] ||!$data['uid'] ||!$data['service_type'] ||!$data['illustrate'] ||!$data['image']) return $this->errorJson(400,'请将信息填写完整');
        $order = db('orders')->where(['order_id'=>$data['oid'],'uid'=>$this->uid])->value('order_status');
        if(!$order) return $this->errorJson(400,'非法操作');
        if($order!=5) return $this->errorJson(403,'请先确认收货');
        $data['apply_time'] = time();
        $res = db('service')->where(['oid'=>$data['oid']])->value('id');
        if($res){
            $re = db('service')->where(['oid'=>$data['oid']])->update($data);

            if ($data['is_invoice'] == 1){
                $info['sid'] = $res;
                $info['name'] = input('invoicetit');
                $info['is_person'] = input('invoiceType');
                $info['tax_num'] = input('invoiceTFN','','intval');
                $info['consignee'] = input('consignee');
                $info['address'] = input('address');
                $info['mobile'] = input('mobile');
                $invoice = db('invoice')->where(['sid'=>$info['sid']])->update($info);
                if($invoice != false) return $this->errorJson(400,'非法操作');
            }
            db('orders')->where('order_id',$data['oid'])->setField('is_service',1);
            if($re!==false){
//                if($data['service_type']==2){
//                    db('orders')->where('order_id',$data['oid'])->setField('is_lease',1);
//                }
                insertAction($data['oid'],'售后信息','修改了售后申请，等待后台处理',$data['uid']);
                return json(['code'=>200,'msg'=>'申请修改成功']);
            }else{
                return json(['code'=>400,'msg'=>'操作失败']);
            }
        }else{
            $re = db('service')->insertGetId($data);
            if ($data['is_invoice'] == 1){
                $info['sid'] = $re;
                $info['name'] = input('invoicetit');
                $info['is_person'] = input('invoiceType');
                $info['tax_num'] = input('invoiceTFN','','intval');
                $info['consignee'] = input('consignee');
                $info['address'] = input('address');
                $info['mobile'] = input('mobile');
                $invoice = db('invoice')->insert($info);
                if(!$invoice) return $this->errorJson(400,'非法操作');
            }
            if($re){
//                if($data['service_type']==2){
//                    db('orders')->where('order_id',$data['oid'])->setField('is_lease',1);
//                }
                db('orders')->where(['order_id'=>$data['oid']])->setField('is_service',1);
                insertAction($data['oid'],'售后信息','申请了售后，等待后台处理',$data['uid']);
                return json(['code'=>200,'msg'=>'申请提交成功','applyid'=>$re]);
            }else{
                return json(['code'=>400,'msg'=>'操作失败']);
            }
        }
    }
    //售后详情
    public function detail()
    {
        $order_id = input('oid');
        $mess = db('orders')->field('type_id,logistics_time,total_price,order_id,is_lease')->where('order_id',$order_id)->find();
        $lease = db('lease')->field('start_time,end_time,rate')->where(['id'=>1])->find();
        $service_id = db('service')->where('oid',$order_id)->value('id');
        $mess1 = db('invoice')->field('name,is_person,tax_num,consignee,address,mobile')->where('sid',$service_id)->find();
        if(!$service_id) return $this->errorJson(400,'请将信息填写完整');
        $list = db('service')->field('id,isagree_goods,service_type,image,illustrate,is_invoice')->where(['id'=>$service_id,'uid'=>$this->uid])->find();

        switch ($list['service_type']) {
            // 1质量问题，2租赁订单，3未收到货，4发错货，5其他
            case 1:
                $list['service_type'] = '质量问题';  //退货原因
                break;
            case 2:
                $list['service_type'] = '租赁还车';  //退货原因
                break;
            case 5:
                $list['service_type'] = '其他';  //退货原因
                break;
            default:
                return $this->errorJson(400,'非法操作');
                break;
        }
        $mess2 = get_exp_num($mess['order_id']);
        $mess['day'] = $this->count_time($mess['logistics_time'],$lease['start_time'],$lease['end_time'],$mess2['expenses'],$lease['rate'],$mess['total_price'],$mess['type_id'],$mess2['goods_num']);
        $mess['expense'] = $this->count_expenses($mess['logistics_time'],$lease['start_time'],$lease['end_time'],$mess2['expenses'],$lease['rate'],$mess['total_price'],$mess['type_id'],$mess2['goods_num']);
        $mess['total_price'] = $this->Retreat_expenses($mess['logistics_time'],$lease['start_time'],$lease['end_time'],$mess2['expenses'],$lease['rate'],$mess['total_price'],$mess['type_id'],$mess2['goods_num']);
        $mess['days'] = $this->count_day($mess['logistics_time']);
        $mess['name'] = $mess1['name'];
        $mess['is_person'] = $mess1['is_person'];
        $mess['tax_num'] = $mess1['tax_num'];
        $mess['consignee'] = $mess1['consignee'];
        $mess['address'] = $mess1['address'];
        $mess['mobile'] = $mess1['mobile'];
        $list['images'] = explode(',',$list['image']);

        $info = db('orderGoods')->field('goods_name,goods_img,spec_key_name')->where('order_id',$order_id)->select();
        return json(['code'=>200,'data'=>['info'=>$info,'list'=>$list,'mess'=>$mess]]);
    }

    //取消退车、还车
    public function cancel()
    {
        $service_id = input('id');
        if(!$service_id) return $this->errorJson(400,'缺少参数');
        $oid=db('service')->where(['id'=>$service_id,'uid'=>$this->uid])->value('oid');
        $re = db('service')->where(['id'=>$service_id,'uid'=>$this->uid])->delete();
        db('orders')->where(['order_id'=>$oid,'uid'=>$this->uid])->update(['is_service'=>0]);
        db('invoice')->where(['sid'=>$service_id])->setField('status',2);
        return $this->trueOrFalse($re,'取消成功','取消失败 ');
    }

    public function count_day($starttime)
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

    public function count_time($time,$st,$et,$expenses,$rate,$money,$type,$num){
        $nowTime = time();
        $money = unFormatMoney($money);
        $day = ceil(($nowTime - $time)/(24*60*60));
        $diff = $st - $day;
        $diff1 = $et - $day;
//    $diff2= $day - $et;
        $expense1 = $expenses*$num;
        $expense2 = ($expenses + ($day-$et)*$rate)*$num;
        if ($type == 7){
            return "租赁免费";
        }else{
            if($day>0 && $day<=$st){
                return "已租".$day."天还剩".($diff)."天开始计费";
            }else if($day>$st && $day<=$et){
                if($expense1>$money) {
                    return "停止计费(租赁期价超于成品价)";
                }else{
                    return "已租" . $day . "天还剩" . ($diff1) . "天另外计费";
                }
            }else if($day>$et) {
                if($expense2>$money){
                    return "停止计费(租赁期价超于成品价)";
                }else {
                    return "已租" . $day . "天（正按百分率计费）";
                }
            }
        }
    }
    //产生的租赁费用
    public function count_expenses($time,$st,$et,$expenses,$rate,$money,$type,$num){
        $nowTime = time();
        $money = unFormatMoney($money);
        $day = ceil(($nowTime - $time)/(24*60*60));
        $expense = 0;
        $expense1 = $expenses*$num;
//        var_dump($expenses);exit;
        $expense2 = ($expenses + ($day-$et)*$rate)*$num;
        if($type == 7){
            return 0;
        }else{
            if($day>0 && $day<=$st){
                $real_expense = $expense;
                return $real_expense;
            }else if($day>$st && $day<=$et){
                if($expense1>$money){
                    $real_expense = $money;
                    return $real_expense;
                }else{
                    $real_expense = $expense1;
                    return round($real_expense,2);
                }
            }else if($day>$et){
                if($expense2>$money){
                    $real_expense = $money;
                    return $real_expense;
                }else {
                    $real_expense = $expense2;
                    return round($real_expense,2);
                }
            }
        }
    }

    //可退金额
    public function Retreat_expenses($time,$st,$et,$expenses,$rate,$money,$type,$num){
        //发货时间、最小天数、最大天数、固定计费、费率、总价格、商品类型、购买数量
        $nowTime = time();
        $day = ceil(($nowTime - $time)/(24*60*60));
//    $diff = $st - $day;
//    $diff1 = $et - $day;
//    $diff2= $day - $et;
        $real_expense = '';
        $money = unFormatMoney($money);
        $expense = 0;
        $expense1 = $expenses*$num;
        $expense2 = ($expenses + ($day-$et)*$rate)*$num;
        if($type == 7){
            return $money;
        }else{
            if($day>0 && $day<=$st){
                $real_expense = $expense;
                $rt_expenses = $money - $real_expense;
                return $rt_expenses;
            }else if($day>$st && $day<=$et){
                if($expense1>$money){
//                    $real_expense = $money;
//                    $rt_expenses = $money - $real_expense;
                    return 0;
                }else{
                    $real_expense = $expense1;
                    $rt_expenses = $money - $real_expense;
                    return round($rt_expenses,2);
                }
            }else if($day>$et){
                if($expense2>$money){
//                    $real_expense = $money;
//                    $rt_expenses = $money - $real_expense;
                    return 0;
                }else {
                    $real_expense = $expense2;
                    $rt_expenses = $money - $real_expense;
                    return round($rt_expenses,2);
                }
            }
        }
    }
}