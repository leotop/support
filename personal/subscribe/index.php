<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подписка на рассылку");
?><?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "subscribe", Array(
	"USE_PERSONALIZATION" => "Y",	// Определять подписку текущего пользователя
	"PAGE" => "/personal/subscribe/subscr_edit.php",	// Страница редактирования подписки (доступен макрос #SITE_DIR#)
	"SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"CACHE_NOTES" => ""
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>