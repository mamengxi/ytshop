<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/3/5 16:32
 */
namespace app\common\model;

use think\Model;

class Order extends Model
{

    public function get_order_goods($order_id)
    {
        $list = db('orderGoods')->field('goods_name,goods_id gid,goods_img,goods_price,goods_num,spec_key_name,expenses')->where('order_id',$order_id)->select();
        if($list){
            foreach ($list as $k=>$v){
                $list[$k]['goods_price']=$v['goods_price']/100;
            }
        }
        return $list;
    }

    public function getOrderNum($order_id)
    {
        $info = self::get_order_goods($order_id);
        if($info){
            $num=0;
            foreach ($info as $v) {
                $num+=$v['goods_num'];
            }
            return $num;
        }else{
            return 0;
        }
    }
}