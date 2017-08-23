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
?>
<a href="<?=$arParams["COMPARE_URL"]?>" id="bx_compare_count_mini" class="inline-block-container">
    <?$frame = $this->createFrame('bx_compare_count_mini', false)->begin();
        $countCompare = count($arResult);
        $countCompareCaptionMini = $countCompare . ' ' . NLApparelshopUtils::nl_inclination($countCompare, GetMessage('NL_PRODUCT_1'), GetMessage('NL_PRODUCT_2'), GetMessage('NL_PRODUCT_10'));
        $countCompareCaption = $countCompareCaptionMini . ' ' . GetMessage('COMPARE_CAPTION');?>
        <span class="inline-block-item relative">
            <svg class="icon">
                <use xlink:href="#svg-icon-compare"></use>
            </svg>
            <span class="header-block-info-counter inline-block-item" title="<?=$countCompareCaptionMini?>"><?if ($countCompare > 0):?><?=$countCompare?><?endif;?></span>
        </span>
        <span class="inline-block-item hide-for-small-only hide-for-medium-only hide-for-large-only">
            <span class="header-block-info-link"><?=getMessage('COMPARE_TITLE')?></span>
            <span class="header-block-info-desc" title="<?=$countCompareCaption?>"><?=$countCompareCaption?></span>
        </span>
    <?$frame->beginStub();
        $countCompare = 0;
        $countCompareCaptionMini = $countCompare . ' ' . NLApparelshopUtils::nl_inclination($countCompare, GetMessage('NL_PRODUCT_1'), GetMessage('NL_PRODUCT_2'), GetMessage('NL_PRODUCT_10'));
        $countCompareCaption = $countCompareCaptionMini . ' ' . GetMessage('COMPARE_CAPTION');?>
        <span class="inline-block-item relative">
            <svg class="icon">
                <use xlink:href="#svg-icon-compare"></use>
            </svg>
            <span class="header-block-info-counter inline-block-item" title="<?=$countCompareCaptionMini?>"><?if ($countCompare > 0):?><?=$countCompare?><?endif;?></span>
        </span>
        <span class="inline-block-item hide-for-small-only hide-for-medium-only hide-for-large-only">
            <span class="header-block-info-link"><?=getMessage('COMPARE_TITLE')?></span>
            <span class="header-block-info-desc" title="<?=$countCompareCaption?>"><?=$countCompare?><?=$countCompareCaption?></span>
        </span>
    <?$frame->end();?>
    <script>
        var NL_ADD_2_COMPARE = '<?=getMessage('COMPARE_REDIRECT')?>';
        var NL_ADD_2_COMPARE_URL = '<?=$arParams["COMPARE_URL"]?>';
        var NL_ADD_2_COMPARE_CAPTION = '<?=getMessage('COMPARE_CAPTION')?>';
    </script>
</a>
        