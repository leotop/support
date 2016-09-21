<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<br/>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
<?echo bitrix_sessid_post();?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
<tr valign="top">
	<td width="90%">
		<input type="hidden" name="SUBSCR_CONFIRM" value="Y" />
		<p><?echo GetMessage("subscr_email")?><span class="starrequired">*</span><br />
		<input type="text" name="EMAIL" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"];?>" size="50" maxlength="255" /></p>
    <?
      $arResult["SUBSCRIPTION"]["EMAIL"]!="" ? $email = $arResult["SUBSCRIPTION"]["EMAIL"] : $email = $arResult["REQUEST"]["EMAIL"];

      $GKSubscriber = GKGetSubscriber($email);

      $name = $_POST["sf_NAME"];
      $company = $_POST["sf_COMPANY"];

      if($GKSubscriber){
        $name = $GKSubscriber["ORGANIZATION"]["VALUE"];
        $company = $GKSubscriber["CONTACT"]["VALUE"];
      }
    ?>
		<p>Ф.И.О.:<br />
		<input type="text" name="sf_NAME" value="<?=$name?>" size="50" maxlength="255" /></p>

		<p>Компания:<br />
		<input type="text" name="sf_COMPANY" value="<?=$company?>" size="50" maxlength="255" /></p>


		<p><?echo GetMessage("subscr_rub")?><span class="starrequired">*</span><br />
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<label><input type="checkbox" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> />&nbsp;&nbsp;<?=$itemValue["NAME"]?></label><br/>
		<?endforeach;?></p>
<p><?echo GetMessage("subscr_settings_note1")?><br/>
<?echo GetMessage("subscr_settings_note2")?></p>
	</td>
</tr>
<tfoot><tr><td colspan="2">
<br/>
<input type="submit" name="Save" value="Подтвердить" />
	<input type="reset" value="<?echo GetMessage("subscr_reset")?>" name="reset" />
</td></tr></tfoot>
</table>
<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?if($_REQUEST["register"] == "YES"):?>
	<input type="hidden" name="register" value="YES" />
<?endif;?>
<?if($_REQUEST["authorize"]=="YES"):?>
	<input type="hidden" name="authorize" value="YES" />
<?endif;?>

<input type="hidden" name="FORMAT" id="MAIL_TYPE_TEXT" value="text" />
<input type="hidden" name="FORMAT" id="MAIL_TYPE_HTML" value="html" checked />

</form>
<br />
