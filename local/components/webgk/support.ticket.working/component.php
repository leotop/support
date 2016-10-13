<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


    //Include module
    Cmodule::IncludeModule("webgk.support");
    Cmodule::IncludeModule("support");

    /**
    * check ticket responsible and status
    * 
    * @param integer $ticket_id
    * @param string $status_id
    */
    function checkTicketResponsible($ticket_id, $status_id) {     
        $ticket_id = intval($ticket_id);

        if (empty($ticket_id) || empty($status_id)) {
            return false;
        }

        //check user group
        global $USER;
        $user_id = $USER->GetID();  

        if (!$user_id) {
            return false;
        }

        $staff_group_id = GKSupport::GetSupportEmployerGroupID();
        $user_groups = CUser::GetUserGroupArray();

        //check ticket responsible id and ticket status_id
        $arFilter = Array(
            "ID" => $ticket_id,         
            "RESPONSIBLE_ID" => $user_id,     
            "STATUS_SID" => $status_id,  
            "CLOSE" => "N"      
        );

        $ticket = CTicket::GetList($by="ID", $order="ASC", $arFilter, $filtered, "N");
        $arTicket = $ticket->Fetch();

        if(empty($arTicket)) {
            return false;
        } else {
            return true;
        }
    }

    /**
    * check current ticket work status
    * 
    * @param integer $ticket_id
    */
    function checkWorkStatus($ticket_id) {

        //check user group
        global $USER;
        $user_id = $USER->GetID();

        if (!$user_id) {
            return false;
        }

        //check current ticket work status
        $ticket_work_status = new GKSupportTicketTracking;
        $rsTicketStatus = $ticket_work_status->GetList($by, $sort, array("TICKET_ID" => $ticket_id, "USER_ID" => $user_id));
        $arTicketStatus = $rsTicketStatus->Fetch();
        $in_work = (!empty($arTicketStatus)) ? "Y" : "N";
        
        return $in_work;
    }


    $ticket_id = intval($arParams["TICKET_ID"]);
    $status_id = $arParams["WORK_STATUS_ID"];

    if (empty($ticket_id)) {
        return false;
    }


    //check user group
    global $USER;
    $user_id = $USER->GetID();    
    $staff_group_id = GKSupport::GetSupportEmployerGroupID();
    $user_groups = CUser::GetUserGroupArray();

    //if user not in support staff group
    if (!in_array($staff_group_id, $user_groups) || empty($user_id)) {
        return false; 
    }

    if (!checkTicketResponsible($ticket_id, $status_id)) {
        return false;

    }       

    //ajax ticket status update
    if ($_GET["ajax"] == "yes" && intval($_GET["update_ticket_work_status"]) > 0) {
        if (!checkTicketResponsible(intval($_GET["update_ticket_work_status"]), $status_id)) {
            return false;      
        }                      

        $in_work = checkWorkStatus($ticket_id);
        
        if ($in_work == "Y") {
           $ticket_work_status = new GKSupportTicketTracking; 
           $ticket_work_status->Delete($ticket_id, $user_id);
        } else {
           $ticket_work_status = new GKSupportTicketTracking; 
           $ticket_work_status->Add(array("TICKET_ID" => $ticket_id, "USER_ID" => $user_id)); 
        }

    }      


    $arResult["IN_WORK"] = checkWorkStatus($ticket_id);

    $arResult["TICKET_ID"] = $ticket_id;
    $arResult["USER_ID"] = $user_id;

    $this->IncludeComponentTemplate();
?>