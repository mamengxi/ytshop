<?php /*a:2:{s:63:"/home/wwwroot/ytshop/application/pchome/view/contact/index.html";i:1524796946;s:61:"/home/wwwroot/ytshop/application/pchome/view/public/base.html";i:1527661620;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MSC-爱巢科技</title>
    <meta name="Keywords" content="手机,手机测评,科技,爱巢科技," />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html;charset=gb2312">
    <meta name="viewport" content="width=device-width, initial-scale=0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/static/pchome/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/static/pchome/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/static/pchome/js/swiper.min.css"/>
    <style>
        .QRcode-fixed{
            position: fixed;
            top: 40%;
            right: 0;
            z-index: 1000;
            width: 126px;
            box-sizing: border-box;
            padding: 9px;
            background: #3C3C3C;
            text-align: center;
            font-size: 14px;
            color: #a4a4a4;
        }
        .QRcode-fixed p{
            margin-bottom: 10px;
        }
        .QRcode-fixed img{
            width: 108px;
            height: 108px;
        }
    </style>
</head>
<body>
<header class="head">
    <div class="nav">
        <div class="logo">
            <a href="javascript:;"><span style="font-weight: bold;font-family:华文楷体;font-size:54px;color: #8d4bbb">爱&nbsp;巢&nbsp;科&nbsp;技</span></a>
        </div>
        <ul class="navList">
            <li class="<?php if($nav == 1): ?>on<?php endif; ?>">
                <a href="/">首页</a>
            </li>
            <li class="<?php if($nav == 2): ?>on<?php endif; ?>">
                <a href="/product">产品展示</a>
            </li>
            <li class="<?php if($nav == 3): ?>on<?php endif; ?>">
                <a href="/about">关于我们</a>
            </li>
            <li class="<?php if($nav == 4): ?>on<?php endif; ?>">
                <a href="/contact">联系我们</a>
            </li>
        </ul>
    </div>
</header>

<script src="/static/pchome/js/jquery-2.1.4.js"></script>
<script src="/static/pchome/layer/layer.js"></script>

		<div class="contact_body">
			<div class="contact_box">
				<h2>联系我们</h2>
				<p>努力打造让客户最满意的产品，提供最贴心的服务,<br />
					如对我们的产品或服务有任何疑问，请填写联系表格。请尽可能详细地填写表格，以便我们更好地为您服务。感谢您提供的意见和建议。
				</p>
				<div class="input_box">
					<form action="javascript:;" method="post">
						<ul>
							<li><span>您的姓名</span><div class="lay_input"><input class="name" type="text" maxlength="5" name="name"/></div></li>
							<li><span>联系电话</span><div class="lay_input"><input class="phone" type="text" maxlength="11" name="phone"/></div></li>
							<li><span>邮箱</span><div class="lay_input"><input class="email" type="text" maxlength="30" name="email"/></div></li>
							<li><span>留言</span><div class="lay_textarea"><textarea class="mess" maxlength="300" name="mess"></textarea></div></li>
							<li class="submit"><span></span><button type="submit" class="form1">联系我们</button></li>
						</ul>
					</form>
				</div>
			</div>
		</div>
<script type="text/javascript">
    $('.form1').on("click",function(){
        var name = $(".name").val();
        if (name==''){
            layer.msg('姓名不能为空');return false;
        }
        var tel = $(".phone").val();
        var myreg = /^1[3456789]\d{9}$/;
        if(tel==''){
            layer.msg('手机号不能为空');return false;
        }else if(!myreg.test(tel)){
            layer.msg('手机号格式不正确');return false;
        }
        var email = $(".email").val();
        var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
        if(email==''){
            layer.msg('邮箱不能为空');return false;
        }else if(!reg.test(email)){
            layer.msg('邮箱格式不正确');return false;
        }
        var mess = $(".mess").val();
        if (mess==''){
            layer.msg('留言不能为空');return false;
        }
        $.ajax({
            type:'POST',//提交方式
            url:"/contact",//需要提交的url
            dataType:'json', // 如果需要json传输接收数据就开启
            data:{tel:tel,name:name,email:email,mess:mess},//传输的数据 如果没有直接填写空 {}
            success: function(data) {
                if(data.status){
                    layer.msg(data.info,{icon: 1,time: 1000 },function(){
                        parent.location.reload();
                    });
                }else{
                    layer.msg(data.info,{icon:2});
                }
            }
        });
    });

</script>


<div class="QRcode-fixed">
    <div class="QRcode-fixed-img">
        <p style="color:#FF0000;font-family: 华文楷体;font-size: 24px;font-weight: bold;">扫码下单</p>
        <div><img src="<?php echo htmlentities((isset($config['qrcode']) && ($config['qrcode'] !== '')?$config['qrcode']:'/static/pchome/image/QR_code_img.png')); ?>"/></div>
    </div>
</div>
<footer class="st_footer">
    <div class="st_footer_box">
        <ul class="profile">
            <li><?php echo htmlentities($config['company']); ?></li>
            <li>客服热线：<?php echo htmlentities($config['mobile']); ?></li>
            <!--<li>QQ：<?php echo htmlentities($config['QQ']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮箱：<?php echo htmlentities($config['email']); ?></li>-->
            <li>投诉与建议：<?php echo htmlentities($config['QQ']); ?></li>
            <li>公司地址：<?php echo htmlentities($config['address']); ?></li>
        </ul>
        <div class="QR_code">
            <div><img src="<?php echo htmlentities((isset($config['qrcode']) && ($config['qrcode'] !== '')?$config['qrcode']:'/static/pchome/image/QR_code_img.png')); ?>"/></div>
            <p>扫描关注公众号</p>
        </div>
    </div>
    <div class="copyright">版权所有©Copyright 2009-2018</div>
</footer>
<script src="/static/pchome/js/jquery-2.1.4.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/pchome/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var mySwiper = new Swiper ('.swiper-container', {
        direction: 'horizontal',
        loop: true,
        // 如果需要分页器
        pagination: {
            el: '.swiper-pagination',
        },
        // 如果需要前进后退按钮
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        // 如果需要滚动条
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });
    function productImg(){
        $.each($(".product_l img"), function(i,item) {
            var img = new Image();
            img.src = $(item).prop("src");
            img.onload = function(){
                var w = this.width;
                var h = this.height;
                if(w>h){
                    $(item).css("width","100%");
                    return
                }else{
                    $(item).css("height","100%");
                    return
                }
            }
        });
    }
    productImg();


    // 产品展示

    $(".series").click(function () {
        $(this).addClass('on').siblings().removeClass('on');
        if($(this).hasClass('news')){
            $(".display_list").removeClass('on');
            $(".list-news").addClass('on');
            $(".msg").removeClass('on');
        }else if($(this).hasClass('xunhuanA')){
            $(".display_list").removeClass('on');
            $(".list-xunhuanA").addClass('on');
            $(".msg-A").addClass('on').siblings('.msg-B').removeClass('on');
        }else if($(this).hasClass('xunhuanB')){
            $(".display_list").removeClass('on');
            $(".list-xunhuanB").addClass('on');
            $(".msg-B").addClass('on').siblings('.msg-A').removeClass('on');
        }
    })

    $(window).resize(function(){
        banner();
    });
    function banner(){
        var w = $(window).width();
        if(w <= 1200){
            w = 1200;
        }
        var h = w * 0.33;
        $(".banner").css("height",h+'px');
    }
    banner();


</script>
</body>
</html>

