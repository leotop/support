<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    $bDemo = (CTicket::IsDemo()) ? "Y" : "N";
    $bAdmin = (CTicket::IsAdmin()) ? "Y" : "N";
    $bSupportTeam = (CTicket::IsSupportTeam()) ? "Y" : "N";
    $bADS = $bDemo == 'Y' || $bAdmin == 'Y' || $bSupportTeam == 'Y';
?>

<?
global $USER;
if (in_array(8, $USER->GetUserGroupArray()) ) {
	CModule::IncludeModule('pull');
	CPullWatch::Add($USER->GetID(), "Tickets_notify");
?>
<link href="/local/push_messages/css/style.css" type="text/css"  rel="stylesheet" />
<script type="text/javascript" src="/local/push_messages/js/push.js"></script>
<script>
$(function() {
	$(".bx-filter-rows").find("tr").css("display","");
	
	// пуши по уведомлениям
	var tickets_push = new SupportPush();
	tickets_push.init();

	BX.addCustomEvent("onPullEvent", BX.delegate(function(module_id, command, params) {	
		var result       = JSON.parse(params.data),
			popup_header = result.header,
			popup_body   = result.message;
			tickets_push.onNewPush(popup_header, popup_body);
		}, this));
})
</script>
 
<div id="popup_container">
</div>
<? } ?>

<script type="text/javascript">BX.loadCSS('<? echo CUtil::JSEscape( $this->GetFolder() ); ?>/style.css');</script>

<a href="<?=$APPLICATION->GetCurPage()."?show_wizard=Y"?>"><?=GetMessage("SUP_ASK")?></a>

<br />
<br />

<?  
    //Forming table headers
    $ticketListHeader=array(
        array("id"=>"LAMP", "name"=> GetMessage('SUP_LAMP'), "sort"=>"s_lamp", "default"=>true, "align"=>"center"),
        array("id"=>"ID", "name"=>GetMessage('SUP_ID'), "sort"=>"s_id", "default"=>true),
        array("id"=>"TITLE", "name"=>GetMessage('SUP_TITLE'), "default"=>true),
        array("id"=>"TIMESTAMP_X", "name"=>GetMessage('SUP_TIMESTAMP'), "sort"=>"s_timestamp_x", "default"=>true, "align"=>"center"),
        array("id"=>"RESPONSIBLE_HTML_NAME_S", "name"=>GetMessage('SUP_RESPONSIBLE'), "default"=>true),
        array("id"=>"MESSAGES", "name"=>GetMessage('SUP_MESSAGES'),  "default"=>true, "align"=>"center"),
        array("id"=>"STATUS_NAME", "name"=>GetMessage('SUP_STATUS'), "default"=>true, "align"=>"center"),
        array("id"=>"OWNER_HTML_NAME_S", "name"=>GetMessage('SUP_OWNER'), "default"=>true),
        array("id"=>"UF_SPEND_TIME", "name"=>GetMessage('SUP_TIME'), "default"=>true, "align"=>"center"),
        array("id"=>"CRITICALITY_NAME", "name"=>GetMessage('SUP_CRITICALITY'), "default"=>true, "align"=>"center"),
        array("id"=>"DATE_CREATE", "name"=>GetMessage('SUP_DATE_CREATE'),"sort"=>"date_create", "default"=>true, "align"=>"center"),
        array("id"=>"NEED_TESTING", "name"=>GetMessage('SUP_TESTING'), "align"=>"center", "default"=>true)
    );
    
    //if user support admin or site admin
    if ($bAdmin == "Y" || $USER->IsAdmin()) {
       $ticketListHeader[] = array("id"=>"SUP_PLAN", "name"=>GetMessage('SUP_PLAN'), "align"=>"center", "default"=>true); 
    }
    
    /*Show testing only for support employer
    if($arResult["IS_STAFF"]=='Y') {
        $ticketListHeader[]=array("id"=>"NEED_TESTING", "name"=>GetMessage('SUP_TESTING'), "align"=>"center", "default"=>true);
    }*/    
    
   
    $APPLICATION->IncludeComponent(
        "webgk:main.interface.grid",
        "",
        array(
            "GRID_ID"=>$arResult["GRID_ID"],
            "HEADERS"=> $ticketListHeader,
            "SORT"=>$arResult["SORT"],
            "SORT_VARS"=>$arResult["SORT_VARS"],
            "ROWS"=>$arResult["ROWS"],
            "FOOTER"=>array(array("title"=>GetMessage('SUP_TOTAL'), "value"=>$arResult["ROWS_COUNT"])),
            "ACTION_ALL_ROWS"=>false,
            "EDITABLE"=>false,
            "NAV_OBJECT"=>$arResult["NAV_OBJECT"],
            "AJAX_ID"=>$arParams["AJAX_ID"],
            "FILTER"=>$arResult["FILTER"],
            "TICKET_PLAN"=>$arResult["TICKET_PLAN"],
            "IS_STAFF"=>$arResult["IS_STAFF"],
            "TICKET_PLAN_LOG"=>$arResult["TICKET_PLAN_LOG"], 
        ),
        $component
    );
?>


<br />
<table class="support-ticket-hint">
    <tr>
        <td><div class="support-lamp-red"></div></td>
        <td> - <?=$bADS ? GetMessage("SUP_RED_ALT_SUP") : GetMessage("SUP_RED_ALT_2")?></td>
    </tr>
    <?if ($bADS):?>
        <tr>
            <td><div class="support-lamp-yellow"></div></td>
            <td> - <?=GetMessage("SUP_YELLOW_ALT_SUP")?></td>
        </tr>
        <?endif;?>
    <tr>
        <td><div class="support-lamp-green"></div></td>
        <td> - <?=GetMessage("SUP_GREEN_ALT")?></td>
    </tr>
    <?if ($bADS):?>
        <tr>
            <td><div class="support-lamp-green-s"></div></td>
            <td> - <?=GetMessage("SUP_GREEN_S_ALT_SUP")?></td>
        </tr>
        <?endif;?>
    <tr>
        <td><div class="support-lamp-grey"></div></td>
        <td> - <?=GetMessage("SUP_GREY_ALT")?></td>
    </tr>
</table>