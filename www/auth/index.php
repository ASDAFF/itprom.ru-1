<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
$backurl = (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0) ? $_REQUEST["backurl"] : SITE_DIR;
LocalRedirect($backurl);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>