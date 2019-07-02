<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/9
 * Time: 15:58
 */
namespace app\admin\controller;

use app\common\controller\Admin;

class Login extends Admin
{
    public function initialize()
    {
        $action=request()->action();
        $admin_id = input('session.admin_id',0);
        if($admin_id&&$action!='logout'){
            $this->redirect('/admin/Index');
        }
    }
    public function index()
    {
        if(request()->isPost()) {
            $username = input('username', '', 'trim');
            $password = input('password', '', 'trim');
            $remember = input('remember');
//            $admin_id = 1;
//            var_dump($remember);exit;
//            $user_id = session('user_id','1');
            if($username==""||$password==""){
                return json(array('status'=>false,'msg'=>'用户名或密码不能为空！'));
            }
            $info=db('admin')->where(array('username'=>$username,'password'=> strongmd5($password),'status'=>1))->find();
//            var_dump(strongmd5($password));exit;
            if($info){
                session('admin_id',$info['id']);
                session('is_superadmin',$info['is_superadmin']);
                $data['last_ip']=request()->ip();
                $data['last_time']=time();
                if($remember == '1'){
                    cookie('admin_id', $info['id'], 604800);
                }
//                model('Log')->log($info['username'].'在'.date('Y-m-d H:i:s').'登录了后台','admin',$info['id']);
                db('admin')->where("id={$info['id']}")->update($data);
                return json(array('status'=>true,'msg'=>'登录成功','url'=>url('/admin/Index/index')));
            }else{
                return json(array('status'=>false,'msg'=>'用户名或密码错误！'));
            }
        }else{
            return view();
        }
    }
    /**
     * 退出登录
     * @Author   jiayangyang
     * @DateTime 2016-01-04T10:25:24+0800
     */
    public function logout() {
        cookie('admin_id', null);
        session(null);
        $this->redirect('/admin/Login/index');
    }

}