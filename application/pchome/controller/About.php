<?php
namespace app\pchome\controller;
use app\common\controller\Pc;

/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/3/16
 * Time: 11:07
 */
class About extends Pc
{

    public function index()
    {

        $scroll = db('ad')->field('ad_name,img_src,url')->where(['location_id'=>2,'status'=>1])->order(['sort','add_time'=>'desc'])->select();
        $this->assign('ad',$scroll);
        cache('CONFIG',null);
        if(cache('CONFIG')){
            $config = cache('CONFIG');
        }else{
            $config = db('config')->column('v','k');
            cache('CONFIG',$config,7200);
        }
        $this->assign('config',$config);
        $this->assign('nav', 3);
        return view();
    }
}