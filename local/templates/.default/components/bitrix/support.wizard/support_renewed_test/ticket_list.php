<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    //�������������� ���� ��� �������
    $arFilter = array();

    //�������� ������ �������������
    $items = array(""=>"-");

    $params = array("SELECT"=>array("UF_*","ID"));
    $filter = array("GROUPS_ID"=>array(7),"ACTIVE"=>"Y");    
    $users = CUser::GetList(($by="id"), ($order="asc"), $filter, $params);
    while ($arUser = $users->Fetch()) {
        $items[$arUser["ID"]] = $arUser["UF_SITE"];
    }

    //arshow($items, true);

    asort($items);
    //��������� � ������ ���� "��� �������"
    $arFilter[] = array(
        "id"=> "OWNER",  //�������� ������� ���� ����� ����� �� �������  http://dev.1c-bitrix.ru/api_help/support/classes/cticket/getlist.php
        "name" => "����",
        "type" => "list",
        "items" => $items, 
    );     


    //��������� � ������ �������������
    $users = array(""=>"-");
    $user = CUser::GetList(($by="name"), ($order="asc"), array("GROUPS_ID"=>array(8)));   
    while ($arUser = $user->Fetch()){
        $users[$arUser["ID"]] = $arUser["NAME"]." ".$arUser["LAST_NAME"];
    }
    $arFilter[] = array(
        "id"=> "RESPONSIBLE",  
        "name" => "�������������",
        "type" => "list",
        "items" => $users, 
    );         


    //�������� ������� ��� �������
    $fStatuses = array(""=>"-");
    $statuses = CTicketDictionary::GetList($by="id",$order="asc",array("TYPE"=>"S"));  
    while($arStatus = $statuses->Fetch()) {
        $fStatuses[$arStatus["ID"]] = $arStatus["NAME"];  
    }
    $arFilter[] = array(
        "id"=> "STATUS_ID",  
        "name" => "������",
        "type" => "list",
        "items" => $fStatuses, 
    ); 

    // arshow($fStatuses);  


    //id ����������

    //�������� ��������� ��� �������    
    $fSources = array(""=>"-");
    $arSelect = Array("ID", "NAME");
    $res = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>"22"), false, Array(), $arSelect);
    $i=9;
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $fSources[$arFields["ID"]] = $arFields["NAME"];
    }

    $arFilter[] = array(
        "id"=> "UF_SOURCE_TICKET",  
        "name" => "��������",
        "type" => "list",
        "items" => $fSources, 
    ); 


?>                                

<?
    //arshow($arResult);
    //arshow($arFilter);
    //arshow($arParams, true);
?>
<?$APPLICATION->IncludeComponent(
        "webgk:support.ticket.list", 
        "tickets", 
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
