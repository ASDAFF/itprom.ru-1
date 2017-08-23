<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Localization\Loc;
global $APPLICATION;
Loc::loadMessages(__FILE__);?>
<?if ($arResult['ACTION_PRODUCTS_VALUE']):?>
    <?$APPLICATION->IncludeFile(
        SITE_DIR . "include/product_slider.php",
        Array(
            "TITLE" => Loc::GetMessage("MSG_ACTION_PRODUCTS_TITLE"),
            "FILTER" => array('ID' => $arResult['ACTION_PRODUCTS_VALUE']),
            "SUB_SLIDER" => "Y",
        )
    );?>
<?endif;?>