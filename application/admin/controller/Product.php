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
class Product extends Admin
{
    /**
     * 商品列表
     */
    public function product_list(){
        $where=[];
        $title=input('title');
        $btitle=input('btitle');
        $this->assign('btitle',$btitle);
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $title?$where['p.title']=['p.title','like','%'.$title.'%']:'';
        $btitle?$where['p.kind_id']=$btitle:'';
        $begin_time&&!$end_time?$where['p.create_time']=['p.create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['p.create_time']=['p.create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['p.create_time']=['p.create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['p.status']=['p.status','<>',-1];
        $list = db('product')->alias('p')
            ->join('__KIND__ k','p.kind_id = k.id')
            ->field('p.id,p.title,p.create_time,p.status,k.title ktitle')
            ->where($where)
            ->paginate(13,false,['query'=>['title'=>$title,'k.krand_id'=>$btitle,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        $kind = db('kind')->field('id,title')->where('status',1)->select();
        $this->assign('kind',$kind);
        $this->assign('list',$list);
        return view();
    }
    /**    *添加产品     */
    public function product_add(){
       if(request()->isPost()){
           $data['title']=input('title');
           $data['kind_id'] =input('kind_id');
           $data['introduce'] =input('introduce');
           $data['description'] =input('description');
//           $data['img'] =input('image_url');
           $data['img_thumb'] =input('img');
           $data['create_time'] =time();
           $re = db('product')->insert($data);
           if($re){
               return json(['status'=>true,'msg'=>'添加成功']);
           }else{
               return json(['status'=>false,'msg'=>'添加失败']);
           }
       }else {
           $kind = db('kind')->field('id,title')->where('status',1)->select();
           $this->assign('kind',$kind);
           return view();
       }
    }
    /**     *编辑产品     */
    public function product_edit(){
        $id=input('id',0,'intval');
        if(request()->isPost()){
            $data['title'] = input('title');
            $data['img_thumb'] =input('img');
            $data['introduce'] =input('introduce');
            $data['description'] = input('description');
            $re = db('product')->where(['id'=>$id])->update($data);
            if($re!==false){
                return json(['status'=>true,'msg'=>'修改成功！','code'=>200]);
            }else{
                return json(['status'=>false,'msg'=>'修改失败！','code'=>400]);
            }
        }else {
            $info=db('product')
                ->where(['id'=>$id])
                ->find();
            $this->assign('info',$info);
            return view();
        }
    }

    /**
     * 品牌种类
     */
    public function kind(){
        $where=[];
        $title= input('title');
        $title?$where['title']=['title','like','%'.$title.'%']:'';
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $begin_time&&!$end_time?$where['create_time']=['create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['create_time']=['create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['create_time']=['create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['status'] = ['status','>',-1];
        $list = db('kind')
            ->where($where)
            ->paginate(13,false,['query'=>['title'=>$title,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        $page = $list->render();
        $this->assign('page',$page);
        $this->assign('list',$list);
        return $this->fetch();
        return view();
    }
    /**
     * 添加种类
     */
    public function kind_add(){
        if(request()->isPost()) {
            $data['title'] = input('title');
            $data['create_time'] = time();
            $data['image'] = input('img');
            $re = db('kind')->insert($data);
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
     * 编辑种类
     * @Author   MSC
     * @DateTime 201-01-19T18:10:27+0800
     */
    public function kind_edit(){
        $id=input('id');
        if(request()->isPost()){
            $data['title']=input('title');
            $data['image'] = input('img');
            $data['status']=input('status');
            $re=db('kind')->where(array('id'=>$id))->update($data);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('kind')->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            return view();
        }
    }

}