<?php
namespace app\pchome\controller;
use app\common\controller\Pc;

/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/3/16
 * Time: 11:07
 */
class Display extends Pc
{

    public function index()
    {
        $cate = input('cate',0,'intval');
//        if($cate !==0){
//            $where['p.kind_id']=$cate;
//        }
        $where['p.status']=1;
        $scroll = db('ad')->field('ad_name,img_src,url')->where(['location_id'=>2,'status'=>1])->order(['sort','add_time'=>'desc'])->select();
        $list1 = db('product')
            ->alias('p')
            ->field('k.title as ktitle,p.title as ptitle,p.id,p.img_thumb')
            ->join('__KIND__ k','k.id=p.kind_id')
            ->where($where)
            ->where('k.id',1)
            ->select();
        $list2 = db('product')
            ->alias('p')
            ->field('k.title as ktitle,p.title as ptitle,p.id,p.img_thumb')
            ->join('__KIND__ k','k.id=p.kind_id')
            ->where($where)
            ->where('k.id',2)
            ->select();
        $list3 = db('product')
            ->alias('p')
            ->field('k.title as ktitle,p.title as ptitle,p.id,p.img_thumb')
            ->join('__KIND__ k','k.id=p.kind_id')
            ->where($where)
            ->where('k.id',3)
            ->select();
        $this->assign('ad',$scroll);

        $catelist = db('kind')->field('id,title')->where('status',1)->select();
        $this->assign('id',$cate);
        $this->assign('cateList',$catelist);
//        $this->assign('list',$list);
        $this->assign('list1',$list1);
        $this->assign('list2',$list2);
        $this->assign('list3',$list3);
        $this->assign('nav', 2);
        return view();
    }
}