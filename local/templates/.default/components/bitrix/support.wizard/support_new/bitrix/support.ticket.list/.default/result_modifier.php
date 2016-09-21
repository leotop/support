<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    //проверяем группы текущего пользователя
    $user_groups = CUser::GetUserGroup($USER->GetId());
    //если пользователь в группе админов, для него выводим доп поле для фильтра 
    if (in_array(1,$user_groups)) {

        //получаем список пользователей
        $items = array(""=>"-");

        $params = array("SELECT"=>array("UF_*","ID"));
        $filter = array();    
        $users = CUser::GetList(($by="id"), ($order="asc"), $filter, $params);
        while ($arUser = $users->Fetch()) {
            $items[$arUser["ID"]] = $arUser["UF_SITE"];
        }

        asort($items);
        //добавляем в фильтр поле "кто добавил"
        $arResult["FILTER"][] = array(
            "id"=> "CREATED_USER_ID",
            "name" => "Сайт",
            "type" => "list",
            "items" => $items, 
        );     

        //arshow($arResult);
        //удаляем из выборки записи, не соответствующие фильтру
        if ($_GET["CREATED_USER_ID"]) {
            foreach ($arResult["TICKETS"] as $id=>$ticket) {
                if ($ticket["CREATED_USER_ID"] != $_GET["CREATED_USER_ID"]) {               
                    unset($arResult["TICKETS"][$id]);
                }
            } 
           // arshow($arResult["ROWS"]);
            
            foreach ($arResult["ROWS"] as $row_id=>$row) {
                if ($row["data"]["CREATED_USER_ID"] != $_GET["CREATED_USER_ID"]) {               
                    unset($arResult["ROWS"][$row_id]);
                }
            }    
        }

    }

    //arshow($arResult);
?>