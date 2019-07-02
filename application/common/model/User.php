<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/15
 * Time: 18:15
 */

namespace app\common\model;
use think\Db;
use think\Model;
use app\common\validate\User as UserValidate;

class User extends Model{
    /**
     *  后台 添加/修改用户
     */
    public function addUser(){
        $id=input('id',0,'intval');
        $data['nickname']=input('nickname');
        $data['password']=strongmd5(input('password'));
        $data['real_name']=input('real_name');
        $data['head_img']=input('head_img');
        $data['sex']=input('sex');
        $data['phone']=input('phone');
        $data['id_card']=input('id_card');
        $data['email']=input('email');
        $data['address']=input('address');
        $data['id_img_front']=input('id_img_front');
        $data['id_img_back']=input('id_img_back');
        $data['status']=input('status');
//        var_dump($data);exit;
        if($id){
            $re=Db::name('user')->where(['id'=>$id])->update($data);
            if($re){
                return ['status'=>true,'msg'=>'操作成功','code'=>200];
            }else{
                return ['status'=>false,'msg'=>'操作失败','code'=>400];
            }
        }else{
            $data['create_time']=time();
//            $validate = new \app\common\validate\User;
            $validate=validate('User');
            if(!$validate->check($data)){
                return ['status'=>false,'msg'=>$validate->getError(),'code'=>400];
            }
            $re=$this->insert($data);
            if($re){
                return ['status'=>true,'msg'=>'操作成功','code'=>200];
            }else{
                return ['status'=>false,'msg'=>'操作失败','code'=>400];
            }
        }
    }

    /**
     *  手机号快速注册
     * @param    [type]                   $username [用户名]
     * @param    [type]                   $password [密码]
     * @return   [type]                             [description]
     */
    public function register($phone,$password,$uid){
        // var_dump($uid);exit;
        $data['phone']=$phone;
        $data['nickname']='yt_'.safePhone($phone);

        $validate = new UserValidate();
        if(!$validate->scene('quickreister')->check($data)){
            return ['code'=>400,'msg'=>$validate->getError()];
        }
        $data['create_time']=time();
        $data['password']=strongmd5($password);
        try{
            $re = Db::name('user')->where('id',$uid)->update($data);
            $t= createToken(['uid'=>$uid,'username'=>$phone]);
            return ['msg'=>'绑定成功！','code'=>200,'data'=>['token'=>$t,'uid'=>$uid]];
        }catch (\Exception $e){
            return ['msg'=>'绑定失败！','code'=>400];
        }
    }

    /**
     * 找回密码
     * @param    [type]                   $phone    [手机号]
     * @param    [type]                   $password [密码]
     * @param    [type]                   $code 	[验证码]
     * @return   [type]                             [description]
     */
    public function forgetPassword($phone,$password,$code){
        if(!preg_match("/^1[3456789]\d{9}$/", $phone)){
            return ['status'=>false,'msg'=>'请填写正确的手机号','code'=>400];
        }
        $result=model('MobileCheckCode')->checkCode($phone,$code,2);
        if(!$result['status']){
            return $result;
        }else{
            $re=Db::name('user')->where(['phone'=>$phone])->setField('password', strongmd5($password));
            if($re!==false){
                return ['status'=>true,'msg'=>'重置密码成功！','code'=>200];
            }else{
                return ['status'=>false,'msg'=>'重置密码失败！','code'=>400];
            }
        }
    }
    /**
     * 修改密码
     * @param    [type]                   $uid         [用户id]
     * @param    [type]                   $password    [新密码]
     * @param    [type]                   $oldPassword [旧密码]
     * @return   [type]                                [description]
     */
    public function changePassword($uid,$password,$oldPassword){
        if(strlen($password)<6){
            return ['status'=>false,'msg'=>'密码长度小于6位！','code'=>400];
        }
        if($password==$oldPassword){
            return ['status'=>false,'msg'=>'新密码和旧密码不能相同！','code'=>400];
        }
        $re=Db::name('user')->where(['id'=>$uid,'password'=>strongmd5($oldPassword)])->find();
        if(!$re){
            return ['status'=>false,'msg'=>'旧密码错误！','code'=>400];
        }else{
            $result=Db::name('user')->where(['id'=>$uid])->setField('password', strongmd5($password));
            if($result){
                return ['status'=>true,'msg'=>'修改密码成功！','code'=>200];
            }else{
                return ['status'=>false,'msg'=>'修改密码失败！','code'=>400];
            }
        }
    }
    /**
     * 找回支付密码
     * @Author   JYY
     * @DateTime 2017-06-03T15:11:44+0800
     * @param    [type]                   $uid          [用户id]
     * @param    [type]                   $code         [验证码]
     * @param    [type]                   $pay_password [支付密码]
     * @return   [type]                                 [description]
     */
    public function forgetPayPassword($uid,$code,$pay_password){
        $user=Db::name('user')->where('id', $uid)->find();
        if(strlen($pay_password)<6){
            return ['status'=>false,'msg'=>'密码长度小于6位！','code'=>400];
        }
        $result=model('MobileCheckCode')->checkCode($user['phone'],$code,6);
        if(!$result['status']){
            return $result;
        }else{
            $re=Db::name('user')->where('id', $uid)->setField('pay_password', strongmd5($pay_password));
            if($re!==false){
                return ['status'=>true,'msg'=>'设置成功','code'=>200];
            }else{
                return ['status'=>false,'msg'=>'设置失败','code'=>400];
            }
        }
    }

    /**
     *      登录
     * @param    [type]                   $phone    [手机号]
     * @param    [type]                   $password [密码]
     * @return   [type]                             [description]
     */
    public function login($phone,$password){
        $re=Db::name('user')->where(['phone'=>$phone,'password'=>strongmd5($password)])->find();
        if($re){
            $t= createToken(['uid'=>$re['id'],'username'=>$re['phone']]);
            Db::name('user')->where(['phone'=>$phone])->setField('token', $t);
            return ['msg'=>'登录成功！','code'=>200,'data'=>['token'=>$t,'uid'=>$re['id']]];
        }else{
            return ['msg'=>'账号或密码错误！','code'=>400];
        }
    }
    /**
     * 微信登录
     * @param    [type]                   $open_id [微信iopen_id]
     * @param    [type]                   $device_type [设备类型 1.pc ;2.app]
     */
    public function wxLogin($open_id,$device_type=1){
        if(!$open_id){
            return ['status'=>false,'msg'=>'请绑定手机号','code'=>400];
        }
        $re=Db::name('user')->where('open_id', $open_id)->find();
        if($re){
            $t= get_login_token(['uid'=>$re['id'],'username'=>$re['username']]);
            if($device_type==2){
                $token=Db::name('user')->where('open_id', $open_id)->setField('token', $t);
                $key_name = md5($re['id'] . '_app_userlogin'); //@缓存暂时键名
                cache($key_name,null);
                cache($key_name, $t);
                return ['status'=>true,'msg'=>'登录成功！','code'=>200,'data'=>['token'=>$t]];
            }else{
                cookie('token', $t);
                return ['status'=>true,'msg'=>'登录成功！','code'=>200];
            }
        }else{
            return ['status'=>false,'msg'=>'请绑定手机号','code'=>400];
        }
    }


    /**
     * 微信绑定账号
     * @DateTime 2017-07-20T14:32:16+0800
     * @param    [string]                   $phone    [手机号]
     * @param    [string]                   $password [密码]
     * @param    [string]                   $open_id  [微信open_id]
     */
    public function wxBinding($phone,$password,$open_id){
        if(!$phone||!$password||!$open_id){
            return ['status'=>false,'msg'=>'参数错误','code'=>400];
        }
        $info=Db::name('user')->where(['phone'=>$phone,'password'=>strongmd5($password)])->find();
        if($info){

            $re=Db::name('user')->where(['id'=>$info['id']])->setField('open_id', $open_id);

            if($re){
                $t= get_login_token(['uid'=>$info['id'],'username'=>$info['username']]);
                $token=Db::name('user')->where('id', $info['id'])->setField('token', $t);
                return ['status'=>true,'msg'=>'绑定成功！','code'=>200,'data'=>['token'=>$t,'uid'=>$info['id']]];
            }else{
                return ['status'=>false,'msg'=>'绑定失败，请重试','code'=>400];
            }
        }else{
            return ['status'=>false,'msg'=>'账号或密码错误！','code'=>400];
        }
    }

    public function wxBindPhone($phone,$password,$uid)
    {
        if(!$phone||!$password||!$uid){
            return ['msg'=>'参数错误','code'=>400];
        }
        $res= db('user')->where('id',$uid)->setField(['phone'=>$phone,'password'=>strongmd5($password)]);
        if($res){
            return ['msg'=>'绑定成功','code'=>200];
        }else{
            return ['msg'=>'绑定失败','code'=>400];
        }
    }
    /**
     * 退出登录
     * @Author   JYY
     * @DateTime 2017-05-19T17:58:39+0800
     * @param    [type]                   $uid         [description]
     * @param    integer                  $device_type [description]
     * @return   [type]                                [description]
     */
    public function logout($uid){
        try{
            db('user')->where('id',$uid)->setField('token',null);
            return ['msg'=>'账号己退出', 'code' => 200];
        }catch (\Exception $e){
            return ['msg'=>'账号退出失败', 'code' => 400];
        }
    }

    /**
     * 昵称修改
     * @DateTime 2017-05-19T17:10:25+0800
     * @param    [type]                   $uid [用户id]
     * @return   [type]                   $nickname  [用户昵称]
     */
    public function apinickName($uid,$nickname){
        $is_register=Db::name('user')->where(['nickname'=>$nickname])->count();
        if($is_register){
            return ['status'=>false,'msg'=>'昵称已存在！','code'=>400];
        }
        $list=Db::name('user')->where('id',$uid)->update(['nickname'=>$nickname]);
        if($list){
            return ['status'=>true,'msg'=>'修改成功！','code'=>200];
        }else{
            return ['status'=>false,'msg'=>'修改失败！','code'=>400];
        }
    }

    /**
     * 换绑手机号
     * @param    [type]                   $uid [用户id]
     * @return   [type]                   $phone     [用户电话]
     * @return   [type]                   $password     [用户密码]
     * @return   [type]                   $checkcode     [验证码]
     */
    public function apiphone($password,$phone,$code,$uid){

        $row=Db::name('user')->field('password')->where('id',$uid)->find();
        if(strongmd5($password)!==$row['password']){
            return ['status'=>false,'msg'=>'密码错误！','code'=>400];
        }

        $result=model('MobileCheckCode')->checkCode($phone,$code,3);

        if($result['status']==true){
            $list=Db::name('user')->where('id',$uid)->update(['phone' => $phone]);
            if($list){
                return ['status'=>true,'msg'=>'更新绑定成功！','code'=>200];
            }else{
                return ['status'=>false,'msg'=>'更新绑定失败！','code'=>400];
            }
        }else{
            return $result;
        }
    }

}