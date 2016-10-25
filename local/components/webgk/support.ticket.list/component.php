<?

    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    require_once($_SERVER["DOCUMENT_ROOT"].$componentPath."/functions.php");

    CModule::IncludeModule("webgk.support");

    if (!CModule::IncludeModule("support"))
    {
        ShowError(GetMessage("MODULE_NOT_INSTALL"));
        return;
    }

    $userSites = array(); //project names by users
    $clients = GKSupportUsers::GetList($by="ID",$sort="ASC",array("ACTIVE"=>"Y"));
    while($arClient = $clients->Fetch()) {
        $userSites[$arClient["USER_ID"]] = $arClient["PROJECT_NAME"]; 
    }                    


    //Permissions
    if ( !($USER->IsAuthorized() && (CTicket::IsSupportClient() || CTicket::IsAdmin() || CTicket::IsSupportTeam() || CTicket::IsDemo())) )
        $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));         


    $bADS = $bDemo == 'Y' || $bAdmin == 'Y' || $bSupportTeam == 'Y';

    //TICKET_EDIT_TEMPLATE
    $arParams["TICKET_EDIT_TEMPLATE"] = (strlen($arParams["TICKET_EDIT_TEMPLATE"]) > 0 ? $arParams["TICKET_EDIT_TEMPLATE"] : "ticket_edit.php?ID=#ID#");

    //Get Tickets
    CPageOption::SetOptionString("main", "nav_page_in_session", "N");

    $UFA = array();
    $UFAT = array();
    global $USER_FIELD_MANAGER;
    $arrUF = $USER_FIELD_MANAGER->GetUserFields( "SUPPORT", 0, LANGUAGE_ID );
    if (isset($arParams["SET_SHOW_USER_FIELD"]) && is_array($arParams["SET_SHOW_USER_FIELD"]))
    {
        foreach( $arParams["SET_SHOW_USER_FIELD"] as $k => $v )
        {
            if( strlen( trim( $v ) ) > 0 )
            {
                $UFAT[$v] = array(
                    "NAME_C" => $arrUF[$v]["LIST_COLUMN_LABEL"],
                    "NAME_F" => $arrUF[$v]["EDIT_FORM_LABEL"],
                    "ALL" => $arrUF[$v],
                );
                $UFA[] = $v;
            }
        }
    }
    $arParams["SET_SHOW_USER_FIELD_T"] = $UFAT;

    //Result array
    $arResult = Array(
        "TICKETS" => Array(),
    );



    //Check is user is in staff group
    $uID = $USER->GetId();
    $supportStaffGroupID = GKSupport::GetSupportEmployerGroupID();
    $supportStaff = in_array($supportStaffGroupID,CUser::GetUserGroup($uID)); 
    if ($supportStaff===true) {
        $arResult["IS_STAFF"]='Y';
    }
    
    $staff_user_list = CUser::GetList($by = "ID", $sort = "ASC", array("GROUPS_ID" => $supportStaffGroupID));
    while($arUser = $staff_user_list->Fetch()) {
        $arResult["STAFF_LIST"][$arUser["ID"]] = $arUser;
    }

    //AJAX UPDATE
    if ($_REQUEST["AJAX"] == "YES" && $_REQUEST["ACTION"] && intval($_REQUEST["TICKET_ID"]) > 0) {
        switch ($_REQUEST["ACTION"]) {
            case "ADD": 
                $ticket_plan = new GKSupportTicketPlan;
                $ticket_plan->Add(array("TICKET_ID" => intval($_REQUEST["TICKET_ID"])));
                break;

            case "DELETE":
                $text = iconv("UTF-8", "CP1251", $_REQUEST["COMMENT"]);
                $ticket_plan = new GKSupportTicketPlan;
                $ticket_plan->DeleteByTicket(intval($_REQUEST["TICKET_ID"]), $text);
                break;

            case "UPDATE": 
                $text = iconv("UTF-8", "CP1251", $_REQUEST["COMMENT"]);
                $ticket_plan = new GKSupportTicketPlan;
                $ticket_plan->Update(intval($_REQUEST["TICKET_ID"]), array("COMMENT" => $text));
                break;
        }
    }

    //Get Dictionary Array
    $arTicketDictionary = CTicketDictionary::GetDropDownArray();

    //Dictionary table
    $arDictType = Array(
        "C" => "CATEGORY",
        "K" => "CRITICALITY",
        "S" => "STATUS",
        "M" => "MARK",
        "SR" => "SOURCE",
    );

    //Set Title
    $arParams["SET_PAGE_TITLE"] = ($arParams["SET_PAGE_TITLE"] == "N" ? "N" : "Y" );

    if ($arParams["SET_PAGE_TITLE"] == "Y")
        $APPLICATION->SetTitle(GetMessage("SUP_DEFAULT_TITLE"));


    // ------------------------------
    // rewrite old filter values
    foreach ($_REQUEST as $k => $v)
    {
        if ($k === 'find_title')
        {
            $_REQUEST['find_message'] = trim(trim($_REQUEST['find_message']) . ' ' . trim($_REQUEST['find_title']));
            unset($_REQUEST['find_title']);
        }
    }

    foreach ($_REQUEST as $k => $v)
    {
        if (substr($k, 0 , 5) === 'find_')
        {
            $fName = strtoupper(substr($k, 5));
            $_REQUEST[$fName] = $v;
        }
    }


    $arResult["FILTER"] = array(
        array("id"=>"ID", "name"=>GetMessage('SUP_F_ID')),
        array("id"=>"LAMP", "name"=>GetMessage('SUP_F_LAMP'), "type"=>"list", "params"=>array("size"=>5, "multiple"=>"multiple"), "valign"=>"top", "items"=>array(
            'red' => GetMessage('SUP_RED'), 'yellow' => GetMessage('SUP_YELLOW'),  'green' => GetMessage('SUP_GREEN'),  'grey' => GetMessage('SUP_GREY'),
        )),
        array("id"=>"CLOSE", "name"=>GetMessage('SUP_F_CLOSE'), "type" => "list", "items" => array(
            "" => GetMessage('SUP_ALL'), 'Y' => GetMessage('SUP_CLOSED'),'N' => GetMessage('SUP_OPENED')
        )),
        array("id"=>"MESSAGE", "name"=>GetMessage('SUP_F_MESSAGE_TITLE'), 'type'=>'text', "params"=>array("size"=>50))
    );

    foreach ($arParams["FILTER"] as $filterField) {
        $filter = array("id"=>$filterField["id"],"name"=>$filterField["name"], "type" => $filterField["type"], "params"=>$filterField["params"]);
        if ($filterField["items"]) {
            $filter["items"] = $filterField["items"]; 
        }
        $arResult["FILTER"][] = $filter;

    }


    $arParams["TICKETS_PER_PAGE"] = (intval($arParams["TICKETS_PER_PAGE"]) <= 0 ? 50 : intval($arParams["TICKETS_PER_PAGE"]));

    $grid_options = new CGridOptions($arResult["GRID_ID"]);
    $aSort = $grid_options->GetSorting(array("sort"=>array("id"=>"desc"), "vars"=>array("by"=>"by", "order"=>"order")));
    $aNav = $grid_options->GetNavParams(array("nPageSize"=>$arParams["TICKETS_PER_PAGE"]));
    $aSortArg = each($aSort["sort"]);

    $aFilter = $grid_options->GetFilter($arResult["FILTER"]); 



    if ($_GET["filter"] != "" && $_GET["clear_filter"] != "Y") {
        //  foreach ($)
    }  

    $aSortVal = $aSort['sort'];
    $sort_order = current($aSortVal);
    $sort_by = key($aSortVal);


    if (strlen($arParams["SITE_ID"]) > 0)
        $aFilter["LID"] = $arParams["SITE_ID"];


    if ($aFilter["OWNER"] > 0) {
        $aFilter["OWNER_EXACT_MATCH"] = "Y"; 
    } 

    //���������� ��� ����������� �������� � ������������ ������� � ������. ��� ���� ������� ����� ���������� (LAMP)
    foreach ($aFilter as $key=> $filterE) {
        if (is_array($filterE) && $key != "LAMP") {
            $statusSID = "";
            foreach ($filterE as $k=>$sid) {
                if ($k > 0) {
                    $statusSID .= "|";
                } 
                $statusSID .= $sid;
            }
            $aFilter[$key] = $statusSID;
        }
    } 

    //arshow($aFilter, true);  

    $aFilter["RESPONSIBLE_EXACT_MATCH"] = "Y";

    /*   //��� ��� ����������� ���� �������
    if (is_array($aFilter["STATUS_SID"])) {
    $statusSID = "";
    foreach ($aFilter["STATUS_SID"] as $k=>$sid) {
    if ($k > 0) {
    $statusSID .= "|";
    } 
    $statusSID .= $sid;
    }
    $aFilter["STATUS_SID"] = $statusSID;
    }   */



    //  $aFilter = array();
    $rsTickets = CTicket::GetList(
        $sort_by,
        $sort_order,
        $aFilter,
        $is_filtered,
        $check_rights = "Y",
        $get_user_name = "N",
        $get_dictionary_name = "Y",
        false,
        array( "SELECT" => $UFA, 'NAV_PARAMS' => array('nPageSize' => $arParams["TICKETS_PER_PAGE"], 'bShowAll' => false) )
    );

    $arTickets = array();
    $arRespUserIDs = array();
    $arGuestIDs = array();
    $arUsersPref = array("RESPONSIBLE", "OWNER", "MODIFIED", "CREATED");
    $arGuestsPref = array("OWNER", "CREATED");

    while ($arTicket = $rsTickets->GetNext())
    {
        //arshow($arTicket,true);
        $arTickets[] = $arTicket;

        foreach($arUsersPref as $cup)
        {
            $arRespUserIDs[] = $arTicket[$cup . "_USER_ID"];
        }

        foreach($arGuestsPref as $cgp)
        {
            $arGuestIDs[] = $arTicket[$cgp . "_GUEST_ID"];
        }
    }

    $arStrUsersM = CTicket::GetUsersPropertiesArray($arRespUserIDs,$arGuestIDs);

    // join userdata with tickets
    foreach ($arTickets as $arTicket)
    {
        $arUsersP = array();

        foreach($arUsersPref as $cup)
        {
            $cuid = intval($arTicket[$cup . "_USER_ID"]);
            $userGuest = "arUsers";

            if($cuid <= 0 && in_array($cup, $arGuestsPref))
            {
                $cuid = intval($arTicket[$cup . "_GUEST_ID"]);
                $userGuest = "arGuests";
                //array_key_exists("first", $search_array)
            }

            $cName = "";
            $cSName = "";
            $cLName = "";
            $cLogin = "";
            $cHtmlMameS = "";

            if($cuid > 0)
            {
                $cName = $arStrUsersM[$userGuest][$cuid]["NAME"];
                $cSName = $arStrUsersM[$userGuest][$cuid]["SECOND_NAME"];
                $cLName = $arStrUsersM[$userGuest][$cuid]["LAST_NAME"];
                $cLogin = $arStrUsersM[$userGuest][$cuid]["LOGIN"];
                $cHtmlMameS = $arStrUsersM[$userGuest][$cuid]["HTML_NAME_S"];

                if ($userSites[$cuid]) {
                    $cHtmlMameS .= " <br><i>(".$userSites[$cuid].")</i>";
                }

            }

            $arUsersP[$cup . "_NAME"] = $cName;
            $arUsersP[$cup . "_SECOND_NAME"] = $cSName;
            $arUsersP[$cup . "_LAST_NAME"] = $cLName;
            $arUsersP[$cup . "_LOGIN"] = $cLogin;
            $arUsersP[$cup . "_HTML_NAME_S"] = $cHtmlMameS;
        }


        $arDict = Array();

        foreach ($arDictType as $TYPE => $CODE)
        {
            $arDict += _GetDictionaryInfo($arTicket[$CODE."_ID"], $TYPE, $CODE, $arTicketDictionary);
        }


        $url = CComponentEngine::MakePathFromTemplate($arParams["TICKET_EDIT_TEMPLATE"], Array("ID" => $arTicket["ID"]));

        $arResult["TICKETS"][] = ($arTicket + $arUsersP + $arDict + Array("TICKET_EDIT_URL" => $url));
    }
    //Make list of tickets for test
    $obTicketTesting = GKSupportTicketTesting::GetList(($by="ticket_id"), ($order="desc"), array()); 
    while($ticket = $obTicketTesting->Fetch()) {
        $ticketTestList[$ticket["TICKET_ID"]]=$ticket;
    }       

    // make grid
    foreach ($arResult["TICKETS"] as &$arTicket)
    {
        $arTickets[] = $arTicket;

        foreach($arUsersPref as $cup)
        {
            $arRespUserIDs[] = $arTicket[$cup . "_USER_ID"];
        }
        foreach($arGuestsPref as $cgp)
        {
            $arGuestIDs[] = $arTicket[$cgp . "_GUEST_ID"];
        }

        if (strlen($arTicket["MODIFIED_MODULE_NAME"])<=0 || $arTicket["MODIFIED_MODULE_NAME"]=="support")
        {
            if(intval($arTicket["MODIFIED_USER_ID"]) > 0)
            {
                if(isset($arTicket["MODIFIED_HTML_NAME_S"]))
                {
                    $arTicket['MODIFIED_BY'] = $arTicket["MODIFIED_HTML_NAME_S"];
                }
                else
                {
                    $arTicket['MODIFIED_BY'] = ("[" . $arTicket["MODIFIED_USER_ID"] . "] (" . $arTicket["MODIFIED_LOGIN"] . ") " . $arTicket["MODIFIED_NAME"] . "  " . $arTicket["MODIFIED_LAST_NAME"]);
                }
            }
            elseif(intval($arTicket["OWNER_USER_ID"]) > 0)
            {
                if(isset($arTicket["OWNER_HTML_NAME_S"]))
                {
                    $arTicket['MODIFIED_BY'] = $arTicket["OWNER_HTML_NAME_S"];
                }
                else
                {
                    $arTicket['MODIFIED_BY'] = ("[" . $arTicket["OWNER_USER_ID"] . "] (" . $arTicket["OWNER_LOGIN"] . ") " . $arTicket["OWNER_NAME"] . "  " . $arTicket["OWNER_LAST_NAME"]);
                }
            }
            elseif(intval($arTicket["CREATED_USER_ID"]) > 0)
            {
                if(isset($arTicket["CREATED_HTML_NAME_S"]))
                {
                    $arTicket['MODIFIED_BY'] = $arTicket["CREATED_HTML_NAME_S"];
                }
                else
                {
                    $arTicket['MODIFIED_BY'] = ("[" . $arTicket["CREATED_USER_ID"] . "] (" . $arTicket["CREATED_LOGIN"] . ") " . $arTicket["CREATED_NAME"] . "  " . $arTicket["CREATED_LAST_NAME"]);
                }
            }
        }
        else
        {
            $arTicket['MODIFIED_BY'] = $arTicket["MODIFIED_MODULE_NAME"];
        }

        $aCols = array(
            'LAMP' => '<div class="support-lamp-'.str_replace("_","-",$arTicket["LAMP"]).'" title="'.GetMessage("SUP_".strtoupper($arTicket["LAMP"]).($bADS ? "_ALT_SUP" : "_ALT")).'"></div>',
            'TIMESTAMP_X' => FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arTicket["TIMESTAMP_X"]))
        );

        $url = CComponentEngine::MakePathFromTemplate($arParams["TICKET_EDIT_TEMPLATE"], Array("ID" => $arTicket["ID"]));

        $aActions = Array(
            array("ICONCLASS"=>"edit", "TEXT"=>GetMessage('SUP_EDIT'), "DEFAULT"=>true, "ONCLICK"=>
                "BX.ajax.AJAX_ID = '".$arParams['AJAX_ID']."'; var url = '".$url."'; if(BX.ajax.AJAX_ID != '') BX.ajax.insertToNode(url+(url.indexOf('?') == -1? '?':'&')+'bxajaxid='+BX.ajax.AJAX_ID, 'comp_'+BX.ajax.AJAX_ID); else jsUtils.Redirect(arguments, '".$url."');"
            ),
        );


        $arResult["FULL_TICKET_LIST"][$arTicket["ID"]] = $arTicket["ID"];

        if(!empty($ticketTestList[$arTicket["ID"]])){
            $arTicket["NEED_TESTING"]='Y';
        } else {
            $arTicket["NEED_TESTING"]='N';
        }
        $aRows[] = array("data"=>$arTicket, "actions"=>$aActions, "columns"=>$aCols);
    }

    $arResult["ROWS"] = $aRows;
    $arResult["ROWS_COUNT"] = $rsTickets->SelectedRowsCount();
    $arResult["TICKETS_COUNT"] = $rsTickets->SelectedRowsCount();
    $arResult["NAV_STRING"] = $rsTickets->GetPageNavString(GetMessage("SUP_PAGES"));
    $arResult["CURRENT_PAGE"] = htmlspecialcharsbx($APPLICATION->GetCurPage());
    $arResult["NEW_TICKET_PAGE"] = htmlspecialcharsbx(CComponentEngine::MakePathFromTemplate($arParams["TICKET_EDIT_TEMPLATE"], Array("ID" => "0")));

    $arResult["SORT"] = $aSort["sort"];
    $arResult["SORT_VARS"] = $aSort["vars"];

    $arResult["NAV_OBJECT"] = $rsTickets;          


    // rewrite for old templates
    if (!empty($_SESSION["main.interface.grid"][$arResult["GRID_ID"]]["filter"]))
    {
        foreach ($_SESSION["main.interface.grid"][$arResult["GRID_ID"]]["filter"] as $k => $v)
        {
            $_REQUEST['find_'.strtolower($k)] = $v;
        }
    }


    //check ticket plan
    $ticket_plan = new GKSupportTicketPlan;
    $ticket_plan_list = $ticket_plan->GetList($by = "ID", $sort = "ASC", array());
    while($arTicketPlan = $ticket_plan_list->Fetch()) {
        $arResult["TICKET_PLAN"][$arTicketPlan["TICKET_ID"]] = $arTicketPlan["TICKET_ID"];
    }

    //check ticket plan log
    foreach ($arResult["FULL_TICKET_LIST"] as $ID) {
        $ticket_plan_log = new GKSupportTicketPlanLog;
        $rsTicketPlanLog = $ticket_plan_log->GetList($by = "ID", $sort = "DESC", $arFilter = array("TICKET_ID" => $ID));
        while ($arTicketlog = $rsTicketPlanLog->Fetch()) {
            $arTicketlog["DATE"] = str_replace(" ", "<br>", $arTicketlog["DATE"]);
            $user = $arResult["STAFF_LIST"][$arTicketlog["USER_ID"]];
            $arTicketlog["USER"] = $user["NAME"]."<br>".$user["LAST_NAME"]; 
           
            $arResult["TICKET_PLAN_LOG"][$ID][] = $arTicketlog;
        }    
    }      

    $this->IncludeComponentTemplate();
?>