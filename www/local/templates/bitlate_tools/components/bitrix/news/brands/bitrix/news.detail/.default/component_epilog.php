<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Localization\Loc;
global $APPLICATION;
Loc::loadMessages(__FILE__);?>
<?$APPLICATION->IncludeFile(
    SITE_DIR . "include/product_slider.php",
    Array(
        "TITLE" => Loc::GetMessage("MSG_PRODUCTS_TITLE"),
        "FILTER" => array("PROPERTY_MANUFACTURE" => $arResult['ID']),
        "SUB_SLIDER" => "Y",
    )
);?>