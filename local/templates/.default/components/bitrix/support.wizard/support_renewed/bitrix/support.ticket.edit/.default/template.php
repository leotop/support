<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>      
<?
    $APPLICATION->AddHeadScript($this->GetFolder() . '/script.js');
    
    CModule::IncludeModule("webgk.support");
?>

<?if (in_array(8, $USER->GetUserGroupArray())){?> 

    <script type="text/javascript">

        <? if($_POST["NEW_TICKET"]==1) {?>

            function check_status() {
                $("#ticket-form").submit();
            }

            <?} else {?>
            //�������� �� ��������� ������ ��� ����������� ���������
            function check_status() {  
                //alert($("#MESSAGE").val());           
                if(!($("#MESSAGE").val()=="")) {

                    if (!($("#STATUS_SID").val()=='D' || $("#STATUS_SID").val()=='G' || $("#STATUS_SID").val()=='L' || $("#STATUS_SID").val()=='B') ) {
                        if ($("#STATUS_SID").val() == 'W' && $("#saveStatus").prop("checked") == true) {     //��� ���������� ������� "� ������" ���������� ��������� �������
                            check_time();  
                        }
                        else {
                            alert('���������� ������ "��������", "��������� ��������� �������", "�������", ���� "����������"');
                            return false;
                        }
                    }  else {  
                        check_time();
                    }
                } else {
                    check_time();
                }
            }

            <?}?>

        function check_time() {
            if($("#STATUS_SID").val()=='G') {
                if($("#SPEND_TIME").val()=='') {
                    alert('���� "����������� �����" �� ������ ���� ������');
                    return false;
                } else { 
                    $("#ticket-form").submit();
                }
            } else { 
                $("#ticket-form").submit();
            }
        }           



        $(function(){

            $("#save").click(function(){
                $(".type-butt").attr("name", "save");  
                check_status();                                                                                   
            })

            $("#apply").click(function(){
                $(".type-butt").attr("name", "apply"); 
                check_status();                                          
            })
        })




    </script> 
    <? }?>    

<?=ShowError($arResult["ERROR_MESSAGE"]);?>
<a href="/">����� � ������</a>
<br>
<br>
<h5>����� �<?=$arResult["TICKET"]["ID"]?>. <span style="text-transform: lowercase;"><?=$arResult["TICKET"]["TITLE"]?></span></h5>
<form name="support_edit" method="POST" action="<?=$arResult["REAL_FILE_PATH"]?>" enctype="multipart/form-data" name="ticket-form" id="ticket-form">
    <!--<input type="hidden" name="UPDATE_TICKET" value="Y">-->
    <?//arshow($arResult["TICKET"]); 
        //arshow($_POST)?> 
    <input type="hidden" name="author" value="<?=$_POST['ticket_author']?>">
    <script type="text/javascript">BX.loadCSS('<? echo CUtil::JSEscape( $this->GetFolder() ); ?>/style.css');</script>

    <table class="support-ticket-edit-form data-table">

        <?if (empty($arResult["TICKET"])):?>
            <thead>
                <tr>
                    <th colspan="2"><?=GetMessage("SUP_TICKET")?></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="field-name border-none"><?=GetMessage("SUP_TITLE")?>:</td>
                    <td class="border-none"><input type="text" name="TITLE" value="<?=htmlspecialcharsbx($_REQUEST["wizard"]["wz_title"])?>" size="100" maxlength="255" /></td>
                </tr>
                <?else:?>

                <tr>
                    <th colspan="2"><?=GetMessage("SUP_ANSWER")?></th>
                </tr>

                <?endif?>


            <?if (strlen($arResult["TICKET"]["DATE_CLOSE"]) <= 0):?>
                <tr>
                    <td class="field-name"><?=GetMessage("SUP_MESSAGE")?>:</td>
                    <td>
                        <input accesskey="b" type="button" value="<?=GetMessage("SUP_B")?>" onClick="insert_tag('B', document.forms['support_edit'].elements['MESSAGE'])"  name="B" id="B" title="<? echo GetMessage("SUP_B_ALT"); ?>" />
                        <input accesskey="i" type="button" value="<?=GetMessage("SUP_I")?>" onClick="insert_tag('I', document.forms['support_edit'].elements['MESSAGE'])" name="I" id="I" title="<? echo GetMessage("SUP_I_ALT"); ?>" />
                        <input accesskey="u" type="button" value="<?=GetMessage("SUP_U")?>" onClick="insert_tag('U', document.forms['support_edit'].elements['MESSAGE'])" name="U" id="U" title="<? echo GetMessage("SUP_U_ALT"); ?>" />
                        <input accesskey="q" type="button" value="<?=GetMessage("SUP_QUOTE")?>" onClick="insert_tag('QUOTE', document.forms['support_edit'].elements['MESSAGE'])" name="QUOTE" id="QUOTE" title="<? echo GetMessage("SUP_QUOTE_ALT"); ?>" />
                        <input accesskey="c" type="button" value="<?=GetMessage("SUP_CODE")?>" onClick="insert_tag('CODE', document.forms['support_edit'].elements['MESSAGE'])" name="CODE" id="CODE" title="<? echo GetMessage("SUP_CODE_ALT"); ?>" />
                        <?if (LANG == "ru"):?>
                            <input accesskey="t" type="button" accesskey="t" value="<?=GetMessage("SUP_TRANSLIT")?>" onClick="translit(document.forms['support_edit'].elements['MESSAGE'])" name="TRANSLIT" id="TRANSLIT" title="<? echo GetMessage("SUP_TRANSLIT_ALT"); ?>" />
                            <?endif?>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td><textarea name="MESSAGE" id="MESSAGE" rows="5" cols="150" wrap="virtual"><?=htmlspecialcharsbx($_REQUEST["MESSAGE"])?></textarea></td>
                </tr>


                <tr>
                    <td class="field-name">
                        <?=GetMessage("SUP_ATTACH")?><br />
                        (max - <?=$arResult["OPTIONS"]["MAX_FILESIZE"]?> <?=GetMessage("SUP_KB")?>):
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?=($arResult["OPTIONS"]["MAX_FILESIZE"]*1024)?>">
                    </td>
                    <td>
                        <input name="FILE_0" size="30" type="file" /> <br />
                        <input name="FILE_1" size="30" type="file" /> <br />
                        <input name="FILE_2" size="30" type="file" /> <br />
                        <span id="files_table_2"></span>
                        <input type="button" value="<?=GetMessage("SUP_MORE")?>" OnClick="AddFileInput('<?=GetMessage("SUP_MORE")?>')" />
                        <input type="hidden" name="files_counter" id="files_counter" value="2" />
                    </td>
                </tr>
                <?endif?>


            <tr>
                <td class="field-name"><?=GetMessage("SUP_CRITICALITY")?>:</td>
                <td>
                    <?
                        if (empty($arResult["TICKET"]) || strlen($arResult["ERROR_MESSAGE"]) > 0 )
                        {
                            if (strlen($arResult["DICTIONARY"]["CRITICALITY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0)
                                $criticality = $arResult["DICTIONARY"]["CRITICALITY_DEFAULT"];
                            else
                                $criticality = htmlspecialcharsbx($_REQUEST["CRITICALITY_ID"]);
                        }
                        else
                            $criticality = $arResult["TICKET"]["CRITICALITY_ID"];
                    ?>
                    <select name="CRITICALITY_ID" id="CRITICALITY_ID">
                        <!--                        <option value="">&nbsp;</option>-->
                        <?foreach ($arResult["DICTIONARY"]["CRITICALITY"] as $value => $option):?>
                            <option value="<?=$value?>" <?if($criticality == $value):?>selected="selected"<?endif?>><?=$option?></option>
                            <?endforeach?>
                    </select>
                </td>
            </tr>

            <?if (empty($arResult["TICKET"])):?>
                <tr>
                    <td class="field-name"><?=GetMessage("SUP_CATEGORY")?>:</td>
                    <td>
                        <?
                            if (strlen($arResult["DICTIONARY"]["CATEGORY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0)
                                $category = $arResult["DICTIONARY"]["CATEGORY_DEFAULT"];
                            else
                                $category = htmlspecialcharsbx($_REQUEST["CATEGORY_ID"]);
                        ?>
                        <select name="CATEGORY_ID" id="CATEGORY_ID">
                            <?/*<option value="">&nbsp;</option> */?>
                            <?foreach ($arResult["DICTIONARY"]["CATEGORY"] as $value => $option):?>
                                <option value="<?=$value?>" <?if($category == $value):?>selected="selected"<?endif?>><?=$option?></option>
                                <?endforeach?>
                        </select>
                    </td>
                </tr>
                <?else:?>
                <tr>
                    <td class="field-name"><?=GetMessage("SUP_MARK")?>:</td>
                    <td>
                        <?$mark = (strlen($arResult["ERROR_MESSAGE"]) > 0 ? htmlspecialcharsbx($_REQUEST["MARK_ID"]) : $arResult["TICKET"]["MARK_ID"]);?>
                        <select name="MARK_ID" id="MARK_ID">
                            <option value="">&nbsp;</option>
                            <?foreach ($arResult["DICTIONARY"]["MARK"] as $value => $option):?>
                                <option value="<?=$value?>" <?if($mark == $value):?>selected="selected"<?endif?>><?=$option?></option>
                            <?endforeach?>
                    </select>
                </td>
            </tr>
            <?endif?>



            <?if (strlen($arResult["TICKET"]["DATE_CLOSE"])<=0):?>
                <tr>
                    <td class="field-name"><?=GetMessage("SUP_CLOSE_TICKET")?>:</td>
                    <td><input type="checkbox" name="CLOSE" value="Y" <?if($arResult["TICKET"]["CLOSE"] == "Y"):?>checked="checked" <?endif?>/>
                    </td>
                </tr>
                <?else:?>
                <tr>
                    <td  class="field-name"><?=GetMessage("SUP_OPEN_TICKET")?>:</td>
                    <td><input type="checkbox" name="OPEN" value="Y" <?if($arResult["TICKET"]["OPEN"] == "Y"):?>checked="checked" <?endif?>/>
                </td>
            </tr>
            <?endif;?>
            <?if ($arParams['SHOW_COUPON_FIELD'] == 'Y' && $arParams['ID'] <= 0){?>
                <tr>
                    <td  class="field-name"><?=GetMessage("SUP_COUPON")?>:</td>
                    <td><input type="text" name="COUPON" value="<?=htmlspecialcharsbx($_REQUEST["COUPON"])?>" size="100" maxlength="255" />
                    </td>
                </tr>
                <?}?>
            <?
                global $USER_FIELD_MANAGER;
                if( isset( $arParams["SET_SHOW_USER_FIELD_T"] ) )
                {
                    //foreach( $arParams["SET_SHOW_USER_FIELD_T"] as $k => $v )
                    //                    {
                    //                        $v["ALL"]["VALUE"] = $arParams[$k];
                    //                        echo '<tr><td  class="field-name">' . htmlspecialcharsbx( $v["NAME_F"] ) . ':</td><td>';
                    //                        $APPLICATION->IncludeComponent(
                    //                            'bitrix:system.field.edit',
                    //                            $v["ALL"]['USER_TYPE_ID'],
                    //                            array(
                    //                                'arUserField' => $v["ALL"],
                    //                            ),
                    //                            null,
                    //                            array('HIDE_ICONS' => 'Y')
                    //                        );
                    //                        echo '</td></tr>';
                    //                    }
                }
            ?>

        </tbody>
    </table>
    <br />

    <?if (in_array(8, $USER->GetUserGroupArray())){?>

        <input type="button" id="save" name="save" value="<?=GetMessage("SUP_SAVE")?>" />&nbsp;
        <input type="button" id="apply" name="apply" value="<?=GetMessage("SUP_APPLY")?>"/>&nbsp;
        <input type="reset" value="<?=GetMessage("SUP_RESET")?>"/>
        <input class="type-butt" type="hidden" value="Y" />
        <?
        } else {
        ?>
        <input type="submit" id="save" name="save" value="<?=GetMessage("SUP_SAVE")?>" />&nbsp;
        <input type="submit" id="apply" name="apply" value="<?=GetMessage("SUP_APPLY")?>"/>&nbsp;
        <input type="reset" value="<?=GetMessage("SUP_RESET")?>"/>
        <!--<input type="hidden" value="Y" name="apply" />-->
        <?
        }
    ?>

    <?
        /*$hkInst=CHotKeys::getInstance();
        $arHK = array("B", "I", "U", "QUOTE", "CODE", "TRANSLIT");
        foreach($arHK as $n => $s)
        {
        $arExecs = $hkInst->GetCodeByClassName("TICKET_EDIT_$s");
        echo $hkInst->PrintJSExecs($arExecs);
        }*/

        if (!empty($arResult["TICKET"])):
        ?>


        <?
            if (!empty($arResult["ONLINE"]))
            {
            ?>
            <p>
                <?$time = intval($arResult["OPTIONS"]["ONLINE_INTERVAL"]/60)." ".GetMessage("SUP_MIN");?>
                <?=str_replace("#TIME#",$time,GetMessage("SUP_USERS_ONLINE"));?>:<br />
                <?foreach($arResult["ONLINE"] as $arOnlineUser):?>
                    <small><?=$arOnlineUser["USER_NAME"]?> [<?=FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arOnlineUser["TIMESTAMP_X"]))?>]</small><br />
                    <?endforeach?>
            </p>
            <?
            }
        ?>


        <table class="support-ticket-edit data-table">

            <tr>
                <th><?=GetMessage("SUP_TICKET")?></th>
            </tr>

            <tr>
                <td>


                    <?=GetMessage("SUP_CREATE")?>: <?=FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arResult["TICKET"]["DATE_CREATE"]))?>

                    <?if (strlen($arResult["TICKET"]["CREATED_MODULE_NAME"])<=0 || $arResult["TICKET"]["CREATED_MODULE_NAME"]=="support"):?>
                        <?=$arResult["TICKET"]["CREATED_NAME"]?>
                        <?else:?>
                        <?=$arResult["TICKET"]["CREATED_MODULE_NAME"]?>
                        <?endif?>
                    <br />


                    <?if ($arResult["TICKET"]["DATE_CREATE"]!=$arResult["TICKET"]["TIMESTAMP_X"]):?>
                        <?=GetMessage("SUP_TIMESTAMP")?>: <?=FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arResult["TICKET"]["TIMESTAMP_X"]))?>

                        <?if (strlen($arResult["TICKET"]["MODIFIED_MODULE_NAME"])<=0 || $arResult["TICKET"]["MODIFIED_MODULE_NAME"]=="support"):?>
                            <?=$arResult["TICKET"]["MODIFIED_BY_NAME"]?>
                            <?else:?>
                            <?=$arResult["TICKET"]["MODIFIED_MODULE_NAME"]?>
                            <?endif?>

                        <br />
                        <?endif?>


                    <?=GetMessage("SUP_STATUS")?>: 
                    <?if (in_array(8, $USER->GetUserGroupArray())){?>
                        <?  
                            //�������� ������������� �� ������ "���������� ������������"
                            $statuses = CTicketDictionary::GetList($by="id",$order="asc",array("TYPE"=>"S"));  
                            //while($ar = $statuses->Fetch()) {
                            //                                arshow($ar);
                            //                            }
                        ?>
                        <select name="STATUS_SID" id="STATUS_SID">
                            <option value="0">-</option>
                            <? while($arStatus = $statuses->Fetch()) {?>
                                <option value="<?=$arStatus["SID"]?>" <?if ($arResult["TICKET"]["STATUS_ID"] == $arStatus["ID"]){?> selected="selected"<?}?>><?=$arStatus["NAME"]?></option>
                                <?}?>
                        </select>

                        <?  
                            if ($arResult["TICKET"]["STATUS_SID"] == "W") {?>
                            <label><input type="checkbox" name="saveStatus" id="saveStatus" value="1" > ��������� ������ "� ������"</label>
                            <?}?>
                           <br><br> 
                            <label><input type="checkbox" id="UF_IN_PAYMENT" name="UF_IN_PAYMENT" value="1" <?if ($arResult["TICKET"]["UF_IN_PAYMENT"]){?> checked="checked"<?}?>> ��������� � ������</label>
                            

                        <?} else {?>
                        <input type="hidden" id="UF_IN_PAYMENT" name="UF_IN_PAYMENT" value="<?if ($arResult["TICKET"]["UF_IN_PAYMENT"]){echo "1";}?>">
                        <?=$arResult["TICKET"]["STATUS_NAME"]?>
                        <?}?>     
                    <br />  <br />
                    
                    


                    <?if (in_array(8, $USER->GetUserGroupArray()) || in_array(7, $USER->GetUserGroupArray()) || $USER->IsAdmin()){?>

                        <?if($_GET['ID']<=1235 && in_array(8, $USER->GetUserGroupArray())){?>
                            <?=GetMessage("SUP_TICKET_TIME")?>:
                            <input type="text" name="SPEND_TIME" id="SPEND_TIME" value="<?=$arResult["TICKET"]["UF_SPEND_TIME"]?>">
                            <br />  <br />
                            <?} else if($_GET['ID']<=1235 && ($USER->IsAdmin() || in_array(7, $USER->GetUserGroupArray()))) {?>
                            <input type="hidden" name="SPEND_TIME" id="SPEND_TIME" value="<?=$arResult["TICKET"]["UF_SPEND_TIME"]?>">
                            <?} else {?>
                            <!--Start of billing table-->
                            <style>
                                .tableHours div{
                                    display:inline-block;
                                    width:70px;
                                }
                                .tableHours input{
                                    width:50px;
                                }
                                .billingTimeTable td:nth-child(4){
                                    width:200px;
                                }
                                .billingTimeTable{
                                    display:none;
                                }
                                .addHours{
                                    display:inline;
                                }
                                .hideBillingTable{
                                    display:none;
                                }
                            </style>

                            <script type="text/javascript" src="<?=$this->GetFolder()?>/billing.js"></script>



                            <a href="javascript:void(0)" class="billingTableControl">
                                <span class="addHours">���������� ���������</span>
                                <span class="hideBillingTable">������</span>
                            </a>
                            <br><br>


                            <div class="billingTimeTable">
                                <table>
                                    <tr>
                                        <th>����</th>
                                        <th>�����</th>
                                        <th>�����</th>
                                        <th>������</th>
                                        <th>�����������</th>
                                        <th>��������</th>                                        
                                    </tr>

                                    <?
                                        $totalHours=0;
                                        $totalMinutes=0;

                                        $arSelect = Array('ID',"PROPERTY_add_date","PROPERTY_support_user_id","PROPERTY_spend_time_hours","PROPERTY_support_user_comment","PROPERTY_ticket_id","PROPERTY_spend_time_minutes", "PROPERTY_in_payment", "PROPERTY_is_payed");
                                        $arFilter = Array("IBLOCK_ID"=>24,"PROPERTY_ticket_id"=>$_GET['ID']);
                                        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>999), $arSelect);
                                        while($ob = $res->GetNextElement())
                                        {
                                            $arFields = $ob->GetFields();?>

                                        <?
                                            $totalHours += $arFields['PROPERTY_SPEND_TIME_HOURS_VALUE'];
                                            $totalMinutes += $arFields['PROPERTY_SPEND_TIME_MINUTES_VALUE'];
                                        ?>

                                        <tr>
                                            <td><?=$arFields['PROPERTY_ADD_DATE_VALUE']?></td>
                                            <td><?
                                                $rsUser = CUser::GetByID($arFields['PROPERTY_SUPPORT_USER_ID_VALUE']);
                                                $arUser = $rsUser->Fetch();
                                                echo $arUser['NAME'].' '.$arUser['LAST_NAME'];
                                            ?></td>
                                            <td class="tableHours">
                                                <p><?=$arFields['PROPERTY_SPEND_TIME_HOURS_VALUE']?>:<?=$arFields['PROPERTY_SPEND_TIME_MINUTES_VALUE']?></p>
                                            </td>
                                            <td>
                                            
                                            </td>
                                            <td>
                                                <p><?=$arFields['PROPERTY_SUPPORT_USER_COMMENT_VALUE']['TEXT']?></p>
                                            </td>                                             

                                            <td>
                                                <?if($USER->GetID()==$arFields['PROPERTY_SUPPORT_USER_ID_VALUE'] || $USER->IsAdmin()){?>
                                                    <input type="hidden" name="recordID" value="<?=$arFields['ID']?>">
                                                    <input class="deleteBillingPosition" data-action="delete" value="�������" type="submit" />
                                                    <?}?>
                                            </td>
                                        </tr>


                                        <?}?>
                                    <?if(in_array(8, $USER->GetUserGroupArray()) || $USER->IsAdmin()){?>
                                        <tr class="billingEditRow">
                                            <td>����� ��������� ������� ����.</td>
                                            <td>����� ����� ������ ��<br>����� �������� ����������.</td>
                                            <td class="tableHours">                                            
                                                <div>
                                                    <label for="billingHour">
                                                        <input name="billingHour" class="fieldsForBilling" type="text" />
                                                        �
                                                    </label>
                                                </div>
                                                <div>
                                                    <label for="billingMinute">
                                                        <input name="billingMinute" class="fieldsForBilling" type="text" />
                                                        �
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                               <?
                                               $service = GKSupportServices::GetList($by="ID",$sort="ASC",array());
                                               ?>
                                               <select name="serviceID" id="serviceID">
                                               <?while($arService = $service->Fetch()){?>
                                                  <option value="<?=$arService["ID"]?>"><?=$arService["NAME"]?></option>
                                               <?}?>
                                               </select>
                                            </td>
                                            <td>
                                                <textarea name="billingComment" class="fieldsForBilling" id="" cols="30" rows="3"></textarea>
                                            </td>                                              
                                            <td>
                                                <input type="hidden" name="supportUserID" value="<?=$USER->GetID()?>">
                                                <input type="hidden" name="supportTicketID" value="<?=$_GET['ID']?>">
                                                <input type="hidden" name="supportClientID" value="<?=$arResult["TICKET"]["OWNER_USER_ID"]?>">
                                                <input class="submitBilling" data-action="add" value="��������" type="submit" />
                                            </td>
                                        </tr>
                                        <?}?>
                                </table>
                                <br>
                                <br>
                            </div>
                            <div>
                                ����� �����:
                                <span class="billingTotal">
                                    <?
                                        $minutes = $totalMinutes%60;
                                        if (strlen($minutes) == 1) {$minutes = "0".$minutes;}
                                        echo ($totalHours + intval($totalMinutes/60)).":".$minutes;
                                    ?>
                                </span>
                            </div>
                            <br>
                            <!--End of billing table-->    
                            <?}?>

                        <?}?>       



                    <?if (strlen($arResult["TICKET"]["CATEGORY_NAME"]) > 0):?>
                        <?=GetMessage("SUP_CATEGORY")?>: <span title="<?=$arResult["TICKET"]["CATEGORY_DESC"]?>"><?=$arResult["TICKET"]["CATEGORY_NAME"]?></span><br />
                        <?endif?>


                    <?if(strlen($arResult["TICKET"]["CRITICALITY_NAME"])>0) :?>
                        <?=GetMessage("SUP_CRITICALITY")?>: <span title="<?=$arResult["TICKET"]["CRITICALITY_DESC"]?>"><?=$arResult["TICKET"]["CRITICALITY_NAME"]?></span><br />
                        <?endif?>


                    <?=GetMessage("SUP_RESPONSIBLE")?>:
                    <?if ($USER->IsAdmin()){?>
                        <?
                            //�������� ������������� �� ������ "���������� ������������"
                            $user = CUser::GetList(($by="name"), ($order="asc"), array("ACTIVE"=>"Y", "GROUPS_ID"=>array(8)));   
                        ?>

                        <select name="RESPONSIBLE_USER_ID" id="RESPONSIBLE_USER_ID">
                            <option value="0">-</option>
                            <?while($arUser = $user->Fetch()){?>
                                <option value="<?=$arUser["ID"]?>" <?if ($arResult["TICKET"]["RESPONSIBLE_USER_ID"] == $arUser["ID"]){?> selected="selected"<?}?>><?=$arUser["NAME"]." ".$arUser["LAST_NAME"]?></option>
                                <?}?>
                        </select>
                        <?} else {?>
                        <input type="hidden" name="RESPONSIBLE_USER_ID" value="<?=$arResult["TICKET"]["RESPONSIBLE_USER_ID"]?>">
                        <?=$arResult["TICKET"]["RESPONSIBLE_NAME"]?>
                        <?}?>
                    <br />

                    <input type="hidden" name="UPDATE_TICKET" value="Y">

                    <?/*if (strlen($arResult["TICKET"]["SLA_NAME"])>0) :?>
                        <?=GetMessage("SUP_SLA")?>:
                        <span title="<?=$arResult["TICKET"]["SLA_DESCRIPTION"]?>"><?=$arResult["TICKET"]["SLA_NAME"]?></span>
                    <?endif*/?>

                    <br>

                    <?//arshow($arResult)?>  
                </td>
            </tr>


            <tr>
                <th><?=GetMessage("SUP_DISCUSSION")?></th>
            </tr>




            <tr>
                <td>
                    <?=$arResult["NAV_STRING"]?>
                    <?$userGroups = array();//������ � �������� �������������, ������� ����� �����?>
                    <?foreach ($arResult["MESSAGES"] as $arMessage):?>
                        <div class="ticket-edit-message">

                            <div class="support-float-quote">[&nbsp;<a href="#postform" OnMouseDown="javascript:SupQuoteMessage('quotetd<? echo $arMessage["ID"]; ?>')" title="<?=GetMessage("SUP_QUOTE_LINK_DESCR");?>"><?echo GetMessage("SUP_QUOTE_LINK");?></a>&nbsp;]</div>


                            <div align="left"><b><?=GetMessage("SUP_TIME")?></b>: <?=FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arMessage["DATE_CREATE"]))?></div>
                            <b><?=GetMessage("SUP_FROM")?></b>:


                            <?=$arMessage["OWNER_SID"]?>

                            <?if (intval($arMessage["OWNER_USER_ID"])>0):?>
                                <?=$arMessage["OWNER_NAME"]?>
                                <?endif?>

                            <?
                                //���� ����� ����� �������� �������������� - ������� ��������������� ��������� � �������
                                if (!is_array($userGroups[$arMessage["OWNER_USER_ID"]])) {
                                    $groups = CUser::GetUserGroupList($arMessage["OWNER_USER_ID"]);
                                    while($arGroup = $groups->Fetch()) {
                                        $userGroups[$arMessage["OWNER_USER_ID"]][] = $arGroup["GROUP_ID"]; 
                                    }   
                                }
                            ?>
                            <?
                            if ($arUsers[$arMessage["OWNER_USER_ID"]] != "") {
                                $siteName = $arUsers[$arMessage["OWNER_USER_ID"]];
                            }
                            else {
                                $owner = CUser::GetList($by="ID",$sort="asc",array("ID"=>$arMessage["OWNER_USER_ID"]),array("SELECT"=>array("UF_SITE")))->Fetch();
                                $arUsers[$arMessage["OWNER_USER_ID"]] = $owner["UF_SITE"];
                            }
                            ?>
                            <?if (in_array(1,$userGroups[$arMessage["OWNER_USER_ID"]])) {?><i class="ticket_link">(������������� ������������)</i><?} else if (in_array(7,$userGroups[$arMessage["OWNER_USER_ID"]])) {?>(<?=$arUsers[$arMessage["OWNER_USER_ID"]]?>)<?}?>
                            <br />


                            <?
                                $aImg = array("gif", "png", "jpg", "jpeg", "bmp");
                                foreach ($arMessage["FILES"] as $arFile):
                                ?>
                                <div class="support-paperclip"></div>
                                <?if(in_array(strtolower(GetFileExtension($arFile["NAME"])), $aImg)):?>
                                    <a title="<?=GetMessage("SUP_VIEW_ALT")?>" href="<?=$componentPath?>/ticket_show_file.php?hash=<?echo $arFile["HASH"]?>&amp;lang=<?=LANG?>"><?=$arFile["NAME"]?></a>
                                    <?else:?>
                                    <?=$arFile["NAME"]?>
                                    <?endif?>
                                (<? echo CFile::FormatSize($arFile["FILE_SIZE"]); ?>)
                                [ <a title="<?=str_replace("#FILE_NAME#", $arFile["NAME"], GetMessage("SUP_DOWNLOAD_ALT"))?>" href="<?=$componentPath?>/ticket_show_file.php?hash=<?=$arFile["HASH"]?>&amp;lang=<?=LANG?>&amp;action=download"><?=GetMessage("SUP_DOWNLOAD")?></a> ]
                                <br class="clear" />
                                <?endforeach?>


                            <br /><div id="quotetd<? echo $arMessage["ID"]; ?>"><?=$arMessage["MESSAGE"]?></div>

                        </div>
                        <?endforeach?>

                    <?=$arResult["NAV_STRING"]?>

                </td>

            </tr>
        </table>



        <br />
        <?endif;?>



    <?=bitrix_sessid_post()?>
    <input type="hidden" name="set_default" value="Y" />
    <input type="hidden" name="ID" value=<?=(empty($arResult["TICKET"]) ? 0 : $arResult["TICKET"]["ID"])?> />
    <input type="hidden" name="edit" value="1">
    <input type="hidden" name="lang" value="<?=LANG?>" />



    <script type="text/javascript">
        BX.ready(function(){
            var buttons = BX.findChildren(document.forms['support_edit'], {attr:{type:'submit'}});
            for (i in buttons)
            {
                BX.bind(buttons[i], "click", function(e) {
                    setTimeout(function(){
                        var _buttons = BX.findChildren(document.forms['support_edit'], {attr:{type:'submit'}});
                        for (j in _buttons)
                        {
                            _buttons[j].disabled = true;
                        }

                        }, 30);
                });
            }
        });
    </script>

</form>     
