<?php
/*if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
*/

//echo $ip;
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang=""> 
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<?php 
	if($_GET['id']){ 
		$data = getPost('event',array('title','thumbnail','abstract'),'desc',$_GET['id']);
	?>
<title><?php echo get_bloginfo('name')?></title>
<meta property="og:locale" content="th_TH">
<meta property="og:title" content="<?php echo $data[0]["title"] ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thai PBS">
<meta property="og:description" content="<?php echo strip_tags($data[0]["abstract"]) ?>">
<meta property="og:image" content="<?php echo $data[0]["thumbnail"]["url"] ?>">
<meta property="og:url" content="<?php echo bloginfo('url')?>/event/?id=<?php echo $_GET['id']?>">  

	<?php } ?>
    <!-- CSS -->
        <!-- icons & logo -->
        <link rel="shortcut icon" href="http://news.thaipbs.or.th/images/icons/favicon.ico"/>
 
        <script>
        function loadCSS(e,n,o,t){"use strict";var d=window.document.createElement("link"),i=n||window.document.getElementsByTagName("script")[0],r=window.document.styleSheets;return d.rel="stylesheet",d.href=e,d.media="only x",t&&(d.onload=t),i.parentNode.insertBefore(d,i),d.onloadcssdefined=function(e){for(var n,o=0;o<r.length;o++)r[o].href&&r[o].href===d.href&&(n=!0);n?e():setTimeout(function(){d.onloadcssdefined(e)})},d.onloadcssdefined(function(){d.media=o||"all"}),d}

        loadCSS('http://news.thaipbs.or.th/css/style.min.css?0a5fa5f');
        </script>
      
	<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/font-awesome.min.css" media="screen">
	<link rel="stylesheet" href="http://news.thaipbs.or.th/css/style.min.css?0a5fa5f">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/js/ammap/ammap.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/js/lwtCountdown/style/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/js/responsive-calendar/0.9/css/responsive-calendar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/js/bootstrap-datepicker/css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/push-bootstrap-button/assets/css/buttons.css">
			<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.1.5" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/custom.css">
	
	 <!-- jQuery -->
		<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery-1.12.0.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script src="<?php echo get_template_directory_uri();?>/js/bootstrap-datepicker/js/bootstrap-datepicker-thai.js"></script>
		<script src="<?php echo get_template_directory_uri();?>/js/bootstrap-datepicker/js/locales/bootstrap-datepicker.th.js"></script>
		<script src="<?php echo get_template_directory_uri();?>/js/responsive-calendar/0.9/js/responsive-calendar.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.1.5"></script>
     <meta name="keywords" content="Thaipbs, ทีวีไทย, thaipbs, tpbs, ไทยพีบีเอส, รายการ, ผังรายการ,ผังรายเดือน ดูย้อนหลัง, คลิป, ข่าวล่าสุด , ข่าวยอดนิยม, รายการข่าว, กิจกรรมล่าสุด, ทันข่าวเด่น, รายการวิทยุ, รายการโทรทัศน์, ข่าว">
</head>

<body>
<!-- Header -->
<header>
	            <nav id="header-nav" class="navbar navbar-inverse">
                <div id="top-nav" class="container navbar-orange">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed dropdown-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                           Menu
                            <span class="caret"></span>
                        </button>
                        <button type="button" class="navbar-toggle btn-secondary">
                            <i class="fa fa-user"></i>
                        </button>
                        <button type="button" class="navbar-toggle btn-secondary" id="open-search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                        <a class="navbar-brand col-xxs-4 col-xs-4" href="//www.thaipbs.or.th" title="Thai PBS logo">
                            <img src="http://news.thaipbs.or.th/images/logo/tpbs.png" class="logo" alt="Thai PBS logo" />
                            <img src="http://news.thaipbs.or.th/images/logo/tpbs-sm.png" class="logo-sm" alt="Thai PBS logo" />
                        </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                                       <ul class="nav navbar-nav">
                            <li class="home">
                                <a href="//www.thaipbs.or.th" target="_blank" title="หน้าแรก">หน้าแรก</a>
                            </li>
                            <li>
                                <a href="//www.thaipbs.or.th/news" target="_blank" title="ข่าว">ข่าว</a>
                            </li>
                            <li>
                                <a href="//program.thaipbs.or.th" target="_blank" title="รายการทีวี">รายการทีวี</a>
                            </li>
                            <li>
                                <a href="//thaipbs.or.th/live" target="_blank" title="ชมสด">ชมสด</a>
                            </li>
                            <li>
                                <a href="//program.thaipbs.or.th/watch" target="_blank" title="ชมย้อนหลัง">ชมย้อนหลัง</a>
                            </li>
                            <li>
                                <a href="http://www.thaipbsonline.net/" target="_blank" title="วิทยุ">วิทยุ</a>
                            </li>
                            <li>
                                <a href="//org.thaipbs.or.th/home" target="_blank" title="องค์กร">องค์กร</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" id="language-switcher" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="full">ENGLISH</span><span class="short">ENG</span> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="//englishnews.thaipbs.or.th/" target="_blank" title="Thai PBS News">Thai PBS News</a></li>
            						<li><a href="//www2.thaipbs.or.th/home.php" target="_blank" title="About Thai PBS">About Thai PBS</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="social-sharing">
                            <li class="search-tablet-holder hidden">
                                <a href="#" title="ค้นหา" rel="search"><i class="fa fa-search"></i></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/ThaiPBSFan?_rdr=p" target="_blank" title="Thai PBS Facebook"><i class="fa fa-facebook-square"></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/ThaiPBS" target="_blank" title="Thai PBS Twitter"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/user/Thaipbs" target="_blank" title="Thai PBS YouTube"><i class="fa fa-youtube-play"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/thaipbs/" target="_blank" title="Thai PBS Instagram"><i class="fa fa-instagram"></i></a>
                            </li>
							<li>
                                <a href="https://gplus.to/thaipbs/" target="_blank" title="Thai PBS Google Plus"><i class="fa fa-google-plus"></i></a>
                            </li>
                           
                           
                        </ul>
                        <form class="form" id="mini-search-form" action="http://news.thaipbs.or.th/search" method="get" >
                            <div class="form-group">
                                <input type="search" id="mini-search-input" name="q" class="form-control" autocomplete="off" tabindex="1">
                                 <input type="hidden"  name="tab" value="news">
                                 <input type="hidden"  name="time" value="last_month">
                                <span class="icon">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </form>
                    </div><!--/.navbar-collapse -->
                </div><!--/#top-nav -->

		
</header>
<section id="hero">

	<div class="container">
		<div class="hero-text">
			<div class="heading"><span class="over">ปฎิทินกิจกรรม <i class="fa fa-calendar-check-o"></i> </span>   ไทยพีบีเอส</div>
			<div class="sub-heading hright"><span class="over"> Thai PBS Event Calendar</span></div>
		</div>
	</div>

</section>

