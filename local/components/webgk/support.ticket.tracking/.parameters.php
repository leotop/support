<? if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

    $arComponentParameters = array(
        'PARAMETERS' => array(    
            'WORK_STATUS_ID' => array(
                'NAME' => GetMessage("WORK_STATUS_ID"),
                'TYPE' => 'STRING',
                'PARENT' => 'BASE',
                'DEFAULT' => 'W'
            ),
            'TICKET_PAGE_URL'  => array(
                'NAME' => GetMessage("TICKET_PAGE_URL"),
                'TYPE' => 'STRING',
                'PARENT' => 'BASE',
                'DEFAULT' => '/?ID=#TICKET_ID#&edit=1'
            ),  
        ),
    );
?>