<?php /*a:2:{s:61:"/home/wwwroot/ytshop/application/pchome/view/index/index.html";i:1527660235;s:61:"/home/wwwroot/ytshop/application/pchome/view/public/base.html";i:1527661620;}*/ ?>
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
<div class="index_body">
    <div class="welcome">
        <h2>Welcome to Technology of MSC</h2>
            <p style="text-align: center;">
                爱巢科技始于2009年一个高中生的设想，源自于对手机的热爱，MSC团队对手机测评有着专业的知识和严谨的流程 <br>
                爱巢科技从开始的Symbian系统到现在Android系统和iOS系统都有全面的解析和独到的见解。目睹曾经的机皇诺基亚和安卓鼻祖HTC等公司的崛起和变迁。Come on，与爱巢科技一同了解和探索未来的手机世界吧！
                <br>
            </p>
    </div>
    <div class="exhibition_box">
        <?php if(is_array($kind) || $kind instanceof \think\Collection || $kind instanceof \think\Paginator): $i = 0; $__LIST__ = $kind;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="exhibition">
                <div>
                    <a href="javascript:;">
                        <img src="/static/pchome/image/img<?php echo htmlentities($i); ?>.png"/>
                    </a>
                </div>
                <p><?php echo htmlentities($vo['title']); ?></p>
            </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="product_box">
        <div class="product_content">
            <div class="product_a">
                <div class="product_l">
                    <img src="/static/pchome/image/item_img1.png"/>
                </div>
                <div class="product_r">
                    华为P20 Pro采用的是变色曲面玻璃屏设计，通过变色光学原理，给P20 Pro做出了流光溢彩的效果，完全是按照艺术品的规格来设计。手机拍照方面，P20 Pro可以说是无可匹敌，采用的是800万三倍变焦+2000万黑白色彩+4000万像素色彩的三代莱卡镜头。
                </div>
            </div>
        </div>
        <div class="product_content">
            <div class="product_b">
                <div class="product_l">
                    <img src="/static/pchome/image/item_img2.png"/>
                </div>
                <div class="product_r">
                    小米mix2s搭载了高通新一代的骁龙845，最高主频2.8GHz，安兔兔跑分27万+。正面是一块5.99英寸的18:9的LCD全面屏，分辨率为2160×1080。小米mix2s后置为1200万+1200万双摄像头，单个摄像面积为1.4μm，支持全像素对焦。小米mix2s无论是拍照还是系统各方面性能都很好，是一款值得入手的手机。
                </div>
            </div>
        </div>
        <div class="product_content">
            <div class="product_c">
                <div class="product_l">
                    <img src="/static/pchome/image/item_img3.png"/>
                </div>
                <div class="product_r">
                    三星S9/S9+均搭载骁龙845/Exynos 9810处理器，采用Android 8.0操作系统，支持IP68级防尘防水、QC 2.0快充以及支持无线充电技术，并且延续了之前的虹膜识别、Bixby、NFC等配套功能。Galaxy S9采用Quad HD + Super AMOLED 全视曲面屏幕设计，S9+采用6.2英寸Quad HD + Super AMOLED 全视曲面屏幕。
                </div>
            </div>
        </div>
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

