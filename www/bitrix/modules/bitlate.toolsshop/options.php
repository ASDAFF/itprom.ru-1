<?
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Iblock;
use Bitrix\Currency;

global $DOCUMENT_ROOT;

if(!$USER->IsAdmin())
    return;
if (!CModule::IncludeModule('bitlate.toolsshop'))
    return;
if (!Loader::includeModule('iblock'))
    return;
$catalogIncluded = Loader::includeModule('catalog');

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/options.php");
IncludeModuleLangFile(__FILE__);
CJSCore::Init(array("jquery"));

$arSites = array();
$arSitesDir = array();
$rsSites = CSite::GetList($by = 'sort', $order = 'asc', array());
$aTabs = array();
while ($arSite = $rsSites->Fetch()) {
    $catalogId = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_ID", 0, $arSite["LID"]);
    if (intval($catalogId) > 0) {
        $arSites[] = array($arSite["LID"] => $arSite["NAME"]);    
        $arSitesDir[$arSite["LID"]] = $arSite["DIR"];    
        $aTabs[] = array("DIV" => "edit{$arSite["LID"]}", "TAB" => "[{$arSite["LID"]}] " . $arSite["NAME"], "ICON" => "ib_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET"));
    }
};

$arIBlockType = CIBlockParameters::GetIBlockTypes();
$arIBlock = array();
$arIblockIds = array();
$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), array('ACTIVE' => 'Y'));
$offersIblocks = array();
$offersInfoIblocks = array();
$offersProps = array();
while ($arr = $rsIBlock->Fetch()) {
    $arIBlock[$arr['IBLOCK_TYPE_ID']][$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
    $arIblockIds[] = $arr['ID'];
    $mxResult = CCatalogSKU::GetInfoByOfferIBlock($arr['ID']);
    if ($mxResult !== false) {
        $offersIblocks[$mxResult['PRODUCT_IBLOCK_ID']] = $arr['ID'];
        $offersInfoIblocks[$mxResult['PRODUCT_IBLOCK_ID']] = array(
            'ID' => $arr['ID'],
            'IBLOCK_TYPE_ID' => $arr['IBLOCK_TYPE_ID'],
        );
    }
}
unset($arr, $rsIBlock);
$arPrice = array();
if ($catalogIncluded) {
    $arPrice = CCatalogIBlockParameters::getPriceTypesList();
}

$arIBlocksProps = array();
$rsPrors = CIBlockProperty::GetList(Array("IBLOCK_ID" => "asc", "sort"=>"asc"), Array("ACTIVE"=>"Y"));
while ($arProps = $rsPrors->GetNext()) {
    if (in_array($arProps["IBLOCK_ID"], $offersIblocks)) {
        $key = array_search($arProps["IBLOCK_ID"], $offersIblocks);
        $offersProps[$key][$arProps["CODE"]] = '['.$arProps['ID'].']['.$arProps['CODE'].'] '.$arProps['NAME'];
    }
    $arIBlocksProps[$arProps["IBLOCK_ID"]][$arProps["CODE"]] = '['.$arProps['ID'].']['.$arProps['CODE'].'] '.$arProps['NAME'];
}

$arStore = array();
if ($catalogIncluded) {
	$storeIterator = CCatalogStore::GetList(
		array(),
		array('SHIPPING_CENTER' => 'Y'),
		false,
		false,
		array('ID', 'TITLE')
	);
	while ($store = $storeIterator->GetNext())
		$arStore[$store['ID']] = "[".$store['ID']."] ".$store['TITLE'];
}

$arAllOptions = array(
    GetMessage("NL_SHOP_BLOCK_SET"),
    
    array("NL_SHOP_RUB", GetMessage("NL_SHOP_RUB_TITLE"), "N",array("checkbox", "Y")),
    array("NL_CATALOG_REVIEWS_MODERATE", GetMessage("NL_SHOP_REVIEWS_MODERATE_TITLE"), "N", array("checkbox", "Y")),
    array("NL_CATALOG_VIEW", GetMessage("NL_CATALOG_VIEW_TITLE"), "board", array("selectbox", NLApparelshopUtils::getViewList())),
    array("NL_CATALOG_PRICE_COMPOSITE", GetMessage("NL_CATALOG_PRICE_COMPOSITE_TITLE"), "N", array("checkbox", "N"), false, GetMessage("NL_CATALOG_PRICE_COMPOSITE_DESCR")),
    
    GetMessage("NL_REQUEST_CALL_BLOCK_SET"),
    
    array("NL_REQUEST_CALL_OKKADD_MESS", GetMessage("NL_REQUEST_CALL_OKKADD_MESS_TITLE"), GetMessage("NL_REQUEST_CALL_OKKADD_MESS_DEFAULT"), array("textarea", 3, 60)),
    array("NL_REQUEST_CALL_EMAIL", GetMessage("NL_REQUEST_CALL_EMAIL_TITLE"), "", array("text", 20)),
    
    GetMessage("NL_BUY1CLICK_BLOCK_SET"),
    
    array("NL_BUY1CLICK_OKKADD_MESS", GetMessage("NL_BUY1CLICK_OKKADD_MESS_TITLE"), GetMessage("NL_BUY1CLICK_OKKADD_MESS_DEFAULT"), array("textarea", 3, 60)),
    array("NL_BUY1CLICK_EMAIL", GetMessage("NL_BUY1CLICK_EMAIL_TITLE"), "", array("text", 20)),
    
    GetMessage("NL_SERVICE_ORDER_BLOCK_SET"),
    
    array("NL_SERVICE_ORDER_OKKADD_MESS", GetMessage("NL_SERVICE_ORDER_OKKADD_MESS_TITLE"), GetMessage("NL_SERVICE_ORDER_OKKADD_MESS_DEFAULT"), array("textarea", 3, 60)),
    array("NL_SERVICE_ORDER_EMAIL", GetMessage("NL_SERVICE_ORDER_EMAIL_TITLE"), "", array("text", 20)),
    
    GetMessage("NL_CATALOG_BLOCK_SET"),
    
    GetMessage("NL_CATALOG_BLOCK_DATA_SET"),
    
    array("NL_CATALOG_TYPE", GetMessage("NL_CATALOG_TYPE_TITLE"), "N",array("IBLOCK_TYPE", $arIBlockType)),
    array("NL_CATALOG_ID", GetMessage("NL_CATALOG_ID_TITLE"), "N",array("IBLOCK_ID", $arIBlock)),
    array("NL_CATALOG_PROPERTY_CODE", GetMessage("NL_CATALOG_PROPERTY_CODE_TITLE"), "N", array("PROPERTY_CODE", $arIBlocksProps)),
    array("NL_CATALOG_OFFERS_PROPERTY_CODE", GetMessage("NL_CATALOG_OFFERS_PROPERTY_CODE_TITLE"), "N",array("PROPERTY_CODE_OFFERS", $offersProps)),
    array("NL_CATALOG_CART_PRODUCT_PROPERTIES_CODE", GetMessage("NL_CATALOG_CART_PRODUCT_PROPERTIES_CODE_TITLE"), "N",array("PROPERTY_CODE", $arIBlocksProps)),
    array("NL_CATALOG_CART_OFFERS_PROPERTY_CODE", GetMessage("NL_CATALOG_CART_OFFERS_PROPERTY_CODE_TITLE"), "N",array("PROPERTY_CODE_OFFERS", $offersProps)),
    array("NL_CATALOG_PRICE_CODE", GetMessage("NL_CATALOG_PRICE_CODE_TITLE"), "N",array("multyselectbox", $arPrice)),
    array("NL_HIDE_NOT_AVAILABLE", GetMessage("NL_HIDE_NOT_AVAILABLE_TITLE"), false, array("selectbox", array(
        'N' => GetMessage("NL_HIDE_NOT_AVAILABLE_DEFAULT_3"),
        'L' => GetMessage("NL_HIDE_NOT_AVAILABLE_DEFAULT_2"),
        'Y' => GetMessage("NL_HIDE_NOT_AVAILABLE_DEFAULT_1"),
    ))),
    
    GetMessage("NL_CATALOG_BLOCK_VIEW_SET"),
    
    array("NL_CATALOG_COMPONENT_TEMPLATE", GetMessage("NL_CATALOG_COMPONENT_TEMPLATE_TITLE"), "", array("text", 20)),
    array("NL_CATALOG_MAIN_LIST", GetMessage("NL_CATALOG_MAIN_LIST_TITLE"), false, array("checkbox", "Y")),
    array("NL_CATALOG_ADD_PICT_PROP", GetMessage("NL_CATALOG_ADD_PICT_PROP_TITLE"), false, array("PROPERTY_CODE", $arIBlocksProps, false)),
    array("NL_CATALOG_OFFER_ADD_PICT_PROP", GetMessage("NL_CATALOG_OFFER_ADD_PICT_PROP_TITLE"), false, array("PROPERTY_CODE_OFFERS", $offersProps, false)),
    
    GetMessage("NL_CATALOG_BLOCK_SORT_SET"),
    
    array("NL_CATALOG_SORT_LIST_CODES", GetMessage("NL_CATALOG_SORT_LIST_CODES_TITLE"), false, array("multytext", 20)),
    array("NL_CATALOG_SORT_LIST_FIELDS", GetMessage("NL_CATALOG_SORT_LIST_FIELDS_TITLE"), false, array("multytext", 20)),
    array("NL_CATALOG_SORT_LIST_ORDERS", GetMessage("NL_CATALOG_SORT_LIST_ORDERS_TITLE"), false, array("multytext", 20)),
    array("NL_CATALOG_SORT_LIST_NAME", GetMessage("NL_CATALOG_SORT_LIST_NAME_TITLE"), false, array("multytext", 20)),
    
    GetMessage("NL_CATALOG_BLOCK_COMPARE_SET"),
    
    array("NL_CATALOG_USE_COMPARE", GetMessage("NL_CATALOG_USE_COMPARE_TITLE"), "N",array("checkbox", "Y")),
    
    GetMessage("NL_CATALOG_BLOCK_AMOUNT_SET"),
    
    array("NL_CATALOG_USE_AMOUNT", GetMessage("NL_CATALOG_USE_AMOUNT_TITLE"), false, array("checkbox", "Y")),
    array("NL_CATALOG_STORES", GetMessage("NL_CATALOG_STORES_TITLE"), "N",array("multyselectbox", $arStore)),
    array("NL_CATALOG_USE_MIN_AMOUNT", GetMessage("NL_CATALOG_USE_MIN_AMOUNT_TITLE"), false, array("checkbox", "Y")),
    array("NL_CATALOG_MIN_AMOUNT", GetMessage("NL_CATALOG_MIN_AMOUNT_TITLE"), false, array("text", 20)),
    array("NL_CATALOG_MAX_AMOUNT", GetMessage("NL_CATALOG_MAX_AMOUNT_TITLE"), false, array("text", 20)),
    
    GetMessage("NL_CATALOG_BLOCK_BIG_DATA_SET"),
    
    array("NL_CATALOG_USE_BIG_DATA", GetMessage("NL_CATALOG_USE_BIG_DATA_TITLE"), "N",array("checkbox", "Y")),
    array("NL_CATALOG_BIG_DATA_RCM_TYPE", GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_TITLE"), false, array("selectbox", array(
        'bestsell' => GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_DEFAULT_1"),
        'personal' => GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_DEFAULT_2"),
        'similar_sell' => GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_DEFAULT_3"),
        'similar_view' => GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_DEFAULT_4"),
        'similar' => GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_DEFAULT_5"),
        'any_similar' => GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_DEFAULT_6"),
        'any_personal' => GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_DEFAULT_7"),
        'any' => GetMessage("NL_CATALOG_BIG_DATA_RCM_TYPE_DEFAULT_8"),
    ))),
    
    GetMessage("NL_CATALOG_BLOCK_PAGER_SET"),
    
    array("NL_CATALOG_PAGE_TO_LIST", GetMessage("NL_CATALOG_PAGE_TO_LIST_TITLE"), false, array("multytext", 20)),
    
    GetMessage("NL_CATALOG_BLOCK_SEF_URL_SET"),
    
    array("NL_CATALOG_SEF_FOLDER", GetMessage("NL_CATALOG_SEF_FOLDER_TITLE"), "", array("text", 20), false, GetMessage("NL_CATALOG_SEF_FOLDER_DESCR")),
    array("NL_CATALOG_SEF_URL_TEMPLATES_SECTIONS", GetMessage("NL_CATALOG_SEF_URL_TEMPLATES_SECTIONS_TITLE"), "", array("text", 20, false)),
    array("NL_CATALOG_SEF_URL_TEMPLATES_SECTION", GetMessage("NL_CATALOG_SEF_URL_TEMPLATES_SECTION_TITLE"), "", array("text", 20), false, GetMessage("NL_CATALOG_SEF_URL_TEMPLATES_SECTION_DESCR")),
    array("NL_CATALOG_SEF_URL_TEMPLATES_ELEMENT", GetMessage("NL_CATALOG_SEF_URL_TEMPLATES_ELEMENT_TITLE"), "", array("text", 40), false, GetMessage("NL_CATALOG_SEF_URL_TEMPLATES_ELEMENT_DESCR")),
    array("NL_CATALOG_SEF_URL_TEMPLATES_COMPARE", GetMessage("NL_CATALOG_SEF_URL_TEMPLATES_COMPARE_TITLE"), "", array("text", 20)),
    array("NL_CATALOG_SEF_URL_TEMPLATES_SEARCH", GetMessage("NL_CATALOG_SEF_URL_TEMPLATES_SEARCH_TITLE"), "", array("text", 20)),
    
    GetMessage("NL_CATALOG_BLOCK_404_SET"),
    
    array("NL_SET_STATUS_404", GetMessage("NL_SET_STATUS_404_TITLE"), "N",array("checkbox", "Y")),
    array("NL_SHOW_404", GetMessage("NL_SHOW_404_TITLE"), "N",array("checkbox", "Y")),
    array("NL_MESSAGE_404", GetMessage("NL_MESSAGE_404_TITLE"), "", array("text", 20)),
    
    GetMessage("NL_SLIDER_SET"),
    
    array("NL_SLIDER_PAGE_ELEMENT_COUNT", GetMessage("NL_SLIDER_PAGE_ELEMENT_COUNT_TITLE"), "", array("text", 20)),
    array("NL_SLIDER_ELEMENT_SORT_FIELD", GetMessage("NL_SLIDER_ELEMENT_SORT_FIELD_TITLE"), "", array("text", 20), GetMessage("NL_SLIDER_ELEMENT_SORT_FIELD_HINT")),
    array("NL_SLIDER_ELEMENT_SORT_ORDER", GetMessage("NL_SLIDER_ELEMENT_SORT_ORDER_TITLE"), "", array("text", 20), GetMessage("NL_SLIDER_ELEMENT_SORT_ORDER_HINT")),
    array("NL_SLIDER_ELEMENT_SORT_FIELD2", GetMessage("NL_SLIDER_ELEMENT_SORT_FIELD2_TITLE"), "", array("text", 20), GetMessage("NL_SLIDER_ELEMENT_SORT_FIELD2_HINT")),
    array("NL_SLIDER_ELEMENT_SORT_ORDER2", GetMessage("NL_SLIDER_ELEMENT_SORT_ORDER2_TITLE"), "", array("text", 20), GetMessage("NL_SLIDER_ELEMENT_SORT_ORDER2_HINT")),
    
    GetMessage("NL_MAIN_TABS_SET"),
    
    array("NL_MAIN_TABS_PAGE_ELEMENT_COUNT", GetMessage("NL_MAIN_TABS_PAGE_ELEMENT_COUNT_TITLE"), "", array("text", 20)),
    array("NL_MAIN_TABS_ELEMENT_SORT_FIELD", GetMessage("NL_MAIN_TABS_ELEMENT_SORT_FIELD_TITLE"), "", array("text", 20), GetMessage("NL_MAIN_TABS_ELEMENT_SORT_FIELD_HINT")),
    array("NL_MAIN_TABS_ELEMENT_SORT_ORDER", GetMessage("NL_MAIN_TABS_ELEMENT_SORT_ORDER_TITLE"), "", array("text", 20), GetMessage("NL_MAIN_TABS_ELEMENT_SORT_ORDER_HINT")),
    array("NL_MAIN_TABS_ELEMENT_SORT_FIELD2", GetMessage("NL_MAIN_TABS_ELEMENT_SORT_FIELD2_TITLE"), "", array("text", 20), GetMessage("NL_MAIN_TABS_ELEMENT_SORT_FIELD2_HINT")),
    array("NL_MAIN_TABS_ELEMENT_SORT_ORDER2", GetMessage("NL_MAIN_TABS_ELEMENT_SORT_ORDER2_TITLE"), "", array("text", 20), GetMessage("NL_MAIN_TABS_ELEMENT_SORT_ORDER2_HINT")),
);
$generateOptions = NLApparelshopUtils::getGenerateOptions();
$arMultyOptions = NLApparelshopUtils::getMultyOptions();

$tabControl = new CAdminTabControl("tabControl", $aTabs);
$arErrors = array();
if ($_SERVER['REQUEST_METHOD'] == "POST" && (strlen($_POST['Update']) > 0 || strlen($_POST['Apply']) > 0) && check_bitrix_sessid())
{
    foreach ($arSites as $arSite) {
        $siteLID = key($arSite);
        $generate[$siteLID] = false;
        $iblockTypeSelected = false;
        $iblockIdSelected = false;
        foreach ($arAllOptions as $arOption) {
            if (is_array($arOption)) {
                $errorOption = false;
                $opName = $arOption[0];
                $opTitle = $arOption[1] . ((count($arSites) > 1) ? " [{$arSite[$siteLID]}]" : "");
                $name = $arOption[0] . "_" . $siteLID;
                $val = $_REQUEST[$name];
                switch ($arOption[3][0]) {
                    case "checkbox":
                        if ($val != "Y") {
                            $val = "N";
                        }
                        break;
                    case "text":
                    case "textarea":
                        if (strlen(trim($val)) <= 0) {
                            if ($arOption[3][2] !== false) {
                                $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_EMPTY"));
                                $errorOption = true;
                            }
                        } elseif (strlen(trim($val)) > 2000) {
                            $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_TOO_MUCH"));
                            $errorOption = true;
                        }
                        break;
                    case "multytext":
                        if (is_array($val)) {
                            foreach ($val as $k => $v) {
                                if (empty($v)) {
                                    unset($val[$k]);
                                } elseif (strlen(trim($v)) > 2000) {
                                    $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_TOO_MUCH"));
                                    $errorOption = true;
                                }
                            }
                            $val = implode('|', $val);
                        } else {
                            $val = '';
                        }
                        break;
                    case "selectbox":
                    case "IBLOCK_TYPE":
                        if (!array_key_exists($val, $arOption[3][1])) {
                            $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_NO_SELECT"));
                            $errorOption = true;
                        } elseif ($arOption[3][0] == "IBLOCK_TYPE") {
                            $iblockTypeSelected = $val;
                        }
                        break;
                    case "IBLOCK_ID":
                        $val = $val[$iblockTypeSelected];
                        if (!array_key_exists($val, $arOption[3][1][$iblockTypeSelected])) {
                            $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_NO_SELECT"));
                            $errorOption = true;
                        } else {
                            $iblockIdSelected = $val;
                        }
                        break;
                    case "PROPERTY_CODE":
                    case "PROPERTY_CODE_OFFERS":
                        $val = $val[$iblockIdSelected];
                        if (is_array($val)) {
                            foreach ($val as $v) {
                                if (!array_key_exists($v, $arOption[3][1][$iblockIdSelected])) {
                                    $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_NO_SELECT"));
                                    $errorOption = true;
                                    break;
                                }
                            }
                            if ($arOption[3][2] === false && count($val) > 1) {
                                $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_MORE_1_SELECT"));
                                $errorOption = true;
                                break;
                            }
                            $val = implode('|', $val);
                        } else {
                            $val = '';
                        }
                        break;
                    case "multyselectbox":
                        if (!is_array($val)) {
                            $val = array($val);
                        }
                        foreach ($val as $v) {
                            if (!array_key_exists($v, $arOption[3][1])) {
                                $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_NO_SELECT"));
                                $errorOption = true;
                                break;
                            }
                        }
                        $val = implode('|', $val);
                        break;
                }
                if ($errorOption === false && strpos($opName, 'EMAIL') !== false) {
                    if ($val != '#DEFAULT_EMAIL_FROM#' && !check_email($val)) {
                        $arErrors[] = str_replace("#FIELD_NAME#", $opTitle, GetMessage("NL_OPTION_NO_EMAIL"));
                        $errorOption = true;
                    }
                }
                if ($errorOption === false) {
                    if (in_array($opName, $generateOptions)) {
                        $oldVal = COption::GetOptionString("bitlate.toolsshop", $opName, $arOption[1], $siteLID);
                        if ($oldVal != $val) {
                            $generate[$siteLID] = true;
                        }
                        if (in_array($opName, array("NL_CATALOG_PROPERTY_CODE", "NL_CATALOG_OFFERS_PROPERTY_CODE", "NL_CATALOG_CART_PRODUCT_PROPERTIES_CODE", "NL_CATALOG_CART_OFFERS_PROPERTY_CODE"))) {
                            if ($val == '') {
                                $val = ' ';
                            }
                        }
                        if ($opName == 'NL_CATALOG_ID') {
                            COption::SetOptionString("bitlate.toolsshop", "NL_CATALOG_OFFERS_ID", $offersInfoIblocks[$val]['ID'], false, $siteLID);
                            COption::SetOptionString("bitlate.toolsshop", "NL_CATALOG_OFFERS_TYPE", $offersInfoIblocks[$val]['IBLOCK_TYPE_ID'], false, $siteLID);
                        }
                        COption::SetOptionString("bitlate.toolsshop", $opName, $val, $arOption[1], $siteLID);
                    } else {
                        switch ($opName) {
                            case "NL_REQUEST_CALL_EMAIL":
                                COption::SetOptionString("bitlate.toolsshop", $opName, $val, $arOption[1], $siteLID);
                                $arFilter = array(
                                    "TYPE_ID" => array("FORM_FILLING_NL_CALL_BACK_FORM_" . $siteLID),
                                    "ACTIVE"  => "Y",
                                );
                                $rsMess = CEventMessage::GetList($by = "site_id", $order = "asc", $arFilter);
                                while ($arMess = $rsMess->Fetch()) {
                                    $em = new CEventMessage;
                                    $arFields = array(
                                        "EMAIL_TO" => htmlspecialcharsbx($val),
                                    );
                                    $res = $em->Update($arMess["ID"], $arFields);
                                }
                                break;
                            case "NL_SHOP_RUB":
                                $oldVal = COption::GetOptionString("bitlate.toolsshop", $opName, $arOption[1], $siteLID);
                                if ($oldVal != $val) {
                                    if (CModule::IncludeModule("currency")) {
                                        if ($resCur = CCurrencyLang::GetCurrencyFormat("RUB", "ru")) {
                                            if ($val == "Y") {
                                                COption::SetOptionString("bitlate.toolsshop", "NL_SHOP_RUB_FORMAT_DEFAULT", $resCur["FORMAT_STRING"], "", $siteLID);
                                                $resCur["FORMAT_STRING"] = COption::GetOptionString("bitlate.toolsshop", "NL_SHOP_RUB_FORMAT", "", $siteLID);
                                            } else {
                                                $resCur["FORMAT_STRING"] = COption::GetOptionString("bitlate.toolsshop", "NL_SHOP_RUB_FORMAT_DEFAULT", "", $siteLID);
                                            }
                                            CCurrencyLang::Update("RUB", "ru", array("FORMAT_STRING" => $resCur["FORMAT_STRING"]));
                                            foreach ($arSites as $arSite2) {
                                                $siteLID2 = key($arSite2);
                                                COption::SetOptionString("bitlate.toolsshop", $opName, $val, $arOption[1], $siteLID2);
                                            }
                                        } else {
                                            $arErrors[] = GetMessage("NL_OPTION_NO_CURRENCY_RUB");
                                            $errorOption = true;
                                        }
                                    } else {
                                        $arErrors[] = GetMessage("NL_OPTION_NO_CURRENCY_MODULE");
                                        $errorOption = true;
                                    }
                                }
                                break;
                            case "NL_CATALOG_REVIEWS_MODERATE":
                                $oldVal = COption::GetOptionString("bitlate.toolsshop", $opName, $arOption[1], $siteLID);
                                if ($oldVal != $val) {
                                    if (CModule::IncludeModule("blog")) {
                                        $blogUrl = 'NL_CATALOG_REVIEWS_' . $siteLID;
                                        $blogExist = false;

                                        $blogIterator = CBlog::GetList(
                                            array(),
                                            array('URL' => $blogUrl, 'GROUP_SITE_ID' => $siteLID),
                                            false,
                                            false,
                                            array('ID', 'GROUP_ID', 'EMAIL_NOTIFY', 'GROUP_SITE_ID')
                                        );
                                        if ($blog = $blogIterator->Fetch()) {
                                            if ($val == "Y") {
                                                CBlog::SetBlogPerms(
                                                    $blog['ID'],
                                                    array(
                                                        "1" => BLOG_PERMS_PREMODERATE,
                                                        "2" => BLOG_PERMS_PREMODERATE
                                                    ),
                                                    BLOG_PERMS_COMMENT
                                                );
                                            } else {
                                                CBlog::SetBlogPerms(
                                                    $blog['ID'],
                                                    array(
                                                        "1" => BLOG_PERMS_WRITE,
                                                        "2" => BLOG_PERMS_WRITE
                                                    ),
                                                    BLOG_PERMS_COMMENT
                                                );
                                            }
                                            COption::SetOptionString("bitlate.toolsshop", $opName, $val, $arOption[1], $siteLID);
                                        } else {
                                            $arErrors[] = GetMessage("NL_OPTION_NO_BLOG_REVIEWS");
                                            $errorOption = true;
                                        }
                                        unset($blogIterator);
                                    } else {
                                        $arErrors[] = GetMessage("NL_OPTION_NO_BLOG_MODULE");
                                        $errorOption = true;
                                    }
                                }
                                break;
                            default:
                                COption::SetOptionString("bitlate.toolsshop", $opName, $val, $arOption[1], $siteLID);
                                break;
                        }
                    }
                }
            }
        }
    }
    /*if (count($arErrors) == 0) {
        if(strlen($_POST['Update']) > 0 && strlen($_REQUEST["back_url_settings"]) > 0)
            LocalRedirect($_REQUEST["back_url_settings"]);
        else
            LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($mid)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"])."&".$tabControl->ActiveTabParam());
    }*/
    
    foreach ($generate as $siteLID => $check) {
        if ($check) {
            NLApparelshopUtils::generateIncludeFile($siteLID, $arSitesDir[$siteLID], true, 'bitlate_tools');
        }
    }
}
if (count($arErrors) > 0) {
    CAdminMessage::ShowMessage(implode('<br />', $arErrors));
}

$tabControl->Begin();
?>
<form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?echo LANGUAGE_ID?>">
    <?foreach($aTabs as $i => $aTab):
        $siteLID = key($arSites[$i]);?>
        <?$tabControl->BeginNextTab();?>
        <?foreach($arAllOptions as $arOption):
            if (is_array($arOption)):
                $fieldName = htmlspecialcharsbx($arOption[0]) . "_" . $siteLID;
                $val = COption::GetOptionString("bitlate.toolsshop", $arOption[0], false, $siteLID);
                $type = $arOption[3];?>
                <tr>
                    <td width="40%" nowrap <?if($type[0]=="textarea" || $type[0]=="text") echo 'class="adm-detail-valign-top" style="padding-top:11px;"'?>>
                        <?if ($arOption[4]):?><span id="hint_<?=$fieldName?>"></span>&nbsp;<?endif;?><label for="<?echo htmlspecialcharsbx($arOption[0])?>"><?echo $arOption[1]?>:</label>
                        <?if ($arOption[4]):?>
                            <script type="text/javascript">
                                BX.hint_replace(BX('hint_<?=$fieldName?>'), '<?=$arOption[4]?>');
                            </script>
                        <?endif;?>
                    <td width="60%">
                        <?if($type[0]=="checkbox"):?>
                            <input type="checkbox" id="<?=$fieldName?>" name="<?=$fieldName?>" value="Y"<?if($val=="Y")echo" checked";?>>
                        <?elseif($type[0]=="multytext"):
                            $varArr = explode('|', $val);?>
                            <?foreach ($varArr as $v => $k):?>
                                <input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($k)?>" name="<?=$fieldName?>[]"><br />
                            <?endforeach;?>
                            <button id="button_<?=$fieldName?>">+</button>
                            <script>
                                $(document).ready(function(){
                                    $(document).on('click', '#button_<?=$fieldName?>', function(e){
                                        $('<input type="text" size="<?=$type[1]?>" maxlength="255" value="" name="<?=$fieldName?>[]"><br />').insertBefore($(this));
                                        e.preventDefault();
                                    });
                                })
                            </script>
                        <?elseif($type[0]=="text"):?>
                            <input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialcharsbx($val)?>" name="<?=$fieldName?>">
                        <?elseif($type[0]=="textarea"):?>
                            <textarea rows="<?echo $type[1]?>" cols="<?echo $type[2]?>" name="<?=$fieldName?>"><?echo htmlspecialcharsbx($val)?></textarea>
                        <?elseif($type[0]=="selectbox" || $type[0]=="IBLOCK_TYPE"):?>
                            <select name="<?=$fieldName?>" id="<?=$fieldName?>">
                                <?foreach($type[1] as $v => $k):?>
                                    <option value="<?=$v?>"<?if($val==$v)echo" selected";?>><?=$k?></option>
                                <?endforeach;?>
                            </select>
                            <script>
                                $(document).ready(function(){
                                    <?if ($type[0]=="IBLOCK_TYPE"):?>
                                        $(document).on('change', '#<?=$fieldName?>', function(e){
                                            $('.types_iblocks').hide();
                                            $('select[data-iblock-type=' + $(this).val() + ']').show().trigger('change');
                                        });
                                        
                                        var val = $('#<?=$fieldName?>').val();
                                        if (val == 0) {
                                            val = $('#<?=$fieldName?>').find('option').eq(0).attr('value');
                                            $('#<?=$fieldName?>').find('option').eq(0).attr('selected', 'selected');
                                        }
                                        $('#<?=$fieldName?>').trigger('change');
                                    <?endif;?>
                                })
                            </script>
                        <?elseif($type[0]=="IBLOCK_ID"):
                            $varArr = explode('|', $val);
                            $typeIblockId = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_TYPE", false, $siteLID);
                            foreach ($type[1] as $typeIblock => $iblockProps):?>
                                <select class="types_iblocks" name="<?=$fieldName?>[<?=$typeIblock?>]" id="<?=$fieldName?>_<?=$typeIblock?>"<?if ($typeIblockId != $typeIblock):?> style="display:none;"<?endif;?> data-iblock-type="<?=$typeIblock?>">
                                    <?foreach($iblockProps as $v => $k):?>
                                        <option value="<?=$v?>"<?if(in_array($v, $varArr))echo" selected";?>><?=$k?></option>
                                    <?endforeach;?>
                                </select>
                                <script>
                                    $(document).on('change', '#<?=$fieldName?>_<?=$typeIblock?>', function(e){
                                        var val = $(this).val();
                                        if (val == 0) {
                                            val = $(this).find('option').eq(0).attr('value');
                                            $(this).find('option').eq(0).attr('selected', 'selected');
                                        }
                                        $('.iblocks').hide();
                                        $('select[data-iblock-id=' + val + ']').show();
                                    });
                                </script>
                            <?endforeach;?>
                        <?elseif($type[0]=="PROPERTY_CODE" || $type[0]=="PROPERTY_CODE_OFFERS"):
                            $varArr = explode('|', $val);
                            $catalogIblockId = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_ID", false, $siteLID);
                            foreach ($type[1] as $iblockId => $iblockProps):?>
                                <select class="iblocks" name="<?=$fieldName?>[<?=$iblockId?>][]" id="<?=$fieldName?>_<?=$iblockId?>"<?if ($type[3] !== false):?> multiple<?endif;?> size="3"<?if ($catalogIblockId != $iblockId):?> style="display:none;"<?endif;?> data-iblock-id="<?=$iblockId?>">
                                    <?foreach($iblockProps as $v => $k):?>
                                        <option value="<?=$v?>"<?if(in_array($v, $varArr))echo" selected";?>><?=$k?></option>
                                    <?endforeach;?>
                                </select>
                            <?endforeach;?>
                        <?elseif($type[0]=="multyselectbox"):
                            $varArr = explode('|', $val);?>
                            <select name="<?=$fieldName?>[]" id="<?=$fieldName?>" multiple size="3">
                                <?foreach($type[1] as $v => $k):?>
                                    <option value="<?=$v?>"<?if(in_array($v, $varArr))echo" selected";?>><?=$k?></option>
                                <?endforeach;?>
                            </select>
                        <?endif?>
                    </td>
                </tr>
                <?if ($arOption[5]):?>
                    <tr>
                        <td colspan="2">
                            <div class="adm-info-message-wrap" align="center">
                                <div class="adm-info-message" style="margin:5px 5px; padding: 10px 30px;"><?=$arOption[5]?></div>
                            </div>
                        </td>
                    </tr>
                <?endif;?>
            <?else:?>
                <tr class="heading">
                    <td colspan="2"><b><?echo $arOption?></b></td>
                </tr>
            <?endif;?>
        <?endforeach?>
    <?endforeach?>
<?$tabControl->Buttons();?>
    <input type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" title="<?=GetMessage("MAIN_OPT_SAVE_TITLE")?>" class="adm-btn-save">
    <input type="submit" name="Apply" value="<?=GetMessage("MAIN_OPT_APPLY")?>" title="<?=GetMessage("MAIN_OPT_APPLY_TITLE")?>">
    <?if(strlen($_REQUEST["back_url_settings"])>0):?>
        <input type="button" name="Cancel" value="<?=GetMessage("MAIN_OPT_CANCEL")?>" title="<?=GetMessage("MAIN_OPT_CANCEL_TITLE")?>" onclick="window.location='<?echo htmlspecialcharsbx(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
        <input type="hidden" name="back_url_settings" value="<?=htmlspecialcharsbx($_REQUEST["back_url_settings"])?>">
    <?endif?>
    <?=bitrix_sessid_post();?>
<?$tabControl->End();?>
</form>