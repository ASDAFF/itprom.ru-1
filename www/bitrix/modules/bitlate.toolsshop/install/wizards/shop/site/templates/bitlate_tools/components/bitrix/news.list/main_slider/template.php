<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if (!empty($arResult['ITEMS'])):?>
    <div class="owl-carousel main-slider">
        <?foreach ($arResult['ITEMS'] as  $arItem):
            if (intval($arItem['PREVIEW_PICTURE'])):
                $pic = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width' => 1900, 'height' => 574), BX_RESIZE_IMAGE_EXACT, true);
                $detailUrl = $arResult['RELATED_ITEMS'][$arItem['PROPERTIES']['RELATED_ITEM']['VALUE']]['DETAIL_PAGE_URL'];
                $blockSelector = ($detailUrl) ? 'a' : 'div';?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="item vertical-middle" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <<?=$blockSelector?><?if ($detailUrl):?> href="<?=$detailUrl?>"<?endif;?> class="background <?=($arItem['PROPERTIES']['STYLE']['VALUE_XML_ID'] == 'white') ? 'white' : 'black'?>" style="background-image:url(<?=$pic['src']?>);">
                        <span class="container row">
                            <span class="main-slider-caption"><?=$arItem['NAME']?></span>
                            <span class="main-slider-desc"><?=$arItem['PREVIEW_TEXT']?></span>
                            <?if ($detailUrl):?>
                                <span class="button hide-for-small-only"><?=GetMessage("MORE")?></span>
                            <?endif;?>
                        </span>
                    </<?=$blockSelector?>>
                </div>
            <?endif;
        endforeach;?>
    </div>
<?endif;?>