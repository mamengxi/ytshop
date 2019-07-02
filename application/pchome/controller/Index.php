<?php
namespace app\pchome\controller;
use app\common\controller\Pc;

/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/3/16
 * Time: 11:07
 */
class Index extends Pc
{

    public function index()
    {
        //轮播图
        $scroll = db('ad')->field('ad_name,img_src,url')->where(['location_id'=>2,'status'=>1])->order(['sort','add_time'=>'desc'])->select();
        $this->assign('ad',$scroll);
        //
        $kind = db('kind')->field('title')->order(['sort','create_time'=>'desc'])->where('status',1)->limit(0,3)->select();
        $this->assign('kind',$kind);
        //
        $product = db('product')->field('img_thumb,introduce')->where('status',1)->order('create_time desc')->limit(0,3)->select();
        $this->assign('product',$product);

        $this->assign('nav', 1);
        return view();
    }
}