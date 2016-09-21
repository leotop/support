<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <title><?$APPLICATION->ShowTitle()?></title>
<!--    <link rel="shortcut icon" type="image/x-icon" href="?=SITE_TEMPLATE_PATH?>/favicon.ico"/>           -->
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
<!--    <link rel="shortcut icon" href="/i/favicon.ico" type="image/x-icon">
-->    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:300,400,700&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
    <meta name="description" content="<?$APPLICATION->ShowTitle()?>">
    <!--<meta name="viewport" content="minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>-->
    <link href="/css/styles.css" type="text/css" rel="stylesheet" />
    <link href="/css/jquery.fancybox.css" type="text/css" rel="stylesheet" />


    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script> 

    <script type="text/javascript" src="/js/jquery.cookie.js"></script>


    <script type="text/javascript" src="/js/jquery.cookie.js"></script>

    <!--     <script type="text/javascript" src="/js/jquery_mobile.js"></script> -->

    <script type="text/javascript" src="/js/jquery-ui-1.10.0.custom.js"></script>
    <script type="text/javascript" src="/js/mobile_detect.js"></script>      
    
    <script src="/js/queryloader2.min.js" type="text/javascript"></script>
    <!--обработка вращения колесика мыши-->
    <script type="text/javascript" src="/js/mousewheel.js"></script>
    <!--Эффекты завершения анимации-->
    <script type="text/javascript" src="/js/easing.js"></script>
                                        
    <!--пользовательские скрипты-->
    <script type="text/javascript" src="/js/main.js"></script>
    <!--Скрипты параллакса-->
    <script type="text/javascript" src="/js/parallax.js"></script>
    <!--Fancybox-->
    <script type="text/javascript" src="/js/jquery.fancybox.js"></script>

    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', function() {
            new QueryLoader2(document.querySelector("body"), {
                barColor: "#efefef",
                backgroundColor: "#111",
                percentage: false,
                barHeight: 2,
                minimumTime: 200,
                fadeOutTime: 1000,

            });
        });
    </script>      
    
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

            if($.cookie('HELP')!=="Y"){
                $("#scroll_help").css("display","block");
                $("#scroll_help").animate({opacity: 1}, 1000);      
                setTimeout('$("#scroll_help").animate({opacity: 0}, 1000);', 4000);
                setTimeout('$("#scroll_help").css("display", "none");', 5000);
                $.cookie('HELP','Y', {
                    expires: 1
                });
            };


        });
    </script>


    <style>
        .fancybox-close {

            top: 10% !important;
            right: 0;

        }
    </style>

</head>
<body>
        <frameset>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter26381235 = new Ya.Metrika({
                    id:26381235,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/26381235" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
               </frameset>

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
            );
            $main=CIBlockElement::GetList(
                array (""),
                array ("IBLOCK_CODE"=>"PORTFOLIO"),
                false,
                false,
                Array("NAME", "PROPERTY_SITE_TYPE", "PROPERTY_SITE_MAIN", "PROPERTY_NAME_MAIN1", "PROPERTY_NAME_MAIN2", "PROPERTY_BUBBLE_COLOR","PROPERTY_NAME_COLOR", 
                    "PROPERTY_OPACITY_BUBBLE", "PROPERTY_PICTURE_MAIN", "PROPERTY_COORD_X", "PROPERTY_COORD_Y","CODE")
            );
            //$a=1;
            while($main_s = $main->Fetch()){
                //arshow($main_s);
                if ($main_s["PROPERTY_SITE_MAIN_VALUE"]!==NULL){

                    $property_1[$main_s["PROPERTY_SITE_MAIN_VALUE"]]=array("NAME1"=>($main_s["PROPERTY_NAME_MAIN1_VALUE"]),
                        "NAME2"=>$main_s["PROPERTY_NAME_MAIN2_VALUE"], "TYPE"=>$main_s["PROPERTY_SITE_TYPE_VALUE"],
                        "BUBBLE_COLOR"=>$main_s["PROPERTY_BUBBLE_COLOR_VALUE"], "NAME_COLOR"=>$main_s["PROPERTY_NAME_COLOR_VALUE"],
                        "OPACITY"=>$main_s["PROPERTY_OPACITY_BUBBLE_VALUE"], "PICTURE"=>$main_s["PROPERTY_PICTURE_MAIN_VALUE"],
                        "X"=>$main_s["PROPERTY_COORD_X_VALUE"], "Y"=>$main_s["PROPERTY_COORD_Y_VALUE"], "CODE"=>$main_s["CODE"]);                   
                    ksort($property_1);
                    //$opacity[]="opacity:".$property_1[$main_s["PROPERTY_SITE_MAIN_VALUE"]]["OPACITY"];
                    /* $property_2[]=$main_s["PROPERTY_NAME_MAIN2_VALUE"]; 
                    $property_n[]=$main_s["PROPERTY_SITE_TYPE_VALUE"];
                    $property_bub[]=$main_s["PROPERTY_BUBBLE_COLOR_VALUE"];
                    $property_name[]=$main_s["PROPERTY_NAME_COLOR_VALUE"]; */
                    //$a++;  
                    //$link_pic[]=CFile::GetPath($property_1[$main_s["PROPERTY_SITE_MAIN_VALUE"]]["PICTURE"]); 
                }               

            }  
            //arshow($property_1);
            $main2=CIBlockElement::GetList(
                array (""),
                array ("IBLOCK_CODE"=>"WEBGK_NEWS", "PROPERTY_PRINT_MAIN_VALUE"=>"да"),
                false,
                false,
                Array("NAME", "PREVIEW_TEXT", "CODE")
            );
            $main_s2 = $main2->Fetch(); 
            //arshow($main_s2);    

        ?>               


    </div>
</div>
<!--//Верхнее меню-->



<div class="swipe_zone index_bg not_scrolling">


    <a href="/">
        <div class="logo">
            <span id="sp1" style="color:#fff"></span>
            <br>
            <span id="sp2" style="color:#fff"></span>
    </div> </a>

    <!--контент-->
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <div class="wave_container">

    </div>

    <div class="left_arrow">

    </div>

    <div class="content_over_wave">

        <div class="bubble_0">
            <?/*$APPLICATION->IncludeFile(SITE_DIR."/include/bubble_0.php",Array(),Array("MODE"=>"html"));*/?>
            <a href="/1c_bitrix/">
                <div class="bubble_0-0">
                    <h2>
                        <?$APPLICATION->IncludeFile(SITE_DIR."/include/bubble_0-1.php",Array(),Array("MODE"=>"html"));?>   
                    </h2>
                </div>
            </a>
        </div>

        <div class="bubble_1">
            <a href="/portfolio/<?=$property_1[1]["CODE"]?>/">
                <div class="bubble_img img_bubble" style="left:<?=$property_1[1]["X"]?>px; top:<?=$property_1[1]["Y"]?>px;">
                <?if ($property_1[1]["PICTURE"]!==NULL){
                    ?> <img src="<?=CFile::GetPath($property_1[1]["PICTURE"])?>"> 
                    <? }?>  
            </a>

        </div>
        <div class="bubble_1-1" style='background:<?=$property_1[1]["BUBBLE_COLOR"]?>; opacity:<?=$property_1[1]["OPACITY"]?>;'>


        </div> 

        <div>
            <h3 style='color:<?=$property_1[1]["NAME_COLOR"]?>;'><?=$property_1[1]["NAME1"]?></h3>
            <h2 style='color:<?=$property_1[1]["NAME_COLOR"]?>;'><?=$property_1[1]["NAME2"]?></h2>
            <span><?=$property_1[1]["TYPE"]?></span>
        </div>
    </div>

    <div class="bubble_2">
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => ""
	)
);?>
        
    </div>
    <div class="bubble_3">
        <a href="http://www.1c-bitrix.ru/partners/list.php?city%5B%5D=9487&country%5B%5D="></a>
    </div>

    <div class="bubble_4">
        <?$APPLICATION->IncludeFile(SITE_DIR."/include/bubble_4.php",Array(),Array("MODE"=>"html"));?>
    </div>

    <div class="bubble_5">
        <a href="/portfolio/<?=$property_1[2]["CODE"]?>/">
            <div class="bubble_img img_bubble" style="left:<?=$property_1[2]["X"]?>px; top:<?=$property_1[2]["Y"]?>px;">
            <?if ($property_1[2]["PICTURE"]!==NULL){
                ?>  <img src="<?=CFile::GetPath($property_1[2]["PICTURE"])?>"> 
                <? }?> 
        </a>

    </div>
    <div style="background:<?=$property_1[2]["BUBBLE_COLOR"]?>; opacity:<?=$property_1[2]["OPACITY"]?>;" class="bubble_5-1">


    </div>
    <div>
        <h3 style='color:<?=$property_1[2]["NAME_COLOR"]?>;'><?=$property_1[2]["NAME1"]?></h3>
        <h2 style='color:<?=$property_1[2]["NAME_COLOR"]?>;'><?=$property_1[2]["NAME2"]?></h2>
        <span><?=$property_1[2]["TYPE"]?></span>
    </div>
</div>

<div class="bubble_6"> 
    <a href="/tech/"></a>
    <div>                
        <h2>
            <?$APPLICATION->IncludeFile(SITE_DIR."/include/bubble_6-1.php",Array(),Array("MODE"=>"html"));?>
        </h2>
        <p>
            <?$APPLICATION->IncludeFile(SITE_DIR."/include/bubble_6-2.php",Array(),Array("MODE"=>"html"));?>
        </p>
    </div> 

</div> 

<div class="bubble_7">
    <a href="/portfolio/<?=$property_1[3]["CODE"]?>/">  
        <div class="bubble_img img_bubble" style="left:<?=$property_1[3]["X"]?>px; top:<?=$property_1[3]["Y"]?>;">
            <?if ($property_1[3]["PICTURE"]!==NULL){?>  
                <img src="<?=CFile::GetPath($property_1[3]["PICTURE"])?>" class="img_bubble"> 
                <?}?> 

        </div>
    </a>
    <div class="bubble_7-1"  style="background: <?=$property_1[3]["BUBBLE_COLOR"]?>; opacity:<?=$property_1[3]["OPACITY"]?>;"></div>

    <div>
        <h3 style='color:<?=$property_1[3]["NAME_COLOR"]?>;'><?=$property_1[3]["NAME1"]?></h3>
        <h2 style='color:<?=$property_1[3]["NAME_COLOR"]?>;'><?=$property_1[3]["NAME2"]?></h2>
        <p><?=$property_1[3]["TYPE"]?></p>
    </div>


</div>

<div class="bubble_8">
    <a href="http://support.webgk.ru/"></a>
    <?$APPLICATION->IncludeFile(SITE_DIR."/include/bubble_8.php",Array(),Array("MODE"=>"html"));?>
</div>
<div class="bubble_9">
    <?$APPLICATION->IncludeFile(SITE_DIR."/include/bubble_9.php",Array(),Array("MODE"=>"html"));?>
</div>

<div class="bubble_10">
    <a href="/portfolio/<?=$property_1[4]["CODE"]?>/"> </a>
    <div class="bubble_img img_bubble" style="left:<?=$property_1[4]["X"]?>px; top:<?=$property_1[4]["Y"]?>px;">
        <?if ($property_1[4]["PICTURE"]!==NULL){
            ?>  <img src="<?=CFile::GetPath($property_1[4]["PICTURE"])?>" class="img_bubble"> 
            <? }?>                   
    </div>
    <div class="bubble_10-1" style="background: <?=$property_1[4]["BUBBLE_COLOR"]?>; opacity:<?=$property_1[4]["OPACITY"]?>;">

    </div>
    <div>
        <h3 style='color:<?=$property_1[4]["NAME_COLOR"]?>;'><?=$property_1[4]["NAME1"]?></h3> 
        <h2 style='color:<?=$property_1[4]["NAME_COLOR"]?>;'><?=$property_1[4]["NAME2"]?></h2>
        <span><?=$property_1[4]["TYPE"]?></span>
    </div>

</div>

</div>
<div class="right_arrow">

    </div>
    <!--//контент-->
        </div>
        <!--Нижнее меню-->