<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/11
 * Time: 11:04
 */

namespace app\common\model;

use think\Db;
use think\Model;

/**
 *系统配置
 * @version 1.0
 */
class Config extends Model{
    /**
     * 设置键值
     * @param $k string 键
     * @param $v string 值
     */
    public function set($k,$v) {
        $exist = $this->where(Array('k'=>$k))->find();
        $v=htmlspecialchars($v);
        $flag='';
        if ($exist) {
            if($exist['v']!=$v){
                $flag = $this->where(Array('k'=>$k))->setField('v',$v);
                model('Log')->log('更新配置项"'.$k.'"为"'.$v.'"','config',$exist['id']);
            }
        } else {
            $data['k'] = $k;
            $data['v'] = $v;
            $flag = $this->insert($data);
            model('Log')->log('添加配置项"'.$k.'"为"'.$v.'"','config',$flag);
        }
        cache('config',null);
        return $flag;
    }


    public function setAll($post){
        foreach ($post as $k => $v) {
            $this->set($k,$v);
        }
        return true;
    }

}