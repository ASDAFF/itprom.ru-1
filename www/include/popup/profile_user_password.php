<?php
if ($USER->IsAuthorized()):
?>
    <?$APPLICATION->IncludeComponent("bitrix:main.profile","password",Array(
            "USER_PROPERTY_NAME" => "",
            "SET_TITLE" => "N", 
            "AJAX_MODE" => "N", 
            "USER_PROPERTY" => Array(), 
            "SEND_INFO" => "N", 
            "CHECK_RIGHTS" => "N",  
            "AJAX_OPTION_JUMP" => "N", 
            "AJAX_OPTION_STYLE" => "Y", 
            "AJAX_OPTION_HISTORY" => "N" 
        )
    );?>
<?endif;?>