<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if ($arResult['NAV_RESULT']->NavPageNomer <= 1 && $arParams['REQUEST_LOAD'] != "Y"):?>
    <nav class="inner-menu-filter">
        <ul class="menu">
            <li class="float-left<?if ($arParams["CUR_YEAR"] == 0):?> active<?endif;?>"><a href="<?=$APPLICATION->GetCurPage()?>" data-ajax="<?=$APPLICATION->GetCurPage()?>?load=Y"><?=GetMessage('CT_ALL')?></a></li>
            <?if (count($arResult["YEARS"]) > 1):?>
                <?foreach ($arResult["YEARS"] as $year):?>
                    <li class="float-left<?if ($arParams["CUR_YEAR"] == $year):?> active<?endif;?>"><a href="<?=$APPLICATION->GetCurPage()?>?YEAR=<?=$year?>" data-ajax="<?=$APPLICATION->GetCurPage()?>?YEAR=<?=$year?>&load=Y"><?=$year?> <?=GetMessage('CT_YEAR')?></a></li>
                <?endforeach;?>
            <?endif;?>
        </ul>
        <div class="clearfix"></div>
    </nav>
    <ul class="inner-content-list" id="news-items">
<?endif;?>
    <?foreach ($arResult["ITEMS"] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $pic = false;
        if (!empty($arItem['PREVIEW_PICTURE'])) {
            $pic = CFile::resizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 210, 'height' => 164), BX_RESIZE_IMAGE_EXACT, true);
        }?>
        <li id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="table-container">
            <?if ($pic !== false):?>
                <div class="inner-content-preview for-news table-item">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$pic['src']?>" alt="<?=$title?>" title="<?=$title?>"></a>
                </div>
            <?endif;?>
            <div class="inner-content-info table-item">
                <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                    <span class="label"><?=$arItem['DISPLAY_ACTIVE_FROM']?></span>
                <?endif;?>
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="name"><?=$arItem['NAME']?></a>
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
        <a href="javascript:;" class="load-more float-center text-center" onclick="getNewsItems(this, 'news-items', false)" data-ajax="<?=$nextPageUrl?>">
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