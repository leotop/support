<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    CModule::IncludeModule("webgk.support");   

    $supportGroupId = GKSupport::GetSupportEmployerGroupID();

    $groups = $USER->GetUserGroupArray();
    if (in_array($supportGroupId, $groups))  {

        Cmodule::IncludeModule("webgk.support"); 
        $suppostGroups = GKSupport::GetBitrixSupportGroup();

        //список клиентов
        $arFilter = array();       
        $items = array(""=>" - ");

        $clients = GKSupportUsers::GetList($by="ID",$sort="ASC",array("ACTIVE"=>"Y"));
        while($arClient = $clients->Fetch()) {
            $project = $arClient["PROJECT_NAME"];
            //добавляем пользователей без группы
            if(!$suppostGroups[$arClient["USER_ID"]]) {                        
                $items[$arClient["USER_ID"]] = $project;
            }     
        }

        //добавляем группы пользователей
        $support_groups = GKSupport::GetBitrixSupportGroupInfo();
        if (is_array($support_groups["GROUPS"]) && count($support_groups["GROUPS"]) > 0) {
            foreach ($support_groups["GROUPS"] as $g_id => $group) {
                if ($group["IS_TEAM_GROUP"] != "Y") {
                    //у группы добавляем префикс "g", чтобы отличать их при фильтрации
                    $items["g".$g_id] = " [".GetMessage("GROUP")."] ".$group["NAME"];
                }
            }     
        }


        asort($items);
        $arFilter[] = array(
            "id"=> "OWNER",  
            "name" => GetMessage("PROJECT"),           
            "type" => "list",
            "items" => $items, 
        );      


        //список ответственных
        $users = array(""=>"-");
        $user = CUser::GetList(($by="name"), ($order="asc"), array("GROUPS_ID"=>array($supportGroupId), "ACTIVE"=>"Y"));   
        while ($arUser = $user->Fetch()){
            $users[$arUser["ID"]] = $arUser["NAME"]." ".$arUser["LAST_NAME"];
        }
        $arFilter[] = array(
            "id"=> "RESPONSIBLE",                      
            "name" => GetMessage("RESPONSIBLE"),
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
        "name" => GetMessage("STATUS"),
        "type" => "list",
        "params"=>array("size"=>5, "multiple"=>"multiple"),
        "valign"=> "top",
        "items" => $fStatuses         
    );    
?>    
<?$APPLICATION->IncludeComponent("bitrix:menu", "deskmanMenu", Array(
        "ROOT_MENU_TYPE" => "deskman",    
        "MENU_CACHE_TYPE" => "N",    
        "MENU_CACHE_TIME" => "3600",    
        "MENU_CACHE_USE_GROUPS" => "Y",    
        "MENU_CACHE_GET_VARS" => "",    
        "MAX_LEVEL" => "1",    
        "CHILD_MENU_TYPE" => "",    
        "USE_EXT" => "Y",    
        ),
        false
    ); 
?>                            
<?$APPLICATION->IncludeComponent(
        "webgk:support.ticket.list", 
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