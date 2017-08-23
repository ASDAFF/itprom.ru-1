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
$this->setFrameMode(true);

$strMainID = $this->GetEditAreaId($arResult['ID']);

$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
<div class="description-product" id="<?=$arItemIDs['ID']?>">
  <div class="description-block">
    <div class="heading">
      <?$useBrands = ('Y' == $arParams['BRAND_USE']);
      if ($useBrands){?>
        <span class="brand-text"><?=GetMessage("WF_BRAND")?>:</span>
        <?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", "brands", array(
        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ELEMENT_ID" => $arResult['ID'],
        "ELEMENT_CODE" => "",
        "PROP_CODE" => $arParams['BRAND_PROP_CODE'],
        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
        "CACHE_TIME" => $arParams['CACHE_TIME'],
        "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
        "WIDTH" => $arParams["DETAIL_BRAND_WIDTH"],
        "HEIGHT" => $arParams["DETAIL_BRAND_HEIGHT"],
        "WIDTH_SMALL" => $arParams["DETAIL_BRAND_WIDTH_SMALL"],
        "HEIGHT_SMALL" => $arParams["DETAIL_BRAND_HEIGHT_SMALL"]
        ),
        $component,
        array("HIDE_ICONS" => "Y")
      );?>
      <?}?>
    </div>
    <?if(!empty($arResult["PROPERTIES"]["ARTNUMBER"]["VALUE"])):?>
      <div class="code-text"><?=$arResult["PROPERTIES"]["ARTNUMBER"]["NAME"]?>: <?=$arResult["PROPERTIES"]["ARTNUMBER"]["VALUE"]?></div>
    <?endif?>
    <span class="price-text"><?=GetMessage("WF_PRICE")?>:</span>
    <?
    $boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
    $canBuy = $arResult['CAN_BUY'];
    ?>
    <span class="price">
    <?
    if($boolDiscountShow):?>
      <small class="oldprice" id="<?= $arItemIDs['OLD_PRICE']?>"><s><?=str_replace(" руб.","",$arResult["MIN_PRICE"]["PRINT_VALUE"])?></s></small>
      &nbsp;<span id="totalPrice" id="<?= $arItemIDs['PRICE']?>"><?=str_replace(" руб.","",$arResult["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"])?></span> <span class="rouble">&#8399;</span>
      <br/><small class="econ" id="<?= $arItemIDs['DISCOUNT_PRICE']?>"><?=GetMessage("WF_DISC_DIFF", array ("#DISC_PRICE#" => str_replace(" руб.","",$arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF']).'<span class="rouble">&#8399;</span>'))?></small>
    <?else:?>
      <span id="<?= $arItemIDs['PRICE']?>"><?=str_replace(" руб.","",$arResult["MIN_PRICE"]["PRINT_VALUE"])?></span> <span class="rouble">&#8399;</span>
    <?endif?>
    </span>
    <!--span class="warranty"><?=GetMessage("WF_GUARANTY")?>: 1 год</span-->
    <span class="availability"><?=GetMessage("WF_AVAIL_STATUS")?>: 
      <?if($canBuy):?>
        <span class="availability-has"><?=GetMessage("WF_AVAILABLE")?></span>
      <?else:?>
        <span class="expected"><?=$arParams["MESS_NOT_AVAILABLE"]?></span>
      <?endif?>
    </span>
    <?
    if ($canBuy){
      $buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));?>
      <a href="#" class="btn-basket">
        <span class="add-basket" id="<?=$arItemIDs['BUY_LINK']?>" ><?=$buyBtnMessage?></span>
        <span class="items-cart"><?=GetMessage("WF_ADDED_TO_CART")?></span>
      </a>
      <a href="#" class="btn-credit" onclick="$('.add-basket').click();return false;"><?=GetMessage("WF_CREDIT_BUY")?><br/>
        <span class="small-text"><?=GetMessage("WF_CREDIT_BUY2",array("#PRICE#" => round($arResult["MIN_PRICE"]["DISCOUNT_VALUE"]/10).' <span class="rouble">&#8399;</span>'))?></span>
      </a>
    <?
    }else{
      $buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
    }
    ?>
  </div>
  <div class="description-text">
    <h1><?=
			isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			: $arResult["NAME"]
		 ?></h1>
    <div class="gallery-vertical-hold" id="<?= $arItemIDs['BIG_SLIDER_ID']?>">
      <div class="gallery-vertical">
        <a href="#" class="prev" id="<?=$arItemIDs['SLIDER_LEFT']?>">&nbsp;</a>
        <div class="gallery">
          <ul style="margin-top: -368px;" id="<?= $arItemIDs['SLIDER_CONT_ID']?>">
            <?foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto){?>
              <li data-value="<?=$arOnePhoto['ID']?>">
                <a href="<?=$arOnePhoto['SRC']?>"><img src="<?=$arOnePhoto['SRC']?>" width="90" height="90" alt=""></a>
              </li>
            <?}?>
          </ul>
        </div>
        <a href="#" class="next" id="<?=$arItemIDs['SLIDER_RIGHT']?>">&nbsp;</a>
      </div>
      <div class="visual" id="<?= $arItemIDs['BIG_IMG_CONT_ID']; ?>">
        <img id="<?= $arItemIDs['PICT']?>" class="" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>">
      </div>
    </div>
  </div>
</div>
<div class="tabset tabset-type02">
  <ul class="tab-list tab-list2">
    <li><a href="#" class="active"><strong><?=GetMessage("WF_DESCRIPTION")?></strong></a></li>
    <li><a href="#" class=""><strong><?=GetMessage("WF_SPECS")?></strong></a></li>
    <li><a href="#" class=""><strong><?=GetMessage("WF_REVIEWS")?></strong></a></li>
  </ul>
  <div class="tab-holder">
    <div class="tab active">   
      <?=$arResult["DETAIL_TEXT"]?>
    </div>
    <div class="tab">
      <?$excludeProps = array("BRAND_REF", "SPECIALOFFER", "ARTNUMBER", "RECOMMEND")?>
      <h3 class="description-title"><?=GetMessage("WF_MAIN")?></h3>
      <ul class="description-list">
        <?foreach($arResult["DISPLAY_PROPERTIES"] as $key => $arDp):
          if(in_array($key,$excludeProps)) continue;
          ?>
          <li>
            <span class="text-left"><?=$arDp["NAME"]?></span>
            <span class="text-right"><?=$arDp["VALUE"]?></span>
          </li>
        <?endforeach?>
      </ul>
    </div>
    <div class="tab">
      <?
      if ('Y' == $arParams['USE_COMMENTS']){?>
      <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.comments",
        "comments",
        array(
          "ELEMENT_ID" => $arResult['ID'],
          "ELEMENT_CODE" => "",
          "IBLOCK_ID" => $arParams['IBLOCK_ID'],
          "URL_TO_COMMENT" => "",
          "WIDTH" => "800",
          "COMMENTS_COUNT" => "5",
          "BLOG_USE" => $arParams['BLOG_USE'],
          "FB_USE" => $arParams['FB_USE'],
          "FB_APP_ID" => $arParams['FB_APP_ID'],
          "VK_USE" => $arParams['VK_USE'],
          "VK_API_ID" => $arParams['VK_API_ID'],
          "CACHE_TYPE" => $arParams['CACHE_TYPE'],
          "CACHE_TIME" => $arParams['CACHE_TIME'],
          "BLOG_TITLE" => "",
          "BLOG_URL" => $arParams['BLOG_URL'],
          "PATH_TO_SMILE" => "",
          "EMAIL_NOTIFY" => "N",
          "AJAX_POST" => "Y",
          "SHOW_SPAM" => "Y",
          "SHOW_RATING" => "N",
          "FB_TITLE" => "",
          "FB_USER_ADMIN_ID" => "",
          "FB_COLORSCHEME" => "light",
          "FB_ORDER_BY" => "reverse_time",
          "VK_TITLE" => "",
          "TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
        ),
        $component,
        array("HIDE_ICONS" => "Y")
      );?>
      <?}?>
    </div>
  </div>
</div>
<?
$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
			'BUY_URL' => $arResult['~BUY_URL'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL']
		)
	);
	unset($emptyProductProperties);
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>