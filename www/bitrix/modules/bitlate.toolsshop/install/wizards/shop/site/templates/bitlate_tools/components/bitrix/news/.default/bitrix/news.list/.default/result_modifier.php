<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arParams['REQUEST_LOAD'] != "Y") {
    $yearStart = 0;
    $yearEnd = 0;
    $arResult["YEARS"] = array();
    $res = CIBlockElement::GetList(array("DATE_ACTIVE_FROM" => "DESC"), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"), false, array("nPageSize"=>1), array("DATE_ACTIVE_FROM"));
    while($arFields = $res->GetNext()) {
        $yearEnd = date("Y", strtotime($arFields['DATE_ACTIVE_FROM']));
    }
    $res = CIBlockElement::GetList(array("DATE_ACTIVE_FROM" => "ASC"), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y"), false, array("nPageSize"=>1), array("DATE_ACTIVE_FROM"));
    while($arFields = $res->GetNext()) {
        $yearStart = date("Y", strtotime($arFields['DATE_ACTIVE_FROM']));
    }
    if ($yearStart > 0 && $yearEnd > 0) {
        for ($year = $yearEnd; $year >= $yearStart; $year--) {
            if ($year != $yearStart && $year != $yearEnd) {
                $res = CIBlockElement::GetList(array("DATE_ACTIVE_FROM" => "DESC"), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", array(">=DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime($year . '-01-01 00:00:00'),"FULL")), array("<DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime(($year + 1) . '-01-01 00:00:00'),"FULL")),), false, array("nPageSize"=>1), array());
                while($arFields = $res->GetNext()) {
                    $arResult["YEARS"][] = $year;
                }
            } else {
                $arResult["YEARS"][] = $year;
            }
        }
    }
}