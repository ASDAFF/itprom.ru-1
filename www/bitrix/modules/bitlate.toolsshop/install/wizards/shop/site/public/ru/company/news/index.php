<?if ($_REQUEST['load'] == 'Y') {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
} else {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Новости");
}?>
<?$curYear = intval($_REQUEST["YEAR"]);
if ($curYear > 0) {
    $arrFilter = array(
        array(">=DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime($curYear . '-01-01 00:00:00'),"FULL")),
        array("<DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime(($curYear + 1) . '-01-01 00:00:00'),"FULL")),
    );
}
$APPLICATION->IncludeComponent(
    "bitrix:news", 
    ".default", 
    array(
        "IBLOCK_TYPE" => "news",
        "IBLOCK_ID" => "#NL_NEWS_IBLOCK_ID#",
        "NEWS_COUNT" => "5",
        "USE_SEARCH" => "N",
        "USE_RSS" => "N",
        "NUM_NEWS" => "20",
        "NUM_DAYS" => "180",
        "YANDEX" => "N",
        "USE_RATING" => "N",
        "USE_CATEGORIES" => "N",
        "USE_REVIEW" => "N",
        "USE_FILTER" => ($curYear > 0) ? "Y" : "N",
        "FILTER_NAME" => ($curYear > 0) ? "arrFilter" : "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "CHECK_DATES" => "Y",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "#SITE_DIR#company/news/",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "DISPLAY_PANEL" => "Y",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "USE_PERMISSIONS" => "N",
        "PREVIEW_TRUNCATE_LEN" => "",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "LIST_FIELD_CODE" => array(
            0 => "",
            1 => "",
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
            0 => "NAME",
            1 => "TAGS",
            2 => "PREVIEW_TEXT",
            3 => "PREVIEW_PICTURE",
            4 => "DETAIL_TEXT",
            5 => "DETAIL_PICTURE",
            6 => "DATE_ACTIVE_FROM",
            7 => "ACTIVE_FROM",
            8 => "DATE_ACTIVE_TO",
            9 => "ACTIVE_TO",
            10 => "DATE_CREATE",
            11 => "",
        ),
        "DETAIL_PROPERTY_CODE" => array(
            0 => "PHOTOGALLERY",
            1 => "BOTTOM_TEXT",
        ),
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PAGER_TEMPLATE" => ".default",
        "DETAIL_PAGER_SHOW_ALL" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
        "PAGER_SHOW_ALL" => "N",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "AJAX_OPTION_ADDITIONAL" => "",
        "ADD_ELEMENT_CHAIN" => "Y",
        "USE_SHARE" => "N",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "section" => "",
            "detail" => "#ELEMENT_ID#.html",
        ),
        "REQUEST_LOAD" => ($_REQUEST['load'] == "Y") ? "Y" : "N",
        "CUR_YEAR" => $curYear,
    ),
    false
);?>
<?if ($_REQUEST['load'] == 'Y') {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
} else {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}?>