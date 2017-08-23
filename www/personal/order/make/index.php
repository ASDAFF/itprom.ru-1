<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
?>
<?COption::SetOptionString("main","new_user_registration_email_confirmation","N");?>
<?$APPLICATION->IncludeComponent(
    "bitrix:sale.order.ajax",
    "main", 
    array(
        "PAY_FROM_ACCOUNT" => "N",
        "ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
        "ALLOW_AUTO_REGISTER" => "Y",
        "SEND_NEW_USER_NOTIFY" => "Y",
        "DELIVERY_NO_AJAX" => "Y",
        "COUNT_DELIVERY_TAX" => "N",
        "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
        "TEMPLATE_LOCATION" => "popup",
        "PROP_1" => array(
        ),
        "PATH_TO_BASKET" => "/personal/cart/",
        "PATH_TO_PERSONAL" => "/personal/",
        "PATH_TO_PAYMENT" => "/personal/order/payment/",
        "SET_TITLE" => "Y",
        "DELIVERY2PAY_SYSTEM" => "",
        "SHOW_ACCOUNT_NUMBER" => "Y",
        "DELIVERY_NO_SESSION" => "Y",
        "DELIVERY_TO_PAYSYSTEM" => "d2p",
        "USE_PREPAYMENT" => "N",
        "ALLOW_USER_PROFILES" => "Y",
        "ALLOW_NEW_PROFILE" => "Y",
        "SHOW_PAYMENT_SERVICES_NAMES" => "Y",
        "SHOW_STORES_IMAGES" => "Y",
        "DELIVERIES_PER_PAGE" => 99,
        "PAY_SYSTEMS_PER_PAGE" => 99,
        "PICKUPS_PER_PAGE" => 99,
        "PATH_TO_AUTH" => "/auth/",
        "DISABLE_BASKET_REDIRECT" => "N",
        "PRODUCT_COLUMNS" => array(
        )
    ),
    false
);?>
<?COption::SetOptionString("main","new_user_registration_email_confirmation","Y");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>