<?php
namespace app\index\controller;

use app\common\controller\Admin;

class Index extends Admin
{
    public function index()
    {
        $this->assign('name','ma');
        return view();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
