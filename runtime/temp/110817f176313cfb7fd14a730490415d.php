<?php /*a:2:{s:63:"/home/wwwroot/ytshop/application/admin/view/auth/rule_edit.html";i:1523434689;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                            <label class="col-sm-3 control-label">节点名称</label>
                            <div class="col-sm-9">
                                <input type="text" name="title" lay-verify="required" value="<?php echo htmlentities($info['title']); ?>" autocomplete="off" placeholder="请输入节点名称" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">节点url</label>
                            <div class="col-sm-9">
                                <input type="text" name="url" lay-verify="required" value="<?php echo htmlentities($info['url']); ?>" autocomplete="off" placeholder="请输入节点url" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">父级节点</label>
                            <div class="col-sm-9">
                                <select name="pid" lay-filter="aihao">
                                    <option value="0">一级节点</option>
                                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                                    <option value="<?php echo htmlentities($vo['id']); ?>" <?php if($vo['id'] == $info['pid']): ?>selected=""<?php endif; ?>><?php echo htmlentities($vo['html']); ?><?php echo htmlentities($vo['title']); ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">icon</label>
                            <div class="col-sm-6">
                                <input type="text" name="icon" autocomplete="off" placeholder="请输入icon" value="<?php echo htmlentities($info['icon']); ?>" class="form-control" >
                            </div>
                            <div class="col-sm-3 tips"><a href="http://fontawesome.dashgame.com/#why" target="_blank">选择图标</a></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">排序</label>
                            <div class="col-sm-9">
                                <input type="text" name="sort" lay-verify="number" placeholder="越大越靠前" value="<?php echo htmlentities($info['sort']); ?>" autocomplete="off" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">是否导航</label>
                            <div class="col-sm-9">
                                <input type="checkbox" <?php if($info['is_nav'] == 1): ?>checked=""<?php endif; ?> value="1"  lay-filter="is_nav" name="is_nav" lay-skin="switch" lay-text="ON|OFF" title="开关">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">是否启用</label>
                            <div class="col-sm-9">
                                <input type="checkbox" <?php if($info['status'] == 1): ?>checked=""<?php endif; ?> value="1"  lay-filter="status" name="status" lay-skin="switch" lay-text="ON|OFF" title="开关">
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button class="btn btn-mint" lay-submit="" lay-filter="rule">提交</button>
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
        form.on('submit(rule)', function(data){
            data.field.status=data.field.status?1:0;
            data.field.is_nav=data.field.is_nav?1:0;
            ajax("/admin/Auth/rule_edit",data.field,function(data){
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
