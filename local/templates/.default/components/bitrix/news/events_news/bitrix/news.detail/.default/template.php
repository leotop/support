<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->createFrame()->begin()?>
<?

    $foto=array();
    if ($arResult["PROPERTIES"]["EVENTS_FOTO"]["VALUE"]!=0){
    $foto["ID"]=$arResult["PROPERTIES"]["EVENTS_FOTO"]["VALUE"]; 
    }
    



?>
<div class="news-detail">


<span class="news-date-time"><?=str_replace(".","/",substr($arResult["ACTIVE_FROM"], 0, 5))?></span>

<?if (count($arResult["DETAIL_PICTURE"]["SRC"])>0):?>

<div class="detail_picture_div"><img class="detail_picture" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"></div>

<?endif?>


<h1><?=$arResult["PREVIEW_TEXT"]?></h1>




<div class="detail_news">
    <?=$arResult["DETAIL_TEXT"]?>
</div>

<?if ($arResult["PROPERTIES"]["DETAIL_TEXT1"]["VALUE"]!=null || $arResult["PROPERTIES"]["DETAIL_TEXT2"]["VALUE"]!=null):?>

<div class="detail_news2">
    <?=$arResult["PROPERTIES"]["DETAIL_TEXT1"]["VALUE"]?> 
    <div id="green"> <?=$arResult["PROPERTIES"]["DETAIL_TEXT2"]["VALUE"]?></div>
</div>

<?endif?>

 <?if ($arResult["PROPERTIES"]["DETAIL_HEADER1"]["VALUE"]!=null):?>  
 
<div class="seminar_div1">

    <span class="seminar_header"><?=$arResult["PROPERTIES"]["DETAIL_HEADER1"]["VALUE"]?></span>
    <?=$arResult["PROPERTIES"]["DETAIL_LIST1"]["~VALUE"]["TEXT"]?>

    <p>
        <?=$arResult["PROPERTIES"]["DETAIL_ITALIC"]["VALUE"]["TEXT"]?> 
    </p>                                    

</div>

<?endif?>

<?if ($arResult["PROPERTIES"]["DETAIL_HEADER2"]["VALUE"]!=null):?>  

<div class="seminar_div2">
    <span class="seminar_header"><?=$arResult["PROPERTIES"]["DETAIL_HEADER2"]["VALUE"]?></span>

    <?$arFile=CIBlockElement::GetList(
            Array("SORT"=>"ASC"),
            Array("ID"=>$arResult["PROPERTIES"]["FILE_TO_EVENTS"]["VALUE"]),
            false,
            false,
            Array("NAME","PREVIEW_TEXT","PROPERTY_FILE_EVENTS")
        );
        while($ob = $arFile->Fetch())
        {
            $link=CFile::GetPath($ob["PROPERTY_FILE_EVENTS_VALUE"]);
          ?>          
        
        <div><a id="link_seminar" href="<?=$link?>"><?=$ob["NAME"]?></a></div>

        <p><?=$ob["PREVIEW_TEXT"]?></p>
    
    <? }?>

 </div>  
 
<?endif?>  
    

<?if (count($foto["ID"])>0):?>  
 
  
<div class="photogallery">
    <span>Фотоотчет с мероприятия</span>


    <? $foto_url=array();
        $a=1;
        foreach($foto["ID"] as $arItem):

            $foto_url["URL"]=CFile::GetPath(
                $arItem 
            );

        ?>

        <div class="photogallery_div"> <a href="<?=$foto_url["URL"]?>" class="gallery" rel="gallery"><img class="img_event_block" src="<?=$foto_url["URL"]?>"></a> </div>  

        <?
            if ($a==4){
                break;
            }
            $a++;
            endforeach;
            
endif?>
    </div>
	