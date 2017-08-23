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
$this->setFrameMode(true);?>
<?if ($arParams['USE_FILTER'] == 'Y'){
  $arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",
  );
  if (0 < intval($arResult["VARIABLES"]["SECTION_ID"])){
    $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
  }
  elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"]){
    $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
  }

  $obCache = new CPHPCache();
  if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")){
    $arCurSection = $obCache->GetVars();
  }
  elseif ($obCache->StartDataCache()){
    $arCurSection = array();
    if (\Bitrix\Main\Loader::includeModule("iblock"))
    {
      $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

      if(defined("BX_COMP_MANAGED_CACHE"))
      {
        global $CACHE_MANAGER;
        $CACHE_MANAGER->StartTagCache("/iblock/catalog");

        if ($arCurSection = $dbRes->Fetch())
        {
          $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
        }
        $CACHE_MANAGER->EndTagCache();
      }
      else
      {
        if(!$arCurSection = $dbRes->Fetch())
          $arCurSection = array();
      }
    }
    $obCache->EndDataCache($arCurSection);
  }
  if (!isset($arCurSection))
  {
    $arCurSection = array();
  }
  $this->SetViewTarget("sm-filter");
  ?>

    <?$APPLICATION->IncludeComponent(
    "bitrix:catalog.smart.filter",
    "santech",
    Array(
      "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
      "IBLOCK_ID" => $arParams["IBLOCK_ID"],
      "SECTION_ID" => $arCurSection['ID'],
      "FILTER_NAME" => $arParams["FILTER_NAME"],
      "PRICE_CODE" => $arParams["PRICE_CODE"],
      "CACHE_TYPE" => $arParams["CACHE_TYPE"],
      "CACHE_TIME" => $arParams["CACHE_TIME"],
      "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
      "SAVE_IN_SESSION" => "N",
      "XML_EXPORT" => "Y",
      "SECTION_TITLE" => "NAME",
      "SECTION_DESCRIPTION" => "DESCRIPTION",
      'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
      "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
    ),
    $component,
    array('HIDE_ICONS' => 'Y')
  );?>
  <?$this->EndViewTarget();
}?>
<div class="main-frame">
  <div id="content">
    <div class="c1">
      <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "catalog", Array(
          "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
          "PATH" => SITE_DIR."/catalog/",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
          "SITE_ID" => "",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
        ),
        false
      );
      ?>
      <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "section",
        array(
          "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
          "IBLOCK_ID" => $arParams["IBLOCK_ID"],
          "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
          "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
          "CACHE_TYPE" => $arParams["CACHE_TYPE"],
          "CACHE_TIME" => $arParams["CACHE_TIME"],
          "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
          "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
          "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
          "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
          "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
          "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
          "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
          "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
        ),
        $component
        );?>
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
      <?$intSectionID = 0;?>
        <?$intSectionID = $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        $sectionTemplate,
        array(
          "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
          "IBLOCK_ID" => $arParams["IBLOCK_ID"],
          "ELEMENT_SORT_FIELD" => $sort,
          "ELEMENT_SORT_ORDER" => $sortOrder,
          "ELEMENT_SORT_FIELD2" => $sort2,
          "ELEMENT_SORT_ORDER2" => $sortOrder2,
          "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
          "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
          "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
          "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
          "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
          "BASKET_URL" => $arParams["BASKET_URL"],
          "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
          "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
          "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
          "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
          "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
          "FILTER_NAME" => $arParams["FILTER_NAME"],
          "CACHE_TYPE" => $arParams["CACHE_TYPE"],
          "CACHE_TIME" => $arParams["CACHE_TIME"],
          "CACHE_FILTER" => $arParams["CACHE_FILTER"],
          "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
          "SET_TITLE" => $arParams["SET_TITLE"],
          "SET_STATUS_404" => $arParams["SET_STATUS_404"],
          "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
          "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
          "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
          "PRICE_CODE" => $arParams["PRICE_CODE"],
          "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
          "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

          "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
          "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
          "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
          "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
          "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

          "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
          "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
          "PAGER_TITLE" => $arParams["PAGER_TITLE"],
          "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
          "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
          "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
          "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
          "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

          "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
          "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
          "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
          "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
          "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
          "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
          "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
          "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

          "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
          "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
          "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
          "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
          'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
          'CURRENCY_ID' => $arParams['CURRENCY_ID'],
          'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

          'LABEL_PROP' => $arParams['LABEL_PROP'],
          'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
          'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

          'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
          'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
          'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
          'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
          'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
          'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
          'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
          'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
          'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
          'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

          'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
          "ADD_SECTIONS_CHAIN" => "N"
        ),
        $component
      );?>
    </div>
  </div>
  <div id="sidebar">
    <?$APPLICATION->ShowViewContent("sm-filter");?>
  </div>
</div>
<?if($arParams["USE_COMPARE"]=="Y"):?>
  <?$this->SetViewTarget("wf_compare_list");?>
    <?$APPLICATION->IncludeComponent(
      "bitrix:catalog.compare.list",
      "footer",
      array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "NAME" => $arParams["COMPARE_NAME"],
        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
        "COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
      ),
      $component
    );?>
  <?$this->EndViewTarget();?>
<?endif?>