<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/12
 * Time: 13:51
 */

namespace app\admin\controller;
use app\common\controller\Admin;
use think\Loader;
use think\Request;
/**
 * 运营管理
 */
class Operate extends Admin
{
    /**
     * 广告列表
     */
    public function ad(){
        $location_id=input('location_id');
        $where['status'] =['status','>',-1];
        $where['location_id']=$location_id;
        $list=db('ad')->where($where)->paginate(10);
//        $page = $list->render();
//        $this->assign('page',$page);
        $this->assign('list',$list);
        $this->assign('location_id',$location_id);
        return $this->fetch();
        return view();
    }
    /**
     * 添加广告
     */
    public function ad_add(){
        $location_id=input('location_id');
        $this->assign('location_id',$location_id);
        if(request()->isPost()){
            $data['ad_name']=input('ad_name');
            $data['url']=input('url');
            $data['start_time']=strtotime(input('start_time'));
            $data['end_time']=strtotime(input('end_time'));
            $data['img_src']=input('img_src');
            $data['sort']=input('sort');
            $data['status']=input('status');
            $data['uid'] = $this->admin;
            $data['location_id']=input('location_id');
            $data['add_time']=time();
            $re=db('ad')->insert($data);
            if($re){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            return view();
        }
    }
    /**
     * 编辑广告
     */
    public function ad_edit(){
        $id=input('id');
        $ad_id['a.id']=$id;
        if(request()->isPost()){
            $data['ad_name']=input('ad_name');
            $data['url']=input('url');
            $data['start_time']=strtotime(input('start_time'));
            $data['end_time']=strtotime(input('end_time'));
            $data['img_src']=input('img_src');
            $data['sort']=input('sort');
            $data['status']=input('status');
            $data['location_id']=input('location_id');
            $data['add_time']=time();
            $re=db('ad')->where(['id'=>$id])->update($data);

            $version_code=db('ad')
                ->field('lo.version_code,lo.id')
                ->alias('a')
                ->join('__AD_LOCATION__ lo','a.location_id=lo.id')
                ->where($ad_id)
                ->find();
            db('ad_location')
                ->where('id', $version_code['id'])
                ->setInc('version_code');
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('ad')->where(['id'=>$id])->find();
            $info['img_srcs']=explode(',',$info['img_src']);
//            var_dump($info);exit;
            $this->assign('info',$info);
            return view();
        }
    }
    /**
     * 广告位管理
     */
    public function ad_location(){
        $list=db('ad_location')->where('status','NOTIN','-1')->paginate(10);
        $this->assign('list',$list);
        return $this->fetch();
        return view();
    }
    /**
     * 添加广告位
     */
    public function ad_location_add(){
        if(request()->isPost()){
            $data['location']=input('location');
            $data['type']=input('type');
            $data['status']=input('status');
            $data['add_time']=time();
            $re=db('ad_location')->insert($data);
            if($re){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            return view();
        }
    }
    /**
     * 编辑广告位
     * @Author   jiayangyang
     * @DateTime 2017-04-05T18:23:28+0800
     */
    public function ad_location_edit(){
        $id=input('id');
        if(request()->isPost()){
            $data['location']=input('location');
            $data['type']=input('type');
            $data['status']=input('status');
            $data['add_time']=time();
            $re=db('ad_location')->where(['id'=>$id])->update($data);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('ad_location')->where(['id'=>$id])->find();
            $this->assign('info',$info);
            return view();
        }
    }
    /**
     * 友情链接
     * @Author   jiayangyang
     * @DateTime 2017-04-05T09:21:27+0800
     */
    public function flink(){
        $where['status']=['status','>',-1];
        $list=model('flink')->flinkList($where);
        $this->assign('list',$list);
        return $this->fetch();
        return view();
    }
    /**
     * 添加友情链接
     * @Author   jiayangyang
     * @DateTime 2017-04-05T18:22:16+0800
     */
    public function flink_add(){
        if(request()->isPost()){
            $re=model('flink')->flinkAdd();
            if($re){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            return view();
        }
    }
    /**
     * 编辑友情链接
     * @Author   jiayangyang
     * @DateTime 2017-04-05T18:22:30+0800
     */
    public function flink_edit(){
        $id=input('id');
        if(request()->isPost()){
            $re=model('flink')->flinkAdd();
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败'));
            }
        }else{
            $info=db('flink')->where(['id'=>$id])->find();
            $this->assign('info',$info);
            return view();
        }
    }
}