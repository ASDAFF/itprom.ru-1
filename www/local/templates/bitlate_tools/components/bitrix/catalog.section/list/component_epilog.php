<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;
if ($arResult['DESCRIPTION'] != '') {
    $APPLICATION->SetPageProperty('NL_CATALOG_SECTION_DESCRIPTION', "<p>{$arResult['DESCRIPTION']}</p>");
}
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/catalog.element.script.js");
$APPLICATION->AddHeadScript("/local/templates/".SITE_TEMPLATE_ID."/js/catalog.section.script.js");
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
	?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
<?
	}
}
?>