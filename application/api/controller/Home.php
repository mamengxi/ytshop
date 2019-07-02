<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/23 16:54
 */
namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

class Home extends Api
{
    public function index()
    {
        $ad = $this->getHomeAd();
//        $hot_goods = $this->hotGoods();
//        $new_goods = $this->newGoods();
//        $suggest_goods = $this->suggestGoods();
//        return ['code'=>200,'msg'=>'success','data'=>['ad'=>$ad,'hot_goods'=>$hot_goods,'new_goods'=>$new_goods,'suggest'=>$suggest_goods,'sell'=>false]];
        $goods_new = $this->Goods_new();
        $goods_a = $this->Goods_a();
        $goods_b = $this->Goods_b();
        return ['code'=>200,'msg'=>'success','data'=>['ad'=>$ad,'goods_new'=>$goods_new,'goods_a'=>$goods_a,'goods_b'=>$goods_b,'sell'=>false]];
    }

    public function search()
    {
        $sq = input('q','iphone','trim');
        if(!$sq) return $this->errorJson(400,'NULL');
        $data = db('goods')->field('id,title,original_price,price,img_thumb')->whereLike('title',"%$sq%")->where('status',1)->select();
        if($data){
            foreach ($data as $k=>$v){
                $data[$k]['original_price']= unFormatMoney($v['original_price']);
                $data[$k]['price']= unFormatMoney($v['price']);
            }
        }
        return ['code'=>200,'data'=>$data];
    }
    /**
     * @return  首页banner 广告
     */
    public function getHomeAd()
    {
        $data = db('ad')->where(['location_id'=>1,'status'=>1])->field('ad_name,img_src,url')->order(['sort','add_time'=>'desc'])->select();
        return $data;
    }

    /**
     * @return bool 热卖商品
     */
    public function hotGoods()
    {
        $goods = db('goods')->field('id,img')->where(['is_hot'=>1,'status'=>1])->order('create_time desc')->limit(0,2)->select();
        if($goods){
            foreach ($goods as $k=>$v){
                $images = explode(',',$v['img']);
                $goods[$k]['img'] =$images[0];
            }
            return $goods;
        }else{
            return false;
        }
    }

    public function newGoods()
    {
        $goods =db('goods')
            ->field('id,title,img_thumb,original_price,price')->where(['status'=>1,'is_new'=>1])
            ->order('create_time desc')->limit(0,3)->select();
        if($goods){
            foreach ($goods as $k=>$v){
                $goods[$k]['original_price'] = unFormatMoney($v['original_price']);
                $goods[$k]['price'] = unFormatMoney($v['price']);
            }
            return $goods;
        }else{
            return false;
        }
    }
    /*
     *   商品推荐
     */
    public function suggestGoods()
    {
        $goods =db('goods')
            ->field('id,title,img_thumb,original_price,price')->where(['status'=>1,'is_quality'=>1])
            ->order('create_time desc')->limit(0,6)->select();
        if($goods){
            foreach ($goods as $k=>$v){
                $goods[$k]['original_price'] = unFormatMoney($v['original_price']);
                $goods[$k]['price'] = unFormatMoney($v['price']);
            }
            return $goods;
        }else{
            return false;
        }
    }

    public function Goods_new()
    {
        $goods =db('goods')
            ->field('id,title,img_thumb,original_price,price')
            ->where(['status'=>1,'type_id'=>5])
            ->order('create_time desc')->limit(0,3)->select();
        if($goods){
            foreach ($goods as $k=>$v){
                $goods[$k]['original_price'] = unFormatMoney($v['original_price']);
                $goods[$k]['price'] = unFormatMoney($v['price']);
            }
            return $goods;
        }else{
            return false;
        }
    }

    public function Goods_a()
    {
        $goods =db('goods')
            ->field('id,title,img_thumb,original_price,price')
            ->where(['status'=>1,'type_id'=>6])
            ->order('create_time desc')->limit(0,3)->select();
        if($goods){
            foreach ($goods as $k=>$v){
                $goods[$k]['original_price'] = unFormatMoney($v['original_price']);
                $goods[$k]['price'] = unFormatMoney($v['price']);
            }
            return $goods;
        }else{
            return false;
        }
    }

    public function Goods_b()
    {
        $goods =db('goods')
            ->field('id,title,img_thumb,original_price,price')
            ->where(['status'=>1,'type_id'=>7])
            ->order('create_time desc')->limit(0,3)->select();
        if($goods){
            foreach ($goods as $k=>$v){
                $goods[$k]['original_price'] = unFormatMoney($v['original_price']);
                $goods[$k]['price'] = unFormatMoney($v['price']);
            }
            return $goods;
        }else{
            return false;
        }
    }

    public function wxNotify()
    {
        $data = file_get_contents("php://input");
        log_result($data,'wxNotifyResultXML');
        if(!$data) return false;
        $dataArr = xml2array($data);
        $data = \WxPayApi::wxOrderQuery($dataArr);  //查询订单是否成功
        if(!$data) return false;
        if($dataArr['return_code'] =='SUCCESS'){
            //支付成功
            Db::startTrans();
            try{
                $orderId = db('orders')->where('order_sn',$dataArr['out_trade_no'])->value('order_id');
                //1、更新订单表
                db('orders')->where('order_id',$orderId)->update(['pay_status'=>1,'pay_time'=>time(),'order_status'=>3,'pay_price'=>$dataArr['total_fee']]);
                //2、商品销量增加
                $goods = db('orderGoods')->where('order_id',$orderId)->column('goods_num','goods_id');
                foreach ($goods as $k=>$v){
                    db('goods')->where('id',$k)->setInc('count',$v);
                }
                // orders_action
                $orderAction['order_id']=$orderId;
                $orderAction['log_time']=time();
                $orderAction['status_desc']='付款成功';
                $orderAction['action_note']='订单付款成功';
                $orderAction['pay_status']=1;
                db('orderAction')->insert($orderAction);
                Db::commit();
                return $this->return_success();
            }catch (\Exception $e){
                Db::rollback();
                return false;
            }
        }

    }

    protected function return_success(){
        $return['return_code'] = 'SUCCESS';
        $return['return_msg'] = 'OK';
        $xml_post = '<xml>
                    <return_code>'.$return['return_code'].'</return_code>
                    <return_msg>'.$return['return_msg'].'</return_msg>
                    </xml>';
        echo $xml_post;exit;
    }

    public function test()
    {
        exit;
//        $id = '3,9';
//        $item = db('goodsAttr')->where('good_attr_id','in',$id)->column('attr_name');
//        $itemName = implode('/',$item);
//        echo $itemName;
//        print_r($item);
//        exit;

        $order = 888291984489227487;
//        $res = \Kdniao::getSingleOrderTracesByJson($order);
        $res = \Kdniao::getOrderTracesByJson('YTO',$order);
        echo print_r($res); exit;
        $array = array(
            '0'=>[
                'ShipperCode'=>'YTO',
                'ShipperName'=>'圆通速递'
            ]
        );
        if($array){
            foreach ($array as $v){
                $res = \Kdniao::getOrderTracesByJson($v['ShipperCode'],$order);
                print_r($res);
            }
        }
//        print_r($array);
    }
}