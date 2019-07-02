<?php /*a:2:{s:63:"/home/wwwroot/ytshop/application/admin/view/operate/ad_add.html";i:1523953165;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                <form class="layui-form form-horizontal" action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="ad_name" lay-verify="required" autocomplete="off" placeholder="请输入活动标题" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">url<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="url" lay-verify="required" autocomplete="off" placeholder="请输入跳转url" class="form-control">
                            </div>
                        </div>
                        <!--<div class="form-group">-->
                            <!--<label class="col-sm-2 control-label">展示时间<i class="red">*</i></label>-->
                            <!--<div class="col-sm-10">-->
                                <!--<div class="input-group mar-btm">-->
                                    <!--<div class="input-group-addon">开始</div>-->
                                    <!--<input type="text" name="start_time" id="laydate-start" lay-verify="required" autocomplete="off" placeholder="活动开始时间" class="form-control" >-->
                                    <!--<div class="input-group-addon">结束</div>-->
                                    <!--<input type="text" name="end_time" id="laydate-end" lay-verify="required" autocomplete="off" placeholder="活动结束时间" class="form-control" >-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">封面图片<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-primary btn-file j-upload-one"  lay-data="{data:{name: 'img_src', folder: 'shop'}}"></i><i class="fa fa-folder-open-o"></i>&nbsp;上传图片...</button>
                                <div class="file-list clearfix">
                                <ul>
                                    <li><img src="<?php echo htmlentities($info['img_src']); ?>"/></li>
                                </ul>
                                    <input name="img_src" class="file-list-input" type="hidden" value="<?php echo htmlentities($info['img_src']); ?>">
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group">-->
                            <!--<label class="col-sm-2 control-label">排序</label>-->
                            <!--<div class="col-sm-6">-->
                                <!--<input type="text" name="sort" lay-verify="required" value="0" autocomplete="off" placeholder="越大越靠前" class="form-control">-->
                            <!--</div>-->
                            <!--<span class="col-sm-4 tips">越大越靠前</span>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">是否启用</label>
                            <div class="col-sm-10">
                                <input type="checkbox" checked="" value="1"  lay-filter="status" name="status" lay-skin="switch" lay-text="ON|OFF" title="开关">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="location_id" value="<?php echo htmlentities($location_id); ?>">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button class="btn btn-mint" lay-submit="" data-url="<?php echo url('Operate/ad_add'); ?>" lay-filter="submit">提交</button>
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
