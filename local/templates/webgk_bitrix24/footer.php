</div>
</div>

<div class="footer-line"></div>

<div class="footer2">    
            <div class="foot_content">
                <div class="footer_text">
                <img class="footer-image" src="/i/footer-img.png">
                КОМПАНИЙ ИСПОЛЬЗУЮТ <font>БИТРИКС24</font>
                </div>
                <!--<div class="shadow">
                    <img src="/i/ten.png" alt="">
                </div>-->
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
     

        <!--//Нижнее меню-->
    </body>
</html>