<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "����������� ���������");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("������� ��������");
?><? $APPLICATION->IncludeComponent(
	"webgk:support.balance", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PAGE_QUANTITY" => "100",
		"HIDE_NULL_BALANCE" => "Y"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>