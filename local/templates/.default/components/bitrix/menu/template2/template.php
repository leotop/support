<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true)?>
<?if (!empty($arResult)):?>
    <ul>

        <?  foreach($arResult as $arItem):
            //arshow($arItem);
           
            if ($arItem["SELECTED"]==1){
             ?><li class="active"> 
             <?=$arItem["TEXT"]?>
            </li>          
                
            <?}
            else {
            ?> <li> 
                <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
            </li>           
           <? }
            ?> 
            
            <?endforeach?>
       
       <li class="menu_last_cell"> 
           <?$APPLICATION->IncludeFile(SITE_DIR."/include/phone.php",Array(),Array("MODE"=>"html"));?>
        </li>
    </ul>
    <?endif?>