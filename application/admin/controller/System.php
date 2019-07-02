<?php
namespace app\admin\controller;
use app\common\controller\Admin;
use think\Db;
use think\facade\Env;
use think\Loader;
use think\Request;
/**
 * 系统配置
 */
class System extends Admin
{
    /**
     * 系统设置
     */
    public function index(){
        if(request()->isAjax()){
            model('config')->setAll($_POST);
            return json(array('status'=>true,'info'=>'修改成功'));
        }else{
            return view();
        }
    }
    /**
     * 邮箱测试
     * @DateTime 2017-02-10T16:02:54+0800
     * @return   [type]                   [description]
     */
    public function email_test(){
        if(request()->isAjax()){
            $email=input('mail_test');
            $re=sendMail($email,'测试邮件','测试邮件请忽略');
            if($re){
                return json(array('status'=>true,'info'=>'发送成功'));
            }else{
                return json(array('status'=>false,'info'=>'发送失败'));
            }
        }else{
            $this->error('请求错误');
        }
    }

    public function version(){
        $list = db('version')->where($where)->order('create_time desc')->paginate(13);
        $this->assign('list', $list);
        return view();
    }


    /**
     * 版本添加
     * @Author   MSC
     * @DateTime 2017-08-09T16:10:37+0800
     * @return   [type]                   [版本添加]
     */
    public function version_add(){
        // echo "string";exit;
        if(request()->isPost()){
            $version['version_code'] = input('version_code');
            $version['explain'] = input('explain');

            $file = request()->file('download_url');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(Env::get('root_path') . 'public' . DIRECTORY_SEPARATOR . 'uploads/apk');
            $file->rule('md5')->move('/public/uploads/apk/');
            $download_url='/uploads/apk/'.$info->getSaveName();
            //获取上传成功后的安装包的路径
            $version['download_url'] = $download_url;



            $version['create_time'] = time();

            $re = db('version')->insert($version);

            if($re){

                $this->success('版本添加成功');
            }else{
                $this->error('版本添加失败，请重新添加');
            }
        }else{
            return view();
        }
    }


    /**
     * 版本编辑
     * @Author   MSC
     * @DateTime 2017-08-10T12:03:37+0800
     * @return   [type]                   [版本编辑]
     */
    public function version_edit(){
        $id =$_GET['id'];
        if(request()->isPost()){
            $version['version_code'] = input('version_code');
            $version['explain'] = input('explain');
            if($_FILES['download_url_update']['error']!=4){
                $file = request()->file('download_url_update');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/apk');
                $file->rule('md5')->move('/public/uploads/apk/');
                $download_url_update='/uploads/apk/'.$info->getSaveName();

                $version['download_url'] = $download_url_update;
            }else{
                $version['download_url'] = input('download_url');
            }

            $re = Db::name('version')->where(['id'=>$id])->update($version);
            if($re){

                $this->success('更新成功');
            }else{
                $this->error('更新失败，请重新添加');
            }
        }else{
            $list =Db::name('version')->find($id);
            $this->assign('list',$list);

            return view();

        }

    }
    //利率
    public function rate(){
        $type=input('type','1');
        $list=Db::name('rate')->where(['type'=>$type])->order('cycle asc')->select();
        $this->assign('list',$list);
        return view();
    }

    public function rate_add(){
        if(request()->isPost()){
            $data['cycle']=input('cycle');
            $data['rate']=input('rate');
            $data['type']=input('type');
            $data['updata_time']=time();
            $re=Db::name('rate')->insert($data);
            if($re){
                return json(['status'=>true,'info'=>'操作成功']);
            }else{
                return json(['status'=>false,'info'=>'操作失败，请重试']);
            }
        }else{
            return view();
        }
    }


    public function rate_edit(){
        $id=input('id');
        if(request()->isPost()){
            $data['cycle']=input('cycle');
            $data['rate']=input('rate');
            $data['updata_time']=time();
            // var_dump($data);exit;
            $re=Db::name('rate')->where(['id'=>$id])->update($data);
            if($re){
                return json(['status'=>true,'info'=>'操作成功']);
            }else{
                return json(['status'=>false,'info'=>'操作失败，请重试']);
            }
        }else{
            $info=Db::name('rate')->where(['id'=>$id])->find();
            $this->assign('info', $info);
            return view();
        }
    }








}