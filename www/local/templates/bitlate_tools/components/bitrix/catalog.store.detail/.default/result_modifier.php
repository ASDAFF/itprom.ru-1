<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$storeRes = CCatalogStore::GetList(array("SORT" => "ASC"), array("ID" => $arResult['ID']), false, false, array("*"));
while($arStoreParam = $storeRes->Fetch()){
    $arResult["EMAIL"] = $arStoreParam["EMAIL"];
    $arResult["IMAGE_ID"] = $arStoreParam["IMAGE_ID"];
}

$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("CAT_STORE", $arResult['ID']);
foreach ($arUF as $name => $value) {
    if ($name == 'UF_NL_SHOP_PHOTOS' && count($value["VALUE"]) > 0) {
        foreach ($value["VALUE"] as $photoId) {
            if (intval($photoId) > 0) {
                $arResult["SHOP_PHOTOS"][] = $photoId;
            }
        }
    }
}
$cp = $this->__component;

if (is_object($cp))
{
    $cp->arResult['NAV_NAME'] = ($arResult["TITLE"] != '') ? $arResult["TITLE"] . " (" . $arResult["ADDRESS"] . ")" : $arResult["ADDRESS"];
    $cp->SetResultCacheKeys(array(
        "ID",
        "TITLE",
        "ADDRESS",
        "DESCRIPTION",
        "GPS_N",
        "GPS_S",
        "IMAGE_ID",
        "PHONE",
        "SCHEDULE",
        "NAV_NAME",
    ));
}