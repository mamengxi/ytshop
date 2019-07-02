<?php /*a:2:{s:61:"/home/wwwroot/ytshop/application/pchome/view/about/index.html";i:1527820168;s:61:"/home/wwwroot/ytshop/application/pchome/view/public/base.html";i:1527661620;}*/ ?>
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

		<div class="banner swiper-container" id="banner">
		    <div class="swiper-wrapper">
				<?php if(empty($ad) || (($ad instanceof \think\Collection || $ad instanceof \think\Paginator ) && $ad->isEmpty())): ?>
				<div class="swiper-slide"><a href=""><img src="/static/pchome/image/banner-1.jpg" /></a></div>
				<div class="swiper-slide"><a href=""><img src="/static/pchome/image/banner-2.jpg" /></a></div>
				<div class="swiper-slide"><a href=""><img src="/static/pchome/image/banner-3.jpg" /></a></div>
				<div class="swiper-slide"><a href=""><img src="/static/pchome/image/banner-4.jpg" /></a></div>
				<?php else: if(is_array($ad) || $ad instanceof \think\Collection || $ad instanceof \think\Paginator): $i = 0; $__LIST__ = $ad;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<div class="swiper-slide"><a href="<?php echo htmlentities($vo['url']); ?>"><img src="<?php echo htmlentities((isset($vo['img_src']) && ($vo['img_src'] !== '')?$vo['img_src']:'/static/pchome/image/banner-1.jpg')); ?>" alt="<?php echo htmlentities($vo['ad_name']); ?>"/></a></div>
				<?php endforeach; endif; else: echo "" ;endif; endif; ?>
		    </div>
		    <div class="swiper-pagination"></div>
		    <div class="swiper-button-prev"></div>
    		<div class="swiper-button-next"></div>
		</div>
		<div class="about_body">
			<div class="history">
				<h2>品牌故事</h2>
				<p style="text-align: center;">
					爱巢科技有限公司是从2009年开始成立的一家私人企业。目睹曾经的机皇诺基亚和安卓鼻祖HTC等公司的崛起和变迁。有着强大的手机正规货源渠道、灵活的销售技巧和高信用的售后服务。<br>
					<br>
					<br>
					公司创始人MSC，未来打破历史的马氏企业家！<br>
					<br>
					<br>
					公司检测设备先进、技术力量雄厚，拥有先进的自动检测流水线，形成从收集——检测——修理——检测——销售一条龙配套的企业。<br>
					<br>
					<br>
				</p>
			</div>
			<div class="about_img">
				<img src="/static/pchome/image/about.jpg"/>
			</div>
		</div>


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

