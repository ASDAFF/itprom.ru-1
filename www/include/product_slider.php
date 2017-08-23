<?$APPLICATION->IncludeFile(
    SITE_TEMPLATE_PATH . "/include/" . SITE_ID ."/product_slider.php",
    Array(
        'FILTER' => $FILTER,
        'TITLE' => $TITLE,
        'SECTION' => $SECTION,
        'SUB_SLIDER' => $SUB_SLIDER,
        'SLIDER_ZINDEX' => $SLIDER_ZINDEX,
    )
);?>