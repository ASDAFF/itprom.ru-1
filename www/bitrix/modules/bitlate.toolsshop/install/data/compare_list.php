<?$APPLICATION->IncludeComponent("bitrix:catalog.compare.list",$TYPE,
Array(
        "AJAX_MODE" => "Y",
        "IBLOCK_TYPE" => "#NL_CATALOG_TYPE#",
        "IBLOCK_ID" => "#NL_CATALOG_ID#",
        "POSITION_FIXED" => "Y",
        "POSITION" => "top left",
        "DETAIL_URL" => "",
        "COMPARE_URL" => "#NL_CATALOG_SEF_FOLDER##NL_CATALOG_SEF_URL_TEMPLATES_COMPARE#",
        "NAME" => "CATALOG_COMPARE_LIST",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id"
    )
);?>