<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if (!CModule::IncludeModule($arParams['MODULE_NAME']))
    return;

$arResult['THEME_LIST'] = NLApparelshopUtils::getThemeList();
$curTheme = $arParams['CUR_THEME'];
if (!in_array($curTheme, NLApparelshopUtils::getThemeListCode())) {
    $curTheme = $arResult['THEME_LIST'][5]['CODE'];
}
$arResult['CUR_THEME'] = $curTheme;
$this->IncludeComponentTemplate();
?>
