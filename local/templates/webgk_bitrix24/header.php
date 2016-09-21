<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <title><?$APPLICATION->ShowTitle()?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <?$APPLICATION->ShowHead();?>

    <!--[if lte IE 6]>
    <style type="text/css">

    #support-question { 
    background-image: none;
    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./images/question.png', sizingMethod = 'crop'); 
    }

    #support-question { left: -9px;}

    #banner-overlay {
    background-image: none;
    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./images/overlay.png', sizingMethod = 'crop');
    }

    </style>
    <![endif]-->      

    <title>WebGK</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:300,400,700&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
<!--    <link rel="shortcut icon" href="/i/favicon.ico" type="image/x-icon">
-->    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:300,400,700&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
    <meta name="description" content="<?$APPLICATION->ShowTitle()?>">
    <!--<meta name="viewport" content="minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>-->
    <link href="/css/styles.css" type="text/css" rel="stylesheet">
    <link href="<?=SITE_TEMPLATE_PATH?>/css/template_styles.css" type="text/css" rel="stylesheet">
    <link href="/css/jquery.fancybox.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="/js/jquery-1.9.0.js"></script>

    <script type="text/javascript" src="/js/jquery-ui-1.10.0.custom.js"></script>
    <!--     <script type="text/javascript" src="/js/jquery_mobile.js"></script> -->  

    <!--Кастомизация скролл бара-->

    <script type="text/javascript" src="/js/jquery.mousewheel.js"></script>     
    <script type="text/javascript" src="/js/jScrollPane.js"></script> 
    <link href="/css/jScrollPane.css" type="text/css" rel="stylesheet" />

    <script src='/js/grayscale.js'></script>

    <script type="text/javascript" src="/js/main.js"></script>
    <!--Скрипты параллакса-->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="/js/scripts.js"></script>  

    <script type="text/javascript" src="/js/jquery.fancybox.js"></script>



    <script type="text/javascript" src="/js/main3.js"></script>
    <script type="text/javascript" src="/js/job_slider.js"></script>



    <script type="text/javascript">
        $(document).ready(function() {
            //-----------100% работающий код для ресайза fancybox под размер фрейма
            $(".fancybox").fancybox({
                type : 'iframe',
                scrolling : 'no',
                closeClick : false,
                openEffect : 'none',
                closeEffect : 'none',
                beforeShow : function() {
                    this.width = ($('.fancybox-iframe').contents().find('body > div').width());
                    this.height = ($('.fancybox-iframe').contents().find('body > div').height());
                    if ($(document).height()<720){
                        $('.fancybox-inner').find('iframe').contents().find('#want_site_form').css({'transform':'scale(0.8)','top':'-70px'});
                        $('.fancybox-inner').find('iframe').contents().find('#want_work_form').css({'transform':'scale(0.7)','top':'-150px','left':'80px'});
                    }
                },
            });  


            //инициалзация кастомизации скроллбара
            $('.scroll-pane').jScrollPane({autoReinitialise: true, wheelSpeed: 50, showArrows: true, scrollbarMargin: 0, animateScroll:true, mouseWheelSpeed:100, hideFocus: true});

        });
    </script>

    <script type="text/javascript">


    </script>



</head>
<body class="internal_site scroll-pane">
 <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TZC8F8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TZC8F8');</script>
<!-- End Google Tag Manager -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter26381235 = new Ya.Metrika({id:26381235,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div></div></noscript>
<!-- /Yandex.Metrika counter -->


<?$APPLICATION->ShowPanel();?>
<!--Верхнее меню-->
<? if ($USER->IsAdmin()) {
    $style_menu="top: 150px";   
}?>
<div id="top_menu" style="<?=$style_menu?>">
    <div class="menu_container">
        <?$APPLICATION->IncludeComponent("bitrix:menu", "template2", array(
                "ROOT_MENU_TYPE" => "left",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MAX_LEVEL" => "1",
                "CHILD_MENU_TYPE" => "left",
                "USE_EXT" => "N",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N"
                ),
                false
            );?>               

    </div>
</div>
<!--//Верхнее меню-->
<div class="swipe_zone bg_tab">
<a href="/">
    <div class="logo">
        <span id="sp1" style="color:#fff"></span>
        <br>
        <span id="sp2" style="color:#fff"></span>
    </div> 
</a>

<!--контент-->  

<!--<a href="/">
<div class="logo">
<span id="sp1" style="color:#fff"></span>
<br>
<span id="sp2" style="color:#fff"></span>
</div> 
</a>  -->

<div class="logo_bread_crumb_container">

    <!-- nav bread crumb -->
    <nav class="bread_crumb">
        <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "template1", array(
                "START_FROM" => "0",
                "PATH" => "",
                "SITE_ID" => "s2"
                ),
                false
            );?>
    </nav>
    <!-- End nav bread crumb -->
</div>
<!--контент-->
<!-- our services -->


<div id="slider">

    <h1>
        <?$APPLICATION->IncludeFile("/include/bitrix24.php",Array(),Array("MODE"=>"html"));?>
    </h1>
    <div class="under_h1"> 
        <?$APPLICATION->IncludeFile("/include/bitrix24under.php",Array(),Array("MODE"=>"html"));?>
    </div>
    <div id="line"></div>

</div><!--end slider-->
<div class="bitrix_bg">
    <div id="content1">

        <h2 class="nomer">01</h2>
        <div class="lozung"><?$APPLICATION->IncludeFile("/include/bitrix24_lozung.php",Array(),Array("MODE"=>"html"));?></div>
        <!--<img class="line1" src="/i/line1.png" alt="Линия">
        <div class="lozung_text"><?$APPLICATION->IncludeFile("/include/text.php",Array(),Array("MODE"=>"html"));?></div>      -->
        <div id="line2"></div>
        <div id="line3"></div>

        <table  class="times"> 
            <tr>
                <td><div class="left-line"></div></td>
                <td><div class="inner-line" style="margin-left: 88px !important;"></div></td>
                <td><div class="inner-line" style="margin-left: 100px !important;"></div></td>
                <td><div class="inner-line" style="margin-left: 57px !important;"></div></td>
                <td><div class="inner-line" style="margin-left: 35px !important;"></div></td>
                <td><div class="inner-line" style="margin-left: 53px !important;"></div></td>
                <td><div class="inner-line" style="margin-left: 44px !important;"></div></td>
                <td><div class="inner-line" style="margin-left: 39px !important;"></div></td>
                <td><div class="inner-line" style="margin-left: 56px !important;"></div></td>
                <td><div class="inner-line" style="margin-left: 34px !important;"></div></td>
                <td><div class="right-line"></div></td>
            </tr>

            <tr>
                <td><b><a href=""><?$APPLICATION->IncludeFile("/include/social.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td><b><a href=""><?$APPLICATION->IncludeFile("/include/ticket.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td><b><a href=""><?$APPLICATION->IncludeFile("/include/chat-video.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td><b><a href=""><?$APPLICATION->IncludeFile("/include/document.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td style="width: 70px;"><b><a href=""><?$APPLICATION->IncludeFile("/include/disc.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td><b><a href=""><?$APPLICATION->IncludeFile("/include/calendar.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td style="width: 90px;"><b><a href=""><?$APPLICATION->IncludeFile("/include/mail.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td style="width: 80px;"><b><a href=""><?$APPLICATION->IncludeFile("/include/crm.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td><b><a href=""><?$APPLICATION->IncludeFile("/include/telephony.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td style="width: 70px;"><b><a href=""><?$APPLICATION->IncludeFile("/include/hr.php",Array(),Array("MODE"=>"html"));?></a></b></td>
                <td><b><a href=""><?$APPLICATION->IncludeFile("/include/mobility.php",Array(),Array("MODE"=>"html"));?></a></b></td>
            </tr>
        </table>

        <div class="under-times">
            <div class="line-dotted"></div>
            <div class="else-note"><?$APPLICATION->IncludeFile("/include/else.php",Array(),Array("MODE"=>"html"));?></div>
        </div>
        <br /><br /><br />

        <div class="meet-bitrix24">
            <div class="title"><?$APPLICATION->IncludeFile("/include/acq.php",Array(),Array("MODE"=>"html"));?></div>
            <div class="line-under-title"></div>    
            <div class="video"><iframe width="840" height="470" src="//www.youtube.com/embed/gy7psPCEwX0" frameborder="0" allowfullscreen></iframe></div>    
        </div>

        <div id="img_YouTube">
            <embed width="100%" height="100%" name="player_uid_153142030_1" id="player_uid_153142030_1" tabindex="0" type="application/x-shockwave-flash" src="http://s.ytimg.com/yts/swfbin/player-vflQefRRn/watch_as3.swf" wmode="opaque" allowfullscreen="true" allowscriptaccess="always" bgcolor="#000000" flashvars="fexp=908567%2C927622%2C929305%2C930666%2C930672%2C931345%2C931983%2C932404%2C941397%2C947209%2C948526%2C952302%2C952901%2C957103&amp;el=embedded&amp;title=%D0%9A%D0%BE%D0%BC%D0%BF%D0%BE%D0%B7%D0%B8%D1%82%D0%BD%D1%8B%D0%B9%20%D1%81%D0%B0%D0%B9%D1%82&amp;allow_embed=1&amp;is_html5_mobile_device=false&amp;ldpj=-1&amp;iurlhq=http%3A%2F%2Fi.ytimg.com%2Fvi%2Fjo4A4Wqlksc%2Fhqdefault.jpg&amp;iurlmq=http%3A%2F%2Fi.ytimg.com%2Fvi%2Fjo4A4Wqlksc%2Fmqdefault.jpg&amp;avg_rating=4.51515151515&amp;video_id=jo4A4Wqlksc&amp;eurl=http%3A%2F%2Fwebgk.ru%2F1c_bitrix%2F&amp;enablejsapi=1&amp;host_language=ru&amp;allow_ratings=1&amp;cr=RU&amp;rel=0&amp;iurlmaxres=http%3A%2F%2Fi.ytimg.com%2Fvi%2Fjo4A4Wqlksc%2Fmaxresdefault.jpg&amp;idpj=-1&amp;iurl=http%3A%2F%2Fi.ytimg.com%2Fvi%2Fjo4A4Wqlksc%2Fhqdefault.jpg&amp;length_seconds=58&amp;view_count=5809&amp;watch_xlb=http%3A%2F%2Fs.ytimg.com%2Fyts%2Fxlbbin%2Fwatch-strings-ru_RU-vflPCmD9V.xlb&amp;iurlsd=http%3A%2F%2Fi.ytimg.com%2Fvi%2Fjo4A4Wqlksc%2Fsddefault.jpg&amp;hl=ru_RU&amp;index=0&amp;loaderUrl=http%3A%2F%2Fwebgk.ru%2F1c_bitrix%2F&amp;playerapiid=player_uid_153142030_1&amp;framer=http%3A%2F%2Fwebgk.ru%2F1c_bitrix%2F">
        </div> 

        <div id="right_content1">

            <div id="img_x">
                <?$APPLICATION->IncludeFile("/include/img1.php",Array(),Array("MODE"=>"html"));?>
            </div>

            <div id="text">
                <?$APPLICATION->IncludeFile("/include/img2.php",Array(),Array("MODE"=>"html"));?>
            </div>

            <div class="img1">
                <?$APPLICATION->IncludeFile("/include/img3.php",Array(),Array("MODE"=>"html"));?>
            </div>

            <div class="img2">
                <?$APPLICATION->IncludeFile("/include/img4.php",Array(),Array("MODE"=>"html"));?>
            </div>

        </div> <!--end right_content1-->   


    </div> <!--end content1-->
</div>

 <div id=content2>
 <div class="content">