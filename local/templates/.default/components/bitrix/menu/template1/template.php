<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<div style="margin: 90px 40px 10px;">
<?foreach($arResult as $arItem):?>
	<div class="as">
		<a href="<?=$arItem["LINK"]?>" class="menr"><?=$arItem["TEXT"]?></a>
	</div>
<?endforeach?>
</div>
<?endif?>