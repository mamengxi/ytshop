<?php /*a:2:{s:69:"/home/wwwroot/ytshop/application/admin/view/goods/attr_value_add.html";i:1524737609;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                            <label class="col-sm-3 control-label">商品属性</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="attrid">
                                    <?php if(is_array($attr) || $attr instanceof \think\Collection || $attr instanceof \think\Paginator): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['attr_name']); ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">商品属性值</label>
                            <div class="col-sm-9">
                                <textarea name="name" class="form-control" rows="3" lay-verify="required"></textarea>
                                <!--<p>多个属性之前请用 <b style="color:red;">英文 逗号(,)</b>  隔开</p>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button class="btn btn-mint" lay-submit="" lay-filter="attr">提交</button>
                                <button type="reset" onclick="layer_close()" class="btn btn-warning">关闭</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    layui.use(['form','upload'], function(){
        var form = layui.form,
            layer = layui.layer;
        //监听提交
        form.on('submit(attr)', function(data){
            ajax("/admin/Goods/attr_value_add",data.field,function(data){
                if(data.status){
                    layer.msg(data.info, {
                        icon: 1,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function(){
                        layer_close();
                        parent.location.reload();
                    });
                }else{
                    layer.msg(data.info, {
                        icon: 2,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    });
                }
            })
            return false;
        });
    });
</script>

</body>
</html>
