<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/9
 * Time: 15:53
 */

namespace app\common\model;


use think\Db;
use think\Model;
/**
 * 后台model基础类
 *
 * Class Admin
 * @package app\admin\model
 */
class Auth extends Model{

    public function rule(){
        $admin_id = input('session.admin_id',0);
        $rules=db('admin')->where(array('id'=>$admin_id))->value('rule');
        $rules=explode(',', $rules);
        // var_dump($rules);
        $re=Db('AuthRule')->where(array('status'=>1,'is_nav'=>1,'pid'=>0))->order('sort')->select();
        foreach ($re as $k => $v) {
            if(in_array($v['id'], $rules)){
                $re[$k]['son']=Db('AuthRule')->where(array('status'=>1,'is_nav'=>1,'pid'=>$v['id']))->order('sort')->select();
                $rule=array();

                foreach ($re[$k]['son'] as $key => $value) {
                    if(in_array($value['id'], $rules)||$admin_id==1){
                        $rule[]=$value['url'];
                    }else{
                        unset($re[$k]['son'][$key]);
                    }
                }
                $re[$k]['rule']=$rule;
            }else{
                unset($re[$k]);
            }
        }
        return $re;
    }

    /**
     * 面包屑
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
//    public function getCrumbs($url){
//        $crumbs='<li><i class="fa fa-home"></i>&nbsp;<a href="/admin/Index/index">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;';
//        $info=db('auth_rule')->where('url',$url)->find();
//        if($info['pid']!==0){
//            $parent=db('auth_rule')->where('id',$info['pid'])->find();
//            $crumbs.="<a href='/".$parent['url']."'>".$parent['title']."</a>&nbsp;&nbsp;<i class='fa fa-angle-right'></i>&nbsp;&nbsp;";
//        }
//        $crumbs.=$info['title']."</li>";
//        return $crumbs;
//    }

    /**
     * 节点列表获取所有节点
     * @Author   jiayangyang
     * @DateTime 2017-02-20T12:18:14+0800
     * @return   [type]                   [description]
     */
    public function getTree($pid=0,$html="|---",$level=3){
        $list=db('auth_rule')->order('sort')->select();
        $list=getSort($list,$pid,$html,$level);
        return $list;
    }

//    /**
//     * 获取所有可用节点
//     * @return [type] [description]
//     */
//    public function getAllRule(){
//        $re=Db('AuthRule')->field('id,title')->where(array('status'=>1,'pid'=>0))->order('sort')->select();
//        foreach ($re as $k => $v) {
//            $re[$k]['sub']=Db('AuthRule')->field('id,title')->where(array('status'=>1,'pid'=>$v['id']))->select();
//            foreach ($re[$k]['sub'] as $key => &$value) {
//                $value['sub']=Db('AuthRule')->field('id,title')->where(array('status'=>1,'pid'=>$value['id']))->select();
//            }
//        }
//        return $re;
//    }
    
    
    public function getAllRule()
    {
        $res=db('AuthRule')->field('id,title,pid')->where('status',1)->order('sort')->select();
        $list = array();
        foreach ($res as $k=>$v)
        {
            if($v['pid']==0){
                $child = self::getChrildRule($res,$v['id']);
                $v['sub'] = $child;
                array_push($list,$v);
            }
        }
        return $list;
    }

    private function getChrildRule($res,$pid)
    {
        $list = array();
        foreach ($res as $k=>$v){
            if($v['pid'] ==$pid){
                $child = self::getChrildRule($res,$v['id']);
                $v['sub'] = $child;
                array_push($list,$v);
            }
        }
        return $list;
    }
}