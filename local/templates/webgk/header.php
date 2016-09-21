<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <?$APPLICATION->ShowHead()?>
    <title><?=$APPLICATION->ShowTitle()?></title>
    <!--<base href="<?=str_replace("build.php", "", "http://".getenv("HTTP_HOST").$_SERVER["PHP_SELF"])?>" />-->
    <link rel="stylesheet" href="/data1/common.css?hash=<?=rand()?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <!--<script src="/js/validate/jquery-1.6.min.js" type="text/javascript"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  
    <script src="/js/main.js?hash=<?=rand()?>" type="text/javascript"></script>



</head>


<body style='width: 100%; height: 100%;'>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TZC8F8"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager -->
<?=$APPLICATION->ShowPanel();?>    
<table  id="maintable">
<tr><!--Шапка страницы-->
    <td><img src='/img1/pixel.png' style="width:1px;height:1px;" /></td>
    <td style="padding: 49px 0 43px;" >
        <img src="/img1/pixel.png" style="width: 990px; height: 1px;" alt="" /><br />
        <table style="width:100%; background:url(/img1/bg2_.jpg) repeat-x #099f3b;">
            <tr>
                <td style="width:334px; height:115px; background:white;">
                    <a href='http://support.webgk.ru'><img src="/img1/help.png" alt="" style="margin:15px 0px 0px 59px;" /></a>
                </td>
                <td style="background:url(/img1/bg1_.jpg) no-repeat; padding:10px 53px 0 53px;">                      
                </td>

            </tr>

            <tr><td colspan="2" style="padding: 15px 0 0 329px; background: white;">
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "main_menu1", Array(
                            "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
                            "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                            "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
                            "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                            ),
                            false
                        );?>
                </td></tr>
        </table>
    </td>
    <td><img src='/img1/pixel.png' style="width:1px;height:1px;" /></td>
</tr>
<tr><!--Тело страницы-->
	<td><img src='/img1/pixel.png' style="width:1px;height:1px;" /></td>

	<td>
		<table style="width: 100%; padding: 0 0 74px;">
			<tr>
				<td style="">
					<h4 style="padding: 22px 0 0 80px;"><?=$APPLICATION->ShowTitle()?></h4>
<div style="margin-left: 80px; margin-right: 60px; margin-bottom: 30px;">

