<?php /*a:2:{s:59:"/home/wwwroot/ytshop/application/admin/view/goods/item.html";i:1524638584;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
        <div class="form-group">
            <button class="btn btn-sm btn-primary m-t-n-xs" onclick="layer_show('添加单品','/admin/Goods/item_add.html?gid=<?php echo htmlentities($gid); ?>',800,520)"><strong>添加单品</strong></button>
            <button class="btn btn-sm btn-primary refresh"> <i class="fa fa-refresh"></i> <strong> 刷新</strong></button>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center" width="50"><input class="check-all" type="checkbox"/></th>
                <th>id</th>
                <th>属性</th>
                <th>价格</th>
                <th>库存</th>
                <th>是否上架</th>
                <th width="121">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
            <tr class="gradeX">
                <td class="text-center"><input class="ids" type="checkbox" name="id[]" value="<?php echo htmlentities($vo['id']); ?>"></td>
                <td><?php echo htmlentities($vo['id']); ?></td>
                <td>
                    <?php if(is_array($vo['attr_id']) || $vo['attr_id'] instanceof \think\Collection || $vo['attr_id'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['attr_id'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                         <span class="btn btn-info btn-sm"><?php echo htmlentities($item[$v]); ?></span>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </td>
                <td><?php echo htmlentities($vo['price']/100); ?></td>
                <td><?php echo htmlentities($vo['stock']); ?></td>
                <td class="layui-form"><input type="checkbox" <?php if($vo['status'] == 1): ?>checked=""<?php endif; ?> data-db="goods_item" data-id="<?php echo htmlentities($vo['id']); ?>" name="open" lay-skin="switch" lay-filter="switchStatus" lay-text="上架|下架"></td>
                <td>
                    <button class="btn btn-xs btn-default do-del" data-db="goods_item" data-id="<?php echo htmlentities($vo['id']); ?>" data-status="-1" data-field="is_delete"><i class="fa fa-trash-o"></i> 删除</button>
                    <button class="btn btn-xs btn-primary" onclick="layer_show('编辑','/admin/Goods/item_edit.html?id=<?php echo htmlentities($vo['id']); ?>',800,520)"><i class="fa fa-edit"></i> 编辑</button>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <?php echo $page; ?>
    </div>
</div>
<script>
    $('.refresh').click(function () {
        location.reload();
    })
</script>

</body>
</html>
