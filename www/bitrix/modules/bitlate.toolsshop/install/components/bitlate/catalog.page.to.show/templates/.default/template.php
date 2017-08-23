<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?if (!empty($arResult['VARIANTS']) && is_array($arResult['VARIANTS'])):?>
    <div class="catalog-show-count">
        <span><?=GetMessage('PAGE_TO_TITLE')?>:</span>
        <?foreach ($arResult['VARIANTS'] as $arCount):?>
            <a href="<?=$APPLICATION->GetCurPageParam("PAGE_EL_COUNT=".$arCount['VALUE'], array("PAGE_EL_COUNT", "load", "PAGEN_1", "PAGEN_2", "PAGEN_3", "PAGEN_4", "PAGEN_5"))?>" data-ajax="<?=$APPLICATION->GetCurPageParam("PAGE_EL_COUNT=".$arCount['VALUE']."&load=Y", array("PAGE_EL_COUNT", "load", "PAGEN_1", "PAGEN_2", "PAGEN_3", "PAGEN_4", "PAGEN_5"))?>"<?if ($arCount["SELECTED"] == "Y"):?> class="selected"<?endif;?> data-count-code="<?=$arCount['VALUE']?>"><?=$arCount['TITLE']?></a>
        <?endforeach;?>
    </div>
<?endif;?>