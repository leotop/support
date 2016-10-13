</div></td>
<td style='width: 225px;' valign="top">
<?
if(!strstr($_SERVER['REQUEST_URI'],"subscribe")){
?>
<?/*
<?$APPLICATION->IncludeComponent("bitrix:menu", "template1", Array(
	"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
	"MENU_CACHE_TYPE" => "N",	// Тип кеширования
	"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
	"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	),
	false
);
}
?>
<div style='margin-top: 30px;'>
<?
if(CUser::IsAuthorized())
{?> <?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"",
	Array(
		"REGISTER_URL" => "/registration/",
		"PROFILE_URL" => "/edit_fields/",
		"SHOW_ERRORS" => "N"
	),
false
);?>
</div>
<?*/}
?> 


</td>
			</tr>
		</table>
	</td>
	<td><img src='/img1/pixel.png' style="width:1px;height:1px;" /></td>
</tr><!--Подвал страницы-->
<tr>
	<td><img src='/img1/pixel.png' style="width:1px;height:1px;" /></td>
	<td style="border-top: 1px solid #a9a9a9; text-align: center;" >
		
		<table style="border-top: 4px solid #f8f8f8; width: 100%; background: #c1c1c1"><tr>
			<td style="" ><img src="/img1/gray_bot1.jpg" alt="" /></td>
			<td style="text-align: center; vertical-align: middle; padding: 0 0 5px;">
            <?$APPLICATION->IncludeComponent("bitrix:menu", "main_menu", array(
            	"ROOT_MENU_TYPE" => "top",
            	"MENU_CACHE_TYPE" => "N",
            	"MENU_CACHE_TIME" => "3600",
            	"MENU_CACHE_USE_GROUPS" => "Y",
            	"MENU_CACHE_GET_VARS" => array(
            	),
            	"MAX_LEVEL" => "1",
            	"CHILD_MENU_TYPE" => "",
            	"USE_EXT" => "Y"
            	),
            	false
            );?>
			</td>
			<td style="text-align: right;"><img style='margin-left: auto; margin-right: 0px;' src="/img1/gray_bot2.jpg" alt="" /></td>
		</tr>
		</table>
		<table style="background: #f8f8f8; height: 100px; width: 100%;">
		<tr>
			<td style="padding: 0 0 0 14px;">
				<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("/include_areas1/contact_left.php",Array(),Array("MODE"=>"html")));?>
			</td>
			<td style="text-align: right; padding: 0 14px 0 0;">
				<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("/include_areas1/contact_right.php",Array(),Array("MODE"=>"html")));?>

			</td>

		</tr>
		</table>
</tr>
</table>
<?$APPLICATION->IncludeComponent("webgk:support.user.reports", "", array());?>
<?$APPLICATION->IncludeComponent(
    "webgk:support.ticket.tracking", 
    "", 
    array("WORK_STATUS_ID" => "W", "TICKET_PAGE_URL" => "/?ID=#TICKET_ID#&edit=1"),
    false
    );?>
</body>
</html>