<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>  
<?
    if (intval($_POST["year"] > 0) /*&& intval($_POST["project"]) > 0*/) {
        $tickets = array();

        if ($_POST["project"] > 0) {
            $ticketFilter["OWNER_USER_ID"] = $_POST["project"];  
        }   
        $ticketFilter["DATE_CREATE_1"] = "01.01.".$_POST["year"];
        $ticketFilter["DATE_CREATE_2"] = "31.12.".$_POST["year"];

        $ticket = Cticket::GetList($by = "ID", $order = "asc", $ticketFilter, $isFiltered,"N", "Y", "Y", false, Array("SELECT" => array("UF_*" ))); 

        $ticketCount =  $ticket->SelectedRowsCount();    

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
        $projectsInfo[$arProject["ID"]] = $arProject;  
    }  

    $months = array(
        "01" => "январь",
        "02" => "февраль",
        "03" => "март",
        "04" => "апрель",
        "05" => "май",
        "06" => "июнь",
        "07" => "июль",
        "08" => "август",
        "09" => "сентябрь",
        "10" => "октябрь",
        "11" => "ноябрь",
        "12" => "декабрь"
    );

    //массив с разбивкой тикетов по месяцам с количеством времени
    $ticketsByMonth = array();

    //собираем данные по тикетам из инфоблока с затраченным временем
    $ticketTime = CIBlockElement::GetList(array("DATE_CREATE"=>"ASC"), array("IBLOCK_ID"=>24,"PROPERTY_ticket_id"=>$ticketListIDS), false, false, array("PROPERTY_SPEND_TIME_HOURS", "PROPERTY_SPEND_TIME_MINUTES","DATE_CREATE","PROPERTY_TICKET_ID", "PROPERTY_IS_PAYED", "PROPERTY_CLIENT"));

    //статус оплаты по сообщениям

    //пишем массив с разбивкой по месяцам время для каждого тикета
    while($arTicketTime = $ticketTime->Fetch()) {
        $mesMonth = substr($arTicketTime["DATE_CREATE"],3,2); //месяц, в котором было добавлено время         

        $ticketMinutes = $arTicketTime["PROPERTY_SPEND_TIME_HOURS_VALUE"] * 60 + $arTicketTime["PROPERTY_SPEND_TIME_MINUTES_VALUE"];
        if (!$ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]) {
            $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MINUTES"] = 0;
        }
        //собираем инфо об оплате каждого сообщения
        $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MESS_PAYED"][$arTicketTime["ID"]] = $arTicketTime["PROPERTY_IS_PAYED_VALUE"];

        //по умолчаниею считаем, что все сообщения по данному тикету за месяц оплачены
        if ($ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MONTH_PAYED"] != "N") {
            $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MONTH_PAYED"] = "Y"; 
        }
        //если хоть одно сообщенин тикета за месяц не оплачено - добавляем соответствующий флаг в общий массив
        if (!$arTicketTime["PROPERTY_IS_PAYED_VALUE"]) {
            $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MONTH_PAYED"] = "N";  
        }                              

        //по умолчаниею считаем, что месяц целиком оплачен
        if ($ticketsByMonth[$mesMonth]["MONTH_TOTAL_PAYED"] != "N") {
            $ticketsByMonth[$mesMonth]["MONTH_TOTAL_PAYED"] = "Y"; 
        }
        //если хоть один тикет месяца не оплачен - добавляем соответствующий флаг в общий массив
        if ($ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MONTH_PAYED"] == "N") {
            $ticketsByMonth[$mesMonth]["MONTH_TOTAL_PAYED"] = "N";  
        }      

        //общее количество затраченного времени по тикету
        $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MINUTES"] +=  $ticketMinutes; 


        //суммируем общее время по проекту за месяц      
        $ticketsByMonth[$mesMonth]["PROJECTS"][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["MINUTES"] +=  $ticketMinutes;

        //заносим тикет в общий массив тикетов, по которому будем вычислять количество тикетов клиента за месяц
        $ticketsByMonth[$mesMonth]["PROJECTS"][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["TICKETS"][] = $arTicketTime["PROPERTY_TICKET_ID_VALUE"];

        //если тикет участвует в оплате - плюсуем его время к общему времени к оплате по проекту
        if ($ticketList[$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["UF_IN_PAYMENT"]) {
            $ticketsByMonth[$mesMonth]["PROJECTS"][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["MINUTES_TO_PAY"] +=  $ticketMinutes;  
        }

        //если тикет оплачен - плюсуем его время к общему времени к оплаченному времени по проекту
        if ($arTicketTime["PROPERTY_IS_PAYED_VALUE"]) {
            $ticketsByMonth[$mesMonth]["PROJECTS"][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["MINUTES_PAYED"] +=  $ticketMinutes; 
        }

    }
    //arshow($ticketsByMonth);
    $ticketsByMonth = array_reverse($ticketsByMonth);

    //arshow($ticketsByMonth);

    //если указан проект, выводим статистику по нему, если нет - то по всем проектам за месяц 
    if ($ticketTime->SelectedRowsCount() > 0 && $ticketCount > 0 && $_POST["project"] > 0) {

        $checkAdmin = $USER->IsAdmin();    
    ?>
    <table class="statTable">


        <?
            //перебираем полученный массив, попутно подтягивая инфо о тикетах
            foreach  ($ticketsByMonth as $mID => $month) { ?>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Затраченное время</th>
                <th>В оплате</th>
                <th>Оплачен</th>
            </tr>
            <tr>
                <th colspan="4" class="monthName" style="text-transform: uppercase;"><?=$months[$mID]?></th>
                <th class="monthName">
                    <?if ($checkAdmin && $_POST["project"] > 0) {?>
                        <input type="checkbox" onchange="payTickets(0,'<?=$mID?>',<?=$_POST["year"]?>,<?=$_POST["project"]?>,$(this).prop('checked'))" <?if ($month["MONTH_TOTAL_PAYED"] == "Y"){?> checked="checked"<?}?>>
                        <?} else {
                            if ($month["MONTH_TOTAL_PAYED"] == "Y") {echo "Да";} else {echo "Нет";}    
                    }?>
                </th>
            </tr>
            <?
                $totalTime = 0; //общее время по всем тикетам за месяц
                $totalTimeToPay = 0; //общее время к оплате
                $totalTimePayed = 0; //время оплачено

                //  krsort($month); //сортируем тикеты по ID
                //  reset($month);

                krsort($month["TICKETS"]); //сортируем тикеты по ID
                reset($month["TICKETS"]);

                $i = 0;
            ?>
            <?foreach ($month["TICKETS"] as $tID=>$ticketInfo){?>
                <tr <?if ($i%2 != 0){?> style="background: #efefef;"<?}?>>
                    <td><?=$tID?></td>
                    <td><a href="/?ID=<?=$tID?>&edit=1" target="_blank"><?=$ticketList[$tID]["TITLE"]?></a></td>  
                    <td align="center">
                        <?
                            $hours = floor($ticketInfo["MINUTES"]/60);
                            $minutes = $ticketInfo["MINUTES"]%60;
                            if (strlen($minutes) == 1) {$minutes = "0".$minutes;}
                            echo $hours.":".$minutes;
                        ?>
                    </td>

                    <td align="center">
                        <?switch ($ticketList[$tID]["UF_IN_PAYMENT"]){case 1: echo "Да"; break; default: echo "Нет"; break;}?>
                    </td>

                    <td align="center">    
                        <?if ($checkAdmin && $_POST["project"] > 0){?>                    
                            <input type="checkbox" class="month<?=$mID?>" onchange="payTickets(<?=$tID?>,'<?=$mID?>',<?=$_POST["year"]?>,<?=$_POST["project"]?>,$(this).prop('checked'))" <?if ($ticketInfo["MONTH_PAYED"] == "Y"){?> checked="checked"<?}?>>
                            <?} else {
                                if ($ticketInfo["MONTH_PAYED"] == "Y") {echo "Да";} else {echo "Нет";}
                        }?>
                    </td>
                </tr>
                <?
                    //суммируем общее время
                    $totalTime += $ticketInfo["MINUTES"];

                    //суммируем время тикетов к оплате   
                    if ($ticketList[$tID]["UF_IN_PAYMENT"]){
                        $totalTimeToPay += $ticketInfo["MINUTES"];   
                    }

                    //суммируем оплаченное время
                    if ($ticketInfo["MONTH_PAYED"] == "Y"){
                        $totalTimePayed += $ticketInfo["MINUTES"];
                    }


                    $i++;
                }
            ?>
            <tr>                
                <td colspan="2" align="right"><b>Итого тикетов:</b></td>
                <td colspan="3"><b><?echo count($month["TICKETS"])?></b></td>
            </tr>

            <tr>
                <?
                    $totalHours = floor($totalTime/60);
                    $totalMinutes = $totalTime%60;
                    if (strlen($totalMinutes) == 1) {$totalMinutes = "0".$totalMinutes;}
                ?>
                <td colspan="2" align="right"><b>Итого часов:</b></td>
                <td colspan="3"><b><?echo $totalHours.":".$totalMinutes;?></b></td>
            </tr>

            <tr >
                <?
                    $totalHoursToPay = floor($totalTimeToPay/60);
                    $totalMinutesToPay = $totalTimeToPay%60;
                    if (strlen($totalMinutesToPay) == 1) {$totalMinutesToPay = "0".$totalMinutesToPay;}
                ?>
                <td colspan="2" align="right"><b>Итого часов к оплате:</b></td>
                <td colspan="3"><b><?echo $totalHoursToPay.":".$totalMinutesToPay;?></b></td>
            </tr>

            <tr>
                <td colspan="2" align="right"><b>Стоимость часа:</b></td>
                <td colspan="3"><b><?echo $projectsInfo[$_POST["project"]]["UF_HOUR_PRICE"]?></b></td>
            </tr>

            <tr>
                <td colspan="2" align="right"><b>Сумма к оплате:</b></td>
                <td colspan="3">
                    <? 
                        $hours = $totalTimeToPay/60;
                        $summ = round($hours * $projectsInfo[$_POST["project"]]["UF_HOUR_PRICE"]);
                    ?>
                    <b><?=number_format($summ, 0, ',', ' ');?></b>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="right"><b>Оплачено:</b></td>
                <td colspan="3">
                    <? 
                        $hoursPayed = $totalTimePayed/60;
                        $summPayed = round($hoursPayed * $projectsInfo[$_POST["project"]]["UF_HOUR_PRICE"]);
                    ?>
                    <b><?=number_format($summPayed, 0, ',', ' ');?></b>
                </td>
            </tr>

            <tr <?if ($summ != $summPayed){?> style="background: #FFA8C1;"<?}?>>
                <td colspan="2" align="right"><b>Долг:</b></td>
                <td colspan="3">                     
                    <b><?=number_format($summ - $summPayed, 0, ',', ' ');?></b>
                </td>
            </tr>

            <tr>
                <td colspan="5"></td>
            </tr>
            <?}?>
    </table>

    <?} else if($ticketTime->SelectedRowsCount() > 0 && $ticketCount > 0) {

        $checkAdmin = $USER->IsAdmin();   

        Cmodule::IncludeModule("webgk.support");
        $suppostGroups = GKSupport::GetBitrixSupportGroup(); 
    ?>
    <table class="statTable">


        <?
            //перебираем полученный массив, попутно подтягивая инфо о тикетах
            foreach  ($ticketsByMonth as $mID => $month) { ?>
            <tr>
                <th colspan="9" class="monthName" style="text-transform: uppercase;"><?=$months[$mID]?></th>                 
            </tr>
            <tr>
                <th>Проект</th>
                <th>Тикетов</th>
                <th>Часов</th>
                <th>К оплате</th>
                <th>Оплачено часов</th>
                <th>Стоимость часа</th>
                <th>Сумма к оплате</th>
                <th>Оплачено</th>
                <th>Долг</th>
            </tr>

            <?
                $totalTime = 0; //общее время по всем тикетам за месяц
                $totalTimeToPay = 0;

                //  krsort($month); //сортируем тикеты по ID
                //  reset($month);

                krsort($month["TICKETS"]); //сортируем тикеты по ID
                reset($month["TICKETS"]);


            ?>
            <?
                $monthMinutes = 0; //общее время по проекту за месяц
                $monthMinutesToPay = 0; //общее время по проекту к оплате за месяц
                $monthMinutesPayed = 0; //общее оплаченное время по проекту за месяц
                $monthTicketsCount = 0; //общее количество тикетов за месяц
                $summTotal = 0; //сумма к оплате
                $summTotalPayed = 0; //оплаченная сумма


                $i = 0;
                foreach ($projectsInfo as $pID=>$projectName){?>
                <?
                    //если по проекту в данном месяце велись работы
                    if ($month["PROJECTS"][$pID]["TICKETS"] > 0) {
                    ?>
                    <tr <?if ($i%2 != 0){?> style="background: #efefef;"<?}?>>
                        <td>
                            <a href="javascript:void(0)" onclick="$('#project').val(<?=$pID?>); getStat()" title="показать статистику по проекту <?=$projectName["UF_SITE"]?>">
                                <?
                                  if($suppostGroups[$pID]){
                                     $projectName["UF_SITE"] = "[группа ".$suppostGroups[$pID]."] ".$projectName["UF_SITE"]; 
                                  }
                                ?>
                                <?=$projectName["UF_SITE"]?>
                            </a>
                        </td>

                        <td align="center">
                            <? 
                                $ticketsCount = count(array_unique($month["PROJECTS"][$pID]["TICKETS"]));
                                echo $ticketsCount;?>
                        </td>
                        <td align="center">
                            <?
                                $hours = floor($month["PROJECTS"][$pID]["MINUTES"]/60);
                                $minutes = $month["PROJECTS"][$pID]["MINUTES"]%60;
                                if (strlen($minutes) == 1) {$minutes = "0".$minutes;}
                                echo $hours.":".$minutes;
                            ?>
                        </td>
                        <td align="center">
                            <?
                                $hoursToPay = floor($month["PROJECTS"][$pID]["MINUTES_TO_PAY"]/60);
                                $minutesToPay = $month["PROJECTS"][$pID]["MINUTES_TO_PAY"]%60;
                                if (strlen($minutesToPay) == 1) {$minutesToPay = "0".$minutesToPay;}
                                echo $hoursToPay.":".$minutesToPay;
                            ?>
                        </td>


                        <td align="center" <?if ($month["PROJECTS"][$pID]["MINUTES_TO_PAY"] != $month["PROJECTS"][$pID]["MINUTES_PAYED"]){?> style="background: #FFA8C1;"<?}?>>
                            <?
                                $hoursPayed = floor($month["PROJECTS"][$pID]["MINUTES_PAYED"]/60);
                                $minutesPayed = $month["PROJECTS"][$pID]["MINUTES_PAYED"]%60;
                                if (strlen($minutesPayed) == 1) {$minutesPayed = "0".$minutesPayed;}
                                echo $hoursPayed.":".$minutesPayed;
                            ?>
                        </td>

                        <td align="center"><?=$projectsInfo[$pID]["UF_HOUR_PRICE"]?></td>
                        <td align="center">
                            <?
                                $hours = $month["PROJECTS"][$pID]["MINUTES_TO_PAY"]/60;
                                $summ = round($hours * $projectsInfo[$pID]["UF_HOUR_PRICE"]);
                                echo $summ;
                            ?>
                        </td>

                        <td align="center">
                            <?
                                $hoursPayed = $month["PROJECTS"][$pID]["MINUTES_PAYED"]/60;
                                $summPayed = round($hoursPayed * $projectsInfo[$pID]["UF_HOUR_PRICE"]);
                                echo $summPayed;
                            ?>
                        </td>

                        <td align="center"<?if ($summ != $summPayed){?> style="background: #FFA8C1;"<?}?>>
                            <?echo ($summ - $summPayed)?>
                        </td>
                    </tr>

                    <?
                        $monthMinutes += $month["PROJECTS"][$pID]["MINUTES"];
                        $monthMinutesToPay += $month["PROJECTS"][$pID]["MINUTES_TO_PAY"];
                        $monthMinutesPayed += $month["PROJECTS"][$pID]["MINUTES_PAYED"];
                        $monthTicketsCount += $ticketsCount;
                        $summTotal += $summ;
                        $summTotalPayed += $summPayed;

                        $i++;
                }?>
                <?}?>


            <tr style="background: #91D1DB;">
                <td align="right"><b>Итого</b></td>
                <td align="center"><b><?=$monthTicketsCount?></b></td>
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
                <td align="center"></td>
                <td align="center"><b><?=number_format($summTotal, 0, ',', ' ');?></b></td>

                <td align="center"><b><?=number_format($summTotalPayed, 0, ',', ' ');?></b></td>

                <td align="center">
                    <b><?=number_format($summTotal - $summTotalPayed, 0, ',', ' ')?></b>
                </td>                                                      

            </tr>  


            <tr>
                <td colspan="9"></td>
            </tr>
            <?}?>
    </table>
    <?} else {?>
    <p>За выбранный период обращений не найдено.</p>
    <?}?>