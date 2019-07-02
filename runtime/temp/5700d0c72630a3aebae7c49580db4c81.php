<?php /*a:2:{s:65:"/home/wwwroot/ytshop/application/admin/view/order/order_info.html";i:1525682676;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                        <div>基本信息</div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">订单编号:</label>
                            <label class="col-sm-2 control-label"><?php echo htmlentities($info['order_sn']); ?></label>

                            <label class="col-sm-2 control-label">交易时间:</label>
                            <label class="col-sm-2 control-label"><?php echo htmlentities(date("Y-m-d H:i",!is_numeric($info['create_time'])? strtotime($info['create_time']) : $info['create_time'])); ?></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">买家:</label>
                            <label class="col-sm-2 control-label"><?php echo htmlentities($info['nickname']); ?></label>

                            <label class="col-sm-2 control-label">收货人:</label>
                            <label class="col-sm-2 control-label"><?php echo htmlentities($info['consignee']); ?></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">收货地址:</label>
                            <label class="col-sm-2 control-label"><?php echo htmlentities($info['address']); ?></label>

                            <label class="col-sm-2 control-label">收货人电话:</label>
                            <label class="col-sm-2 control-label"><?php echo htmlentities($info['mobile']); ?></label>
                        </div>

                        <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="80%" color=#987cb9 SIZE=3>
                        <div>商品信息</div>
                        <?php if(is_array($detail) || $detail instanceof \think\Collection || $detail instanceof \think\Paginator): $i = 0; $__LIST__ = $detail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">商品名称:</label>
                                <label class="col-sm-2 control-label"><?php echo htmlentities($vo['goods_name']); ?></label>

                                <label class="col-sm-2 control-label">单价:</label>
                                <label class="col-sm-2 control-label"><?php echo htmlentities($vo['goods_price']/100); ?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">购买量:</label>
                                <label class="col-sm-2 control-label"><?php echo htmlentities($vo['goods_num']); ?></label>

                                <label class="col-sm-2 control-label">属性:</label>
                                <label class="col-sm-2 control-label"><?php echo htmlentities($info['spec_key_name']); ?></label>
                            </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="80%" color=#987cb9 SIZE=3>
                        <div>费用信息</div>
                        <div class="form-group">

                            <label class="col-sm-2 control-label">商品总价:</label>
                            <label class="col-sm-2 control-label"><?php echo htmlentities($info['total_price']/100); ?></label>

                            <label class="col-sm-2 control-label">运费:</label>
                            <label class="col-sm-2 control-label">￥0</label>
                        </div>

                        <?php if($info['logistics_status'] == 1): ?>
                        <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="80%" color=#987cb9 SIZE=3>
                        <div>物流信息</div>
                        <div class="form-group">

                            <label class="col-sm-2 control-label">物流公司:</label>
                            <label class="col-sm-2 control-label">
                                <?php switch($info['logistics_name']): case "SF": ?>顺丰<?php break; case "HTKY": ?>百世汇通<?php break; case "ZTO": ?>中通<?php break; case "STO": ?>申通<?php break; case "YTO": ?>圆通<?php break; case "YD": ?>韵达<?php break; case "EMS": ?>EMS<?php break; case "DBL": ?>德邦<?php break; case "YZPY": ?>邮政快递<?php break; endswitch; ?>
                            </label>

                            <label class="col-sm-2 control-label">物流单号:</label>
                            <label class="col-sm-2 control-label"><?php echo htmlentities($info['logistics_code']); ?></label>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-mint" onclick="layer_show('修改单号信息','/admin/Order/goods_update?oid=<?php echo htmlentities($vo['order_id']); ?>',600,400)">修改单号信息</a>
                            <!--<a class="btn btn-mint" onclick="layer_show('物流信息','/admin/Order/goods_progress?oid=<?php echo htmlentities($vo['order_id']); ?>',600,400)">查看物流信息</a>-->
                        </div>
                        <?php endif; ?>
                        <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="80%" color=#987cb9 SIZE=3>
                        <div>操作记录</div>
                        <br>
                        <div class="form-group">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>操作者</th>
                                    <th>操作时间</th>
                                    <th>描述</th>
                                    <th>备注</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($action) || $action instanceof \think\Collection || $action instanceof \think\Paginator): $i = 0; $__LIST__ = $action;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <tr>
                                    <th scope="row"><?php switch($vo['action_user']): case "": ?>用户<?php break; default: ?>管理员
                                        <?php endswitch; ?></th>
                                    <td><?php echo htmlentities(date("Y-m-d H:i",!is_numeric($vo['log_time'])? strtotime($vo['log_time']) : $vo['log_time'])); ?></td>
                                    <td><?php echo htmlentities($vo['status_desc']); ?></td>
                                    <td><?php echo htmlentities($vo['action_note']); ?></td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <?php if($info['logistics_status'] == 0 and $info['order_status'] == 3): ?>
                            <div class="col-sm-10 col-sm-offset-2">
                                <a class="btn btn-mint" onclick="layer_show('提交发货信息','/admin/Order/goods_send?oid=<?php echo htmlentities($vo['order_id']); ?>',800)">发货</a>
                                <button type="reset" onclick="layer_close()" class="btn btn-warning">关闭</button>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $('.test-test').click(function(){
        var id=$(this).data('id');
        var status=$(this).data('status');

        layer.prompt({title: '随便写点啥，并确认', formType: 2}, function(text, index){
            layer.close(index);
            ajax('/admin/Order/action',{id:id,status:status,text:text},function(data){
                if(data.status){
                    layer.msg(data.info, {icon: 1,time: 1000 }, function(){
                        location.reload();
                    });
                }else{
                    layer.msg(data.info,{icon:2});
                }
            })
        });
    })
</script>

</body>
</html>
