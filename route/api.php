<?php
/**
 * @Author xj
 * @Email job@ainiok.com
 * @Create Time: 2018/1/24 11:49
 */

Route::get('ainiok',function (){
    return "hello";
});
Route::pattern([
    'id' => '\d+'
]);
//Route::get('/','/admin/Index/index');

Route::group(['method'=>'get,post'],function(){
    Route::group('v1',function(){
        Route::rule('register','api/User/register');
        Route::rule('login','api/User/login');
        Route::rule('wxlogin','api/User/wxLogin'); //微信登录

        Route::rule('logout','api/User/logout');
        Route::rule('forget','api/User/forgetPassword'); //忘记密码
        Route::rule('repassword','api/Member/repassword'); //重置密码
        Route::rule('sendcode','api/Index/sendCode'); // 发送验证码
        Route::rule('upload','api/Index/upload'); //文件上传
        Route::rule('base64ToImg','api/Index/base64ToImg'); //保存base64图片
        Route::rule('thumb','api/Index/thumb'); //文件缩略图

        Route::rule('home','api/Home/index');  //首页接口
        Route::rule('search','api/Home/search');  //搜索
        Route::rule('catlist','api/Goods/catlist'); //分类列表
        Route::rule('catshops','api/Goods/catshops'); //根据分类id 获取商品列表
        Route::rule('show','api/Goods/show'); //根据分类id 获取商品信息
        Route::rule('attribute','api/Goods/getShopAttribute'); //根据商品id 获取属性
        Route::rule('shopComment','api/Goods/comments'); //根据商品id 获取商品评价

        //订单
        Route::rule('confirmation','api/Order/confirmation'); //确认订单
        Route::rule('unifiedorder','api/Pay/unifiedorder'); //提交订单
        Route::rule('continue','api/Pay/continuePay'); //继续支付订单
        Route::post('order','api/Order/getOrderInfo'); //支付成功后查询支付信息
        Route::rule('unOrder','api/Order/unOrder');   //取消订单
        Route::rule('delOrder','api/Order/delOrder');   //删除订单
        Route::rule('detail','api/Order/detail');   //订单详情
        Route::rule('step','api/Order/show');   //订单tab  1、待付款 2、待发货 3、待收货 4、已完成
        Route::rule('receipt','api/Order/receipt');  //确认收货
        Route::rule('addComment','api/Order/comment'); //添加商品评价

        //售后
        Route::rule('intoApply','api/Service/index');  //进入售后
        Route::rule('apply','api/Service/apply');  //申请售后
        Route::rule('applyDetail','api/Service/detail');  //申请售后
        Route::rule('cancel','api/Service/cancel');  //取消售后
        //物流
        Route::rule('logistic','api/Order/logistic');   //查看物流

        //  购物车
        Route::rule('cart','api/Cart/index'); // 购物车
        Route::rule('addcart','api/Cart/addCart'); // 添加购物车
        Route::rule('delCart','api/Cart/delCart'); // 删除购物车
        Route::rule('editCart','api/Cart/editCart'); // 编辑购物车

        Route::rule('member','api/Member/index');  //我的
        Route::rule('info','api/Member/getInfo');  //获取个人信息
        Route::rule('identity','api/Member/identity');  //获取个人认证
        Route::rule('comment','api/Member/comment');  //个人评论

        Route::rule('editInfo','api/Member/editInfo');  //获取个人信息

        Route::rule('bindPhone','api/Member/bindPhone');  //绑定手机号
        Route::rule('changePhone','api/Member/changePhone');  //更改手机号


        Route::rule('collect','api/Member/collect'); // 收藏列表
        Route::rule('actCollect','api/Member/actCollect'); // 添加/删除收藏
        Route::rule('feedback','api/Member/feedback'); //意见反馈

        Route::rule('addrList','api/Member/addrList'); //地址列表
        Route::rule('showAddr','api/Member/showAddr'); //查看地址
        Route::rule('address','api/Member/address'); //添加 / 修改地址
        Route::rule('delAddress','api/Member/delAddress'); //删除地址
        Route::rule('setAddr','api/Member/setCheckAddr'); //设置默认地址

        Route::rule('history','api/Member/history'); //历史记录
        Route::rule('addHistory','api/Member/addHistory'); //添加记录
        Route::rule('delHistory','api/Member/delHistory'); //删除记录

        Route::rule('push','api/Push/release'); //发布妈妈推
        Route::rule('pushList','api/Push/show'); //妈妈推列表
        Route::rule('myPushList','api/Push/myshow'); //我的妈妈推列表
        Route::rule('pushInfo','api/Push/show_detail'); //妈妈推详情
        Route::rule('pushComment','api/Push/comment'); //妈妈推详情评论
        Route::rule('pushCollect','api/Push/actColl'); //妈妈推收藏/取消收藏
        Route::rule('pushMsg','api/Push/message'); //妈妈推消息列表
        Route::rule('pushMsgClean','api/Push/clearList'); //妈妈推消息清空


        Route::rule('test','api/Index/test');
        Route::miss('api/index/miss'); // 找不到路由的时候到这

        //妈妈推
//        Route::rule('show','api/Push/show'); //妈妈推首页展示
//        Route::rule('show_detail','api/Push/show_detail'); //获取列表详情
//        Route::rule('myshow','api/Push/myshow'); //获取妈妈推个人列表
//        Route::rule('commentList','api/Push/commentList'); //评论详情
//
//        Route::rule('release','api/Push/release'); //发布信息
//        Route::rule('comment','api/Push/comment'); //评论信息
//
//        Route::rule('actColl','api/Push/actColl'); //添加、删除收藏
    });
});