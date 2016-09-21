<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<a href="?" class="action back2mylist">&larr; <?=GetMessage('WZ_TICKET_LIST')?></a>
<br/><br/>
<form method="post"  action="<?=POST_FORM_ACTION_URI?>" name="wizard">
<input type=hidden name=LAST_SECTION_ID value="<?=$arResult['LAST_SECTION_ID']?>">
<input type=hidden name=CURRENT_STEP value="<?=$arResult['CURRENT_STEP']?>">

<?
/*
echo "<pre>";
print_r($arResult);
echo "</pre>";
*/

if ($arResult['ERROR'])
	echo '<div><font class=wizard_errortext>'.$arResult['ERROR'].'</font></div>';
elseif($arResult['MESSAGE'])
	echo '<div><font class=wizard_oktext>'.$arResult['MESSAGE'].'</font></div>';


?>
		<div class="tef-caption-main">Создание обращения</div>
		<?
		if ($arResult['TOP_MESSAGE'])
			echo "<div class=wizard_smalltext>".$arResult['TOP_MESSAGE']."</div>";
		?>
<?
?>
		<div class="ticket-edit-form">
			<?
			//if (count($arResult['FIELDS']))
			if (0)
			{
				$i=0;
				foreach($arResult['FIELDS'] as $num=>$f)
				{
					if (trim($f['DETAIL_TEXT']))
					{
						$i++;
						$link = '&nbsp;<a href="#note'.$i.'"><sup>'.$i.'</sup></a>';
						$arHelp[$i] = $f['DETAIL_TEXT'];
					}
					else
						$link = '';


					$id = $f['FIELD_ID'];

					if ($f['FIELD_TYPE']=='text') // simple input field
						echo '<div class="tef-caption">' . $f['NAME'] . ':</div>' .
								'<input class="tef-title" name="wizard['.$id.']" size=50 value="'.$f['FIELD_VALUE'].'">' .
									'<br><font class=smalltext>' . $f['PREVIEW_TEXT'] . $link . '</font>';
					elseif ($f['FIELD_TYPE']=='checkbox') // checkbox
						echo '<div class="tef-caption"><input type=checkbox value="'.GetMessage('WZ_YES').'" name="wizard['.$id.']" '.($f['FIELD_VALUE']?'checked':'').' id="'.$id.'">' .
							'<label for="'.$id.'"><b>' . $f['NAME'] . '</b></label></div>' .
								'<font class=smalltext>' . $f['PREVIEW_TEXT'] . $link . '</font>';
					elseif ($f['FIELD_TYPE']=='select') // select box
					{
						echo 	'<div class="tef-caption">' . $f['NAME'] . ':</div>' .
								'<select name="wizard['.$id.']">';

							foreach($f['FIELD_VALUES'] as $v)
								echo '<option value="'.$v.'" '.($f['FIELD_VALUE']==$v?'selected':'').'>'.$v.'</option>';

						echo ' </select>' .
								'<br><font class=smalltext>' . $f['PREVIEW_TEXT'] . $link . '</font>';
					}
					elseif ($f['FIELD_TYPE']=='radio') // radio box
					{
						echo 	'<div class="tef-caption">' . $f['NAME'] . ':</div>' .
								'<table cellspacing=2 cellpadding=0 border=0>';
							foreach($f['FIELD_VALUES'] as $k=>$v)
								echo '<tr><td align=left><input type=radio name="wizard['.$id.']" value="'.$v.'" '.($f['FIELD_VALUE']==$v?'checked':'').' id="'.$id.'_'.$k.'"><label for="'.$id.'_'.$k.'"> '.$v.'</label></td></tr>';
						echo	'</table><font class=smalltext>' . $f['PREVIEW_TEXT'] . $link . '</font>';
					}
					elseif ($f['FIELD_TYPE']=='multitext') // input options
					{
						echo 	'<div class="tef-caption">' . $f['NAME'] . ':</div>' .
								'<table cellspacing=2 cellpadding=0 border=0>';
							foreach($f['FIELD_VALUES'] as $k=>$v)
								echo '<tr><td align=right>'.$v.':</td><td><input name="wizard['.$id.']['.$k.']" value="'.($f['FIELD_VALUE'][$k]).'"></td></tr>';
						echo	'</table><font class=smalltext>' . $f['PREVIEW_TEXT'] . $link . '</font>';
					}
					else // textarea, default
						echo 	'<div class="tef-caption">' . $f['NAME'] . ':</div>' .
								'<textarea name="wizard['.$id.']" rows=10 cols=50>'.$f['FIELD_VALUE'].'</textarea>' .
									'<br><font class=smalltext>' . $f['PREVIEW_TEXT'] . $link . '</font>';

					unset($arResult['FIELDS'][$field_num]['FIELD_VALUE']);
				}
			}

			if (count($arResult['SECTIONS']))
			{
				echo '<div class="tef-sections">';
				foreach($arResult['SECTIONS'] as $f)
				{
					$id = $f['ID'];
					echo "<div class=wizard_sections align=left><input type=radio name=SECTION_ID value='$id' id='section_$id'> <label for='section_$id'><font class=text>".$f['NAME']."</font></label></div>";
				}
				echo '</div>';
			}

?>
<div class="tef-text">
  <strong>Информационная поддержка</strong><br/>
  Создание и размещение текстовой, графической и другой информации на сайте.
  <br/><br/>
  <strong>Техническая поддержка</strong><br/>
  Добавление нового и поддержка работающего на сайте функционала.
</div>
<div class="tef-category">
		    <div class="tef-caption">Тип обращения</div>
			  			  <select name="CATEGORY_ID" id="CATEGORY_ID">
		    				  <option value="20" >Информационная поддержка</option>
			  				  <option value="21" >Техническая поддержка</option>
			  			  </select>
	    </div>
		<div class="tef-downbyttons">
		<? if (count($arResult['SECTIONS'])) { ?>
			<? if ($arResult['CURRENT_STEP']>1) { ?>
				<input type=submit name="back" value="&larr; Назад">
			<? } elseif ($arParams['BACK_URL']) {?>
				<input type=submit value="&larr; Назад" onclick="javascript:window.location='<?=$arParams['BACK_URL']?>';return false;">
			<? } ?>
			<input type=submit value="Далее &rarr;" name="next">
		<? } else { // Finish ?>
			<input type=submit value="&larr; Назад" name="back">
			<input type=submit value="Далее &rarr;" name="end_wizard">
		<? } ?>
		</div>
<?
	if (count($arResult['HIDDEN']))
	{
		foreach($arResult['HIDDEN'] as $k=>$v)
		{
			if (is_array($v))
				foreach($v as $k1=>$v1)
					echo '<input type=hidden name="wizard['.$k.']['.$k1.']" value="'.$v1.'">';
			else
				echo '<input type=hidden name="wizard['.$k.']" value="'.$v.'">';
		}
	}
?>
</form>
</div>