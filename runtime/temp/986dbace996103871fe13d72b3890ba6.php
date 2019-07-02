<?php /*a:2:{s:59:"/home/wwwroot/ytshop/application/admin/view/operate/ad.html";i:1524557537;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
            <button class="btn btn-sm btn-primary m-t-n-xs" onclick="layer_show('添加广告','/admin/Operate/ad_add.html?location_id=<?php echo htmlentities($location_id); ?>',800,520)"><strong>添加广告</strong></button>
            <!--<button class="btn btn-sm btn-primary m-t-n-xs do-del-all" data-db="ad" data-status="1"><strong>启用</strong></button>-->
            <!--<button class="btn btn-sm btn-primary m-t-n-xs do-del-all" data-db="ad" data-status="0"><strong>禁用</strong></button>-->
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center" width="50"><input class="check-all" type="checkbox"/></th>
                <th>标题</th>
                <th>url</th>
                <!--<th>开始时间</th>-->
                <!--<th>结束时间</th>-->
                <th width="60">状态</th>
                <th width="121">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
            <tr class="gradeX">
                <td class="text-center"><input class="ids" type="checkbox" name="id[]" value="<?php echo htmlentities($vo['id']); ?>"></td>
                <td><?php echo htmlentities($vo['ad_name']); ?></td>
                <td><?php echo htmlentities($vo['url']); ?></td>
                <!--<td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($vo['start_time'])? strtotime($vo['start_time']) : $vo['start_time'])); ?></td>-->
                <!--<td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($vo['end_time'])? strtotime($vo['end_time']) : $vo['end_time'])); if($vo['end_time'] < time()): ?><span class="label label-tips label-warning">过期</span><?php endif; ?></td>-->
                <td class="layui-form"><input type="checkbox" <?php if($vo['status'] == 1): ?>checked=""<?php endif; ?> data-db="ad" data-id="<?php echo htmlentities($vo['id']); ?>" name="open" lay-skin="switch" lay-filter="switchStatus" lay-text="ON|OFF"></td>
                <td>
                    <button class="btn btn-xs btn-default do-del" data-db="ad" data-id="<?php echo htmlentities($vo['id']); ?>" data-status="-1"><i class="fa fa-trash-o"></i> 删除</button>
                    <button class="btn btn-xs btn-primary" onclick="layer_show('编辑广告位','/admin/Operate/ad_edit.html?id=<?php echo htmlentities($vo['id']); ?>',800,520)"><i class="fa fa-edit"></i> 编辑</button>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <?php echo $list; ?>
    </div>
</div>

</body>
</html>
