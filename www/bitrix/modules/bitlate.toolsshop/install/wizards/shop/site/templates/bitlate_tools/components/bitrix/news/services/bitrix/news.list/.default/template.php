<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if ($arResult['NAV_RESULT']->NavPageNomer <= 1 && $arParams['REQUEST_LOAD'] != "Y"):?>
    <ul class="inner-content-list" id="services-items">
<?endif;?>
    <?foreach ($arResult["ITEMS"] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $pic = false;
        if (!empty($arItem['PREVIEW_PICTURE'])) {
            $pic = CFile::resizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 210, 'height' => 164), BX_RESIZE_IMAGE_EXACT, true);
        }
        $isShowDetail = (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"]));?>
        <li id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="table-container">
            <?if ($pic !== false):?>
                <div class="inner-content-preview for-news table-item">
                    <?if ($isShowDetail):?>
                        <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$pic['src']?>" alt="<?=$title?>" title="<?=$title?>"></a>
                    <?else:?>
                        <img src="<?=$pic['src']?>" alt="<?=$title?>" title="<?=$title?>">
                    <?endif;?>
                </div>
            <?endif;?>
            <div class="inner-content-info table-item">
                <?if ($isShowDetail):?>
                    <a class="name" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                <?else:?>
                    <div class="name"><?=$arItem['NAME']?></div>
                <?endif;?>
                <div class="show-for-large"><?=$arItem['PREVIEW_TEXT']?></div>
            </div>
        </li>
    <?endforeach;?>
<?$nextPageUrl = '';
if (isset($arResult['NAV_RESULT']->NavPageCount) && ($arResult['NAV_RESULT']->NavPageCount > 1) && ($arResult['NAV_RESULT']->NavPageCount > $arResult['NAV_RESULT']->NavPageNomer)) {
    $nextPageUrl = $APPLICATION->GetCurPageParam("PAGEN_" . $arResult['NAV_RESULT']->NavNum . "=" . ($arResult['NAV_RESULT']->NavPageNomer + 1) . "&load=Y", array("PAGEN_" . $arResult['NAV_RESULT']->NavNum, "load"));
}
if ($arResult['NAV_RESULT']->NavPageNomer <= 1 && $arParams['REQUEST_LOAD'] != "Y"):?>
    </ul>
    <?if ($nextPageUrl != ''):?>
        <a href="javascript:;" class="load-more float-center text-center" onclick="getNewsItems(this, 'services-items', false)" data-ajax="<?=$nextPageUrl?>">
            <svg class="icon">
                <use xlink:href="#svg-icon-load-more"></use>
            </svg>
            <?=GetMessage('CT_BUTTON_SHOW_MORE')?>
        </a>
    <?endif;?>
<?else:?>
    <script>
        <?if ($nextPageUrl != ''):?>
            $('.load-more').attr('data-ajax', '<?=$nextPageUrl?>');
            $('.load-more').show();
        <?else:?>
            $('.load-more').hide();
        <?endif;?>
    </script>
<?endif;?>