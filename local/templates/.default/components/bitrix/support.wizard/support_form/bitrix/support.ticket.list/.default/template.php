<?
  if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
  /*
  echo "<pre>";
  print_r($arResult["TICKETS"]);
  echo "</pre>";
  */
?>
<div align="right" class="add-new-div">
  <span id="show-filter" class="action">Показать фильтр</span>
  <span id="hide-filter" class="action">Скрыть фильтр</span>
  <a class="make-new-ticket" href="<?=$APPLICATION->GetCurPage()."?show_wizard=Y"?>">Создать новое обращение</a>
</div>
<div id="ticket-filter">
<form action="<?=$arResult["CURRENT_PAGE"]?>" method="get">
<table cellspacing="0" class="sticket-filter">
	<tbody>
	<tr>
		<td>
			<span class="tcaption"><?=GetMessage("SUP_F_ID")?>:</span>
			<input type="text" name="find_id" value="<?=htmlspecialchars($_REQUEST["find_id"])?>" />
			<br/>
			<span class="tcaption"><?=GetMessage("SUP_F_LAMP")?>:</span>
		<?
		$arLamp = Array(
			"red" => GetMessage("SUP_RED"),
			"green" => GetMessage("SUP_GREEN"),
			"grey" => GetMessage("SUP_GREY")
		);
		?>
		<select multiple="multiple" name="find_lamp[]" id="find_lamp" size="3">
		<?foreach ($arLamp as $value => $option):?>
				<option value="<?=$value?>" <?if(is_array($_REQUEST["find_lamp"]) && in_array($value, $_REQUEST["find_lamp"])):?>selected="selected"<?endif?>><?=$option?></option>
		<?endforeach?>
		</select>
		</td>
		<td>
      <span class="tcaption"><?=GetMessage("SUP_F_CLOSE")?>:</span>
			<?
				$arOpenClose= Array(
					"Y" => GetMessage("SUP_CLOSED"),
					"N" => GetMessage("SUP_OPENED"),
				);
			?>
			<select name="find_close" id="find_close">
				<option value=""><?=GetMessage("SUP_ALL")?></option>
			<?foreach ($arOpenClose as $value => $option):?>
				<option value="<?=$value?>" <?if(isset($_REQUEST["find_close"]) && $_REQUEST["find_close"] == $value):?>selected="selected"<?endif?>><?=$option?></option>
			<?endforeach?>
			</select>
			<br/>
      <span class="tcaption"><?=GetMessage("SUP_TITLE")?>:</span>
  		<input type="text" name="find_title" size="40" value="<?=htmlspecialchars($_REQUEST["find_title"])?>" />
  		<br/>
  		<span class="tcaption"><?=GetMessage("SUP_F_MESSAGE")?>:</span>
  		<input type="text" name="find_message" size="40" value="<?=htmlspecialchars($_REQUEST["find_message"])?>" />
		</td>
	</tr>
	</tbody>
	<tfoot>
	<tr>
		<td colspan="2" align="right">
			<input name="del_filter" value="Отмена" type="submit" class="fno" />
			<input name="set_filter" value="Найти" type="submit" class="fok" />
			<input name="set_filter" value="Y" type="hidden" />
		</td>
	</tr>
	</tfoot>
</table>
</form>
</div>
<? if(!count($arResult["TICKETS"])){ ?>
<div class="first-step">
  <h3>Добро пожаловать в личный кабинет клиента техподдержки WebGK!</h3>
  <p>У вас <strong>нет</strong> текущих обращений в техподдержку.</p>
  <p>Вы можете <a href="http://support.webgk.ru/?show_wizard=Y">создать первое обращение</a>.</p>
  <p>О том, как это сделать можно прочитать в разделе <a href="/howdoesitwork/">&laquo;Как это работает?&raquo; &rarr;</a></p>
</div>
<? } ?>
<div class="hr"></div>
<?if (strlen($arResult["NAV_STRING"]) > 0):?>
	<?=$arResult["NAV_STRING"]?><br /><br />
<?endif?>
<div class="tickets-table">
<table cellspacing="0" class="st-list">
  <tr>
    <th width="30">#</th>
    <th width="80"><?=SortingEx("s_lamp")?></th>
    <th>&nbsp;</th>
  </tr>
  <?foreach ($arResult["TICKETS"] as $arTicket):?>
	<tr>
		<td width="30" align="center" valign="middle" class="ticket_id"><?=$arTicket["ID"]?></td>
		<td valign="middle" align="center" width="80" class="tl-indicator">
			<div class="shadow-block shadow-<?=$arTicket["LAMP"]?>">
			  <div><?=intval($arTicket["MESSAGES"])?></div>
			  <span><?=GKPluralForm(intval($arTicket["MESSAGES"]))?></span>
			</div>
		</td>
		<td>
			<a href="<?=$arTicket["TICKET_EDIT_URL"]?>" title="<?=GetMessage("SUP_EDIT_TICKET")?>" class="ticket-title"><?=$arTicket["TITLE"]?></a>
			<?if (strlen(GKGetOrg($arTicket['OWNER_USER_ID']))){?>
			  <div class="tl-organisation"><span>Сайт: </span><a href="http://<?=GKGetOrg($arTicket['OWNER_USER_ID'])?>/" target="_blank" ><?=GKGetOrg($arTicket['OWNER_USER_ID'])?></a></div>
			<? } ?>
			<div class="tl-data"><?=$arTicket["TIMESTAMP_X"]?>
		  <?if (strlen($arTicket["MODIFIED_MODULE_NAME"])<=0 || $arTicket["MODIFIED_MODULE_NAME"]=="support"){?>
			  <span> от </span><?=$arTicket["MODIFIED_NAME"]?>
			<?}else{?>
			  <span> от </span><?=$arTicket["MODIFIED_MODULE_NAME"]?>
			<?}?>
			</div>
		</td>
	</tr>
	<?endforeach?>
</table>
</div>
<?if (strlen($arResult["NAV_STRING"]) > 0):?>
	<br /><?=$arResult["NAV_STRING"]?><br />
<?endif?>
<div class="hr"></div>
<table class="st-hint">
	<tr>
		<td>
		  <div class="shadow-block shadow-red shadow-small">
		  &nbsp;
		  </div>
		</td>
		<td>&mdash;&nbsp;&nbsp;есть ответ от техподдержки</td>
	</tr>
	<tr>
		<td>
		  <div class="shadow-block shadow-green shadow-small">
		</td>
		<td>&mdash;&nbsp;&nbsp;сообщение в стадии рассмотрения</td>
	</tr>
	<tr>
		<td>
		<div class="shadow-block shadow-grey shadow-small">
		</td>
		<td>&mdash;&nbsp;&nbsp;сообщение закрыто</td>
	</tr>
</table>