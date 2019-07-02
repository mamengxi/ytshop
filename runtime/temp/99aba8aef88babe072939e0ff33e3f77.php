<?php /*a:2:{s:63:"/home/wwwroot/ytshop/application/admin/view/user/user_edit.html";i:1526010982;s:62:"/home/wwwroot/ytshop/application/admin/view/public/iframe.html";i:1523434691;}*/ ?>
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
                        <div class="form-group">
                            <label class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-10">
                                <input type="text" name="nickname" readonly="" value="<?php echo htmlentities($info['nickname']); ?>" lay-verify="required" autocomplete="off" placeholder="请输入用户名" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" readonly="" value="<?php echo htmlentities($info['password']); ?>" lay-verify="required" autocomplete="off" placeholder="请输入密码" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">真实姓名</label>
                            <div class="col-sm-10">
                                <input type="text" name="real_name" value="<?php echo htmlentities($info['real_name']); ?>" autocomplete="off" placeholder="请输入用户名" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机号</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" value="<?php echo htmlentities($info['phone']); ?>" lay-verify="required" autocomplete="off" placeholder="请输入手机号" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户头像</label>
                            <div class="col-sm-10">
                                <img class="j-addimg" data-width="60" data-height="60" src="<?php echo htmlentities((isset($info['head_img']) && ($info['head_img'] !== '')?$info['head_img']:'/static/admin/img/no_image.png')); ?>" width="80px" alt="">
                                <input type="hidden" name="head_img" class="head_img" value="<?php echo htmlentities($info['head_img']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">性别</label>
                            <div class="col-sm-10">
                                <input type="radio" name="sex" value="1" title="男" <?php if($info['sex'] == 1): ?>checked=""<?php endif; ?>>
                                <input type="radio" name="sex" value="2" title="女" <?php if($info['sex'] == 2): ?>checked=""<?php endif; ?>>
                                <input type="radio" name="sex" value="3" title="保密" <?php if($info['sex'] == 3): ?>checked=""<?php endif; ?>>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">身份证号</label>
                            <div class="col-sm-10">
                                <input type="text" name="id_card" value="<?php echo htmlentities($info['id_card']); ?>" autocomplete="off" placeholder="请输入身份证号" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">地址</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" value="<?php echo htmlentities($info['address']); ?>" autocomplete="off" placeholder="请输入地址" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">身份证</label>
                            <div class="col-sm-5">
                                <!--<button type="button" class="btn btn-primary btn-file j-upload-more"  lay-data="{data:{name: 'image_url', folder: 'shop'}}"></i><i class="fa fa-folder-open-o"></i>&nbsp;上传身份证正面...</button>-->
                                <div class="file-list clearfix"><ul>
                                    <li><img name="image_url1" src="<?php echo htmlentities((isset($info['id_img_front']) && ($info['id_img_front'] !== '')?$info['id_img_front']:"/static/admin/img/no_image.png")); ?>"></li>
                                </ul>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <!--<button type="button" class="btn btn-primary btn-file j-upload-more"  lay-data="{data:{name: 'image_url', folder: 'shop'}}"></i><i class="fa fa-folder-open-o"></i>&nbsp;上传身份证反面...</button>-->
                                    <div class="file-list clearfix"><ul>
                                        <li><img name="image_url2" src="<?php echo htmlentities((isset($info['id_img_back']) && ($info['id_img_back'] !== '')?$info['id_img_back']:"/static/admin/img/no_image.png")); ?>"></li>
                                    </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group">-->
                            <!--<label class="col-sm-2 control-label">是否启用</label>-->
                            <!--<div class="col-sm-10">-->
                                <!--<input type="checkbox" <?php if($info['status'] == 1): ?>checked=""<?php endif; ?> value="1"  lay-filter="status" name="status" lay-skin="switch" lay-text="ON|OFF" title="开关">-->
                            <!--</div>-->
                        <!--</div>-->
                    </div>
                    <input type="hidden" name="id" value="<?php echo htmlentities($info['id']); ?>">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <!--<button class="btn btn-mint" lay-submit="" data-url="<?php echo url('User/user_edit'); ?>" lay-filter="submit">提交</button>-->
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
