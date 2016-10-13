<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetPageProperty("title", "Техническая поддержка");
    $APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
    $APPLICATION->SetTitle("Главная страница");
?><?$APPLICATION->IncludeComponent(
	"webgk:support.wizard", 
	".default", 
	array(
		"IBLOCK_TYPE" => "support",
		"IBLOCK_ID" => "3",
		"PROPERTY_FIELD_TYPE" => "",
		"PROPERTY_FIELD_VALUES" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"TICKETS_PER_PAGE" => "50",
		"MESSAGES_PER_PAGE" => "20",
		"MESSAGE_MAX_LENGTH" => "70",
		"MESSAGE_SORT_ORDER" => "desc",
		"SET_PAGE_TITLE" => "Y",
		"TEMPLATE_TYPE" => "standard",
		"SHOW_RESULT" => "Y",
		"SHOW_COUPON_FIELD" => "N",
		"SET_SHOW_USER_FIELD" => array(
		),
		"SECTIONS_TO_CATEGORIES" => "Y",
		"SELECTED_SECTIONS" => array(
		),
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => ".default",
		"TICKET_LIST_URL" => "/",
		"WORK_STATUS_ID" => "W",
		"VARIABLE_ALIASES" => array(
			"ID" => "ID",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>