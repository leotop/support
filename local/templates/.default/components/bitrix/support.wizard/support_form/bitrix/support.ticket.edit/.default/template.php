<a href="?" class="action back2mylist">&larr; Мои обращения</a><br/><br/>
<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
  $APPLICATION->AddHeadScript($this->GetFolder() . '/script.js');
  /*
  echo "<pre>";
  print_r($arResult);
  echo "</pre>";
  */
?>
<?=ShowError($arResult["ERROR_MESSAGE"]);?>
<? if (!empty($arResult["TICKET"])):?>
<!--
<?if (!empty($arResult["ONLINE"])):?>
<p>
	<?$time = intval($arResult["OPTIONS"]["ONLINE_INTERVAL"]/60)." ".GetMessage("SUP_MIN");?>
	<?=str_replace("#TIME#",$time,GetMessage("SUP_USERS_ONLINE"));?>:<br />
	<?foreach($arResult["ONLINE"] as $arOnlineUser):?>
	<small>(<?=$arOnlineUser["USER_LOGIN"]?>) <?=$arOnlineUser["USER_NAME"]?> [<?=$arOnlineUser["TIMESTAMP_X"]?>]</small><br />
	<?endforeach?>
</p>
<?endif?>
-->
<div class="ticket-caption">#<?=$arResult["TICKET"]["ID"]?> <?=$arResult["TICKET"]["TITLE"]?></div>
<div class="ticket-info">
Сообщение создано: <?=$arResult["TICKET"]["DATE_CREATE"]?><br/>
</div>
<div class="ticket-data"><?=count($arResult["MESSAGES"])?> <?=GKPluralForm(intval(count($arResult["MESSAGES"])))?></div>
<? $counter = 0; ?>
<?foreach ($arResult["MESSAGES"] as $arMessage):?>
<?
  $counter++;
  $add = "";
  if($arMessage["OWNER_LOGIN"] == $arResult["TICKET"]["CREATED_LOGIN"]){
  	$add = "owner";
  }else{
  	$add = "answer";
  }
?>
<div class="single-ticket <?=$add?>">
  <div class="st-info">
    <span>#<?=$counter?></span>
  </div>
  <div class="st-message"><?=$arMessage["MESSAGE"]?></div>
  <? if(count($arMessage["FILES"])){ ?>
    <?foreach ($arMessage["FILES"] as $arFile):?>
      <a title="<?=GetMessage("SUP_VIEW_ALT")?>" href="<?=$componentPath?>/ticket_show_file.php?hash=<?echo $arFile["HASH"]?>&amp;lang=<?=LANG?>"><?=$arFile["NAME"]?></a>
      <a title="<?=str_replace("#FILE_NAME#", $arFile["NAME"], GetMessage("SUP_DOWNLOAD_ALT"))?>" href="<?=$componentPath?>/ticket_show_file.php?hash=<?=$arFile["HASH"]?>&amp;lang=<?=LANG?>&amp;action=download"><?=GetMessage("SUP_DOWNLOAD")?></a><br/>
    <?endforeach?>
  <? } ?>
</div>
<div class="af <?=$add?>-footer"><?=$arMessage["OWNER_NAME"]?> (<?=$arMessage["DATE_CREATE"]?>)</div>
<?endforeach?>
<?=$arResult["NAV_STRING"]?>
<br />
<?endif;?>

<?/*arshow ($arResult)
$arResult["REAL_FILE_PATH"]*/?>

<form name="support_edit" method="post" action="<?=$arResult["REAL_FILE_PATH"]?>" enctype="multipart/form-data">
  <?=bitrix_sessid_post()?>
  <input type="hidden" name="set_default" value="Y" />
  <input type="hidden" name="ID" value=<?=(empty($arResult["TICKET"]) ? 0 : $arResult["TICKET"]["ID"])?> />
  <input type="hidden" name="lang" value="<?=LANG?>" />
  <div class="ticket-edit-form">
    <?if (empty($arResult["TICKET"])):?>
      <div class="tef-caption-main"><?=GetMessage("SUP_TICKET")?></div>
      <div class="tef-caption"><?=GetMessage("SUP_TITLE")?></div>
		  <input type="text" name="TITLE" value="<?=$_REQUEST[wizard][wz_title];?>" class="tef-title" />
	  <?else:?>
		  <div class="tef-caption-main"><?=GetMessage("SUP_ANSWER")?></div>
	  <?endif?>

	  <?if (strlen($arResult["TICKET"]["DATE_CLOSE"]) <= 0):?>
	    <div class="tef-caption"><?=GetMessage("SUP_MESSAGE")?></div>
	    <div class="tef-buttons">
			  <input type="button" accesskey="b" value="<?=GetMessage("SUP_B")?>" onClick="insert_tag('B', document.forms['support_edit'].elements['MESSAGE'])"  name="B" title="<?=GetMessage("SUP_B_ALT")?> (alt + b)" />
			  <input type="button" accesskey="i" value="<?=GetMessage("SUP_I")?>" onClick="insert_tag('I', document.forms['support_edit'].elements['MESSAGE'])" name="I" title="<?=GetMessage("SUP_I_ALT")?> (alt + i)" />
			  <input type="button" accesskey="u" value="<?=GetMessage("SUP_U")?>" onClick="insert_tag('U', document.forms['support_edit'].elements['MESSAGE'])" name="U" title="<?=GetMessage("SUP_U_ALT")?> (alt + u)" />
			  <input type="button" accesskey="q" value="Цитата" onClick="insert_tag('QUOTE', document.forms['support_edit'].elements['MESSAGE'])" name="QUOTE" title="<?=GetMessage("SUP_QUOTE_ALT")?> (alt + q)" />
			  <input type="button" accesskey="c" value="Код" onClick="insert_tag('CODE', document.forms['support_edit'].elements['MESSAGE'])" name="CODE" title="<?=GetMessage("SUP_CODE_ALT")?> (alt + c)" />
			   <?if (LANG == "ru"):?>
			    <input type="button" accesskey="t" value="<?=GetMessage("SUP_TRANSLIT")?>" onClick="translit(document.forms['support_edit'].elements['MESSAGE'])" name="TRANSLIT" title="<?=GetMessage("SUP_TRANSLIT_ALT")?> (alt + t)" />
			  <?endif?>
      </div>

      <div class="tef-message"><textarea name="MESSAGE" id="MESSAGE" rows="20" cols="45" wrap="virtual"><?=htmlspecialchars($_REQUEST["MESSAGE"])?></textarea></div>

      <div class="tef-attach">
			  <div class="tef-caption"><?=GetMessage("SUP_ATTACH")?></div>
			  <div class="tef-caption-info">(max - <?=$arResult["OPTIONS"]["MAX_FILESIZE"]?> <?=GetMessage("SUP_KB")?>)</div>
			  <input type="hidden" name="MAX_FILE_SIZE" value="<?=($arResult["OPTIONS"]["MAX_FILESIZE"]*1024)?>">
			  <input name="FILE_0" size="30" type="file" /> <br />
			  <input name="FILE_1" size="30" type="file" /> <br />
			  <input name="FILE_2" size="30" type="file" /> <br />
			  <span id="files_table_2"></span>
			  <input type="button" value="<?=GetMessage("SUP_MORE")?>" OnClick="AddFileInput('<?=GetMessage("SUP_MORE")?>')" />
			  <input type="hidden" name="files_counter" id="files_counter" value="2" />
	    </div>
	  <?endif?>

	  <?if (empty($arResult["TICKET"])):?>
	    <div class="tef-category">
		    <div class="tef-caption"><?=GetMessage("SUP_CATEGORY")?></div>
			  <?
			    if (strlen($arResult["DICTIONARY"]["CATEGORY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0 && !$_POST["CATEGORY_ID"])
				    $category = $arResult["DICTIONARY"]["CATEGORY_DEFAULT"];
			    else
				    $category = htmlspecialchars($_POST["CATEGORY_ID"]);
			  ?>
			  <select name="CATEGORY_ID" id="CATEGORY_ID">
		    <?foreach ($arResult["DICTIONARY"]["CATEGORY"] as $value => $option):?>
				  <option value="<?=$value?>" <?if($category == $value):?>selected="selected"<?endif?>><?=$option?></option>
			  <?endforeach?>
			  </select>
	    </div>
	  <?else:?>
	    <!-- div class="tef-mark">
		    <div class="tef-caption"><?=GetMessage("SUP_MARK")?></div>
			  <?$mark = (strlen($arResult["ERROR_MESSAGE"]) > 0 ? htmlspecialchars($_REQUEST["MARK_ID"]) : $arResult["TICKET"]["MARK_ID"]);?>
			  <select name="MARK_ID" id="MARK_ID">
				<?foreach ($arResult["DICTIONARY"]["MARK"] as $value => $option):?>
				  <option value="<?=$value?>" <?if($mark == $value):?>selected="selected"<?endif?>><?=$option?></option>
			  <?endforeach?>
			  </select>
	    </div -->
	  <?endif?>

	  <?if (strlen($arResult["TICKET"]["DATE_CLOSE"])<=0):?>
	    <div class="tef-close">
		    <div class="tef-caption"><?=GetMessage("SUP_CLOSE_TICKET")?> <input type="checkbox" name="CLOSE" value="Y" <?if($arResult["TICKET"]["CLOSE"] == "Y"):?>checked="checked" <?endif?>/></div>
	    </div>
	  <?else:?>
	    <div class="tef-open">
		    <div class="tef-caption"><?=GetMessage("SUP_OPEN_TICKET")?> <input type="checkbox" name="OPEN" value="Y" <?if($arResult["TICKET"]["OPEN"] == "Y"):?>checked="checked" <?endif?>/></div>
	    </div>
	  <?endif;?>
  </div>
  <div class="tef-downbyttons">
    <input type="submit" name="save" value="<?=GetMessage("SUP_SAVE")?>" />&nbsp;
    <input type="submit" name="apply" value=<?=GetMessage("SUP_APPLY")?> />&nbsp;
    <input type="reset" value="<?=GetMessage("SUP_RESET")?>" />
    <input type="hidden" value="Y" name="apply" />
  </div>
</form>
