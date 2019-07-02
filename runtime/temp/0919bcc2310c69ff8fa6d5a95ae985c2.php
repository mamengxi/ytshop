<?php /*a:2:{s:64:"/home/wwwroot/ytshop/application/admin/view/goods/brand_add.html";i:1526627408;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
    <div class="col-sm-12">
        <div class="layui-tab">
            <div class="layui-tab-content">
                <form class="layui-form form-horizontal" action="">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">品牌名称</label>
                            <div class="col-sm-9">
                                <input type="text" name="title" lay-verify="required" autocomplete="off" maxlength="10" placeholder="请输入品牌名称" class="form-control">
                            </div>
                        </div>
                        <!--<div class="form-group">-->
                            <!--<label class="col-sm-3 control-label">排序</label>-->
                            <!--<div class="col-sm-9">-->
                                <!--<input type="text" name="sort" lay-verify="number" minlength="1" maxlength="2" placeholder="越小越靠前" value="99" autocomplete="off" class="form-control">-->
                            <!--</div>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">启用</label>
                            <div class="col-sm-9">
                                <input type="checkbox" checked="" value="1"  lay-filter="status" name="status" lay-skin="switch" lay-text="ON|OFF" title="开关">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button class="btn btn-mint" lay-submit="" data-url="/admin/Goods/brand_add" lay-filter="submit">提交</button>
                                <button type="reset" onclick="layer_close()" class="btn btn-warning">关闭</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
