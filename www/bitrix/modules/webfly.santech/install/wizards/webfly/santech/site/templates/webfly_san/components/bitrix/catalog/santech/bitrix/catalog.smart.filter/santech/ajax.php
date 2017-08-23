<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$APPLICATION->RestartBuffer();
echo "<!--JSON-->";
unset($arResult["COMBO"]);
echo str_replace("'",'"',CUtil::PHPToJSObject($arResult, true));
?>