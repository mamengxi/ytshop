<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/15
 * Time: 10:30
 */
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Db;
use think\Request;
/**
 * 内容管理
 */
class Content extends Admin
{
    /**
     * 文章列表
     */
    public function index(){
        $title=input('title');
        $detail=input('detail');
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $title?$where['p.title']=['like','%'.$title.'%']:'';
        $detail?$where['p.detail']=['like','%'.$detail.'%']:'';
        $begin_time&&!$end_time?$where['p.create_time']=['GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['p.create_time']=['LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['p.create_time']=['BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['p.status']=['>',-1];
        $where['p.type']=1;
        $list = db('post')->field('p.id,p.title,p.create_time,p.sort,p.status,c.name')->alias('p')->join('category c','p.category_id=c.id')->where($where)->order('p.create_time desc')->paginate(10,false,['query'=>['title'=>$title,'detail'=>$detail,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        // 把分页数据赋值给模板变量list
//        $page = $list->render();
//        $this->assign('page',$page);
        $this->assign('list', $list);
//         var_dump($page);exit;
        return $this->fetch();
        return view();
    }

    /**
     * 内容发布
     * @Author   jiayangyang
     * @DateTime 2017-03-22T15:03:57+0800
     * @return   [type]                   [description]
     */
    public function release(){
        if(request()->isPost()){
            // var_dump($_POST);exit;
            $re=model('post')->addPost();
            if($re){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $category=db('category')->where(['status'=>1,'pid'=>1])->order('sort desc')->select();
            $this->assign('category',$category);
            return view();
        }

    }

    /**
     * 内容编辑
     * @Author   jiayangyang
     * @DateTime 2017-03-22T15:03:57+0800
     * @return   [type]                   [description]
     */
    public function release_edit(){
        $id=input('id');
        if(request()->isPost()){
            $re=model('post')->editPost();
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=model('post')->postInfo($id);
            $this->assign('info',$info);
            $category=db('category')->where(['status'=>1,'pid'=>1])->order('sort desc')->select();
            $this->assign('category',$category);
            return view();
        }

    }

    /**
     * 栏目管理
     * @Author   jiayangyang
     * @DateTime 2017-04-10T17:29:42+0800
     * @return   [type]                   [description]
     */
    public function category(){
        $list=model('category')->getTree($pid=0,$html="|---",$level=2);
        $this->assign('list',$list);
        return view();
    }
    /**
     * 添加栏目
     * @Author   jiayangyang
     * @DateTime 2017-04-10T17:29:54+0800
     * @return   [type]                   [description]
     */
    public function category_add(){
        if(request()->isPost()){
            $re=model('category')->categoryAdd();
            if($re){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $list=model('category')->getTree($pid=0,$html="|---",$level=1);
            $this->assign('list',$list);
            return view();
        }
    }
    /**
     * 编辑栏目
     * @Author   jiayangyang
     * @DateTime 2017-04-10T17:30:04+0800
     * @return   [type]                   [description]
     */
    public function category_edit(){
        if(request()->isPost()){
            $re=model('category')->categoryAdd();
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $list=model('category')->getTree($pid=0,$html="|---",$level=1);
            $this->assign('list',$list);

            $id=input('id');
            $info=db('category')->where(['id'=>$id])->find();
            $this->assign('info',$info);
            return view();
        }
    }

    /**
     * 问题列表
     */
    public function problem(){
        $title=input('title');
        $detail=input('detail');
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $title?$where['title']=['title','like','%'.$title.'%']:'';
        $detail?$where['detail']=['detail','like','%'.$detail.'%']:'';
        $begin_time&&!$end_time?$where['create_time']=['create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['create_time']=['create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['create_time']=['create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['status']=['status','>',-1];
        $where['type']=2;
        $list = db('post')->where($where)->order('create_time desc')->paginate(13,false,['query'=>['title'=>$title,'detail'=>$detail,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        return view();
    }

    /**
     * 问题发布
     * @Author   jiayangyang
     * @DateTime 2017-03-22T15:03:57+0800
     * @return   [type]                   [description]
     */
    public function problem_add(){
        if(request()->isPost()){
            $re=model('post')->addPost();
            if($re){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            return view();
        }

    }

    /**
     * 问题编辑
     * @Author   jiayangyang
     * @DateTime 2017-03-22T15:03:57+0800
     * @return   [type]                   [description]
     */
    public function problem_edit(){
        $id=input('id');
        if(request()->isPost()){
            $re=model('post')->editPost();
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('post')->where(['id'=>$id])->find();
            // var_dump($info);
            $this->assign('info',$info);
            return view();
        }

    }


    /**
     * 消息列表
     */
    public function msg(){
        $title=input('title');
        $detail=input('detail');
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $title?$where['p.title']=['like','%'.$title.'%']:'';
        $detail?$where['p.detail']=['like','%'.$detail.'%']:'';
        $begin_time&&!$end_time?$where['p.create_time']=['GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['p.create_time']=['LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['p.create_time']=['BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['p.status']=['>',-1];
        $where['p.type']=3;
        $list = db('post')->field('p.id,p.title,p.create_time,p.sort,p.status,c.name')->alias('p')->join('category c','p.category_id=c.id')->where($where)->order('p.create_time desc')->paginate(13,false,['query'=>['title'=>$title,'detail'=>$detail,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        // var_dump($list);
        return view();
    }

    /**
     * 消息发布
     * @Author   jiayangyang
     * @DateTime 2017-03-22T15:03:57+0800
     * @return   [type]                   [description]
     */
    public function msg_add(){
        if(request()->isPost()){
            $re=model('post')->addPost();
            if($re){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $category=db('category')->where(['status'=>1,'pid'=>1])->order('sort desc')->select();
            $this->assign('category',$category);
            return view();
        }

    }

    /**
     * 消息编辑
     * @Author   jiayangyang
     * @DateTime 2017-03-22T15:03:57+0800
     * @return   [type]                   [description]
     */
    public function msg_edit(){
        $id=input('id');
        if(request()->isPost()){
            $re=model('post')->editPost();
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('post')->where(['id'=>$id])->find();
            // var_dump($info);
            $this->assign('info',$info);
            return view();
        }

    }
}