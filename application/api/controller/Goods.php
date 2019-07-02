<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/30 10:59
 */
namespace app\api\controller;

use app\common\controller\Api;

class Goods extends Api
{
    /*
     * 根据id 返回详情
     * @return \think\response\Json
     */
    public function show()
    {
        $shopid = input('id','','intval');
        $token = input('token');
        if($token){
            $this->checkToken();
        }
        $
        $collect = false;
        if($this->uid){//查询是否收藏
            $collect = db('collect')->where(['uid'=>$this->uid,'status'=>1,'gid'=>$shopid])->find();
            $collect = $collect?true:false;
        }

        $shopinfo = db('goods')->field('id,type_id,title,description,price,original_price,count,img,img_thumb,parameter,status,expenses')->where(['id'=>$shopid])->find();
        if($shopinfo){
            $shopinfo['is_exist'] = 1;
        }else{
            $shopinfo['is_exist'] = 2;
        }
//        $imglist = db('goodImage')->where('good_id',$shopid)->select();
        $shopinfo['imglist']= explode(',',$shopinfo['img']);
        $shopinfo['price'] = unFormatMoney($shopinfo['price']);
        $shopinfo['original_price'] = unFormatMoney($shopinfo['original_price']);
        $shopinfo['collect'] = $collect;  //收藏
        $shopinfo['description'] =preg_replace('/<img.+?src=[\'|"](.+?)[\'|"].*?>/','<img style="max-width:100%" src="http://'.$_SERVER['HTTP_HOST'].'\1">',$shopinfo['description']);
        $shopinfo['parameter'] = json_decode($shopinfo['parameter']);
//        $lease_a = $this->price_replace($shopinfo['type_id'],$shopinfo['expenses'],$shopinfo['price']);
//        $shopinfo['re']=$lease_a;
        return json(['code'=>200,'data'=>$shopinfo]);
    }
    /*
     *  获取分类列表
     */
    public function catlist()
    {
        $list = db('goodsType')->field('id,title')->where('status',1)->order('create_time asc')->select();
        return json(['code'=>200,'data'=>$list]);
    }
    /*
     *   根据分类id 获取分类下的商品
     */
    public function catshops()
    {
        $catid = input('cid','','intval');
        $list = db('goods')->field('id,title,price,original_price,img_thumb img')->where(['type_id'=>$catid,'status'=>1])->order('create_time desc')->select();
        foreach ($list as $k => $v){
            $list[$k]['original_price'] = unFormatMoney($v['original_price']);
            $list[$k]['price'] = unFormatMoney($v['price']);
        }

        return json(['code'=>200,'data'=>$list]);
    }

    // 获取商品属性
    public function getShopAttribute()
    {
        $id= input('id','','intval');
        if(!$id) return json(['code'=>402,'msg'=>'缺少参数']);
        $item = db('goodsItem')->field('id itemid,attr_id,gid,price,stock')->where(['gid'=>$id,'status'=>1])->where('is_delete',1)->select();
        if($item){
            foreach ($item as $k=>$v){
                $itemName=db('goodsAttr')->where('good_attr_id','in',$v['attr_id'])->select();
                $name= '';
                foreach ($itemName as $val)
                {
                    if($name ==''){
                        $name=$val['attr_name'];
                    }else{
                        $name .='/'.$val['attr_name'];
                    }
                }
                $item[$k]['stock'] = $v['stock'];
                $item[$k]['item_name']= $name;
                $item[$k]['price']= unFormatMoney($v['price']);
                if($item[$k]['stock']<=0){
                    $item[$k]['iscan_buy'] = '立即预订';
                }else{
                    $item[$k]['iscan_buy'] = '立即租赁';
                }
            }
            return json(['code'=>200,'data'=>$item]);
        }else{
            return $this->errorJson(400,'暂无数据');
        }
    }
    //商品评价
    public function comments()
    {
        $id= input('id','','intval');
        $page=input('page',1);
        $limit = 10;
        if(!$id) return json(['code'=>402,'msg'=>'缺少参数']);
        $list = db('comments')->alias('c')
            ->join('__USER__ u','c.uid=u.id')
            ->field('c.content,c.image,c.time,u.head_img,u.nickname')
            ->order('time desc')
            ->where(['c.gid'=>$id,'c.status'=>1])->page($page)->limit($limit)->select();
        $count=db('comments')->alias('c')
            ->join('__USER__ u','c.uid=u.id')
            ->field('c.content,c.image,c.time,u.head_img,u.nickname')
            ->order('time desc')
            ->where(['c.gid'=>$id,'c.status'=>1])->count();
        $total_page=ceil($count/$limit);
        if($list){
            foreach ($list as $k=>$v){
                $list[$k]['time'] =formatTimestamp($v['time']);
                $list[$k]['image'] =$list[$k]['image']?explode(',',$v['image']):'';
                $list[$k]['head_img'] = $v['head_img']?$v['head_img']:'/static/default_head_image.png';
            }
            return json(['code'=>200,'data'=>$list,'commentCount'=>$count,'total_page'=>$total_page]);
        }else{
            return json(['code'=>400,'msg'=>'暂无数据']);
        }
    }
}