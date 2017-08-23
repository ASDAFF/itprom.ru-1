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
$buttonText = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));?>
<div id="liked" class="fancybox-block cart" data-ajax="<?=SITE_DIR?>nl_ajax/favorite.php">
    <div class="fancybox-block-caption fancybox-block-caption-liked"><?=GetMessage('CT_BCS_TPL_FAVORITES_TITLE')?></div>
    <div class="fancybox-block-wrap">
        <?if (!empty($arResult['ITEMS'])) {?>
            <?foreach ($arResult['ITEMS'] as $key => $arItem) {
                $strMainID = $this->GetEditAreaId('FAV_' . $arItem['ID']);

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

                    'PRICE' => $strMainID.'_price',
                    'PRICE_HOVER' => $strMainID.'_price_hover',
                    'DSC_PERC' => $strMainID.'_dsc_perc',
                    'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
                    'PROP_DIV' => $strMainID.'_sku_tree',
                    'PROP' => $strMainID.'_prop_',
                    'LIKED_COMPARE_ID' => $strMainID.'_add_liked_compare_',
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
                if (intval($arItem['PROPERTIES']['OLD_PRICE']['VALUE']) > 0 && 
                    $arItem['PROPERTIES']['OLD_PRICE']['ACTIVE'] == 'Y' &&
                    intval($arItem['PROPERTIES']['OLD_PRICE']['VALUE']) > $maxPriceValue) {
                    $maxPriceValue = intval($arItem['PROPERTIES']['OLD_PRICE']['VALUE']);
                }
                $discount = ($maxPriceValue > 0 && $minPriceValue > 0) ? ($maxPriceValue - $minPriceValue) : 0;
                $arItem['MIN_BASIS_PRICE']['VALUE'] = $maxPriceValue;
                $arItem['MIN_BASIS_PRICE']['ECONOMY'] = $discount;
                $pic = false;
                if ($arItem['PREVIEW_PICTURE']['ID'] > 0) {
                    $pic = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]['ID'], array('width' => 170, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
                }
                if ($pic === false) {
                    $pic['src'] = SITE_TEMPLATE_PATH . "/images/no_photo.png";
                }?>
                <div class="callout cart-product-item inline-block-container" data-product-id="<?=$arItem['ID']?>" id="<? echo $strMainID; ?>" data-closable>
                    <div class="inline-block-item vertical-middle cart-product-item-preview">
                        <img src="<?=$pic['src']?>" alt="<? echo $productTitle; ?>" id="<? echo $arItemIDs['PICT']; ?>">
                    </div>
                    <div class="inline-block-item vertical-middle cart-product-item-info">
                        <div class="inline-block-container">
                            <div class="inline-block-item vertical-middle cart-product-item-desc">
                                <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="cart-product-item-name"><? echo $productTitle; ?></a>
                                <div>
                                    <?foreach ($arItem['DISPLAY_PROPERTIES'] as $pCode => $prop):?>
                                        <?=$prop['NAME']?>: <?=$prop['DISPLAY_VALUE']?><br />
                                    <?endforeach;?>
                                    <?if ($arItem['IS_OFFER'] == "Y"):?>
                                        <?foreach ($arResult['SKU_PROPS'] as $pCode => $propInfo):
                                            if ($arItem['TREE']['PROP_' . $propInfo['ID']]):?>
                                                <?=$propInfo['NAME']?>: <?=$propInfo['VALUES'][$arItem['TREE']['PROP_' . $propInfo['ID']]]['NAME']?><br />
                                            <?endif;?>
                                        <?endforeach;?>
                                    <?endif;?>
                                </div>
                            </div>
                            <div class="inline-block-item vertical-middle cart-product-item-price">
                                <div class="inline-block-container">
                                    <div class="inline-block-item vertical-middle small-12 medium-6 large-4">
                                        <div class="product-price">
                                            <div class="product-info-caption"><?=GetMessage('CT_BCS_TPL_FAVORITES_PRICE')?></div>
                                            <?if (!empty($minPrice)):?>
                                            <div class="main"><?=$minPrice['PRINT_DISCOUNT_VALUE']?></div>
                                        <?endif;?>
                                        <?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discount > 0):?>
                                            <div class="old"><?=CCurrencyLang::CurrencyFormat($maxPriceValue, $arItem['MIN_PRICE']['CURRENCY'])?></div>
                                        <?endif;?>
                                        </div>
                                    </div>
                                    <div class="inline-block-item vertical-middle small-12 medium-6 large-8 column-for-add2cart" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>">
                                        <a href="javascript:;" id="<? echo $arItemIDs['BUY_LINK']; ?>" class="button add2cart small" data-product-id="<?=$arItem['ID']?>"<?if (!$arItem['CAN_BUY']):?> disabled="disabled"<?endif;?>><span><?=$buttonText?></span></a>
                                        <input class="input-group-field" type="hidden" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="close-button remove2liked" data-ajax="<?=SITE_DIR?>nl_ajax/favorite.php" data-product-id="<?=$arItem['ID']?>" type="button" data-close>
                        <span aria-hidden="true">+</span>
                    </button>
                    <?$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
                    if (!$emptyProductProperties) {?>
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
                    <?} elseif (!empty($arItem['DISPLAY_PROPERTIES'])) {?>
                        <div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
                            <?foreach ($arItem['DISPLAY_PROPERTIES'] as $pCode => $prop):?>
                                <input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $prop['ID']; ?>]" value="<? echo htmlspecialcharsbx($prop['VALUE']); ?>">
                            <?endforeach;?>
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
                            'ADD_PROPS' => 'Y',
                            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                            'EMPTY_PROPS' => $emptyProductProperties,
                            'ADD_URL_TEMPLATE' => SITE_DIR . 'nl_ajax/favorite.php?'.$arParams["ACTION_VARIABLE"]."=ADD2BASKET&".$arParams["PRODUCT_ID_VARIABLE"]."=#ID#",
                            'BUY_URL_TEMPLATE' => SITE_DIR . 'nl_ajax/favorite.php?'.$arParams["ACTION_VARIABLE"]."=BUY&".$arParams["PRODUCT_ID_VARIABLE"]."=#ID#"
                        ),
                        'VISUAL' => array(
                            'ID' => $arItemIDs['ID'],
                            'PICT_ID' => $arItemIDs['PICT'],
                            'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                            'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                            'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                            'PRICE_ID' => $arItemIDs['PRICE'],
                            'PRICE_HOVER_ID' => $arItemIDs['PRICE_HOVER'],
                            'BUY_ID' => $arItemIDs['BUY_LINK'],
                            'LIKED_COMPARE_ID' => $arItemIDs['LIKED_COMPARE_ID'],
                            'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
                            'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
                            'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
                            'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK'],
                            'ECONOMY_HTML' => $arItemHtml['ECONOMY_HTML']
                        ),
                        'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
                    );
                    unset($emptyProductProperties);?>
                    <script type="text/javascript">
                        var <? echo $strObName; ?> = new JCCatalogSectionFavorite(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
                    </script>
                </div>
            <?}?>
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
            </script>
        <?}?>
        <script type="text/javascript">
            var NL_ADD_TO_BASKET = '<?=GetMessageJS('ADD_TO_BASKET')?>';
            var NL_ADD_TO_BASKET_URL = '<?=$arParams['BASKET_URL']?>';
            var NL_ADD_TO_BASKET_BUTTON = '<?=$buttonText?>';
        </script>
    </div>
</div>