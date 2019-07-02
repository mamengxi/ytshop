<?php
/**
 * Created by MSC.
 * User: stlhtech
 * Date: 2018/2/25
 * Time: 16:04
 */
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Db;
use think\Request;
/**
 * 内容管理
 */
class Push extends Admin
{
    public function mom_push()
    {
        $content=input('content');
        $begin_time=input('begin_time');
        $end_time=input('end_time');
        $content?$where['mp.content']=['mp.content','like','%'.$content.'%']:'';
        $begin_time&&!$end_time?$where['mp.create_time']=['mp.create_time','GT',strtotime($begin_time)]:'';
        $end_time&&!$begin_time?$where['mp.create_time']=['mp.create_time','LT',strtotime($end_time)]:'';
        $end_time&&$begin_time?$where['mp.create_time']=['mp.create_time','BETWEEN',array(strtotime($begin_time),strtotime($end_time))]:'';
        $where['mp.status']=['mp.status','=',1];
        $list = db('mom_push')
            ->alias('mp')
            ->join('__USER__ u','u.id = mp.uid')
            ->field('mp.*,u.nickname')
            ->where($where)
            ->order('mp.create_time desc')
            ->paginate(13,false,['query'=>['content'=>$content,'begin_time'=>$begin_time,'end_time'=>$end_time]]);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        return view();
    }

    public function push_detail()
    {
        $push_id = input('id');
        $where['mp.id'] = $push_id;
        $info = db('mom_push')
            ->alias('mp')
            ->join('__USER__ u','u.id = mp.uid')
            ->field('u.nickname,mp.*')
            ->where($where)
            ->find();
        $info['imgList']=explode(',',$info['image']);

        //评论区的内容
        $list=db('mom_comment')
            ->field('mc.*,u.nickname,u.id as uid')
            ->alias('mc')
            ->join('__USER__ u','mc.uid=u.id')
            ->where(['push_id'=>$push_id,'comment_id'=>0])
            ->order('mc.create_time desc')
            ->select();
        foreach ($list as $k => $v) {
            $list[$k]['son']=db('mom_comment')
                ->field('mc.*,u1.id as u1_id,u1.nickname as u1_nickname,u2.id as u2_id,u2.nickname as u2_nickname')
                ->alias('mc')
                ->join('__USER__ u1','mc.uid=u1.id')
                ->join('__USER__ u2','mc.to_uid=u2.id')
                ->where(['comment_id'=>$v['id']])
                ->order('mc.create_time asc')
                ->select();
        }
        $this->assign('info',$info);
        $this->assign('list',$list);
        return view();
    }
}