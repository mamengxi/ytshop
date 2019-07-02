<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/12
 * Time: 17:33
 */
namespace app\common\model;
use think\Db;
use think\Model;
/**
 * 活动管理
 */
class Flink extends Model{

    public function flinkList($where){
        $re=db('flink')->where($where)->order('sort desc')->paginate(10);
        return $re;
    }

    public function flinkAdd(){
        $id=input('id',0,'intval');
        $data['title']=input('title');
        $data['link']=input('link');
        $data['type']=input('type');
        $data['sort']=input('sort');
        $data['description']=input('description');
        $data['status']=input('status');
        if($id){
            $re=db('flink')->where(['id'=>$id])->update($data);
        }else{
            $re=db('flink')->insert($data);
        }
        return $re;
    }
}