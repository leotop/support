<?  require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 

    Cmodule::IncludeModule("webgk.support");

    if ($_REQUEST["testParam"]=="needTest") {
        if ($_REQUEST["checkedNeed"]=="true") {
            $arFields = array("TICKET_ID"=>$_REQUEST["ticketID"], "TEST_PASSED"=>'N');
            $addTicketTest=GKSupportTicketTesting::Add($arFields);
        }   else if ($_REQUEST["checkedNeed"]=="false"){
            $deleteTicketTest=GKSupportTicketTesting::Delete($_REQUEST["ticketID"]);
        }  
    } else if ($_REQUEST["testParam"]=="testPassed") {
        
        if ($_REQUEST["checkedPassed"]=="true") {
            $testPassed='Y';
        }   else if ($_REQUEST["checkedPassed"]=="false"){
            $testPassed='N';
        }  
        $changeTicketTest=GKSupportTicketTesting::Change($_REQUEST["ticketID"], $testPassed);

    }

?>