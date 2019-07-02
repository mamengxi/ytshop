<?php /*a:2:{s:61:"/home/wwwroot/ytshop/application/admin/view/system/index.html";i:1524556537;s:60:"/home/wwwroot/ytshop/application/admin/view/public/base.html";i:1523434691;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>网站管理后台</title>
    <link href="/static/admin/nifty/css/bootstrap.css" rel="stylesheet">
    <link href="/static/admin/nifty/css/nifty.css" rel="stylesheet">
    <link href="/static/admin/lib/font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">
    <link href="/static/admin/nifty/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="/static/admin/nifty/plugins/pace/pace.min.js"></script>
    <script src="/static/admin/nifty/js/jquery-2.2.4.min.js"></script>
    <script src="/static/admin/nifty/js/bootstrap.min.js"></script>
    <script src="/static/admin/nifty/js/nifty.js"></script>
    <script src="/static/admin/lib/city/area.js"></script>
    <script src="/static/admin/lib/city/city.js"></script>
    <script src="/static/admin/lib/layui/layui.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="/static/admin/lib/layui/css/layui.css?__v=1477903794767"  media="all">
    <script src="/static/admin/js/common.js?__v=1477903794749" type="text/javascript"></script>

</head>
<body>
<div id="container" class="effect aside-float aside-bright mainnav-lg easeOutBack">
    <header id="navbar">
        <div id="navbar-container" class="boxed">
            <div class="navbar-header">
                <a href="index.html" class="navbar-brand">
                    <img src="/static/admin/nifty/img/logo.png" alt="Nifty Logo" class="brand-icon">
                    <div class="brand-title">
                        <span class="brand-text">Nifty</span>
                    </div>
                </a>
            </div>
            <div class="navbar-content clearfix">
                <ul class="nav navbar-top-links pull-left">
                    <li class="tgl-menu-btn">
                        <a class="mainnav-toggle" href="#">
                            <i class="fa fa-navicon"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge badge-header badge-danger"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md">
                            <div class="pad-all bord-btm">
                                <p class="text-semibold text-main mar-no">You have 9 notifications.</p>
                            </div>
                            <div class="nano scrollable">
                                <div class="nano-content">
                                    <ul class="head-list">
                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <p class="pull-left">Database Repair</p>
                                                    <p class="pull-right">70%</p>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div style="width: 70%;" class="progress-bar">
                                                        <span class="sr-only">70% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <p class="pull-left">Upgrade Progress</p>
                                                    <p class="pull-right">10%</p>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div style="width: 10%;" class="progress-bar progress-bar-warning">
                                                        <span class="sr-only">10% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <span class="badge badge-success pull-right">90%</span>
                                                <div class="media-left">
                                                    <i class="demo-pli-data-settings icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">HDD is full</div>
                                                    <small class="text-muted">50 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <i class="demo-pli-file-edit icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">Write a news article</div>
                                                    <small class="text-muted">Last Update 8 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <span class="label label-danger pull-right">New</span>
                                                <div class="media-left">
                                                    <i class="demo-pli-speech-bubble-7 icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">Comment Sorting</div>
                                                    <small class="text-muted">Last Update 8 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <i class="demo-pli-add-user-plus-star icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">New User Registered</div>
                                                    <small class="text-muted">4 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="bg-gray">
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <img class="img-circle img-sm" alt="Profile Picture" src="/static/admin/nifty/img/profile-photos/9.png">
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">Lucy sent you a message</div>
                                                    <small class="text-muted">30 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="bg-gray">
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <img class="img-circle img-sm" alt="Profile Picture" src="/static/admin/nifty/img/profile-photos/3.png">
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">Jackson sent you a message</div>
                                                    <small class="text-muted">40 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="pad-all bord-top">
                                <a href="#" class="btn-link text-dark box-block">
                                    <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Notifications
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-top-links pull-right">

                    <li class="mega-dropdown">
                        <a title="网站首页" href="/" target="_blank">
                            <i class="fa fa-send-o"></i> 网站首页
                        </a>
                    </li>
                    <li id="dropdown-user" class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                            <i class="fa fa-user-o"></i>
                            <?php echo htmlentities($admin_username); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">
                            <div class="pad-all bord-btm">
                                <p class="text-main mar-btm"><span class="text-bold">750GB</span> of 1,000GB Used</p>
                                <div class="progress progress-sm">
                                    <div class="progress-bar" style="width: 70%;">
                                        <span class="sr-only">70%</span>
                                    </div>
                                </div>
                            </div>
                            <ul class="head-list">
                                <li>
                                    <a href="#">
                                        <span class="badge badge-danger pull-right">9</span>
                                        <i class="fa fa-envelope-o"></i> 消息
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-success pull-right">New</span>
                                        <i class="fa fa-cog"></i> 设置
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa fa-exclamation-circle"></i> 帮助
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-tv"></i> 锁定桌面
                                    </a>
                                </li>
                            </ul>
                            <div class="pad-all text-right">
                                <a href="<?php echo url('/admin/Login/logout'); ?>" class="btn btn-primary">
                                    <i class="fa fa-sign-out"></i> 退出
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a  href="javascript:cache()">
                            <i class="fa fa-trash-o"></i>
                            清除缓存
                        </a>
                    </li>
                    <li>
                        <a  href="<?php echo url('/admin/Login/logout'); ?>">
                            <i class="fa fa-sign-out"></i>
                            退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="boxed">
        <div id="content-container">
            <div id="page-title">
                <!--<ol class="breadcrumb"></ol>-->
                <!--<div class="searchbox">-->
                    <!--<div class="input-group custom-search-form">-->
                        <!--<input type="text" class="form-control" placeholder="Search..">-->
                            <!--<span class="input-group-btn">-->
                                <!--<button class="text-muted" type="button"><i class="fa fa-search"></i></button>-->
                            <!--</span>-->
                    <!--</div>-->
                <!--</div>-->
            </div>
            <div id="page-content">
                
<div class="row">
    <div class="col-sm-12">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>系统设置</legend>
        </fieldset>
        <div class="layui-tab layui-tab-brief">
            <ul class="layui-tab-title">
                <li class="layui-this">基本设置</li>
                <li class="pay">支付方式</li>
                <li class="pay">物流方式</li>
                <li class="pay">短信平台设置</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="row panel-body">
                        <form class="layui-form form-horizontal col-sm-6" action="">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">公司名称</label>
                                <div class="col-sm-9">
                                    <input type="text" name="company" lay-verify="required" autocomplete="off" placeholder="请输入内容" class="form-control" value="<?php echo htmlentities((isset($config['company']) && ($config['company'] !== '')?$config['company']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">网站名称</label>
                                <div class="col-sm-9">
                                    <input type="text" name="site_name" lay-verify="required" autocomplete="off" placeholder="请输入标题" class="form-control" value="<?php echo htmlentities((isset($config['site_name']) && ($config['site_name'] !== '')?$config['site_name']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">网站标题</label>
                                <div class="col-sm-9">
                                    <input type="text" name="site_title" lay-verify="required" autocomplete="off" placeholder="请输入标题" class="form-control" value="<?php echo htmlentities((isset($config['site_title']) && ($config['site_title'] !== '')?$config['site_title']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">微信公众号</label>
                                <div class="col-sm-9">
                                    <input type="text" name="qr_num" lay-verify="required" autocomplete="off" placeholder="请输入公众号" class="form-control" value="<?php echo htmlentities((isset($config['qr_num']) && ($config['qr_num'] !== '')?$config['qr_num']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">公众号二维码</label>
                                <div class="col-sm-9">
                                    <button type="button" class="btn btn-primary btn-file j-upload-one"  lay-data="{data:{name: 'qrcode', folder: 'shop'}}"></i><i class="fa fa-folder-open-o"></i>&nbsp;上传二维码图片...</button>
                                    <div class="file-list clearfix">
                                        <ul>
                                            <li><img src="<?php echo htmlentities($config['qrcode']); ?>"/></li>
                                        </ul>
                                        <input name="qrcode" class="file-list-input" type="hidden" value="<?php echo htmlentities($config['qrcode']); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">热门搜索</label>
                                <div class="col-sm-9">
                                    <input type="text" name="site_search" lay-verify="required" placeholder="请输入" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['site_search']) && ($config['site_search'] !== '')?$config['site_search']:'')); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">关键词</label>
                                <div class="col-sm-9">
                                    <input type="text" name="site_keywords" lay-verify="required" placeholder="请输入" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['site_keywords']) && ($config['site_keywords'] !== '')?$config['site_keywords']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">客服QQ</label>
                                <div class="col-sm-9">
                                    <input type="text" name="QQ" lay-verify="required" placeholder="请输入" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['QQ']) && ($config['QQ'] !== '')?$config['QQ']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">售后服务</label>
                                <div class="col-sm-9">
                                    <input type="text" name="mobile" lay-verify="required" placeholder="请输入" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['mobile']) && ($config['mobile'] !== '')?$config['mobile']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">公司地址</label>
                                <div class="col-sm-9">
                                    <input type="text" name="address" lay-verify="required" autocomplete="off" placeholder="请输入地址" class="form-control" value="<?php echo htmlentities((isset($config['address']) && ($config['address'] !== '')?$config['address']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">邮箱</label>
                                <div class="col-sm-9">
                                    <input type="text" name="email" lay-verify="required" autocomplete="off" placeholder="请输入邮箱" class="form-control" value="<?php echo htmlentities((isset($config['email']) && ($config['email'] !== '')?$config['email']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group layui-form-text">
                                <label class="col-sm-3 control-label">项目介绍</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="project_introduce" placeholder="请输入内容" autocomplete="off" class="form-control"><?php echo htmlentities((isset($config['project_introduce']) && ($config['project_introduce'] !== '')?$config['project_introduce']:'')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group layui-form-text">
                                <label class="col-sm-3 control-label">网站描述</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="site_description" placeholder="请输入内容" autocomplete="off" class="form-control"><?php echo htmlentities((isset($config['site_description']) && ($config['site_description'] !== '')?$config['site_description']:'')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group layui-form-text">
                                <label class="col-sm-3 control-label">关于我们</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="about_us" placeholder="请输入内容" autocomplete="off" class="form-control"><?php echo htmlentities((isset($config['about_us']) && ($config['about_us'] !== '')?$config['about_us']:'')); ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button class="btn btn-mint" lay-submit="" lay-filter="demo1">立即提交</button>
                                    <button type="reset" class="btn btn-warning">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="layui-tab-item">
                    <div class="row">
                        <form class="layui-form form-horizontal col-sm-6" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">支付方式</label>
                                <div class="col-sm-9">
                                    <input type="text" name="pay_way" lay-verify="required" autocomplete="off" placeholder="请输入支付方式" class="form-control" value="<?php echo htmlentities((isset($config['pay_way']) && ($config['pay_way'] !== '')?$config['pay_way']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">支付方式介绍</label>
                                <div class="col-sm-9">
                                    <textarea name="introduce" cols="30" lay-verify="required" autocomplete="off" placeholder="请输入支付方式介绍" class="form-control" rows="10"><?php echo htmlentities((isset($config['introduce']) && ($config['introduce'] !== '')?$config['introduce']:'')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">AppId</label>
                                <div class="col-sm-9">
                                    <input type="text" name="appid" lay-verify="required" placeholder="请输入AppId" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['appid']) && ($config['appid'] !== '')?$config['appid']:'')); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">AppSecret</label>
                                <div class="col-sm-9">
                                    <input type="text" name="appsecret" lay-verify="required" placeholder="请输入AppSecret" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['appsecret']) && ($config['appsecret'] !== '')?$config['appsecret']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">商户ID</label>
                                <div class="col-sm-9">
                                    <input type="text" name="bus_id" lay-verify="required" placeholder="请输入商户ID" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['bus_id']) && ($config['bus_id'] !== '')?$config['bus_id']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">商户密钥</label>
                                <div class="col-sm-9">
                                    <input type="text" name="secret" lay-verify="required" placeholder="请输入商户密钥" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['secret']) && ($config['secret'] !== '')?$config['secret']:'')); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button class="btn btn-mint" lay-submit="" lay-filter="demo4">立即提交</button>
                                    <button type="reset" class="btn btn-warning">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="layui-tab-item">
                    <div class="row">
                        <form class="layui-form form-horizontal col-sm-6" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">商户ID</label>
                                <div class="col-sm-9">
                                    <input type="text" name="ebusinessid" lay-verify="required" placeholder="请输入EBusinessID" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['ebusinessid']) && ($config['ebusinessid'] !== '')?$config['ebusinessid']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">AppKey</label>
                                <div class="col-sm-9">
                                    <input type="text" name="appkey" lay-verify="required" placeholder="请输入AppKey" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['appkey']) && ($config['appkey'] !== '')?$config['appkey']:'')); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button class="btn btn-mint" lay-submit="" lay-filter="demo4">立即提交</button>
                                    <button type="reset" class="btn btn-warning">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="layui-tab-item">
                    <div class="row">
                        <form class="layui-form form-horizontal col-sm-6" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">短信ID</label>
                                <div class="col-sm-9">
                                    <input type="text" name="messageid" lay-verify="required" placeholder="请输入短信ID" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['messageid']) && ($config['messageid'] !== '')?$config['messageid']:'')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">AppKey</label>
                                <div class="col-sm-9">
                                    <input type="text" name="messagekey" lay-verify="required" placeholder="请输入messagekey" autocomplete="off" class="form-control" value="<?php echo htmlentities((isset($config['messagekey']) && ($config['messagekey'] !== '')?$config['messagekey']:'')); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button class="btn btn-mint" lay-submit="" lay-filter="demo4">立即提交</button>
                                    <button type="reset" class="btn btn-warning">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
    layui.use(['form','element','upload'], function(){
        var form = layui.form
                ,layer = layui.layer
                ,element = layui.element;
//        layui.upload({
//            url: '/admin/Common/upload' //上传接口
//            ,success: function(res){ //上传成功后的回调
//                if(res.status){
//                    $('.site_logo').val(res.url)
//                    $('.site_logo_img').attr('src',res.url);
//                    // $('.file-url').empty();
//                    // $('.file-url').append("<input type='text' name='site_logo' lay-verify='required' autocomplete='off' value='"+res.url+"' class='form-control'>")
//                }else{
//                    layer.msg(res.info)
//                }
//            }
//        });

        //监听提交
        form.on('submit(demo1)', function(data){
            data.field.site_close=data.field.site_close?1:0;
            console.log(data.field.site_close);
            ajax("/admin/System/index",data.field,function(data){
                if(data.status){
                    layer.msg(data.info);
                }else{
                    layer.msg(data.info);
                }
            })
            return false;
        });

        //监听提交
        form.on('submit(demo2)', function(data){
            ajax("/admin/System/index",data.field,function(data){
                if(data.status){
                    layer.msg(data.info);
                }else{
                    layer.msg(data.info);
                }
            })
            return false;
        });
        form.on('submit(demo3)', function(data){
            ajax("<?php echo url('System/email_test'); ?>",data.field,function(data){
                if(data.status){
                    layer.msg(data.info);
                }else{
                    layer.msg(data.info);
                }
            })
            return false;
        });
        form.on('submit(demo4)', function(data){
            ajax("<?php echo url('admin/System/index'); ?>",data.field,function(data){
                if(data.status){
                    layer.msg(data.info);
                }else{
                    layer.msg(data.info);
                }
            })
            return false;
        });

        $('.a').click(function(){
            layer.open({
                type: 1 //Page层类型
                ,area: ['500px', '300px']
                ,title: '你好，layer。'
                ,shade: 0.6 //遮罩透明度
                ,maxmin: true //允许全屏最小化
                ,anim: 0 //0-6的动画形式，-1不开启
                ,content: '<div style="padding:50px;">这是一个非常普通的页面层，传入了自定义的html</div>'
            });
        })

    });

</script>

            </div>
        </div>
        <nav id="mainnav-container">
            <div id="mainnav">
                <div id="mainnav-menu-wrap">
                    <div class="nano">
                        <div class="nano-content">
                            <div id="mainnav-profile" class="mainnav-profile">
                                <div class="profile-wrap">
                                    <div class="pad-btm">
                                        <img class="img-circle img-sm img-border" src="/static/admin/nifty/img/profile-photos/1.png" alt="Profile Picture">
                                    </div>
                                    <a href="javascript:" class="box-block">
                                        <p class="mnp-name"><?php echo htmlentities($admin_username); ?></p>
                                    </a>
                                </div>

                            </div>

                            <ul id="mainnav-menu" class="list-group">

                                <li class="list-header">导航</li>
                                <?php if(is_array($rule) || $rule instanceof \think\Collection || $rule instanceof \think\Paginator): if( count($rule)==0 ) : echo "" ;else: foreach($rule as $key=>$vo): if($vo['son'] == null): ?>
                                <li class="<?php if(($rule_val == $vo['url']) OR in_array($rule_val,$vo['rule'])): ?>active-link<?php endif; ?> ">
                                <a href="/<?php echo htmlentities($vo['url']); ?>">
                                    <i class="fa <?php echo htmlentities($vo['icon']); ?>"></i>
                                                <span class="menu-title">
                                                    <strong><?php echo htmlentities($vo['title']); ?></strong>
                                                </span>
                                </a>
                                </li>

                                <?php else: ?>
                                <li <?php if(in_array($rule_val,$vo['rule'],true)): ?>class="active-sub active"<?php endif; ?>>
                                <a href="#">
                                    <i class="fa <?php echo htmlentities($vo['icon']); ?>"></i>
                                                <span class="menu-title">
                                                    <strong><?php echo htmlentities($vo['title']); ?></strong>
                                                </span>
                                    <i class="arrow"></i>
                                </a>
                                <ul class="collapse">
                                    <?php if(is_array($vo['son']) || $vo['son'] instanceof \think\Collection || $vo['son'] instanceof \think\Paginator): if( count($vo['son'])==0 ) : echo "" ;else: foreach($vo['son'] as $key=>$item): ?>
                                    <li <?php if($rule_val == $item['url']): ?>class="active-link"<?php endif; ?>><a href="/<?php echo htmlentities($item['url']); ?>"><?php echo htmlentities($item['title']); ?></a></li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                </li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <footer id="footer">
        <div class="hide-fixed pull-right pad-rgt">
            powered by <strong><a href="http://www.stlhtech.com" target="_blank">世通领航</a></strong>
        </div>
        <p class="pad-lft">&#0169; 2017 <?php echo htmlentities($config['site_name']); ?></p>
    </footer>
    <button class="scroll-top btn">
        <i class="pci-chevron chevron-up"></i>
    </button>
</div>
</body>
</html>
