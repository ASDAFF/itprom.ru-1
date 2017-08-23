<?if (CModule::IncludeModule('bitlate.toolsshop')) {
    $APPLICATION->IncludeFile(
        SITE_DIR . "include/favorites.php",
        Array(
            'USER_FAVORITES' => NLApparelshopUtils::getFavorits(),
        )
    );
    die();
}?>