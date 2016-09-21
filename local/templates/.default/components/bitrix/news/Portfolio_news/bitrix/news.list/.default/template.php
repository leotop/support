<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="border_port">



    <div class="header">


        <div class="slider_count"><span class="from">1</span> / <span class="to">5</span></div>

        <?$prop=CIBlockPropertyEnum::GetList(
                array("sort"=>"ASC"),
                Array("PROPERTY_ID"=>15)
            );
        ?>
        <ul class="header_filter">
            <li><a class="active f0">показать всё</a></li>

            <?  $a=1;
                global $work_t;
                $work_t=array();

                while ($property_work=$prop->Fetch()){
                    // arshow($property_work);
                ?>
                <li>
                    <a class="f<?=$a?>"><?=$property_work["VALUE"]?>
                    </a>
                </li> 

                <?$work_t[$property_work["ID"]]="f$a";$a++;}?>       
        </ul>
    </div>

</div>

<!--контент-->  


<!--контент-->
<!-- our services 
<div class="our_services_tabs">-->
<div class="news-list">

    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?><br />
        <?endif;
        global $work_t;
        //arshow($work_t);?>

    <div class="slider_wrapper">
        <div>
            <div id="portfolioNews" class="slider_data">    
                <?//$frame = $this->createFrame("portfolioNews",false)->begin()?>
                <?asort($arResult["ITEMS"]["PROPERTIES"]["CREATED"]["VALUE"]);
                    foreach($arResult["ITEMS"] as $arItem):
                        //arshow($arItem);

                        $class="";
                        foreach($arItem["PROPERTIES"]["WORK_TYPE"]["VALUE_ENUM_ID"] as $ob){
                            $class.=" ".$work_t[$ob];

                            $date_t=substr($arItem["PROPERTIES"]["CREATED"]["VALUE"],6,4);

                            if ($date_t<date("Y")-4){
                                $date_t=date("Y")-5;  
                            }  

                        };
                        if ($arItem["DETAIL_PAGE_URL"]){?> 

                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="f0 y0 <?=$class?> y<?=date("Y")-$date_t+1;?>">
                            <div class="port_div">
                                <div>
                                    <img class="port_img" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
                                </div>
                            </div>
                            <span class="name"><?=$arItem["NAME"]?></span>
                            <span class="cat_name"><?foreach($arItem["PROPERTIES"]["WORK_TYPE"]["VALUE"] as $cat_name=>$val):  


                                        if($cat_name > 0) { echo ' / '; }

                                         if($val == 'Лендинг Пейдж' or  $val =='Корпоративный сайт') { echo $val;}
                                         
                                         else {echo substr($val,0,-1);}

                                    endforeach ?></span>

                            <span class="date"><?=$arItem["PROPERTIES"]["CREATED"]["VALUE"]?></span></a>  


                        <?}endforeach?>

                <?//$frame->beginStub()?>
                <?//$frame->end()?>
            </div>
            <div class="slider">
        </div>   </div> 
        <div class="clear"></div>
    </div>  

</div>
<div class="filter">
    <span class="slider_next">
    </span>
    <span class="slider_prev disabled">
    </span>
    <ul>
        <li>
            <a class="y0 active">Все</a>
        </li>   
        <?for ($i=0; $i<4; $i++){
                $year=date('Y')-$i;   
            ?>
            <li>
                <a class="y<?=$i+1?>"><?=$year?></a>
            </li>

            <? }    ?>

        <li>
            <!--     <a class="y6">архив</a> -->
        </li>   
    </ul>     
    </div>

  

