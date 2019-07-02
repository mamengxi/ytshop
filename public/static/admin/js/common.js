$(document).ready(function () {
    var $srcImgDiv = null;
    //全选的实现
    $(".check-all").click(function(){
        $(".ids").prop("checked", this.checked);
    });
    $(".ids").click(function(){
        var option = $(".ids");
        option.each(function(i){
            if(!this.checked){
                $(".check-all").prop("checked", false);
                return false;
            }else{
                $(".check-all").prop("checked", true);
            }
        });
    });


    //公共操作
    //删除
    $('.do-del').on('click',function(){
        var db=$(this).data('db'),
            id=$(this).data('id'),
            status=$(this).data('status');
        index=$(this).data('index')||'id';
        field=$(this).data('field')||'status';
        layer.confirm('确定该操作么？', {
            title: '提示',
            btnAlign: 'c',
            resize: false,
            icon: 3,
            btn: ['确定', '容朕想想'],
            yes: function () {
                ajax('/admin/Index/do_del',{id:id,db:db,status:status,index:index,field:field},function(data){
                    if(data.status){
                        layer.msg(data.info, {icon: 1,time: 1000 }, function(){
                            location.reload();
                        });
                    }else{
                        layer.msg(data.info,{icon:2});
                    }
                })
            }
        });
    })
    //全选删除
    $('.do-del-all').on('click',function(){
        var ids='';
        $('.ids:checked').each(function(){
            ids += $(this).val()+',';
        })
        ids=ids.replace(/(^,)|(,$)/g,'');
        if(ids==''){
            layer.msg('请选择要操作的数据');
            return false;
        }
        var db=$(this).data('db');
        var status=$(this).data('status');
        layer.confirm('确定该操作么？', {
            title: '提示',
            btnAlign: 'c',
            resize: false,
            icon: 3,
            btn: ['确定', '容朕想想'],
            yes: function () {
                ajax('/admin/Index/do_del_all',{id:ids,db:db,status:status},function(data){
                    if(data.status){
                        layer.msg(data.info, {icon: 1,time: 1000 }, function(){
                            location.reload();
                        });
                    }else{
                        layer.msg(data.info,{icon:2});
                    }
                })
            }
        });
    })

    //搜索下拉
    $('.search-box .dropdown-menu a').on('click',function(){
        var text=$(this).text();
        var data=$(this).attr('j-data')
        $('.search-box .j-text').text(text);
        $('.search-box .j-data').attr('name',data);
        $('.search-box .j-data').attr('placeholder','请输入'+text);
    })
})

layui.use(['form','laydate','upload','layer'], function(){
    var form = layui.form,
        laydate = layui.laydate,
        layer = layui.layer,
        upload =layui.upload;
    //查看大图
    layer.photos({
        photos: '.show-pic'
        ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    });
    //日期插件
    var start = {
        elem: '#start1',
        format: 'YYYY-MM-DD hh:mm:ss',
        min:'2017-3-31',
        max:'2066-10-20',
        istime: true,
        istoday: true,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end1',
        format: 'YYYY-MM-DD hh:mm:ss',
        min:'2017-3-31',
        max:'2066-10-20',
        istime: true,
        istoday: false,
        choose: function(datas){
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate.render({
        elem: '#laydate-start' //指定元素
    });
    laydate.render({
        elem: '#laydate-end' //指定元素
    });
    //公共switch改变状态
    form.on('switch(switchStatus)', function(data){
        var db=$(this).data('db');
        var id=$(this).data('id');
        var index=$(this).data('index')||'id';
        var field=$(this).data('field')||'status';
        var status=this.checked ? '1' : '0'
        ajax('/admin/Index/do_del',{id:id,db:db,status:status,index:index,field:field},function(data){
            if(data.status){
                layer.msg(data.info, {icon: 1,time: 1000 });
            }else{
                layer.msg(data.info,{icon:2});
            }
        })
    });
    //公共表单ajax提交
    form.on('submit(submit)', function(data){
        data.field.status=data.field.status?1:0;
        url=$(this).data('url');
        ajax(url,data.field,function(data){
            if(data.status){
                layer.msg(data.info, {
                    icon: 1,
                    time: 1000 //1秒关闭（如果不配置，默认是3秒）
                }, function(){
                    layer_close();
                    parent.location.reload();
                });
            }else{
                layer.msg(data.info, {
                    icon: 2,
                    time: 1000 //1秒关闭（如果不配置，默认是3秒）
                });
            }
        })
        return false;
    });

    //多文件上传
    upload.render({
        elem: '.j-upload-more'
        ,multiple:true
        ,url: '/admin/Index/upload' //上传接口
        ,before: function(obj){ //上传前do something
            layer.load(); //上传loading
        }
        ,done: function(res, index, upload){
            layer.closeAll('loading'); //关闭loading
            if(res.status){
                var item = this.item;
                var name=this.data.name;
                if($("input[name="+name+"]").length<=0){
                    item.parent().find('.file-list').append("<input name='"+name+"' class='file-list-input' type='hidden' value=''>");
                }
                layer.msg('上传成功')
                var img_src=$("input[name="+name+"]").val()+',';
                img_src+=res.url+',';
                img_src=img_src.replace(/(^,)|(,$)/g,'');
                $("input[name="+name+"]").val(img_src);
                item.parent().find('.file-list ul').append("<li><img src="+res.url+"><span>X</span></li>");
            }else{
                layer.msg(res.msg)
            }
        }
        ,allDone:function(obj){
            console.log("全部上传");
            console.log(obj);
        }
        ,error: function(index, upload){
            layer.closeAll('loading'); //关闭loading
        }
    });

    //单文件上传
    upload.render({
        elem: '.j-upload-one'
        ,multiple:false
        ,url: '/admin/Index/upload' //上传接口
        ,before: function(obj){ //上传前do something
            layer.load(); //上传loading
        }
        ,done: function(res, index, upload){
            layer.closeAll('loading'); //关闭loading
            if(res.status){
                var item = this.item;
                var name=this.data.name;
                if($("input[name="+name+"]").length<=0){
                    item.parent().find('.file-list').append("<input name='"+name+"' type='hidden' value=''>");
                }
                layer.msg('上传成功')
                $("input[name="+name+"]").val(res.url);
                item.parent().find('.file-list ul').html("<li><img src="+res.url+"><span>X</span></li>");
            }else{
                layer.msg('上传失败')
            }
        }
        ,error: function(index, upload){
            layer.closeAll('loading'); //关闭loading
        }
    });
});
// 公共ajax封装
function ajax(url,data,fn,obj){
    obj=obj||{};
    type=obj.type||'POST';
    dataType=obj.dataType||'json';
    var index='';
    $.ajax({
        url:url,
        type:type,
        async: true,
        dataType: dataType,
        data:data,
        beforeSend: function () {
            index=layer.load()
        },
        success: function (data) {
            if(data.code==0){
                layer.msg(data.msg);
                return;
            }
            fn(data)
        },
        complete: function () {
            layer.close(index);
        },
        error: function (data) {
            layer.msg('请求错误');
        },

    })
    // console.log(data);
}

/**
 * 弹出iframe
 * @Author   jiayangyang
 * @DateTime 2017-02-20T16:37:11+0800
 * @param    {[type]}                 title [标题]
 * @param    {[type]}                 url   [地址]
 * @param    {[type]}                 w     [宽]
 * @param    {[type]}                 h     [高]
 * @return   {[type]}                       [description]
 */
function layer_show(title,url,w,h){
    if (title == null || title == '') {
        title=false;
    };
    if (w == null || w == '') {
        w=800;
    };
    if (h == null || h == '') {
        h=($(window).height() - 50);
    };
    //$.get(url, function(result){
    //    if(result.code==0){
    //        layer.msg(result.msg);
    //        return;
    //    }
    layer.open({
        type: 2,
        area: [w+'px', h +'px'],
        fix: false, //不固定
        maxmin: true,
        zIndex:1989,
        skin: 'layui-layer-rim', //加上边框
        shade:0.4,
        title: title,
        content: url
    });
    //});
}


//关闭iframe窗口
function layer_close(){
    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
    parent.layer.close(index); //再执行关闭
}

//弹出百度编辑器图片上传的对话框
function upImage() {
    var myImage = _editor.getDialog("insertimage");
    myImage.open();
}

//图片上传
var uploadPicForm= function(obj) {
    obj = obj || {};
    domTarget = obj.target;
    success = obj.success;
    err = obj.err;
    url=obj.url;
    single=obj.single;
    //动态创建form表单
    $('form#form').remove();
    if(single==1){
        var formHtm = '<form id="form" enctype="multipart/form-data" encoding="multipart/form-data" target="uploadiframe" action="'+url+'" method="post">' +
            '<input style="position:absolute;left:0;font-size:0px;opacity: 0;filter: alpha(opacity=0);cursor: pointer;z-index:2" type="file" id="file" name="file[]" accept="image/jpg,image/jpeg,image/png,image/gif">' +
            '<iframe id="uploadiframe" name="uploadiframe" style="display:none"></iframe></form>';
    }else{
        var formHtm = '<form id="form" enctype="multipart/form-data" encoding="multipart/form-data" target="uploadiframe" action="'+url+'" method="post">' +
            '<input style="position:absolute;left:0;font-size:0px;opacity: 0;filter: alpha(opacity=0);cursor: pointer;z-index:2" type="file" id="file" name="file[]" accept="image/jpg,image/jpeg,image/png,image/gif" multiple="">' +
            '<iframe id="uploadiframe" name="uploadiframe" style="display:none"></iframe></form>';
    }

    $(formHtm).insertBefore(domTarget);
    var $file = $('#file');
    var self = this;
    $file.change(function() {
        //立即执行回调函数
        (function(callback) {
            //表单提交上传
            $('#form').submit();
            self.timeid = setInterval(callback, 200);
        })(function() {
            var content = $('#uploadiframe')[0].contentDocument.body && $('#uploadiframe')[0].contentDocument.body.innerText;
            if (content) {
                //console.log(content);
                var result = JSON.parse(content);
                //关闭setInterval()循环函数
                window.clearInterval(self.timeid);
                $('form#form').remove();
                if (result.status) {
                    success && success(result);
                } else {
                    err && err(result);
                }

            }
        });
    });
    if (!window.ActiveXObject) {
        $file.trigger('click');
    }
};

function upload_file(that){
    var name=that.getAttribute('data-name');
    var url=that.getAttribute('data-url');
    var single=that.getAttribute('data-single');
    uploadPicForm({
        target:that,
        url:url,
        single:single,
        success: function(data) {
            if(data.status){
                if($('.file-list-input').length<=0){
                    $('.file-list').append("<input name='"+name+"' class='file-list-input' type='hidden' value=''>");
                }
                if(single==0){
                    var img_src=$('.file-list-input').val()+',';
                    for (var i = 0; i < data.list.length; i++) {
                        $('.file-list ul').append("<li><img src="+data.list[i]+"><span>X</span></li>");
                        img_src+=data.list[i]+',';
                    }
                    img_src=img_src.replace(/(^,)|(,$)/g,'');
                    $('.file-list-input').val(img_src);
                }else{
                    if($('.file-list ul img').length<=0){
                        $('.file-list ul').append("<li><img src="+data.list[0]+"><span>X</span></li>");

                    }else{
                        $('.file-list ul img').attr('src',data.list[0]);
                    }
                    $('.file-list-input').val(data.list[0]);
                }
            }else{
                layer.msg('上传失败')
            }
        },
        err: function(err) {
            layer.msg('请求失败')
        }
    });
}
function upload_file1(that){
    var name=that.getAttribute('data-name');
    var url=that.getAttribute('data-url');
    var single=that.getAttribute('data-single');
    uploadPicForm({
        target:that,
        url:url,
        single:single,
        success: function(data) {
            if(data.status){
                if($('.file-list-input1').length<=0){
                    $('.file-list1').append("<input name='"+name+"' class='file-list-input1' type='hidden' value=''>");
                }
                if(single==0){
                    var img_src=$('.file-list-input1').val()+',';
                    for (var i = 0; i < data.list.length; i++) {
                        $('.file-list1 ul').append("<li><img src="+data.list[i]+"><span>X</span></li>");
                        img_src+=data.list[i]+',';
                    }
                    img_src=img_src.replace(/(^,)|(,$)/g,'');
                    $('.file-list-input1').val(img_src);
                }else{
                    if($('.file-list1 ul img').length<=0){
                        $('.file-list1 ul').append("<li><img src="+data.list[0]+"><span>X</span></li>");

                    }else{
                        $('.file-list1 ul img').attr('src',data.list[0]);
                    }
                    $('.file-list-input1').val(data.list[0]);
                }
            }else{
                layer.msg('上传失败')
            }
        },
        err: function(err) {
            layer.msg('请求失败')
        }
    });
}
//删除图片
$(document).on('click', '.file-list span', function(e) {
    var that=$(this).parents('.file-list').find('input')
    $(this).parent('li').remove();
    var img_src='';
    $('.file-list li img').each(function(){
        img_src += $(this).attr('src')+',';
    })
    img_src=img_src.replace(/(^,)|(,$)/g,'');
    that.val(img_src)
})

//图片拖动排序

$(document).on('dragstart', '.file-list li img', function() {
    $srcImgDiv = $(this).parent();
});
// 拖动到.drop-left,.drop-right上方时触发的事件
$(document).on('dragover', '.file-list li img', function(event) {
    // 必须通过event.preventDefault()来设置允许拖放
    event.preventDefault();
});
// 结束拖动放开鼠标的事件
$(document).on('drop', '.file-list li img', function(event) {
    event.preventDefault();
    if($srcImgDiv[0] != $(this).parent()[0]) {
        var o_src=$srcImgDiv.find('img').attr('src');
        var n_src=$(this).attr('src');
        $(this).attr('src',o_src);
        $srcImgDiv.find('img').attr('src',n_src);
        var img_src='';
        $('.file-list li img').each(function(){
            img_src += $(this).attr('src')+',';
        })
        img_src=img_src.replace(/(^,)|(,$)/g,'');
        $(this).parents('.file-list').find('input').val(img_src)
    }
});

//序列化表单成json
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if(this.value!==""){
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        }

    });
    return o;
};

function cache(){
    ajax('/admin/Index/clearCache',{},function(data){
        if(data.status){
            layer.msg(data.info, {icon: 1,time: 1000 });
        }else{
            layer.msg(data.info,{icon:2});
        }
    })
}