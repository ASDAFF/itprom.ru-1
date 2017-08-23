<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="small-up-2 large-up-4 xxlarge-up-6">
    <?foreach($arResult["ITEMS"] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $pic = false;
        if (!empty($arItem['PREVIEW_PICTURE'])) {
            $pic = CFile::resizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 140, 'height' => 80), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
        }?>
        <a class="column inner-content-brand" href="<?=$arItem["DETAIL_PAGE_URL"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?if ($pic !== false):?>
                <img src="<?=$pic['src']?>" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>" />
            <?endif;?>
        </a>
    <?endforeach;?>
</div>
