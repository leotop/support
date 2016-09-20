<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?> 
<div id="to_form_reg_my"><?$APPLICATION->IncludeComponent(
	"bitrix:main.register",
	"",
	Array(
		"USER_PROPERTY_NAME" => "",
		"SEF_MODE" => "N",
		"SHOW_FIELDS" => Array("NAME", "LAST_NAME"),
		"REQUIRED_FIELDS" => Array("NAME"),
		"AUTH" => "Y",
		"USE_BACKURL" => "Y",
		"SUCCESS_PAGE" => "http://support.webgk.ru",
		"SET_TITLE" => "Y",
		"USER_PROPERTY" => Array("UF_ORGANIZATION", "UF_SITE")
	)
);?></div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>