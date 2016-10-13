<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (is_array($arResult["DATES"])) {?>      
    <form method="post" class="work-report-form">
        <p><?=GetMessage("FORM_TITLE")?></p>
        <p style="color: green"><?=GetMessage("YOUR_WORK_NORM")?>: <b><?=$arResult["USER_NORM"]?></b></p>
        <hr />
        <?foreach ($arResult["DATES"] as $date) {?>
            <div class="work-day-header"><?=GetMessage("WORK_DAY")?>: <b><?=$date["DATE"]?></b> (<?=GetMessage("WORK_HOURS")?>: <?=$date["TIME"]?>)</div>    
            <textarea name="work-report[<?=$date["DATE"]?>]"></textarea>
            <input type="hidden" name="work-report-time[<?=$date["DATE"]?>]" value="<?=$date["TIME"]?>">
            <hr />
            <?}?>
        <p>*<?=GetMessage("FORM_WARNING")?></p>

        <input type="submit" value="<?=GetMessage("SUBMIT_FORM")?>" disabled="disabled" id="submit-report">
        <input type="hidden" name="submit-reports" value="Y">
    </form>
    <?}?>