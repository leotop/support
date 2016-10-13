<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult["IN_WORK"]) && !empty($arResult["TICKET_ID"])) {?>
    <form id="ticket-in-work-">
        <input id="ticket-in-work-<?=$arResult["TICKET_ID"]?>" name="ticket-in-work-<?=$arResult["TICKET_ID"]?>" value="<?echo ($arResult["IN_WORK"] == "Y") ? "N" : "Y"?>" type="checkbox">   

    </form>
    <?}?>