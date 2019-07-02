<?php /*a:2:{s:64:"/home/wwwroot/ytshop/application/admin/view/goods/goods_add.html";i:1525415620;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                            <label class="col-sm-2 control-label">商品名称<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="title" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品名称" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品分类<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="type_id">
                                    <option value="">请选择商品分类</option>
                                    <?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品品牌<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="brand_id">
                                    <option value="">所有品牌</option>
                                    <?php if(is_array($brand) || $brand instanceof \think\Collection || $brand instanceof \think\Paginator): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品价格<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="price" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品价格 （最多允许两位小数）" class="form-control" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">市场价<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="original_price" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品原价 （最多允许两位小数）" class="form-control" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">固定计费<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="expenses" value="" lay-verify="required" autocomplete="off" placeholder="请输入固定计费（用于计算产生的租赁费用）" class="form-control" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-7 control-label" style="color: #999999">
                                计算公式，如：  21< N ≤181,租赁计费，F=固定计费（租赁费用=550）
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-8 control-label" style="color: #999999">
                                N>181,租赁费用=固定计费+（实际租赁天数-181）*租赁费率（F=550+（N-181）*0.1）
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品缩略图</label>
                            <div class="col-sm-10">
                                <img class="j-addimg" data-width="60" data-height="60" src="/static/admin/img/no_image.png" width="80px" alt="">
                                <input type="image" name="img" class="head_img" value="" style="opacity: 0">
                                <input type="file" name="upfile" class="form-control j-file hidden" value="" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品详情展示图</label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-primary btn-file j-upload-more"  lay-data="{data:{name: 'image_url', folder: 'shop'}}"></i><i class="fa fa-folder-open-o"></i>&nbsp;上传图片...</button>
                                <div class="file-list clearfix"><ul></ul></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">设置为精品</label>
                            <div class="col-sm-10">
                                <input type="checkbox" checked="" value="1"  lay-filter="status" name="is_quality" lay-skin="switch" lay-text="ON|OFF" title="开关">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">设置为新品</label>
                            <div class="col-sm-10">
                                <input type="checkbox" checked="" value="1"  lay-filter="status" name="is_new" lay-skin="switch" lay-text="ON|OFF" title="开关">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">设置为热销</label>
                            <div class="col-sm-10">
                                <input type="checkbox" checked="" value="1"  lay-filter="status" name="is_hot" lay-skin="switch" lay-text="ON|OFF" title="开关">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品描述</label>
                            <div class="col-sm-10">
                                <textarea id="editor" name="description" type="text/plain" style="width:100%;height:300px;"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">品牌<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="brands" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品参数" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">厂商型号<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="model" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品参数" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">颜色分类<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="color" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品参数" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">适用年龄<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="use_age" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品参数" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">配件<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="parts" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品参数" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品条形码<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="bar_code" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品参数" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">重量<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="weight" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品参数" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">承重<i class="red">*</i></label>
                            <div class="col-sm-10">
                                <input type="text" name="bearing" value="" lay-verify="required" autocomplete="off" placeholder="请输入商品参数" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <button class="btn btn-mint" lay-submit="" lay-filter="addshop">提交</button>
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
<script type="text/javascript" charset="utf-8" src="/static/admin/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/admin/lib/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/admin/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
    var ue = UE.getEditor('editor');
</script>
<script>
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(addshop)', function(data){
            if(!data.field.type_id){
                layer.msg('请选择商品分类！');return false;
            }
            if(!data.field.brand_id){
                layer.msg('请选择商品品牌！');return false;
            }
            data.field.is_quality =data.field.is_quality?1:0;
            data.field.is_new =data.field.is_new?1:0;
            data.field.is_hot =data.field.is_hot?1:0;
            ajax("<?php echo url('Goods/goods_add'); ?>",data.field,function (data) {
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
