<?php
namespace app\admin\controller;
use app\common\controller\Admin;
use think\facade\Env;
use think\Image;
use think\Loader;
use think\Request;
use think\Db;
/**
 * 后台首页及公共
 */
class Index extends Admin
{
    /**
     * 后台登录首页
     */
    public function index(){
        $sys_info=$this->sys_info();
        $this->assign('sys_info', $sys_info);
        $list = Db::name('log')->order('create_time desc')->paginate(10);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        // 渲染模板输出
        return view();
    }

    public function demo(){
        $list=model('region')->getArea(100000);
        $this->assign('list', $list);
        // var_dump($list);exit();
        return view();
    }
    /**
     * 系统信息
     * @return   [type]                   [description]
     */
    public function sys_info(){
        // mysql_connect("localhost", "mysql_user", "mysql_pass");
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            '主机名'=>$_SERVER['SERVER_NAME'],
            'PHP版本'=>PHP_VERSION,
            // '数据库版本'=>mysql_get_server_info(),
            'WEB服务端口'=>$_SERVER['SERVER_PORT'],
            '网站文档目录'=>$_SERVER["DOCUMENT_ROOT"],
            '浏览器信息'=>substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            '通信协议'=>$_SERVER['SERVER_PROTOCOL'],
            '请求方法'=>$_SERVER['REQUEST_METHOD'],
            'ThinkPHP版本'=>5.1,
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '用户的IP地址'=>$_SERVER['REMOTE_ADDR'],
            '剩余空间'=>round((disk_free_space(".")/(1024*1024)),2).'M',
        );
        return $info;
    }

    /**
     * 公共删除/禁用/启用操作
     * @return   [type]                   [description]
     */
    public function do_del(){
        if(request()->isAjax()){
            $id=input('id','','intval');
            $db=input('db');
            $index=input('index');
            $field=input('field');
            $status=input('status','-1','intval');
            $re=db($db)->where($index,$id)->setField($field,$status);
            // var_dump($re);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功！'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败！'));
            }
        }
    }

    public function do_del1(){
        if(request()->isAjax()){
            $id=input('id','','intval');
            $db=input('db');
            $index=input('index');
            $field=input('field');
            $is_del=input('is_del','0','intval');
            $re=db($db)->where($index,$id)->setField($field,$is_del);
            // var_dump($re);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功！'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败！'));
            }
        }
    }
    /**
     * 公共多选删除/禁用/启用操作
     * @return   [type]                   [description]
     */
    public function do_del_all(){
        if(request()->isAjax()){
            $id=input('id');
            $db=input('db');
            $status=input('status','-1','intval');
            $re=db($db)->where('id','in',$id)->setField('status',$status);
            if($re!==false){
                return json(array('status'=>true,'info'=>'操作成功！'));
            }else{
                return json(array('status'=>false,'info'=>'操作失败！'));
            }
        }
    }


    /**
     * 后台文件上传
     * @return   [type]                   [description]
     */
    public function upload(){
        $folder=input('folder')?'/'.input('folder'):'/file';
        $file_name=array_keys($_FILES);
        $file = request()->file($file_name[0]);
        $info = $file->move(Env::get('root_path') . 'public' . DIRECTORY_SEPARATOR . 'uploads'.$folder);
        if($info){
            $url='/uploads'.$folder.'/'.$info->getSaveName();
            return json(array('status'=>true,'url'=>$url));
        }else{
            // 上传失败获取错误信息
            return json(array('status'=>false,'info'=>$file->getError()));
        }
    }

    public function crop(){
        $x=input('x');
        $y=input('y');
        $w=input('w');
        $h=input('h');
        $file_name=array_keys($_FILES);
        $file = request()->file($file_name[0]);
        $folder='/head_img';
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(Env::get('root_path') . 'public' . DIRECTORY_SEPARATOR . 'uploads'.$folder);
        $img_name='/uploads'.$folder.'/'.$info->getSaveName();
        $image = \think\Image::open('.'.$img_name);
        //将图片裁剪为300x300并保存为crop.png
        $image->crop($w, $h,$x,$y,290,290)->save('.'.$img_name);
        if($info){
            return json(array('status'=>true,'info'=>$img_name));
        }else{
            // 上传失败获取错误信息
            return json(array('status'=>false,'info'=>$file->getError()));
        }

    }

    public function getArea(){
        $parentCode=input('parentCode');
        $list=model('region')->getArea($parentCode);
        return json($list);
    }

    //清除缓存
    public function clearCache(){
        $dir = Env::get('runtime_path');
        deleteDir($dir.'/temp');
        deleteDir($dir.'/log');
//        deleteDir($dir.'/system');
         deleteDir($dir.'/cache');
        return ['status'=>true,'info'=>'清除成功'];
    }
}