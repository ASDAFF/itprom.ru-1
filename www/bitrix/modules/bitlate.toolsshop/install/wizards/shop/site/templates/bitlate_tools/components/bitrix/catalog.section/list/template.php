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
<?if (!$arParams["TAB_TYPE"]):?>
    <div data-sticky-container>
        <div class="sticky md-preloader-wrapper text-center" id="catalog-preloader" data-sticky data-margin-top="0" data-margin-bottom="0" data-top-anchor="catalog-content" data-btm-anchor="catalog-filter:bottom">
            <div class="md-preloader">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="30" width="30" viewBox="0 0 75 75">
                    <circle cx="37.5" cy="37.5" r="33.5" stroke-width="4"></circle>
                </svg>
            </div>
        </div>
    </div>
    <div class="catalog-content" id="catalog-content">
<?endif;?>
<div class="product-list maxi">
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
    $isPriceComposite = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_PRICE_COMPOSITE", false, SITE_ID);?>
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
        'PROP_TABLE' => $strMainID.'_prop_table_',
        'QUANTITY_MAX' => $strMainID.'_quant_max_',
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
    $payed = 0;
    $quantity = 0;
    if (!empty($arItem['PROPERTIES']['DISCOUNT']['VALUE'])) {
        $itemType[] = 'discount';
    }
    if (!empty($arItem['PROPERTIES']['NEWPRODUCT']['VALUE']))
        $itemType[] = 'new';
        
    if (!empty($arItem['PROPERTIES']['SALELEADER']['VALUE'])) {
        $itemType[] = 'hit';
    }
    if (intval($arItem['PROPERTIES']['PRODUCT_ACTION']['VALUE'])) {
        $itemType = array('action');
        $quantity = intval($arItem['PROPERTIES']['PRODUCT_ACTION']['VALUE']);
    }
    if (!empty($arItem['PROPERTIES']['PRODUCT_OF_DAY']['VALUE']) && intval($arItem['PROPERTIES']['ALREADY_PAYED']['VALUE']) > 0) {
        $itemType = array('prodday');
        $payed = intval($arItem['PROPERTIES']['ALREADY_PAYED']['VALUE']);
    }?>
    <div class="product-list-item table-container h100pc" id="<? echo $strMainID; ?>">
        <div class="table-item small-3 large-4 xxlarge-3 h100pc column-preview text-center relative">
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
            <?if (in_array('prodday', $itemType) && $discount > 0):?>
                <div class="product-action-label best-day left"><?=GetMessage("CT_BCS_TPL_MESS_PRODDAY")?></div>
            <?endif;?>
            <?if (in_array('action', $itemType)):?>
                <div class="product-action-label time-buy left"><?=GetMessage("CT_BCS_TPL_MESS_ACTION")?></div>
            <?endif;?>
            <?$pic = false;
            if ($arItem['PREVIEW_PICTURE']['ID'] > 0) {
                $pic = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]['ID'], array('width' => 170, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
            }
            if ($pic === false) {
                $pic['src'] = SITE_TEMPLATE_PATH . "/images/no_photo.png";
            }?>
            <div class="img-wrap">
                <img id="<? echo $arItemIDs['PICT']; ?>" src="<?=$pic['src']?>" class="thumbnail" alt="<? echo $productTitle; ?>">
            </div>
            <img id="<? echo $arItemIDs['SECOND_PICT']; ?>" src="<? echo (
                !empty($arItem['PREVIEW_PICTURE_SECOND'])
                ? $arItem['PREVIEW_PICTURE_SECOND']['SRC']
                : $arItem['PREVIEW_PICTURE']['SRC']
            ); ?>" class="thumbnail" alt="<? echo $productTitle; ?>" style="display: none;">
            <?/*if (in_array('prodday', $itemType) && $discount > 0):?>
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
            <?if (in_array('action', $itemType)):?>
                <div class="product-action-banner timer text-center show-for-large">
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
            <?endif;*/?>
        </div>
        <div class="table-item small-9 large-8 xxlarge-9 h100pc">
            <div class="column large-6 xxlarge-8 column-info">
                <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="name"><? echo $productTitle; ?></a>
                <div class="row">
                    <div class="column column-info-block small-6 medium-4 large-6 xxlarge-4">
                        <div class="rating">
                            <div class="rating-star">
                                <div class="rating-star-active" style="width: <?=($arItem['RATING']/5 * 100)?>%;"></div>
                            </div>
                            <span class="rating-count hide-for-small-only" title="<?=getMessage('CT_BCS_COUNT_RATE', array('COUNT' => $arItem['VOTE_COUNT']))?>"><?=$arItem['VOTE_COUNT']?></span>
                        </div>
                    </div>
                    <?if ($arParams['SHOW_MAX_QUANTITY']):
                        if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])):
                            $quantityInfo = NLApparelshopUtils::getProductAmount($arItem['CATALOG_QUANTITY'], $arParams['MIN_AMOUNT'], $arParams['MAX_AMOUNT']);
                            $quantityText = ($arParams['USE_MIN_AMOUNT'] == "Y") ? $quantityInfo['text'] : $quantityInfo['products'];?>
                            <div class="column column-info-block small-6 medium-4 large-6 xxlarge-4 existence <?=$quantityInfo['class']?>" title="<?=$quantityText?>">
                                <div class="existence-icon">
                                    <div class="existence-icon-active"></div>
                                </div>
                                <span class="existence-count"><?=$quantityText?></span>
                            </div>
                        <?else:?>
                            <div class="column column-info-block small-6 medium-4 large-6 xxlarge-4">
                                <?foreach ($arItem['OFFERS'] as $key => $arOneOffer):
                                    $quantityInfo = NLApparelshopUtils::getProductAmount($arOneOffer['CATALOG_QUANTITY'], $arParams['MIN_AMOUNT'], $arParams['MAX_AMOUNT']);
                                    $quantityText = ($arParams['USE_MIN_AMOUNT'] == "Y") ? $quantityInfo['text'] : $quantityInfo['products'];
                                    $strVisible = ($key == $arItem['OFFERS_SELECTED'] ? '' : 'none');?>
                                        <div class="existence <?=$quantityInfo['class']?>" id="<? echo $arItemIDs['QUANTITY_MAX'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
                                            <div class="existence-icon">
                                                <div class="existence-icon-active"></div>
                                            </div>
                                            <span class="existence-count"><?=$quantityText?></span>
                                        </div>
                                <?endforeach;?>
                            </div>
                        <?endif;?>
                    <?endif;?>
                    <?if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])):?>
                        <?foreach ($arItem['OFFERS'] as $key => $arOffer):
                            $strVisible = ($key == $arItem['OFFERS_SELECTED'] ? '' : 'none');?>
                            <div class="column column-info-block small-6 medium-4 large-6 xxlarge-4 float-left" id="<? echo $arItemIDs['LIKED_COMPARE_ID']; ?><?=$arOffer['ID']?>" style="display: <? echo $strVisible; ?>;">
                                <a href="#" class="button transparent add2liked" title="<?=GetMessage('CT_BCS_ADD_2_LIKED')?>" data-ajax="<?=SITE_DIR?>nl_ajax/favorite.php" data-product-id="<?=$arOffer['ID']?>">
                                    <svg class="icon">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-liked"></use>
                                    </svg>
                                </a>
                                <?if ($arParams['DISPLAY_COMPARE']):?>
                                    <a href="javascript:void(0);" id="<? echo $arItemIDs['COMPARE_LINK']; ?><?=$arOffer['ID']?>" class="button transparent add2compare" title="<?=GetMessage('CT_BCS_ADD_2_COMPARE')?>" data-product-id="<?=$arOffer['ID']?>">
                                        <svg class="icon">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-compare"></use>
                                        </svg>
                                    </a>
                                <?endif;?>
                            </div>
                        <?endforeach;?>
                    <?else:?>
                        <div class="column column-info-block small-6 medium-4 large-6 xxlarge-4 float-left">
                            <a href="#" class="button transparent add2liked" title="<?=GetMessage('CT_BCS_ADD_2_LIKED')?>" data-ajax="<?=SITE_DIR?>nl_ajax/favorite.php" data-product-id="<?=$arItem['ID']?>">
                                <svg class="icon">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-liked"></use>
                                </svg>
                            </a>
                            <?if ($arParams['DISPLAY_COMPARE']):?>
                                <a href="javascript:void(0);" id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="button transparent add2compare" title="<?=GetMessage('CT_BCS_ADD_2_COMPARE')?>" data-product-id="<?=$arItem['ID']?>">
                                    <svg class="icon">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-compare"></use>
                                    </svg>
                                </a>
                            <?endif;?>
                        </div>
                    <?endif;?>
                </div>
                <div class="show-for-xxlarge">
                    <?if ('' != $arItem['PREVIEW_TEXT']):?>
                        <p class="description"><?=$arItem['PREVIEW_TEXT']?></p>
                    <?endif;?>
                    <?$isParams = false;
                    foreach ($arItem['DISPLAY_PROPERTIES'] as $arProperty) {
                        if (in_array($arProperty['ID'], $arItem['SHOWED_PROPERTIES']) && $arProperty['ACTIVE'] == 'Y') {
                            $isParams = true;
                            break;
                        }
                        if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS']) && $arItem['SHOW_OFFERS_PROPS']) {
                            foreach ($arItem['OFFERS'] as $arOneOffer) {
                                if (!empty($arOneOffer['DISPLAY_PROPERTIES'])) {
                                    $isParams = true;
                                    break;
                                }
                            }
                        }
                    }
                    if ($isParams) {?>
                        <?if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])):
                            foreach ($arItem['OFFERS'] as $key => $arOneOffer):
                                $strVisible = ($key == $arItem['OFFERS_SELECTED'] ? '' : 'none');?>
                                <div id="<? echo $arItemIDs['PROP_TABLE'].$arOneOffer['ID'] ?>" style="display: <? echo $strVisible; ?>;">
                                    <a href="javascript:;" data-toggle="product-config-<?=$arOneOffer['ID']?>" class="dropdown-link"><?=GetMessage("CT_BCS_PRODUCT_CONFIG")?></a>
                                    <div id="product-config-<?=$arOneOffer['ID']?>" class="dropdown-config dropdown-pane" data-dropdown>
                                        <table>
                                            <?foreach ($arItem['DISPLAY_PROPERTIES'] as $arProperty):
                                                if (in_array($arProperty['ID'], $arItem['SHOWED_PROPERTIES']) && $arProperty['ACTIVE'] == 'Y'):
                                                    $pValue = (is_array($arProperty['DISPLAY_VALUE']) ? implode(' / ', $arProperty['DISPLAY_VALUE']) : $arProperty['DISPLAY_VALUE']);?>
                                                    <tr><td><?=$arProperty['NAME']?></td><td><?=$pValue?></td></tr>
                                                <?endif;
                                            endforeach;?>
                                            <?if (!empty($arOneOffer['DISPLAY_PROPERTIES'])):
                                                foreach ($arOneOffer['DISPLAY_PROPERTIES'] as $arOneProp):
                                                    $pValue = (is_array($arOneProp['DISPLAY_VALUE']) ? implode(' / ', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE']);?>
                                                    <tr><td><?=$arOneProp['NAME']?></td><td><?=$pValue?></td></tr>
                                                <?endforeach;
                                            endif;?>
                                        </table>
                                    </div>
                                </div>
                            <?endforeach;?>
                        <?else:?>
                            <a href="javascript:;" data-toggle="product-config-<?=$arItem['ID']?>" class="dropdown-link"><?=GetMessage("CT_BCS_PRODUCT_CONFIG")?></a>
                            <div id="product-config-<?=$arItem['ID']?>" class="dropdown-config dropdown-pane" data-dropdown>
                                <table>
                                    <?foreach ($arItem['DISPLAY_PROPERTIES'] as $arProperty):
                                        if (in_array($arProperty['ID'], $arItem['SHOWED_PROPERTIES']) && $arProperty['ACTIVE'] == 'Y'):
                                            $pValue = (is_array($arProperty['DISPLAY_VALUE']) ? implode(' / ', $arProperty['DISPLAY_VALUE']) : $arProperty['DISPLAY_VALUE']);?>
                                            <tr><td><?=$arProperty['NAME']?></td><td><?=$pValue?></td></tr>
                                        <?endif;
                                    endforeach;?>
                                </table>
                            </div>
                        <?endif;?>
                    <?}?>
                </div>
            </div>
            <div class="column large-6 xxlarge-4 relative column-action">
                <div class="price-block" id="<? echo $arItemIDs['PRICE']; ?>_block">
                    <?if ($isPriceComposite == "Y" && $arParams["REQUEST_LOAD"] == "N"):?>
                        <?$frame = $this->createFrame($arItemIDs['PRICE'] . "_block", false)->begin();?>
                    <?endif;?>
                        <?if (count($arItem['PRICES']) > 1 && !in_array('prodday', $itemType) && !in_array('action', $itemType)):?>
                            <div id="<? echo $arItemIDs['PRICE']; ?>">
                                <?foreach ($arItem['PRICES'] as $arPrice):
                                    $maxItemPriceValue = ($arPrice['VALUE'] > $maxPriceValue) ? $arPrice['VALUE'] : $maxPriceValue;
                                    $discountPrice = $maxItemPriceValue - $arPrice['DISCOUNT_VALUE'];?>
                                    <div class="price-block">
                                        <div class="product-info-caption"><?=$arItem['CATALOG_GROUP_NAME_' . $arPrice['PRICE_ID']]?></div>
                                        <div class="price"><?if (!empty($minPrice)):?><?=$arPrice['PRINT_DISCOUNT_VALUE']?><?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discountPrice > 0):?> <span class="old"><?=CCurrencyLang::CurrencyFormat($maxItemPriceValue, $arPrice['CURRENCY'])?></span><?endif;?><?endif;?></div>
                                        <?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discountPrice > 0):?>
                                            <div class="economy"><?=GetMessage("CT_BCS_TPL_MESS_ECONOMY")?>: <span><?=CCurrencyLang::CurrencyFormat($discountPrice, $arPrice['CURRENCY'])?></span></div>
                                        <?endif;?>
                                    </div>
                                <?endforeach;?>
                            </div>
                        <?else:?>
                            <div id="<? echo $arItemIDs['PRICE']; ?>">
                                <div class="price">
                                    <?if (!empty($minPrice)):?><?=$minPrice['PRINT_DISCOUNT_VALUE']?><?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discount > 0):?> <span class="old"><?=CCurrencyLang::CurrencyFormat($maxPriceValue, $arItem['MIN_PRICE']['CURRENCY'])?></span><?endif;?><?endif;?>
                                </div>
                                <?if ($discount > 0 && 'Y' == $arParams['SHOW_OLD_PRICE']):?>
                                    <div class="economy" id="<? echo $arItemIDs['ECONOMY_ID']; ?>"><?=GetMessage("CT_BCS_TPL_MESS_ECONOMY")?>: <span><?=CCurrencyLang::CurrencyFormat($discount, $arItem['MIN_PRICE']['CURRENCY'])?></span></div>
                                <?endif;?>
                            </div>
                        <?endif;?>
                    <?if ($isPriceComposite == "Y" && $arParams["REQUEST_LOAD"] == "N"):?>
                        <?$frame->beginStub();?>
                        <?$frame->end();?>
                    <?endif;?>
                </div>
                <?if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) {?>
                    <?if ($arItem['CAN_BUY']) {?>
                        <div class="row row-cart">
                            <?if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {?>
                                <div class="small-6 medium-4 large-6 column">
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
                            <div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="small-6 medium-8 large-6 columns">
                                <a id="<? echo $arItemIDs['BUY_LINK']; ?>" href="javascript:;" class="button tiny add2cart" data-preview="#<? echo $arItemIDs['PICT']; ?>" data-product-id="<?=$arItem['ID']?>"><span><?=$buttonText?></span></a>
                            </div>
                        </div>
                    <?}?>
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
                        'SHOW_FULL_PRICE' => true,
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
                            'PROP_TABLE' => $arItemIDs['PROP_TABLE'],
                            'QUANTITY_MAX' => $arItemIDs['QUANTITY_MAX'],
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
                    if (count($arItem['PRICES']) > 1 && !in_array('prodday', $itemType) && !in_array('action', $itemType)) {
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
                    <div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>">
                        <?if (!empty($arItem['OFFERS_PROP'])) {
                            $arSkuProps = array();?>
                            
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
                                            $templateRow .= '<div class="inline-block-container show-for-large" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
                            '<div class="product-info-caption inline-block-item">'.htmlspecialcharsex($arProp['NAME']).':&nbsp;</div>'.
                            '<div class="product-info-option text inline-block-item"><fieldset class="inline-block-container" id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                                            foreach ($arProp['VALUES'] as $arOneValue)
                                            {
                                                if (in_array($arOneValue['ID'], $arPropIds)) {
                                                    $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                                    $templateRow .= '<div class="inline-block-item" data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'"><input type="radio" name="#ITEM#_prop_name_'.$arProp['ID'].'" value="'.$arOneValue['ID'].'" id="#ITEM#_prop_'.$arProp['ID'].'_'.$arOneValue['ID'].'" class="show-for-sr" title="'.$arOneValue['NAME'].'"><label for="#ITEM#_prop_'.$arProp['ID'].'_'.$arOneValue['ID'].'" class="inline-block-item" title="'.$arOneValue['NAME'].'"><span>'.$arOneValue['NAME'].'</span></label></div>';
                                                }
                                            }
                                            $templateRow .= '</fieldset></div>'.
                            '<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'"></div>'.
                            '<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'"></div>'.
                            '</div>';
                                        }
                                        elseif ('PICT' == $arProp['SHOW_MODE'])
                                        {
                                            $templateRow .= '<div class="inline-block-container show-for-large" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
                            '<div class="product-info-caption inline-block-item">'.htmlspecialcharsex($arProp['NAME']).':&nbsp;</div>'.
                            '<div class="product-info-option color inline-block-item"><fieldset class="inline-block-container" id="#ITEM#_prop_'.$arProp['ID'].'_list">';
                                            foreach ($arProp['VALUES'] as $arOneValue)
                                            {
                                                if (in_array($arOneValue['ID'], $arPropIds)) {
                                                    $arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
                                                    $templateRow .= '<div class="inline-block-item" data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'"><input type="radio" name="#ITEM#_prop_name_'.$arProp['ID'].'" value="'.$arOneValue['ID'].'" id="#ITEM#_prop_'.$arProp['ID'].'_'.$arOneValue['ID'].'" class="show-for-sr" title="'.$arOneValue['NAME'].'"><label for="#ITEM#_prop_'.$arProp['ID'].'_'.$arOneValue['ID'].'" class="inline-block-item" title="'.$arOneValue['NAME'].'"><span style="background-image:url(\''.$arOneValue['PICT']['SRC'].'\');" title="'.$arOneValue['NAME'].'"></span></label></div>';
                                                }
                                            }
                                            $templateRow .= '</fieldset></div>'.
                            '<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'"></div>'.
                            '<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'"></div>'.
                            '</div>';
                                        }
                                        $strTemplate = $templateRow;
                                    }
                                    echo '', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '';
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
                                }
                                $discount = $arItem['JS_OFFERS'][$keyOffer]['PRICE']['VALUE'] - $arItem['JS_OFFERS'][$keyOffer]['PRICE']['DISCOUNT_VALUE'];
                                $arItem['JS_OFFERS'][$keyOffer]['PRICE']['ECONOMY'] = $discount;
                                $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['VALUE'] = $arItem['JS_OFFERS'][$keyOffer]['PRICE']['VALUE'];
                                $arItem['JS_OFFERS'][$keyOffer]['BASIS_PRICE']['ECONOMY'] = $discount;
                                if (count($arItem['OFFERS'][$keyOffer]['PRICES']) > 1) {
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
                                'SHOW_FULL_PRICE' => true,
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
                                    'PROP_TABLE' => $arItemIDs['PROP_TABLE'],
                                    'QUANTITY_MAX' => $arItemIDs['QUANTITY_MAX'],
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
                        <div class="row row-cart">
                            <?if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {?>
                                <div class="small-6 medium-4 large-6 column">
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
                            <div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="small-6 medium-8 large-6 columns" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
                                <?foreach ($arItem['OFFERS'] as $key => $arOffer):
                                    $strVisible = ($key == $arItem['OFFERS_SELECTED'] ? '' : 'none');?>
                                    <a id="<? echo $arItemIDs['BUY_LINK']; ?><?=$arOffer['ID']?>" class="button tiny add2cart" href="javascript:;" rel="nofollow" data-preview="#<? echo $arItemIDs['PICT']; ?>" style="display: <? echo $strVisible; ?>;" data-product-id="<?=$arOffer['ID']?>"><span><?=$buttonText?></span></a>
                                <?endforeach;?>
                            </div>
                        </div>
                        <?unset($canBuy);?>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
<?}?>
<? 
}?>
<?$nextPageUrl = '';
if (isset($arResult['NAV_RESULT']->NavPageCount) && ($arResult['NAV_RESULT']->NavPageCount > 1) && ($arResult['NAV_RESULT']->NavPageCount > $arResult['NAV_RESULT']->NavPageNomer)) {
    if ($arParams["TAB_TYPE"]) {
        $nextPageUrl = SITE_DIR . "nl_ajax/product_tab.php?TAB_TYPE=" . $arParams["TAB_TYPE"] . "&PAGEN_1=" . ($arResult['NAV_RESULT']->NavPageNomer + 1) . "&load=Y";
    } else {
        $nextPageUrl = $APPLICATION->GetCurPageParam("PAGEN_" . $arResult['NAV_RESULT']->NavNum . "=" . ($arResult['NAV_RESULT']->NavPageNomer + 1) . "&load=Y", array("PAGE_EL_COUNT", "PAGEN_" . $arResult['NAV_RESULT']->NavNum, "load"));
    }
}?>
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
            <a href="javascript:;" class="load-more text-center" onclick="getCatalogItems(this, '<?=(($arParams["TAB_TYPE"]) ? '.product-grid-' . $arParams["TAB_TYPE"] . ' .product-grid' : '.product-list.maxi')?>', false<?if ($arParams["TAB_TYPE"]):?>, true<?endif;?>)" data-ajax="<?=$nextPageUrl?>">
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