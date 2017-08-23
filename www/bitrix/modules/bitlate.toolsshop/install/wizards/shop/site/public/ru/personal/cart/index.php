<?if ($_REQUEST['load'] == 'Y') {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
} else {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Корзина");
}?>
<?$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket", 
    "main",
    array(
        "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
        "COLUMNS_LIST" => array(
            0 => "NAME",
            1 => "DISCOUNT",
            2 => "DELETE",
            3 => "PRICE",
            4 => "QUANTITY",
            5 => "SUM",
        ),
        "PATH_TO_ORDER" => "#SITE_DIR#personal/order/make/",
        "HIDE_COUPON" => "N",
        "QUANTITY_FLOAT" => "N",
        "PRICE_VAT_SHOW_VALUE" => "N",
        "SET_TITLE" => "Y",
        "OFFERS_PROPS" => array(),
        "USE_PREPAYMENT" => "N",
        "AUTO_CALCULATION" => "Y",
        "ACTION_VARIABLE" => "action",
        "REQUEST_LOAD" => ($_REQUEST['load'] == "Y") ? "Y" : "N",
    ),
    false
);?>
<?if ($_REQUEST['load'] == 'Y') {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
} else {
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
}?>