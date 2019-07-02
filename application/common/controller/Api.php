<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/23 16:32
 */
namespace app\common\controller;

use think\Controller;
use think\facade\Log;

class Api extends Controller
{
    protected  $appid=1529132323;

    protected $uid;

    public function initialize()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
//        if(!request()->isAjax()){
//            echo json_encode(['code'=>400,'msg'=>'请求错误']);exit;
//        }
    }

    protected function geOpenId()
    {
        if(!$this->uid) return false;
        return db('user')->where('id',$this->uid)->value('open_id');
    }

    /*
     *   获取默认地址 如果没有默认地址就返回第一个
     */
    public function getCheckAddress()
    {
        $list = db('address')->field('id,phone,province,city,area,detail,username')->where(['uid'=>$this->uid,'status'=>1,'is_check'=>1])->find();
        if(!$list){
            $list = db('address')->field('id,phone,province,city,area,detail,username')->where(['uid'=>$this->uid,'status'=>1])->find();
            $list = $list?$list:false;
        }
        return $list;
    }
    /**
     * 验证签名
     * @param $token
     * @return mixed
     */
    protected function checkToken(){
        $token = input('token');
        if(!$token) {
            echo json_encode(['code'=>123456,'msg'=>'没有登录']);exit;
//            return json_encode(['code'=>123456,'msg'=>'没有登录']);
        }
        if(request()->isPost()){
            $res = checkToken($token); //get 请求
        }else{
            $res = checkToken(urlencode($token)); //get 请求
        }
        if($res['code'] ==200)
        {
            $this->uid = $res['uid'];
        }
    }

    protected function  errorJson($code,$msg){
        return json(['code'=>$code,'msg'=>$msg]);
    }

    protected function trueOrFalse($res,$success,$error){
        if($res){
            return $this->errorJson(200,$success);
        }else{
            return $this->errorJson(400,$error);
        }
    }

    protected function saveBase64($base64){
        $image="";
        foreach (explode('#####', $base64) as $k => $v) {
            $re=base64_to_img($v);
            $image.=$re.',';
        }
        $image=trim($image,',');
        return $image;
    }
}