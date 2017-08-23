<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Наши магазины"); 
?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.store",
    "",
    Array(
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => ".default",
        "MAP_TYPE" => "0",
        "PHONE" => "Y",
        "SCHEDULE" => "Y",
        "SEF_FOLDER" => "#SITE_DIR#company/shops/",
        "SEF_MODE" => "Y",
        "SEF_URL_TEMPLATES" => Array("element"=>"#store_id#.html","liststores"=>"index.php"),
        "SET_TITLE" => "Y",
        "TITLE" => "Наши магазины"
    )
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>