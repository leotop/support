<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="subscribe-form">
<form method="POST" action="<?=$arResult["FORM_ACTION"]?>" id="subscribe-form-validate" >
<!--
<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
	<label for="sf_RUB_ID_<?=$itemValue["ID"]?>">
	<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /> <?=$itemValue["NAME"]?>
	</label><br />
<?endforeach;?>
-->


	<table border="0" align="left" class="subscribe-form">
		<tr>
			<td valign="middle">E-mail:<span class="starrequired">*</span></td>
			<td valign="middle">
			  <input type="text" name="sf_EMAIL" id="sf_EMAIL" class="validate[required]" size="50" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>"/>
			</td>
    </tr>
    <tr>
			<td valign="middle">Ф.И.О:</td>
			<td valign="middle">
			  <input type="text" name="sf_NAME" id="sf_NAME" size="50" value="" />
			</td>
    </tr>
    <tr>
			<td valign="middle">Компания:</td>
			<td valign="middle">
			  <input type="text" name="sf_COMPANY" id="sf_COMPANY" size="50" value="" />
			</td>
    </tr>
    <tr>
      <td valign="middle"></td>
      <td align="left" valign="middle" style="padding-top:15px;" class="authorize-submit-cell">
        <input type="submit" name="OK" value="Войти / подписаться" />
      </td>
		</tr>
	</table>
</form>
</div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
&nbsp;
<script type="text/javascript">
  $(document).ready(function() {
    $("#subscribe-form-validate").validationEngine()
  });
</script>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>&nbsp;