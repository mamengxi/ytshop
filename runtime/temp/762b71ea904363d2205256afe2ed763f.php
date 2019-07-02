<?php /*a:2:{s:64:"/home/wwwroot/ytshop/application/admin/view/goods/attr_edit.html";i:1524721804;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <title>
        后台管理系统
    </title>
    <link href="/static/admin/lib/font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">
    <link href="/static/admin/nifty/css/bootstrap.css" rel="stylesheet">
    <link href="/static/admin/nifty/css/nifty.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/admin/lib/layui/css/layui.css?__v=1477903794767"  media="all">
    <script src="/static/admin/nifty/js/jquery-2.2.4.min.js"></script>
    <script src="/static/admin/lib/city/area.js"></script>
    <script src="/static/admin/lib/city/city.js"></script>
    <script src="/static/admin/lib/layui/layui.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/admin/js/common.js?__v=1477903794749" type="text/javascript"></script>
</head>
<body>

<div class="row" id="page-content">
    <div class="col-lg-12">
        <div class="layui-tab">
            <div class="layui-tab-content">
                <form class="layui-form form-horizontal col-sm-12" action="">
                    <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">规格名称 <i class="red">*</i></label>
                        <div class="col-sm-9">
                            <input type="text" name="name" lay-verify="required" autocomplete="off" placeholder="" minlength="1" maxlength="8" class="form-control" value="<?php echo htmlentities($info['attr_name']); ?>">
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
    </div>
</div>
<script>
    layui.use(['form','element','upload'], function(){
        var form = layui.form
                ,layer = layui.layer;
        //监听提交
        form.on('submit(demo1)', function(data){
            ajax("/admin/Goods/attr_edit",data.field,function(data){
                if(data.status){
                    layer.msg(data.info,{icon: 1,time: 1000 }, function(){
                        parent.location.reload();
                    });
                }else{
                    layer.msg(data.info,{icon:2});
                }
            })
            return false;
        });


    });

</script>

</body>
</html>
