<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>  
<?
    if (intval($_POST["year"] > 0) /*&& intval($_POST["project"]) > 0*/) {
        $tickets = array();

        $ticketFilter["DATE_CREATE_1"] = "01.01.".$_POST["year"];
        $ticketFilter["DATE_CREATE_2"] = "31.12.".$_POST["year"];

        $ticket = Cticket::GetList($by = "ID", $order = "asc", $ticketFilter, $isFiltered,"N", "Y", "Y", false, Array("SELECT" => array("UF_*" ))); 

        $ticketCount =  $ticket->SelectedRowsCount();  

        //собираем всех сотрудников техподдержки
        $staffList = array();
        $users = CUser::GetList($by="name",$order="asc",array("GROUPS_ID"=> Array(8)/*, "ACTIVE"=>"Y"*/),array("SELECT"=>array("UF_*")));
        while($arUser = $users->Fetch()) {
            $staffList[$arUser["ID"]] = $arUser; 
        }  
    }
?>      
<br><br>  
<?
    //собираем тикеты в массив
    $ticketList = array(); //массив тикетов с полным описанием
    $ticketListIDS = array(); // массив ID тикетов за выбранный период
    while($arTicket = $ticket->Fetch()) {
        //  arshow($arTicket);
        $ticketList[$arTicket["ID"]] = $arTicket;
        $ticketListIDS[] = $arTicket["ID"];
    }
    //   arshow($ticketList);

    //инфо по клиентам/проектам. собираем только активных пользователей из группы "техподдержка" (клиентов)
    $projectsInfo = array(); 
    $projects = CUSer::GetList($by="UF_SITE", $sort="asc",array("ACTIVE"=>"Y", "GROUPS_ID"=>7),array("SELECT"=>array("UF_*")));
    while ($arProject = $projects->Fetch()) {
        $projectsInfo[$arProject["ID"]] = $arProject["UF_SITE"];  
    }  
    
    //arshow($projectsInfo);
    

    $months = array(
        "01" => "€нварь",
        "02" => "февраль",
        "03" => "март",
        "04" => "апрель",
        "05" => "май",
        "06" => "июнь",
        "07" => "июль",
        "08" => "август",
        "09" => "сент€брь",
        "10" => "окт€брь",
        "11" => "но€брь",
        "12" => "декабрь"
    );

    //массив с разбивкой тикетов по мес€цам с количеством времени
    $ticketsByMonth = array();

    //собираем данные по тикетам из инфоблока с затраченным временем
    $ticketTime = CIBlockElement::GetList(array("DATE_CREATE"=>"ASC"), array("IBLOCK_ID"=>24,"PROPERTY_ticket_id"=>$ticketListIDS), false, false, array("PROPERTY_SPEND_TIME_HOURS", "PROPERTY_SPEND_TIME_MINUTES","DATE_CREATE","PROPERTY_TICKET_ID", "PROPERTY_IS_PAYED", "PROPERTY_CLIENT", "PROPERTY_SUPPORT_USER_ID"));
       
    //пишем массив с разбивкой по мес€цам врем€ дл€ каждого тикета
    while($arTicketTime = $ticketTime->Fetch()) {
        $mesMonth = substr($arTicketTime["DATE_CREATE"],3,2); //мес€ц, в котором было добавлено врем€         

        $ticketMinutes = $arTicketTime["PROPERTY_SPEND_TIME_HOURS_VALUE"] * 60 + $arTicketTime["PROPERTY_SPEND_TIME_MINUTES_VALUE"];
        
        //статистика по сотрудникам
        $ticketsByMonth[$mesMonth]["STAFF"][$arTicketTime["PROPERTY_SUPPORT_USER_ID_VALUE"]][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["TICKETS"][] = $arTicketTime["PROPERTY_TICKET_ID_VALUE"]; //по проекту
        $ticketsByMonth[$mesMonth]["STAFF"][$arTicketTime["PROPERTY_SUPPORT_USER_ID_VALUE"]][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["TOTAL_TIME"] += $ticketMinutes;  //обща€

        $ticketsByMonth[$mesMonth]["STAFF"][$arTicketTime["PROPERTY_SUPPORT_USER_ID_VALUE"]]["TICKETS"][] = $arTicketTime["PROPERTY_TICKET_ID_VALUE"];  //по проекту
        $ticketsByMonth[$mesMonth]["STAFF"][$arTicketTime["PROPERTY_SUPPORT_USER_ID_VALUE"]]["TOTAL_TIME"] += $ticketMinutes;  //обща€
        //если тикет в оплате
        if ($ticketList[$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["UF_IN_PAYMENT"]) {
            $ticketsByMonth[$mesMonth]["STAFF"][$arTicketTime["PROPERTY_SUPPORT_USER_ID_VALUE"]][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["TOTAL_TIME_TO_PAY"] += $ticketMinutes;  //по проекту
            $ticketsByMonth[$mesMonth]["STAFF"][$arTicketTime["PROPERTY_SUPPORT_USER_ID_VALUE"]]["TOTAL_TIME_TO_PAY"] += $ticketMinutes;   //обща€

        }            
        //если тикет оплачен 
        if ($arTicketTime["PROPERTY_IS_PAYED_VALUE"]) {
            $ticketsByMonth[$mesMonth]["STAFF"][$arTicketTime["PROPERTY_SUPPORT_USER_ID_VALUE"]][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["TOTAL_TIME_PAYED"] += $ticketMinutes;  //по проекту
            $ticketsByMonth[$mesMonth]["STAFF"][$arTicketTime["PROPERTY_SUPPORT_USER_ID_VALUE"]]["TOTAL_TIME_PAYED"] += $ticketMinutes;   //обща€
        }



    }
    //arshow($ticketsByMonth);
    $ticketsByMonth = array_reverse($ticketsByMonth);

    //arshow($ticketsByMonth);

    //если указан сотрудник, выводим статистику по нему, если нет - то по всем сотрудникам за мес€ц 
    if ($ticketTime->SelectedRowsCount() > 0 && $ticketCount > 0 && $_POST["user"] > 0) {

        
        Cmodule::IncludeModule("webgk.support"); 
        $suppostGroups = GKSupport::GetBitrixSupportGroup();
    ?>
    <table class="statTable">


        <?
            //перебираем полученный массив, попутно подт€гива€ инфо о тикетах
            foreach  ($ticketsByMonth as $mID => $month) 
            { 
            ?>
             <tr>
                <th colspan="5" class="monthName" style="text-transform: uppercase;"><?=$months[$mID]?></th>                
            </tr>
            <tr>
                <th>ѕроект</th>
                <th>“икетов</th>
                <th>«атрачено часов</th>
                <th>„асов к оплате</th>
                <th>„асов оплачено</th>
            </tr>
           
            <?
                $totalTime = 0; //общее врем€ по всем тикетам за мес€ц
                $totalTimeToPay = 0;
                $totalTimePayed = 0;
                $totalTicketCount = 0;

                //  krsort($month); //сортируем тикеты по ID
                //  reset($month);

                krsort($month["TICKETS"]); //сортируем тикеты по ID
                reset($month["TICKETS"]);


              $i = 0;  
            foreach ($projectsInfo as $pID=>$projectInfo)
                {?>
                <?if ($month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME"] > 0) {?>
                    <tr <?if ($i%2 != 0){?> style="background: #efefef;"<?}?>>
                        <td>  
                        <?
                        if ($suppostGroups[$pID]) {
                            $projectInfo = "[группа ".$suppostGroups[$pID]."] ".$projectInfo;
                        }
                        ?>                        
                            <?=$projectInfo?>
                        </td>

                        <td align="center">
                            <?
                                $ticketsCount = count(array_unique($month["STAFF"][$_POST["user"]][$pID]["TICKETS"]));
                                echo $ticketsCount;
                            ?>
                        </td>

                        <td align="center">
                            <?
                                $hours = floor($month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME"]/60);
                                $minutes = $month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME"]%60;
                                if (strlen($minutes) == 1) {$minutes = "0".$minutes;}
                                echo $hours.":".$minutes;
                            ?>
                        </td>

                        <td align="center">

                            <?
                                $hoursToPay = floor($month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME_TO_PAY"]/60);
                                $minutesToPay = $month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME_TO_PAY"]%60;
                                if (strlen($minutesToPay) == 1) {$minutesToPay = "0".$minutesToPay;}
                                echo $hoursToPay.":".$minutesToPay;
                            ?>
                        </td>

                        <td align="center" <?if ($month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME_TO_PAY"] != $month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME_PAYED"]){?>style="background: #FFA8C1;"<?}?>>   

                            <?
                                $hoursPayed = floor($month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME_PAYED"]/60);
                                $minutesPayed = $month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME_PAYED"]%60;
                                if (strlen($minutesPayed) == 1) {$minutesPayed = "0".$minutesPayed;}
                                echo $hoursPayed.":".$minutesPayed;
                            ?>
                        </td>
                    </tr>    
                    <?
                        $totalTime += $month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME"]; //общее врем€ по всем тикетам за мес€ц
                        $totalTimeToPay += $month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME_TO_PAY"];
                        $totalTimePayed += $month["STAFF"][$_POST["user"]][$pID]["TOTAL_TIME_PAYED"];
                        $totalTicketCount += $ticketsCount;
                        
                        $i++;
                }?> 

                <?}?>

            <tr style="background: #91D1DB;">
                <td align="right"><b>»того</b></td>
                <td align="center"><b><?=$totalTicketCount?></b></td>
                <?
                    $totalHours = floor($totalTime/60);
                    $totalMinutes = $totalTime%60;
                    if (strlen($totalMinutes) == 1) {$totalMinutes = "0".$totalMinutes;}
                ?>
                <td align="center"><b><?echo $totalHours.":".$totalMinutes;?></b></td>

                <?
                    $totalHoursToPay = floor($totalTimeToPay/60);
                    $totalMinutesToPay = $totalTimeToPay%60;
                    if (strlen($totalMinutesToPay) == 1) {$totalMinutesToPay = "0".$totalMinutesToPay;}
                ?>
                <td align="center"><b><?echo $totalHoursToPay.":".$totalMinutesToPay;?></b></td>


                <?
                    $totalHoursPayed = floor($totalTimePayed/60);
                    $totalMinutesPayed = $totalTimePayed%60;
                    if (strlen($totalMinutesPayed) == 1) {$totalMinutesPayed = "0".$totalMinutesPayed;}
                ?>
                <td align="center" <?if ($totalTimeToPay != $totalTimePayed){?> style="background: #FFA8C1;"<?}?>><b><?echo $totalHoursPayed.":".$totalMinutesPayed;?></b></td>
            </tr>

            <tr>
                <td colspan="5"></td>
            </tr>

            <?}?>
    </table>

    <?} else if($ticketTime->SelectedRowsCount() > 0 && $ticketCount > 0) {?>
    <table class="statTable">


        <?
            //перебираем полученный массив, попутно подт€гива€ инфо о тикетах
            foreach  ($ticketsByMonth as $mID => $month) { ?>
            <tr>
                <th colspan="5" class="monthName" style="text-transform: uppercase;"><?=$months[$mID]?></th>                 
            </tr>
            <tr>
                <th>—отрудник</th>
                <th>“икетов</th>
                <th>«атрачено часов</th>
                <th>„асов к оплате</th>
                <th>„асов оплачено</th>
            </tr>
            
            <?
                $totalTime = 0; //общее врем€ по всем тикетам за мес€ц
                $totalTimeToPay = 0;    

            ?>
            <?
                $monthMinutes = 0; //общее врем€ по проекту за мес€ц
                $monthMinutesToPay = 0; //общее врем€ по проекту к оплате за мес€ц
                $monthMinutesPayed = 0; //общее оплаченное врем€ по проекту за мес€ц
                $monthTicketsCount = 0; //общее количество тикетов за мес€ц

                $i = 0;
                foreach ($staffList as $sID=>$staffName){?>
                <?
                    //если по проекту в данном мес€це велись работы
                    if ($month["STAFF"][$sID]["TOTAL_TIME"] > 0) {
                    ?>
                    <tr <?if ($i%2 != 0){?> style="background: #efefef;"<?}?>>
                        <td><a href="javascript:void(0)" onclick="$('#user').val(<?=$sID?>); getUserStat()" title="показать статистику по сотруднику <?=$staffName["NAME"]." ".$staffName["LAST_NAME"]?>"><?=$staffName["NAME"]." ".$staffName["LAST_NAME"]?></a></td>
                        <td align="center">
                            <? 
                                $ticketsCount = count(array_unique($month["STAFF"][$sID]["TICKETS"]));
                                echo $ticketsCount;?>
                        </td>
                        <td align="center">
                            <?
                                $hours = floor($month["STAFF"][$sID]["TOTAL_TIME"]/60);
                                $minutes = $month["STAFF"][$sID]["TOTAL_TIME"]%60;
                                if (strlen($minutes) == 1) {$minutes = "0".$minutes;}
                                echo $hours.":".$minutes;
                            ?>
                        </td>
                        <td align="center">
                            <?
                                $hoursToPay = floor($month["STAFF"][$sID]["TOTAL_TIME_TO_PAY"]/60);
                                $minutesToPay = $month["STAFF"][$sID]["TOTAL_TIME_TO_PAY"]%60;
                                if (strlen($minutesToPay) == 1) {$minutesToPay = "0".$minutesToPay;}
                                echo $hoursToPay.":".$minutesToPay;
                            ?>
                        </td>


                        <td align="center" <?if ($month["STAFF"][$sID]["TOTAL_TIME_TO_PAY"] != $month["STAFF"][$sID]["TOTAL_TIME_PAYED"]){?> style="background: #FFA8C1;"<?}?>>
                            <?
                                $hoursPayed = floor($month["STAFF"][$sID]["TOTAL_TIME_PAYED"]/60);
                                $minutesPayed = $month["STAFF"][$sID]["TOTAL_TIME_PAYED"]%60;
                                if (strlen($minutesPayed) == 1) {$minutesPayed = "0".$minutesPayed;}
                                echo $hoursPayed.":".$minutesPayed;
                            ?>
                        </td>
                    </tr>      

                    <?
                        $monthMinutes += $month["STAFF"][$sID]["TOTAL_TIME"];
                        $monthMinutesToPay += $month["STAFF"][$sID]["TOTAL_TIME_TO_PAY"];
                        $monthMinutesPayed += $month["STAFF"][$sID]["TOTAL_TIME_PAYED"];
                        $monthTicketsCount += $ticketsCount;
                        
                        $i++;
                    ?>
                    <?}?>
                <?}?>   
            <tr style="background: #91D1DB;">
                <td align="right" colspan="2"><b>»того</b></td>
                <?
                    $totalHours = floor($monthMinutes/60);
                    $totalMinutes = $monthMinutes%60;
                    if (strlen($totalMinutes) == 1) {$totalMinutes = "0".$totalMinutes;}
                ?>
                <td align="center"><b><?echo $totalHours.":".$totalMinutes;?></b></td>

                <?
                    $totalHoursToPay = floor($monthMinutesToPay/60);
                    $totalMinutesToPay = $monthMinutesToPay%60;
                    if (strlen($totalMinutesToPay) == 1) {$totalMinutesToPay = "0".$totalMinutesToPay;}
                ?>
                <td align="center"><b><?echo $totalHoursToPay.":".$totalMinutesToPay;?></b></td>


                <?
                    $totalHoursPayed = floor($monthMinutesPayed/60);
                    $totalMinutesPayed = $monthMinutesPayed%60;
                    if (strlen($totalMinutesPayed) == 1) {$totalMinutesPayed = "0".$totalMinutesPayed;}
                ?>
                <td align="center" <?if ($monthMinutesToPay != $monthMinutesPayed){?> style="background: #FFA8C1;"<?}?>><b><?echo $totalHoursPayed.":".$totalMinutesPayed;?></b></td>
            </tr>    
            <tr>
                <td colspan="5"></td>
            </tr>
            <?}?>
    </table>
    <?} else {?>
    <p>«а выбранный период обращений не найдено.</p>
    <?}?>