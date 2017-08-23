<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$boolActive = false;
foreach ($arResult['SECTIONS'] as $i => $arSection) {
    if ($arSection['RELATIVE_DEPTH_LEVEL'] == 1) {
        $boolActive = ($arSection['ID'] == $arParams["CUR_SECTION_ID"]) ? true : false;
    }
    if ($arSection['RELATIVE_DEPTH_LEVEL'] > 1 && !$boolActive) {
        unset($arResult['SECTIONS'][$i]);
    }
}
?>