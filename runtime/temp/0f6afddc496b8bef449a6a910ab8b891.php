<?php /*a:2:{s:62:"/home/wwwroot/ytshop/application/admin/view/auth/rule_set.html";i:1523434689;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
        <form class="layui-form form-horizontal" action="">
            <div id="Auth-Set-Site" class="row">
                <ul class="ul-wrapper" checked="checked">
                    <li class="li0 li">
                        <input type="checkbox" id="CheckAllSite" class="custom-checkbox"  lay-filter="checkAll" lay-skin="primary" title="全选/全不选">
                        <ul class="ul">
                            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$voo): ?>
                            <li class="li1 li">
                                <input type="checkbox" value="<?php echo htmlentities($voo['id']); ?>" lay-filter="checkvoo" <?php if(in_array($voo['id'],$rule)): ?>checked<?php endif; ?> name="rules" lay-skin="primary" title="<?php echo htmlentities($voo['title']); ?>">
                                <a href="javascript:void(0);" class="arrow"></a>
                                <?php if($voo['sub'] != null): ?>
                                <ul class="sub-ul clearfix">
                                    <?php if(is_array($voo['sub']) || $voo['sub'] instanceof \think\Collection || $voo['sub'] instanceof \think\Paginator): if( count($voo['sub'])==0 ) : echo "" ;else: foreach($voo['sub'] as $key=>$vo): ?>
                                    <li class="li2 li">
                                        <input type="checkbox" class="checkvo" value="<?php echo htmlentities($vo['id']); ?>" lay-filter="checkvo" <?php if(in_array($vo['id'],$rule)): ?>checked<?php endif; ?> name="rules" lay-skin="primary" title="<?php echo htmlentities($vo['title']); ?>">
                                        <?php if($vo['sub'] != null): ?>
                                        <ul class="last-ul clearfix">
                                            <?php if(is_array($vo['sub']) || $vo['sub'] instanceof \think\Collection || $vo['sub'] instanceof \think\Paginator): if( count($vo['sub'])==0 ) : echo "" ;else: foreach($vo['sub'] as $key=>$v): ?>
                                            <li class="tree-leaf li3 li ">
                                                <em class="ll">&nbsp;</em>
                                                <input type="checkbox" lay-filter="checkv" value="<?php echo htmlentities($v['id']); ?>" <?php if(in_array($v['id'],$rule)): ?>checked<?php endif; ?> name="rules" lay-skin="primary" title="<?php echo htmlentities($v['title']); ?>">
                                            </li>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                        <?php endif; ?>
                                    </li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <input type="hidden" name="id" value="<?php echo htmlentities($id); ?>">
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button class="btn btn-mint" lay-submit="" lay-filter="demo1">提交</button>
                        <button type="reset" onclick="layer_close()" class="btn btn-warning">关闭</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .ul-wrapper .ul {
        margin: 0px 0 20px 20px
    }


    .ul-wrapper .ul>li .sub-ul {
        margin: 10px 0 0 20px;
        padding: 0px 20px 0;
        border: 1px solid #ececec;
        background-color: #fff
    }

    .ul-wrapper .ul>li .sub-ul li {
        display: inline-block;
        width: 150px
    }

    .ul-wrapper .ul>li .sub-ul li.li2 {
        margin-bottom: 5px;
        vertical-align: top
    }

    .ul-wrapper .ul>li .sub-ul .last-ul {
        margin-left: 5px;
        border-left: 1px dotted #a0a2a5
    }

    .ul-wrapper .ul>li .sub-ul .last-ul li em {
        position: relative;
        top: -5px;
        padding-left: 10px;
        border-bottom: 1px dotted #a0a2a5
    }

    .ul-wrapper .ul>li .sub-ul .last-ul li.tree-last:after {
        content: '.';
        overflow: hidden;
        height: 0;
        display: block;
        margin-bottom: -5px
    }
</style>


<script>
    layui.use(['form','upload'], function(){
        var form = layui.form,
            layer = layui.layer;

        form.on('checkbox(checkAll)', function(data){
            var child = $(data.elem).parents('ul').find('input[type="checkbox"]');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });
        form.on('checkbox(checkvoo)', function(data){
            var child = $(data.elem).parents('.li1').find('input[type="checkbox"]');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });
        form.on('checkbox(checkvo)', function(data){
            var child = $(data.elem).parents('.li2').find('input[type="checkbox"]');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });


        //监听提交
        form.on('submit(demo1)', function(data){
            var rules ='';
            $('input[name="rules"]:checked').each(function(){
                rules+=$(this).val()+',';
            });
            var id=$('input[name="id"]').val();
            ajax("/admin/Auth/rule_set",{rules:rules,id:id},function(data){
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
