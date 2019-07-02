<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/2/5 17:25
 */
namespace app\api\controller;

use app\common\controller\Api;

class Cart extends Api
{
    public function initialize()
    {
        parent::initialize();
        $this->checkToken();
    }

    public function index()
    {
        $list = db('cart')->alias('c')
              ->join('__GOODS__ g','c.gid=g.id')
              ->join('__GOODS_ITEM__ gi','c.item_id=gi.id')
            ->field('c.*,g.title,g.img_thumb,gi.id item_id,gi.attr_name,gi.price,g.type_id')
            ->where(['c.uid'=>$this->uid,'c.delete'=>0])
            ->select();
        if($list){
            foreach ($list as $k => $v) {
                $list[$k]['check']=false;
                $list[$k]['edit']=false;
                $list[$k]['price'] = unFormatMoney($v['price']);
                $list[$k]['type_id'] = $v['type_id'];
            }
        }   
        return json(['code'=>200,'data'=>$list]);
    }

    public function addCart()
    {
        $gid = input('id','','intval');
        $item_id = input('item_id');
        $num = input('num');
        if(!$gid||!$item_id||!$num) return $this->errorJson(400,'缺少参数');
        $info =db('cart')->where(['uid'=>$this->uid,'gid'=>$gid,'item_id'=>$item_id,'buytype'=>input('buytype')])->find();
        if($info){
            $res = db('cart')->where('id',$info['id'])->setInc('num');
        }else{
            $res =db('cart')->insert(['uid'=>$this->uid,'gid'=>$gid,'create_time'=>time(),'item_id'=>$item_id,'num'=>$num,'buytype'=>input('buytype')]);
        }
        if($res){
            return $this->errorJson(200,'添加成功');
        }else{
            return $this->errorJson(400,'添加失败');
        }
    }

    public function delCart()
    {
        $ids = input('id');
        if(!$ids) return $this->errorJson(400,'缺少参数');
        $info = db('cart')->where('id','in',$ids)->select();
        if($info){
            $res = db('cart')->where('id','in',$ids)->delete();
        }
        return $this->trueOrFalse($res,'删除成功','删除失败');
    }

    public function editCart()
    {
        $id = input('id','','intval');
        $item_id = input('item_id');
        $num = input('num');
        if(!$id||!$item_id||!$num) return $this->errorJson(400,'缺少参数');
        $res = db('cart')->where('id',$id)->update(['item_id'=>$item_id,'num'=>$num]);
        if($res !==false){
            return $this->errorJson(200,'修改成功');
        }else{
            return $this->errorJson(400,'修改失败');
        }
    }
}