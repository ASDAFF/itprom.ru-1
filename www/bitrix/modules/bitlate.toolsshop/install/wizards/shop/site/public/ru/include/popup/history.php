<?php
if ($USER->IsAuthorized()):
?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:sale.personal.order.list",
        ".default",
        array(
            "POPUP" => $POPUP,
            "ORDERS_PER_PAGE" => $ORDERS_PER_PAGE,
            "PATH_TO_PAYMENT" => "#SITE_DIR#personal/order/payment/",
            "PATH_TO_BASKET" => "#SITE_DIR#personal/cart/",
            "SET_TITLE" => "N",
            "SAVE_IN_SESSION" => "N",
            "NAV_TEMPLATE" => "",
            "ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
            "HISTORIC_STATUSES" => array(
            ),
            "CACHE_TYPE" => "Y",
            "CACHE_TIME" => "3600",
            "CACHE_GROUPS" => "Y",
            "PATH_TO_DETAIL" => "",
            "PATH_TO_COPY" => "",
            "PATH_TO_CANCEL" => "",
        ),
        false
    );?>
<?endif;?>