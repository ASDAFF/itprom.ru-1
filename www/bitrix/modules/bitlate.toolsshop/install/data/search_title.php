<?$APPLICATION->IncludeComponent(
    "bitrix:search.title",
    "catalog",
    array(
        "NUM_CATEGORIES" => "3",
        "TOP_COUNT" => "3",
        "ORDER" => "rank",
        "USE_LANGUAGE_GUESS" => "Y",
        "CHECK_DATES" => "N",
        "SHOW_OTHERS" => "N",
        "PAGE" => "#NL_CATALOG_SEF_FOLDER##NL_CATALOG_SEF_URL_TEMPLATES_SEARCH#",
        "SHOW_INPUT" => "Y",
        "INPUT_ID" => "title-search-input",
        "CONTAINER_ID" => "search-dropdown",
        "CATEGORY_0_TITLE" => getMessage('TITLE_NEWS'),
        "CATEGORY_0" => array(
            0 => "iblock_news",
        ),
        "PRICE_CODE" => #NL_CATALOG_PRICE_CODE#,
        "PRICE_VAT_INCLUDE" => "Y",
        "PREVIEW_TRUNCATE_LEN" => "",
        "SHOW_PREVIEW" => "Y",
        "CONVERT_CURRENCY" => "Y",
        "PREVIEW_WIDTH" => "52",
        "PREVIEW_HEIGHT" => "50",
        "CATEGORY_1_TITLE" => getMessage('TITLE_ACTIONS'),
        "CATEGORY_1" => array(
            0 => "iblock_news",
        ),
        "CATEGORY_2_TITLE" => getMessage('TITLE_GOODS'),
        "CATEGORY_2" => array(
            0 => "iblock_#NL_CATALOG_TYPE#",
        ),
        "CATEGORY_0_iblock_news" => array(
            0 => '#NL_IBLOCK_ID_NEWS#',
        ),
        "CATEGORY_1_iblock_news" => array(
            0 => '#NL_IBLOCK_ID_ACTIONS#',
        ),
        "CATEGORY_2_iblock_#NL_CATALOG_TYPE#" => array(
            0 => '#NL_CATALOG_ID#',
        ),
        "CURRENCY_ID" => "RUB"
    ),
    false
);?>