<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<h2 class="nomer2">02</h2>
                    <div class="lozung2">Преимущества системы</div>
                     <div class="">
                      <img class="line2" src="/i/line2.png" alt="Линия"> 
                    </div>
                     <div>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <? //arShow($arItem); ?>
           <div class="props" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
           <? if($arItem['SORT']== 900) { ?>
           <div class="line"></div>
                       <div class="last_krug"><img src="/i/krug.png" alt=""></div>
                       <div class="goriz_line"></div>
                       <div class="vertical_line"></div>
                       <div class="border2"></div>
           
           <?} elseif($arItem['SORT']== 1000) {?>
           <div class="vertical_line2"></div>
                      <div class="goriz_line2"></div>
                      <div class="last_krug2"><img src="/i/krug.png" alt=""></div>
                      <div class="border"></div>
                      <div class="vertical_line3"></div>
           
           <?} else {?>
                    <div class="line"></div>
                    <div class="krug"><img src="/i/krug.png" alt=""></div>
                    
                    <?}?>
                        <div class="text">
                            <h2><?echo $arItem['NAME']?></h2> <br />
                            <p><?=$arItem['DETAIL_TEXT'];?></p> <br />
                        <div class="hr"></div>
                        </div>
                        <div class="image">
                            <img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" class='<? if($arItem['SORT']== 900) {echo "phone1"; } if($arItem['SORT']== 1000) {echo "iphone2"; } ?>' alt="">
                        </div> 
                    </div>
<?endforeach;?>

</div>