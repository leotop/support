<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("РђРІС‚РѕСЂРёР·Р°С†РёСЏ 3.0");
?>

<?php
// Сообщение
$message = "Line 1\r\nLine 2\r\nLine 3";

// На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Отправляем
echo mail('web-ajFcTD@mail-tester.com', 'My Subject', $message);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>