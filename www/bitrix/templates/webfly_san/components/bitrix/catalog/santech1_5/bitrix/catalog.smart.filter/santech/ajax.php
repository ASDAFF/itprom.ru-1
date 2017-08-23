<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

//define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
//addMessage2Log($arResult);
$APPLICATION->RestartBuffer();
echo "<!--JSON-->";
unset($arResult["COMBO"]);
echo str_replace("'",'"',CUtil::PHPToJSObject($arResult, true));
?>