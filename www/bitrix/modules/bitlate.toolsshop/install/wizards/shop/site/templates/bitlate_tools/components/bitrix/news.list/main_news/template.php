<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?if (!empty($arResult['ITEMS'])):?>
    <div class="main-news">
        <h2 class="main-news-caption"><?=$arParams['PAGER_TITLE']?></h2>
        <div class="owl-carousel main-news-carousel">
            <?foreach ($arResult['ITEMS'] as $index => $arItem):
                $pic = false;
                if (intval($arItem['FIELDS']['PREVIEW_PICTURE'])) {
                    $pic = CFile::ResizeImageGet($arItem['FIELDS']['PREVIEW_PICTURE'], array('width' => 283, 'height' => 220), BX_RESIZE_IMAGE_EXACT, true);
                }
                if ($pic !== false || $arParams['DISPLAY_PICTURE'] == "N"):
                    if (CModule::IncludeModule('bitlate.toolsshop')) {
                        $title = NLApparelshopUtils::nl_truncate_text($arItem['FIELDS']['NAME'], 50);
                        $previewText = NLApparelshopUtils::nl_truncate_text(strip_tags($arItem['FIELDS']['PREVIEW_TEXT']), 200);
                    }?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <?if ($pic !== false):?>
                            <img src="<?=$pic['src']?>" alt="<?=$title?>">
                        <?endif;?>
                        <span class="main-news-item-info<?if ($pic === false):?> no-preview<?endif;?>">
                            <span class="label"><?=$arItem['FIELDS']['ACTIVE_FROM']?></span>
                            <span class="main-news-item-caption"><?=$title?></span>
                            <span class="main-news-item-desc"><?=strip_tags($previewText)?></span>
                        </span>
                    </a>
                <?endif;?>
            <?endforeach;?>
        </div>
    </div>
<?endif;?>