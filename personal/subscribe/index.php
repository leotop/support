<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�������� �� ��������");
?><?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "subscribe", Array(
	"USE_PERSONALIZATION" => "Y",	// ���������� �������� �������� ������������
	"PAGE" => "/personal/subscribe/subscr_edit.php",	// �������� �������������� �������� (�������� ������ #SITE_DIR#)
	"SHOW_HIDDEN" => "N",	// �������� ������� ������� ��������
	"CACHE_TYPE" => "A",	// ��� �����������
	"CACHE_TIME" => "3600",	// ����� ����������� (���.)
	"CACHE_NOTES" => ""
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>