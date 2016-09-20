<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="information-block"> 	 	 
	<div class="information-block-head">Автокеширование</div>
	Обратите внимание: по умолчанию кеширование данных <b>включено</b>. Автокеширование позволяет значительно ускорить работу демо-сайта. Изменить настройки кеширования данных на сайте можно на специальной <a href="/bitrix/admin/cache.php">странице</a>.
</div>

<!-- SOCNETWORK_GROUPS -->

<div class="information-block"> 	 	 
  <div class="information-block-head">Опрос</div>
 	<?$APPLICATION->IncludeComponent(
	"bitrix:voting.current",
	"main_page",
	Array(
		"CHANNEL_SID" => "ANKETA",
		"CACHE_TYPE"	=>	"A",
		"CACHE_TIME"	=>	"3600",
		"AJAX_MODE" => "Y", 
		"AJAX_OPTION_SHADOW" => "Y", 
		"AJAX_OPTION_JUMP" => "Y", 
		"AJAX_OPTION_STYLE" => "Y", 
		"AJAX_OPTION_HISTORY" => "N", 		
	)
);?> </div>

<!--PHOTO_RANDOM-->