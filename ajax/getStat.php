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
    //�������� ������ � ������
    $ticketList = array(); //������ ������� � ������ ���������
    $ticketListIDS = array(); // ������ ID ������� �� ��������� ������
    while($arTicket = $ticket->Fetch()) {
        //  arshow($arTicket);
        $ticketList[$arTicket["ID"]] = $arTicket;
        $ticketListIDS[] = $arTicket["ID"];
    }
    //   arshow($ticketList);

    //���� �� ��������/��������. �������� ������ �������� ������������� �� ������ "������������" (��������)
    $projectsInfo = array(); 
    $projects = CUSer::GetList($by="UF_SITE", $sort="asc",array("ACTIVE"=>"Y", "GROUPS_ID"=>7),array("SELECT"=>array("UF_*")));
    while ($arProject = $projects->Fetch()) {
        $projectsInfo[$arProject["ID"]] = $arProject;  
    }  

    $months = array(
        "01" => "������",
        "02" => "�������",
        "03" => "����",
        "04" => "������",
        "05" => "���",
        "06" => "����",
        "07" => "����",
        "08" => "������",
        "09" => "��������",
        "10" => "�������",
        "11" => "������",
        "12" => "�������"
    );

    //������ � ��������� ������� �� ������� � ����������� �������
    $ticketsByMonth = array();

    //�������� ������ �� ������� �� ��������� � ����������� ��������
    $ticketTime = CIBlockElement::GetList(array("DATE_CREATE"=>"ASC"), array("IBLOCK_ID"=>24,"PROPERTY_ticket_id"=>$ticketListIDS), false, false, array("PROPERTY_SPEND_TIME_HOURS", "PROPERTY_SPEND_TIME_MINUTES","DATE_CREATE","PROPERTY_TICKET_ID", "PROPERTY_IS_PAYED", "PROPERTY_CLIENT"));

    //������ ������ �� ����������

    //����� ������ � ��������� �� ������� ����� ��� ������� ������
    while($arTicketTime = $ticketTime->Fetch()) {
        $mesMonth = substr($arTicketTime["DATE_CREATE"],3,2); //�����, � ������� ���� ��������� �����         

        $ticketMinutes = $arTicketTime["PROPERTY_SPEND_TIME_HOURS_VALUE"] * 60 + $arTicketTime["PROPERTY_SPEND_TIME_MINUTES_VALUE"];
        if (!$ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]) {
            $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MINUTES"] = 0;
        }
        //�������� ���� �� ������ ������� ���������
        $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MESS_PAYED"][$arTicketTime["ID"]] = $arTicketTime["PROPERTY_IS_PAYED_VALUE"];

        //�� ���������� �������, ��� ��� ��������� �� ������� ������ �� ����� ��������
        if ($ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MONTH_PAYED"] != "N") {
            $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MONTH_PAYED"] = "Y"; 
        }
        //���� ���� ���� ��������� ������ �� ����� �� �������� - ��������� ��������������� ���� � ����� ������
        if (!$arTicketTime["PROPERTY_IS_PAYED_VALUE"]) {
            $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MONTH_PAYED"] = "N";  
        }                              

        //�� ���������� �������, ��� ����� ������� �������
        if ($ticketsByMonth[$mesMonth]["MONTH_TOTAL_PAYED"] != "N") {
            $ticketsByMonth[$mesMonth]["MONTH_TOTAL_PAYED"] = "Y"; 
        }
        //���� ���� ���� ����� ������ �� ������� - ��������� ��������������� ���� � ����� ������
        if ($ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MONTH_PAYED"] == "N") {
            $ticketsByMonth[$mesMonth]["MONTH_TOTAL_PAYED"] = "N";  
        }      

        //����� ���������� ������������ ������� �� ������
        $ticketsByMonth[$mesMonth]["TICKETS"][$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["MINUTES"] +=  $ticketMinutes; 


        //��������� ����� ����� �� ������� �� �����      
        $ticketsByMonth[$mesMonth]["PROJECTS"][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["MINUTES"] +=  $ticketMinutes;

        //������� ����� � ����� ������ �������, �� �������� ����� ��������� ���������� ������� ������� �� �����
        $ticketsByMonth[$mesMonth]["PROJECTS"][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["TICKETS"][] = $arTicketTime["PROPERTY_TICKET_ID_VALUE"];

        //���� ����� ��������� � ������ - ������� ��� ����� � ������ ������� � ������ �� �������
        if ($ticketList[$arTicketTime["PROPERTY_TICKET_ID_VALUE"]]["UF_IN_PAYMENT"]) {
            $ticketsByMonth[$mesMonth]["PROJECTS"][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["MINUTES_TO_PAY"] +=  $ticketMinutes;  
        }

        //���� ����� ������� - ������� ��� ����� � ������ ������� � ����������� ������� �� �������
        if ($arTicketTime["PROPERTY_IS_PAYED_VALUE"]) {
            $ticketsByMonth[$mesMonth]["PROJECTS"][$arTicketTime["PROPERTY_CLIENT_VALUE"]]["MINUTES_PAYED"] +=  $ticketMinutes; 
        }

    }
    //arshow($ticketsByMonth);
    $ticketsByMonth = array_reverse($ticketsByMonth);

    //arshow($ticketsByMonth);

    //���� ������ ������, ������� ���������� �� ����, ���� ��� - �� �� ���� �������� �� ����� 
    if ($ticketTime->SelectedRowsCount() > 0 && $ticketCount > 0 && $_POST["project"] > 0) {

        $checkAdmin = $USER->IsAdmin();    
    ?>
    <table class="statTable">


        <?
            //���������� ���������� ������, ������� ���������� ���� � �������
            foreach  ($ticketsByMonth as $mID => $month) { ?>
            <tr>
                <th>ID</th>
                <th>���������</th>
                <th>����������� �����</th>
                <th>� ������</th>
                <th>�������</th>
            </tr>
            <tr>
                <th colspan="4" class="monthName" style="text-transform: uppercase;"><?=$months[$mID]?></th>
                <th class="monthName">
                    <?if ($checkAdmin && $_POST["project"] > 0) {?>
                        <input type="checkbox" onchange="payTickets(0,'<?=$mID?>',<?=$_POST["year"]?>,<?=$_POST["project"]?>,$(this).prop('checked'))" <?if ($month["MONTH_TOTAL_PAYED"] == "Y"){?> checked="checked"<?}?>>
                        <?} else {
                            if ($month["MONTH_TOTAL_PAYED"] == "Y") {echo "��";} else {echo "���";}    
                    }?>
                </th>
            </tr>
            <?
                $totalTime = 0; //����� ����� �� ���� ������� �� �����
                $totalTimeToPay = 0; //����� ����� � ������
                $totalTimePayed = 0; //����� ��������

                //  krsort($month); //��������� ������ �� ID
                //  reset($month);

                krsort($month["TICKETS"]); //��������� ������ �� ID
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
                        <?switch ($ticketList[$tID]["UF_IN_PAYMENT"]){case 1: echo "��"; break; default: echo "���"; break;}?>
                    </td>

                    <td align="center">    
                        <?if ($checkAdmin && $_POST["project"] > 0){?>                    
                            <input type="checkbox" class="month<?=$mID?>" onchange="payTickets(<?=$tID?>,'<?=$mID?>',<?=$_POST["year"]?>,<?=$_POST["project"]?>,$(this).prop('checked'))" <?if ($ticketInfo["MONTH_PAYED"] == "Y"){?> checked="checked"<?}?>>
                            <?} else {
                                if ($ticketInfo["MONTH_PAYED"] == "Y") {echo "��";} else {echo "���";}
                        }?>
                    </td>
                </tr>
                <?
                    //��������� ����� �����
                    $totalTime += $ticketInfo["MINUTES"];

                    //��������� ����� ������� � ������   
                    if ($ticketList[$tID]["UF_IN_PAYMENT"]){
                        $totalTimeToPay += $ticketInfo["MINUTES"];   
                    }

                    //��������� ���������� �����
                    if ($ticketInfo["MONTH_PAYED"] == "Y"){
                        $totalTimePayed += $ticketInfo["MINUTES"];
                    }


                    $i++;
                }
            ?>
            <tr>                
                <td colspan="2" align="right"><b>����� �������:</b></td>
                <td colspan="3"><b><?echo count($month["TICKETS"])?></b></td>
            </tr>

            <tr>
                <?
                    $totalHours = floor($totalTime/60);
                    $totalMinutes = $totalTime%60;
                    if (strlen($totalMinutes) == 1) {$totalMinutes = "0".$totalMinutes;}
                ?>
                <td colspan="2" align="right"><b>����� �����:</b></td>
                <td colspan="3"><b><?echo $totalHours.":".$totalMinutes;?></b></td>
            </tr>

            <tr >
                <?
                    $totalHoursToPay = floor($totalTimeToPay/60);
                    $totalMinutesToPay = $totalTimeToPay%60;
                    if (strlen($totalMinutesToPay) == 1) {$totalMinutesToPay = "0".$totalMinutesToPay;}
                ?>
                <td colspan="2" align="right"><b>����� ����� � ������:</b></td>
                <td colspan="3"><b><?echo $totalHoursToPay.":".$totalMinutesToPay;?></b></td>
            </tr>

            <tr>
                <td colspan="2" align="right"><b>��������� ����:</b></td>
                <td colspan="3"><b><?echo $projectsInfo[$_POST["project"]]["UF_HOUR_PRICE"]?></b></td>
            </tr>

            <tr>
                <td colspan="2" align="right"><b>����� � ������:</b></td>
                <td colspan="3">
                    <? 
                        $hours = $totalTimeToPay/60;
                        $summ = round($hours * $projectsInfo[$_POST["project"]]["UF_HOUR_PRICE"]);
                    ?>
                    <b><?=number_format($summ, 0, ',', ' ');?></b>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="right"><b>��������:</b></td>
                <td colspan="3">
                    <? 
                        $hoursPayed = $totalTimePayed/60;
                        $summPayed = round($hoursPayed * $projectsInfo[$_POST["project"]]["UF_HOUR_PRICE"]);
                    ?>
                    <b><?=number_format($summPayed, 0, ',', ' ');?></b>
                </td>
            </tr>

            <tr <?if ($summ != $summPayed){?> style="background: #FFA8C1;"<?}?>>
                <td colspan="2" align="right"><b>����:</b></td>
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
            //���������� ���������� ������, ������� ���������� ���� � �������
            foreach  ($ticketsByMonth as $mID => $month) { ?>
            <tr>
                <th colspan="9" class="monthName" style="text-transform: uppercase;"><?=$months[$mID]?></th>                 
            </tr>
            <tr>
                <th>������</th>
                <th>�������</th>
                <th>�����</th>
                <th>� ������</th>
                <th>�������� �����</th>
                <th>��������� ����</th>
                <th>����� � ������</th>
                <th>��������</th>
                <th>����</th>
            </tr>

            <?
                $totalTime = 0; //����� ����� �� ���� ������� �� �����
                $totalTimeToPay = 0;

                //  krsort($month); //��������� ������ �� ID
                //  reset($month);

                krsort($month["TICKETS"]); //��������� ������ �� ID
                reset($month["TICKETS"]);


            ?>
            <?
                $monthMinutes = 0; //����� ����� �� ������� �� �����
                $monthMinutesToPay = 0; //����� ����� �� ������� � ������ �� �����
                $monthMinutesPayed = 0; //����� ���������� ����� �� ������� �� �����
                $monthTicketsCount = 0; //����� ���������� ������� �� �����
                $summTotal = 0; //����� � ������
                $summTotalPayed = 0; //���������� �����


                $i = 0;
                foreach ($projectsInfo as $pID=>$projectName){?>
                <?
                    //���� �� ������� � ������ ������ ������ ������
                    if ($month["PROJECTS"][$pID]["TICKETS"] > 0) {
                    ?>
                    <tr <?if ($i%2 != 0){?> style="background: #efefef;"<?}?>>
                        <td>
                            <a href="javascript:void(0)" onclick="$('#project').val(<?=$pID?>); getStat()" title="�������� ���������� �� ������� <?=$projectName["UF_SITE"]?>">
                                <?
                                  if($suppostGroups[$pID]){
                                     $projectName["UF_SITE"] = "[������ ".$suppostGroups[$pID]."] ".$projectName["UF_SITE"]; 
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
                <td align="right"><b>�����</b></td>
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
    <p>�� ��������� ������ ��������� �� �������.</p>
    <?}?>