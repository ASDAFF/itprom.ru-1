<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if ($arResult['NAV_RESULT']->NavPageNomer <= 1 && $arParams['REQUEST_LOAD'] != "Y"):?>
    <nav class="inner-menu-filter">
        <ul class="menu">
            <li class="float-left<?if ($arParams["CUR_ACTIVE"] == ''):?> active<?endif;?>"><a href="<?=$APPLICATION->GetCurPage()?>" data-ajax="<?=$APPLICATION->GetCurPage()?>?load=Y"><?=GetMessage('CT_ALL')?></a></li>
            <?if ($arResult["ACTIONS_ACTIVE"] === true):?>
                <li class="float-left<?if ($arParams["CUR_ACTIVE"] == "Y"):?> active<?endif;?>"><a href="<?=$APPLICATION->GetCurPage()?>" data-ajax="<?=$APPLICATION->GetCurPage()?>?ACTIVE=Y&load=Y"><?=GetMessage('CT_ACTIVE')?></a></li>
            <?endif;?>
            <?if ($arResult["ACTIONS_INACTIVE"] === true):?>
                <li class="float-left<?if ($arParams["CUR_ACTIVE"] == "N"):?> active<?endif;?>"><a href="<?=$APPLICATION->GetCurPage()?>" data-ajax="<?=$APPLICATION->GetCurPage()?>?ACTIVE=N&load=Y"><?=GetMessage('CT_INACTIVE')?></a></li>
            <?endif;?>
        </ul>
        <div class="clearfix"></div>
    </nav>
    <ul class="inner-content-list" id="action-items">
<?endif;?>
    <?foreach ($arResult["ITEMS"] as $i => $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $pic = false;
        if (!empty($arItem['PREVIEW_PICTURE'])) {
            $pic = CFile::resizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 385, 'height' => 210), BX_RESIZE_IMAGE_EXACT, true);
        }?>
        <li class="row inline-block-container" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?if ($pic !== false):?>
                <div class="inner-content-preview inline-block-item float-none columns large-7 xxlarge-5 vertical-middle">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$pic['src']?>" alt="<?=$arItem['NAME']?>" title="<?=$arItem['NAME']?>"></a>
                </div>
            <?endif;?>
            <div class="inner-content-info inline-block-item float-none columns large-5 xxlarge-7 vertical-middle">
                <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                    <span class="label<?if (($i % 2) == 0):?> secondary<?endif;?>"><?=$arItem['DISPLAY_ACTIVE_FROM']?><?if ($arItem['ACTIVE_TO']):?> – <?=ConvertTimeStamp(strtotime($arItem['ACTIVE_TO']), $arParams["LIST_ACTIVE_DATE_FORMAT"])?><?endif;?></span>
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
        <a href="javascript:;" class="load-more float-center text-center" onclick="getNewsItems(this, 'action-items', false)" data-ajax="<?=$nextPageUrl?>">
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