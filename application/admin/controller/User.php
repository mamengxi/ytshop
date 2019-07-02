<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/15
 * Time: 17:57
 */
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Request;

/**
 * 用户管理
 */
class User extends Admin
{
    /**
     * 用户列表
     */
    public function index(){
        $username=input('username');
        $where=[];
        $phone=input('phone');
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $username?$where['username']=['username','like','%'.$username.'%']:'';
        $phone?$where['phone']=['phone','like','%'.$phone.'%']:'';
        $begin_time&&!$end_time?$where['create_time']=['create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['create_time']=['create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['create_time']=['create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['status']=['status','neq',-1];
        $list = db('user')->where($where)->order('create_time desc')->paginate(10,false,['query'=>['username'=>$username,'phone'=>$phone,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);

        $area=model('region')->getArea(100000);
        $this->assign('area', $area);
        return view();
    }
    /**
     * 添加用户
     * @Author   jiayangyang
     * @DateTime 2017-02-10T16:02:54+0800
     * @return   [type]                   [description]
     */
    public function user_add(){
        if(request()->isPost()){
            $re=model('user')->addUser();
            if($re['code']==200) {
                return json(['status' => true, 'info' => '操作成功']);
            }else{
                return json(['status'=>false,'info'=>$re['msg']]);
            }
        }else{
            return view();
        }
    }

    public function user_edit(){
        $id=input('id',0,'intval');
        if(request()->isPost()){
//            $re=model('user')->addUser();
            $data['nickname']=input('nickname');
            $data['password']=strongmd5(input('password'));
            $data['head_img']=input('head_img');
            $data['real_name']=input('real_name');
            $data['sex']=input('sex');
            $data['phone']=input('phone');
            $data['id_card']=input('id_card');
            $data['email']=input('email');
            $data['address']=input('address');
            $data['status']=input('status');
            $re = db('user')->where(['id'=>$id])->update($data);
            if($re!==false){
                return json(['status'=>true,'info'=>'操作成功']);
            }else{
                return json(['status'=>false,'info'=>'操作失败']);
            }
        }else{
            $info=db('user')->where(['id'=>$id])->find();
            $this->assign('info',$info);
//            var_dump($info);exit;
            return view();
        }
    }

    //身份审核通过或不通过
    public function user_identify(){
        $id= input('id','','intval');
        if(request()->isPost()){

            $data['id_card']=input('id_card','');
            $data['real_name']=input('real_name','');
            $data['id_img_front']=input('image_url1');
            $data['id_img_back']=input('image_url2');
            $data['passtime']=time();
            $filter = input('filter');
            $status = input('status');

            $re = db('user')->where('id',$id)->setField($filter,$status);

            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功！'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败！'));
            }
        }else{
            $list = db('user')->where('id',$id)->field('real_name,id_card,id_img_front,id_img_back,id')->find();
            $this->assign('list',$list);
            return view();
        }
    }

}