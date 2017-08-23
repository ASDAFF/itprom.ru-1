<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult['PAGE_TO_LIST'] = array();
$curPageElement = 0;
if (isset($arParams['PAGE_TO_LIST'])) {
    foreach ($arParams['PAGE_TO_LIST'] as $page) {
        if (intval($page) > 0) {
            $arResult['PAGE_TO_LIST'][] = intval($page);
            if ($curPageElement == 0 || (intval($arParams['REQUEST_PAGE_EL_COUNT']) > 0 && intval($arParams['REQUEST_PAGE_EL_COUNT']) == intval($page))) {
                $curPageElement = intval($page);
            }
        } elseif ($page == "ALL") {
            $arResult['PAGE_TO_LIST'][] = "ALL";
            if ($curPageElement == 0 || $arParams['REQUEST_PAGE_EL_COUNT'] == "ALL") {
                $curPageElement = 999999999;
            }
        }
    }
}
$arResult['PAGE_ELEMENT_COUNT'] = $curPageElement;
return $arResult;
?>
