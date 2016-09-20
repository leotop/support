<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); ?>
<h1>Импорт адресов</h1>
<?
  /*
  CModule::IncludeModule("subscribe");
  CModule::IncludeModule("iblock");
  function arShow($array){  	echo "<pre>";
  	print_r($array);
  	echo "</pre>";  }

  $f = fopen("webgk.txt", "r");
  $filseze = filesize("webgk.txt");
  $data = fread($f, $filseze);
  fclose($f);
  $array = unserialize($data);

  $f = fopen("finros.txt", "r");
  $filseze = filesize("finros.txt");
  $data2 = fread($f, $filseze);
  fclose($f);
  $array2 = unserialize($data2);

  $result = array_merge($array, $array2);

  $counter = 0;

  foreach($result as $item){    $counter++;
    $subscriber_link = CSubscription::GetByEmail(trim($item["email"]));
    $subscriber = $subscriber_link->GetNext();

    if($subscriber["ID"]){
      $email = trim($subscriber["EMAIL"]);
      $organization = $item["name"];
      $contact = $item["lico"];

      if(check_email($email)){
        // проверим, нет ли такого уже у нас в инфоблоке
        $res = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 4, "NAME" => $email), false, false, array());
        $line = $res->getNextElement();
        if(!is_array($line->fields)){        	$el = new CIBlockElement;

          $PROP = array();
          $PROP[1] = $organization;
          $PROP[2] = $contact;

          $arLoadProductArray = Array(
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID"      => 4,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $email,
            "ACTIVE"         => "Y"
          );

          $PRODUCT_ID = $el->Add($arLoadProductArray);
          echo $PRODUCT_ID."<br/>";
        }
      }
    }

  }

  //arShow($result);
  */
?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>