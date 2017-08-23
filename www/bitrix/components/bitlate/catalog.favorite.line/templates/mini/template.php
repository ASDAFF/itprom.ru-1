<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="inline-block-item relative" id="bx_favorite_count_mini">
    <?$frame = new \Bitrix\Main\Page\FrameHelper("bx_favorite_count_mini", false);
    $frame->begin();
        $countFav = NLApparelshopUtils::getCountFavorits();
        $countFavCaptionMini = $countFav . ' ' . NLApparelshopUtils::nl_inclination($countFav, GetMessage('NL_PRODUCT_1'), GetMessage('NL_PRODUCT_2'), GetMessage('NL_PRODUCT_10'));
        $countFavCaption = $countFavCaptionMini . ' ' . GetMessage('ADD_2_LIKED_CAPTION');?>
        <a href="<?=(($countFav > 0) ? '#liked' : 'javascript:;')?>" class="inline-block-container fancybox">
            <span class="inline-block-item relative">
                <svg class="icon">
                    <use xlink:href="#svg-icon-liked"></use>
                </svg>
                <span class="header-block-info-counter inline-block-item" title="<?=$countFavCaptionMini?>"><?if ($countFav > 0):?><?=$countFav?><?endif;?></span>
            </span>
            <span class="inline-block-item hide-for-small-only hide-for-medium-only hide-for-large-only">
                <span class="header-block-info-link"><?=getMessage('FAVORITE')?></span>
                <span class="header-block-info-desc" title="<?=$countFavCaption?>"><?=$countFavCaption?></span>
            </span>
        </a>
    <?$frame->beginStub();
        $countFav = 0;
        $countFavCaptionMini = $countFav . ' ' . NLApparelshopUtils::nl_inclination($countFav, GetMessage('NL_PRODUCT_1'), GetMessage('NL_PRODUCT_2'), GetMessage('NL_PRODUCT_10'));
        $countFavCaption = $countFavCaptionMini . ' ' . GetMessage('ADD_2_LIKED_CAPTION');?>
        <a href="javascript:;" class="inline-block-container fancybox">
            <span class="inline-block-item relative">
                <svg class="icon">
                    <use xlink:href="#svg-icon-liked"></use>
                </svg>
                <span class="header-block-info-counter inline-block-item" title="<?=$countFavCaptionMini?>"></span>
            </span>
            <span class="inline-block-item hide-for-small-only hide-for-medium-only hide-for-large-only">
                <span class="header-block-info-link"><?=getMessage('FAVORITE')?></span>
                <span class="header-block-info-desc" title="<?=$countFavCaption?>"><?=$countFavCaption?></span>
            </span>
        </a>
    <?$frame->end();?>
    <script>
        var NL_ADD_2_LIKED_DELETE = '<?=GetMessage('ADD_2_LIKED_DELETE')?>';
        var NL_ADD_2_LIKED = '<?=GetMessage('ADD_2_LIKED')?>';
        var NL_PRODUCT_1 = '<?=GetMessage('NL_PRODUCT_1')?>';
        var NL_PRODUCT_2 = '<?=GetMessage('NL_PRODUCT_2')?>';
        var NL_PRODUCT_10 = '<?=GetMessage('NL_PRODUCT_10')?>';
        var NL_ADD_2_LIKED_CAPTION = '<?=GetMessage('ADD_2_LIKED_CAPTION')?>';
    </script>
</div>