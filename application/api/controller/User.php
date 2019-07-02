<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/23 19:38
 */
namespace app\api\controller;

use think\facade\Env;
use app\common\controller\Api;

class User extends Api
{
    public function info()
    {
        $res =$this->checkToken("ssssssss");
        echo $res;
        echo Env::get('runtime_path');
        //return json(['code'=>200,'msg'=>'success','data'=>'']);
    }

    /*
     *      用户注册
     */
    public function register()
    {
        $this->checkToken();
        $phone = input('phone');
        $code = input('code');
        $password = input('password','','trim');
        if(!$phone || !$code ||!$password) return $this->errorJson(400,'参数有误');
        $res  = model('MobileCode')->checkCode($phone,$code,1);
        if($res['code'] != 200){
            return json($res);
        }
        $result = model('user')->wxBindPhone($phone,$password,$this->uid);
        return $result;
    }

    /*
     *      用户登录
     */
    public function login()
    {
        $username = input('phone','','trim');
        $password = input('password','','trim');
        if($username==''||$password==''){
            return $this->errorJson(400,'参数有误');
        }
        $res =model('user')->login($username,$password);
        return json($res);
    }
    /*
     *  退出
     */
    public function logout()
    {
        $token = input('token');
        $res = model('user')->logout(1);
        return json($res);

    }
    /*
     *   忘记密码
     */
    public function forgetPassword()
    {
        $phone = input('phone');
        $code = input('code');
        $password= input('password');
        $repassword= input('repassword');
        if(!$phone || !$code ||!$password||!$repassword) return $this->errorJson(400,'参数有误');
        if($password !=$repassword) return $this->errorJson(400,'密码不一致');
        $checkCode = model('MobileCode')->checkCode($phone,$code,2);
        if($checkCode['code'] != 200) return $checkCode;
        try{
            db('user')->where('phone',$phone)->setField('password',strongmd5($password));
            return $this->errorJson(200,'修改成功');
        }catch (\Exception $e){
            return $this->errorJson(400,'修改失败');
        }
    }

    /**
     *   微信登录
     */
    public function wxLogin()
    {
        $url  ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".config('appid')."&redirect_uri=http://".$_SERVER['HTTP_HOST']."/api/User/wxstart&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
//        $url  ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".config('appid')."&redirect_uri=http://".$_SERVER['HTTP_HOST']."/api/User/wxstart&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header("location: $url");
        exit;
    }

    public function wxstart()
    {
        $code = input('code');
        if(!$code) return json(['code'=>400,'msg'=>'请求错误']);
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".config('appid')."&secret=".config('appsecret')."&code=".$code."&grant_type=authorization_code";
        $data  = http_get($url);
//        $data = '{"access_token":"6__6WFZnMUhh4T8j_xLFyZg-JAZmdMKsA60j0Zx6S9gf4c9Os6Na6B4OAaR_4Cub7uE7Fp9xig84pvGVV4nzfIyYCvgpxVaeD3ZVVRD9m2Rgo","expires_in":7200,"refresh_token":"6_R3I6Bbr84jfDUvnNK0cJ8rz8U1B8EAocoEsAzb2qsUwA1H3ovOxMxelVx4OJLHBkwZxcOg7KBqzRXur_haVBx9H-J4IMcJuikJR5kBZCqhI","openid":"obHfFwCMvRFbt7xkjzNSWH84J3oY","scope":"snsapi_userinfo"}';
        $params = json_decode($data,true);
        if(!empty($params['errcode'])){
            echo "<h3>error:</h3>".$params['errcode'];
            echo "<h3>msg:</h3>".$params['errmsg'];
            exit;
        }
        if(empty($params['openid'])){
            echo "登录失败";
            exit;
        }
        $userinfo = db('user')->field('id,phone,open_id')->where('open_id',$params['openid'])->find();
        if($userinfo){
            $t= createToken(['uid'=>$userinfo['id'],'username'=>$userinfo['phone']]);
            db('user')->where('id',$userinfo['id'])->setField('token', $t);
            $phone=$userinfo['phone']?200:400;
            header("location: http://ytshop.hulupi.com/login?token=$t&uid={$userinfo['id']}&code=$phone");
//            header("location: http://localhost:8101/login?token=$t&uid={$userinfo['id']}&code=$phone");
            exit;
            // return json(['msg'=>'登录成功！','code'=>200,'data'=>['token'=>$t,'uid'=>$userinfo['id'],'phone'=>$phone]]);
        }else{
            $userArr = $this->checkAccessToken($params['access_token'],$params['openid']);
            $userArr['create_time'] = time();
            $uid =db('user')->insertGetId($userArr);
            if($uid){
                $t= createToken(['uid'=>$uid,'username'=>'']);
                db('user')->where(['id'=>$uid])->setField('token', $t);
                header("location: http://ytshop.hulupi.com/login?token=$t&uid=$uid&code=400");
                exit;
                // return json(['msg'=>'登录成功！','code'=>200,'data'=>['token'=>$t,'uid'=>$uid,'phone'=>false]]);
            }
        }
    }

    /*
     *  拉取用户信息(需scope为 snsapi_userinfo)
     */
    private function getWxUserInfo($accessToken)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$accessToken."&openid=".config('appid')."&lang=zh_CN";
        $str = http_get($url);
        $params = json_decode($str,true);
        if(!empty($params['errcode'])){
            echo "<h3>error:</h3>".$params['errcode'];
            echo "<h3>msg:</h3>".$params['errmsg'];
            exit;
        }
        $data['open_id'] = $params['openid'];
        $data['nickname'] = $params['nickname'];
        $data['sex'] = $params['sex'];
        $data['address'] = $params['country'].$params['province'].$params['city'];
        $data['head_img'] = getImage($params['headimgurl'],'wxheadimg');
        return $data;
    }

    /*
     *  检验授权凭证（access_token）是否有效
     */
    private function checkAccessToken($accessToken,$openid){
        $url = "https://api.weixin.qq.com/sns/auth?access_token=".$accessToken."&openid=".$openid;
        $checkStr = http_get($url);
        $params = json_decode($checkStr,true);
        if($params['errcode']==0){
            return $this->getWxUserInfo($accessToken);
        }else{
            echo "access_token已失效,请重新登录!";exit;
        }
    }
}