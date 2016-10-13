<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult["IN_WORK"]) && !empty($arResult["TICKET_ID"])) {?>
    <div id="ticket-in-work-<?=$arResult["TICKET_ID"]?>">
        <label for="ticket-<?=$arResult["TICKET_ID"]?>" class="ticket-in-work <?echo ($arResult["IN_WORK"] == "Y")? "working" : "" ; ?>" >
            <input id="ticket-<?=$arResult["TICKET_ID"]?>" type="checkbox" data-ticket-id="<?=$arResult["TICKET_ID"]?>" value="<?echo ($arResult["IN_WORK"] == "Y") ? "N" : "Y"?>" <?echo ($arResult["IN_WORK"] == "Y") ? "checked" : "" ;?>>
            <?=GetMessage("WORK")?>   
        </label> 
    </div>    
    <?}?>