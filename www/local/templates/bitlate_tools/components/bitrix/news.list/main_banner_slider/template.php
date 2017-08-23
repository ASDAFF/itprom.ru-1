<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if (!empty($arResult['ITEMS'])):?>
    <div class="container row">
        <div class="owl-carousel main-banner hide-for-small-only">
            <?foreach ($arResult['ITEMS'] as $arItem):
                if (intval($arItem['PREVIEW_PICTURE'])):
                    $pic = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width' => 385, 'height' => 210), BX_RESIZE_IMAGE_EXACT, true);?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <img src="<?=$pic['src']?>" alt="<?=$arItem['NAME']?>">
                    </a>
                <?endif;
            endforeach;?>
        </div>
    </div>
<?endif;?>