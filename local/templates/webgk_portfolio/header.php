<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title><?$APPLICATION->ShowTitle()?></title>
    <!--    <link rel="shortcut icon" type="image/x-icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.ico" />       
    -->
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
    <!--    <link rel="shortcut icon" href="/i/favicon.ico" type="image/x-icon">
    -->    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:300,400,700&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:700' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
    <meta name="description" content="Портфолио">
    <!--<meta name="viewport" content="minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>-->
    <link href="/css/styles.css" type="text/css" rel="stylesheet">
    <link href="/css/jquery.fancybox.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="/js/jquery-1.9.0.js"></script>

    <script type="text/javascript" src="/js/jquery-ui-1.10.0.custom.js"></script>
    <!--     <script type="text/javascript" src="/js/jquery_mobile.js"></script> -->  


    <!--пользовательские скрипты-->

    <script type="text/javascript" src="/js/jquery.mousewheel.js"></script>     
    <script type="text/javascript" src="/js/jScrollPane.js"></script> 
    <link href="/css/jScrollPane.css" type="text/css" rel="stylesheet" />

    <script src='/js/grayscale.js'></script>

    <script type="text/javascript" src="/js/main.js"></script>
    <!--Скрипты параллакса-->



    <script type="text/javascript" src="/js/jquery.fancybox.js"></script>

    <script type="text/javascript" src="/js/main3.js"></script>



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
    <style type="text/css">
        .logo_bread_crumb_container{
            margin-bottom:0;
            border-bottom: none;
        }
    </style>


</head>
<body class="scroll-pane">
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
<a href="/">
    <div class="logo">
        <span id="sp1" style="color:#fff"></span>
        <br>
        <span id="sp2" style="color:#fff"></span>
    </div> 
</a>

<?if ($APPLICATION->GetCurPage()!=="/portfolio/"){?>
    <div class="logo_bread_crumb_container">    
        <!-- nav bread crumb -->    
        <div class="bread_crumb">
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "template1", array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => "s2"
                    ),
                    false
                );?>
        </div>   
        <!-- End nav bread crumb -->
    </div>
    <?};?>
