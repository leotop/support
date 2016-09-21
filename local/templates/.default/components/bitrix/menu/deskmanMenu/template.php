<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
    <? 
        Cmodule::IncludeModule("webgk.support");  
        global $USER;
        //Get id group of support emloyee's 
        $supportId = GKSupportUsers::GetSupportEmployerGroupID();

        //Forming array of urls shows fo admin
        $urlForAdmins = array("/load/", "/staff/", "/client/"); ?>

    <ul class="deskmanMenu">
        <?foreach($arResult as $arItem):?>
            <? if (in_array($arItem["LINK"], $urlForAdmins)) { 
                    if ($USER->IsAdmin() || in_array($supportId, $USER->GetUserGroupArray())) {  ?>
                    <li><a href="<?=$arItem["LINK"]?>" class="menr"><?=$arItem["TEXT"]?></a></li>
                    <?}
                } else { ?>
                <li><a href="<?=$arItem["LINK"]?>" class="menr"><?=$arItem["TEXT"]?></a></li>
                <? } ?>             
            <?endforeach?>
    </ul>
    <?endif?>