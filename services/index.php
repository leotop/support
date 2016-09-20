<?


    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Услуги");

    $service=CIBlockElement::GetList(
        array("SORT"=>"ASC"),
        array("IBLOCK_CODE"=>"SERVICES"),
        false,
        false,
        Array("NAME", 'PREVIEW_TEXT','ID', 'PREVIEW_PICTURE', "PROPERTY_PRICE_SERVICE", "PROPERTY_BOTTOM_PICTURE_1", "PROPERTY_TEXT_BOTTOM_1", "PROPERTY_BOTTOM_PICTURE_2",
            "PROPERTY_TEXT_BOTTOM_2", "PROPERTY_TEXT_BOTTOM_3","PROPERTY_BOTTOM_PICTURE_3","CODE")
    );
    $ELEMENTS=array();
    while($ob = $service->Fetch())
    {  
        $ELEMENTS[]=$ob;
        //arshow($ELEMENTS);
    }  
?>  
<script type="text/javascript">
function service_resize(){
  // alert($("body").css("width"));
    if (parseInt($("body").css("width"))<1310){
        $("#resize_service").css({"padding-top" : "40px", "text-align" : "left"});
        $("#fitst-li").css("margin-left","0");
       
    }
      if (parseInt($("body").css("width"))<1230){
        $("#resize_service li").css({"margin-left" : "15px", "font-size" : "12px"});
        $("#fitst-li").css("margin-left","0");  
      }
      
      if (parseInt($("body").css("width"))>1230){
        $("#resize_service li").css({"margin-left" : "30px", "font-size" : "14px"});
        $("#fitst-li").css("margin-left","0");  
      } 
      
    
    
    if (parseInt($("body").css("width"))>1310){ 
       $("#resize_service").css({"padding-top" : "0", "text-align" : "right"}); 
       $("#fitst-li").css("margin-left","30"+"px");
       
    }
    
}

 $(document).ready(function(){
        service_resize();
    })

    $(window).bind("resize",function() {
        service_resize();
    })

</script>

<ul class="tabs" id="resize_service">

    <? $a=1;  
        $value=array(); 
       // global $service_code; 
        foreach ($ELEMENTS as $value) {   
         
            if ($a==1){
                $service_code=$value["CODE"];
                $id="id='fitst-li'";
            }
            else{
               $id=""; 
            }?>     
        <li rel="<?=$value["CODE"]?>" <?=$id?>><a href="/services/#<?=$value["CODE"]?>"><?=$a.". ".$value["NAME"]?></a></li>
        <?$a++;
        $n++;}?>      
</ul>

<ul class="tab_content">

    <?$b=1;
        foreach ($ELEMENTS as $value) {
            $sec=CFile::GetPath($value['PREVIEW_PICTURE']);
            $sec1=CFile::GetPath($value['PROPERTY_BOTTOM_PICTURE_1_VALUE']);
            $sec2=CFile::GetPath($value['PROPERTY_BOTTOM_PICTURE_2_VALUE']);
            $sec3=CFile::GetPath($value['PROPERTY_BOTTOM_PICTURE_3_VALUE']);

            if ($b==1){
                // $col="style='background-color: #030F15; min-height: 730px;'";    
            }
            else {
                $col="";   
            }
        ?> 

        <li>
            <h2 class="tab_content_title">наши услуги</h2>
            <!-- left_tab block -->
            <div class="tab_blocks">
                <div class="left_tab_blocks">
                    <img src="<?=$sec?>" alt="img-01" style="">
                </div>
                <div class="right_tab_blocks">
                    <!-- tab title -->
                    <h1 class="tab_title"><?=$value['NAME']?></h1>
                    <!-- End tab title -->
                    <!-- tab price -->
                    <div class="tab_price">
                        <?=$value["PROPERTY_PRICE_SERVICE_VALUE"]?>
                    </div>
                    <!-- End tab price -->
                    <!-- tab text -->
                    <div class="tab_text">
                        <?=$value['PREVIEW_TEXT']?>                 

                    </div>
                    <!-- End tab text -->
                    <!-- tab list -->
                    <div class="tab_list">
                        <ul>
                            <li class="info_icon_1" style="background-image: url('<?=$sec1?>')";><?=$value["PROPERTY_TEXT_BOTTOM_1_VALUE"]?></li>
                            <li class="info_icon_2" style="background-image: url('<?=$sec2?>')";><?=$value["PROPERTY_TEXT_BOTTOM_2_VALUE"]?></li>
                            <li class="info_icon_3" style="background-image: url('<?=$sec3?>')";><?=$value["PROPERTY_TEXT_BOTTOM_3_VALUE"]?></li>
                        </ul>
                    </div>
                    <!-- End tab list -->
                    <div class="order_now">
                        <a href="/forms/want_site_form.php?TYPE=<?=$value["ID"]?>" class="fancybox">заказать прямо сейчас</a>
                    </div>
                </div>
            </div>
            <!-- End left_tab block -->
        </li>
        <?
            $name_service[]=$value["NAME"];
            global $name_service;    
            $b++;}?>
    </ul>
    
            

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>