<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult['VARIANTS'] = array();
$arResult['SORT'] = array();
$curSort = '';
if (isset($arParams['SORT_CODES']) && isset($arParams['SORT_FIELDS']) && isset($arParams['SORT_ORDERS']) && isset($arParams['SORT_NAME'])) {
    foreach ($arParams['SORT_CODES'] as $k => $code) {
        if ($curSort == '' || ($arParams['REQUEST_SORT'] != '' && $arParams['REQUEST_SORT'] == $code)) {
            $curSort = $code;
        }
        $arResult['VARIANTS'][$code]['title'] = $arParams['SORT_NAME'][$k];
        $fields = explode(';', $arParams['SORT_FIELDS'][$k]);
        $orders = explode(';', $arParams['SORT_ORDERS'][$k]);
        foreach ($fields as $n => $field) {
            $arResult['VARIANTS'][$code]['sort'][] = array(
                'FIELD' => $field,
                'ORDER'	=> $orders[$n],
            );
        }
    }
}
if (!empty($arResult['VARIANTS'][$curSort]['sort'][0])) {
    $arResult['VARIANTS'][$curSort]['SELECTED'] = 'Y';
    $arResult['SORT'][0] = $arResult['VARIANTS'][$curSort]['sort'][0];
    if (!empty($arResult['VARIANTS'][$curSort]['sort'][1])) {
        $arResult['SORT'][1] = $arResult['VARIANTS'][$curSort]['sort'][1];
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
if ($arParams["REQUEST_LOAD"] != "Y") {
    $this->IncludeComponentTemplate();
}
return $arResult['SORT'];
?>
