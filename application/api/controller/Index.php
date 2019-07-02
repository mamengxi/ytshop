<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/24 17:15
 */
namespace app\api\controller;

use app\common\controller\Api;
use think\facade\Env;
class Index extends Api
{
    /**
     *  发送验证码
     */
    public function sendCode()
    {
        $phone = input('phone','','intval');
        $type = input('type','','intval');
        if(!$phone || !$type) return $this->errorJson(400,'参数不对');
        $res = model('MobileCode')->sendCode($phone,$type);
        return $res;
    }
    
    /*
     * 校验 验证码
     */
    public function checkCode()
    {
        $phone = input('phone','','intval');
        $code = input('code');
        $type = input('type','','intval');
        if(!$phone || $code || !$type) return $this->errorJson(400,'参数不对');
        $res =  model('MobileCode')->checkCode($phone,$code,$type);
        return $res;
    }


    public function test(){
        $data = array();
        $data['out_trade_no'] ='YT2018032297505497';
        $data['refund_fee'] =1; //要退金额
        $data['total_fee'] =1; // 用户支付的实际金额
        $arr = \WxPayApi::wxRefund($data);
        if($arr ==false) return json(['code'=>200,'msg'=>'退款失败']);
        if($arr['result_code'] ==='SUCCESS')
        {
            // 根据订单号 $arr['out_trade_no']   == orders 表中的【order_sn】 字段  得到order_id
            //1.修改订单状态为已退款   order_status
            //2、order_action  记录操作
            //  写入退款申请表
        }
        var_dump($arr);
    }

    /*
     *    文件上传
     */
    public function upload()
    {
        $folder=input('folder')?'/'.input('folder'):'/file';
        $file_name=array_keys($_FILES);
        $file = request()->file($file_name[0]);
        if($file ==null) return json(['code'=>400,'msg'=>'文件最大只能上传8M']);
        $info = $file->move(Env::get('root_path') . 'public' . DIRECTORY_SEPARATOR . 'uploads'.$folder);
        if($info){
            $url='/uploads'.$folder.'/'.$info->getSaveName();
            return json(['code'=>200,'msg'=>'上传成功','data'=>$url]);
        }else{
            // 上传失败获取错误信息
            return json(['code'=>400,'msg'=>$file->getError()]);
        }
    }
    /**
     * 缩略图
     * @Author   JYY
     * @DateTime 2018-02-02T17:26:51+0800
     * @return   [type]                   [description]
     */
    public function thumb(){
        $Timthumb= new \Timthumb();
    }
    /**
     * base64转图片
     * @Author   JYY
     * @DateTime 2018-02-05T15:22:52+0800
     * @return   [type]                   [description]
     */
    public function base64ToImg(){
        $base64=input('base64');
        $re=base64_to_img($base64);
        return json(['code'=>200,'data'=>$re]);
    }

    public function miss()
    {
        return $this->errorJson('403','找不到路由');
    }
}