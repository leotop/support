<?$solutions=CIBlockElement::GetList(
        array("SORT"=>"ASC"),
        array("IBLOCK_CODE"=>"WEBGK_CONTACTS", "NAME"=>array("Почта","Отдел продаж")),
        false,
        false,
        Array("PREVIEW_TEXT")
    );
    $contact=array();
    while($ob = $solutions->Fetch())
    {  
        $contact[]=$ob["PREVIEW_TEXT"];
    }
    $site_type=CIBlockPropertyEnum::GetList(
        Array("SORT"=>"ASC", "VALUE"=>"ASC"),
        Array("IBLOCK_ID"=>"14","CODE"=>"TYPE_SOLUTIONS")
    ); 
    $types=array();
    while($enum_fields = $site_type->GetNext())
    {
        $types[$enum_fields["ID"]]=$enum_fields["VALUE"]; 
        //$id_solution[$enum_fields["VALUE"]]=$enum_fields["ID"]; 
    }   
    // arshow($id_solution); 
    function lang($n){            // Функция для подбора правильного окончания у слов в зависимости от количества готовых решений
    global $lang1,$lang2;
    $b=strval($n);
    $rest = substr($b, -1);  
    $rest = substr($b, -1);
    if ($rest=="0" || $rest=="5" || $rest=="6" || $rest=="7" || $rest=="8" || $rest=="9" || $rest=="12" || $rest=="13" || $rest=="14"){
    $lang1="ов";
    $lang2="ых";
    }
    elseif ($rest=="1") {
    $lang1="";
    $lang2="ый";        
    }   
    else {
    $lang1="а";
    $lang2="ых"; 
    } 
    
    }            

?>

<div class="info_solution">

    <ul class="info_resh">
        <li class="info_li" id="margin_li" rel="21">
            <span class="left_info">
                <?$ob=CIBlockElement::GetList(
                        Array("SORT"=>"ASC"),
                        Array("IBLOCK_CODE"=>"SOLUTIONS", "PROPERTY_TYPE_SOLUTIONS_VALUE"=>"Интернет сайт"),
                        false,
                        false,
                        Array("NAME")
                    );
                    $a=0;
                    while($res=$ob->Fetch()){
                        $a++;
                    };  
                    
                     lang($a);

                    echo $a;
                ?>
            </span>
            <span class="right_info">готов<?=$lang2?><br>сайт<?=$lang1?>
            </span>
        </li>  
        <li class="info_li" rel="20">
            <span class="left_info">
                <?$ob=CIBlockElement::GetList(
                        Array("SORT"=>"ASC"),
                        Array("IBLOCK_CODE"=>"SOLUTIONS", "PROPERTY_TYPE_SOLUTIONS_VALUE"=>"Интернет магазины"),
                        false,
                        false,
                        Array("NAME")
                    );
                    $a2=0;
                    while($res=$ob->Fetch()){
                        $a2++;
                    };
                    lang($a2);
                                       
                     echo $a2;
                ?>
            </span>
            <span class="right_info">интернет<br>магазин<?=$lang1?>
            </span>
        </li>
        <li class="info_li" rel="22">
            <span class="left_info">
                <?$ob=CIBlockElement::GetList(
                        Array("SORT"=>"ASC"),
                        Array("IBLOCK_CODE"=>"SOLUTIONS", "PROPERTY_TYPE_SOLUTIONS_VALUE"=>"Лэндинг"),
                        false,
                        false,
                        Array("NAME")
                    );
                    $a3=0;
                    while($res=$ob->Fetch()){
                        $a3++;
                    };
                    lang($a3);
                    
                    echo $a3;
                ?>   
            </span>
            <span class="right_info">

                Готов<?=$lang2?> <br> Лэндинг<?=$lang1?>
                <?//$APPLICATION->IncludeFile(SITE_DIR."/include/solutions/statistics3_text.php",Array(),Array("MODE"=>"html"));?>
            </span>
        </li>
    </ul> 

</div>

<div class="contact_solution">
    <p><div class="bottom_container"><span class="call_me_resh">Звоните и пишите нам</span>

            , мы с удовольствием проконсультируем и сделаем:</div><span class="phone_bottom"><?$APPLICATION->IncludeFile(SITE_DIR."/include/solutions/phone.php",Array(),Array("MODE"=>"html"));?>
</span>
        <span class="resh_bold"><a href="mailto:<?=$contact[0]?>"><?=$contact[0]?></a></span></p>
</div>

</div>
<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("solutionForm")?>
<div class="right_blocks_resh">
    <form method="post" id="form_solutions">

        <div class="resh_select1">
            <div class="select_vis" name="site_type" onclick='get_click1(this)'>
                 Выберите тип решения
                <?/*foreach ($types as $key=>$obr) {
                    echo $obr;
                    $key_first=$key;
                    break;
                }*/?>

            </div>

            <div class="select_hid" id="hidden1">

                <?foreach($types as $key=>$obr){
                    echo "<p rel='".$key."' onclick='get_click2(this)'>".$obr."</p>";
                }  ?>

            </div>       

            <input type="hidden" name="input_hid_type" id="input_hid" class="input_hidden">

        </div>  

        <div class="resh_select2">  
            <input placeholder="E-mail" name="contact_scope" class="input_vis" id="select_white">
           
            <!--<div class="select_vis" id="select_white" name="site_resh" onclick='get_click1(this)'>
             Укажите сферу бизнеса
            </div> -->

            <div class="select_hid" id="select_hid">

            </div>

            <!--<input type="hidden" name="input_hid_solut" class="input_hidden">-->

        </div> 

        <div class="resh_input">    
            <input placeholder="Имя" name="contact_name_resh" id="solution2">

            <input placeholder="Телефон" name="contact_phone_resh" id="solution3">

            <textarea placeholder="Напишите интересующий вас вопрос" name="question_resh" id="solution4"></textarea>

        </div> 

        <div id="error_text">
        </div>  

        <div class="order_now order_resh">
            <a href="#" onclick="want_solution()">Заказать консультацию</a>
        </div>
    </form>

</div>
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("solutionForm","Form Loading")?>
</div>

</div>
</div>
<div id="foot_menu">
    <div id="bx-composite-banner"></div>
    <div class="menu_container">
        <ul>

            <li>
                2004-<?=date("Y"); ?> веб-студия webgk
            </li>

            <li><?$APPLICATION->IncludeFile(SITE_DIR."/include/footer/mail.php",Array(),Array("MODE"=>"html"));?></li>     
            <li>                                                           
                 <?$city = get_city_by_ip($_SERVER["REMOTE_ADDR"]);?>
                <?$city = iconv("UTF-8","CP1251",$city)?>
                <?if($city=="Москва" or $city=="Санкт-Петербург"){?>
                    <p><strong><?$APPLICATION->IncludeFile(SITE_DIR."/include/footer/phoneMoscow.php",Array(),Array("MODE"=>"html"));?></strong></p>                      
                    <?}else{?>
                    <p><strong><?$APPLICATION->IncludeFile(SITE_DIR."/include/footer/phoneTula.php",Array(),Array("MODE"=>"html"));?></strong></p>                           
                    <?}?>
            </li>

            <li><a href="/information/"><?$APPLICATION->IncludeFile(SITE_DIR."/include/footer/information.php",Array(),Array("MODE"=>"html"));?></a></li>

            <li class="menu_last_cell">    
                <?$city = get_city_by_ip($_SERVER["REMOTE_ADDR"]);?>
                <?$city = iconv("UTF-8","CP1251",$city)?>
                <?if($city=="Москва" or $city=="Санкт-Петербург"){?>
                    <strong><?$APPLICATION->IncludeFile(SITE_DIR."/include/footer/addressMoscow.php",Array(),Array("MODE"=>"html"));?></strong>
                    <?}else{?>
                    <strong><?$APPLICATION->IncludeFile(SITE_DIR."/include/footer/addressTula.php",Array(),Array("MODE"=>"html"));?></strong>
                    <?}?>
            </li>


        </ul>
    </div>
        </div>
     
    </div>
        <!--//Нижнее меню-->
        
        </div>
    </body>
</html>