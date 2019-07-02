<?php /*a:2:{s:63:"/home/wwwroot/ytshop/application/pchome/view/display/index.html";i:1527662043;s:61:"/home/wwwroot/ytshop/application/pchome/view/public/base.html";i:1527661620;}*/ ?>
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

<style>
	.tab_series{
		position: relative;
	}
	.msg{
		position: absolute;
		left: 0;
		bottom: 10px;
		font-size: 20px;
		color: #ff0000;
		padding: 10px 0;
		display: none;
	}
	.msg span{
		color: #000000;
		font-size: 24px;
		position: relative;
		top: 1px;
	}
	.msg.on{
		display: block;
	}
</style>

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
		<div class="display_body">
			<div class="tab_series">
				<div class="series news on">
					三星系列
				</div>
				<div class="series xunhuanA">
					小米系列
				</div>
				<div class="series xunhuanB">
					华为系列
				</div>
				<p class="msg msg-A">95新单机<span> + </span>无线充电器<span> + </span>爱巢专属徽章</p>
				<p class="msg msg-B">95新单机<span> + </span>全新充电器<span> + </span>爱巢专属徽章</p>
			</div>

			<div class="display_box">

				<ul class="display_list list-news on">
					<?php if(is_array($list1) || $list1 instanceof \think\Collection || $list1 instanceof \think\Paginator): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
					<li class="display_item">
						<a href="<?php echo url('/pchome/Detailed/index'); ?>?id=<?php echo htmlentities($vo1['id']); ?>">
							<img src="<?php echo htmlentities($vo1['img_thumb']); ?>"/>
							<div class="product_name">
								<?php echo htmlentities($vo1['ktitle']); ?>-<?php echo htmlentities($vo1['ptitle']); ?>
							</div>
						</a>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<ul class="display_list list-xunhuanA">
					<?php if(is_array($list2) || $list2 instanceof \think\Collection || $list2 instanceof \think\Paginator): $i = 0; $__LIST__ = $list2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
					<li class="display_item">
						<a href="<?php echo url('/pchome/Detailed/index'); ?>?id=<?php echo htmlentities($vo1['id']); ?>">
							<img src="<?php echo htmlentities($vo1['img_thumb']); ?>"/>
							<div class="product_name">
								<?php echo htmlentities($vo1['ktitle']); ?>-<?php echo htmlentities($vo1['ptitle']); ?>
							</div>
						</a>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<ul class="display_list list-xunhuanB">
					<?php if(is_array($list3) || $list3 instanceof \think\Collection || $list3 instanceof \think\Paginator): $i = 0; $__LIST__ = $list3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>
					<li class="display_item">
						<a href="<?php echo url('/pchome/Detailed/index'); ?>?id=<?php echo htmlentities($vo1['id']); ?>">
							<img src="<?php echo htmlentities($vo1['img_thumb']); ?>"/>
							<div class="product_name">
								<?php echo htmlentities($vo1['ktitle']); ?>-<?php echo htmlentities($vo1['ptitle']); ?>
							</div>
						</a>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<!--<div class="display_box">-->
				<!--<ul class="display_list list-news">-->
					<!--<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?>-->
					<!--<li class="display_item">-->
						<!--<a href="<?php echo url('/pchome/Detailed/index'); ?>?id=<?php echo htmlentities($vo1['id']); ?>">-->
							<!--<img src="<?php echo htmlentities($vo1['img_thumb']); ?>"/>-->
							<!--<div class="product_name">-->
								<!--<?php echo htmlentities($vo1['ktitle']); ?>-<?php echo htmlentities($vo1['ptitle']); ?>-->
							<!--</div>-->
						<!--</a>-->
					<!--</li>-->
					<!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
				<!--</ul>-->
			<!--</div>-->
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

