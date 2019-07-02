<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/24
 * Time: 17:00
 */
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Request;
class Lease extends Admin
{
    public function term()
    {
        /*
            修改租赁信息
         */
        if (request()->isAjax()) {
//            $data['expenses'] = input('expenses');
            $data['start_time'] = input('start_time');
            $data['end_time'] = input('end_time');
            $data['rate'] = input('rate');

            $res  = db('lease')->where(['id'=>1])->find();
            if($res){
                $re = db('lease')->where(['id'=>1])->update($data);

                if ($re !== false) {
                    return json(array('status' => true, 'info' => '操作成功！'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败！'));
                }
            }else{
                $re = db('lease')->insert($data);
                if ($re) {
                    return json(array('status' => true, 'info' => '操作成功！'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败！'));
                }
            }

        } else {
            $info = db('lease')->where(['id'=>1])->find();
            $this->assign('info', $info);
            return view();
        }
    }

    /**
     * 租赁商品列表
     */
    public function index(){
        /*
            order:订单号(order_num) 交易日期(add_time) 买家编号(phone) 状态(status)
            goods:商品名(title) 价格(price)
            cate:商品种类(name)
            delivery:地址->省市区街道字段
         */
        $where=[];
        $mobile= input('mobile');
        $mobile?$where['o.mobile']=['o.mobile','like','%'.$mobile.'%']:'';
        $order_sn=input('order_sn');
        $order_sn?$where['o.order_sn']=['o.order_sn','like','%'.$order_sn.'%']:'';

        $where['o.is_lease'] = 1;
//        $where['s.service_type'] = 2;
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $begin_time&&!$end_time?$where['o.logistics_time']=['o.logistics_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['o.logistics_time']=['o.logistics_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['o.logistics_time']=['o.logistics_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';

        $lease = db('lease')->where(['id'=>1])->find();

        $page = db('orders')
            ->field('o.*,s.isagree_money')
            ->alias('o')
            ->join('__SERVICE__ s','s.oid=o.order_id')
            ->where($where)
            ->order(['s.isagree_money'=>3,'s.apply_time'=>'desc'])
            ->paginate(13,false,['query'=>['order_sn'=>$order_sn,'mobile'=>$mobile,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        $list=$page->all();
        foreach ($list as $k => $v){
            $info=get_exp_num($v['order_id']);
            $list[$k]['expenses'] = $info['expenses'];
            $list[$k]['goods_num'] = $info['goods_num'];
        }
        $this->assign('page',$page);
        $this->assign('lease',$lease);
        $this->assign('list',$list);
        return view();
    }

    /**
     * 租赁商品列表详情
     */
    public function lease_detail(){

        $oid = input('id');
        $where['o.is_lease'] = 1;
        if(request()->isPost()) {
            $filter = input('filter');
            $sid = input('sid', '', 'intval');
            $status = input('status');
            $refund = input('refund');
            $info = db('orders')->where('order_id', $oid)->field('order_sn,pay_price')->find();
            $data = array();
            $data['out_trade_no'] = $info['order_sn'];
            $data['refund_fee'] = $refund*100; //要退金额
            $data['total_fee'] = (int)($info['pay_price']); // 用户支付的实际金额
            $arr = \WxPayApi::wxRefund($data);
            if($data['refund_fee']>$data['total_fee']){
                return json(array('status' => false, 'info' => '退款金额已超过实际支付金额！'));
            }
            if ($arr == false) return json(array('status' => false, 'info' => '退款失败！'));
            if ($arr['result_code'] === 'SUCCESS') {
                if(array_key_exists('err_code_des',$arr)){
                    log_result($arr['err_code_des'],'refund');
                }
                //1.修改订单状态为已退款   order_status
                db('orders')->where('order_id', $oid)->setField('order_status', 7);
                //2、order_action  记录操作
                insertAction($oid, '售后信息', '同意退款，并已将退款金额退回至用户账户', $this->admin);
                $re = db('service')->where('id', $sid)->setField($filter, $status);
                db('service')->where('id', $sid)->setField('isagree_goods', 1);

                if ($re !== false) {
                    return json(array('status' => true, 'info' => '操作成功！'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败！'));
                }
            }
        }else {
                $lease = db('lease')->where(['id' => 1])->find();

                $list = db('orders')
                    ->field('o.*,s.id,s.image,s.isagree_money,s.type,s.service_type,s.illustrate')
                    ->alias('o')
                    ->join('__SERVICE__ s', 's.oid=o.order_id')
                    ->where(['o.is_lease' => 1, 'o.order_id' => $oid])
                    ->order('o.logistics_time desc')
                    ->find();
                $list['images'] = explode(',', $list['image']);
                $info = get_exp_num($list['order_id']);
                $list['expenses'] = $info['expenses'];
                $list['goods_num'] = $info['goods_num'];
                $this->assign('lease', $lease);
                $this->assign('list', $list);
                return view();
            }
        }

    public function contract()
    {
        /*
            修改A类租赁合同
         */
        if (request()->isAjax()) {
            $data['contract'] = input('contract');

            $res  = db('lease')->where(['id'=>1])->find();
            if($res){
                $re = db('lease')->where(['id'=>1])->update($data);

                if ($re !== false) {
                    return json(array('status' => true, 'info' => '操作成功！'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败！'));
                }
            }else{
                $re = db('lease')->insert($data);
                if ($re) {
                    return json(array('status' => true, 'info' => '操作成功！'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败！'));
                }
            }

        } else {
            $info = db('lease')->where(['id'=>1])->find();
            $this->assign('info', $info);
            return view();
        }
    }

    public function contract_b()
    {
        /*
            修改A类租赁合同
         */
        if (request()->isAjax()) {
            $data['contract_b'] = input('contract_b');

            $res  = db('lease')->where(['id'=>1])->find();
            if($res){
                $re = db('lease')->where(['id'=>1])->update($data);

                if ($re !== false) {
                    return json(array('status' => true, 'info' => '操作成功！'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败！'));
                }
            }else{

                $re = db('lease')->insert($data);
                if ($re) {
                    return json(array('status' => true, 'info' => '操作成功！'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败！'));
                }
            }

        } else {
            $info = db('lease')->where(['id'=>1])->value('contract_b');
            $this->assign('info', $info);
            return view();
        }
    }

    public function do_del1(){
        if(request()->isAjax()){
            $id=input('id','','intval');
            $db=input('db');
            $is_del=input('status','0','intval');
            $re=db($db)->where(['id'=>$id])->setField(['is_del'=>$is_del]);
            // var_dump($re);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功！'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败！'));
            }
        }
    }
}