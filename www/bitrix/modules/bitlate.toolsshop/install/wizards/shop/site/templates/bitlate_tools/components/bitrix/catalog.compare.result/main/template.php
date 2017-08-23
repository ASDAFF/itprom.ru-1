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
CModule::IncludeModule('bitlate.toolsshop');
$deleteIds = '';
$countCompare = count($arResult["ITEMS"]);
$countCompareCaptionMini = $countCompare . ' ' . NLApparelshopUtils::nl_inclination($countCompare, GetMessage('NL_PRODUCT_1'), GetMessage('NL_PRODUCT_2'), GetMessage('NL_PRODUCT_10'));
$countCompareCaption = $countCompareCaptionMini . ' ' . GetMessage('COMPARE_CAPTION');
foreach ($arResult["ITEMS"] as $arElement) {
    $deleteIds .= "&ID[]={$arElement['ID']}";
}?>
<script>
    $('.empty-compare-caption').remove();
</script>
<div class="compare-caption row">
    <h1 class="columns large-4"><?=GetMessage("CATALOG_COMPARE_TITLE")?></h1>
    <div class="columns large-8 xlarge-6 xxlarge-5">
        <a href="<?=$arParams['SEF_FOLDER']?>" class="small-12 large-4 float-right button small"><?=GetMessage("CATALOG_ADD_TO_COMPARE_LIST")?></a>
        <a href="javascript:;" onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arResult['COMPARE_URL_TEMPLATE'].'=DELETE_FROM_COMPARE_RESULT' . $deleteIds)?>');" class="small-12 large-4 float-right button small secondary"><?=GetMessage("CATALOG_DELETE_FROM_COMPARE_RESULT")?></a>
    </div>
</div>
<div class="product-grid relative">
    <div class="compare-table fix-table">
        <?$empty = true;
        if (!empty($arResult["SHOW_PROPERTIES"])) {
            foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty) {
                $showRow = true;
                if ($arResult['DIFFERENT']) {
                    $arCompare = array();
                    foreach($arResult["ITEMS"] as &$arElement) {
                        $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
                        if (is_array($arPropertyValue)) {
                            sort($arPropertyValue);
                            $arPropertyValue = implode(" / ", $arPropertyValue);
                        }
                        $arCompare[] = $arPropertyValue;
                    }
                    unset($arElement);
                    $showRow = (count(array_unique($arCompare)) > 1);
                }
                if ($showRow) {?>
                    <div class="compare-table-td large-up-3 xlarge-up-4 xxlarge-up-5 same-td">
                        <div class="column"><?=$arProperty["NAME"]?></div>
                        <div class="column hide-for-large">&nbsp;</div>
                    </div>
                <?}
            }
        }?>
        <?if (!empty($arResult["SHOW_OFFER_PROPERTIES"])) {
            foreach($arResult["SHOW_OFFER_PROPERTIES"] as $code=>$arProperty) {
                $showRow = true;
                if ($arResult['DIFFERENT']) {
                    $arCompare = array();
                    foreach($arResult["ITEMS"] as &$arElement) {
                        $arPropertyValue = $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["VALUE"];
                        if(is_array($arPropertyValue)) {
                            sort($arPropertyValue);
                            $arPropertyValue = implode(" / ", $arPropertyValue);
                        }
                        $arCompare[] = $arPropertyValue;
                    }
                    unset($arElement);
                    $showRow = (count(array_unique($arCompare)) > 1);
                }
                if ($showRow) {?>
                    <div class="compare-table-td large-up-3 xlarge-up-4 xxlarge-up-5 same-td">
                        <div class="column"><?=$arProperty["NAME"]?></div>
                        <div class="column hide-for-large">&nbsp;</div>
                    </div>
                <?}
            }
        }?>
    </div>
    <div class="owl-carousel product-compare-carousel float-right">
        <?foreach($arResult["ITEMS"] as $key => $arCurElement):
            $pic = false;
            if ($arCurElement['PREVIEW_PICTURE']['ID'] > 0) {
                $pic = CFile::resizeImageGet($arCurElement['PREVIEW_PICTURE']['ID'], array('width' => 150, 'height' => 170), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
            } elseif ($arCurElement['DETAIL_PICTURE']['ID'] > 0) {
                $pic = CFile::resizeImageGet($arCurElement['DETAIL_PICTURE']['ID'], array('width' => 150, 'height' => 170), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
            }
            if ($pic === false) {
                $pic['src'] = SITE_TEMPLATE_PATH . '/images/no_photo.png';
            }
            $minPrice = false;
            $minPriceValue = 0;
            $maxPriceValue = 0;
            if (isset($arCurElement['MIN_PRICE']) || isset($arCurElement['RATIO_PRICE'])) {
                $minPrice = (isset($arCurElement['RATIO_PRICE']) ? $arCurElement['RATIO_PRICE'] : $arCurElement['MIN_PRICE']);
                $minPriceValue = $minPrice["DISCOUNT_VALUE"];
                $maxPriceValue = $minPrice["VALUE"];
            }
            if (intval($arCurElement['PROPERTIES']['OLD_PRICE']['VALUE']) > 0 && 
                $arCurElement['PROPERTIES']['OLD_PRICE']['ACTIVE'] == 'Y' &&
                intval($arCurElement['PROPERTIES']['OLD_PRICE']['VALUE']) > $maxPriceValue) {
                $maxPriceValue = intval($arCurElement['PROPERTIES']['OLD_PRICE']['VALUE']);
            }
            $discount = ($maxPriceValue > 0 && $minPriceValue > 0) ? ($maxPriceValue - $minPriceValue) : 0;?>
            <div class="item column text-center">
                <div class="item-wrap">
                    <button type="button" class="product-compare-change remove close-button">
                        <span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arCurElement['~DELETE_URL'])?>');" aria-hidden="true">+</span>
                    </button>
                    <div class="img-wrap">
                        <img src="<?=$pic['src']?>" class="thumbnail" alt="<?=$arCurElement['NAME']?>" id="pic_<?=$arCurElement['ID']?>">
                    </div>
                    <div class="name">
                        <a href="<?=$arCurElement['DETAIL_PAGE_URL']?>" class="name"><span><?=$arCurElement['NAME']?></span></a>
                    </div>
                    <?if ($minPrice !== false):?>
                        <div class="price"><?=$arCurElement['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?><?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $discount > 0):?> <span class="old"><?=CCurrencyLang::CurrencyFormat($maxPriceValue, $arCurElement['MIN_PRICE']['CURRENCY'])?></span><?endif;?></div>
                    <?endif;?>
                    <?if ($arCurElement["CAN_BUY"]):?>
                        <a href="javascript:;" onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arCurElement["ADD_URL"])?>', '<?=CUtil::JSEscape($arResult["COMPARE_URL_TEMPLATE"])?>', '<?=$arCurElement['ID']?>');" class="button small add2cart" data-preview="#pic_<?=$arCurElement['ID']?>" data-product-id="<?=$arCurElement['ID']?>"><span><?=GetMessage("CATALOG_COMPARE_BUY"); ?></span></a>
                    <?endif;?>
                    <a href="javascript:;" class="button transparent add2liked" data-ajax="<?=SITE_DIR?>nl_ajax/favorite.php" data-product-id="<?=$arCurElement['ID']?>">
                        <svg class="icon">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-liked"></use>
                        </svg>
                        <span><?=GetMessage('CATALOG_COMPARE_ADD_2_LIKED')?></span>
                    </a>
                </div>
                <?$i = 0;
                $empty = true;
                if (!empty($arResult["SHOW_PROPERTIES"])) {
                    foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty) {
                        $showRow = true;
                        if ($arResult['DIFFERENT']) {
                            $arCompare = array();
                            foreach($arResult["ITEMS"] as &$arElement) {
                                $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
                                if (is_array($arPropertyValue)) {
                                    sort($arPropertyValue);
                                    $arPropertyValue = implode(" / ", $arPropertyValue);
                                }
                                $arCompare[] = $arPropertyValue;
                            }
                            unset($arElement);
                            $showRow = (count(array_unique($arCompare)) > 1);
                        }
                        if ($showRow) {?>
                            <?if ($i == 0):?>
                                <div class="compare-table text-left">
                            <?endif;?>
                            <div class="compare-table-td same-td">
                                <div class="column transparent hide-for-large">&nbsp;</div>
                                <div class="column"><?=(is_array($arCurElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arCurElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arCurElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>&nbsp;</div>
                            </div>
                            <?$i++;
                        }
                    }
                }?>
                <?if (!empty($arResult["SHOW_OFFER_PROPERTIES"])) {
                    foreach($arResult["SHOW_OFFER_PROPERTIES"] as $code=>$arProperty) {
                        $showRow = true;
                        if ($arResult['DIFFERENT']) {
                            $arCompare = array();
                            foreach($arResult["ITEMS"] as &$arElement) {
                                $arPropertyValue = $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["VALUE"];
                                if(is_array($arPropertyValue)) {
                                    sort($arPropertyValue);
                                    $arPropertyValue = implode(" / ", $arPropertyValue);
                                }
                                $arCompare[] = $arPropertyValue;
                            }
                            unset($arElement);
                            $showRow = (count(array_unique($arCompare)) > 1);
                        }
                        if ($showRow) {?>
                            <?if ($i == 0):?>
                                <div class="compare-table text-left">
                            <?endif;?>
                            <div class="compare-table-td same-td">
                                <div class="column transparent hide-for-large">&nbsp;</div>
                                <div class="column"><?=(is_array($arCurElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arCurElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arCurElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>&nbsp;</div>
                            </div>
                            <?$i++;
                        }
                    }
                }?>
                <?if ($i > 0):?>
                    </div>
                <?endif;?>
            </div>
        <?endforeach;?>
    </div>
    <div class="item column item-buttons">
        <a href="javascript:;" onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arResult['COMPARE_URL_TEMPLATE'].'&DIFFERENT=N')?>');" class="small-12 button secondary<?if ($arResult['DIFFERENT']):?> hollow<?endif;?>"><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?></a>
        <a href="javascript:;" onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arResult['COMPARE_URL_TEMPLATE'].'&DIFFERENT=Y')?>');" class="small-12 button secondary<?if (!$arResult['DIFFERENT']):?> hollow<?endif;?>"><?=GetMessage("CATALOG_ONLY_DIFFERENT")?></a>
    </div>
</div>
<script type="text/javascript">
    <?if ($arParams["REQUEST_LOAD"] != "Y"):?>
        var CatalogCompareObj = new BX.Iblock.Catalog.CompareClass("bx_catalog_compare_block");
    <?endif;?>
    <?if ($countCompare > 0):?>
        $('#bx_compare_count span').html(' (<?=$countCompare?>)');
        $('#bx_compare_count_mini .header-block-info-counter').html('<?=$countCompare?>');
        $('#bx_compare_count_mini .header-block-info-counter').attr('title', '<?=$countCompareCaptionMini?>');
    <?else:?>
        $('#bx_compare_count span').html('');
        $('#bx_compare_count_mini .header-block-info-counter').html('');
        $('#bx_compare_count_mini .header-block-info-counter').attr('title', '');
    <?endif;?>
    $('#bx_compare_count_mini .header-block-info-desc').html('<?=$countCompareCaption?>');
    $('#bx_compare_count_mini .header-block-info-desc').attr('title', '<?=$countCompareCaption?>');
</script>
