<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;
if (count($arResult['SECTIONS_DEPTH'])) {
    foreach ($arResult['SECTIONS_DEPTH'] as $code => $content) {
        $GLOBALS[$code] = $content;
    }
}
?>