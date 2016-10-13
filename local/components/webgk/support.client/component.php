<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    //Include required modules
    Cmodule::IncludeModule("webgk.support");
    Cmodule::IncludeModule("support");

    global $USER;

    $oneHour = 1;
    $oneHourInMinutes = 60;

    function calculateTimePrice ($Year, $Month, $user, $time, $arResult, $key) {
        $oneHour = 1;
        $oneHourInMinutes = 60;
        $Month = intval($Month);
        //Calculate client time
        $arResult["STAT"][$Year][$Month][$user["PROJECT_NAME"]]["PRICE".$key]=$arResult["STAT"][$Year][$Month][$user["PROJECT_NAME"]]["PRICE".$key]+$time["PRICE"];

        //Calculate price by year
        $arResult["PRICE_YEAR"][$Year][$user["PROJECT_NAME"]]["PRICE".$key]=$arResult["PRICE_YEAR"][$Year][$user["PROJECT_NAME"]]["PRICE".$key]+$time["PRICE"];

        return $arResult;
    }

    //Get list of all group's support
    $arResult["GROUPS"] = GKSupport::GetBitrixSupportGroup();

    //get full groups info
    $arResult["GROUPS_INFO"] = GKSupport::GetBitrixSupportGroupInfo();

    $groupsInFilter = array();

    $users = GKSupportUsers::GetList($by="PROJECT_NAME",$sort="asc", array("ACTIVE"=>"Y"));
    while($arUser = $users->Fetch()) {

        //check for user groups
        $projectName = $arUser["PROJECT_NAME"];
        $groupName = $arResult["GROUPS"][$arUser["USER_ID"]];             

        $arResult["CLIENT"][$arUser["ID"]]=$arUser; 

        //if user has group
        if ($groupName) {
            if ($groupsInFilter[$groupName]) {                   
                unset($arResult["CLIENT"][$groupsInFilter[$groupName]]);                   
            } 

            $projectName = $groupName." (".GetMessage("GROUP").")"; 
            $arUser["PROJECT_NAME"] = $projectName;
            $arResult["CLIENT"][$arUser["ID"]] = $arUser;
            $groupsInFilter[$groupName] = $arUser["ID"];  
        }    
    } 

    $groupsInFilter = array();
    
    //Get list of all transactions
    $filt=array("ACTIVE"=>"Y");
    $transaction = GKSupportTransactions::GetList($by="id",$sort="desc",$filt);
    while($arTransaction = $transaction->Fetch()) {
        $arTransactions[$arTransaction["SPENT_TIME_ID"]]=$arTransaction["SUMM"];
    }

    //Creating a list of all client's
    $client = GKSupportUsers::GetList($by="PROJECT_NAME",$sort="asc", $arFilterClient);
    while($user = $client->Fetch()) { 

        $arFilter["CLIENT_ID"]=$user["ID"];
        $obTime = GKSupportSpentTime::GetList(($by="id"), ($order="desc"), $arFilter); 
        $payed="N";
        while($time = $obTime->Fetch()) {
            $Month = substr($time["DATE"],5,2); 
            $Month = intval($Month);
            $Year = substr($time["DATE"],0,4);

            //check for user groups
            $projectName = $user["PROJECT_NAME"];
            $groupName = $arResult["GROUPS"][$user["USER_ID"]];
            //if user has group
            if ($groupName) {
                $projectName = $groupName." (".GetMessage("GROUP").")"; 
                $user["PROJECT_NAME"] = $projectName;  
            } 

            //Calculate ticket price
            $inPayment = GKSupportTicketPayment::GetByTicket($time["TICKET_ID"]);
            if ($inPayment=="Y"){
                
                $time["PRICE"]=$arTransactions[$time["ID"]];
                //Check payed time or not 
                $arResult=calculateTimePrice ($Year, $Month, $user, $time, $arResult, "_TO_PAY");
            } 
        }  
    }
    
    //arshow($arResult["CLIENT"]);
    
    unset($arResult["GROUPS"]);
    unset($arResult["GROUPS_INFO"]);
    unset($arResult["USER_GROUPS"]);
    krsort($arResult["STAT"]); 


    $this->IncludeComponentTemplate();
?>