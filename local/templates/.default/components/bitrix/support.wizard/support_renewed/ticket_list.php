<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

    $groups = $USER->GetUserGroupArray();
    if (in_array(8, $groups))  {
        
        Cmodule::IncludeModule("webgk.support"); 
        $suppostGroups = GKSupport::GetBitrixSupportGroup();
        
        $arFilter = array();       
        $items = array(""=>"-");

        $params = array("SELECT"=>array("UF_*","ID"));
        $filter = array("GROUPS_ID"=>array(7),"ACTIVE"=>"Y");    
        $users = CUser::GetList(($by="id"), ($order="asc"), $filter, $params);
        while ($arUser = $users->Fetch()) {              
            $site = $arUser["UF_SITE"];
            if($suppostGroups[$arUser["ID"]]) {
                $site = "[".GetMessage("GROUP")." ".$suppostGroups[$arUser["ID"]]."] ".$site;
            }
            
            $items[$arUser["ID"]] = $site;
        }

        asort($items);
        $arFilter[] = array(
            "id"=> "OWNER",  
            "name" => "Проект",
            "type" => "list",
            "items" => $items, 
        );   

        $users = array(""=>"-");
        $user = CUser::GetList(($by="name"), ($order="asc"), array("GROUPS_ID"=>array(8), "ACTIVE"=>"Y"));   
        while ($arUser = $user->Fetch()){
            $users[$arUser["ID"]] = $arUser["NAME"]." ".$arUser["LAST_NAME"];
        }
        $arFilter[] = array(
            "id"=> "RESPONSIBLE",  
            "name" => "Ответственный",
            "type" => "list",
            "items" => $users, 
        );     
       

    }

    $fStatuses = array();
    $statuses = CTicketDictionary::GetList($by="sort",$order="asc",array("TYPE"=>"S"));  
    while($arStatus = $statuses->Fetch()) { 
        $fStatuses[$arStatus["SID"]] = $arStatus["NAME"];  
    }
    $arFilter[] = array(
        "id"=> "STATUS_SID",  
        "name" => "Статус",
        "type" => "list",
        "params"=>array("size"=>5, "multiple"=>"multiple"),
        "valign"=> "top",
        "items" => $fStatuses         
    );    
?>                                
<?$APPLICATION->IncludeComponent(
        "bitrix:support.ticket.list", 
        "", 
        Array(
            "TICKET_EDIT_TEMPLATE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["ticket_edit"],
            "TICKETS_PER_PAGE" => $arParams["TICKETS_PER_PAGE"],
            "SET_PAGE_TITLE" => $arParams["SET_PAGE_TITLE"],
            "TICKET_ID_VARIABLE" => $arResult["ALIASES"]["ID"],
            "SITE_ID" => $arParams["SITE_ID"],
            "SET_SHOW_USER_FIELD" => $arParams["SET_SHOW_USER_FIELD"],
            "AJAX_ID" => $arParams["AJAX_ID"],
            "FILTER" => $arFilter,
        ),
        $component,
        array('HIDE_ICONS' => 'Y')
    );
?>      