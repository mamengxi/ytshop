<?php
namespace app\common\controller;
use think\Controller;

/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/3/16
 * Time: 15:10
 */
class Pc extends Controller
{
    public function initialize()
    {
        /**
         * 公共头尾部
         */
        cache('CONFIG',null);
        if(cache('CONFIG')){
            $config = cache('CONFIG');
        }else{
            $config = db('config')->column('v','k');
            cache('CONFIG',$config,7200);
        }
        $this->assign('config',$config);
    }
}