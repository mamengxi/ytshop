<?php
namespace app\pchome\controller;
use app\common\controller\Pc;
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/3/16
 * Time: 11:07
 */
class Detailed extends Pc
{

    public function index()
    {
        $id = input('id');
        $list = db('product')->where('id',$id)->find();
        $this->assign('list',$list);
        $this->assign('nav', 2);
        return view();
    }
}