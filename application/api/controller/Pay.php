<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/2/27 15:58
 */

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

class Pay extends Api
{
    public function initialize()
    {
        parent::initialize();
        $this->checkToken();
    }

    public function continuePay()
    {
        $order_id = input('id','','intval');
        if(!$order_id) return $this->errorJson(400,'缺少参数');
        $orderInfo =db('orders')->field('order_id,order_sn,total_price')->where(['order_id'=>$order_id,'deleted'=>0,'uid'=>$this->uid])->find();
        if(!$orderInfo) return $this->errorJson(400,'非法操作');
        $order_sn= makeOrdel('YT');
        $res = db('orders')->where('order_id',$order_id)->setField(['order_sn'=>$order_sn,'create_time'=>time()]);
        if($res){
            $data =[
                'body'=>'商品购买',
                'out_trade_no'=>$order_sn,
                'total_fee'=>$orderInfo['total_price'],
                'notify_url'=>$_SERVER['HTTP_HOST']."/api/Home/wxNotify",
                'openid'=>$this->geOpenId()
            ];
            $result = \WxPayApi::wxUnifiedorder($data);
            if($result['status'])
            {
                return json(['code'=>200,'data'=>$result]);
            }else{
                return $this->errorJson(400,'错误');
            }
        }else{
            return $this->errorJson(400,'系统错误');
        }
    }
    public function unifiedorder()
    {
        $items = $_POST;
        $act = input('act',0,'intval');
        $addid = input('address_id');
        $address= db('address')->field('phone,province,city,area,detail,username')->where('id',$addid)->find();
        $order = $orderGoods= array();
        $totalMoney=0;
        if(count($items['id'])<1){
            return $this->errorJson(400,'未知错误');
        }
//        var_dump($items['id'][0]);exit;
        $type_id = db('goods')->where('id', $items['id'][0])->value('type_id');
        /* 开始记录 **/
        Db::startTrans();
        try{
            // 1、生成order信息
            $order['order_sn']= makeOrdel('YT');
            $order['uid']= $this->uid;
            $order['consignee']= $address['username'];
            $order['address']= $address['province'].$address['city'].$address['area'].$address['detail'];
            $order['mobile']= $address['phone'];
            $order['create_time']= time();
            $order['type_id']= $type_id;
            $order['is_lease'] = input('type',1,'intval');
//            $order['total_price']=$totalMoney;
            $orderId = db('orders')->insertGetId($order);

            //2、生成order_goods信息
            foreach ($items['id'] as $k=>$v)
            {
                $tmpGoods = db('goods')->field('id,title,img_thumb,expenses')->where('id',$v)->find();
                $tmpItem = db('goodsItem')->field('id,attr_id,price,attr_name,stock')->where('id',$items['itemid'][$k])->find();
                if($act==1){ //如果是购物车提交 则删除购物车信息
                    db('cart')->where(['uid'=>$this->uid,'item_id'=>$items['itemid'][$k]])->delete();
                }
                $orderGoods[$k]['goods_id'] =$v;
                $orderGoods[$k]['order_id'] =$orderId;
                $orderGoods[$k]['goods_name']=$tmpGoods['title'];
                $orderGoods[$k]['goods_img']=$tmpGoods['img_thumb'];
                $orderGoods[$k]['expenses'] = $tmpGoods['expenses'];
                $orderGoods[$k]['goods_price']=$tmpItem['price'];
                $orderGoods[$k]['spec_key']=$tmpItem['attr_id'];
                $orderGoods[$k]['spec_key_name']=$tmpItem['attr_name'];
                $orderGoods[$k]['goods_num'] = $items['num'][$k];
                $stocks = $orderGoods[$k]['goods_num'];
                $totalMoney += $orderGoods[$k]['goods_price']*$orderGoods[$k]['goods_num'];
            }
            db('orderGoods')->insertAll($orderGoods);

            db('orders')->where('order_id',$orderId)->setField('total_price',$totalMoney);
            //3、写入 order_action

            $orderAction['order_id']=$orderId;
            $orderAction['log_time']=time();
            $orderAction['status_desc']='提交订单';
            $orderAction['action_note']='您提交了订单，请等待系统确认';
            db('orderAction')->insert($orderAction);

            //4、单品库存减去相应数量
            $stock = $tmpItem['stock'] - $stocks;
            db('goodsItem')->where('id',$tmpItem['id'])->setField('stock',$stock);

            Db::commit();
            $data =[
                'body'=>'购买BTC',
                'out_trade_no'=>$order['order_sn'],
                'total_fee'=>$totalMoney,
//                'total_fee'=>1,
                'notify_url'=>$_SERVER['HTTP_HOST']."/api/Home/wxNotify",
                'openid'=>$this->geOpenId()
            ];
            $result = \WxPayApi::wxUnifiedorder($data);
            $result['order_id'] = $orderId;
            if($result['status'])
            {
                return json(['code'=>200,'data'=>$result]);
            }else{
                return $this->errorJson(400,'错误');
            }


        }catch (\Exception $e){
            Db::rollback();
            return $this->errorJson(400,'提交失败');
        }
    }
}