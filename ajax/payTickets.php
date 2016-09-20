<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?> 
<?
    //собираем обращения по тикету/месяцу для клиента
    $messFilter = array();

    if (intval($_POST["ticket"]) > 0) {
        $messFilter["PROPERTY_TICKET_ID"] = intval($_POST["ticket"]); 
    }

    //$messFilter[">DATE_CREATE"] = $_POST["year"]."-".$_POST["month"]."-01 00:00:00";
    //$messFilter["<=DATE_CREATE"] = $_POST["year"]."-".$_POST["month"]."-".date("t")." 23:59:59";
    $messFilter[">=DATE_CREATE"] = "01.".$_POST["month"].".".$_POST["year"]." 00:00:00";
    $messFilter["<=DATE_CREATE"] = date("t", mktime(0,0,0,$_POST["month"],01,$_POST["year"])).".".$_POST["month"].".".$_POST["year"]." 23:59:59";
    $messFilter["IBLOCK_ID"] = 24;
    $messFilter["PROPERTY_CLIENT"] = $_POST["client"];

    //arshow($messFilter);
    $mess = CIBlockElement::GetList(array(), $messFilter, false, false, array("ID"));
    
    $value = "";
    if ($_POST["status"] != "false") {
        $value = 35; //оплачен
    }
    
    
    while($arMess = $mess->Fetch()) {
        CIBlockElement::SetPropertyValuesEx($arMess["ID"], 24, array("is_payed" => $value));
    }

?>