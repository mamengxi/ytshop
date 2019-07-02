<?php /*a:2:{s:73:"/home/wwwroot/ytshop/application/admin/view/operate/ad_location_edit.html";i:1525944628;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                            <label class="col-sm-2 control-label">广告位名称<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="location" lay-verify="required" autocomplete="off" placeholder="请输入广告位名称" value="<?php echo htmlentities($info['location']); ?>" class="form-control">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-sm-2 control-label">广告类型<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="radio" name="type" value="1" title="图片"  <?php if($info['type'] == 1): ?>checked=""<?php endif; ?>>
                                <input type="radio" name="type" value="2" title="文字" <?php if($info['type'] == 2): ?>checked=""<?php endif; ?>>
                                <input type="radio" name="type" value="3" title="文章" <?php if($info['type'] == 3): ?>checked=""<?php endif; ?>>
                                <input type="radio" name="type" value="4" title="用户" <?php if($info['type'] == 4): ?>checked=""<?php endif; ?>>
                            </div>
                        </div> -->
                        <!--<div class="form-group">-->
                            <!--<label class="col-sm-2 control-label">关闭启用</label>-->
                            <!--<div class="col-sm-10">-->
                                <!--<input type="checkbox" <?php if($info['status'] == 1): ?>checked=""<?php endif; ?> value="1"  lay-filter="status" name="status" lay-skin="switch" lay-text="ON|OFF" title="开关">-->
                            <!--</div>-->
                        <!--</div>-->
                        <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button class="btn btn-mint" lay-submit="" data-url="<?php echo url('Operate/ad_location_edit'); ?>" lay-filter="submit">提交</button>
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
