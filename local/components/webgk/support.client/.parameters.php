<? if(!defined('B_PROLOG_INCLUDED')||B_PROLOG_INCLUDED!==true)die();  

    $months = array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12);

    $arComponentParameters = array(
        'PARAMETERS' => array(          
            'TICKET_DETAIL_PAGE' => array(
                'NAME' => GetMessage('TICKET_DETAIL_PAGE'),
                'TYPE' => 'STRING',
                'MULTIPLE' => 'N',
                'PARENT' => 'BASE',
                'DEFAULT' => '/deskman/?ID=#ID#&edit=1',
            ), 
            'DEFAULT_MONTH_COUNT' => array(              
                'NAME' => GetMessage('DEFAULT_MONTH_COUNT'),
                'TYPE' => 'LIST',
                'VALUES' => $months,
                'DEFAULT' => 2,
            ),
        ),
    );
?>