<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/3/12 14:44
 */
namespace app\common\model;

use think\Model;

class Goods extends Model
{

    public function getGoodsInfo($gid)
    {
        return db('goods')->field('title,img_thumb,price,type_id,status')->where('id',$gid)->find();
    }
}