<?php
/**
 * Created by PhpStorm.
 * User: stlhtech
 * Date: 2018/1/10
 * Time: 17:21
 */

namespace app\common\Controller;
use think\Controller;
use think\Request;

class Common extends Controller
{

    function initialize()
    {
        $config = $this->getConfig();
        $this->config = $config;
        $this->assign('config', $config);
    }

    /**
     * 网站配置
     * @Author   jiayangyang
     * @DateTime 2017-03-22T14:49:32+0800
     * @return   [type]                   [description]
     */
    public function getConfig()
    {
        $site_cionfig = array(
            'site_name' => '',
            'site_title' => '',
            'site_keywords' => '',
            'site_description' => '',
            'site_close' => '',
            'site_logo' => '',
            'site_icp' => '',
            'site_tongji' => '',
            'site_copyright' => '',
            'site_co_name' => '',
            'site_address' => '',
            'site_tel' => '',
            'site_admin_email' => '',
            'site_qq' => '',
            'project_introduce' => '',
            'mail_smtp' => '',
            'mail_port' => '',
            'mail_sender' => '',
            'mail_address' => '',
            'mail_account' => '',
            'mail_password' => '',
        );
        $config = cache('config');
        if (!$config) {
            $array = db('Config')->select();
            $config = array();
            foreach ($array as $re) {
                $config[$re['k']] = $re['v'];
            }
            cache('config', $config);
        }
        $config = array_merge($site_cionfig, $config);
        return $config;
    }
}