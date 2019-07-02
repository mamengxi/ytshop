<?php /*a:2:{s:63:"/home/wwwroot/ytshop/application/admin/view/feedback/index.html";i:1523434690;s:60:"/home/wwwroot/ytshop/application/admin/view/public/base.html";i:1523434691;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>网站管理后台</title>
    <link href="/static/admin/nifty/css/bootstrap.css" rel="stylesheet">
    <link href="/static/admin/nifty/css/nifty.css" rel="stylesheet">
    <link href="/static/admin/lib/font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">
    <link href="/static/admin/nifty/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="/static/admin/nifty/plugins/pace/pace.min.js"></script>
    <script src="/static/admin/nifty/js/jquery-2.2.4.min.js"></script>
    <script src="/static/admin/nifty/js/bootstrap.min.js"></script>
    <script src="/static/admin/nifty/js/nifty.js"></script>
    <script src="/static/admin/lib/city/area.js"></script>
    <script src="/static/admin/lib/city/city.js"></script>
    <script src="/static/admin/lib/layui/layui.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="/static/admin/lib/layui/css/layui.css?__v=1477903794767"  media="all">
    <script src="/static/admin/js/common.js?__v=1477903794749" type="text/javascript"></script>

</head>
<body>
<div id="container" class="effect aside-float aside-bright mainnav-lg easeOutBack">
    <header id="navbar">
        <div id="navbar-container" class="boxed">
            <div class="navbar-header">
                <a href="index.html" class="navbar-brand">
                    <img src="/static/admin/nifty/img/logo.png" alt="Nifty Logo" class="brand-icon">
                    <div class="brand-title">
                        <span class="brand-text">Nifty</span>
                    </div>
                </a>
            </div>
            <div class="navbar-content clearfix">
                <ul class="nav navbar-top-links pull-left">
                    <li class="tgl-menu-btn">
                        <a class="mainnav-toggle" href="#">
                            <i class="fa fa-navicon"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge badge-header badge-danger"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md">
                            <div class="pad-all bord-btm">
                                <p class="text-semibold text-main mar-no">You have 9 notifications.</p>
                            </div>
                            <div class="nano scrollable">
                                <div class="nano-content">
                                    <ul class="head-list">
                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <p class="pull-left">Database Repair</p>
                                                    <p class="pull-right">70%</p>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div style="width: 70%;" class="progress-bar">
                                                        <span class="sr-only">70% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <p class="pull-left">Upgrade Progress</p>
                                                    <p class="pull-right">10%</p>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div style="width: 10%;" class="progress-bar progress-bar-warning">
                                                        <span class="sr-only">10% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <span class="badge badge-success pull-right">90%</span>
                                                <div class="media-left">
                                                    <i class="demo-pli-data-settings icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">HDD is full</div>
                                                    <small class="text-muted">50 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <i class="demo-pli-file-edit icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">Write a news article</div>
                                                    <small class="text-muted">Last Update 8 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <span class="label label-danger pull-right">New</span>
                                                <div class="media-left">
                                                    <i class="demo-pli-speech-bubble-7 icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">Comment Sorting</div>
                                                    <small class="text-muted">Last Update 8 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <i class="demo-pli-add-user-plus-star icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">New User Registered</div>
                                                    <small class="text-muted">4 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="bg-gray">
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <img class="img-circle img-sm" alt="Profile Picture" src="/static/admin/nifty/img/profile-photos/9.png">
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">Lucy sent you a message</div>
                                                    <small class="text-muted">30 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="bg-gray">
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <img class="img-circle img-sm" alt="Profile Picture" src="/static/admin/nifty/img/profile-photos/3.png">
                                                </div>
                                                <div class="media-body">
                                                    <div class="text-nowrap">Jackson sent you a message</div>
                                                    <small class="text-muted">40 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="pad-all bord-top">
                                <a href="#" class="btn-link text-dark box-block">
                                    <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Notifications
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-top-links pull-right">

                    <li class="mega-dropdown">
                        <a title="网站首页" href="/" target="_blank">
                            <i class="fa fa-send-o"></i> 网站首页
                        </a>
                    </li>
                    <li id="dropdown-user" class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                            <i class="fa fa-user-o"></i>
                            <?php echo htmlentities($admin_username); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">
                            <div class="pad-all bord-btm">
                                <p class="text-main mar-btm"><span class="text-bold">750GB</span> of 1,000GB Used</p>
                                <div class="progress progress-sm">
                                    <div class="progress-bar" style="width: 70%;">
                                        <span class="sr-only">70%</span>
                                    </div>
                                </div>
                            </div>
                            <ul class="head-list">
                                <li>
                                    <a href="#">
                                        <span class="badge badge-danger pull-right">9</span>
                                        <i class="fa fa-envelope-o"></i> 消息
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-success pull-right">New</span>
                                        <i class="fa fa-cog"></i> 设置
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa fa-exclamation-circle"></i> 帮助
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-tv"></i> 锁定桌面
                                    </a>
                                </li>
                            </ul>
                            <div class="pad-all text-right">
                                <a href="<?php echo url('/admin/Login/logout'); ?>" class="btn btn-primary">
                                    <i class="fa fa-sign-out"></i> 退出
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a  href="javascript:cache()">
                            <i class="fa fa-trash-o"></i>
                            清除缓存
                        </a>
                    </li>
                    <li>
                        <a  href="<?php echo url('/admin/Login/logout'); ?>">
                            <i class="fa fa-sign-out"></i>
                            退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="boxed">
        <div id="content-container">
            <div id="page-title">
                <!--<ol class="breadcrumb"></ol>-->
                <!--<div class="searchbox">-->
                    <!--<div class="input-group custom-search-form">-->
                        <!--<input type="text" class="form-control" placeholder="Search..">-->
                            <!--<span class="input-group-btn">-->
                                <!--<button class="text-muted" type="button"><i class="fa fa-search"></i></button>-->
                            <!--</span>-->
                    <!--</div>-->
                <!--</div>-->
            </div>
            <div id="page-content">
                
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>反馈列表</legend>
            </fieldset>
            <div class="row">
                <div class="search-box form-group col-sm-12">
                    <form role="form" class="form-inline layui-form search-form" method="get">
                        <div class="input-group">
                            <input type="text" name="phone" placeholder="请输入手机号" class="form-control j-data" value="">
                        </div>
                        <button class="btn btn-primary j-search" type="button">搜索</button>
                        <button class="btn btn-primary j-empey" type="button">清空</button>
                    </form>
                </div>
            </div>

            <table class="layui-hide" id="LAY_table_user" lay-filter="table"></table>
            <script type="text/html" id="barDemo">
                {{#  if(d.status == 1){ }}
                <a class="btn btn-xs btn-info" lay-event="detail"><i class="fa fa-eye"></i> 处理</a>
                <a class="btn btn-xs btn-primary" lay-event="edit"><i class="fa fa-edit"></i> 忽略</a>
                {{#  } }}
                <a class="btn btn-xs btn-default" lay-event="del"><i class="fa fa-trash-o"></i> 删除</a>
            </script>
            <script type="text/html" id="barDemo1">
                {{#  if(d.status == 1){ }}
                    <p style="color:red;">待处理<p>
                {{#  } else if(d.status == 2) { }}
                    <p style="color:green;">已处理<p>
                {{#  } else { }}
                    <p style="color:#999999;">已忽略<p>
                {{#  } }}
            </script>
        </div>
    </div>
</div>
<script>
    layui.use(['layer', 'table',], function(){
        var layer = layui.layer //弹层
                ,table = layui.table //表格

        var tableIns = table.render({
            elem: '#LAY_table_user'
            ,url: "<?php echo url('index'); ?>"
            ,cols: [[
                {field:'nickname', title: '昵称',width:120}
                ,{field:'phone', title: '联系方式',width:120}
                ,{field:'time', title: '反馈时间',width:200}
                ,{field:'detail', title: '反馈详情'}
                ,{field:'status', title: '反馈状态',width:150, toolbar: '#barDemo1'}
                ,{fixed: 'right',title: '操作', width:200, align:'center', toolbar: '#barDemo'}

            ]]
            ,page: true
            ,method: 'post'
            ,done: function(res, curr, count){
            }
        });

        table.on('tool(table)', function(obj){
            var data = obj.data
                    ,layEvent = obj.event;
            if(layEvent === 'detail'){
                layer.confirm('确定该操作么？', {
                    title: '提示',
                    btnAlign: 'c',
                    resize: false,
                    icon: 3,
                    btn: ['确定', '容朕想想'],
                    yes: function (index) {
                        ajax("<?php echo url('feedback/deal'); ?>",{id:data.id,status:2},function(data){
                            if(data.status){
                                layer.msg(data.msg, {
                                    icon: 1,
                                    time: 1000 //1秒关闭（如果不配置，默认是3秒）
                                }, function(){
                                    $('.layui-laypage-btn').click();
                                });
                            }else{
                                layer.msg(data.msg,{icon:2});
                            }
                        })
                    }
                });
            } else if(layEvent === 'edit'){
                layer.confirm('确定该操作么？', {
                    title: '提示',
                    btnAlign: 'c',
                    resize: false,
                    icon: 3,
                    btn: ['确定', '容朕想想'],
                    yes: function (index) {
                        ajax("<?php echo url('feedback/deal'); ?>",{id:data.id,status:3},function(data){
                            if(data.status){
                                layer.msg(data.msg, {
                                    icon: 1,
                                    time: 1000 //1秒关闭（如果不配置，默认是3秒）
                                }, function(){
                                    $('.layui-laypage-btn').click();
                                });
                            }else{
                                layer.msg(data.msg,{icon:2});
                            }
                        })
                    }
                });
            }else if(layEvent === 'del'){
                layer.confirm('确定该操作么？', {
                    title: '提示',
                    btnAlign: 'c',
                    resize: false,
                    icon: 3,
                    btn: ['确定', '容朕想想'],
                    yes: function (index) {
                        ajax("<?php echo url('feedback_del'); ?>",{id:data.id},function(data){
                            if(data.status){
                                layer.msg(data.msg, {icon: 1,time: 1000 }, function(){
                                    obj.del();
                                    layer.close(index);
                                });
                            }else{
                                layer.msg(data.msg,{icon:2});
                            }
                        })
                    }
                });
            }
        });
        //排序
        table.on('sort(table)', function(obj){
            if(obj.type){
                tableIns.reload({
                    initSort: obj
                    ,where: {
                        order: obj.field+' '+obj.type
                    }
                });
            }
        });

        //搜索
        $('.j-search').on('click', function(){
            var where=JSON.stringify($(".search-form").serializeObject());
            where=JSON.parse(where);
            tableIns.reload({
                where: where
            });
        });
        //清空
        $('.j-empey').on('click', function(){
            $('.search-box input').each(function(e){
                $(this).val('');
            })
            tableIns.reload({
                where: {}
            });
        });
    });

</script>


            </div>
        </div>
        <nav id="mainnav-container">
            <div id="mainnav">
                <div id="mainnav-menu-wrap">
                    <div class="nano">
                        <div class="nano-content">
                            <div id="mainnav-profile" class="mainnav-profile">
                                <div class="profile-wrap">
                                    <div class="pad-btm">
                                        <img class="img-circle img-sm img-border" src="/static/admin/nifty/img/profile-photos/1.png" alt="Profile Picture">
                                    </div>
                                    <a href="javascript:" class="box-block">
                                        <p class="mnp-name"><?php echo htmlentities($admin_username); ?></p>
                                    </a>
                                </div>

                            </div>

                            <ul id="mainnav-menu" class="list-group">

                                <li class="list-header">导航</li>
                                <?php if(is_array($rule) || $rule instanceof \think\Collection || $rule instanceof \think\Paginator): if( count($rule)==0 ) : echo "" ;else: foreach($rule as $key=>$vo): if($vo['son'] == null): ?>
                                <li class="<?php if(($rule_val == $vo['url']) OR in_array($rule_val,$vo['rule'])): ?>active-link<?php endif; ?> ">
                                <a href="/<?php echo htmlentities($vo['url']); ?>">
                                    <i class="fa <?php echo htmlentities($vo['icon']); ?>"></i>
                                                <span class="menu-title">
                                                    <strong><?php echo htmlentities($vo['title']); ?></strong>
                                                </span>
                                </a>
                                </li>

                                <?php else: ?>
                                <li <?php if(in_array($rule_val,$vo['rule'],true)): ?>class="active-sub active"<?php endif; ?>>
                                <a href="#">
                                    <i class="fa <?php echo htmlentities($vo['icon']); ?>"></i>
                                                <span class="menu-title">
                                                    <strong><?php echo htmlentities($vo['title']); ?></strong>
                                                </span>
                                    <i class="arrow"></i>
                                </a>
                                <ul class="collapse">
                                    <?php if(is_array($vo['son']) || $vo['son'] instanceof \think\Collection || $vo['son'] instanceof \think\Paginator): if( count($vo['son'])==0 ) : echo "" ;else: foreach($vo['son'] as $key=>$item): ?>
                                    <li <?php if($rule_val == $item['url']): ?>class="active-link"<?php endif; ?>><a href="/<?php echo htmlentities($item['url']); ?>"><?php echo htmlentities($item['title']); ?></a></li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                </li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <footer id="footer">
        <div class="hide-fixed pull-right pad-rgt">
            powered by <strong><a href="http://www.stlhtech.com" target="_blank">世通领航</a></strong>
        </div>
        <p class="pad-lft">&#0169; 2017 <?php echo htmlentities($config['site_name']); ?></p>
    </footer>
    <button class="scroll-top btn">
        <i class="pci-chevron chevron-up"></i>
    </button>
</div>
</body>
</html>
