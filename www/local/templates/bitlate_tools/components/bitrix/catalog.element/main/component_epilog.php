<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
global $APPLICATION;
Loc::loadMessages(__FILE__);
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
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
if (isset($templateData['JS_OBJ']))
{
?><script type="text/javascript">
BX.ready(BX.defer(function(){
	if (!!window.<? echo $templateData['JS_OBJ']; ?>)
	{
		window.<? echo $templateData['JS_OBJ']; ?>.allowViewedCount(true);
	}
}));
</script><?
}
?>
<?if ($arParams["REQUEST_LOAD"] != "Y"):?>
    <?if ($arResult['ACCESSORIES_VALUE']):?>
        <?$APPLICATION->IncludeFile(
            SITE_DIR . "include/product_slider.php",
            Array(
                "TITLE" => Loc::GetMessage("CT_BCS_ACCESSORIES_TITLE"),
                "FILTER" => array('ID' => $arResult['ACCESSORIES_VALUE']),
                "SLIDER_ZINDEX" => "3",
            )
        );?>
    <?endif;?>
    <?$APPLICATION->IncludeFile(
        SITE_DIR . "include/product_slider.php",
        Array(
            "TITLE" => Loc::GetMessage("CT_BCS_SIMILAR_TITLE"),
            "FILTER" => array('!ID' => $arResult['ID'], 'SECTION_ID' => $arResult["IBLOCK_SECTION_ID"]),
            "SLIDER_ZINDEX" => "2",
        )
    );?>
    <?
    $frame = new \Bitrix\Main\Page\FrameHelper("bx-comments-blg_" . $arResult['ID'], false);
    $frame->begin();?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.comments",
            "",
            array(
                "ELEMENT_ID" => $arResult['ID'],
                "IBLOCK_ID" => $arResult['IBLOCK_ID'],
                "COMMENTS_COUNT" => "5",
                "BLOG_USE" => 'Y',
                "CACHE_TYPE" => 'A',
                "CACHE_TIME" => 86400,
                "BLOG_URL" => 'NL_CATALOG_REVIEWS_' . SITE_ID,
                "PATH_TO_SMILE" => "",
                "EMAIL_NOTIFY" => "Y",
                "AJAX_POST" => "Y",
                "SHOW_SPAM" => "Y",
                "SHOW_RATING" => "N",
            ),
            $component,
            array("HIDE_ICONS" => "Y")
        );?>
    <?$frame->beginStub();?>
    <?$frame->end();?>
<?endif;?>