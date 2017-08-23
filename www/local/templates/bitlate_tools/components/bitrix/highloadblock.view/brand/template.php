<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR'])){
	echo $arResult['ERROR'];
	return false;
}
test_dump($arResult);
//$APPLICATION->SetPageProperty("title", $arResult["ELEMENT"]["PROPERTIES"]["TITLE"]["VALUE"]);


$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/js/highloadblock/css/highloadblock.css');
$listUrl = str_replace('#BLOCK_ID#', intval($arParams['BLOCK_ID']),	$arParams['LIST_URL']);
?>
<div class="myContent" style="padding-bottom: 0;">
    <?
    $myRow = $arResult['row'];
    $GLOBALS['APPLICATION']->SetTitle(GetMessage("HLBLOCK_ROW_VIEW_BRAND_HEAD",array("#BRAND_NAME#" => $myRow["UF_NAME"])));
    ?>
	  <h1>fsdf<?= GetMessage("HLBLOCK_ROW_VIEW_BRAND_HEAD",array("#BRAND_NAME#" => $myRow["UF_NAME"]))?></h1>
      <div class="brand_photo_holder"><img src="<?= $myRow["UF_FILE"]?>"/></div>
      <div class="brand_info"><p class="brand_announce"><?= $myRow["UF_DESCRIPTION"] ?></p>
      <p><?= $myRow["UF_FULL_DESCRIPTION"] ?></p>
		</div>
	<div class="clearfix">&nbsp;</div>
    <a rel="nofollow" href="<?=htmlspecialcharsbx($listUrl)?>"><?=GetMessage('HLBLOCK_ROW_VIEW_BACK_TO_LIST')?></a>
	<h3 style="margin-bottom: 0;"><?=GetMessage("HLBLOCK_ROW_VIEW_PRODUCTION")?>:</h3>
</div>
  <?if(isset($_REQUEST["view"]) and $_REQUEST["view"] == "list") $sectionTemplate = "list";
  else $sectionTemplate = "tiles";
  if(!empty($_GET["sort"])){
    if($_GET["sort"] == "price") $sort = "catalog_PRICE_1";
    else $sort = $_GET["sort"];
    $sortOrder = $_GET["sort_ord"];
  }else{
    $sort = $arParams["ELEMENT_SORT_FIELD"];
    $sortOrder = $arParams["ELEMENT_SORT_ORDER"];
  }
  $sort2 = $arParams["ELEMENT_SORT_FIELD"];
  $sortOrder2 = $arParams["ELEMENT_SORT_ORDER"];
  ?>
  <?/*$APPLICATION->IncludeComponent(
  "bitrix:catalog.section",
  $sectionTemplate,
  array(
    "TEMPLATE_THEME" => "blue",
    "PRODUCT_DISPLAY_MODE" => "N",
    "ADD_PICT_PROP" => "MORE_PHOTO",
    "LABEL_PROP" => "-",
    "OFFER_ADD_PICT_PROP" => "FILE",
    "OFFER_TREE_PROPS" => array(
      0 => "-",
    ),
    "PRODUCT_SUBSCRIPTION" => "N",
    "SHOW_DISCOUNT_PERCENT" => "N",
    "SHOW_OLD_PRICE" => "Y",
    "MESS_BTN_BUY" => "������",
    "MESS_BTN_ADD_TO_BASKET" => "� �������",
    "MESS_BTN_SUBSCRIBE" => "�����������",
    "MESS_BTN_DETAIL" => "���������",
    "MESS_NOT_AVAILABLE" => "��� � �������",
    "AJAX_MODE" => "N",
    "IBLOCK_TYPE" => "catalog",
    "IBLOCK_ID" => "4",
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "SECTION_CODE" => "",
    "SECTION_USER_FIELDS" => array(
      0 => "",
      1 => "",
    ),
    "ELEMENT_SORT_FIELD" => $sort,
    "ELEMENT_SORT_ORDER" => $sortOrder,
    "ELEMENT_SORT_FIELD2" => $sort2,
    "ELEMENT_SORT_ORDER2" => $sortOrder2,
    "FILTER_NAME" => "arrFilter",
    "INCLUDE_SUBSECTIONS" => "Y",
    "SHOW_ALL_WO_SECTION" => "Y",
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "BASKET_URL" => SITE_DIR."personal/basket.php",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
    "ADD_PROPERTIES_TO_BASKET" => "N",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "PARTIAL_PRODUCT_PROPERTIES" => "N",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "ADD_SECTIONS_CHAIN" => "Y",
    "DISPLAY_COMPARE" => "N",
    "SET_TITLE" => "Y",
    "SET_BROWSER_TITLE" => "Y",
    "BROWSER_TITLE" => "-",
    "SET_META_KEYWORDS" => "Y",
    "META_KEYWORDS" => "",
    "SET_META_DESCRIPTION" => "Y",
    "META_DESCRIPTION" => "",
    "SET_STATUS_404" => "N",
    "PAGE_ELEMENT_COUNT" => "1000",
    "LINE_ELEMENT_COUNT" => "4",
    "PROPERTY_CODE" => array(
      0 => "BRAND_REF",
      1 => "NEWPRODUCT",
      2 => "SALELEADER",
      3 => "SPECIALOFFER",
      4 => "",
    ),
    "OFFERS_FIELD_CODE" => array(
      0 => "",
      1 => "",
    ),
    "OFFERS_PROPERTY_CODE" => array(
      0 => "",
      1 => "",
    ),
    "OFFERS_SORT_FIELD" => "sort",
    "OFFERS_SORT_ORDER" => "asc",
    "OFFERS_SORT_FIELD2" => "active_from",
    "OFFERS_SORT_ORDER2" => "desc",
    "OFFERS_LIMIT" => "5",
    "PRICE_CODE" => array(
      0 => "BASE",
    ),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "PRODUCT_PROPERTIES" => array(
    ),
    "USE_PRODUCT_QUANTITY" => "N",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "36000000",
    "CACHE_FILTER" => "Y",
    "CACHE_GROUPS" => "Y",
    "DISPLAY_TOP_PAGER" => "N",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "PAGER_TITLE" => "������",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => "",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "HIDE_NOT_AVAILABLE" => "Y",
    "OFFERS_CART_PROPERTIES" => array(
    ),
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "CONVERT_CURRENCY" => "Y",
    "CURRENCY_ID" => "RUB",
    "AJAX_OPTION_ADDITIONAL" => "",
    "BRAND_REF_VALUE" => $arResult['row']["UF_LINK"]
  ),
  false
);*/?>