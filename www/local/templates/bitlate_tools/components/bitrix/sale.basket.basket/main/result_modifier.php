<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$productIds = array();
$productIblocksIds = array();
$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
if ($normalCount > 0) {
    foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
        if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y") {
            $productIds[$k] = $arItem["PRODUCT_ID"];
        }
    }
}
if ($productIds) {
    $res = CIBlockElement::GetList(array(), array('ID' => $productIds), false, false, array("ID", "IBLOCK_ID"));
    while ($arRes = $res->GetNext()) {
        $productIblocksIds[$arRes['IBLOCK_ID']][] = $arRes['ID'];
    }
}
foreach ($productIblocksIds as $iblockId => $ids) {
    $mxResult = CCatalogSKU::GetInfoByOfferIBlock($iblockId);
    if ($mxResult === false) {
        foreach ($ids as $id) {
            $resProp = CIBlockElement::GetProperty($iblockId, $id, array("sort" => "asc"), array("CODE" => "OLD_PRICE"));
            if ($arResProp = $resProp->GetNext()) {
                $key = array_search($id, $productIds);
                $arResult["GRID"]["ROWS"][$key]['OLD_PRICE'] = $arResProp['VALUE'];
            }
        }
    } else {
        $propsValues = array();
        foreach ($ids as $id) {
            $res = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $mxResult['IBLOCK_ID'], 'ID' => $id), false, false, array("ID", "IBLOCK_ID", "NAME", "PROPERTY_" . $mxResult['SKU_PROPERTY_ID']));
            while ($arRes = $res->GetNext()) {
                $parentId = $arRes["PROPERTY_" . $mxResult['SKU_PROPERTY_ID'] . "_VALUE"];
                if (!$propsValues[$parentId]) {
                    $resProp = CIBlockElement::GetProperty($mxResult['PRODUCT_IBLOCK_ID'], $parentId, array("sort" => "asc"), array("CODE" => "OLD_PRICE"));
                    if ($arResProp = $resProp->GetNext()) {
                        $propsValues[$parentId] = $arResProp['VALUE'];
                    }
                }
                $key = array_search($id, $productIds);
                $arResult["GRID"]["ROWS"][$key]['OLD_PRICE'] = $propsValues[$parentId];
            }
        }
    }
}