<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    //��������� ������ �������� ������������
    $user_groups = CUser::GetUserGroup($USER->GetId());
    //���� ������������ � ������ �������, ��� ���� ������� ��� ���� ��� ������� 
    if (in_array(1,$user_groups)) {

        //�������� ������ �������������
        $items = array(""=>"-");

        $params = array("SELECT"=>array("UF_*","ID"));
        $filter = array();    
        $users = CUser::GetList(($by="id"), ($order="asc"), $filter, $params);
        while ($arUser = $users->Fetch()) {
            $items[$arUser["ID"]] = $arUser["UF_SITE"];
        }

        asort($items);
        //��������� � ������ ���� "��� �������"
        $arResult["FILTER"][] = array(
            "id"=> "CREATED_USER_ID",
            "name" => "����",
            "type" => "list",
            "items" => $items, 
        );     

        //arshow($arResult);
        //������� �� ������� ������, �� ��������������� �������
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