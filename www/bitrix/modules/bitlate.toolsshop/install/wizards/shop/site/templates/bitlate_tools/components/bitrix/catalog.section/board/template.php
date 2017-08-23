<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule('bitlate.toolsshop');
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
?>
<?if ($arParams["TEMPLATE_THEME"] != 'slider'):?>
    <?if (!$arParams["TAB_TYPE"]):?>
        <?if ($arParams["FILTER_NAME"] != 'searchFilter'):?>
            <div data-sticky-container>
                <div class="sticky md-preloader-wrapper text-center" id="catalog-preloader" data-sticky data-margin-top="0" data-margin-bottom="0" data-top-anchor="catalog-content" data-btm-anchor="catalog-filter:bottom">
                    <div class="md-preloader">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="30" width="30" viewBox="0 0 75 75">
                            <circle cx="37.5" cy="37.5" r="33.5" stroke-width="4"></circle>
                        </svg>
                    </div>
                </div>
            </div>
        <?endif;?>
        <div class="catalog-content" id="catalog-content">
    <?endif;?>
    <div class="products-flex-grid product-grid<?if (!$arParams["TAB_TYPE"]):?> container<?endif;?>">
<?endif;?>
<?
if (!empty($arResult['ITEMS']))
{
	$templateLibrary = array('popup');
	$currencyList = '';
	if (!empty($arResult['CURRENCIES']))
	{
		$templateLibrary[] = 'currency';
		$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
	}
    $templateData = array(
		'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
		'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
		'TEMPLATE_LIBRARY' => $templateLibrary,
		'CURRENCIES' => $currencyList
	);
	
	unset($currencyList, $templateLibrary);

	$arSkuTemplate = array();
    if (!empty($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as &$arProp)
		{
			$arSkuTemplate[$arProp['CODE']] = 1;
		}
		unset($templateRow, $arProp);
	}

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
    
    $buttonText = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));
    $isPriceComposite = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_PRICE_COMPOSITE", false, SITE_ID);
    $largeClass = ($arParams["TAB_TYPE"]) ? "xlarge-6" : "large-6";?>
    <?if ($arParams["TEMPLATE_THEME"] == 'slider'):?>
        <div class="product-seeit">
            <div class="container row">
                <h2><?=$arParams["PAGER_TITLE"]?></h2>
                <div class="owl-carousel product-carousel product-grid<?if ($arParams['SUB_SLIDER'] == "Y"):?> product-carousel-inner<?endif;?>"<?if ($arParams['SLIDER_ZINDEX'] > 0):?> style="z-index:<?=$arParams['SLIDER_ZINDEX']?>;"<?endif;?>>
    <?endif;?>
<?foreach ($arResult['ITEMS'] as $key => $arItem) {
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);

	$arItemIDs = array(
		'ID' => $strMainID,
		'PICT' => $strMainID.'_pict',
		'SECOND_PICT' => $strMainID.'_secondpict',
		'STICKER_ID' => $strMainID.'_sticker',
		'SECOND_STICKER_ID' => $strMainID.'_secondsticker',
		'QUANTITY' => $strMainID.'_quantity',
		'QUANTITY_DOWN' => $strMainID.'_quant_down',
		'QUANTITY_UP' => $strMainID.'_quant_up',
		'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
		'BUY_LINK' => $strMainID.'_buy_link',
		'BASKET_ACTIONS' => $strMainID.'_basket_actions',
		'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
		'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
		'COMPARE_LINK' => $strMainID.'_compare_link',
		'PREVIEW_LINK' => $strMainID.'_preview_link',

		'PRICE' => $strMainID.'_price',
		'PRICE_HOVER' => $strMainID.'_price_hover',
		'DSC_PERC' => $strMainID.'_dsc_perc',
		'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
		'PROP_DIV' => $strMainID.'_sku_tree',
		'PROP' => $strMainID.'_prop_',
		'LIKED_COMPARE_ID' => $strMainID.'_add_liked_compare_',
		'ECONOMY_ID' => $strMainID.'_economy_',
		'ACTION_ECONOMY_ID' => $strMainID.'_action_economy',
		'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
		'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
	);
    $arItemHtml = array(
        'ECONOMY_HTML' => GetMessage("CT_BCS_TPL_MESS_ECONOMY") . ': <span>#ECONOMY_PRICE#</span>',
    );

	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

	$productTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $arItem['NAME']
	);
	$imgTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $arItem['NAME']
	);

	$minPrice = false;
	$minPriceValue = 0;
    $maxPriceValue = 0;
    if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE'])) {
        $minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);
        $minPriceValue = $minPrice["DISCOUNT_VALUE"];
        $maxPriceValue = $minPrice["VALUE"];
    }
    if ($arItem['PROPERTIES']['OLD_PRICE']['VALUE'] > 0 && 
        $arItem['PROPERTIES']['OLD_PRICE']['ACTIVE'] == 'Y' &&
        $arItem['PROPERTIES']['OLD_PRICE']['VALUE'] > $maxPriceValue) {
        $maxPriceValue = $arItem['PROPERTIES']['OLD_PRICE']['VALUE'];
    }
    $discount = ($maxPriceValue > 0 && $minPriceValue > 0) ? ($maxPriceValue - $minPriceValue) : 0;
    $arItem['MIN_BASIS_PRICE']['VALUE'] = $maxPriceValue;
    $arItem['MIN_BASIS_PRICE']['ECONOMY'] = $discount;
    $itemType = array();
    $itemClass = '';
    $payed = 0;
    $quantity = 0;
    $isBigPreview = false;
    if (!empty($arItem['PROPERTIES']['DISCOUNT']['VALUE'])) {
        $itemType[] = 'discount';
    }
    if (!empty($arItem['PROPERTIES']['NEWPRODUCT']['VALUE'])) {
        $itemType[] = 'new';
    }
    if (!empty($arItem['PROPERTIES']['SALELEADER']['VALUE'])) {
        $itemType[] = 'hit';
    }
    if (intval($arItem['PROPERTIES']['PRODUCT_ACTION']['VALUE'])) {
        $itemType = array('action');
        $quantity = intval($arItem['PROPERTIES']['PRODUCT_ACTION']['VALUE']);
        if ($arParams["TAB_TYPE"]) {
            $itemClass = ' size-2x1';
        }
    }
    if (!empty($arItem['PROPERTIES']['PRODUCT_OF_DAY']['VALUE']) && intval($arItem['PROPERTIES']['ALREADY_PAYED']['VALUE']) > 0) {
        $itemType = array('prodday');
        $payed = intval($arItem['PROPERTIES']['ALREADY_PAYED']['VALUE']);
        if ($arParams["TAB_TYPE"]) {
            $itemClass = ' size-2x2';
            $isBigPreview = true;
        }
    }?>
    <?if ($arParams["TEMPLATE_THEME"] != 'slider'):?>
        <div class="products-flex-item<?=$itemClass?>" id="<? echo $strMainID; ?>">
    <?endif;?>
        <div class="item column text-center hover-elements"<?if ($arParams["TEMPLATE_THEME"] == 'slider'):?> id="<? echo $strMainID; ?>"<?endif;?>>
            <?if (!in_array('prodday', $itemType) && !in_array('action', $itemType) && count($itemType) > 0):?>
                <div class="label-block text-left">
                    <?if (in_array('new', $itemType)):?>
                        <div><span class="label warning"><?=GetMessage("CT_BCS_TPL_MESS_NEW")?></span></div>
                    <?endif;
                    if (in_array('discount', $itemType)):?>
                        <div><span class="label sale"><?=GetMessage("CT_BCS_TPL_MESS_DISCOUNT")?></span></div>
                    <?endif;
                    if (in_array('hit', $itemType)):?>
                        <div><span class="label bestseller"><?=GetMessage("CT_BCS_TPL_MESS_HIT")?></span></div>
                    <?endif;?>
                </div>
            <?endif;?>
            <?$pic = false;
            if ($arItem['PREVIEW_PICTURE']['ID'] > 0) {
                $arSizePreview = ($isBigPreview) ? array('width' => 429, 'height' => 380) : array('width' => 170, 'height' => 150);
                $pic = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]['ID'], $arSizePreview, BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
            }
            if ($pic === false) {
                $pic['src'] = SITE_TEMPLATE_PATH . "/images/no_photo.png";
            }?>
            <div class="img-wrap">
                <?if ($arParams["TEMPLATE_THEME"] != 'slider'):?>
                    <img id="<? echo $arItemIDs['PICT']; ?>" src="<?=$pic['src']?>" class="thumbnail" alt="<? echo $productTitle; ?>">
                <?else:?>
                    <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><img id="<? echo $arItemIDs['PICT']; ?>" src="<?=$pic['src']?>" class="thumbnail" alt="<? echo $productTitle; ?>"></a>
                <?endif;?>
            </div>
            <img id="<? echo $arItemIDs['SECOND_PICT']; ?>" src="<? echo (
				!empty($arItem['PREVIEW_PICTURE_SECOND'])
				? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
				: $arItem['PREVIEW_PICTURE']['SRC']
			); ?>" class="thumbnail" alt="<? echo $productTitle; ?>" style="display: none;">
            <?if (in_array('action', $itemType) && $arParams["TAB_TYPE"]):?>
                <div class="row">
                    <div class="xlarge-6 columns columns-info">
                        <div class="name">
                            <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="name"><span><? echo $productTitle; ?></span></a>
                        </div>
            <?else:?>
                <div class="name">
                    <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="name"><span><? echo $productTitle; ?></span></a>
                </div>
            <?endif;?>
            <div id="<? echo $arItemIDs['PRICE']; ?>_block">
                <?if ($isPriceComposite == "Y" && $arParams["REQUEST_LOAD"] == "N"):?>
                    <?$frame = $this->createFrame($arItemIDs['PRICE'] . "_block", false)->begin();?>
                <?endif;?>
                    <?if ($arParams['TAB_TYPE']) {
                        if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) {
                            $isPriceExt = (in_array('action', $itemType) || in_array('prodday', $itemType)) ? false : true;
                        } elseif (count($arItem['PRICES']) > 1 && !in_array('prodday', $itemType) && !in_array('action', $itemType)) {
                            $isPriceExt = true;
                        } else {
                            $isPriceExt = false;
                        }
                    } else {
                        if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) {
                            $isPriceExt = true;
                        } elseif (count($arItem['PRICES']) > 1) {
                            $isPriceExt = true;
                        } else {
                            $isPriceExt = false;
                        }
                    }?>
                    <div class="price<?if ($isPriceExt):?> hover-hide<?endif;?>" id="<? echo $arItemIDs['PRICE']; ?>">
                        <?if (!empty($minPrice)):?><?=$minPrice['PRINT_DISCOUNT_VALUE']?><?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discount > 0):?> <span class="old"><?=CCurrencyLang::CurrencyFormat($maxPriceValue, $arItem['MIN_PRICE']['CURRENCY'])?></span><?endif;?><?endif;?>
                    </div>
                <?if ($isPriceComposite == "Y" && $arParams["REQUEST_LOAD"] == "N"):?>
                    <?$frame->beginStub();?>
                    <?$frame->end();?>
                <?endif;?>
            </div>
            <?if (in_array('prodday', $itemType) && $discount > 0):?>
                <?if ($arParams["TAB_TYPE"]):?>
                    <div class="product-action-banner economy text-center show-for-xlarge">
                        <div class="table-container float-center">
                            <div class="icon rub table-item"><?=GetMessage("CT_BCS_TPL_RUB")?></div>
                            <div class="info table-item"><strong id="<? echo $arItemIDs['ACTION_ECONOMY_ID']; ?>"><?=CCurrencyLang::CurrencyFormat($discount, $arItem['MIN_PRICE']['CURRENCY'])?></strong> <?=GetMessage("CT_BCS_TPL_MESS_ECONOMY_2")?></div>
                            <div class="counter table-item">
                                <div class="progress float-center">
                                    <div class="progress active" style="width:<?=$payed?>%;"></div>
                                </div>
                                <?=GetMessage("CT_BCS_TPL_MESS_PAYED", array("#PAYED#" => $payed))?>
                            </div>
                        </div>
                    </div>
                <?endif;?>
                <div class="product-action-label best-day left"><?=GetMessage("CT_BCS_TPL_MESS_PRODDAY")?></div>
            <?endif;?>
            <?if (in_array('action', $itemType)):?>
                <?if ($arParams["TAB_TYPE"]):?>
                        </div>
                        <div class="xlarge-6 columns">
                            <div class="product-action-banner timer text-center show-for-xlarge">
                                <div class="table-container float-center">
                                    <svg class="icon table-item">
                                        <use xlink:href="#svg-icon-timer"></use>
                                    </svg>
                                    <div class="info table-item">
                                        <div class="table-container">
                                            <div class="table-item time hour"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_HOUR")?></div>
                                            <div class="table-item time min"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_MINUTE")?></div>
                                            <div class="table-item time sec"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_SECOND")?></div>
                                        </div>
                                    </div>
                                    <div class="counter table-item"><strong><?=$quantity?></strong> <?=$arItem["CATALOG_MEASURE_NAME"]?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?endif;?>
                <div class="product-action-label time-buy left"><?=GetMessage("CT_BCS_TPL_MESS_ACTION")?></div>
            <?endif;?>
            <div class="hover-show bx_catalog_item_controls">
                <div class="hover-buttons">
                    <?if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])):?>
                        <?foreach ($arItem['OFFERS'] as $key => $arOffer):
                            $strVisible = ($key == $arItem['OFFERS_SELECTED'] ? '' : 'none');?>
                            <div class="float-right" id="<? echo $arItemIDs['LIKED_COMPARE_ID']; ?><?=$arOffer['ID']?>" style="display: <? echo $strVisible; ?>;">
                                <a href="#" class="button transparent add2liked" title="<?=GetMessage('CT_BCS_ADD_2_LIKED')?>" data-ajax="<?=SITE_DIR?>nl_ajax/favorite.php" data-product-id="<?=$arOffer['ID']?>">
                                    <svg class="icon">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-liked-hover"></use>
                                    </svg>
                                </a>
                                <?if ($arParams['DISPLAY_COMPARE']):?>
                                    <a href="javascript:void(0);" id="<? echo $arItemIDs['COMPARE_LINK']; ?><?=$arOffer['ID']?>" class="button transparent add2compare" title="<?=GetMessage('CT_BCS_ADD_2_COMPARE')?>" data-product-id="<?=$arOffer['ID']?>">
                                        <svg class="icon">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-compare-hover"></use>
                                        </svg>
                                    </a>
                                <?endif;?>
                            </div>
                        <?endforeach;?>
                    <?else:?>
                        <div class="float-right">
                            <a href="#" class="button transparent add2liked" title="<?=GetMessage('CT_BCS_ADD_2_LIKED')?>" data-ajax="<?=SITE_DIR?>nl_ajax/favorite.php" data-product-id="<?=$arItem['ID']?>">
                                <svg class="icon">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-liked-hover"></use>
                                </svg>
                            </a>
                            <?if ($arParams['DISPLAY_COMPARE']):?>
                                <a href="javascript:void(0);" id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="button transparent add2compare" title="<?=GetMessage('CT_BCS_ADD_2_COMPARE')?>" data-product-id="<?=$arItem['ID']?>">
                                    <svg class="icon">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-compare-hover"></use>
                                    </svg>
                                </a>
                            <?endif;?>
                        </div>
                    <?endif;?>
                    <div class="clearfix"></div>
                    <a href="#" data-href="<? echo $arItem['DETAIL_PAGE_URL']; ?>?load=Y" id="<? echo $arItemIDs['PREVIEW_LINK']; ?>" class="button secondary tiny preview-button"><?=GetMessage('CT_BCS_PREVIEW')?></a>
                </div>
                <div id="<? echo $arItemIDs['PRICE_HOVER']; ?>_block">
                    <?if ($isPriceComposite == "Y" && $arParams["REQUEST_LOAD"] == "N"):?>
                        <?$frame = $this->createFrame($arItemIDs['PRICE_HOVER'] . "_block", false)->begin();?>
                    <?endif;?>
                        <?if ($isPriceExt):?>
                            <?if (count($arItem['PRICES']) > 1):?>
                                <div id="<? echo $arItemIDs['PRICE_HOVER']; ?>">
                                    <?foreach ($arItem['PRICES'] as $arPrice):
                                        $maxItemPriceValue = ($arPrice['VALUE'] > $maxPriceValue) ? $arPrice['VALUE'] : $maxPriceValue;
                                        $discountPrice = $maxItemPriceValue - $arPrice['DISCOUNT_VALUE'];?>
                                        <div class="price-block">
                                            <div class="product-info-caption"><?=$arItem['CATALOG_GROUP_NAME_' . $arPrice['PRICE_ID']]?></div>
                                            <div class="price"><?if (!empty($minPrice)):?><?=$arPrice['PRINT_DISCOUNT_VALUE']?><?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discountPrice > 0):?> <span class="old"><?=FormatCurrency($maxItemPriceValue, $arPrice['CURRENCY'])?></span><?endif;?><?endif;?></div>
                                            <?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discountPrice > 0):?>
                                                <div class="economy"><?=GetMessage("CT_BCS_TPL_MESS_ECONOMY")?>: <span><?=FormatCurrency($discountPrice, $arPrice['CURRENCY'])?></span></div>
                                            <?endif;?>
                                        </div>
                                    <?endforeach;?>
                                </div>
                            <?else:?>
                                <div id="<? echo $arItemIDs['PRICE_HOVER']; ?>">
                                    <div class="price"><?if (!empty($minPrice)):?><?=$minPrice['PRINT_DISCOUNT_VALUE']?><?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discount > 0):?> <span class="old"><?=FormatCurrency($maxPriceValue, $arItem['MIN_PRICE']['CURRENCY'])?></span><?endif;?><?endif;?></div>
                                    <?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discount > 0):?>
                                        <div class="economy"><?=GetMessage("CT_BCS_TPL_MESS_ECONOMY")?>: <span><?=FormatCurrency($discount, $arItem['MIN_PRICE']['CURRENCY'])?></span></div>
                                    <?endif;?>
                                </div>
                            <?endif;?>
                        <?endif;?>
                        <?unset($minPrice);?>
                    <?if ($isPriceComposite == "Y" && $arParams["REQUEST_LOAD"] == "N"):?>
                        <?$frame->beginStub();?>
                        <?$frame->end();?>
                    <?endif;?>
                </div>
                <?if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) {?>
                    <?if ($discount > 0 && 'Y' == $arParams['SHOW_OLD_PRICE'] && count($arItem['PRICES']) <= 1 && !(in_array('prodday', $itemType) && $discount > 0 && $arParams['TAB_TYPE']) && !(in_array('action', $itemType) && $arParams['TAB_TYPE'])):?>
                        <div class="economy" id="<? echo $arItemIDs['ECONOMY_ID']; ?>"><?=GetMessage("CT_BCS_TPL_MESS_ECONOMY")?>: <span><?=CCurrencyLang::CurrencyFormat($discount, $arItem['MIN_PRICE']['CURRENCY'])?></span></div>
                    <?endif;?>
                    <?if (in_array('prodday', $itemType) && $discount > 0):?>
                        <?if (!$arParams["TAB_TYPE"]):?>
                            <div class="product-action-banner economy text-center show-for-large">
                                <div class="table-container float-center">
                                    <div class="counter table-item">
                                        <div class="progress float-center">
                                            <div class="progress active" style="width:<?=$payed?>%;"></div>
                                        </div>
                                        <?=GetMessage("CT_BCS_TPL_MESS_PAYED", array("#PAYED#" => $payed))?>
                                    </div>
                                </div>
                            </div>
                        <?endif;?>
                    <?endif;?>
                    <?if (in_array('action', $itemType)):?>
                        <?if (!$arParams["TAB_TYPE"]):?>
                            <div class="product-action-banner timer text-center show-for-large">
                                <div class="table-container float-center">
                                    <div class="info table-item">
                                        <div class="table-container">
                                            <div class="table-item time hour"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_HOUR")?></div>
                                            <div class="table-item time min"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_MINUTE")?></div>
                                            <div class="table-item time sec"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_SECOND")?></div>
                                        </div>
                                    </div>
                                    <div class="counter table-item"><strong><?=$quantity?></strong> <?=$arItem["CATALOG_MEASURE_NAME"]?></div>
                                </div>
                            </div>
                        <?elseif ($discount > 0 && 'Y' == $arParams['SHOW_OLD_PRICE']):?>
                            <div class="<?=$largeClass?> columns">
                                <div class="economy" id="<? echo $arItemIDs['ECONOMY_ID']; ?>"><?=GetMessage("CT_BCS_TPL_MESS_ECONOMY")?>: <span><?=CCurrencyLang::CurrencyFormat($discount, $arItem['MIN_PRICE']['CURRENCY'])?></span></div>
                            </div>
                            <div class="<?=$largeClass?> columns">
                        <?endif;?>
                    <?endif;?>
                    <?if ($arItem['CAN_BUY']) {?>
                        <div class="row row-count-cart">
                            <?if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {?>
                                <div class="small-6 column">
                                    <div class="product-count">
                                        <div class="input-group">
                                            <div class="input-group-button">
                                                <button id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" class="button decrement" type="button">-</button>
                                            </div>
                                            <input class="input-group-field" type="number" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>" min="1" value="1">
                                            <div class="input-group-button">
                                                <button id="<? echo $arItemIDs['QUANTITY_UP']; ?>" class="button increment" type="button">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
                            <div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="small-6 columns">
                                <a id="<? echo $arItemIDs['BUY_LINK']; ?>" href="javascript:;" class="button tiny add2cart" data-preview="#<? echo $arItemIDs['PICT']; ?>" data-product-id="<?=$arItem['ID']?>"><span><?=$buttonText?></span></a>
                            </div>
                        </div>
                    <?} else {?>
                        <div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone row-count-cart" style="display: <? echo ($canBuy ? 'none' : ''); ?>;"><span class="bx_notavailable"><?
                        echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
                        ?></span></div>
                    <?}?>
                    <?if ($arParams["TAB_TYPE"] && in_array('action', $itemType) && $discount > 0 && 'Y' == $arParams['SHOW_OLD_PRICE']):?>
                        </div> <!-- end large-6 columns -->
                    <?endif;?>
                    <?$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
                    if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties) {?>
                        <div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
                            <?if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])) {
                                foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) {?>
                                    <input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
                                    <?if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
                                        unset($arItem['PRODUCT_PROPERTIES'][$propID]);
                                }
                            }
                            $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
                            if (!$emptyProductProperties) {?>
                                <table>
                                    <?foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo) {?>
                                        <tr><td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
                                            <td>
                                            <?if(
                                                'L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']
                                                && 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']
                                            ) {
                                                foreach($propInfo['VALUES'] as $valueID => $value)
                                                {
                                                    ?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
                                                }
                                            } else {
                                                ?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
                                                foreach($propInfo['VALUES'] as $valueID => $value)
                                                {
                                                    ?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? 'selected' : ''); ?>><? echo $value; ?></option><?
                                                }
                                                ?></select><?
                                            }?>
                                        </td></tr>
                                    <?}?>
                                </table>
                            <?}?>
                        </div>
                    <?}
                    $arJSParams = array(
                        'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                        'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
                        'SHOW_ADD_BASKET_BTN' => false,
                        'SHOW_BUY_BTN' => true,
                        'SHOW_ABSENT' => true,
                        'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                        'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                        'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
                        'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                        'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                        'PRODUCT' => array(
                            'ID' => $arItem['ID'],
                            'NAME' => $productTitle,
                            'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
                            'CAN_BUY' => $arItem["CAN_BUY"],
                            'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
                            'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
                            'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
                            'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
                            'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
                            'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL'],
                            'BASIS_PRICE' => $arItem['MIN_BASIS_PRICE']
                        ),
                        'BASKET' => array(
                            'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                            'EMPTY_PROPS' => $emptyProductProperties,
                            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
                        ),
                        'VISUAL' => array(
                            'ID' => $arItemIDs['ID'],
                            'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
                            'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                            'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                            'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                            'PRICE_ID' => $arItemIDs['PRICE'],
                            'PRICE_HOVER_ID' => $arItemIDs['PRICE_HOVER'],
                            'BUY_ID' => $arItemIDs['BUY_LINK'],
                            'LIKED_COMPARE_ID' => $arItemIDs['LIKED_COMPARE_ID'],
                            'ECONOMY_ID' => $arItemIDs['ECONOMY_ID'],
                            'ACTION_ECONOMY_ID' => $arItemIDs['ACTION_ECONOMY_ID'],
                            'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
                            'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
                            'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
                            'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
                            'ECONOMY_HTML' => $arItemHtml['ECONOMY_HTML']
                        ),
                        'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
                    );
                    if ($arParams['DISPLAY_COMPARE'])
                    {
                        $arJSParams['COMPARE'] = array(
                            'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
                            'COMPARE_PATH' => $arParams['COMPARE_PATH']
                        );
                    }
                    if (count($arItem['PRICES']) > 1) {
                        $iPrice = 0;
                        foreach($arItem['PRICES'] as $arPrice) {
                            $maxItemPriceValue = ($arPrice['VALUE'] > $maxPriceValue) ? $arPrice['VALUE'] : $maxPriceValue;
                            $arJSParams['PRODUCT']['BASIS_PRICE']['PRICES'][$iPrice]['TITLE'] = $arItem['CATALOG_GROUP_NAME_' . $arPrice['PRICE_ID']];
                            $arJSParams['PRODUCT']['BASIS_PRICE']['PRICES'][$iPrice]['DISCOUNT_VALUE'] = $arPrice['DISCOUNT_VALUE'];
                            $arJSParams['PRODUCT']['BASIS_PRICE']['PRICES'][$iPrice]['VALUE'] = $maxItemPriceValue;
                            $arJSParams['PRODUCT']['BASIS_PRICE']['PRICES'][$iPrice]['ECONOMY'] = $maxItemPriceValue - $arPrice['DISCOUNT_VALUE'];
                            $arJSParams['PRODUCT']['BASIS_PRICE']['PRICES'][$iPrice]['CURRENCY'] = $arPrice['CURRENCY'];
                            $iPrice++;
                        }
                    }
                    unset($emptyProductProperties);?>
                    <script type="text/javascript">
                        <?if ($isPriceComposite == "Y" && $arParams["REQUEST_LOAD"] == "N"):?>
                            if (window.frameCacheVars === undefined) {
                                var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                            } else {
                                BX.addCustomEvent("onFrameDataReceived" , function(json) {
                                    var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                                });
                            }
                        <?else:?>
                            var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                        <?endif;?>
                    </script>
                <?} else {?>
                    <?if ('Y' == $arParams['SHOW_OLD_PRICE'] && count($arItem['PRICES']) <= 1 && !((in_array('action', $itemType) || in_array('prodday', $itemType)) && $arParams['TAB_TYPE'])):?>
                        <div class="economy" style="display:none;" id="<? echo $arItemIDs['ECONOMY_ID']; ?>"></div>
                    <?endif;?>
                    <?if (in_array('prodday', $itemType) && $discount > 0):?>
                        <?if (!$arParams["TAB_TYPE"]):?>
                            <div class="product-action-banner economy text-center show-for-large">
                                <div class="table-container float-center">
                                    <div class="counter table-item">
                                        <div class="progress float-center">
                                            <div class="progress active" style="width:<?=$payed?>%;"></div>
                                        </div>
                                        <?=GetMessage("CT_BCS_TPL_MESS_PAYED", array("#PAYED#" => $payed))?>
                                    </div>
                                </div>
                            </div>
                        <?endif;?>
                    <?endif;?>
                    <?if (in_array('action', $itemType)):?>
                        <?if (!$arParams["TAB_TYPE"]):?>
                            <div class="product-action-banner timer text-center show-for-large">
                                <div class="table-container float-center">
                                    <div class="info table-item">
                                        <div class="table-container">
                                            <div class="table-item time hour"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_HOUR")?></div>
                                            <div class="table-item time min"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_MINUTE")?></div>
                                            <div class="table-item time sec"><strong>00</strong> <?=GetMessage("CT_BCS_TPL_MESS_SECOND")?></div>
                                        </div>
                                    </div>
                                    <div class="counter table-item"><strong><?=$quantity?></strong> <?=$arItem["CATALOG_MEASURE_NAME"]?></div>
                                </div>
                            </div>
                        <?endif;?>
                    <?endif;?>
                    <div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>">
                        <?if (in_array('action', $itemType) && $arParams['TAB_TYPE']):?>
                            <div class="large-6 columns">
                        <?elseif (in_array('prodday', $itemType) && $arParams['TAB_TYPE']):?>
                            <div class="row large-10 float-center">
                        <?endif;?>
                        <?if (!empty($arItem['OFFERS_PROP'])) {
                            $arSkuProps = array();
                                $beginStr = (in_array('prodday', $itemType) && $arParams['TAB_TYPE']) ? '<div class="xlarge-6 columns">' : '';
                                $endStr = (in_array('prodday', $itemType) && $arParams['TAB_TYPE']) ? '</div>' : '';?>
                                <?foreach ($arSkuTemplate as $code => $strTemplate) {
                                    if (!isset($arItem['OFFERS_PROP'][$code])) {
                                        continue;
                                    } else {
                                        $arProp = $arResult['SKU_PROPS'][$code];
                                        $arPropIds = array();
                                        foreach ($arItem['OFFERS'] as $arOneOffer) {
                                            if (isset($arOneOffer['TREE']['PROP_' . $arProp['ID']])) {
                                                $arPropIds[] = $arOneOffer['TREE']['PROP_' . $arProp['ID']];
                                            }
                                        }
                                        $arPropIds = array_unique($arPropIds);
                                        $templateRow = '';
                                        if ('TEXT' == $arProp['SHOW_MODE'])
                                        {
                                            if ("SIZES_CLOTHES" == $arProp['CODE'] || "SIZES_SHOES" == $arProp['CODE']) {
                                                $arProp['NAME'] = GetMessage("CT_BCS_CATALOG_SIZE_TITLE");
                                            }
                                            $templateRow .= '<div class="row text-left" id="#ITEM#_prop_'.$arProp['ID'].'_cont"><div class="small-4 column">'.
                            '<div class="product-info-caption">'.htmlspecialcharsex($arProp['NAME']).':&nbsp;</div></div>'.
                            '<div class="small-8 columns"><div class="product-info-option text"><fieldset class="inline-block-container" id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                                            foreach ($arProp['VALUES'] as $arOneValue)
                                            {
                                                if (in_array($arOneValue['ID'], $arPropIds)) {
                                                    $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                                    $templateRow .= '<div class="inline-block-item" data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'"><input type="radio" name="#ITEM#_prop_name_'.$arProp['ID'].'" value="'.$arOneValue['ID'].'" id="#ITEM#_prop_'.$arProp['ID'].'_'.$arOneValue['ID'].'" class="show-for-sr" title="'.$arOneValue['NAME'].'"><label for="#ITEM#_prop_'.$arProp['ID'].'_'.$arOneValue['ID'].'" class="inline-block-item" title="'.$arOneValue['NAME'].'"><span>'.$arOneValue['NAME'].'</span></label></div>';
                                                }
                                            }
                                            $templateRow .= '</fieldset></div></div>'.
                            '<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'"></div>'.
                            '<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'"></div>'.
                            '</div>';
                                        }
                                        elseif ('PICT' == $arProp['SHOW_MODE'])
                                        {
                                            $templateRow .= '<div class="row text-left" id="#ITEM#_prop_'.$arProp['ID'].'_cont"><div class="small-4 column">'.
                            '<div class="product-info-caption">'.htmlspecialcharsex($arProp['NAME']).':&nbsp;</div></div>'.
                            '<div class="small-8 columns"><div class="product-info-option color"><fieldset class="inline-block-container" id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                                            foreach ($arProp['VALUES'] as $arOneValue)
                                            {
                                                if (in_array($arOneValue['ID'], $arPropIds)) {
                                                    $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                                    $templateRow .= '<div class="inline-block-item" data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'"><input type="radio" name="#ITEM#_prop_name_'.$arProp['ID'].'" value="'.$arOneValue['ID'].'" id="#ITEM#_prop_'.$arProp['ID'].'_'.$arOneValue['ID'].'" class="show-for-sr" title="'.$arOneValue['NAME'].'"><label for="#ITEM#_prop_'.$arProp['ID'].'_'.$arOneValue['ID'].'" class="inline-block-item" title="'.$arOneValue['NAME'].'"><span style="background-image:url(\''.$arOneValue['PICT']['SRC'].'\');" title="'.$arOneValue['NAME'].'"></span></label></div>';
                                                }
                                            }
                                            $templateRow .= '</fieldset></div></div>'.
                            '<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'"></div>'.
                            '<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'"></div>'.
                            '</div>';
                                        }
                                        $strTemplate = $templateRow;
                                    }
                                    echo $beginStr, str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), $endStr;
                                }
                                foreach ($arResult['SKU_PROPS'] as $arOneProp) {
                                    if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
                                        continue;
                                    $arSkuProps[] = array(
                                        'ID' => $arOneProp['ID'],
                                        'SHOW_MODE' => $arOneProp['SHOW_MODE'],
                                        'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
                                    );
                                }
                                foreach ($arItem['JS_OFFERS'] as &$arOneJs) {
                                    if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
                                    {
                                        $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
                                        $arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
                                    }
                                }
                                unset($arOneJs);?>
                            
                            <?if ($arItem['OFFERS_PROPS_DISPLAY']) {
                                foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer) {
                                    $strProps = '';
                                    if (!empty($arJSOffer['DISPLAY_PROPERTIES'])) {
                                        foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp) {
                                            $strProps .= '<br>'.$arOneProp['NAME'].' <strong>'.(
                                                is_array($arOneProp['VALUE'])
                                                ? implode(' / ', $arOneProp['VALUE'])
                                                : $arOneProp['VALUE']
                                            ).'</strong>';
                                        }
                                    }
                                    $arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
                                }
                            }
                            foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer) {
                                if (intval($arItem['PROPERTIES']['OLD_PRICE']['VALUE']) > 0 && 
                                    $arItem['PROPERTIES']['OLD_PRICE']['ACTIVE'] == 'Y' &&
                                    intval($arItem['PROPERTIES']['OLD_PRICE']['VALUE']) > $arItem['JS_OFFERS'][$keyOffer]['PRICE']['VALUE']) {
                                    $arItem['JS_OFFERS'][$keyOffer]['PRICE']['VALUE'] = intval($arItem['PROPERTIES']['OLD_PRICE']['VALUE']);
                                    $arItem['JS_OFFERS'][$keyOffer]['PRICE']['PRINT_VALUE'] = CCurrencyLang::CurrencyFormat($arItem['PROPERTIES']['OLD_PRICE']['VALUE'], $arItem['JS_OFFERS'][$keyOffer]['PRICE']['CURRENCY']);
                                }
                                $discount = $arItem['JS_OFFERS'][$keyOffer]['PRICE']['VALUE'] - $arItem['JS_OFFERS'][$keyOffer]['PRICE']['DISCOUNT_VALUE'];
                                $arItem['JS_OFFERS'][$keyOffer]['PRICE']['ECONOMY'] = $discount;
                                $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['VALUE'] = $arItem['JS_OFFERS'][$keyOffer]['PRICE']['VALUE'];
                                $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['ECONOMY'] = $discount;
                                if (count($arItem['OFFERS'][$keyOffer]['PRICES']) > 1 && (!$arParams['TAB_TYPE'] || ($arParams['TAB_TYPE'] && !in_array('prodday', $itemType) && !in_array('action', $itemType)))) {
                                    $iPrice = 0;
                                    foreach($arItem['OFFERS'][$keyOffer]['PRICES'] as $arPrice) {
                                        $maxItemPriceValue = ($arPrice['VALUE'] > $maxPriceValue) ? $arPrice['VALUE'] : $maxPriceValue;
                                        $arItem['JS_OFFERS'][$keyOffer]['PRICE']['PRICES'][$iPrice]['TITLE'] = $arItem['OFFERS'][$keyOffer]['CATALOG_GROUP_NAME_' . $arPrice['PRICE_ID']];
                                        $arItem['JS_OFFERS'][$keyOffer]['PRICE']['PRICES'][$iPrice]['DISCOUNT_VALUE'] = $arPrice['DISCOUNT_VALUE'];
                                        $arItem['JS_OFFERS'][$keyOffer]['PRICE']['PRICES'][$iPrice]['VALUE'] = $maxItemPriceValue;
                                        $arItem['JS_OFFERS'][$keyOffer]['PRICE']['PRICES'][$iPrice]['ECONOMY'] = $maxItemPriceValue - $arPrice['DISCOUNT_VALUE'];
                                        $arItem['JS_OFFERS'][$keyOffer]['PRICE']['PRICES'][$iPrice]['CURRENCY'] = $arPrice['CURRENCY'];
                                        $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['PRICES'][$iPrice]['TITLE'] = $arItem['OFFERS'][$keyOffer]['CATALOG_GROUP_NAME_' . $arPrice['PRICE_ID']];
                                        $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['PRICES'][$iPrice]['DISCOUNT_VALUE'] = $arPrice['DISCOUNT_VALUE'];
                                        $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['PRICES'][$iPrice]['VALUE'] = $maxItemPriceValue;
                                        $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['PRICES'][$iPrice]['ECONOMY'] = $maxItemPriceValue - $arPrice['DISCOUNT_VALUE'];
                                        $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['PRICES'][$iPrice]['CURRENCY'] = $arPrice['CURRENCY'];
                                        $iPrice++;
                                    }
                                }
                            }
                            $arJSParams = array(
                                'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                                'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
                                'SHOW_ADD_BASKET_BTN' => false,
                                'SHOW_BUY_BTN' => true,
                                'SHOW_ABSENT' => true,
                                'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
                                'SECOND_PICT' => $arItem['SECOND_PICT'],
                                'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                                'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                                'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                                'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
                                'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                                'DEFAULT_PICTURE' => array(
                                    'PICTURE' => $arItem['PRODUCT_PREVIEW'],
                                    'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
                                ),
                                'VISUAL' => array(
                                    'ID' => $arItemIDs['ID'],
                                    'PICT_ID' => $arItemIDs['PICT'],
                                    'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
                                    'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                                    'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                                    'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                                    'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
                                    'PRICE_ID' => $arItemIDs['PRICE'],
                                    'PRICE_HOVER_ID' => $arItemIDs['PRICE_HOVER'],
                                    'TREE_ID' => $arItemIDs['PROP_DIV'],
                                    'TREE_ITEM_ID' => $arItemIDs['PROP'],
                                    'BUY_ID' => $arItemIDs['BUY_LINK'],
                                    'LIKED_COMPARE_ID' => $arItemIDs['LIKED_COMPARE_ID'],
                                    'ECONOMY_ID' => $arItemIDs['ECONOMY_ID'],
                                    'ACTION_ECONOMY_ID' => $arItemIDs['ACTION_ECONOMY_ID'],
                                    'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
                                    'DSC_PERC' => $arItemIDs['DSC_PERC'],
                                    'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
                                    'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
                                    'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
                                    'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
                                    'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
                                    'ECONOMY_HTML' => $arItemHtml['ECONOMY_HTML']
                                ),
                                'BASKET' => array(
                                    'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                                    'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                                    'SKU_PROPS' => $arItem['OFFERS_PROP_CODES'],
                                    'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                                    'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
                                ),
                                'PRODUCT' => array(
                                    'ID' => $arItem['ID'],
                                    'NAME' => $productTitle
                                ),
                                'OFFERS' => $arItem['JS_OFFERS'],
                                'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
                                'TREE_PROPS' => $arSkuProps,
                                'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
                            );
                            if ($arParams['DISPLAY_COMPARE'])
                            {
                                $arJSParams['COMPARE'] = array(
                                    'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
                                    'COMPARE_PATH' => $arParams['COMPARE_PATH']
                                );
                            }
                            ?>
                            <script type="text/javascript">
                                <?if ($isPriceComposite == "Y" && $arParams["REQUEST_LOAD"] == "N"):?>
                                    if (window.frameCacheVars === undefined) {
                                        var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                                    } else {
                                        BX.addCustomEvent("onFrameDataReceived" , function(json) {
                                            var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                                        });
                                    }
                                <?else:?>
                                    var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                                <?endif;?>
                            </script>
                        <?}?>
                        <?$canBuy = $arItem['JS_OFFERS'][$arItem['OFFERS_SELECTED']]['CAN_BUY'];?>
                        <?if (in_array('action', $itemType) && $arParams['TAB_TYPE']):?>
                            </div>
                            <div class="xlarge-6 columns">
                                <div class="economy" style="display:none;" id="<? echo $arItemIDs['ECONOMY_ID']; ?>"></div>
                        <?elseif (in_array('prodday', $itemType) && $arParams['TAB_TYPE']):?>
                            </div>
                        <?endif;?>
                        <div class="row row-count-cart bx_catalog_item_controls no_touch">
                            <?if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {?>
                                <div class="small-6 column">
                                    <div class="product-count">
                                        <div class="input-group">
                                            <div class="input-group-button">
                                                <button id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" class="button decrement" type="button">-</button>
                                            </div>
                                            <input class="input-group-field" type="number" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>" min="1" value="1">
                                            <div class="input-group-button">
                                                <button id="<? echo $arItemIDs['QUANTITY_UP']; ?>" class="button increment" type="button">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
                            <div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone" style="display: <? echo ($canBuy ? 'none' : ''); ?>;"><span class="bx_notavailable"><?
                                echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
                            ?></span></div>
                            <div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="small-6 columns" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
                                <?foreach ($arItem['OFFERS'] as $key => $arOffer):
                                    $strVisible = ($key == $arItem['OFFERS_SELECTED'] ? '' : 'none');?>
                                    <a id="<? echo $arItemIDs['BUY_LINK']; ?><?=$arOffer['ID']?>" class="button tiny add2cart" href="javascript:;" rel="nofollow" data-preview="#<? echo $arItemIDs['PICT']; ?>" style="display: <? echo $strVisible; ?>;" data-product-id="<?=$arOffer['ID']?>"><span><?=$buttonText?></span></a>
                                <?endforeach;?>
                            </div>
                        </div>
                        <?if ('Y' == $arParams['SHOW_OLD_PRICE'] && in_array('action', $itemType) && $arParams['TAB_TYPE']):?>
                            </div>
                        <?endif;?>
                        <?unset($canBuy);?>
                    </div>
                <?}?>
            </div>
        </div>
    <?if ($arParams["TEMPLATE_THEME"] != 'slider'):?>
        </div>
    <?endif;?>
<?}?>
<?if ($arParams["TEMPLATE_THEME"] == 'slider'):?>
        </div>
    </div>
<?endif;?>
<? 
}
?>
<?$nextPageUrl = '';
if (isset($arResult['NAV_RESULT']->NavPageCount) && ($arResult['NAV_RESULT']->NavPageCount > 1) && ($arResult['NAV_RESULT']->NavPageCount > $arResult['NAV_RESULT']->NavPageNomer)) {
    if ($arParams["TAB_TYPE"]) {
        $nextPageUrl = SITE_DIR . "nl_ajax/product_tab.php?TAB_TYPE=" . $arParams["TAB_TYPE"] . "&PAGEN_1=" . ($arResult['NAV_RESULT']->NavPageNomer + 1) . "&load=Y";
    } else {
        $nextPageUrl = $APPLICATION->GetCurPageParam("PAGEN_" . $arResult['NAV_RESULT']->NavNum . "=" . ($arResult['NAV_RESULT']->NavPageNomer + 1) . "&load=Y", array("PAGE_EL_COUNT", "PAGEN_" . $arResult['NAV_RESULT']->NavNum, "load"));
    }
}?>
<?if ($arParams["TEMPLATE_THEME"] != 'slider'):?>
        <?if ($arParams["TAB_TYPE"]):?>
            <?if ($arParams["REQUEST_LOAD"] == "Y"):?>
                <script>
                    <?$parentBlock = ($arParams["TAB_TYPE"]) ? "#product-tab-{$arParams["TAB_TYPE"]} " : "";?>
                    <?if ($nextPageUrl != ''):?>
                        $('<?=$parentBlock?>.load-more').attr('data-ajax', '<?=$nextPageUrl?>');
                        $('<?=$parentBlock?>.load-more').show();
                    <?else:?>
                        $('<?=$parentBlock?>.load-more').hide();
                    <?endif;?>
                </script>
            <?else:?>
                </div>
            <?endif;?>
        <?endif;?>
    </div>
    <div class="row collapse catalog-footer">
        <div class="column large-4 small-12">
            <?if (!empty($arResult['ITEMS'])):?>
            <?$APPLICATION->IncludeComponent(
                "bitlate:catalog.page.to.show",
                "",
                array(
                    "PAGE_TO_LIST" => $arParams['PAGE_TO_LIST'],
                    "PAGE_ELEMENT_COUNT" => $arParams['PAGE_ELEMENT_COUNT'],
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );?>
        <?endif;?>&nbsp;
        </div>
        <div class="column large-4 small-12 text-center">
            <?if ($nextPageUrl != ''):?>
                <a href="javascript:;" class="load-more text-center" onclick="getCatalogItems(this, '<?=(($arParams["TAB_TYPE"]) ? '.product-grid-' . $arParams["TAB_TYPE"] . ' .product-grid' : '.products-flex-grid')?>', false<?if ($arParams["TAB_TYPE"]):?>, true<?endif;?>)" data-ajax="<?=$nextPageUrl?>">
                    <svg class="icon">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-load-more"></use>
                    </svg>
                    <span><?=GetMessage('CT_BCS_TPL_BUTTON_SHOW_MORE')?></span>
                </a>
            <?endif;?>
        </div>
        <div class="column large-4 small-12">
            <?if ($arParams["DISPLAY_BOTTOM_PAGER"]) {
                echo $arResult["NAV_STRING"];
            }?>
        </div>
    </div>
    <?if (!$arParams["TAB_TYPE"]):?>
        </div>
    <?endif;?>
<?endif;?>
<?if ($arParams["REQUEST_LOAD"] != "Y"):?>
    <script type="text/javascript">
        BX.message({
            BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
            BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
            ADD_TO_BASKET_BUTTON: '<? echo $buttonText; ?>',
            ADD_TO_BASKET: '<? echo GetMessageJS('ADD_TO_BASKET'); ?>',
            ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
            TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
            TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
            TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
            BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
            BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
            BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>',
            BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
            COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK') ?>',
            COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
            COMPARE_TITLE: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE') ?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_COMPARE_REDIRECT') ?>',
            BTN_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_COMPARE_REDIRECT') ?>',
            SITE_ID: '<? echo SITE_ID; ?>'
        });
        var NL_ADD_TO_BASKET = '<?=GetMessageJS('ADD_TO_BASKET')?>';
        var NL_ADD_TO_BASKET_URL = '<?=$arParams['BASKET_URL']?>';
        var NL_ADD_TO_BASKET_BUTTON = '<?=$buttonText?>';
    </script>
<?endif;?>