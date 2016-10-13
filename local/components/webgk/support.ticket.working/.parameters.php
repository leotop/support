<? if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

    $arComponentParameters = array(
        'PARAMETERS' => array(    
            'TICKET_ID' => array(
                'NAME' => GetMessage("TICKET_ID"),
                'TYPE' => 'STRING',
                'PARENT' => 'BASE',
            ), 
            'WORK_STATUS_ID' => array(
                'NAME' => GetMessage("WORK_STATUS_ID"),
                'TYPE' => 'STRING',
                'PARENT' => 'BASE',
                'DEFAULT' => 'W'
            )   
        ),
    );
?>