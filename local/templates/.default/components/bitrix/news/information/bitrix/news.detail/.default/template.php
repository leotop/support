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
            <!-- left_tab block -->
            <div class="tab_blocks">
                <div class="left_tab_blocks">
                    <img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="img-01" style="">
                     <div class="order_now1">
                        <a href="/forms/want_site_form.php?TYPE=<?=$value["ID"]?>" class="fancybox">заказать прямо сейчас</a>
                    </div>
                </div>
                
                <div class="right_tab_blocks">
                    <!-- tab title -->
                    <h1 class="tab_title"><?=$arResult['NAME']?></h1>
                    <div class="tab_text">
                      <?=$arResult["DETAIL_TEXT"];?>        
                    </div>
                   
                </div>
            </div>

