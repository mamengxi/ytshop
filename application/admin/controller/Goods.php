<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/17
 * Time: 11:16
 */
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Request;

/**
 * 商品管理
 */
class Goods extends Admin
{
    /**
     * 商品列表
     */
    public function goods_list(){
        $where=[];
        $title=input('title');
        $btitle=input('btitle');
        $this->assign('btitle',$btitle);
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $title?$where['g.title']=['g.title','like','%'.$title.'%']:'';
        $btitle?$where['g.brand_id']=$btitle:'';
        $begin_time&&!$end_time?$where['g.create_time']=['g.create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['g.create_time']=['g.create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['g.create_time']=['g.create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['g.status']=['g.status','<>',-1];
        $list = db('goods')->alias('g')
            ->join('__GOODS_TYPE__ gt','g.type_id = gt.id')
            ->join('__BRAND__ b','g.brand_id = b.id')
            ->field('g.id,g.title,g.original_price,g.price,g.create_time,g.status,gt.title gtitle,b.title btitle')
            ->where($where)
            ->order('create_time desc')
            ->paginate(13,false,['query'=>['title'=>$title,'b.brand_id'=>$btitle,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        $brand = db('brand')->field('id,title')->where('status',1)->select();
        $this->assign('brand',$brand);
        $this->assign('list',$list);
        return view();
    }
    /**    *添加商品     */
    public function goods_add(){
       if(request()->isPost()){
           $data['title']=input('title');
           $data['type_id'] =input('type_id');
           $data['brand_id'] =input('brand_id');
           $data['description'] =input('description');
           $data['img'] =input('image_url');
           $data['img_thumb'] =input('img');
           $data['original_price'] =formatMoney(input('original_price'));
           $data['expenses'] = input('expenses');
           $data['price'] =formatMoney(input('price'));
           $data['is_quality'] =input('is_quality');
           $data['is_new'] =input('is_new');
           $data['is_hot'] =input('is_hot');
           $data['create_time'] =time();
           $info['brands'] = input('brands');
           $info['model'] = input('model');
           $info['color'] = input('color');
           $info['use_age'] = input('use_age');
           $info['parts'] = input('parts');
           $info['bar_code'] = input('bar_code');
           $info['weight'] = input('weight');
           $info['bearing'] = input('bearing');
           $data['parameter'] = json_encode($info);
           $res = db('goods')->insert($data);
           if($res){
               return json(['status'=>true,'msg'=>'添加成功']);
           }else{
               return json(['status'=>false,'msg'=>'添加失败']);
           }
       }else {
           $brand = db('brand')->field('id,title')->where('status',1)->select();
           $this->assign('brand',$brand);
           $tree = db('goodsType')->field('id,title')->where(['status'=>1])->select();
           $this->assign('tree',$tree);
           return view();
       }
    }
    /**     *编辑商品     */
    public function goods_edit(){
        $id=input('id',0,'intval');
        if(request()->isPost()){
            $data['title'] = input('title');
            $data['price'] = formatMoney(input('price'));
            $data['original_price'] = formatMoney(input('original_price'));
            $data['expenses'] = input('expenses');
            $data['is_quality'] = input('is_quality');
            $data['is_new'] = input('is_new');
            $data['is_hot'] = input('is_hot');
            $data['img'] = input('image_url');
            $data['img_thumb'] =input('img');
            $data['description'] = input('description');
            $info['brands'] = input('brands');
            $info['model'] = input('model');
            $info['color'] = input('color');
            $info['use_age'] = input('use_age');
            $info['parts'] = input('parts');
            $info['bar_code'] = input('bar_code');
            $info['weight'] = input('weight');
            $info['bearing'] = input('bearing');
            $data['parameter'] = json_encode($info);
            $res = db('goods')->where(['id'=>$id])->update($data);
            if($res!==false){
                return ['status'=>true,'msg'=>'修改成功！','code'=>200];
            }else{
                return ['status'=>false,'msg'=>'修改失败！','code'=>400];
            }
        }else {
            $info=db('goods')
                ->where(['id'=>$id])
                ->find();
            $info['imgs']=explode(',',$info['img']);
            $info['parameter'] = json_decode($info['parameter'],true);
            $this->assign('info',$info);
            return view();
        }
    }
    /**     * 商品分类列表     */
    public function type(){
        $list = db('goodsType')->where('status','1')->paginate(10);
        $this->assign('list',$list);
        return view();
    }
    /*** 添加商品分类     */
    public function type_add(){
        if(request()->isPost()) {
            $data['title'] = input('title');
            $data['create_time'] = time();
            $re = db('goodsType')->where('title',$data['title'])->find();
            if ($re){
                return json(array('status' => false, 'info' => '已存在该分类'));
            }else{
                $re = db('goodsType')->insert($data);
                if ($re) {
                    return json(array('status' => true, 'info' => '操作成功'));
                } else {
                    return json(array('status' => false, 'info' => '操作失败'));
                }
            }
        }else{
            return view();
        }
    }
    /**     * 编辑商品分类     */
    public function type_edit(){
        $id=input('id');
        if(request()->isPost()){
            $title=input('title');
            $re = db('goodsType')->where('title',$title)->find();
            if ($re){
                return json(array('status' => false, 'info' => '已存在该分类'));
            }else{
                $res=db('goodsType')->where(array('id'=>$id))->setField('title',$title);
                if($res!==false){
                    return json(array('status'=>true,'info'=>'操作成功'));
                }else{
                    return json(array('status'=>false,'info'=>'操作失败'));
                }
            }
        }else{
            $info=db('goodsType')->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            return view();
        }
    }
    /**     *  商品规格列表     */
    public function attr_list(){
        $list = db('goodsAttribute')
            ->field('id,attr_name')
            ->where('status',1)
            ->paginate(13);
        $this->assign('list',$list);
        return view();
    }
    /**     *  添加商品规格     */
    public function attr_add(){
        if(request()->isPost()){
            $data['attr_name'] = input('name','','trim');
            $re = db('goodsAttribute')->where('attr_name',$data['attr_name'])->find();
            if ($re){
                return json(['status'=>false,'info'=>'已存在该规格']);
            }else{
                $res = db('goodsAttribute')->insert($data);
                if($res){
                    return json(['status'=>true,'info'=>'添加成功']);
                }else{
                    return json(['status'=>false,'info'=>'添加失败']);
                }
            }
        }else{
            return view();
        }
    }
    /**     * 编辑商品规格     */
    public function attr_edit(){
        $id = input('id');
        if(request()->isPost())
        {
            $data['attr_name'] = input('name','','trim');
            $res = db('goodsAttribute')->where('id',$id)->update($data);
            if($res){
                return json(['status'=>true,'info'=>'更新成功']);
            }else{
                return json(['status'=>false,'info'=>'更新失败']);
            }
        }else{
            $list = db('goodsAttribute')->field('id,attr_name')->where('id',$id)->find();
            if(!$list){
                return $this->error('数据有误');
            }
            $this->assign('info',$list);
            $this->assign('type',$this->getGoodsType());
            return view();
        }
    }
    /**     * 商品属性列表     */
    public function attr_value(){
        $where=[];
        $where['g.status']=1;
        $title= input('title');
        $value =input('value');
        $title?$where['ga.attr_name']=$title:'';
        $value?$where['g.attr_name']=$value:'';
        $list = db('goodsAttr')->alias('g')
            ->join('__GOODS_ATTRIBUTE__ ga','g.attr_id = ga.id')
            ->field('g.good_attr_id gaid,g.attr_name gname,ga.attr_name ganame')
            ->where($where)->paginate(13,false,['query'=>['title'=>$title,'value'=>$value]]);
        $this->assign('list',$list);
        return view();
    }
    /** 添加商品属性  */
    public function attr_value_add(){
        if(request()->isPost()){
            $attr_id=input('attrid');
            $attr_name=input('name');
            $arr = explode(',',$attr_name);
            $arr=array_unique($arr);
            foreach ($arr as $k=>$v){
                $data[$k]['attr_id'] = $attr_id;
                $data[$k]['attr_name'] = $v;
            }
            $re=db('goodsAttr')->insertAll($data);
            if($re){
                return json(['status'=>true,'info'=>'操作成功']);
            }else{
                return json(['status'=>false,'info'=>'操作失败']);
            }
        }else{
            $attribute  =$this->getAttribute();
            $this->assign('attr',$attribute);
            return view();
        }
    }
    /** 编辑商品属性  */
    public function attr_value_edit(){
        $id=input('id');
        if(request()->isPost()){
            $data['attr_name']=input('name');
            $re=db('goods_attr')->where(array('good_attr_id'=>$id))->update($data);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('goods_attr')
                ->alias('g')
                ->join('__GOODS_ATTRIBUTE__ ga','g.attr_id = ga.id')
                ->field('g.good_attr_id gaid,g.attr_name gname,ga.attr_name ganame')
                ->where('good_attr_id',$id)->find();
            $this->assign('info',$info);
            return view();
        }
    }
    /**     *单品列表     */
    public function item(){
        $id= input('location_id','','intval');
        if(!$id) return $this->error('非法操作');
        $data = db('goodsItem')->field('id,attr_id,status,price,stock')->where(['is_delete'=>1,'gid'=>$id])->paginate(10);
        //以下两种方法任选
        $list = $data->toArray()['data'];
//        $list = $data->all();
        $attrIds = '';
        foreach ($list as $k=>$v)
        {
            $attrIds.=','.$v['attr_id'];
            $list[$k]['attr_id']=explode(',',trim($v['attr_id']));
        }
        $page = $data->render();
        $this->assign('page',$page);
        $attrIds = substr($attrIds,1);
        $idsArr = array_unique(explode(',',$attrIds)); //得到去重后的所有id
        $strIds = implode(',',$idsArr);
        $itemName = db('goodsAttr')->where('good_attr_id','in',$strIds)->column('attr_name','good_attr_id');
        $this->assign('list',$list);
        $this->assign('item',$itemName);
        $this->assign('gid',$id);
        return view();
    }
    /**     *添加单品     */
    public function item_add(){
        $gid=input('gid','','intval');
        if(request()->isPost()){
            $request = \think\facade\Request::param();
            $data['attr_id'] = implode(',',$request['name']);
            $item = db('goodsAttr')->where('good_attr_id','in',$data['attr_id'])->column('attr_name');
            $data['attr_name'] = implode('/',$item);
            $data['gid']=$request['gid'];
            $data['price']=formatMoney($request['price']);
            $data['stock']=$request['stock'];
            $data['create_time']=time();
//            $re = db('goodsItem')->where('attr_name',$data['attr_name'])->find();
//            if ($re){
//                return json(['status'=>false,'info'=>'已存在该属性']);
//            }else{
                $res = db('goodsItem')->insert($data);
                if($res){
                    return json(['status'=>true,'info'=>'添加成功']);
                }else{
                    return json(['status'=>false,'info'=>'添加失败']);
                }
//            }
        }else{
            $attribute = db('goodsAttribute')->where('status',1)->field('id,attr_name')->select();
            if(count($attribute)>0)
            {
                foreach ($attribute as $k=>$v){
                    $attribute[$k]['attr_value'] = db('goodsAttr')->where('attr_id',$v['id'])->where('status',1)->field('good_attr_id,attr_name')->select();
                }
            }else{
            }
            $this->assign('attr',$attribute);
        }
        $this->assign('gid',$gid);
        return view();
    }
    /**     * 编辑单品     */
    public function item_edit(){
        $id = input('id','',intval);
        if(request()->isPost()){
            $request = \think\facade\Request::param();
            $data['attr_id'] = implode(',',$request['name']);
            $item = db('goodsAttr')->where('good_attr_id','in',$data['attr_id'])->column('attr_name');
            $data['attr_name'] = implode('/',$item);
            $data['price']=formatMoney($request['price']);
            $data['stock']=$request['stock'];
            $data['create_time']=time();
            $res = db('goodsItem')->where('id',$id)->update($data);
            if($res){
                return json(['status'=>true,'info'=>'修改成功']);
            }else{
                return json(['status'=>true,'info'=>'修改失败']);
            }
        }else{
            $list=db('goodsItem')->field('id,attr_id,price,stock')->find($id);
            $list['attr_id'] =explode(',',$list['attr_id']);
            $attribute = db('goodsAttribute')->where('status',1)->field('id,attr_name')->select();
            if(count($attribute)>0)
            {
                foreach ($attribute as $k=>$v){
                    $attribute[$k]['attr_value'] = db('goodsAttr')->where('attr_id',$v['id'])->field('good_attr_id,attr_name')->select();
                }
            }else{
            }
            $this->assign('info',$list);
            $this->assign('attr',$attribute);
        }
        return view();
    }




    /**
     * 评论列表
     */
    public function comments(){
        $title=input('title');
        $nickname=input('nickname');
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $title?$where['g.title']=['g.title','like','%'.$title.'%']:'';
        $nickname?$where['u.nickname']=['u.nickname','like','%'.$nickname.'%']:'';
        $begin_time&&!$end_time?$where['c.time']=['c.time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['c.time']=['c.time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['c.time']=['c.time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['c.status']= 1;
        $list = db('comments')->field('c.id,g.title,c.time,c.content,c.status,u.nickname')->alias('c')->join('__GOODS__ g','g.id=c.gid')->join('__USER__ u','u.id=c.uid')->where($where)->order('c.time desc')->paginate(13,false,['query'=>['title'=>$title,'nickname'=>$nickname,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        // 把分页数据赋值给模板变量list
        $page = $list->render();
        $this->assign('page', $page);
        $this->assign('list', $list);
        // var_dump($list);
        return $this->fetch();
        return view();
    }
    /**
     * 评论列表
     */
    public function comments_detail(){
        $id=input('id',0,'intval');
        $where['c.id']=$id;
        $where['c.status']=['c.status','>',-1];
        $info = db('comments')->field('c.id,g.title,c.time,c.content,c.image,c.status,u.nickname')->alias('c')->join('__GOODS__ g','g.id=c.gid')->join('__USER__ u','u.id=c.uid')->where($where)->find();
        // 把分页数据赋值给模板变量list
//        var_dump($info);exit;
        $info['images']=explode(',',$info['image']);
        $this->assign('info', $info);
        // var_dump($list);
        return view();
    }


    /**
     * 商品回收列表
     */
    public function recycle(){
        $where=[];
        $title=input('title');
        $btitle=input('btitle');
        $this->assign('btitle',$btitle);
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $title?$where['g.title']=['g.title','like','%'.$title.'%']:'';
        $btitle?$where['g.brand_id']=$btitle:'';
        $begin_time&&!$end_time?$where['g.create_time']=['g.create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['g.create_time']=['g.create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['g.create_time']=['g.create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['g.status'] = -1;
        $list = db('goods')->alias('g')
            ->join('__GOODS_TYPE__ gt','g.type_id = gt.id')
            ->join('__BRAND__ b','g.brand_id =b.id')
            ->field('g.id,g.title,g.original_price,g.price,g.create_time,gt.title gtitle,b.title btitle')
            ->where($where)
            ->order('g.create_time desc')
            ->paginate(13,false,['query'=>['title'=>$title,'b.brand_id'=>$btitle,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        $brand = db('brand')->field('id,title')->where('status',1)->select();
        $this->assign('brand',$brand);
        $this->assign('list',$list);
        return view();
    }
    /**
     * 品牌列表
     */
    public function brand(){
        $where=[];
        $title= input('title');
        $title?$where['title']=['title','like','%'.$title.'%']:'';
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $begin_time&&!$end_time?$where['create_time']=['create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['create_time']=['create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['create_time']=['create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['status'] = ['status','>',-1];
        $list = db('brand')
            ->where($where)
            ->paginate(13,false,['query'=>['title'=>$title,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        $page = $list->render();
        $this->assign('page',$page);
        $this->assign('list',$list);
        return $this->fetch();
        return view();
    }
    /**
     * 添加品牌
     */
    public function brand_add(){
        if(request()->isPost()) {
            $data['title'] = input('title');
            $data['create_time'] = time();

            $re = db('brand')->insert($data);
            if ($re) {
                return json(array('status' => true, 'info' => '操作成功'));
            } else {
                return json(array('status' => false, 'info' => '操作失败'));
            }
        }else{
            return view();
        }
    }
    /**
     * 编辑分类
     * @Author   MSC
     * @DateTime 201-01-19T18:10:27+0800
     */
    public function brand_edit(){
        $id=input('id');
        if(request()->isPost()){
            $data['title']=input('title');
//            $data['id']=input('id');
            $data['status']=input('status');
//            $data['sort']=input('sort');
//            var_dump($data);exit;
            $re=db('brand')->where(array('id'=>$id))->update($data);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('brand')->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            return view();
        }
    }


    /**
     * 订单评论列表
     */
    public function order_comments(){
        $order_sn=input('order_sn');
        $nickname=input('nickname');
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $order_sn?$where['o.order_sn']=['o.order_sn','like','%'.$order_sn.'%']:'';
        $nickname?$where['u.nickname']=['u.nickname','like','%'.$nickname.'%']:'';
        $begin_time&&!$end_time?$where['c.create_time']=['c.create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['c.create_time']=['c.create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['c.create_time']=['c.create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['c.status']=['c.status','=',1];
        $list = db('order_comments')
            ->field('c.*,u.nickname,o.order_sn')
            ->alias('c')
            ->join('__ORDERS__ o','c.order_id=o.order_id')
            ->join('__GOODS__ g','g.id=c.gid')
            ->join('__USER__ u','u.id=c.uid')
            ->where($where)
            ->order('c.create_time desc')
            ->paginate(13,false,['query'=>['order_sn'=>$order_sn,'nickname'=>$nickname,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        // 把分页数据赋值给模板变量list
        $page = $list->render();
        $this->assign('page',$page);
        $this->assign('list', $list);
        // var_dump($list);
        return $this->fetch();
        return view();
    }
    /**
     * 评论列表
     */
    public function order_comments_detail(){
        $id=input('id',0,'intval');
        $where['c.id']=$id;
        $where['c.status']=['c.status','=',1];
        $info = db('order_comments')
            ->field('c.*,u.nickname,o.order_sn')
            ->alias('c')
            ->join('__ORDERS__ o','c.order_id=o.order_id')
            ->join('__USER__ u','u.id=c.uid')
            ->where($where)
            ->order('c.create_time desc')
            ->find();
        // 把分页数据赋值给模板变量list
//        var_dump($info);exit;
        $this->assign('info', $info);
        // var_dump($list);
        return view();
    }



    public function getGoodsType()
    {
        $list = db('goodsType')->field('id,title')->where('status',1)->select();
        return $list;
    }

    /***  获取规格  ***/
    public function getAttribute()
    {
        $list = db('goodsAttribute')->where('status',1)->select();
        return $list;
    }

    /**
     * 节点列表获取所有节点
     * @return   [type]                   [description]
     */
    public function getTree($pid=0,$html="|-----",$level=5){
        $list=db('goods_class')->where(['status'=>1])->select();
        $list=getSort($list,$pid,$html,$level);
        return $list;
    }

    public function test()
    {
        $mon="19999999.195sss999sssss";
        $price = number_format($mon, 2, '.', '');
        echo $price;

        $arr = Array(['tid' =>'1','attr_id' =>'2,9', 'status' =>1,'price'=> 66600]);
        $arr[0]['sss']="sss";
        print_r($arr);
    }

}