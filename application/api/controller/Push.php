<?php
/**
 * Created by MSC.
 * User: msc
 * Date: 2018/2/23
 * Time: 10:46
 */

namespace app\api\controller;

use app\common\controller\Api;

class Push extends Api
{
    /*
       获取妈妈推所有列表
     */
    public function show()
    {
        $this->checkToken();
        $page=input('page',1);
        $list = db('mom_push')
            ->alias('mp')
            ->join('__USER__ u','mp.uid = u.id')
            ->field('mp.*,u.head_img,u.nickname')
            ->where('mp.status',1)
            ->order('create_time', 'desc')
            ->page($page)
            ->limit(10)
            ->select();
        foreach ($list as $k => $v) {
            $list[$k]['create_time']=date("Y-m-d H:i",$v['create_time']);
            $list[$k]['is_coll'] = db('mom_collect')->where(['push_id'=>$v['id'],'uid'=>$this->uid])->find()?1:0;
            if($v['image']){
                $list[$k]['image']=explode(',', $v['image']);
            }else{
                $list[$k]['image']=[];
            }
        }
        $total=db('mom_push')->where(['status'=>1])->count();
        return json(['code'=>200,'data'=>['list'=>$list,'total_page'=>ceil($total/10)]]);
    }
    /*
       获取列表详情
     */
    public function show_detail()
    {
        $this->checkToken();
        $id = input('id');
        $list = db('mom_push')
            ->alias('mp')
            ->join('__USER__ u','mp.uid = u.id')
            ->field('mp.*,u.head_img,u.nickname')
            ->where(['mp.status' =>1,'mp.id' => $id])
            ->find();
        $list['create_time']=date("Y-m-d H:i",$list['create_time']);
        if($list['image']){
            $list['image']=explode(',', $list['image']);
        }
        $list['comment']=$this->commentList($id);
        //判断是否有收藏过该主题
        $re = db('mom_collect')->where(['push_id'=>$id,'uid'=>$this->uid])->find();
        if($re){
            $list['is_coll'] = 1;
        }else{
            $list['is_coll'] = 0;
        }

        return json(['code'=>200,'data'=>$list]);
    }
    /*
     *  获取妈妈推个人列表
     */
    public function myshow()
    {
        $page=input('page',1);
        $this->checkToken();
        $id = $this->uid;
        $list = db('mom_push')
            ->alias('mp')
            ->join('__USER__ u','mp.uid = u.id')
            ->field('mp.*,u.head_img,u.nickname')
            ->where(['mp.status'=>1,'uid'=>$id])
            ->order('create_time', 'desc')
            ->page($page)
            ->limit(10)
            ->select();
        foreach ($list as $k => $v) {
            $list[$k]['create_time']=date("Y-m-d H:i",$v['create_time']);
            $list[$k]['is_coll'] = db('mom_collect')->where(['push_id'=>$v['id'],'uid'=>$this->uid])->find()?1:0;
            if($v['image']){
                $list[$k]['image']=explode(',', $v['image']);
            }
        }
        $total=db('mom_push')->where(['status'=>1,'uid'=>$id])->count();
        $is_msg=db('message')->where(['to_uid'=>$this->uid,'status'=>2])->count()?true:false;
        return json(['code'=>200,'data'=>['list'=>$list,'total_page'=>ceil($total/10),'is_msg'=>$is_msg]]);
    }
    /*
      发布信息
   */
    public function release()
    {
        $this->checkToken();
        $data['content'] = input('content');
        if(input('image')){
            $img=$this->saveBase64(input('image'));
            $data['image'] =  $img;
        }
        $data['uid'] = $this->uid;
        $data['create_time'] = time();
        if(!$data['content']) return $this->errorJson(400,'缺少参数');
        $re = db('mom_push')->insert($data);
        if($re){
            return json(['code'=>200,'msg'=>'发布成功']);
        }else{
            return json(['code'=>400,'msg'=>'操作失败']);
        }
    }
    /*
      评论信息
   */
    public function comment()
    {
        $this->checkToken();
        $data['push_id'] = input('push_id');
        $data['comment_id'] =  input('comment_id','0','intval');
        $data['to_uid'] =  input('to_uid','0','intval');
        $data['uid'] = $this->uid;
        $data['content'] = input('content');
        $data['create_time'] = time();
        if(!$data['content']) return $this->errorJson(400,'缺少参数');
        $re = db('mom_comment')->insert($data);
        if($re){
            if($data['comment_id']==0){
                $res = db('mom_push')->where(['status' => 1, 'id' => $data['push_id']])->setInc('commentcount', 1);
                if($res){
                    $tid = db('mom_push')->where('id',$data['push_id'])->value('uid');
//                    $content = db('mom_comment')->where(['uid'=>$data['uid'],'push_id'=>$data['push_id']])->value('content');
                    $data1['to_uid'] = $tid;
                    $data1['push_id'] = $data['push_id'];
                    $data1['content'] = $data['content'];
                    $data1['type'] = 3;
                    $data1['create_time'] = time();
                    $data1['uid'] = $this->uid;
                    if ($this->uid !== $tid){
                        db('message')->insert($data1);
                    }
                    return json(['code'=>200,'msg'=>'评论成功']);
                }else{
                    return json(['code'=>400,'msg'=>'操作失败']);
                }
            }else{
                return json(['code'=>200,'msg'=>'评论成功']);
            }
        }else{
            return json(['code'=>400,'msg'=>'操作失败']);
        }
    }

    /*
       评论详情
    */
    public function commentList($id){
        $list=db('mom_comment')
            ->field('mc.*,u.head_img,u.nickname,u.id as uid')
            ->alias('mc')
            ->join('__USER__ u','mc.uid=u.id')
            ->where(['push_id'=>$id,'comment_id'=>0])
            ->order('mc.create_time desc')
            ->select();
        foreach ($list as $k => $v) {
            $list[$k]['create_time']=date('Y-m-d H:i',$v['create_time']);
            $list[$k]['son']=db('mom_comment')
                ->field('mc.*,u1.id as u1_id,u1.nickname as u1_nickname,u2.id as u2_id,u2.nickname as u2_nickname')
                ->alias('mc')
                ->join('__USER__ u1','mc.uid=u1.id')
                ->join('__USER__ u2','mc.to_uid=u2.id')
                ->where(['comment_id'=>$v['id']])
                ->order('mc.create_time asc')
                ->select();
        }
        return $list;
    }

    /**
     *  帖子  添加/删除  赞
     */
    public function actColl()
    {
        $this->checkToken();
        $id = input('id');
        $uid = $this->uid;
        $data['uid'] = $uid;
        $data['push_id'] = $id;
        $data['add_time'] = time();
        $act = input('act','','trim');
        if (!$id || !$act) return $this->errorJson(400, '缺少参数');
        switch (strtolower($act)) {
            case 'add':
                $res = db('mom_collect')->where(['uid' => $data['uid'], 'push_id' => $id])->find();
                if ($res) {
                    return json(['code' => 400, 'msg' => '点赞过啦']);
                } else {
                    $re = db('mom_collect')->insert($data);
                    if ($re) {
                        $re1 = db('mom_push')->where(['id' => $id])->setInc('likecount', 1);
                        if ($re1) {
                            $nickname = db('user')->where('id',$uid)->value('nickname');
                            $tid = db('mom_push')->where('id',$id)->value('uid');
                            $data1['to_uid'] = $tid;
                            $data1['push_id'] = $id;
                            $data1['content'] = $nickname.'赞了你的发布';
                            $data1['type'] = 1;
                            $data1['create_time'] = time();
                            $data1['uid'] = $this->uid;if ($this->uid !== $tid){
                                db('message')->insert($data1);
                            }
                            return json(['code' => 200, 'msg' => '点赞成功']);
                        } else {
                            return json(['code' => 400, 'msg' => '操作失败']);
                        }
                    } else {
                        return json(['code' => 400, 'msg' => '操作失败']);
                    }
                }
                break;
            case 'del':
                $res = db('mom_collect')->where(['uid' => $data['uid'], 'push_id' => $id])->find();
                if ($res) {
                    $re = db('mom_collect')->where(['uid' => $data['uid'], 'push_id' => $id])->delete();
                    if ($re) {
                        $re1 = db('mom_push')->where(['id' => $id])->setDec('likecount', 1);
                        if ($re1) {
                            return json(['code' => 200, 'msg' => '取消成功']);
                        } else {
                            return json(['code' => 400, 'msg' => '操作失败']);
                        }
                    } else {
                        return json(['code' => 400, 'msg' => '操作失败']);
                    }
                } else {
                    return json(['code' => 400, 'msg' => '没有收藏过哦']);
                }
                break;
        }
    }

    //分享次数
    public function share(){
        $id = input('id');
        $uid = $this->uid;
        $re =  db('mom_push')->where(['id'=>$id,'status'=>1])->setInc('sharecount',1);
        if($re){
            $nickname = db('user')->where('id',$uid)->value('nickname');
            $tid = db('mom_push')->where('id',$id)->value('uid');
            $data['to_uid'] = $tid;
            $data['push_id'] = $id;
            $data['content'] = $nickname.'分享了你的发布';
            $data['type'] = 2;
            $data['create_time'] = time();
            $data['uid'] = $this->uid;
            if ($this->uid !== $tid){
                db('message')->insert($data);
            }
            return json(['code'=>200,'msg'=>'分享成功']);
        }else{
            return json(['code'=>400,'msg'=>'操作失败']);
        }

    }

    //消息推送
    public function message(){
        $this->checkToken();
        $to_uid = $this->uid;
        $list = db('message')
            ->alias('m')
            ->field('m.*,u.nickname,u.head_img,mp.image,mp.id as push_id')
            ->join('__MOM_PUSH__ mp','mp.id = m.push_id')
            ->join('__USER__ u','u.id = m.uid')
            ->where(['m.to_uid'=>$to_uid])
            ->order('create_time desc,status desc')
            ->select();
        foreach ($list as $k => $v) {
            $list[$k]['create_time'] = mdate($v['create_time']);
            if($v['image']){
                $list[$k]['image'] = explode(',', $v['image']);
                $list[$k]['image'] = $list[$k]['image'][0];
            }
        }
        db('message')->where(['to_uid'=>$this->uid])->setField('status', 1);
        return json(['code'=>200,'data'=>$list]);
    }

    //清空消息列表
    public function clearList(){
        $this->checkToken();
        $to_uid = $this->uid;
        $re = db('message')->where('to_uid',$to_uid)->delete();
        if($re!==false){
            return json(['code'=>200,'msg'=>'操作成功']);
        }else{
            return json(['code'=>400,'msg'=>'操作失败']);
        }
    }
}