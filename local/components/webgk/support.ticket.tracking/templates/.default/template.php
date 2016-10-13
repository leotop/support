<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult["USERS"])) {?>

    <div class="ticket-tracking-container-wrapper">

        <div class="ticket-tracking-button ticket-tracking-control" >
            <?=GetMessage("TICKETS_IN_WORK")?>: <b><?=$arResult["TOTAL_COUNT"]?></b>
        </div>

        <div class="ticket-tracking-container" id="ticket-tracking-container">     

            <div class="ticket-tracking-close ticket-tracking-control">&#10006;</div>

            <div class="total-ticket-count ticket-tracking-title"><?=GetMessage("TOTAL_TICKET_IN_WORK_COUNT")?>: <b><?=$arResult["TOTAL_TICKET_IN_WORK_COUNT"]?></b></div>
            <div class="total-ticket-count-in-work ticket-tracking-title"><?=GetMessage("TOTAL_COUNT")?>: <b><?=$arResult["TOTAL_COUNT"]?></b></div>

            <hr />

            <?foreach ($arResult["USERS"] as $user) {?>
                <p><b><span style="color: green"><?=$user["LAST_NAME"]." ".$user["NAME"]?></span> <span style="color: red;">(<?=count($user["TICKETS"])?>)</span></b></p>
                <ul>
                    <?foreach ($user["TICKETS"] as $ticket) {?>
                        <li>[<?=$ticket["TICKET_ID"]?>] <a href="<?=$ticket["DETAIL_PAGE_URL"]?>" target="_blank"> <?=$arResult["TICKETS"][$ticket["TICKET_ID"]]["TITLE"]?></a></li>
                        <?}?>
                </ul>
                <hr />
                <?}?>

            <?if (!empty($arResult["USERS_WITHOUT_WORK"])) {?>
                <div class="ticket-tracking-free-users">
                    <span style="color: red"><?=GetMessage("FREE_USERS")?> (<?=count($arResult["USERS_WITHOUT_WORK"])?>):</span><br />   
                    <?foreach ($arResult["USERS_WITHOUT_WORK"] as $user){?>
                        <span style="color: green"><?=$user["LAST_NAME"]." ".$user["NAME"]?></span>
                        <?}?>
                </div>
                <?}?>
        </div>

    </div>
    <?}?>