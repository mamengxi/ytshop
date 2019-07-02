<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/9
 * Time: 14:10
 */
namespace app\common\controller;

use think\Controller;
use think\facade\Cache;

class Admin extends common
{
    protected $admin;
    public function initialize()
    {
        parent::initialize();
        $admin_id = input('session.admin_id',0);
        if(!$admin_id){
            $this->redirect('/admin/Login/index');
        }
        $this->admin = $admin_id;
        $admin_info=db('admin')->where('id',$admin_id)->find();
        $this->assign('admin_username',$admin_info['username']);
        $rule_val = request()->module().'/'.request()->controller().'/'.request()->action();
        $rule_array=explode(',', $admin_info['rule']);
        $rule_id=db('auth_rule')->where('url',$rule_val)->value('id');
        // var_dump($rule_id);
        if((!in_array($rule_id, $rule_array)||$rule_id==null)&&$admin_id!=1){
            if(request()->isAjax()){
                $this->error('没有权限！');
                // return json(array('status'=>false,'info'=>'没有权限！'));
            }else{
                $this->error('没有权限！');
            }

        }
        if(Cache::get('rule')){
            $rule = Cache::get('rule');
        }else{
            $rule=model('Auth')->rule();
            Cache::set('rule',$rule,3600);
        }

//        $crumbs=model('Auth')->getCrumbs($rule_val);
//        $this->assign('crumbs',$crumbs);
        // var_dump($crumbs);
        $this->assign('rule',$rule);
        $this->assign('rule_val',$rule_val);
    }
}
