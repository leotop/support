<?  require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 

    Cmodule::IncludeModule("webgk.support");
    
    if ($_REQUEST["checked"]=="true") {
        $arFields = array("TICKET_ID"=>$_REQUEST["ticketID"], "TEST_PASSED"=>'N');
        $addTicketTest=GKSupportTicketTesting::Add($arFields);
    }   else if ($_REQUEST["checked"]=="false"){
        $deleteTicketTest=GKSupportTicketTesting::Delete($_REQUEST["ticketID"]);
    }  
    

?>