<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Авторизация 3.0");
?>

<?php
// ���������
$message = "Line 1\r\nLine 2\r\nLine 3";

// �� ������ ���� �����-�� ������ ������ ������� 70 �������� �� ���������� wordwrap()
$message = wordwrap($message, 70, "\r\n");

// ����������
echo mail('web-ajFcTD@mail-tester.com', 'My Subject', $message);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>