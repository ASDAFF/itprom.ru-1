<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult['VARIANTS'] = array();
if (isset($arParams['PAGE_TO_LIST'])) {
    foreach ($arParams['PAGE_TO_LIST'] as $k => $page) {
        if (intval($page) > 0) {
            $arResult['VARIANTS'][$k]['TITLE'] = intval($page);
            $arResult['VARIANTS'][$k]['VALUE'] = intval($page);
            if (intval($arParams['PAGE_ELEMENT_COUNT']) > 0 && intval($arParams['PAGE_ELEMENT_COUNT']) == intval($page)) {
                $arResult['VARIANTS'][$k]['SELECTED'] = "Y";
            }
        } elseif ($page == "ALL") {
            $arResult['VARIANTS'][$k]['TITLE'] = GetMessage("PAGE_TO_SHOW_ALL");
            $arResult['VARIANTS'][$k]['VALUE'] = "ALL";
            if ($arParams['PAGE_ELEMENT_COUNT'] == 999999999) {
                $arResult['VARIANTS'][$k]['SELECTED'] = "Y";
            }
        }
    }
}
$this->IncludeComponentTemplate();
?>
