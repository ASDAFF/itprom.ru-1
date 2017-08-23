<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$templateData = array(
	'BLOG_USE' => ($arResult['BLOG_USE'] ? 'Y' : 'N'),
	'FB_USE' => $arParams['FB_USE'],
	'VK_USE' => $arParams['VK_USE'],
	'BLOG' => array(
		'BLOG_FROM_AJAX' => $arResult['BLOG_FROM_AJAX'],
	),
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

if (!$arResult['BLOG_FROM_AJAX']) {
	if (!empty($arResult['ERRORS']))
	{
		ShowError(implode('<br>', $arResult['ERRORS']));
		return;
	}

	$arData = array();
	$arJSParams = array(
		'serviceList' => array(

		),
		'settings' => array(

		)
	);

	$templateData['BLOG']['AJAX_PARAMS'] = array(
		'IBLOCK_ID' => $arResult['ELEMENT']['IBLOCK_ID'],
		'ELEMENT_ID' => $arResult['ELEMENT']['ID'],
		'URL_TO_COMMENT' => $arParams['~URL_TO_COMMENT'],
		'WIDTH' => $arParams['WIDTH'],
		'COMMENTS_COUNT' => $arParams['COMMENTS_COUNT'],
		'BLOG_USE' => 'Y',
		'BLOG_FROM_AJAX' => 'Y',
		'FB_USE' => 'N',
		'VK_USE' => 'N',
		'BLOG_TITLE' => $arParams['~BLOG_TITLE'],
		'BLOG_URL' => $arParams['~BLOG_URL'],
		'PATH_TO_SMILE' => $arParams['~PATH_TO_SMILE'],
		'EMAIL_NOTIFY' => $arParams['EMAIL_NOTIFY'],
		'AJAX_POST' => $arParams['AJAX_POST'],
		'SHOW_SPAM' => $arParams['SHOW_SPAM'],
		'SHOW_RATING' => $arParams['SHOW_RATING'],
		'RATING_TYPE' => $arParams['~RATING_TYPE'],
		'CACHE_TYPE' => 'N',
		'CACHE_TIME' => '0',
		'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
	);

	$arJSParams['serviceList']['blog'] = true;
	$arJSParams['settings']['blog'] = array(
		'ajaxUrl' => $templateFolder.'/ajax.php?IBLOCK_ID='.$arResult['ELEMENT']['IBLOCK_ID'].'&ELEMENT_ID='.$arResult['ELEMENT']['ID'].'&SITE_ID='.SITE_ID,
		'ajaxParams' => array(
			'first_load' => 'Y'
		),
        'contID' => 'bx-comments-blg_'.$arResult['ELEMENT']['ID']
	);
	?>
	<script type="text/javascript">
		var obCatalogComments = new JCCatalogSocnetsComments(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
	</script>
<?
}
