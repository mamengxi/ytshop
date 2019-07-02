<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/23 10:42
 */
namespace app\common\model;

use think\Model;

class Log extends Model
{
    public function log($remark='',$model='',$record_id=''){
        //插入行为日志
        $uid=session('admin_id');
        $data['uid']=$uid?$uid:0;
        $data['action_ip']=request()->ip();
        $data['model']=$model;
        $data['record_id']=$record_id;
        $data['create_time']=time();
        $data['remark']=$remark;
        $this->insert($data);
    }
}