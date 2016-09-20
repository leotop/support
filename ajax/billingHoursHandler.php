<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<? 
    switch($_POST['action']){
        case 'add':
            addNewBillingTimeRecord();
            break;
        case 'delete':
            deleteBillingTimeRecord();
            break;
    }

    function addNewBillingTimeRecord(){
        global $DB;
        $re = CTicket::GetByID($_POST['ticket_id']);
        if($arF = $re->GetNext()){
            $ticketTitle = $arF['TITLE'];
        }

        $el = new CIBlockElement;

        $PROP = array();
        $PROP[83] = date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), mktime()); 
        $PROP[84] = $_POST['user_id'];  
        $PROP[85] = $_POST['hours'];
        $PROP[86] = iconv("UTF-8", "WINDOWS-1251",$_POST['comment']);
        $PROP[87] = $_POST['ticket_id'];  
        $PROP[88] = $_POST['minutes'];  
        $PROP[91] = $_POST["client"];  

        if ($_POST["in_payment"] == "Y") {
            $PROP[89] = 34; //участвует в оплате = "Да"
        }

        $arLoadProductArray = Array(
            "MODIFIED_BY"    => $_POST['user_id'],
            "IBLOCK_ID"      => 24,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $ticketTitle,
            "ACTIVE"         => "Y"
        );



        if($PRODUCT_ID = $el->Add($arLoadProductArray)){


            //add spentTime in webgk.support
            CModule::IncludeModule("webgk.support");
            $timeFields = array(
                "USER_ID" => $_POST['user_id'],
                "CLIENT_ID" => GKSupportUsers::GetClientId($_POST["client"]), 
                "IS_PAYED" => "N", 
                "COMMENT" => iconv("UTF-8", "WINDOWS-1251",$_POST['comment']), 
                "TICKET_ID" => $_POST['ticket_id'], 
                "SERVICE_ID" => $_POST["service_id"],
                "HOURS" => $_POST['hours'],
                "MINUTES" => $_POST['minutes']
            );
            GKSupportSpentTime::Add($timeFields);  
            
              

            $rsUser = CUser::GetByID($_POST['user_id']);
            $arUser = $rsUser->Fetch();
            echo "<tr>
            <td>".date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), mktime())."</td>
            <td>".$arUser['NAME']." ".$arUser['LAST_NAME']."</td>
            <td class='tableHours'>
            <p>".$_POST['hours'].":".$_POST['minutes']."</p>
            </td>
            <td></td>
            <td>
            <p>".iconv("UTF-8", "WINDOWS-1251",$_POST['comment'])."</p>
            </td>             
            <td>
            <input type='hidden' name='recordID' value='".$PRODUCT_ID."'>
            <input class='deleteBillingPosition' data-action='delete' value='Удалить' type='submit' />
            </td>
            </tr>";
        } else {
            //echo "Error: ".$el->LAST_ERROR;
        }
    }

    function deleteBillingTimeRecord(){
        // global $DB;
        //$DB->StartTransaction();
        CIBlockElement::Delete($_POST['record_id']);
        //$DB->Commit();
    }
?>
