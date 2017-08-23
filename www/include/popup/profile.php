<?php
if ($USER->IsAuthorized()):
?>
    <?$APPLICATION->IncludeComponent("bitlate:sale.personal.profile.detail","",Array(
        "PATH_TO_LIST" => "profile_list.php",
        "PATH_TO_DETAIL" => "profile_detail.php?ID=#ID#",
        "ID" => "",
        "USE_AJAX_LOCATIONS" => "Y",
        "SET_TITLE" => "N"
    ));?>
<?endif;?>