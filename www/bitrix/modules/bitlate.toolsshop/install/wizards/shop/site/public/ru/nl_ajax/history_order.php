<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
    "bitrix:sale.personal.order.detail",
    "",
    array(
        "PATH_TO_PAYMENT" => "#SITE_DIR#personal/order/payment/",
        "ID" => $_REQUEST['ID'],
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_GROUPS" => "Y",
        "SET_TITLE" => "N",
        "ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
        "CUSTOM_SELECT_PROPS" => array(),
    ),
    false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?> 