<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������������� ���������� ��������");
?> <?$APPLICATION->IncludeComponent(
	"bitrix:subscribe.edit",
	"",
Array(),
false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>