<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Техническая поддержка");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Главная страница");
?><?$APPLICATION->IncludeComponent(
	"webgk:support.staff", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"DEFAULT_MONTH_COUNT" => "2",
		"YELLOW_ZONE_PERCENT" => "75",
		"TICKET_PAGE_URL" => "/?ID=#TICKET_ID#&edit=1"
	),
	false
);?><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>