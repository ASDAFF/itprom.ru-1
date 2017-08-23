<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$cartId = "bx_cart_block_mini";
$arParams['cartId'] = $cartId;?>
<script>
	var <?=$cartId?> = new BitrixSmallCart;
</script>
<a href="<?=$arParams["PATH_TO_BASKET"]?>" class="inline-block-container" id="bx_cart_block_mini">
    <?$frame = $this->createFrame('bx_cart_block_mini', false)->begin();
        $countCart = intval($arResult["NUM_PRODUCTS"]);
        $countCartCaptionMini = $countCart . ' ' . $arResult['PRODUCT(S)'];
        $countCartCaption = ($countCart > 0) ? GetMessage('YOUR_CART', array('#NUM#' => $countCart, '#PROD_TITLE#' => $arResult['PRODUCT(S)'], '#TOTAL#' => $arResult['TOTAL_PRICE'])) : GetMessage('YOUR_CART_EMPTY', array('#NUM#' => 0));?>
        <span class="inline-block-item relative">
            <svg class="icon">
                <use xlink:href="#svg-icon-cart"></use>
            </svg>
            <span class="header-block-info-counter inline-block-item" title="<?=$countCartCaptionMini?>"><?if ($countCart > 0):?><?=$countCart?><?endif;?></span>
        </span>
        <span class="inline-block-item hide-for-small-only hide-for-medium-only hide-for-large-only">
            <span class="header-block-info-link"><?=GetMessage('CART_TITLE')?></span>
            <span class="header-block-info-desc price-block" title="<?=strip_tags($countCartCaption)?>"><?=$countCartCaption?></span>
        </span>
    <?$frame->beginStub();
        $countCart = 0;
        $countCartCaptionMini = $countCart . ' ' . $arResult['PRODUCT(S)'];
        $countCartCaption = GetMessage('YOUR_CART_EMPTY', array('#NUM#' => 0));?>
        <span class="inline-block-item relative">
            <svg class="icon">
                <use xlink:href="#svg-icon-cart"></use>
            </svg>
            <span class="header-block-info-counter inline-block-item" title="<?=$countCartCaptionMini?>"></span>
        </span>
        <span class="inline-block-item hide-for-small-only hide-for-medium-only hide-for-large-only">
            <span class="header-block-info-link"><?=GetMessage('CART_TITLE')?></span>
            <span class="header-block-info-desc price-block" title="<?=$countCartCaption?>"><?=$countCartCaption?></span>
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