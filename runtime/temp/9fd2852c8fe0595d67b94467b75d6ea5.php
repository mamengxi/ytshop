<?php /*a:2:{s:67:"/home/wwwroot/ytshop/application/admin/view/lease/lease_detail.html";i:1525845023;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                <form class="layui-form form-horizontal" action="javascript:;">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">订单编号</label>
                            <div class="col-sm-10">
                                <input type="text" name="order_num" value="<?php echo htmlentities($list['order_sn']); ?>" lay-verify="required" autocomplete="off" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">订单总额</label>
                            <div class="col-sm-10">
                                <input type="text" name="total_price" value="<?php echo htmlentities(unFormatMoney($list['total_price'])); ?>" lay-verify="required" autocomplete="off" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">申请用户</label>
                            <div class="col-sm-10">
                                <input type="text" name="consignee" value="<?php echo htmlentities($list['consignee']); ?>" lay-verify="required" autocomplete="off" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户联系方式</label>
                            <div class="col-sm-10">
                                <input type="text" name="mobile" value="<?php echo htmlentities($list['mobile']); ?>" lay-verify="required" autocomplete="off" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">退车说明</label>
                            <div class="col-sm-10">
                                <textarea type="text" name="illustrate" autocomplete="off" class="form-control" readonly=""><?php echo htmlentities($list['illustrate']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">退货类型</label>
                            <div class="col-sm-10">
                                <?php if($list['service_type'] == 1): ?>
                                <input type="text" name="service_type" value="质量问题" class="form-control" readonly="">
                                <?php elseif($list['service_type'] == 2): ?>
                                <input type="text" name="service_type" value="租赁还车" class="form-control" readonly="">
                                <?php else: ?>
                                <input type="text" name="service_type" value="其他" class="form-control" readonly="">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">租赁开始时间</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" value="<?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($list['logistics_time'])? strtotime($list['logistics_time']) : $list['logistics_time'])); ?>" lay-verify="required" autocomplete="off" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">退款处理</label>
                            <div class="col-sm-10">
                                <?php switch($list['type_id']): case "7": ?><input type="text" name="type" value="此商品属于B类商品，不产生租赁费用" class="form-control" readonly="">
                                <?php break; default: ?>
                                <input type="text" name="type" value="已产生费用<?php echo htmlentities(count_expenses($list['logistics_time'],$lease['start_time'],$lease['end_time'],$list['expenses'],$lease['rate'],$list['total_price'],$list['goods_num'])); ?>元，需退金额<?php echo htmlentities(Retreat_expenses($list['logistics_time'],$lease['start_time'],$lease['end_time'],$list['expenses'],$lease['rate'],$list['total_price'],$list['goods_num'])); ?>元" class="form-control" readonly="">
                                <?php endswitch; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">图片凭证</label>
                            <div class="col-sm-10">
                                <div class="file-list clearfix"><ul>
                                    <?php if(is_array($list['images']) || $list['images'] instanceof \think\Collection || $list['images'] instanceof \think\Paginator): if( count($list['images'])==0 ) : echo "" ;else: foreach($list['images'] as $key=>$i): ?>
                                    <li><img layer-src="<?php echo htmlentities(thumb_to_big($i)); ?>" src="<?php echo htmlentities((isset($i) && ($i !== '')?$i:"/static/admin/img/no_image.png")); ?>"></li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                    <input name="image_url" class="file-list-input" type="hidden" value="<?php echo htmlentities($list['image']); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo htmlentities($list['id']); ?>">
                    <div class="row">
                        <div class="form-group">
                            <?php switch($list['type_id']): case "7": if($list['isagree_money'] == 3): ?>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button class="btn btn-mint agree" data-id="<?php echo htmlentities($list['id']); ?>" data-status="4" data-price="<?php echo htmlentities(unFormatMoney($list['total_price'])); ?>"  data-filter="isagree_money">同意退款&nbsp <span style="color: #FFCC00;"><?php echo htmlentities(unFormatMoney($list['total_price'])); ?></span>元</button>
                                </div>
                                <?php elseif($list['isagree_money'] == 4): ?>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="btn" class="btn btn-warning">已处理</button>
                                </div>
                                <?php endif; break; default: if($list['isagree_money'] == 3): ?>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button class="btn btn-mint agree" data-id="<?php echo htmlentities($list['id']); ?>" data-status="4" data-price="<?php echo htmlentities(Retreat_expenses($list['logistics_time'],$lease['start_time'],$lease['end_time'],$list['expenses'],$lease['rate'],$list['total_price'],$list['goods_num'])); ?>"  data-filter="isagree_money">同意退款&nbsp <span style="color: #FFCC00;"><?php echo htmlentities(Retreat_expenses($list['logistics_time'],$lease['start_time'],$lease['end_time'],$list['expenses'],$lease['rate'],$list['total_price'],$list['goods_num'])); ?></span>元</button>
                                </div>
                                <?php elseif($list['isagree_money'] == 4): ?>
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="btn" class="btn btn-warning">已处理</button>
                                </div>
                                <?php endif; endswitch; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.agree').click(function(e){
        var status = e.currentTarget.dataset.status;
        var id = e.currentTarget.dataset.id;
        var filter = e.currentTarget.dataset.filter;
        var refund = e.currentTarget.dataset.price;
        $.post("<?php echo url('Lease/Lease_detail',['id'=>$list['order_id']]); ?>",{sid:id,status:status,filter:filter,refund:refund},function(data){
            if(data.status){
                layer.msg(data.info, {icon: 1,time: 1000 }, function(){
                    parent.location.reload();
                });
            }else{
                layer.msg(data.info,{icon:2});
            }
        })
    })
</script>

</body>
</html>
