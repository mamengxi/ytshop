<?php /*a:2:{s:67:"/home/wwwroot/ytshop/application/admin/view/order/goods_update.html";i:1523434691;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                            <label class="col-sm-2 control-label">快递公司</label>
                            <div class="input-group">
                                <div class="search-box form-group" style="width: 100px;margin-left: 16px;" >
                                    <select name="shipper_code">
                                        <option value="" style="height: 32px;line-height: 32px;">快递类型</option>
                                        <?php if(is_array($express) || $express instanceof \think\Collection || $express instanceof \think\Paginator): $i = 0; $__LIST__ = $express;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo htmlentities($vo['shipper_code']); ?>" <?php if($vo['shipper_code'] == $info['logistics_name']): ?>selected=""<?php endif; ?>><?php echo htmlentities($vo['express_company']); ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">快递单号</label>
                            <div class="col-sm-3">
                                <input type="text" name="logistics_code" value="<?php echo htmlentities($info['logistics_code']); ?>" lay-verify="required" autocomplete="off" placeholder="请输入快递单号"  class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="oid" value="<?php echo htmlentities($oid); ?>">
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button class="btn btn-mint" lay-submit="" data-url="<?php echo url('Order/goods_update'); ?>" lay-filter="submit">提交</button>
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
