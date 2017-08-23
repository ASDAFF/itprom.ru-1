<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (is_array($arResult["STORES"]) && !empty($arResult["STORES"])) {
    foreach ($arResult["STORES"] as $pid => $arProperty) {
        $storeRes = CCatalogStore::GetList(array("SORT" => "ASC"), array("ID" => $arProperty['ID']), false, false, array("IMAGE_ID"));
        while($arStoreParam = $storeRes->Fetch()){
            $arResult["STORES"][$pid]["IMAGE_ID"] = $arStoreParam["IMAGE_ID"];
        }

        $arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("CAT_STORE", $arProperty['ID']);
        foreach ($arUF as $name => $value) {
            if ($name == 'UF_NL_SHOP_METRO' && strlen(trim($value["VALUE"])) > 0) {
                $arResult["STORES"][$pid]["SHOP_METRO"] = trim($value["VALUE"]);
            }
        }
    }
}