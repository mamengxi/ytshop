<?php /*a:2:{s:66:"/home/wwwroot/ytshop/application/admin/view/product/kind_edit.html";i:1525252088;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                            <label class="col-sm-3 control-label">种类编号</label>
                            <div class="col-sm-9">
                                <input type="text" name="id" lay-verify="required" readonly="true" value="<?php echo htmlentities($info['id']); ?>" autocomplete="off" placeholder="请输入种类编号" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">种类名称</label>
                            <div class="col-sm-9">
                                <input type="text" name="title" lay-verify="required" value="<?php echo htmlentities($info['title']); ?>" minlength="1" maxlength="10" autocomplete="off" placeholder="请输入种类名称" class="form-control" >
                            </div>
                        </div>
                        <!--<div class="form-group">-->
                            <!--<label class="col-sm-3 control-label">种类展示图</label>-->
                            <!--<div class="col-sm-9">-->
                                <!--<button type="button" class="btn btn-primary btn-file j-upload-one"  lay-data="{data:{name: 'img', folder: 'shop'}}"></i><i class="fa fa-folder-open-o"></i>&nbsp;修改图片...</button>-->
                                <!--<div class="file-list clearfix">-->
                                    <!--<ul>-->
                                        <!--<li><img src="<?php echo htmlentities($info['image']); ?>" style="width: 220px;height: 120px;"/></li>-->
                                    <!--</ul>-->
                                    <!--<input name="img" class="file-list-input" type="hidden" value="<?php echo htmlentities($info['image']); ?>">-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">启用</label>
                            <div class="col-sm-9">
                                <input type="checkbox" <?php if($info['status'] == 1): ?>checked=""<?php endif; ?> value="1"  lay-filter="status" name="status" lay-skin="switch" lay-text="ON|OFF" title="开关">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button class="btn btn-mint" lay-submit="" data-url="/admin/Product/kind_edit" lay-filter="submit">提交</button>
                                <button type="reset" onclick="layer_close()" class="btn btn-warning">关闭</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="cropper ibox-content" style="display: none">
    <form class="avatar-form" action="" enctype="multipart/form-data" method="post">
        <link href="/static/admin/lib/cropper/cropper.css" rel="stylesheet">
        <div class="row">
            <div class="col-sm-8">
                <div class="img-container">
                    <img src="" alt="">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="docs-preview clearfix">
                    <div class="img-preview preview-lg" style="width: 120px;height: 120px"></div>
                    <div class="img-preview preview-md" style="width: 60px;height: 60px"></div>
                    <!-- <div class="img-preview preview-sm"></div>
                    <div class="img-preview preview-xs"></div> -->
                </div>
                <div class="docs-data" style="display: none">
                    <div class="input-group">
                        <label class="input-group-addon" for="dataX">X</label>
                        <input class="form-control" name="x" id="dataX" type="text" placeholder="x">
                        <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon" for="dataY">Y</label>
                        <input class="form-control" name="y" id="dataY" type="text" placeholder="y">
                        <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon" for="dataWidth">Width</label>
                        <input class="form-control" name="w" id="dataWidth" type="text" placeholder="width">
                        <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon" for="dataHeight">Height</label>
                        <input class="form-control" name="h" id="dataHeight" type="text" placeholder="height">
                        <span class="input-group-addon">px</span>
                    </div>

                </div>
                <div class="btn-group">
                    <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                        <input class="sr-only" id="inputImage" name="upfile" type="file" accept="image/*">
                        <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                            <i class="fa fa-folder-open-o"></i>&nbsp;选择
                            </span>
                    </label>
                    <button type="button" class="btn btn-primary j-crop"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;提交</button>
                </div>
            </div>
        </div>
        <script src="/static/admin/lib/cropper/cropper.js"></script>
        <script src="/static/admin/lib/cropper/main.js"></script>
    </form>
</div>
<script>
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(addshop)', function(data){
            if(!data.field.kind_id){
                layer.msg('请选择商品品牌！');return false;
            }
            ajax("<?php echo url('Product/product_add'); ?>",data.field,function (data) {
                if(data.status){
                    layer.msg(data.msg, {
                        icon: 1,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function(){
                        layer_close();
                        parent.location.reload();
                    });
                }else{
                    layer.msg(data.msg, {
                        icon: 2,
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    });
                }
            });
            return false;
        });
    });
    $('.j-addimg').on('click',function() {
        //捕获页
        layer.open({
            type: 1,
            shade: false,
            zIndex: 1000,
            skin: 'layui-layer-rim', //加上边框
            area: ['600px', '395px'],//宽高
            title: '裁剪图片',//不显示标题
            content: $('.cropper'),//捕获的元素
        });
    })

    // 截图
    $('.j-crop').on('click',function() {
        var formData = new FormData($(".avatar-form")[0]);
        // console.log(formData.status);return;
        $.ajax({
            url: "/admin/Index/crop.html",
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                index = layer.load()
            },
            success: function(data) {
                if (data.status) {
                    $('.j-addimg').attr('src', data.info);
                    $('.head_img').val(data.info);
                    layer.closeAll('page');
                } else {
                    layer.msg(data.info);
                }
            },
            complete: function() {
                layer.close(index);
            },
            error: function(data) {
                alert('错误！');
            }
        });
    });
</script>


</body>
</html>
