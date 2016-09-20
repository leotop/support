<?
$_SERVER["DOCUMENT_ROOT"] = "/srv/www/support.de.osg.ru/htdocs";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
set_time_limit(0);
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
$push = new SupportPush();
$push->runStatusCases();
?>