<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/3/19
 * Time: 10:49
 */
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Request;
use think\Db;
/**
 * 联系我们
 */
class Contact extends Admin
{
    public function index()
    {
        $list = db('contact_us')->where('status',1)->order('create_time desc')->select();
        $this->assign('list',$list);
        return view();
    }
}