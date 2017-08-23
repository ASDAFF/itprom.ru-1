<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var array $arResult */
$cp = $this->__component;

if (is_object($cp))
{
    $cp->arResult['ACTION_PRODUCTS_VALUE'] = $arResult['PROPERTIES']['ACTION_PRODUCTS']['VALUE'];
    $cp->SetResultCacheKeys(array(
		"ACTION_PRODUCTS_VALUE",
	));
}
?>