<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
$aMenuLinksExt = array();

if(CModule::IncludeModule('iblock'))
{
    $catalogType = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_TYPE", false, SITE_ID);
    $catalogId = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_ID", false, SITE_ID);
    $arFilter = array(
        "TYPE" => $catalogType,
        "ID" => $catalogId,
        "SITE_ID" => SITE_ID,
    );

    $dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
    $dbIBlock = new CIBlockResult($dbIBlock);

    if ($arIBlock = $dbIBlock->GetNext())
    {
        if(defined("BX_COMP_MANAGED_CACHE"))
            $GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_".$arIBlock["ID"]);

        $aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "main", array(
            "IS_SEF" => "Y",
            "SEF_BASE_URL" => "",
            "SECTION_PAGE_URL" => $arIBlock['SECTION_PAGE_URL'],
            "DETAIL_PAGE_URL" => $arIBlock['DETAIL_PAGE_URL'],
            "IBLOCK_TYPE" => $arIBlock['IBLOCK_TYPE_ID'],
            "IBLOCK_ID" => $arIBlock['ID'],
            "DEPTH_LEVEL" => "1",
            "CACHE_TYPE" => "N",
        ), false, Array('HIDE_ICONS' => 'Y'));
    }

    if(defined("BX_COMP_MANAGED_CACHE"))
        $GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_new");
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>