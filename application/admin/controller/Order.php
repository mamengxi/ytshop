<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/15
 * Time: 15:42
 */
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Request;
/*
	订单管理
 */
class Order extends Admin
{
    public function index(){
        /*
            order:订单号(order_num) 交易日期(add_time) 买家编号(phone) 状态(status)
            goods:商品名(title) 价格(price)
            cate:商品种类(name)
            delivery:地址->省市区街道字段
         */
        $where=[];
        $order_sn=input('order_sn');
        $order_sn?$where['o.order_sn']=['o.order_sn','like','%'.$order_sn.'%']:'';
        $consignee=input('consignee');
        $consignee?$where['o.consignee']=['o.consignee','like','%'.$consignee.'%']:'';
        input('status')?$where['o.order_status']=input('status'):'';

        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $begin_time&&!$end_time?$where['o.create_time']=['o.create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['o.create_time']=['o.create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['o.create_time']=['o.create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';

        $where['o.deleted'] =0;
        $list = db('orders')->alias('o')
            ->field('o.order_id,o.order_sn,o.order_status,o.total_price,o.pay_status,o.logistics_status,o.logistics_name,o.create_time,o.consignee,o.mobile,o.is_lease,o.type_id')
            ->where($where)
            ->order('create_time desc')
            ->paginate(10,false,['query'=>['order_num'=>$order_sn,'consignee'=>$consignee,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        //把分页数据赋值给模板变量list
        $page = $list->render();
        $this->assign('page',$page);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /*
     *   订单详情
     */
    public function order_info(){
        $where=[];
        $id = input('id',0,'intval');

        $info  =db('orders')->alias('o')
            ->field('o.*,u.nickname')
            ->join('__USER__ u','o.uid=u.id')
            ->where('order_id',$id)
            ->find();
        $info['spec_key_name'] = db('orderGoods')->where('order_id',$info['order_id'])->value('spec_key_name');
        $detail = db('orderGoods')->where('order_id',$info['order_id'])->select();
        $action = db('orderAction')->where('order_id',$info['order_id'])->order('log_time desc')->select();
        $this->assign('action',$action);
        $this->assign('info',$info);
        $this->assign('detail',$detail);

        return view();
    }
    public function goods_send(){
        /*
            提交发货信息
         */
        $oid=input('oid');
//        var_dump($oid);exit;
        if(request()->isPost()){

            $data['logistics_name']=input('shipper_code');
            $data['logistics_code']=input('logistics_code');
            $data['logistics_time']=time();
            $data['logistics_status']= 1;
            $data['order_status']= 4;
            $re=db('orders')->where(['order_id'=>$oid])->update($data);

            if($re!==false){
                insertAction($oid,'快递信息','发送了货品，等待快递到达客户手中',$this->admin);
                return json(array('status'=>true,'info'=>'操作成功！'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败！'));
            }
        }else{
            $info=db('orders')->where(['order_id'=>$oid])->find();
            $this->assign('info',$info);
            $express = db('express')->select();
            $this->assign('express',$express);
            $this->assign('oid',$oid);
            return view();
        }
    }

    public function goods_update(){
        /*
            修改发货信息
         */
        $oid=input('oid');
//        var_dump($oid);exit;
        if(request()->isPost()){

            $data['logistics_name']=input('shipper_code');
            $data['logistics_code']=input('logistics_code');
            $re=db('orders')->where(['order_id'=>$oid])->update($data);
            if($re!==false){
                insertAction($oid,'快递信息','修改了单号，等待快递到达客户手中',$this->admin);
                return json(array('status'=>true,'info'=>'操作成功！'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败！'));
            }
        }else{
            $info=db('orders')->where(['order_id'=>$oid])->find();
            $this->assign('info',$info);
            $express = db('express')->select();
            $this->assign('express',$express);
            $this->assign('oid',$oid);
            return view();
        }

    }

    public function invoice_info(){
        /*
            发票详情
         */
        $where=[];
        $id = input('id',0,'intval');
        $where['o.id']=$id;
//        var_dump($id);exit;
        $info = db('order')
            ->field('o.order_num,i.*')
            ->alias('o')
            ->join('__INVOICE__ i','o.invoice_id=i.id')
            ->where($where)
            ->find();
        // 把分页数据赋值给模板变量list
        $this->assign('info', $info);
        return view();
    }

    public function service(){
        /*
            售后列表
         */
        $where=[];
        $order_sn=input('order_sn');
        $order_sn?$where['o.order_sn']=$order_sn:'';
        $mobile=input('mobile');
        $mobile?$where['o.mobile']=['o.mobile','like','%'.$mobile.'%']:'';
        $where['o.is_service']=1;
        $where['s.service_type'] = ['s.service_type','neq',2];
//        input('status')?$where['o.status']=input('status'):'';

        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $begin_time&&!$end_time?$where['o.create_time']=['o.create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['o.create_time']=['o.create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['o.create_time']=['o.create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';

        $list = db('service')
            ->field('s.*,u.nickname,o.order_sn,o.is_service,o.mobile')
            ->alias('s')
            ->join('__USER__ u','s.uid=u.id')
            ->join('__ORDERS__ o','s.oid=o.order_id')
            ->where($where)
            ->order('s.apply_time desc')
            ->paginate(13,false,['query'=>['order_sn'=>$order_sn,'mobile'=>$mobile,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        $page = $list->render();
        $this->assign('page',$page);
        $this->assign('list',$list);
        return $this->fetch();
        return view();
    }

    public function service_edit(){
        /*
            售后处理信息
         */
        $id=input('id');
        $this->assign('id',$id);
        if(request()->isPost()){
            $filter = input('filter');
            $oid = input('oid','','intval');
            $id = input('id','','intval');
            $status = input('status');
            $refund = input('refund');
            if($filter ==='isagree_goods'){
                $re = db('service')->where('id', $id)->setField($filter, $status);
                if ($re) {
                    return json(array('status' => true, 'info' => '操作成功！'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败！'));
                }
            }
            if ($filter ==='isagree_money'){
                $info = db('orders')->where('order_id', $oid)->field('order_sn,pay_price')->find();
                $data = array();
                $data['out_trade_no'] = $info['order_sn'];
                if($status ==1){
                    $data['refund_fee'] = $refund*100; //要退金额
                }elseif ($status ==2){
                    $data['refund_fee'] = floor($refund*100*0.9); //要退90%金额
                }
                $data['total_fee'] = (int)($info['pay_price']); // 用户支付的实际金额
                if($data['refund_fee']>$data['total_fee']){
                    return json(array('status' => false, 'info' => '退款金额已超过实际支付金额！'));
                }
                if($status ==0){
                    $re = db('service')->where('id', $id)->setField($filter, $status);
                    if ($re) {
                        insertAction($oid, '售后信息', '不同意退款', $this->admin);
                        return json(array('status' => true, 'info' => '操作成功！'));
                    } else {
                        return json(array('status' => false, 'info' => '操作失败！'));
                    }
                }else{
                    $arr = \WxPayApi::wxRefund($data);
                    if ($arr == false) return json(array('status' => false, 'info' => '退款失败！'));
                    if ($arr['result_code'] === 'SUCCESS') {
                        if(array_key_exists('err_code_des',$arr)){
                            log_result($arr['err_code_des'],'refund');
                        }
                        db('orders')->where('order_id', $oid)->setField('order_status', 7);
                        insertAction($oid, '售后信息', '同意退款，并已将退款金额退回至用户账户', $this->admin);
                        $re = db('service')->where('id', $id)->setField($filter, $status);
                        if ($re !== false) {
                            return json(array('status' => true, 'info' => '操作成功！'));
                        } else {
                            return json(array('status' => false, 'info' => '操作失败！'));
                        }
                    }
                }
            }
        }else{
            $info = db('service')
                ->field('s.*,u.nickname,u.phone,o.order_sn,o.total_price,o.order_id as oid')
                ->alias('s')
                ->join('__USER__ u','s.uid=u.id')
                ->join('__ORDERS__ o','s.oid=o.order_id')
                ->where(['s.id'=>$id])
                ->order('s.apply_time desc')
                ->find();
            $info['total_price'] = unFormatMoney($info['total_price']);
            $info['images'] = explode(',',$info['image']);
            $order_id = db('service')->where(['id'=>$id])->value('oid');
            $list = model('order')->get_order_goods($order_id);

            $this->assign('info',$info);
            $this->assign('list',$list);
//            var_dump($list);exit;
            return view();
        }
    }

    public function action(){
        /*
            数据处理
         */
        if(request()->isAjax()){
            $id=input('id','','intval');
            $text=input('text');
            $status=input('status','1','intval');
            $re=db('order')->where(['order_id'=>$id])->update(['remark' =>$text,'status'=>$status]);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功！'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败！'));
            }
        }
    }
}