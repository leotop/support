<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Техническая поддержка");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Главная страница");
?><?$APPLICATION->IncludeComponent(
	"webgk:support.load", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"SUPPORT_CRITICALY" => "5",
		"SUPPORT_CRITICALY_SUM" => "10"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>