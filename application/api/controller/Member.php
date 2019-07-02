<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/29 14:27
 */

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

class Member extends Api
{
    public function initialize()
    {
        parent::initialize();
        $this->checkToken();
    }
    public function index()
    {
        $userinfo = db('user')->field('phone,head_img,sex,nickname')->where('id',$this->uid)->find(); //用户信息
        $sql = "select
sum(
if((uid = $this->uid and order_status = 2),1,0)
) as a,
sum(
if((uid = $this->uid and order_status = 3),1,0)
) as b,
sum(
if((uid = $this->uid and order_status = 4),1,0)
) as c
from y_orders
";
        $list['order'] = Db::query($sql);
        $list['info'] = $userinfo;
        return json(['code'=>200,'data'=>$list]);
    }

    /*
     *  获取用户信息
     */
    public function getInfo()
    {
        $info = db('user')->field('nickname,head_img,sex,birthday,phone')->where('id',$this->uid)->find();
        if($info['birthday']){
            $info['birthday'] = date("Y-m-d",$info['birthday']);
            $info['head_img']=$info['head_img']?$info['head_img']:'/static/default/default_head_image.png';
        }
        return json(['code'=>200,'data'=>$info]);
    }
    /*
     *   修改个人信息
     */
    public function editInfo()
    {
        $data['head_img'] = input('head_img','','trim');
        $data['sex'] = input('sex','1','intval');
        $data['birthday'] = strtotime(input('birthday'));
        $data['nickname'] = input('nickname');
        $res = db('user')->where('id',$this->uid)->update($data);
        if($res!==false){
            return $this->errorJson(200,'修改成功');
        }else{
            return $this->errorJson(400,'修改失败');
        }
    }

    /*
     *  用户收藏列表
     * @return \think\response\Json
     */
    public function collect()
    {
        $list = db('collect')->alias('c')
            ->join('__GOODS__ g','c.gid=g.id')
            ->field('c.id,g.id gid,g.title,g.price,g.img_thumb')
            ->where(['c.uid'=>$this->uid,'c.status'=>1])
            ->order('add_time desc')
            ->select();
        if($list){
            foreach ($list as $k => $v) {
                $list[$k]['check']=false;
                $list[$k]['price']=unFormatMoney($v['price']);
            }
            return json(['code'=>200,'data'=>$list]);
        }else{
            return json(['code'=>402,'data'=>'暂无数据']);
        }    
        
    }
    /**
     *  用户  添加/删除  收藏
     * @return \think\response\Json
     */
    public function actCollect()
    {
        $id = input('id','');
        $act = input('act','','trim');
        if(!$id ||!$act) return $this->errorJson(400,'缺少参数');
        $userCollect = db('collect')->where('gid','in',$id)->where('uid',$this->uid)->select();
        switch (strtolower($act)){
            case 'add':
                if($userCollect){
                    $res = db('collect')->where('gid',$userCollect[0]['gid'])->update(['status'=>1,'add_time'=>time()]);
                }else{
                    $res = db('collect')->insert(['uid'=>$this->uid,'gid'=>$id,'add_time'=>time()]);
                }
                $msg ='收藏成功';
                $error = '收藏失败';
                break;
            case 'del':
                if($userCollect){
                    $res = db('collect')->where('gid','in',$id)->setField('status',-1);
                }else{
                    return $this->errorJson(403,'没有收藏');
                }
                $msg ='取消成功';
                $error = '取消失败';
                break;
        }
        if($res){
            return $this->errorJson(200,$msg);
        }else{
            return $this->errorJson(400,$error);
        }
    }

    /**
     *  重置密码
     */
    public function repassword()
    {
        $oldpassword = input('oldpassword');
        $password = input('password');
        $repassword = input('repassword');
        if($password != $repassword) return $this->errorJson(403,'密码不一致');
        $userpass = db('user')->where('id',$this->uid)->value('password');
        if(strongmd5($oldpassword) != $userpass) return $this->errorJson(400,'旧密码不正确');
        try{
            db('user')->where('id',$this->uid)->setField('password',strongmd5($password));
            return $this->errorJson(200,'修改成功');
        }catch (\Exception $e){
            return $this->errorJson(400,'修改失败');
        }
    }

    /*
     *   绑定手机号
     * @return \think\response\Json
     */
    public function bindPhone()
    {
        $phone= input('phone','','intval');
        $code = input('code');
        $password=input('password');
        if(!$phone||!$code||!$password) return $this->errorJson(400,'缺少参数');
        $checkCode = model('MobileCode')->checkCode($phone,$code,3);
        if($checkCode['code'] != 200) return $checkCode;
        try{
            db('user')->where('id',$this->uid)->update(['phone'=>$phone,'password'=>strongmd5($password)]);
            return $this->errorJson(200,'绑定成功');
        }catch (\Exception $e){
            return $this->errorJson(400,'绑定失败');
        }
    }
    /*
     *  更改手机号
     */
    public function changePhone()
    {
        $phone= input('phone','','intval');
        $code = input('code');
        if(!$phone||!$code) return $this->errorJson(400,'缺少参数');
        $checkCode = model('MobileCode')->checkCode($phone,$code,5);
        if($checkCode['code'] != 200) return $checkCode;
        try{
            db('user')->where('id',$this->uid)->setField('phone',$phone);
            return $this->errorJson(200,'绑定成功');
        }catch (\Exception $e){
            return $this->errorJson(400,'绑定失败');
        }
    }

    /*
     *  收货地址列表
     */
    public function addrList()
    {
        $list =db('address')->where(['uid'=>$this->uid,'status'=>1])->order('is_check desc')->select();
        return json(['code'=>200,'data'=>$list]);
    }

    public function showAddr()
    {
        $id= input('id','','intval');
        if(!$id) return $this->errorJson(400,'参数不对');
        $data = db('address')->where(['id'=>$id,'uid'=>$this->uid])->find();
        return json(['code'=>200,'data'=>$data]);
    }
    /*
     *  添加收货地址
     */
    public function address()
    {
        $id = input('id','','intval');
        $phone = input('phone','','intval');
        $username = input('username','','trim');
        $province = input('province','','trim');
        $city = input('city','','trim');
        $area = input('area','','trim');
        $detail = input('detail','','trim');
        $check = input('check','0');
        if(!$phone|| !$province ||!$city||!$area||!$detail||!$username) return $this->errorJson(400,'缺少参数');
        if($id){
            // 更新
            $res = db('address')->where(['id'=>$id,'uid'=>$this->uid])->setField(['username'=>$username,'phone'=>$phone,'province'=>$province,'city'=>$city,'area'=>$area,'detail'=>$detail]);
            $success = '更新成功';
            $error = '更新失败';
        }else{
            //添加
            if($check ==1){
                db('address')->where('uid',$this->uid)->setField('is_check',0);
            }
            // var_dump($username);exit;
            $res = db('address')->insert(['uid'=>$this->uid,'username'=>$username,'phone'=>$phone,'province'=>$province,'city'=>$city,'area'=>$area,'detail'=>$detail,'is_check'=>$check,'create_time'=>time()]);
            $success ='添加成功';
            $error ='添加失败';
        }
        if($res!==false){
            return $this->errorJson(200,$success);
        }else{
            return $this->errorJson(500,$error);
        }
    }

    /**   根据地址id 删除地址
     * @return \think\response\Json
     */
    public function delAddress()
    {
        $id = input('id','','intval');
        if(!$id) return $this->errorJson(400,'缺少参数');
        $address = db('address')->where(['uid'=>$this->uid,'id'=>$id])->find();
        if(!$address) return $this->errorJson(400,'不能删除不是自己的地址');
        $res = db('address')->where(['uid'=>$this->uid,'id'=>$id])->setField('status',-1);
        if($res){
            return $this->errorJson(200,'删除成功');
        }else{
            return $this->errorJson(500,'系统繁忙');
        }
    }
    /*
     *   设置默认地址
     */
    public function setCheckAddr()
    {
        $id= input('id','','intval');
        $isexist = db('address')->where(['uid'=>$this->uid,'id'=>$id])->find();
        if(!$isexist) return $this->errorJson(401,'地址不存在');
        Db::startTrans();
        try{
            db('address')->where('uid',$this->uid)->setField('is_check',0);
            db('address')->where('id',$id)->setField('is_check',1);
            return $this->errorJson(200,'设置成功');
        }catch (\Exception $e){
            Db::rollback();
            return $this->errorJson(400,'设置失败');
        }
    }

    /*
     *  会员中心 ->  历史记录
     */
    public function history()
    {
        $list =Db::query("SELECT id,gid,FROM_UNIXTIME(create_time,'%Y-%m-%d') as date FROM y_history WHERE uid=".$this->uid." ORDER BY date desc");
        if($list){
            $data = array();
            $res = array();
            foreach ($list as $k=>$v){
                $goods = model('Goods')->getGoodsInfo($v['gid']);
                $v['title']=$goods['title'];
                $v['img']=$goods['img_thumb'];
                $v['price']=unFormatMoney($goods['price']);
                $v['status']=$goods['status'];
                if(array_key_exists($v['date'],$data)){ // 当天的时间已存在
                    array_push($data[$v['date']],$v);
                }else{
                    $data[$v['date']][]= $v;
                }
            }
            foreach ($data as $k=>$v){
                $tmp['date']=$k;
                $tmp['list']=$v;
                $tmp['check']=false;
                array_push($res,$tmp);
            }
        }
        $res=$res?$res:[];
        return json(['code'=>200,'data'=>$res]);
    }

    /*
     *  添加 历史记录
     */
    public function addHistory()
    {
        $gid = input('id','','intval');
        if(!$gid) return false;
        $exist = db('history')->where(['uid'=>$this->uid,'gid'=>$gid])->find();
        try{
            if($exist){
                db('history')->where('id',$exist['id'])->update(['create_time'=>time(),'status'=>0]);
            }else{
                db('history')->insert(['uid'=>$this->uid,'gid'=>$gid,'create_time'=>time()]);
            }
        }catch (\Exception $e){}
    }

    /*
     *  删除历史记录
     */
    public function delHistory()
    {
        $ids = input('ids');
        if(!$ids) return $this->errorJson(400,'缺少参数');
        $res = db('history')->where('id','in',$ids)->where('uid',$this->uid)->delete();
        if($res!==false){
            return $this->errorJson(200,'删除成功');
        }else{
            return $this->errorJson(401,'删除失败');
        }
    }
    /*
     * 用户反馈
     */
    public function feedback()
    {
        $detail = input('detail');
        if(!$detail) return $this->errorJson(400,'参数不正确');
        $res = db('feedback')->insert(['uid'=>$this->uid,'detail'=>$detail,'time'=>time()]);
        if($res){
            return $this->errorJson(200,'反馈成功');
        }else{
            return $this->errorJson(400,'系统繁忙');
        }
    }

    /**
     *  身份认证
     */
    public function identity()
    {
        if(request()->isPost()){
            $front = input('front');
            $back = input('back');
            $realname = input('realname','','htmlspecialchars');
            $card =  input('card');
            if(!$front ||!$back||!$realname ||!$card) return $this->errorJson(400,'缺少参数');
            $result = regex('id_card',$card);
            if(!$result) return $this->errorJson(403,'身份证不合法');
            $authen = db('user')->where('id',$this->uid)->find();
            if($authen['identify'] ==1) return $this->errorJson(503,'不需要重复认证');
            $res = db('user')->where('id',$authen['id'])->update(['real_name'=>$realname,'id_card'=>$card,'id_img_front'=>$front,'id_img_back'=>$back,'identify'=>3]);
            if($res ===false){
                return $this->errorJson(400,'提交失败');
            }else{
                return $this->errorJson(200,'提交成功');
            }
        }else{
            $info = db('user')->field('id,real_name,id_card,id_img_front,id_img_back,identify status')->where('id',$this->uid)->find();
            if($info){
                return json(['code'=>200,'data'=>$info]);
            }else{
                return json(['code'=>402,'msg'=>'暂无数据']);
            }
            
        }
    }

    public function comment()
    {
        $comment = db('comments')->alias('c')
            ->join('__USER__ u','c.uid=u.id')
            ->field('c.gid,c.content,c.time,c.order_id,c.image,u.head_img,u.nickname')
            ->where(['c.uid'=>$this->uid,'c.status'=>1])
            ->order('c.time desc')
            ->select();
        foreach ($comment as $k => $v) {
            $goods= model('Goods')->getGoodsInfo($v['gid']);
            $comment[$k]['title'] = $goods['title'];
            $comment[$k]['img'] = $goods['img_thumb'];
            $comment[$k]['spec_key_name']= db('orderGoods')->where(['order_id'=>$v['order_id'],'goods_id'=>$v['gid']])->value('spec_key_name');
            $comment[$k]['time']=date("Y-m-d H:i:s",$v['time']);
            $comment[$k]['head_img']=$v['head_img']?$v['head_img']:'/static/default_head_image.png';
            $comment[$k]['image']=explode(',',$v['image']);
//            $comment[$k]['type_id'] = $goods['type_id'];
            if($goods['type_id'] == 5){
                $comment[$k]['type']='全新车';
            }elseif($goods['type_id'] == 6){
                $comment[$k]['type']='循环车A类';
            }else{
                $comment[$k]['type']='循环车B类';
            }

        }    
        return json(['code'=>200,'data'=>$comment]);
    }
}