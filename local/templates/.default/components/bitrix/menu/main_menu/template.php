<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<?foreach($arResult as $arItem):?>
	<?//if($arItem["SELECTED"]):?>
		<div style="float: left;">
			<span style='color:#999999'>&nbsp;|&nbsp;&nbsp;</span>
			<a style="line-height: 200%;" href='<?=$arItem["LINK"]?>' class='gurn'><?=$arItem["TEXT"]?></a>
		</div>
	<?/*<?else:?>
		<div style="float: left;">
			<span style='color:#999999'>&nbsp;|&nbsp;&nbsp;</span>
			<a style="line-height: 200%;" href='<?=$arItem["LINK"]?>' class='gurn'><?=$arItem["TEXT"]?></a>
		</div>
	<?endif?>*/?>
<?endforeach?>
<?endif?>