<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$cartId = "bx_cart_block";
$arParams['cartId'] = $cartId;?>
<script>
	var <?=$cartId?> = new BitrixSmallCart;
</script>
<a href="<?=$arParams["PATH_TO_BASKET"]?>" class="inline-block-container" id="bx_cart_block">
    <?$frame = $this->createFrame('bx_cart_block', false)->begin();?>
        <svg class="icon vertical-middle">
            <use xlink:href="#svg-icon-cart"></use>
        </svg>
        <span class="inline-block-item vertical-middle">
            <span class="header-block-info-link"><?=GetMessage('CART_TITLE')?></span>
            <?if (intval($arResult["NUM_PRODUCTS"]) > 0):?>
                <span class="header-block-info-desc price-block" title="<?=GetMessage('YOUR_CART', array('#NUM#' => intval($arResult["NUM_PRODUCTS"]), '#PROD_TITLE#' => $arResult['PRODUCT(S)'], '#TOTAL#' => strip_tags($arResult['TOTAL_PRICE'])))?>"><?=GetMessage('YOUR_CART', array('#NUM#' => intval($arResult["NUM_PRODUCTS"]), '#PROD_TITLE#' => $arResult['PRODUCT(S)'], '#TOTAL#' => $arResult['TOTAL_PRICE']))?></span>
            <?else:?>
                <span class="header-block-info-desc price-block" title="<?=GetMessage('YOUR_CART_EMPTY', array('#NUM#' => 0))?>"><?=GetMessage('YOUR_CART_EMPTY', array('#NUM#' => 0))?></span>
            <?endif;?>
        </span>
        <div class="basket_products" style="display:none;">
            <?if (count($arResult['CATEGORIES']['READY']) > 0):?>
                <?foreach ($arResult['CATEGORIES']['READY'] as $position):?>
                    <div data-product-id="<?=$position['PRODUCT_ID']?>"></div>
                <?endforeach;?>
            <?endif;?>
        </div>
    <?$frame->beginStub();?>
        <svg class="icon vertical-middle">
            <use xlink:href="#svg-icon-cart"></use>
        </svg>
        <span class="inline-block-item vertical-middle">
            <span class="header-block-info-link"><?=GetMessage('CART_TITLE')?></span>
            <span class="header-block-info-desc price-block" title="">&nbsp;</span>
        </span>
    <?$frame->end();?>
</a>
<script>
	<?=$cartId?>.siteId       = '<?=SITE_ID?>';
	<?=$cartId?>.cartId       = '<?=$cartId?>';
	<?=$cartId?>.ajaxPath     = '<?=$componentPath?>/ajax.php';
	<?=$cartId?>.templateName = '<?=$templateName?>';
	<?=$cartId?>.arParams     =  <?=CUtil::PhpToJSObject ($arParams)?>; // TODO \Bitrix\Main\Web\Json::encode
	<?=$cartId?>.activate();
</script>