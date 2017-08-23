<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$cp = $this->__component;

if (is_object($cp))
{
    $cp->arResult['SECTIONS_DEPTH'] = $arResult['SECTIONS_DEPTH'];
    $cp->SetResultCacheKeys(array(
        "SECTIONS_COUNT",
        "SECTION",
        'SECTIONS_DEPTH'
    ));
}
?>