<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$this->IncludeLangFile('template.php');
$cartId = $arParams['cartId'];
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