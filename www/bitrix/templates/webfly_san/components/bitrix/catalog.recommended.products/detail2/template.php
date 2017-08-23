<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
 if (!empty($arResult['ITEMS'])):
   ?>

<div class="product-catalog product-catalogXX">
<ul id="accessories">
<?
$iterate = 0;
foreach ($arResult['ITEMS'] as $key => $arItem){
        $iterate++;
        /*if($iterate == 5) $styleClearFix = 'style="clear:both;display:block;"';
        else $styleClearFix = "";*/
        if ($iterate > 6) { break; }
        $strMainID = $this->GetEditAreaId($arItem['ID'] . $key);
        $arItemIDs = array(
            'ID' => $strMainID,
            'PICT' => $strMainID . '_pict',
            'SECOND_PICT' => $strMainID . '_secondpict',
            'MAIN_PROPS' => $strMainID . '_main_props',

            'QUANTITY' => $strMainID . '_quantity',
            'QUANTITY_DOWN' => $strMainID . '_quant_down',
            'QUANTITY_UP' => $strMainID . '_quant_up',
            'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
            'BUY_LINK' => $strMainID . '_buy_link',
            'SUBSCRIBE_LINK' => $strMainID . '_subscribe',

            'PRICE' => $strMainID . '_price',
            'DSC_PERC' => $strMainID . '_dsc_perc',
            'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

            'PROP_DIV' => $strMainID . '_sku_tree',
            'PROP' => $strMainID . '_prop_',
            'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
            'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
        );

        $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

        $strTitle = (
        isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
            ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
            : $arItem['NAME']
        );
        $showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";

?>
    <li class="bx_catalog_item wf-new  wf-hit " id="<?=$strMainID; ?>" <?=$styleClearFix?>>
      <div class="hold">
        <div class="visual">
          <a href="<?=$arItem['DETAIL_PAGE_URL']; ?>">
            <img src="<?=$arItem['PREVIEW_PICTURE_SM']['src']?>" title="<?=$strTitle?>" alt="<?=$strTitle?>" id="<?=$arItemIDs['PICT']?>"/>
            <?if(!empty($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"])):?><span class="new"><?=$arItem["PROPERTIES"]["NEWPRODUCT"]["NAME"]?></span><?endif;?>
            <?if(!empty($arItem["PROPERTIES"]["SALELEADER"]["VALUE_ENUM_ID"])):?><span class="hit"><?=$arItem["PROPERTIES"]["SALELEADER"]["NAME"]?></span><?endif;?>
            <?if(!empty($arItem["PROPERTIES"]["SPECIALOFFER"]["VALUE_ENUM_ID"])):?><span class="sale"><?=$arItem["PROPERTIES"]["SPECIALOFFER"]["NAME"]?></span><?endif;?>
          </a>
        </div>
        <div class="block">
          <div class="description">
            <a href="<?= $arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
          </div>
          <div class="box" style="border-bottom: 0;">
            <div class="col-left" style="width:85px;">
              <?
              $discPrice = $arItem['MIN_PRICE']['DISCOUNT_VALUE'];
              $minPrice = $arItem['MIN_PRICE']['VALUE'];
              if($minPrice > $discPrice):?>
                <span class="price" id="<?=$arItemIDs['PRICE']?>" ><span class="my-digit"><?=$discPrice?></span>&nbsp;<span class="rouble">&#8399;</span>
                  <noindex><span class="oldPrice"><?=$minPrice?>&nbsp;</span></noindex>
                </span>
              <?else:?>
                <span class="price" id="<?=$arItemIDs['PRICE']?>" ><span class="my-digit"><?=$minPrice?></span>&nbsp;<span class="rouble">&#8399;</span></span>
              <?endif;?>
              <?if($arItem['CAN_BUY']):?>
                <span class="available"><?=GetMessage("WF_PRODUCT_AVAIL_IS")?></span>
              <?else:?>
                <span class="expected"><?=GetMessage("WF_PRODUCT_AVAIL_NO")?></span>
              <?endif;?>
            </div>
            <?if($arItem['CAN_BUY']):?>
              <a href="javascript:void(0);" class="link-basket" id="<?= $arItemIDs['BUY_LINK']?>"><?=GetMessage("CT_BCS_TPL_MESS_BTN_BUY")?></a>
            <?else:?>
              <a class="link-quastion" href="#">?</a>
            <?endif;?>
          </div>
        </div>
      </div>
    </li>
	<?
	$arJSParams = array(
		'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
		'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
		'SHOW_ADD_BASKET_BTN' => false,
		'SHOW_BUY_BTN' => true,
		'SHOW_ABSENT' => true,
		'PRODUCT' => array(
			'ID' => $arItem['ID'],
			'NAME' => $arItem['~NAME'],
			'PICT' => $arItem['PREVIEW_PICTURE'],
			'CAN_BUY' => $arItem["CAN_BUY"],
			'SUBSCRIPTION' => false,
			'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
			'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
			'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
			'ADD_URL' => $arItem['~ADD_URL'],
			'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL']
		),
		'BASKET' => array(
			'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
			'PICT_ID' => $arItemIDs['PICT'],
			'QUANTITY_ID' => $arItemIDs['QUANTITY'],
			'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
			'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
			'PRICE_ID' => $arItemIDs['PRICE'],
			'BUY_ID' => $arItemIDs['BUY_LINK'],
			'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
		),
		'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
	);
	?>
	<script type="text/javascript">
		var <?= $strObName?> = new JCCatalogSectionRec(<?= CUtil::PhpToJSObject($arJSParams, false, true)?>);
	</script>
  <?}?>
  </ul>
</div>
<script type="text/javascript">
	BX.message({
		MESS_BTN_BUY: '<?= ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_TPL_MESS_BTN_BUY')); ?>',
		MESS_BTN_ADD_TO_BASKET: '<?= ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
		MESS_BTN_DETAIL: '<?= ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_TPL_MESS_BTN_DETAIL')); ?>',
		MESS_NOT_AVAILABLE: '<?= ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_TPL_MESS_BTN_DETAIL')); ?>',
		BTN_MESSAGE_BASKET_REDIRECT: '<?= GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
		BASKET_URL: '<?= $arParams["BASKET_URL"]; ?>',
		ADD_TO_BASKET_OK: '<?= GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_ADD_TO_BASKET_OK'); ?>',
		TITLE_ERROR: '<?= GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_TITLE_ERROR') ?>',
		TITLE_BASKET_PROPS: '<?= GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_TITLE_BASKET_PROPS') ?>',
		TITLE_SUCCESSFUL: '<?= GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_ADD_TO_BASKET_OK'); ?>',
		BASKET_UNKNOWN_ERROR: '<?= GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		BTN_MESSAGE_SEND_PROPS: '<?= GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
		BTN_MESSAGE_CLOSE: '<?= GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_BTN_MESSAGE_CLOSE') ?>'
	});
$(function(){
  $(".tab-holder .tab").eq(3).html($("#wf_recomended").html());
  $("#wf_recomended").detach();
});
</script>
<? endif?>
