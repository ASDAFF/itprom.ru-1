<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);

$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",
);
$arFilterParent = $arFilter;
if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
    $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
    $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
{
    $arCurSection = $obCache->GetVars();
}
elseif ($obCache->StartDataCache())
{
    $arCurSection = array();
    if (Loader::includeModule("iblock"))
    {
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID", "IBLOCK_SECTION_ID", "DEPTH_LEVEL"));

        if(defined("BX_COMP_MANAGED_CACHE"))
        {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

            if ($arCurSection = $dbRes->Fetch())
                $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

            $CACHE_MANAGER->EndTagCache();
        }
        else
        {
            if(!$arCurSection = $dbRes->Fetch())
                $arCurSection = array();
        }
        if ($arCurSection) {
            if ($arCurSection["DEPTH_LEVEL"] > 2) {
                $arFilterParent["ID"] = $arCurSection["IBLOCK_SECTION_ID"];
                $i = 0;
                do {
                    $dbResParent = CIBlockSection::GetList(array(), $arFilterParent, false, array("ID", "IBLOCK_SECTION_ID", "DEPTH_LEVEL"));
                    $arParentSection = $dbResParent->Fetch();
                    if (!$arParentSection) {
                        break;
                    }
                    $arFilterParent["ID"] = $arParentSection["IBLOCK_SECTION_ID"];
                    $arCurSection["ROOT_SECTION_ID"] = $arParentSection["IBLOCK_SECTION_ID"];
                } while ($arParentSection["DEPTH_LEVEL"] > 2 && $i < 10);
            } elseif ($arCurSection["DEPTH_LEVEL"] == 2) {
                $arCurSection["ROOT_SECTION_ID"] = $arCurSection["IBLOCK_SECTION_ID"];
            } else {
                $arCurSection["ROOT_SECTION_ID"] = $arCurSection["ID"];
            }
        }
    }
    $obCache->EndDataCache($arCurSection);
}
if (!isset($arCurSection))
    $arCurSection = array();
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "breadcrumbs",
    array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "SECTION_ID" => '',
        "CUR_SECTION_ID" => $arCurSection["ID"],
        "ROOT_SECTION_ID" => $arCurSection["ROOT_SECTION_ID"],
        "SECTION_CODE" => $arParams["SECTION_CODE"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
        "TOP_DEPTH" => 999,
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
        "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
        "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
        "ADD_SECTIONS_CHAIN" => "N",
    ),
    $component,
    array("HIDE_ICONS" => "Y")
);?>