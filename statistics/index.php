<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "����������� ���������");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("������� ��������");
?><?$APPLICATION->IncludeComponent(
	"webgk:support.statistic", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"TICKET_DETAIL_PAGE" => "/?ID=#ID#&edit=1",
		"DEFAULT_MONTH_COUNT" => "3"
	),
	false
);?><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>