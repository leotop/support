<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


    //Include module
    Cmodule::IncludeModule("webgk.support");
    Cmodule::IncludeModule("support");

    //check user group
    global $USER;
    $user_id = $USER->GetID();    
    $staff_group_id = GKSupport::GetSupportEmployerGroupID();

    //if user not in support staff group
    if (!$USER->IsAdmin() || empty($user_id)) {
        return false; 
    }    

    //current ticket with status "in work"
    $total_ticket_in_work = $arFilter = Array(
        "STATUS_SID" => $arParams["WORK_STATUS_ID"],
        "CLOSE" => "N"       
    );

    //tickets with status 'in work'
    $ticket = CTicket::GetList($by="ID", $order="ASC", $arFilter, $filtered, "N");
    $ticket_count = $ticket->SelectedRowsCount();
    while($arTicket = $ticket->Fetch()) {  
        $arResult["TICKETS"][$arTicket["ID"]] = $arTicket;
    }

    $arResult["TOTAL_TICKET_IN_WORK_COUNT"] = $ticket_count;



    $user_list = CUser::GetList($by = "LAST_NAME", $sort = "ASC", array("GROUPS_ID" => $staff_group_id, "ACTIVE" => "Y"));
    while($arUser = $user_list->Fetch()) {
        $arResult["USERS"][$arUser["ID"]] = $arUser;
    }

    $ticket_work_status = new GKSupportTicketTracking;      
    $ticket_list = $ticket_work_status->GetList($by = "ID", $sort = "ASC", array());
    while($arTicket = $ticket_list->Fetch()) {    
        if (!empty($arResult["TICKETS"][$arTicket["TICKET_ID"]])) {
            $arTicket["DETAIL_PAGE_URL"] = str_replace("#TICKET_ID#", $arTicket["TICKET_ID"], $arParams["TICKET_PAGE_URL"]);
            $arResult["USERS"][$arTicket["USER_ID"]]["TICKETS"][] = $arTicket;
        }
    }

    //current ticket in work
    foreach ($arResult["USERS"] as $uID => $user) {
        if (empty($user["TICKETS"])) {
            $arResult["USERS_WITHOUT_WORK"][$uID] = $user; 
            unset($arResult["USERS"][$uID]);
        } else {
            $arResult["TOTAL_COUNT"] += count($user["TICKETS"]);
        }
    }   



    $this->IncludeComponentTemplate();
?>