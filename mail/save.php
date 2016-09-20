<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?

    CModule::IncludeModule("subscribe");

    $body="";
    $body.=iconv("UTF-8", "cp1251", $_POST["introduction"]);

    for ($i=0;$i<=$_POST["count"]; $i++)
    {
        if ( $_POST["tname".$i] && $_POST["tlink".$i] && $_POST["tintr".$i])
        {
            $body.="<p><a href='".iconv("UTF-8", "cp1251", $_POST["tlink".$i])."'>".iconv("UTF-8", "cp1251", $_POST["tname".$i])."</a><br/>".iconv("UTF-8", "cp1251", $_POST["tintr".$i])." <a href='".iconv("UTF-8", "cp1251", $_POST["tlink".$i])."'>Читать далее</a></p>";
        }
    }
    $body.="<p>".iconv("UTF-8", "cp1251", $_POST["conclusion"])."</p>";
    $posting = new CPosting;
    $arFields = Array(
        "FROM_FIELD" => "root@webgk.net",
        "TO_FIELD" => "",
        "BCC_FIELD" => "",
        "EMAIL_FILTER" => "",
        "SUBJECT" => iconv("UTF-8", "cp1251", $_POST["mailtopick"]),
        "BODY_TYPE" => "html",
        "BODY" => $body,
        "DIRECT_SEND" => "Y",
        "CHARSET" => "Windows-1251",
        "SUBSCR_FORMAT" => "html",
        "RUB_ID" => "",
        "STATUS" => "D"
    );
    $ID = $posting->Add($arFields);
    if($ID == false)
        echo $posting->LAST_ERROR;
    else
        echo "1";
?>