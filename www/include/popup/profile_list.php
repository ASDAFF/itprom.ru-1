<?php
if ($USER->IsAuthorized()):
?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:sale.personal.profile",
        ".default",
        array(
            "SET_TITLE" => "N",
            "SEF_MODE" => "Y",
            "SEF_FOLDER" => "/personal/profile/",
            "PER_PAGE" => "20",
            "USE_AJAX_LOCATIONS" => "N",
            "SEF_URL_TEMPLATES" => array(
                "list" => "",
                "detail" => "",
            ),
            "VARIABLE_ALIASES" => array(
                "detail" => array(
                    "ID" => "ID",
                ),
            )
        ),
        false
    );?>
<?endif;?>