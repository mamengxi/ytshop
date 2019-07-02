<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/24 17:17
 */
namespace app\common\model;

use think\Model;

class MobileCode extends Model
{
    /**
     *  发送短信
     * @param $mobile
     * @param $type [1注册 2修改/找回密码 3绑定手机号码 4验证码登录 5修改手机号码 6 设置支付密码 7找回支付密码]
     * @return array|mixed
     */
    public function sendCode($mobile,$type)
    {
        if(!$type || !$mobile){
            return ['code'=>400,'msg'=>'参数不正确'];
        }
        if(!preg_match("/^1[3456789]\d{9}$/", $mobile)){
            return ['msg'=>'手机号码格式不正确','code'=>400];
        }
        $isRegist = db('user')->where('phone',$mobile)->value('phone');
        switch ($type){
            case 1:
                if($isRegist) return ['code'=>400,'msg'=>'手机号码已被注册'];
                break;
            case 2:
                if(!$isRegist) return ['code'=>400,'msg'=>'手机号码未注册'];
                break;
            case 3:
                if($isRegist) return ['code'=>400,'msg'=>'手机号码已绑定其他账号'];
                break;
            case 4:
                if(!$isRegist) return ['code'=>400,'msg'=>'手机号码不存在'];
                break;
            case 5:
                if($isRegist) return ['code'=>400,'msg'=>'手机号码已绑定其他账号'];
                break;
            case 6:
                if(!$isRegist) return ['code'=>400,'msg'=>'手机号码不存在'];
                break;
            case 7:
                if(!$isRegist) return ['code'=>400,'msg'=>'手机号码不存在'];
                break;
            default:
                return ['code'=>400,'msg'=>'参数类型不对'];
                break;
        }
        $data['mobile'] = $mobile;
        $data['type'] = $type;
        $data['add_time'] = ['add_time','gt',time() -60];
        $count = $this->where($data)->count();
        if($count) return ['code'=>400,'msg'=>'验证码1分钟内只能发送一次'];
        $data['code'] = mt_rand(100000,999999);
        $data['add_time'] =time();
        $res = $this->insert($data);
        if($res){
            return ['msg'=>'验证短信发送成功','code'=>200,'data'=>['code'=>$data['code']]];
        }else{
            return ['msg'=>'验证短信发送失败','code'=>404];
        }
    }

    /**
     * @param $mobile
     * @param $code
     * @param $type
     * @return array
     */
    public function checkCode($mobile,$code,$type)
    {
        if(!$mobile ||!$code ||!$type) return ['code'=>400,'msg'=>'缺少参数'];
        if(!($code >= 100000 && $code <= 999999)) return ['code'=>400,'msg'=>'验证码不正确'];
        if(!preg_match("/^1[3456789]\d{9}$/", $mobile)) return ['code'=>400,'msg'=>'手机号码不正确'];
        $res = $this->where(['mobile'=>$mobile,'type'=>$type])->field('id,code,add_time')->order('add_time desc')->find();
        if(!$res) return ['code'=>400,'msg'=>'请先获取验证码'];
        if($res['add_time'] +10*60 <time()) return ['msg'=>'验证码已经过期','code'=>400];
        if($res['code'] != $code) return ['code'=>400,'msg'=>'验证码错误'];
        return ['msg'=>'验证码正确','code'=>200];
    }
}