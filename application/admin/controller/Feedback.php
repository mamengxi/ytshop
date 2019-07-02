<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/29
 * Time: 10:32
 */

namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Request;
use think\Db;
/**
 * 反馈管理
 */
class Feedback extends Admin
{
    /**
     *
     */
    public function index(){
        if(request()->isPost()){
            $where = [];
            $phone=input('phone');
            $phone?$where['u.phone']=['u.phone','like','%'.$phone.'%']:'';
            $order=input('order','f.time desc');
            $count=db('feedback')
                ->alias('f')
                ->join('__USER__ u', 'u.id=f.uid')
                ->where($where)
                ->count();
            $list = db('feedback')
                ->alias('f')
                ->field('f.*,u.phone,u.nickname')
                ->join('__USER__ u', 'u.id=f.uid')
                ->where($where)
                ->limit(input('limit'))
                ->page(input('page'))
                ->order($order)
                ->select();
//            var_dump($list['phone']);exit;
            foreach ($list as $k => $v) {
                $list[$k]['time']=date('Y-m-d H:i:s',$v['time']);
            }
            return json(['code'=>0,'msg'=>'请求成功','count'=>$count,'data'=>$list]);
        }else{
            return view();
        }

    }

    public function deal(){
        $id=input('id');
        $status=input('status');
//        var_dump($status);exit;
        $re=db('feedback')->where('id',$id)->setField('status',$status);
        if($re){
            return ['status'=>true,'msg'=>'处理成功'];
        }else{
            return ['status'=>false,'msg'=>'处理失败'];
        }

    }

    /**
     * 删除用户
     * @Author   MSC
     * @DateTime 2018-01-29T10:06:56+0800
     * @return   [type]                   [description]
     */
    public function feedback_del(){
        if(request()->isPost()){
            $id=input('id');
            $re=db('feedback')->where(['id'=>$id])->delete();
            if($re){
                return ['status'=>true,'msg'=>'删除成功'];
            }else{
                return ['status'=>false,'msg'=>'删除失败'];
            }
        }
    }
}