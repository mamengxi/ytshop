<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/2/28
 * Time: 15:27
 */
namespace app\api\controller;

use app\common\controller\Api;

class Invoice extends Api
{
    //新增发票信息
    public function add_invoice()
    {
        $uid = $this->uid;
        $data['uid'] = $uid;
        $data['is_person'] = input('is_person');
        $data['name'] = input('name');
        $data['tax_num'] = input('tax_num');

        $re = db('invoice')->insert($data);
        if ($re){
            return json(['code'=>200,'msg'=>'添加成功']);
        }else{
            return json(['code'=>400,'msg'=>'操作失败']);
        }
    }

    //修改发票信息
    public function edit()
    {
        $id = input('id');
        $data['is_person'] = input('is_person');
        $data['name'] = input('name');
        $data['tax_num'] = input('tax_num');

//        $id = 4;
//        $data['name'] = '爱巢科技有限公司';
        $re = db('invoice')->where('id',$id)->update($data);
        if ($re!==false){
            return json(['code'=>200,'msg'=>'修改成功']);
        }else{
            return json(['code'=>400,'msg'=>'操作失败']);
        }
    }

    //展示发票信息
    public function show()
    {
        $uid = $this->uid;
        $list = db('invoice')->where('uid',$uid)->select();
        return $list;
    }

    //删除发票信息
    public function delete()
    {
        $id = input('id');

        $re = db('invoice')->where('id',$id)->delete();
        if ($re){
            return json(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json(['code'=>400,'msg'=>'操作失败']);
        }
    }
}