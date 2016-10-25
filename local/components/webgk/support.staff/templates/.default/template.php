<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>  
<?$APPLICATION->IncludeComponent("bitrix:menu", "deskmanMenu", Array(
        "ROOT_MENU_TYPE" => "deskman",    
        "MENU_CACHE_TYPE" => "N",    
        "MENU_CACHE_TIME" => "3600",    
        "MENU_CACHE_USE_GROUPS" => "Y",    
        "MENU_CACHE_GET_VARS" => "",    
        "MAX_LEVEL" => "1",    
        "CHILD_MENU_TYPE" => "",    
        "USE_EXT" => "Y",    
        ),
        false
    ); 
?>
<? if(count($arResult)>=1) { ?>
    <h1><?=GetMessage('SUPPORT_MAIN_TITLE')?></h1><br>
    <form id="staff-form" method="get">
        <?=GetMessage('SUPPORT_INTERVAL_TIME')?> 
        <div class="date-input">             
            <?$APPLICATION->IncludeComponent(
                    "bitrix:main.calendar", 
                    ".default", 
                    array(
                        "COMPONENT_TEMPLATE" => ".default",
                        "SHOW_INPUT" => "Y",
                        "FORM_NAME" => "date_filter",
                        "INPUT_NAME" => "date_fld",
                        "INPUT_NAME_FINISH" => "date_fld_finish",
                        "INPUT_VALUE" => $arResult["FILTER"][">=DATE"],
                        "INPUT_VALUE_FINISH" => $arResult["FILTER"]["<=DATE"],
                        "SHOW_TIME" => "N",
                        "HIDE_TIMEBAR" => "Y"
                    ),
                    false
                );?> 
        </div>
        &nbsp; <br><br>
        <?=GetMessage('SUPPORT_STAFF')?> :
        <select id="user" name="user">
            <option value=""><?=GetMessage('SUPPORT_STAFF_ALL')?></option>
            <?  foreach ($arResult["FILT_USERS"] as $arUser) {?>
                <option value="<?=$arUser["ID"]?>" <? if($arResult["FILTER"]["ID"]==$arUser["ID"]) {?>selected="selected"<?}?>><?=$arUser["NAME"]." ".$arUser["LAST_NAME"]?></option>
                <?}?>
        </select><br><br>
        <button type="submit"><?=GetMessage('SUPPORT_FIND')?></button>
        <button type="submit" name="IS_RESET" value="Y"><?=GetMessage('SUPPORT_RESET')?></button><br><br>

    </form><br>
    <?  if(!empty($_REQUEST["user"])) { ?>
        <table class="statTable">
            <?   
                foreach  ($arResult["STAT"] as $yID => $year) {
                ?>   
                <tr>
                    <th colspan="5" class="yearTitle" style="text-transform: uppercase;"><?=$yID.' '.GetMessage('SUPPORT_YEAR')?></th>                 
                </tr>
                <? foreach  ($year as $mID => $months) {
                    ?>
                    <tr>
                        <th colspan="5" class="monthName" style="text-transform: uppercase;"><?=GetMessage('SUPPORT_MONTH_'.$mID)?></th>                
                    </tr>
                    <tr>
                        <th><?=GetMessage('SUPPORT_PROJECT')?></th>
                        <th><?=GetMessage('SUPPORT_TICKET')?></th>
                        <th><?=GetMessage('SUPPORT_TIME')?></th>
                        <th><?=GetMessage('SUPPORT_TIME_TO_PAY')?></th>
                        <th><?=GetMessage('SUPPORT_TIME_PAYED')?></th>
                    </tr>
                    <? 
                        $i = 0;  
                        ksort($months);
                        foreach ($months[$arResult["FILTER"]["ID"]] as $pID=>$projectInfo)
                        {    
                        ?>
                        <tr <?if ($i%2 != 0){?> style="background: #efefef;"<?}?>>
                            <td>   
                                <? $group='';
                                    if(!empty($arResult["GROUPS"][$arResult["CLIENT_LIST"][$pID]["USER_ID"]])){
                                        $group='['.GetMessage('SUPPORT_GROUPS').$arResult["GROUPS"][$arResult["CLIENT_LIST"][$pID]["USER_ID"]].'] ';
                                    }
                                ?>                       
                                <?=$group.$arResult["CLIENT_LIST"][$pID]["PROJECT_NAME"]?>
                            </td>
                            <td align="center">
                                <?
                                    $ticketsCount = count($projectInfo);
                                    $totalTicketCount +=$ticketsCount;
                                    echo $ticketsCount;
                                ?>
                            </td>
                            <td align="center">
                                <?
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES"]) == 1) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES"] = "0".$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES"];}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES"]) == 0) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES"] = "00";}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS"]) == 0) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS"] = "0";}
                                    echo $arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS"].":".$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES"];
                                ?>
                            </td>
                            <td align="center">
                                <?
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_IN_PAY"]) == 1) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_IN_PAY"] = "0".$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_IN_PAY"];}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_IN_PAY"]) == 0) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_IN_PAY"] = "00";}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS_IN_PAY"]) == 0) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS_IN_PAY"] = "0";}
                                    echo $arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS_IN_PAY"].":".$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_IN_PAY"];
                                ?>
                            </td>
                            <td align="center" <?if (intval($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_PAYED"]) != intval($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_IN_PAY"]) || intval($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS_IN_PAY"]) != intval($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS_PAYED"])){?>style="background: #FFA8C1;"<?}?>>   
                                <?
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_PAYED"]) == 1) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_PAYED"] = "0".$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_PAYED"];}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_PAYED"]) == 0) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_PAYED"] = "00";}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS_PAYED"]) == 0) {$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS_PAYED"] = "0";}
                                    echo $arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_HOURS_PAYED"].":".$arResult["STAT_TIME"][$yID][$mID][$arResult["CLIENT_LIST"][$pID]["ID"]]["CLIENT_MINUTES_PAYED"];
                                ?>
                            </td>
                        </tr>    
                        <?$i++;?> 
                        <?}?>
                    <tr style="background: #91D1DB;">
                        <td align="right"><b><?=GetMessage('SUPPORT_TOTAL')?></b></td>
                        <td align="center"><b><?=$totalTicketCount?></b></td>

                        <td align="center"><b>
                                <?
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES"]) == 1) {$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES"] = "0".$arResult["STAT_TIME"][$yID][$mID][$pID]["USER_MINUTES"];}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES"]) == 0) {$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES"] = "00";}
                                    echo $arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS"].":".$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES"];
                                ?>
                            </b>
                        </td>
                        <td align="center"><b>
                                <?if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_IN_PAY"]) == 1) {$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_IN_PAY"] = "0".$arResult["STAT_TIME"][$yID][$mID][$pID]["USER_MINUTES_IN_PAY"];}
                                    echo $arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS_IN_PAY"].":".$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_IN_PAY"];
                                ?>
                            </b>
                        </td>
                        <td align="center" <?if ($arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_IN_PAY"] != $arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_PAYED"] || $arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS_IN_PAY"] != $arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS_PAYED"]){?> style="background: #FFA8C1;"<?}?>><b>
                                <?
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_PAYED"]) == 1) {$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_PAYED"] = "0".$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_PAYED"];}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_PAYED"]) == 0 || !$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_PAYED"]) {$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_PAYED"] = "00";}
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS_PAYED"]) == 0 || !$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS_PAYED"]) {$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS_PAYED"] = "0".$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS_PAYED"];}
                                    echo $arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_HOURS_PAYED"].":".$arResult["STAT_TIME"][$yID][$mID][$arResult["FILTER"]["ID"]]["USER_MINUTES_PAYED"];
                                ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <?}?>
                <?}?>
        </table>
        <?
        } else if (count($arResult["STAT"])>=1){?>  

        <table class="statTable">
            <?   
                foreach  ($arResult["STAT"] as $yID => $year) { 
                ?>
                <tr>
                    <th colspan="34" class="yearTitle" style="text-transform: uppercase;"><?=$yID.' '.GetMessage('SUPPORT_YEAR')?></th>                 
                </tr>
                <?foreach  ($year as $mID => $month) { 
                        $dayInMonth = cal_days_in_month(CAL_GREGORIAN, $mID, $yID);   
                    ?>
                    <tr>
                        <th colspan="<?=$dayInMonth+3?>" class="monthName" style="text-transform: uppercase;"><?=GetMessage('SUPPORT_MONTH_'.$mID)?></th>                 
                    </tr>
                    <tr>
                        <th><?=GetMessage('SUPPORT_STAFF')?></th>
                        <th><?=GetMessage('SUPPORT_TICKET')?></th>
                        <th><?=GetMessage('SUPPORT_TIME')?></th>
                        <?
                            for ($t = 1; $t <= $dayInMonth; $t++) {
                            ?>
                            <th><?=$t?></th>
                            <?
                            }
                        ?>
                    </tr> 

                    <? foreach ($month as $tID => $userTickets) {?>
                        <tr <?if ($i%2 != 0){?> style="background: #efefef;"<?}?>>

                            <td><a href="javascript:void(0)" onclick="$('#user').val(<?=$tID?>); $('#staff-form').submit();" title="<?=GetMessage('SUPPORT_TITLE_STAFF')?> <?=$arResult["USERS"][$tID]["NAME"]." ".$arResult["USERS"][$tID]["LAST_NAME"]?>"><?=$arResult["USERS"][$tID]["NAME"]." ".$arResult["USERS"][$tID]["LAST_NAME"]?></a></td>
                            <td align="center">
                                <?   
                                    $ticketsCount = count($userTickets);
                                    echo $ticketsCount;?>
                            </td>
                            <td align="center">      
                                <?  
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$tID]["USER_MINUTES"]) == 1) {$arResult["STAT_TIME"][$yID][$mID][$tID]["USER_MINUTES"] = "0".$arResult["STAT_TIME"][$yID][$mID][$tID]["USER_MINUTES"];}
                                    echo $arResult["STAT_TIME"][$yID][$mID][$tID]["USER_HOURS"].":".$arResult["STAT_TIME"][$yID][$mID][$tID]["USER_MINUTES"];
                                ?>
                            </td>
                            <?  
                                for ($d = 1; $d <= $dayInMonth; $d++) {                                      
                                    $day = date('w', mktime(0,0,0,$mID,$d,$yID));
                                    if (strlen($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"]) == 1) {$arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"] = "0".$arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"];}
                                    if (empty($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"])) { $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"] = "0";}
                                    if (empty($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"])) { $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"] = "00";}
                                ?>

                                <?  
                                    /*  
                                    if ($d == date("d") && $mID == date("m")) {$tdClass = "today";}
                                    else if ((($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"] == "0") && ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"] == "00") &&  $mID != date("m")) || (($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"] == "0") && ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"] == "00") && ($mID == date("m") && $d < date("d")))){ $tdClass = "emptyDay";} 
                                    else if ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"] >=5 ) { $tdClass = "high"; } else if ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"]>=4 && $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"]<5) { $tdClass = "middle";} else if ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"]<4) { $tdClass = "low";}  else if (($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"]==0 && $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"]>0) || ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"]==0 && $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"]==0) ) {$tdClass = "lowest";}
                                    else {$tdClass = "";}
                                    if ($d > date("d") && $mID == date("m")) {$tdClass = "";}
                                    if ($day==0 || $day==6) {$tdClass = "holiday";}   */
                                    $current_work_minutes = $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"];
                                    $current_work_hours = $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"];


                                    $tdClass = "";

                                    if ($arResult["USERS"][$tID]["WORK_NORM"] == 0) {
                                        $tdClass = "default"; 
                                        if ($day==0 || $day==6) {
                                            $tdClass = "holiday";
                                        }
                                        if ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"] > 0 
                                            || $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"] > 0
                                        ) {
                                            $tdClass = "high";     
                                        }                                         
                                    } else {
                                        $total_minutes = $current_work_minutes + $current_work_hours * 60;
                                        if ($total_minutes >=  $arResult["USERS"][$tID]["WORK_NORM"]) {
                                            $tdClass = "high";
                                        } else if ($total_minutes < $arResult["USERS"][$tID]["WORK_NORM"] && $total_minutes > ($arResult["USERS"][$tID]["WORK_NORM"] * $arResult["YELLOW_ZONE_PERCENT"] / 100)) {
                                            $tdClass = "middle";
                                        } else {
                                            $tdClass = "low";
                                        }    
                                    }
                                    //future
                                    if ($d > date("d") && $mID == date("m")) {                                         
                                        $tdClass = "";
                                        if ($arResult["USERS"][$tID]["WORK_NORM"] == 0) {
                                            $tdClass = "default"; 
                                        }
                                    }

                                    if ($day==0 || $day==6) {
                                        $tdClass = "holiday";
                                    } 

                                    if ($d == date("d") && $mID == date("m")) {
                                        $tdClass = "today";
                                    }
                                ?>

                                <td align="center" class="<?=$tdClass?>" >

                                    <?  if ((($d <= date("d") && $mID == date("m")) || $mID < date("m") || $mID > date("m")) && (($day != 0 && $day !=6) || ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"] != "0") || ($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"] != "00")) /*&& ($day != 0 && $day !=6)*/) {    
                                            echo $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"].":".$arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"];
                                            if ($tdClass != "emptyDay") {
                                            ?>
                                            <br>
                                            <a href="javascript:void(0)" class="show-info-link">[<?echo count($arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["TICKETS"])?>]</a>

                                            <div class="info-popup-container">
                                                <div class="ticket-tracking-close">&#10006;</div>

                                                <div>
                                                    <p class="popup-user-name"><span><?=$arResult["USERS"][$tID]["NAME"]." ".$arResult["USERS"][$tID]["LAST_NAME"]?></span> [<?=$d.".".$mID.".".$yID?>]</p>
                                                    <? $day_tickets = $arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["TICKETS"];
                                                        if (is_array($day_tickets) && count($day_tickets) > 0) {?>
                                                        <table>
                                                            <?foreach ($day_tickets as $t_id => $ticket) {?>
                                                                <tr>
                                                                    <td width="10%">
                                                                        [<?=$t_id?>]
                                                                    </td>

                                                                    <td>  
                                                                        <?if ($ticket["LINK"]) {?><a href="<?=$ticket["LINK"]?>" target="_blank"><?}?>
                                                                            <?=$arResult["ALL_TICKETS"][$t_id]["TITLE"]?>
                                                                        <?if ($ticket["LINK"]) {?></a><?}?> 
                                                                    </td>  

                                                                    <td class="ticket-time" width="10%">
                                                                        <?=$ticket["HOURS"].":".$ticket["MINUTES"]?>
                                                                    </td> 
                                                                </tr>
                                                                <?}?>  

                                                            <tr>
                                                                <td colspan="2" align="right">
                                                                        <?=GetMessage('SUPPORT_TOTAL')?>:
                                                                </td>

                                                                <td>
                                                                    <b style="color: green;">
                                                                        <?=$arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_HOURS"].":".$arResult["STAT_TIME"][$yID][$mID][$tID]["DAILY_STAT"][$d]["USER_MINUTES"];?>
                                                                    </b>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2" align="right">
                                                                        <?=GetMessage('USER_NORM')?>:
                                                                </td>

                                                                <td>
                                                                    <b style="color: red;">
                                                                       <?=$arResult["WORK_NORMS"][$tID]?>
                                                                    </b>
                                                                </td>
                                                            </tr>


                                                        </table>    
                                                        <?} else {?>
                                                        <p><?=GetMessage("NO_TICKETS")?></p>
                                                        <?}?>
                                                    <hr />
                                                    <?if ($arResult["USERS"][$tID]["WORK_NORM"] == 0 || $total_minutes >=  $arResult["USERS"][$tID]["WORK_NORM"]) {?>
                                                        <p><b style="color: green"><?=GetMessage("REPORT_NOT_REQUIRED")?></b></p>
                                                        <?} else if ($total_minutes < $arResult["USERS"][$tID]["WORK_NORM"]) {?>
                                                        <?if ($arResult["REPORTS"][$tID][$d.".".$mID.".".$yID]) {?>
                                                            <p><b style="color: red"><?=GetMessage("REPORT")?>:</b><br /> <?=$arResult["REPORTS"][$tID][$d.".".$mID.".".$yID];?></p>
                                                            <?} else {?>
                                                            <p><b style="color: red"><?=GetMessage("REPORT_NOT_EXISTS")?></b></p>
                                                            <?}?>
                                                        <?}?>
                                                </div>

                                            </div>

                                            <?}?>
                                        <?}?>

                                </td>
                                <? }
                            ?>

                        </tr> 
                        <?}?>
                    <tr style="background: #91D1DB;">
                        <td align="right" colspan="2"><b><?=GetMessage('SUPPORT_TOTAL')?></b></td>
                        <?
                            if (strlen($arResult["STAT_TIME"][$yID][$mID]["MONTH_MINUTES"]) == 1) {$arResult["STAT_TIME"][$yID][$mID]["MONTH_MINUTES"] = "0".$arResult["STAT_TIME"][$yID][$mID]["MONTH_MINUTES"];}
                        ?>
                        <td align="center"><b><?echo $arResult["STAT_TIME"][$yID][$mID]["MONTH_HOURS"].":".$arResult["STAT_TIME"][$yID][$mID]["MONTH_MINUTES"]; ?></b></td>
                    </tr>    
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <? } ?>
                <? } ?>

        </table>
        <?    
        } else {
            echo GetMessage('SUPPORT_EMPTY_LIST');
        }
    } else {
        echo GetMessage('SUPPORT_ATTENTION');    
    }
?>
