<?php /*a:1:{s:60:"/home/wwwroot/ytshop/application/admin/view/login/index.html";i:1523434691;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登陆 | 亦特微商城</title>


    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link rel="stylesheet" href="/static/admin/nifty/css/bootstrap.min.css" >

    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="/static/admin/nifty/css/nifty.min.css" rel="stylesheet">
    <!--Magic Checkbox [ OPTIONAL ]-->
    <link href="/static/admin/nifty/plugins/magic-check/css/magic-check.min.css" rel="stylesheet">

    <script src="/static/admin/nifty/js/jquery-2.2.4.min.js"></script>

    <!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link href="/static/admin/nifty/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="/static/admin/nifty/plugins/pace/pace.min.js"></script>
    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="/static/admin/nifty/js/bootstrap.min.js"></script>
    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <link rel="stylesheet" href="/static/admin/lib/layui/css/layui.css?__v=1477903794767"  media="all">
    <!--NiftyJS [ RECOMMENDED ]-->
    <script src="/static/admin/nifty/js/nifty.min.js"></script>
    <script src="/static/admin/js/common.js?__v=1477903794749" type="test/javascript"></script>

</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
<div id="container" class="cls-container">
    <div id="bg-overlay" class="bg-img" style="background-image: url('/static/admin/img/bg-img/bg-img-5.jpg');"></div>
    <div class="cls-content">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <div class="mar-ver pad-btm">
                    <h3 class="h4 mar-no">登陆</h3>
                    <p class="text-muted">请填写您的信息</p>
                </div>
                <form method="post">
                    <div class="form-group">
                        <input type="text" id="username" value="admin" class="form-control" placeholder="请输入账号" autofocus required="true">
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" value="123456" class="form-control" placeholder="请输入密码">
                    </div>
                    <div class="checkbox pad-btm text-left">
                        <input id="demo-form-checkbox" class="magic-checkbox remember_me" type="checkbox">
                        <label for="demo-form-checkbox">记住我</label>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="embed-submit" type="button">登陆</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
//    layui.use(['form'], function() {
//        layer = layui.layer;
//        $('#embed-submit').click(function(){
//            var username=$("#username").val(),
//                password=$("#password").val(),
//                remember=$(".remember_me").is(':checked')?1:0;
//
////            console.log(username);
////            console.log(password);
////            console.log(remember);
//            if(username==""||password==""){
//                layer.msg('请输入用户名或密码');
//                return false;
//            }
//            ajax("/admin/Login/index",{username:username,password:password,remember:remember},function(data){
//                console.log(data);
//                return;
//                if(data.status) {
//                    layer.msg(data.msg);
//                    setTimeout(function () {
//                        window.location.herf = data.url;
//                    }, 1000)
//                    parent.layer.close();
//                }else{
//                    layer.msg(data.msg);
//                }
//            })
//        });
//    });

    layui.use(['form'], function(){
        layer = layui.layer;
            $("#embed-submit").click(function () {
                    var username=$("#username").val(),
                            password=$("#password").val(),
                            remember=$(".remember_me").is(':checked')?1:0;
                    if(username==""||password==""){
                        layer.msg('请输入用户名或密码');
                        return false;
                    }
                $.ajax({
                    url:'/admin/Login/index',
                    type:'POST',
                    async: true,
                    dataType: 'json',
                    data:{
                        'username':username,
                        'password':password,
                    },
                    beforeSend: function () {
                        index=layer.load()
                    },
                    success: function (data) {
                        if(data.status){
                            layer.msg(data.msg);
                            setTimeout(function(){
                                window.location.href=data.url;
                            },1000)

                            layer.close();
                        }else{
                            layer.msg(data.msg);
                        }
                    },
                    complete: function () {
                        layer.close(index);
                    },
                    error: function (data) {
                        layer.msg('请求错误');
                    },

                })

//                    ajax("/admin/Login/index",{username:username,password:password,remember:remember},function(data){
//                        if(data.status){
//                            layer.msg(data.info);
//                            setTimeout(function(){
//                                window.location.href=data.url;
//                            },1000)
//                            parent.layer.close();
//                        }else{
//                            layer.msg(data.info);
//                        }
//                    })
            });
    });
</script>
</body>
</html>
