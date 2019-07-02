<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/15
 * Time: 17:59
 */
namespace app\common\model;
use think\Db;
use think\Request;
use think\Model;

/**
 *省市区
 * @version 1.0
 */
class Region extends Model{
    /**
     * 记录行为
     * @Author   jiayangyang
     * @DateTime 2016-03-08T15:38:58+0800
     * @return   [type]                   [description]
     */
    public function getArea($parentCode=100000){
        $list=db('region')->where(['parentCode'=>$parentCode])->select();
        return $list;
    }



}