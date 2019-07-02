<?php
namespace app\admin\controller;

use app\common\controller\Admin;
use think\facade\Cache;
use think\Loader;
use think\Request;
/**
 * 后台权限管理
 */
class Auth extends Admin{

    /**
     * 管理员列表
     * @Author   MSC
     * @DateTime 2018-01-10T18:08:32+0800
     */
    public function index(){
        $list=db('admin')->paginate(10);
        $this->assign('list',$list);
        return $this->fetch();
        return view();
    }
    /**
     * 添加管理员
     */
    public function admin_add(){
        if(request()->isPost()){
            $data['username']=input('username');
            $data['rolename']=input('rolename');
            $data['password']=strongmd5(input('password'));
            $data['tel']=input('tel','');
            $data['email']=input('email','');
            $data['status']=input('status','');
            $data['add_time']=time();
            $data['ip']=request()->ip();
            $re=db('admin')->insert($data);
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
     * 添加管理员
     */
    public function admin_edit(){
        $id=input('id');
        if(request()->isPost()){
            if($id==1){
                return json(array('status'=>false,'info'=>'没有权限'));
            }
            $data['rolename']=input('rolename');
            $data['password']=strongmd5(input('password'));
            $data['tel']=input('tel','');
            $data['email']=input('email','');
            $data['status']=input('status','');
            $re=db('admin')->where(array('id'=>$id))->update($data);
            if($re){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('admin')->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            return view();
        }
    }

    /**
     * 角色列表
     */
    public function role(){
        return view();
    }
    /**
     * 节点列表
     */
    public function rule(){
        // $list=db('auth_rule')->select();
        $list=model('auth')->getTree();
        $this->assign('list',$list);
        return view();
    }

    /**
     * 添加节点
     */
    public function rule_add(){
        $id=input('id',0,'intval');
        if(request()->isPost()){
            $data['title']=input('title');
            $data['url']=input('url');
            $data['pid']=input('pid');
            $data['status']=input('status');
            $data['is_nav']=input('is_nav');
            $data['icon']=input('icon');
            $data['sort']=input('sort');
            $re=db('auth_rule')->insert($data);
            if($re){
                Cache::rm('rule');
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $this->assign('id',$id);
            $list=model('auth')->getTree();
            $this->assign('list',$list);
            return view();
        }

    }

    /**
     * 编辑节点
     */
    public function rule_edit(){
        $id=input('id');
        if(request()->isPost()){
            $data['title']=input('title');
            $data['url']=input('url');
            $data['pid']=input('pid');
            $data['status']=input('status');
            $data['is_nav']=input('is_nav');
            $data['icon']=input('icon');
            $data['sort']=input('sort');
            $re=db('auth_rule')->where(array('id'=>$id))->update($data);
            if($re!==false){
                Cache::rm('rule');
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('auth_rule')->where(array('id'=>$id))->find();
            $list=model('auth')->getTree();
            $this->assign('list',$list);
            $this->assign('info',$info);
            return view();
        }

    }


    public function rule_set(){
        $id=input('id','','intval');
        if(request()->isPost()){
            $re=db('admin')->where('id',$id)->setField('rule',trim(input('rules'),','));
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $rule=db('admin')->where(array('id'=>$id))->value('rule');
            $rule=explode(',', $rule);
            $this->assign('rule',$rule);
            $this->assign('id',$id);
            $list=model('auth')->getAllRule();
            $this->assign('list',$list);
            $info=db('admin')->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            return view();
        }
    }
}

