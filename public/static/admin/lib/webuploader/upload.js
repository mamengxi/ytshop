var uploadPicForm= function(obj) {
     obj = obj || {};
     domTarget = obj.target;
     paraValue = obj.paraValue || 3;
     success = obj.success;
     err = obj.err;
     //动态创建form表单
     $('form#form').remove();
     var formHtm = '<form id="form" enctype="multipart/form-data" encoding="multipart/form-data" target="uploadiframe" action="/admin/Index/upload?type=1&folder=activity" method="post">' +
         '<input style="position:absolute;width:100%;height:100%;left:0;font-size:0px;opacity: 0;filter: alpha(opacity=0);cursor: pointer;z-index:2" type="file" id="file" name="file[]" accept="image/jpg,image/jpeg,image/png,image/gif" multiple="">' +
         '<input type="hidden" name="type" value="' + paraValue + '">' +
         '<iframe id="uploadiframe" name="uploadiframe" style="display:none"></iframe></form>';
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
                 var result = JSON.parse(content);
                 //关闭setInterval()循环函数
                 window.clearInterval(self.timeid);
                 $('form#form').remove();
                 if (result.status) {
                     success && success(result.list);
                 } else {
                     err && err(result.info);
                 }

             }
         });
     });
     if (!window.ActiveXObject) {
         $file.trigger('click');
     }
 };

               
function uploadPicForm2(that){
    uploadPicForm({
        target:that,
        paraValue: 3,
        success: function(data) {
           
        },
        err: function(err) {
           
        }
    });
}