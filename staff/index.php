<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "����������� ���������");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("������� ��������");
?><?$APPLICATION->IncludeComponent(
	"webgk:support.staff", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"DEFAULT_MONTH_COUNT" => "2"
	),
	false
);?><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>