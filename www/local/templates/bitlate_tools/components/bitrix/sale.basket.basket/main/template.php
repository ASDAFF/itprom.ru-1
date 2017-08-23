<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var CBitrixBasketComponent $component */
use Bitrix\Sale\DiscountCouponsManager;
CModule::IncludeModule('bitlate.toolsshop');
$curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
	"delete" => $curPage."delete&id=#ID#&load=Y",
	"delay" => $curPage."delay&id=#ID#",
	"add" => $curPage."add&id=#ID#",
);
unset($curPage);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
);
?>
<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");
$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader) {
    $arHeaders[] = $arHeader["id"];
}
$offersParams = array();
$offersCartProps = COption::GetOptionString("bitlate.toolsshop", 'NL_CATALOG_CART_OFFERS_PROPERTY_CODE', false, SITE_ID);
$offersCartProps = explode("|", $offersCartProps);?>
<?if ($arParams['REQUEST_LOAD'] != "Y"):?>
    <script type="text/javascript">
        var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>;
        var NL_PRODUCT_1 = '<?=GetMessage("SALE_GOODS_1")?> <?=GetMessage("SALE_ON")?>';
        var NL_PRODUCT_2 = '<?=GetMessage("SALE_GOODS_2")?> <?=GetMessage("SALE_ON")?>';
        var NL_PRODUCT_10 = '<?=GetMessage("SALE_GOODS_10")?> <?=GetMessage("SALE_ON")?>';
    </script>
    <nav class="show-for-large">
        <ul class="breadcrumbs cart">
            <li class="active"><div class="float-right"><span>1</span> <?=GetMessage("SALE_BASKET")?></div></li>
            <li><div class="float-right"><span>2</span> <?=GetMessage("SALE_CONTACTS_AND_DELIVERY")?></div></li>
            <li><div class="float-right"><span>3</span> <?=GetMessage("SALE_PAY")?></div></li>
        </ul>
    </nav>
    <article class="inner-container cart-container">
<?endif;?>
        <?if ($normalCount > 0):?>
            <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form" data-ajax="<?=$APPLICATION->GetCurPage()?>?load=Y">
                <div id="basket_items">
                    <div class="text-center">
                        <div class="cart-caption"><?=GetMessage('SALE_BASKET'); ?></div>
                        <div class="cart-caption-desc product-price"><?=$normalCount?> <?=NLApparelshopUtils::nl_inclination($normalCount, GetMessage("SALE_GOODS_1"), GetMessage("SALE_GOODS_2"), GetMessage("SALE_GOODS_10"))?> <?=GetMessage("SALE_ON")?> <?=$arResult["allSum_FORMATED"]?></div>
                    </div>
                    <?foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
                        if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
                            $pic = false;
                            if ($arItem["PREVIEW_PICTURE"] > 0) {
                                $pic = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width' => 170, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
                            } elseif ($arItem["DETAIL_PICTURE"] > 0) {
                                $pic = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array('width' => 170, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
                            }
                            if ($pic === false) {
                                $pic['src'] = SITE_TEMPLATE_PATH . "/images/no_photo.png";
                            }
                            $useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
                            $useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
                            if (!isset($arItem["MEASURE_RATIO"])) {
                                $arItem["MEASURE_RATIO"] = 1;
                            }
                            $oldPrice = $arItem["FULL_PRICE"];
                            if ($arItem["OLD_PRICE"] > 0 && $arItem["OLD_PRICE"] > $oldPrice) {
                                $oldPrice = $arItem["OLD_PRICE"];
                            }
                            if ($oldPrice <= $arItem["PRICE"]) {
                                $oldPrice = 0;
                            }?>
                            <div class="callout cart-product-item inline-block-container" data-product-id="<?=$arItem["ID"]?>" id="<?=$arItem["ID"]?>">
                                <div class="inline-block-item vertical-middle cart-product-item-preview">
                                    <img src="<?=$pic['src']?>" alt="">
                                </div>
                                <div class="inline-block-item vertical-middle cart-product-item-info">
                                    <div class="inline-block-container">
                                        <div class="inline-block-item vertical-middle cart-product-item-desc">
                                            <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="cart-product-item-name"><?endif;?>
                                                <?=$arItem["NAME"]?>
                                            <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                            <?if (count($arItem["PROPS"])):?>
                                                <div>
                                                    <?foreach ($arItem["PROPS"] as $val):
                                                        if (!in_array($val['CODE'], $offersCartProps)) continue;
                                                        $offersParams[] = $val['CODE'];
                                                        echo $val["NAME"].":&nbsp;".$val["VALUE"]."<br/>";
                                                    endforeach;?>
                                                </div>
                                            <?endif;?>
                                            <a href="#" class="button transparent add2liked" data-ajax="<?=SITE_DIR?>nl_ajax/favorite.php" data-product-id="<?=$arItem['PRODUCT_ID']?>">
                                                <svg class="icon">
                                                    <use xlink:href="#svg-icon-liked"></use>
                                                </svg>
                                                <span><?=GetMessage("SALE_FAVORITE")?></span>
                                            </a>
                                        </div>
                                        <div class="inline-block-item vertical-middle cart-product-item-price medium-up-2 large-up-3">
                                            <div class="column">
                                                <div class="product-count">
                                                    <div class="product-info-caption"><?=GetMessage("SALE_QUANTITY")?></div>
                                                    <div class="input-group">
                                                        <div class="input-group-button">
                                                            <button class="button decrement" type="button" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);">-</button>
                                                        </div>
                                                        <input class="input-group-field" type="number" name="QUANTITY_INPUT_<?=$arItem["ID"]?>" min="1" value="<?=$arItem["QUANTITY"]?>" id="QUANTITY_INPUT_<?=$arItem["ID"]?>">
                                                        <div class="input-group-button">
                                                            <button class="button increment" type="button" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);">+</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
                                                </div>
                                            </div>
                                            <div class="column float-right">
                                                <div class="product-price">
                                                    <div class="product-info-caption"><?=GetMessage("SALE_TOTAL")?></div>
                                                    <div class="main" id="total_price_<?=$arItem["ID"]?>"><?=$arItem["SUM"]?></div>
                                                </div>
                                            </div>
                                            <div class="column show-for-large">
                                                <div class="product-price">
                                                    <div class="product-info-caption"><?=GetMessage("SALE_PRICE_1")?></div>
                                                    <div class="main" id="current_price_<?=$arItem["ID"]?>"><?=$arItem["PRICE_FORMATED"]?></div>
                                                    <div class="old" id="old_price_<?=$arItem["ID"]?>" data-old-price="<?=$oldPrice?>"><?if ($oldPrice > 0):?><?=CCurrencyLang::CurrencyFormat($oldPrice, $arItem["CURRENCY"])?><?endif;?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="close-button" type="button">
                                    <span aria-hidden="true" onclick="cartAjaxAction('<?=SITE_DIR?>nl_ajax/cart.php', 'delete', '<?=$arItem["ID"]?>')">+</span>
                                </button>
                            </div>
                        <?endif;?>
                    <?endforeach;?>
                    <div class="cart-product-footer row large-up-2">
                        <div class="column" id="coupons_block">
                            <?$couponClass = '';
                            $couponValue = '';
                            if (!empty($arResult['COUPON_LIST'])) {
                                foreach ($arResult['COUPON_LIST'] as $oneCoupon) {
                                    if ($oneCoupon['STATUS'] == DiscountCouponsManager::STATUS_APPLYED) {
                                        $couponValue = htmlspecialcharsbx($oneCoupon['COUPON']);
                                        $couponClass = 'good';
                                        break;
                                    }
                                }
                            }?>
                            <div class="inline-block-container cart-product-footer-promo bx_ordercart_coupon <?=$couponClass?>">
                                <input type="text" id="coupon" name="COUPON" value="<?=$couponValue?>" data-coupon="<?=$couponValue?>" placeholder="<?=GetMessage('SALE_COUPON_PLACEHOLDER'); ?>" class="inline-block-item">
                                <button type="submit" class="button small secondary inline-block-item" onclick="enterCoupon(); return false;"><?=GetMessage('SALE_COUPON_APPLY_BUTTON'); ?></button>
                            </div>
                        </div>
                        <div class="column cart-product-footer-amount price"><?=GetMessage("SALE_TOTAL")?> <span class="footer-amount-price"><?=$arResult["allSum_FORMATED"]?></span> <?=GetMessage("SALE_TOTAL_NOTE")?></div>
                    </div>
                    <div class="cart-footer">
                        <a href="javascript:;" onclick="checkOut();" class="button"><?=GetMessage("SALE_ORDER")?></a>
                        <a href="#buy-to-click" class="button secondary go2buy"><?=GetMessage("SALE_ORDER_1_CLICK")?></a>
                        <input type="hidden" name="cart" value="<?=base64_encode(json_encode('Y'))?>" />
                        <input type="hidden" name="props" value="<?=base64_encode(json_encode(array_unique($offersParams)))?>" />
                        <div class="clearfix"></div>
                    </div>
                    <input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
                    <input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
                    <input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
                    <input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
                    <input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
                    <input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
                    <input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
                    <input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
                </div>
                <input type="hidden" name="BasketOrder" value="BasketOrder" />
                <!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
            </form>
        <?endif;?>
        <div id="empty_basket"<?if ($normalCount > 0):?>style="display:none;"<?endif;?>>
            <div class="text-center">
                <div class="cart-caption"><?=GetMessage("SALE_BASKET")?></div>
            </div>
            <div class="cart-content cart-empty text-center inline-block-container">
                <div class="cart-empty-icon inline-block-item vertical-middle">
                    <svg class="icon">
                        <use xlink:href="#svg-icon-cart"></use>
                    </svg>
                </div>
                <div class="inline-block-item vertical-middle"><?=GetMessage("SALE_NO_ITEMS")?></div>
            </div>
        </div>
<?if ($arParams['REQUEST_LOAD'] != "Y"):?>
    </article>
<?endif;?>