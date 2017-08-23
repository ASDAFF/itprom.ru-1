<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!empty($arResult['ERROR'])) {
    echo $arResult['ERROR'];
    return false;
}

//test_dump($arResult);

$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/js/highloadblock/css/highloadblock.css');
$listUrl = str_replace('#BLOCK_ID#', intval($arParams['BLOCK_ID']), $arParams['LIST_URL']);
?>
    <div class="myContent1" style="">
        <?
        $myRow = $arResult['row'];
        $GLOBALS['APPLICATION']->SetTitle(GetMessage("HLBLOCK_ROW_VIEW_BRAND_HEAD", array("#BRAND_NAME#" => $myRow["UF_NAME"])));
        ?>
        <div class="brand_photo_holder"><img src="<?= $myRow["UF_FILE"] ?>"/></div>



        <div class="brand_info">
            <p><?= $myRow["UF_FULL_DESCRIPTION"] ?></p>
            <a el="nofollow" href="<?= htmlspecialcharsbx($listUrl) ?>"><?= GetMessage('HLBLOCK_ROW_VIEW_BACK_TO_LIST') ?></a>
        </div>
        <div class="clearfix">&nbsp;</div>
        <br/>
        <h3 style="margin-bottom: 0;"><?= GetMessage("HLBLOCK_ROW_VIEW_PRODUCTION") ?>:</h3>

<? if (isset($_REQUEST["view"]) and $_REQUEST["view"] == "tiles") $sectionTemplate = "tiles";
else $sectionTemplate = "list";
if (!empty($_GET["sort"])) {
    if ($_GET["sort"] == "price") $sort = "catalog_PRICE_1";
    else $sort = $_GET["sort"];
    $sortOrder = $_GET["sort_ord"];
} else {
    $sort = $arParams["ELEMENT_SORT_FIELD"];
    $sortOrder = $arParams["ELEMENT_SORT_ORDER"];
}
$sort2 = $arParams["ELEMENT_SORT_FIELD"];
$sortOrder2 = $arParams["ELEMENT_SORT_ORDER"];

$GLOBALS["Filter"] = array(
    "PROPERTY_BRAND_REF" => $arParams["ROW_ID"],
    "!CATALOG_PRICE_1" => false, // С ценой
);

?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "list",
    Array(
        "CLEAR_CATCH" => "123",
        "ACTION_VARIABLE" => "action",
        "ADD_PICT_PROP" => "-",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "ADD_TO_BASKET_ACTION" => "ADD",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BACKGROUND_IMAGE" => "-",
        "BASKET_URL" => "/personal/basket.php",
        "BROWSER_TITLE" => "-",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COMPATIBLE_MODE" => "Y",
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
        "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
        "DETAIL_URL" => "",
        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_COMPARE" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_SORT_FIELD" => "id",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER" => "desc",
        "ELEMENT_SORT_ORDER2" => "desc",
        "FILTER_NAME" => "Filter",
        "HIDE_NOT_AVAILABLE" => "N",
        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
        "IBLOCK_ID" => "4",
        "IBLOCK_TYPE" => "catalog",
        "INCLUDE_SUBSECTIONS" => "A",
        "LABEL_PROP" => "-",
        "LAZY_LOAD" => "N",
        "LINE_ELEMENT_COUNT" => "4",
        "LOAD_ON_SCROLL" => "N",
        "MESSAGE_404" => "",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_COMPARE" => "Сравнить",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_BTN_SUBSCRIBE" => "Подписаться",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "OFFERS_CART_PROPERTIES" => array(),
        "OFFERS_FIELD_CODE" => array("",""),
        "OFFERS_LIMIT" => "5",
        "OFFERS_PROPERTY_CODE" => array("ARTNUMBER","COLOR_REF","MORE_PHOTO","SIZES_SHOES","SIZE_GENERAL","SIZES_CLOTHES",""),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_FIELD2" => "id",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_ORDER2" => "desc",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Товары",
        "PAGE_ELEMENT_COUNT" => "18",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => array("BASE"),
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_DISPLAY_MODE" => "N",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPERTIES" => array(),
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_SUBSCRIPTION" => "Y",
        "PROPERTY_CODE" => array("WIDTH","HEIGHT","DEPTH","UNITS","HEAT_POWER","IP_CLASS","BRAND_REF","NEWPRODUCT","SALELEADER","SPECIALOFFER","DBK_HEAT","ARTNUMBER","COLOR","DIN_METIZ","BLOG_POST_ID","DIN_AUTO","FAN","VENTILACIA","KREPL_TYPE","WORK_TYPE","DIAGONAL","MACH_DIAM","LENGTH","OPTION","PANELS","Hygrostat","KLEMM","BLOG_COMMENTS_CNT","MAX_DEPTH","MAX_TEMP","MAX_CURRENT","MATERIAL","MIN_DEPTH","MIN_TEMP","MIN_CURRENT","Cooling_POWER","DIST_FROM_WALL","FAN_RESH","RESH","DIN_ROZ","RECOMMEND","SERIES","ELECTRIC_CURRENT","KREPL_WAY","HANDLE_TYPE","UTEPLITEL","OPTIONS",""),
        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
        "RCM_TYPE" => "personal",
        "SECTION_CODE" => "",
        "SECTION_ID" => "",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SECTION_URL" => "",
        "SECTION_USER_FIELDS" => array("UF_BROWSER_TITLE","UF_KEYWORDS","UF_META_DESCRIPTION","UF_DESCR_TEMPLATE","UF_PRE_DESC_TEMPLATE","UF_TYPEPREFIX","UF_SECT_SERIES_NAME","UF_SECT_DESCRIPTION","UF_SECT_CHARACTER","UF_SHOW_ON_MAIN_PAGE",""),
        "SEF_MODE" => "N",
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SHOW_ALL_WO_SECTION" => "Y",
        "SHOW_CLOSE_POPUP" => "N",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_FROM_SECTION" => "N",
        "SHOW_MAX_QUANTITY" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "TEMPLATE_THEME" => "blue",
        "USE_ENHANCED_ECOMMERCE" => "N",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "Y"
    )
);?>
    </div>