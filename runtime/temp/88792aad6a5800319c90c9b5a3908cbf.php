<?php /*a:2:{s:63:"/home/wwwroot/ytshop/application/admin/view/goods/item_add.html";i:1524706677;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                        <?php if(is_array($attr) || $attr instanceof \think\Collection || $attr instanceof \think\Paginator): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo htmlentities($v['attr_name']); ?></label>
                                <div class="col-sm-6">
                                    <?php if(is_array($v['attr_value']) || $v['attr_value'] instanceof \think\Collection || $v['attr_value'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v['attr_value'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <!--<input type="checkbox" name="" title="<?php echo htmlentities($vo['attr_name']); ?>" lay-skin="primary">-->
                                        <input type="radio" name="name[<?php echo htmlentities($v['id']); ?>]" value="<?php echo htmlentities($vo['good_attr_id']); ?>" title="<?php echo htmlentities($vo['attr_name']); ?>">
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品价格</label>
                            <div class="col-sm-6">
                                <input type="text" name="price" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品价格" class="form-control" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">库存</label>
                            <div class="col-sm-6">
                                <input type="text" name="stock" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品库存" class="form-control" >
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="gid" value="<?php echo htmlentities($gid); ?>">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button class="btn btn-mint" lay-submit="" lay-filter="formDemo">提交</button>
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
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(formDemo)', function(data){
            console.log(data.field);
            ajax("/admin/Goods/item_add",data.field,function(data){
                if(data.status){
                    layer.msg(data.info,{icon: 1,time: 1000 }, function(){
                        parent.location.reload();
                    });
                }else{
                    layer.msg(data.info,{icon:2});
                }
            });
            return false;
        });
    });
</script>

</body>
</html>
