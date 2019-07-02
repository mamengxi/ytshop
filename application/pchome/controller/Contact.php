<?php
namespace app\pchome\controller;
use app\common\controller\Pc;

/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/3/16
 * Time: 11:07
 */
class Contact extends Pc
{

    public function index()
    {
        if(request()->isPost()) {
            $data['mess'] = input('mess');
            $data['name'] = input('name');
            $data['phone'] = input('tel');
            $data['email'] = input('email');
            $data['create_time'] = time();
            $re = db('contact_us')->insert($data);
            if($re){
                return json(array('status'=>true,'info'=>'发送成功'));
            }else{
                return json(array('status'=>false,'info'=>'发送失败'));
            }
        }
        $this->assign('nav', 4);
        return view();
    }
}