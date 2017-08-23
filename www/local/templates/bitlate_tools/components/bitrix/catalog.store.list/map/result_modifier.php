<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult["STORE"] = array();
if (is_array($arResult["STORES"]) && !empty($arResult["STORES"])) {
    foreach ($arResult["STORES"] as $pid => $arProperty) {
        $arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("CAT_STORE", $arProperty['ID']);
        foreach ($arUF as $name => $value) {
            if ($name == 'UF_NL_SHOP_MAIN' && $value["VALUE"] == 1) {
                $arResult["STORE"] = $arResult["STORES"][$pid];
                $storeRes = CCatalogStore::GetList(array("SORT" => "ASC"), array("ID" => $arProperty['ID']), false, false, array("*"));
                while($arStoreParam = $storeRes->Fetch()){
                    $arResult["STORE"]["IMAGE_ID"] = $arStoreParam["IMAGE_ID"];
                    $arResult["STORE"]["EMAIL"] = $arStoreParam["EMAIL"];
                    $arResult["STORE"]["ADDRESS"] = $arStoreParam["ADDRESS"];
                }
                break;
            }
        }
        if ($arResult["STORE"]) {
            break;
        }
    }
}