<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->createFrame()->begin();?>

<h1 class="internal_h1"><?$APPLICATION->ShowTitle(false);?> 

  

</h1>
<div class="events_content">

<div class="slider_events_bottom">
    <div class="slider_event_next" onclick="slider_event('next')">
    </div>
    <div class="slider_prev_event" onclick="slider_event('prev')">
    </div>
</div> 

<div class="slider_events">




    <?//arshow($arResult);

        $event=array();   
        foreach($arResult["ITEMS"] as $arItem): 
            if ($arItem["PROPERTIES"]["PRINT_EVENT"]["VALUE_XML_ID"]=="BIG") {
                $event["BIG"][]=array(

                    "PREVIEW_TEXT"=>$arItem["PREVIEW_TEXT"],
                    "DATE"=>str_replace(".","/",substr($arItem["ACTIVE_FROM"], 0, 5)),
                    "PREVIEW_PICTURE"=>$arItem["PREVIEW_PICTURE"]["SRC"],
                    "DETAIL_PICTURE"=>$arItem["DETAIL_PICTURE"]["SRC"],
                    "LINK_DETAIL"=> $arItem["DETAIL_PAGE_URL"]
                );   
            }
            if ($arItem["PROPERTIES"]["PRINT_EVENT"]["VALUE_XML_ID"]=="MIDDLE") {
                $event["MIDDLE"][]=array(

                    "PREVIEW_TEXT"=>$arItem["PREVIEW_TEXT"],
                    "DATE"=>str_replace(".","/",substr($arItem["ACTIVE_FROM"], 0, 5)),
                    "PREVIEW_PICTURE"=>$arItem["PREVIEW_PICTURE"]["SRC"],
                    "DETAIL_PICTURE"=>$arItem["DETAIL_PICTURE"]["SRC"],
                    "LINK_DETAIL"=> $arItem["DETAIL_PAGE_URL"]
                );
            }


            if ($arItem["PROPERTIES"]["PRINT_EVENT"]["VALUE_XML_ID"]=="MINI") {
                $event["MINI"][]=array(

                    "PREVIEW_TEXT"=>$arItem["PREVIEW_TEXT"],
                    "DATE"=>str_replace(".","/",substr($arItem["ACTIVE_FROM"], 0, 5)),
                    "PREVIEW_PICTURE"=>$arItem["PREVIEW_PICTURE"]["SRC"],
                    "DETAIL_PICTURE"=>$arItem["DETAIL_PICTURE"]["SRC"],
                    "LINK_DETAIL"=> $arItem["DETAIL_PAGE_URL"]
                );

            } 

            endforeach; 

        //arshow($event);


        $a=1;
        foreach($event as $event_news): 

            //arshow($event_news);

        ?> 




        <div class="events_div">

            <?$link=array_shift($event["BIG"]);
            if (!is_null($link)):?>
                <div class="event_block1">
                    <a href="<?=$link["LINK_DETAIL"]?>" class="img_events"><img class="img_event_block" id="img_event_block" src="<?=$link["PREVIEW_PICTURE"]?>">
                    <div class="text_event_block">
                        <span class="data_events"><?=$link["DATE"]?></span>
                        <span class="preview_events"><?=$link["PREVIEW_TEXT"]?></span>
                    </div>
                    </a>  
                </div>
            <?endif;?>

            
            <div class="event_block2">
                <?$link=array_shift($event["MINI"]);
                if (!is_null($link)):?>
                    <div class="event_block3">
                        <a href="<?=$link["LINK_DETAIL"]?>" class="img_events"><img class="img_event_block" src="<?=$link["PREVIEW_PICTURE"]?>">
                        <div class="text_event_block">
                            <span class="data_events" id="date_bottom"><?=$link["DATE"]?></span>
                            <span class="preview_events" id="middle_text"><?=$link["PREVIEW_TEXT"]?></span>
                        </div>
                        </a>
                    </div>
                <?endif;?>

                <?$link=array_shift($event["MINI"]);
                if (!is_null($link)):?>
                    <div class="event_block4">
                        <a href="<?=$link["LINK_DETAIL"]?>" class="img_events"><img class="img_event_block" src="<?=$link["PREVIEW_PICTURE"]?>">
                        <div class="text_event_block">
                            <span class="data_events" id="date_bottom"><?=$link["DATE"]?></span>
                            <span class="preview_events" id="middle_text"><?=$link["PREVIEW_TEXT"]?></span>
                        </div>
                        </a>
                    </div>
                <?endif;?>
            </div>

            <?$link=array_shift($event["MIDDLE"]); 
            if (!is_null($link)):?>
                <div class="event_block5">
                    <a href="<?=$link["LINK_DETAIL"]?>" class="img_events"><img class="img_event_block" src="<?=$link["PREVIEW_PICTURE"]?>"> 
                    <div class="text_event_block">
                        <span class="data_events" id="date_bottom"><?=$link["DATE"]?></span>
                        <span class="preview_events" id="middle_text_right"><?=$link["PREVIEW_TEXT"]?></span>
                    </div>
                    </a>
                </div>
            <?endif;?>

            <?$link=array_shift($event["BIG"]);
            if (!is_null($link)):?>
                <div class="event_block6"> 
                    <a href="<?=$link["LINK_DETAIL"]?>" class="img_events"><img class="img_event_block" src="<?=$link["PREVIEW_PICTURE"]?>">
                    <div class="text_event_block">
                        <span class="data_events"><?=$link["DATE"]?></span>
                        <span class="preview_events"><?=$link["PREVIEW_TEXT"]?></span>
                    </div>  
                    </a>
                </div>
            <?endif;?>
        </div>

        <?$a++;
            if ($a>2) {
                break;
            }
            endforeach?>

</div>



</div>

