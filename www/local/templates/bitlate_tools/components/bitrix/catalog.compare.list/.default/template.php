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
<a href="<?=$arParams["COMPARE_URL"]?>" id="bx_compare_count" class="button transparent add2compare inline-block-item">
    <?$frame = $this->createFrame('bx_compare_count', false)->begin();
        $countCompare = count($arResult);?>
        <svg class="icon">
            <use xlink:href="#svg-icon-compare"></use>
        </svg>
        <?=getMessage('COMPARE_TITLE')?><span><?if ($countCompare > 0):?> (<?=$countCompare?>)<?endif;?></span>
        <div class="compare_products" style="display:none;">
            <?if ($countCompare > 0):?>
                <?foreach($arResult as $arElement):?>
                    <div data-product-id="<?=$arElement['PARENT_ID']?>"></div>
                <?endforeach;?>
            <?endif;?>
        </div>
    <?$frame->beginStub();?>
        <svg class="icon">
            <use xlink:href="#svg-icon-compare"></use>
        </svg>
        <?=getMessage('COMPARE_TITLE')?>
    <?$frame->end();?>
    <script>
        var NL_ADD_2_COMPARE = '<?=getMessage('COMPARE_REDIRECT')?>';
        var NL_ADD_2_COMPARE_URL = '<?=$arParams["COMPARE_URL"]?>';
    </script>
</a>
        