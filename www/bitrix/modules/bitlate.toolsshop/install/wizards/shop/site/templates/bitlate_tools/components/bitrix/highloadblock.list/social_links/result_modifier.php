<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (CModule::IncludeModule('bitlate.toolsshop')) {
    usort($arResult['rows'], "NLApparelshopUtils::nl_highloadblock_sort");
}