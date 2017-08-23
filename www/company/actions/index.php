<?if ($_REQUEST['load'] == 'Y') {
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
} else {
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Акции");
}?>
<?$curActive = ($_REQUEST['ACTIVE'] == 'Y') ? 'Y' : (($_REQUEST['ACTIVE'] == 'N') ? 'N' : '');
if ($curActive != '') {
    if ($curActive == 'Y') {
        $arrFilter = array(array(
            "LOGIC" => "OR",
            array(">=DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime(date("Y-m-d") . ' 00:00:00'),"FULL")),
            array(">=DATE_ACTIVE_TO" => ConvertTimeStamp(strtotime(date("Y-m-d") . ' 00:00:00'),"FULL")),
        ));
    } else {
        $arrFilter = array(array(
            "LOGIC" => "OR",
            array("<DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime(date("Y-m-d") . ' 00:00:00'),"FULL"), "DATE_ACTIVE_TO" => false),
            array("<DATE_ACTIVE_TO" => ConvertTimeStamp(strtotime(date("Y-m-d") . ' 00:00:00'),"FULL"), "!DATE_ACTIVE_TO" => false),
        ));
    }
}
$APPLICATION->IncludeComponent(
    "bitrix:news", 
    "actions", 
    array(
        "IBLOCK_TYPE" => "news",
        "IBLOCK_ID" => "22",
        "NEWS_COUNT" => "5",
        "USE_SEARCH" => "N",
        "USE_RSS" => "N",
        "NUM_NEWS" => "20",
        "NUM_DAYS" => "180",
        "YANDEX" => "N",
        "USE_RATING" => "N",
        "USE_CATEGORIES" => "N",
        "USE_REVIEW" => "N",
        "USE_FILTER" => ($curActive != '') ? "Y" : "N",
        "FILTER_NAME" => ($curActive != '') ? "arrFilter" : "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "CHECK_DATES" => "N",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/company/actions/",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_PANEL" => "Y",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "USE_PERMISSIONS" => "N",
        "PREVIEW_TRUNCATE_LEN" => "",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "LIST_FIELD_CODE" => array(
            0 => "DATE_ACTIVE_TO",
            1 => "ACTIVE_TO",
        ),
        "LIST_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "DISPLAY_NAME" => "Y",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_FIELD_CODE" => array(
            0 => "ID",
            1 => "CODE",
            2 => "XML_ID",
            3 => "NAME",
            4 => "TAGS",
            5 => "SORT",
            6 => "PREVIEW_TEXT",
            7 => "PREVIEW_PICTURE",
            8 => "DETAIL_TEXT",
            9 => "DETAIL_PICTURE",
            10 => "DATE_ACTIVE_FROM",
            11 => "ACTIVE_FROM",
            12 => "DATE_ACTIVE_TO",
            13 => "ACTIVE_TO",
            14 => "",
        ),
        "DETAIL_PROPERTY_CODE" => array(
            0 => "ACTION_PRODUCTS",
            1 => "",
        ),
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PAGER_TEMPLATE" => ".default",
        "DETAIL_PAGER_SHOW_ALL" => "N",
        "DISPLAY_TOP_PAGER" => "Y",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Акции",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
        "PAGER_SHOW_ALL" => "N",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "ADD_ELEMENT_CHAIN" => "Y",
        "USE_SHARE" => "N",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "section" => "",
            "detail" => "#ELEMENT_ID#.html",
        ),
        "REQUEST_LOAD" => ($_REQUEST['load'] == "Y") ? "Y" : "N",
        "CUR_ACTIVE" => $curActive,
    ),
    false
);?>
<?if ($_REQUEST['load'] == 'Y') {
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
} else {
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}?>