<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult['SORT_VARIANTS'] = array();
$arResult['SORT'] = array();
$curSort = '';
if (isset($arParams['SORT_CODES']) && isset($arParams['SORT_FIELDS']) && isset($arParams['SORT_ORDERS']) && isset($arParams['SORT_NAME'])) {
    foreach ($arParams['SORT_CODES'] as $k => $code) {
        if ($curSort == '' || ($arParams['REQUEST_SORT'] != '' && $arParams['REQUEST_SORT'] == $code)) {
            $curSort = $code;
        }
        $arResult['SORT_VARIANTS'][$code]['title'] = $arParams['SORT_NAME'][$k];
        $fields = explode(';', $arParams['SORT_FIELDS'][$k]);
        $orders = explode(';', $arParams['SORT_ORDERS'][$k]);
        foreach ($fields as $n => $field) {
            $arResult['SORT_VARIANTS'][$code]['sort'][] = array(
                'FIELD' => $field,
                'ORDER'	=> $orders[$n],
            );
        }
    }
}
if (!empty($arResult['SORT_VARIANTS'][$curSort]['sort'][0])) {
    $arResult['SORT_VARIANTS'][$curSort]['SELECTED'] = 'Y';
    $arResult['SORT'][0] = $arResult['SORT_VARIANTS'][$curSort]['sort'][0];
    if (!empty($arResult['SORT_VARIANTS'][$curSort]['sort'][1])) {
        $arResult['SORT'][1] = $arResult['SORT_VARIANTS'][$curSort]['sort'][1];
    } else {
        $arResult['SORT'][1] = array(
            'FIELD' => 'NAME',
            'ORDER' => 'asc'
        );
    }
} else {
    $arResult['SORT'][0] = array(
        'FIELD' => 'NAME',
        'ORDER' => 'asc'
    );
}
$curView = COption::GetOptionString($arParams['MODULE_NAME'], 'NL_CATALOG_VIEW', false, SITE_ID);
$arResult['VIEW_DEFAULT'] = $curView;
if (CModule::IncludeModule($arParams['MODULE_NAME'])) {
    $arResult['VIEW_VARIANTS'] = NLApparelshopUtils::getViewListInfo();
    if ($arParams['REQUEST_VIEW'] != '') {
        if (array_key_exists($arParams['REQUEST_VIEW'], NLApparelshopUtils::getViewList())) {
            $curView = $arParams['REQUEST_VIEW'];
        }
    }
}
$arResult['VIEW'] = $curView;
$this->IncludeComponentTemplate();
return $arResult;
?>
