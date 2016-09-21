<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>


<?foreach($arResult as $arItem):?>
	<?if($arItem["SELECTED"]):?>
		<span id='no_activ_mm'><?=$arItem["TEXT"]?></span>
	<?else:?>
		<a class='ref_main_menu' href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
	<?endif?>
	
<?endforeach?>


<?endif?>