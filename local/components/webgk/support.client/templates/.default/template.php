<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent("bitrix:menu", "deskmanMenu", Array(
        "ROOT_MENU_TYPE" => "deskman",    
        "MENU_CACHE_TYPE" => "N",    
        "MENU_CACHE_TIME" => "3600",    
        "MENU_CACHE_USE_GROUPS" => "Y",   
        "MENU_CACHE_GET_VARS" => "",   
        "MAX_LEVEL" => "1",    
        "CHILD_MENU_TYPE" => "",    
        "USE_EXT" => "Y",   
        ),
        false
    ); 
?>   
<? if(count($arResult)>=1) { ?>
    <h1><?=GetMessage('SUPPORT_MAIN_TITLE')?></h1><br>
    <? if (count($arResult["STAT"])>=1){?>  
        <table class="statTable" >
            <?      
                foreach  ($arResult["STAT"] as $yID => $year) {
                    ksort($year);

                    //Sorting elements
                    /*foreach ($arResult["CLIENT"] as $client) {
                        arshow($client); 
                        if(!empty($arResult["PRICE_YEAR"][$yID][$user["PROJECT_NAME"]]["PRICE_TO_PAY"])){ 

                        }
                    }*/

                ?>
                <tr>
                    <th colspan="14" class="yearTitle" style="text-transform: uppercase;"><?=$yID.' '.GetMessage('SUPPORT_YEAR')?></th>                 
                </tr>  
                <tr>
                    <th><?=GetMessage('SUPPORT_PROJECT')?></th>
                    <?for ($monthCount = 1; $monthCount <= 12; $monthCount++) { ?>   
                        <th class="monthName" style="text-transform: uppercase;"><?=GetMessage('SUPPORT_MONTH_'.$monthCount)?></th>                 
                        <? 
                    }?>
                    <th><?=GetMessage('SUPPORT_TOTAL')?></th>
                </tr> 
                <?foreach  ($arResult["CLIENT"] as $uID => $user) { // добаляем поле итоговой цены в массив проектов 
                      $arResult["CLIENT"][$uID]["PRICE_PAY"] = $arResult["PRICE_YEAR"][$yID][$user["PROJECT_NAME"]]["PRICE_TO_PAY"];
                }?> 
                 <?usort($arResult["CLIENT"], function($a, $b){ 
                     // сортируем массив по убыванию цен
                    return ($b['PRICE_PAY'] - $a['PRICE_PAY']);
                 });?>
                <?foreach  ($arResult["CLIENT"] as $uID => $user) {  ?>
                    <?if(!empty($arResult["PRICE_YEAR"][$yID][$user["PROJECT_NAME"]]["PRICE_TO_PAY"])){?>
                        <tr>
                            <td><?=$user["PROJECT_NAME"]?></td>
                            <?for ($monthCount = 1; $monthCount <= 12; $monthCount++) { ?>
                                <td align="center" class="<?if(!empty($year[$monthCount][$user["PROJECT_NAME"]]["PRICE_TO_PAY"])){ echo 'payed'; } else { echo 'notPayed'; }?>">
                                    <?if(!empty($year[$monthCount][$user["PROJECT_NAME"]]["PRICE_TO_PAY"])){
                                            echo $year[$monthCount][$user["PROJECT_NAME"]]["PRICE_TO_PAY"];
                                        } else {
                                            echo '-';
                                    }?>
                                </td>
                                <?}?>
                                 <?//arshow($arResult["PRICE_YEAR"][$yID])?>
                            <td align="center" class="<?if(!empty($arResult["PRICE_YEAR"][$yID][$user["PROJECT_NAME"]]["PRICE_TO_PAY"])){ echo 'payedYear'; } else { echo 'notPayed'; }?>">
                                <?if(!empty($arResult["PRICE_YEAR"][$yID][$user["PROJECT_NAME"]]["PRICE_TO_PAY"])){
                                        echo $arResult["PRICE_YEAR"][$yID][$user["PROJECT_NAME"]]["PRICE_TO_PAY"];
                                    } else {
                                        echo '-';
                                }?>
                            </td>
                        </tr>
                        <?
                        }
                    } 
                ?>
                <tr>
                    <td colspan="14"></td>
                </tr>
                <?} 
            ?>
        </table>
        <?    
        } else {
            echo GetMessage('SUPPORT_EMPTY_LIST');
        }
    } else {
        echo GetMessage('SUPPORT_ATTENTION');    
    }
?>