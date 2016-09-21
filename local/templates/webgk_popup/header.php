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
    <?$APPLICATION->ShowPanel();?>
    
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

    <!--<meta name="viewport" content="minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>-->
    <link href="/css/styles.css" type="text/css" rel="stylesheet" />
    <link href="/css/jquery.fancybox.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="/js/jquery-1.9.0.js"></script>
    <!--     <script type="text/javascript" src="/js/jquery_mobile.js"></script> -->
    <script type="text/javascript" src="/js/jquery-ui-1.10.0.custom.js"></script>
    <script type="text/javascript" src="/js/mobile_detect.js"></script>

    <!--обработка вращени€ колесика мыши-->
    <script type="text/javascript" src="/js/mousewheel.js"></script>
    <!--Ёффекты завершени€ анимации-->
    <script type="text/javascript" src="/js/easing.js"></script>

    <!--пользовательские скрипты-->
    <script type="text/javascript" src="/js/main.js"></script>
    <!--—крипты параллакса-->
    <script type="text/javascript" src="/js/parallax.js"></script>
    <!--Fancybox-->
    <script type="text/javascript" src="/js/jquery.fancybox.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            //-----------100% работающий код дл€ ресайза fancybox под размер фрейма
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
        });
    </script>




</head>
<body class="none">

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


