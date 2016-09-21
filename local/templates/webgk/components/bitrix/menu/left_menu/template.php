<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>


<?foreach($arResult as $arItem):?>
	<?if($arItem["SELECTED"]):?>
		<span href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></span>
	<?else:?>
		<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
	<?endif?>
	
<?endforeach?>


<?endif?>