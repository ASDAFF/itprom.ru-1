<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arParams['REQUEST_LOAD'] != "Y") {
    $arResult["ACTIONS_ACTIVE"] = false;
    $arResult["ACTIONS_INACTIVE"] = false;
    $arFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        array(
            "LOGIC" => "OR",
            array(">=DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime(date("Y-m-d") . ' 00:00:00'),"FULL")),
            array(">=DATE_ACTIVE_TO" => ConvertTimeStamp(strtotime(date("Y-m-d") . ' 00:00:00'),"FULL")),
        )
    );
    $res = CIBlockElement::GetList(array("DATE_ACTIVE_FROM" => "DESC", "DATE_ACTIVE_TO" => "DESC"), $arFilter, false, array("nPageSize"=>1), array());
    while($arFields = $res->GetNext()) {
        $arResult["ACTIONS_ACTIVE"] = true;
    }
    $arFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        array(
            "LOGIC" => "OR",
            array("<DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime(date("Y-m-d") . ' 00:00:00'),"FULL"), "DATE_ACTIVE_TO" => false),
            array("<DATE_ACTIVE_TO" => ConvertTimeStamp(strtotime(date("Y-m-d") . ' 00:00:00'),"FULL"), "!DATE_ACTIVE_TO" => false),
        )
    );
    $res = CIBlockElement::GetList(array("DATE_ACTIVE_FROM" => "DESC", "DATE_ACTIVE_TO" => "DESC"), $arFilter, false, array("nPageSize"=>1), array());
    while($arFields = $res->GetNext()) {
        $arResult["ACTIONS_INACTIVE"] = true;
    }
}