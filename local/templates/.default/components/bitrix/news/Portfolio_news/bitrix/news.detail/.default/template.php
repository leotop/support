<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->createFrame()->begin()?>
<script type="text/javascript">     

    function port_resize(){
        var wid=parseInt($("body").css("width"));
        //alert(wid);
        if (wid>1320){
            $(".port_resize").css("width","1390"+"px");
            $(".port_block1").css("height","auto"); 
            $(".port_block2").css("height","auto"); 
            $(".port_block3").css("height","auto"); 
            //            $(".block3_img").css("height","300"+"px");  
            // $(".port_block4_content > div").css({"padding-left": "10px","width": "290px","height":"50px"}); 
        }
        if (wid<1530){
            $(".resize_footer_span").css("padding-right","1"+"%");
            $(".resize_footer_span").css("padding-left","4"+"%");
            $(".port_block4_content > div").css("padding-left","4"+"%");
            $(".left_port_span").css("font-size","30"+"px");
            $(".right_port_span").css("line-height","18"+"px");
            $(".port_block4_content > span:first-child").css("font-size","30"+"px");
        }
        if (wid>1530){
            $(".resize_footer_span").css("padding-right","8"+"%");
            $(".resize_footer_span").css("padding-right","8"+"%");
            $(".port_block4_content > div").css("padding-left","3"+"%");
            $(".left_port_span").css("font-size","40"+"px");
            $(".right_port_span").css("line-height","23"+"px");
            $(".port_block4_content > span:first-child").css("font-size","36"+"px");  
        }

        if (wid<1320){
            $(".port_resize").css("width","95"+"%");  
            $(".port_block1").css("height","auto"); 
            $(".port_block2").css("height","auto"); 
            $(".port_block3").css("height","auto"); 
            $(".block3_img").css("height","auto"); 
        }

        if (wid<1220){
            $(".port_block4_content > span:first-child").css({"font-size": "24px",});
            $(".left_port_span").css({"font-size": "24px",});
            $(".right_port_span").css({"font-size": "14px",});
            $(".port_block4_content > div").css({"padding-left": "10px","margin-top" : "50px","height":"40px"});
            //$(".port_block4_content > div:nth-child(3)").css({"width":"115px"});
        }
    }

    $(document).ready(function(){
        port_resize();
    })

    $(window).bind("resize",function() {
        port_resize();
    })

</script>

<?//arshow($arResult);?>
<div class="port_detail">



    <div class="port_header" style="background-image: url(<?=$arResult["DETAIL_PICTURE"]["SRC"]?>)">

        <h1><?=$arResult["PROPERTIES"]["SITE_TYPE"]["VALUE"]?> "<?=$arResult["NAME"]?>"</h1>
        <a href="http://<?=$arResult["PROPERTIES"]["PORT_LINK"]["VALUE"]?>/"><?=$arResult["PROPERTIES"]["PORT_LINK"]["VALUE"]?></a> 
        <div></div>  

    </div>

    <?//arshow($arResult["PROPERTIES"])
        $n=1;
        if ($arResult["PROPERTIES"]["SHOW_BLOCK1"]["VALUE"]=="Y"){?>

        <div class="port_block1">



            <div class="port_number">0<?=$n?></div>
            <h3 class="port_h3"><?=$arResult["PROPERTIES"]["HEADER_BLOCK1"]["VALUE"]?></h3>

            <div class="block1_content port_resize">
                <div>
                    <?$pic=CFile::GetPath(
                            $arResult["PROPERTIES"]["PICTURE_BLOCK1"]["VALUE"]
                        );?>

                    <img src="<?=$pic?>">
                </div>

                <div id="text_block1">
                    <?=$arResult["PROPERTIES"]["TEXT_BLOCK1"]["~VALUE"]["TEXT"]?>
                </div>  


            </div>


        </div>

        <?$n++;} 

        if ($arResult["PROPERTIES"]["SHOW_BLOCK2"]["VALUE"]=="Y"){ ?>


        <div class="block1_footer">
            <img src="/i/img_fot1.png">
            <h3 class="port_h3"><?=$arResult["PROPERTIES"]["HEADER_BLOCK2"]["VALUE"]?></h3>
            <div class="port_resize"><?=$arResult["PROPERTIES"]["TEXT_BLOCK2"]["VALUE"]["TEXT"]?></div>         
        </div>

        <?}?>


    <?if ($arResult["PROPERTIES"]["SHOW_BLOCK3"]["VALUE"]=="Y"){?>
        <div class="port_block2">
            <div class="port_number">0<?=$n?></div>
            <h3 class="port_h3"><?=$arResult["PROPERTIES"]["HEADER_BLOCK3"]["VALUE"]?></h3>

            <div class="block2_content port_resize">
                <div>                  
                    <?=$arResult["PROPERTIES"]["TEXT_BLOCK3"]["~VALUE"]["TEXT"]?>
                </div>
                <?$pic=CFile::GetPath(
                        $arResult["PROPERTIES"]["PICTURE_BLOCK3"]["VALUE"]
                    );?>
                <div id="port_img"><img src="<?=$pic?>"></div>       

            </div>   

        </div>
        <?$n++;
    }?>

    <?if ($arResult["PROPERTIES"]["SHOW_BLOCK4"]["VALUE"]=="Y"){?>
        <div class="port_block3">
            <div class="port_number">0<?=$n?></div>
            <h3 class="port_h3"><?=$arResult["PROPERTIES"]["HEADER_BLOCK4"]["VALUE"]?></h3>
            <?
                    //$picParam=CFile::GetFileArray( $picture );
                    $bufParam=0;
                    //arshow($arResult["PROPERTIES"]["M_PICTURE_BLOCK4"]["VALUE"]);
                    foreach($arResult["PROPERTIES"]["M_PICTURE_BLOCK4"]["VALUE"] as $picturePar) {
                        $picParam=CFile::GetFileArray( $picturePar );
//                        arshow($picParam["HEIGHT"]);
                        if ($bufParam<$picParam["HEIGHT"]){
                            $bufParam=$picParam["HEIGHT"];
                        ?>
                        <?
                        }
                    }
                ?>
                <script type="text/javascript">
                    $(window).load(function () {
                        bf='<?=$picParam["HEIGHT"]?>';
//                        alert(bf);
                        $(".block3_img").css("height",bf+"px");
                    }); 

                </script>
            <?if (!empty($arResult["PROPERTIES"]["M_PICTURE_BLOCK4"]["VALUE"])):?>
                <div class="block3_img port_resize">

                    <?foreach($arResult["PROPERTIES"]["M_PICTURE_BLOCK4"]["VALUE"] as $picture):
                            $pic=CFile::GetPath( $picture );
                        ?>

                        <div><img src="<?=$pic?>"> </div>
                        <?endforeach?>
                </div>
                <?endif?>
            <? $pic=CFile::GetPath(
                    $arResult["PROPERTIES"]["PICTURE_BLOCK4"]["VALUE"]
                );?>


            <div class="block3_content port_resize">
                <div>
                    <?
                        //                       arshow($picParam);
                    ?>
                    <img src="<?=$pic?>"></div>


                <div class="block3_text">
                    <?$temp=explode("_", $arResult["PROPERTIES"]["TEMPLATES_BLOCK4"]["VALUE"])?>

                    <div><?=$temp[0]?></div>

                    <div><?=$temp[1]?></div>

                    <?=$arResult["PROPERTIES"]["TEXT_BLOCK4"]["~VALUE"]["TEXT"]?>    
                </div>

            </div>

        </div>

        <?$n++;
    }?>
    <div class="port_block4">

        <div class="port_block4_content">

            <span class="resize_footer_span">Итоги работы:</span>

            <?$i=1;
                foreach ($arResult["PROPERTIES"]["BLOCK5"]["VALUE"] as $arItem):
                    if ($i==1){
                        $id="id='border_none'";
                    }
                    else{
                        $id="";   
                    }
                    $block5=explode("_",$arItem);
                    //arshow($block5);
                ?>


                <div <?=$id?>>
                    <span class="left_port_span"><?=$block5[0]?></span>  
                    <span class="right_port_span"><?=$block5[1]?></span>   
                </div>  
                <?$i++;
                    endforeach?> 

        </div>


    </div>


    <div class="port_footer">

        <img src="/i/tr_port.png">
        <h3>1-с Битрикс</h3>
        <div id="port_footer_text"><?=$arResult["PROPERTIES"]["FOOTER_BLOCK"]["~VALUE"]["TEXT"]?></div>





    </div>





</div>