<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    require_once($_SERVER["DOCUMENT_ROOT"].$componentPath."/functions.php");

    CModule::IncludeModule("webgk.support");

    if (!CModule::IncludeModule("support"))
    {
        ShowError(GetMessage("MODULE_NOT_INSTALL"));
        return;
    }

    global $USER;

    $uID = $USER->GetId();   

    //Permissions
    if ( !($USER->IsAuthorized() && (CTicket::IsSupportClient() || CTicket::IsAdmin() || CTicket::IsSupportTeam() || CTicket::IsDemo())) )
        $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

    global $USER_FIELD_MANAGER;
    $arrUF = $USER_FIELD_MANAGER->GetUserFields( "SUPPORT", 0, LANGUAGE_ID );

    $supportStaffGroupID = GKSupport::GetSupportEmployerGroupID();

    $supportStaff = in_array($supportStaffGroupID,CUser::GetUserGroup($uID));     

    //Post
    $strError = "";

    $arParams["TICKET_EDIT_TEMPLATE"] = trim($arParams["TICKET_EDIT_TEMPLATE"]);
    $arParams["TICKET_EDIT_TEMPLATE"] = (strlen($arParams["TICKET_EDIT_TEMPLATE"]) > 0 ? htmlspecialcharsbx($arParams["TICKET_EDIT_TEMPLATE"]) : "ticket_edit.php?ID=#ID#");

    $arParams['SHOW_COUPON_FIELD'] = (array_key_exists('SHOW_COUPON_FIELD', $arParams) && $arParams['SHOW_COUPON_FIELD'] == 'Y') ? 'Y' : 'N';

    $arStatuses = array();
    $statuses = CTicketDictionary::GetList($by="id",$order="asc",array("TYPE"=>"S"));  
    while($arStatus = $statuses->Fetch()) {
        $arStatuses[] = $arStatus; 
    }

    if ((strlen($_REQUEST["save"])>0 || strlen($_REQUEST["apply"])>0) && $_SERVER["REQUEST_METHOD"]=="POST" && check_bitrix_sessid())
    {
        $ID = intval($_REQUEST["ID"]);

        if ($ID <=0)
        {
            if (strlen(trim($_REQUEST["TITLE"]))<=0) 
                $strError .= GetMessage("SUP_FORGOT_TITLE")."<br>";

            if (strlen(trim($_REQUEST["MESSAGE"]))<=0) 
                $strError .= GetMessage("SUP_FORGOT_MESSAGE")."<br>";
        }   

        /*
        foreach($arStatuses as $arStatus) {             
        $opt = COption::GetOptionString( "webgk.support", 'status_'.$arStatus["SID"]);
        if ($opt == "Y" && $_REQUEST["STATUS_SID"] == $arStatus["SID"] && $_REQUEST["MESSAGE"] == "" && $supportStaff && !$_REQUEST["CLOSE"]) {
        $strError .= GetMessage("SUP_COMMENT_REQUIRED")."<br>";
        }
        } */ 


        //update payment status
        $inPayment = "N";   
        if ($_REQUEST['UF_IN_PAYMENT'] == "Y") {
            $inPayment = "Y";
        }    
        if ($USER->IsAdmin() || $supportStaff) {        
            GKSupportTicketPayment::Change($ID,$inPayment);            
        }


        $arFILES = array();
        if (is_array($_FILES) && count($_FILES)>0)
        {
            foreach ($_FILES as $key => $arFILE)
            {
                if (strlen($arFILE["name"])>0)
                {
                    $arFILE["MODULE_ID"] = "support";
                    $arFILES[] = $arFILE;
                }
            }
        }

        if (is_array($arFILES) && count($arFILES)>0)
        {
            $max_size = COption::GetOptionString("support", "SUPPORT_MAX_FILESIZE");
            $max_size = intval($max_size)*1024;

            foreach ($arFILES as $key => $arFILE)
            {
                if (intval($arFILE["size"])>$max_size || intval($arFILE["error"])>0)
                    $strError .= str_replace("#FILE_NAME#", $arFILE["name"], GetMessage("SUP_MAX_FILE_SIZE_EXCEEDING"))."<br>";
            }
        }

        $arParams["TICKET_LIST_URL"] = trim($arParams["TICKET_LIST_URL"]);
        $arParams["TICKET_LIST_URL"] = (strlen($arParams["TICKET_LIST_URL"]) > 0 ? htmlspecialcharsbx($arParams["TICKET_LIST_URL"]) : "ticket_list.php");

        if ($strError == "")   
        {     

            // check before writing,  user access to ticket
            $bSetTicket = false;
            if ($arParams["ID"] > 0) 
            {
                if (CTicket::IsAdmin())
                    $bSetTicket = true;
                else
                {
                    $rsTicket = CTicket::GetByID($arParams["ID"], SITE_ID, $check_rights = "Y", $get_user_name = "N", $get_extra_names = "N");
                    if ($arTicket = $rsTicket->GetNext())
                        $bSetTicket = true;
                }
            } 
            else 
            {
                $bSetTicket = true;
            }

            if ($bSetTicket)
            {
                if ($_REQUEST["OPEN"]=="Y")
                    $_REQUEST["CLOSE"]="N";
                if ($_REQUEST["CLOSE"]=="Y")
                    $_REQUEST["OPEN"]="N";

                $arFields = array(
                    'SITE_ID'					=> SITE_ID,
                    'CLOSE'						=> $_REQUEST['CLOSE'],
                    'TITLE'						=> $_REQUEST['TITLE'],
                    'CRITICALITY_ID'			=> $_REQUEST['CRITICALITY_ID'],
                    'CATEGORY_ID'				=> $_REQUEST['CATEGORY_ID'],
                    'MARK_ID'					=> $_REQUEST['MARK_ID'],
                    'MESSAGE'					=> $_REQUEST['MESSAGE'],
                    'HIDDEN'					=> 'N',
                    'FILES'						=> $arFILES,
                    'COUPON'					=> $_REQUEST['COUPON'],
                    'PUBLIC_EDIT_URL'			=> $APPLICATION->GetCurPage(),
                );



                foreach( $_REQUEST as $k => $v )
                {
                    if( array_key_exists( $k, $arrUF ) )
                    {
                        $arFields[$k] = $v;
                    }
                }

                //set ticket by user
                if ($_REQUEST["author"]) {
                    $arFields["OWNER_SID"] = $_REQUEST['author'];
                    $arFields["OWNER_USER_ID"] = $_REQUEST['author'];               
                } 

                //ticket params
                if ($_REQUEST["RESPONSIBLE_USER_ID"] && $_REQUEST["STATUS_SID"] && $supportStaff)
                    $arFields["RESPONSIBLE_USER_ID"] = $_REQUEST["RESPONSIBLE_USER_ID"]; 
                $arFields["STATUS_SID"] = $_REQUEST["STATUS_SID"];    

                $checkRights = "Y";
                if (!empty($_REQUEST["CHANGE_TITLE"]) && $_REQUEST["CHANGE_TITLE"] != $_REQUEST["TITLE"]) {
                    $arFields["CHANGE_TITLE"] = $_REQUEST["CHANGE_TITLE"]; 
                    if ($ID > 0) {
                        $checkRights = "N";
                    }  
                } 


                //update working status        
                if ($arFields["STATUS_SID"] == $arParams["WORK_STATUS_ID"] && $arFields["CLOSE"] != "Y") { 
                    //add ticket to work statistics
                    $arTicket = CTicket::GetList($by = "ID", $sort = "ASC", array("ID" => $ID))->Fetch();   
                    $ticket_work_status = new GKSupportTicketTracking; 
                    $arTicketWorking = $ticket_work_status->GetList($by = "ID", $sort = "ASC", array("TICKET_ID" => $ID, "USER_ID" => $arTicket["RESPONSIBLE_USER_ID"]))->Fetch();

                    //responsible changing, current user is not responsible
                    if (!empty($arFields["RESPONSIBLE_USER_ID"]) && $arFields["RESPONSIBLE_USER_ID"] != $arTicket["RESPONSIBLE_USER_ID"]) {                         
                        if (!empty($arTicketWorking) || $arFields["RESPONSIBLE_USER_ID"] != $uID) {
                            $ticket_work_status->DeleteByTicket($ID); 
                        }
                    //responsible changing, current user is responsible    
                    } else if (!empty($arFields["RESPONSIBLE_USER_ID"]) && $arFields["RESPONSIBLE_USER_ID"] == $arTicket["RESPONSIBLE_USER_ID"]) {                          
                        if (empty($arTicketWorking)) {
                            $ticket_work_status->Add(array("TICKET_ID" => $ID, "USER_ID" => $uID)); 
                        }
                    //responsible not changing    
                    } 

                } else {
                    //remove ticket to work statistics
                    $ticket_work_status = new GKSupportTicketTracking; 
                    $arTicketWorking = $ticket_work_status->GetList($by = "ID", $sort = "ASC", array("TICKET_ID" => $ID, "USER_ID" => $uID))->Fetch();
                    if (!empty($arTicketWorking) || $arFields["RESPONSIBLE_USER_ID"] != $uID) {
                        $ticket_work_status->DeleteByTicket($ID); 
                    }
                }


                $ID = CTicket::SetTicket($arFields, $ID, $checkRights, $NOTIFY = "Y");

                if (intval($ID)>0)
                {
                    if (strlen($_REQUEST["save"])>0)
                    {
                        LocalRedirect($arParams["TICKET_LIST_URL"]);
                    }
                    elseif (strlen($_REQUEST["apply"])>0)
                    {
                        LocalRedirect(
                            CComponentEngine::MakePathFromTemplate(
                                $arParams["TICKET_EDIT_TEMPLATE"], 
                                Array(
                                    "ID" => $ID
                                )
                            )
                        );
                    }
                }
                else 
                {
                    $ex = $APPLICATION->GetException();
                    if ($ex)
                    {
                        $strError .= $ex->GetString() . '<br>';
                    }
                    else 
                    {
                        $strError .= GetMessage('SUP_ERROR') . '<br>';
                    }
                }
            }
            else
            {
                LocalRedirect($arParams["TICKET_LIST_URL"]);
            }  
        }



    }

    //Result array
    $arResult = Array(
        "TICKET" => Array(),
        "MESSAGES" => Array(),
        "ONLINE" => Array(),
        "DICTIONARY" => Array(
            "MARK" => Array(),
            "CRITICALITY" => Array(),
            "CRITICALITY_DEFAULT" => "",
            "CATEGORY" => Array(),
            "CATEGORY_DEFAULT" => "",
        ),
        "ERROR_MESSAGE" => $strError,
        "REAL_FILE_PATH" => (strlen($_SERVER["REAL_FILE_PATH"]) > 0 ? htmlspecialcharsbx($_SERVER["REAL_FILE_PATH"]) : htmlspecialcharsbx($APPLICATION->GetCurPage())),
        "NAV_STRING" => "",
        "NAV_RESULT" => null,
        "OPTIONS" => Array(
            "ONLINE_INTERVAL" => intval(COption::GetOptionString("support", "ONLINE_INTERVAL")),
            "MAX_FILESIZE" => intval(COption::GetOptionString("support", "SUPPORT_MAX_FILESIZE")),
        ),
    );

    //    //Check is user is in staff group
    //    $uID = $USER->GetId();
    //    $supportStaffGroupID = GKSupport::GetSupportEmployerGroupID();
    //    $supportStaff = in_array($supportStaffGroupID,CUser::GetUserGroup($uID)); 
    //    if ($supportStaff===true) {
    //        $arResult["IS_STAFF"]='Y';
    //    }

    $arResult["USER"]["IS_STAFF"] = "N";     
    if ($supportStaff) {
        $arResult["USER"]["IS_STAFF"] = "Y";  
    }

    $arResult["USER"]["IS_ADMIN"] = $USER->IsAdmin();   

    $arResult["STATUSES"] = $arStatuses;


    $staff = CUser::GetList(($by="name"), ($order="asc"), array("ACTIVE"=>"Y", "GROUPS_ID"=>array($supportStaffGroupID)));
    while($arStaff = $staff->Fetch()) {
        $arResult["USER"]["STAFF"][] = $arStaff;
    }




    $arParams["ID"] = (intval($arParams["ID"]) > 0 ? intval($arParams["ID"]) : intval($_REQUEST["ID"]));

    $UFA = array();
    $UFAT = array();

    if( isset( $arParams["SET_SHOW_USER_FIELD"] ) )
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
    $rsTicket = CTicket::GetByID($arParams["ID"], SITE_ID, $check_rights = "Y", $get_user_name = "N", $get_extra_names = "N", array( "SELECT" => $UFA ) );

    if ($arTicket = $rsTicket->GetNext())
    {

        //get client info
        $arClient = GKSupportUsers::GetList($by="ID",$sort="ASC",array("USER_ID"=>$arTicket["OWNER_USER_ID"]))->Fetch();
        $arResult["USER"]["CLIENT"] = $arClient;

        foreach( $UFA as $k => $v )
        {
            $arParams[$v] = $arTicket[$v];
        }
        //+Ticket and user names
        $arResult["TICKET"] = $arTicket +
        _GetUserInfo($arTicket["RESPONSIBLE_USER_ID"], "RESPONSIBLE") +
        _GetUserInfo($arTicket["OWNER_USER_ID"], "OWNER") +
        _GetUserInfo($arTicket["CREATED_USER_ID"], "CREATED") +
        _GetUserInfo($arTicket["MODIFIED_USER_ID"], "MODIFIED_BY");


        //Dictionary table
        $arDictionary = Array(
            "C" => Array("CATEGORY", intval($arTicket["CATEGORY_ID"])),
            "K" => Array("CRITICALITY", intval($arTicket["CRITICALITY_ID"])),
            "S" => Array("STATUS", intval($arTicket["STATUS_ID"])),
            "M" => Array("MARK", intval($arTicket["MARK_ID"])),
            "SR" => Array("SOURCE", intval($arTicket["SOURCE_ID"]))
        );

        //+Ticket dictionary
        $arResult["TICKET"] += _GetDictionaryInfoEx($arDictionary);


        //+Sla
        $arResult["TICKET"]["SLA_NAME"] = $arResult["TICKET"]["SLA_DESCRIPTION"] = "";
        $rsSla = CTicketSLA::GetByID($arTicket["SLA_ID"]);
        if ($rsSla && $arSla = $rsSla->Fetch())
        {
            $arResult["TICKET"]["SLA_NAME"] = htmlspecialcharsbx($arSla["NAME"]);
            $arResult["TICKET"]["SLA_DESCRIPTION"] = htmlspecialcharsbx($arSla["DESCRIPTION"]);
        }

        //Messages files
        $arMessagesFiles = Array();
        $rsFiles = CTicket::GetFileList($v1="s_id", $v2="asc", array("TICKET_ID" => $arParams["ID"]));
        {
            while ($arFile = $rsFiles->Fetch())
            {
                $name = strlen($arFile["ORIGINAL_NAME"])>0 ? $arFile["ORIGINAL_NAME"] : $arFile["FILE_NAME"];
                if (strlen($arFile["EXTENSION_SUFFIX"]) > 0)
                {
                    $suffix_length = strlen($arFile["EXTENSION_SUFFIX"]);
                    $name = substr($name, 0, strlen($name)-$suffix_length);
                }
                $arMessagesFiles[$arFile["MESSAGE_ID"]][] = array("HASH" => $arFile["HASH"], "NAME" => htmlspecialcharsbx($name), "FILE_SIZE" => $arFile["FILE_SIZE"]);
            }
        }

        //+Messages
        $arParams["MESSAGES_PER_PAGE"] = (intval($arParams["MESSAGES_PER_PAGE"]) <= 0 ? 20 : intval($arParams["MESSAGES_PER_PAGE"]));

        $arFilter = Array(
            "TICKET_ID" => $arParams["ID"],
            "TICKET_ID_EXACT_MATCH" => "Y",
            "IS_MESSAGE" => "Y"
        );

        CPageOption::SetOptionString("main", "nav_page_in_session", "N");

        //sort config
        $order = $arParams["MESSAGE_SORT_ORDER"];

        $rsMessage = CTicket::GetMessageList($by, $order, $arFilter, $is_filtered, $check_rights = "Y", $get_user_name = "N");
        $rsMessage->NavStart($arParams["MESSAGES_PER_PAGE"]);

        $arResult["NAV_STRING"] = $rsMessage->GetPageNavString(GetMessage("SUP_PAGES"));
        $arResult["NAV_RESULT"] = $rsMessage;

        $userGroups = array();

        while ($arMessage = $rsMessage->GetNext())
        {
            if (array_key_exists($arMessage["ID"], $arMessagesFiles)) 
                $arFiles["FILES"] = $arMessagesFiles[$arMessage["ID"]];
            else
                $arFiles["FILES"] = Array();

            $arMessage["MESSAGE"] =TxtToHTML(
                $arMessage["~MESSAGE"], 
                $bMakeUrls = true, 
                $iMaxStringLen = $arParams["MESSAGE_MAX_LENGTH"], 
                $QUOTE_ENABLED = "Y", 
                $NOT_CONVERT_AMPERSAND = "N", 
                $CODE_ENABLED = "Y", 
                $BIU_ENABLED ="Y",
                $quote_table_class		= "support-quote-table",
                $quote_head_class		= "support-quote-head",
                $quote_body_class		= "support-quote-body",
                $code_table_class		= "support-code-table",
                $code_head_class		= "support-code-head",
                $code_body_class		= "support-code-body",
                $code_textarea_class	= "support-code-textarea",
                $link_class					= ""
            );

            //get message owner status
            if (!is_array($userGroups[$arMessage["OWNER_USER_ID"]]) && $arMessage["OWNER_USER_ID"] != $arResult["USER"]["CLIENT"]["USER_ID"]) {
                $groups = CUser::GetUserGroupList($arMessage["OWNER_USER_ID"]);
                while($arGroup = $groups->Fetch()) {
                    $userGroups[$arMessage["OWNER_USER_ID"]][] = $arGroup["GROUP_ID"]; 
                }      
            }

            $arMessage["OWNER_IS_ADMIN"] = "N";
            if (in_array(1,$userGroups[$arMessage["OWNER_USER_ID"]])) {
                $arMessage["OWNER_IS_ADMIN"] = "Y"; 
            } 
            $arMessage["OWNER_IS_STAFF"] = "N";
            if (in_array($supportStaffGroupID,$userGroups[$arMessage["OWNER_USER_ID"]])) {
                $arMessage["OWNER_IS_STAFF"] = "Y";
            }  



            $arResult["MESSAGES"][] = 
            $arMessage + 
            $arFiles +
            _GetUserInfo($arMessage["OWNER_USER_ID"], "OWNER") +
            _GetUserInfo($arMessage["CREATED_USER_ID"], "CREATED") +
            _GetUserInfo($arMessage["MODIFIED_USER_ID"], "MODIFIED_BY");
        }


        //Online
        CTicket::UpdateOnline($arParams["ID"], $USER->GetID());
        $rsOnline = CTicket::GetOnline($arParams["ID"]);
        while ($arOnline = $rsOnline->GetNext())
        {
            $arResult["ONLINE"][] = $arOnline;
        }

        $ticketSite = $arTicket["SITE_ID"];
        $ticketSla = $arTicket["SLA_ID"];

        //check ticket payment status
        $arResult["TICKET"]["IN_PAYMENT"] = GKSupportTicketPayment::GetByTicket($arResult["TICKET"]["ID"]);
    }
    else
    {
        $ticketSite = SITE_ID;
        $ticketSla = CTicketSLA::GetForUser();
        $arResult["DICTIONARY"]["CRITICALITY_DEFAULT"] = CTicketDictionary::GetDefault("K", $ticketSite);
        $arResult["DICTIONARY"]["CATEGORY_DEFAULT"] = CTicketDictionary::GetDefault("C", $ticketSite);
    }

    //Ticket testing params
    $ticketTesting = GKSupportTicketTesting::GetByID($arResult["TICKET"]["ID"]); 
    if(!empty($ticketTesting)){
        $arResult["TICKET"]["NEED_TESTING"]='Y';
        $arResult["TICKET"]["TEST_PASSED"]=$ticketTesting["TEST_PASSED"];
        $arUserNeedTest = CUser::GetByID(intval($ticketTesting["USER_ID_NEED_TEST"]))->Fetch();
        if (!empty($arUserNeedTest)) {
            $arResult["TICKET"]["USER_ID_NEED_TEST"]=$arUserNeedTest["LAST_NAME"].' '.$arUserNeedTest["NAME"];
        }
        $arUserTestPassed = CUser::GetByID(intval($ticketTesting["USER_ID_TEST_PASSED"]))->Fetch();
        if (!empty($arUserTestPassed)) {
            $arResult["TICKET"]["USER_ID_TEST_PASSED"]=$arUserTestPassed["LAST_NAME"].' '.$arUserTestPassed["NAME"];
        }
    } else {
        $arTicket["TICKET"]["NEED_TESTING"]='N';
        $arTicket["TICKET"]["NEED_TESTING"]='N';
    }

    //Mark, Category, Criticality dictionary list
    $ticketDictionary = CTicketDictionary::GetDropDownArray($ticketSite, $ticketSla);
    $arResult["DICTIONARY"]["MARK"] = _GetDropDownDictionary("M", $ticketDictionary);
    $arResult["DICTIONARY"]["CRITICALITY"] = _GetDropDownDictionary("K", $ticketDictionary);
    $arResult["DICTIONARY"]["CATEGORY"] = _GetDropDownDictionary("C", $ticketDictionary);


    unset($rsTicket);
    unset($rsMessage);
    unset($arMessagesFiles);
    unset($ticketDictionary);



    //Set Title
    $arParams["SET_PAGE_TITLE"] = ($arParams["SET_PAGE_TITLE"] == "N" ? "N" : "Y" );

    if ($arParams["SET_PAGE_TITLE"] == "Y")
    {
        if (empty($arResult["TICKET"]))
            $APPLICATION->SetTitle(GetMessage("SUP_NEW_TICKET_TITLE"));
        else
            $APPLICATION->SetTitle(GetMessage("SUP_EDIT_TICKET_TITLE", array("#ID#" => $arResult["TICKET"]["ID"], "#TITLE#" => $arResult["TICKET"]["TITLE"])));
    }




    $this->IncludeComponentTemplate();

?>