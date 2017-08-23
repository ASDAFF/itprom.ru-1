<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="inline-block-item relative" id="bx_favorite_count">
    <?$frame = new \Bitrix\Main\Page\FrameHelper("bx_favorite_count", false);
    $frame->begin();
        $countFav = NLApparelshopUtils::getCountFavorits();?>
        <a href="<?=(($countFav > 0) ? '#liked' : 'javascript:;')?>" class="button transparent add2liked inline-block-item fancybox">
            <svg class="icon">
                <use xlink:href="#svg-icon-liked"></use>
            </svg>
            <?=getMessage('FAVORITE')?><span><?if ($countFav > 0):?> (<?=$countFav?>)<?endif;?></span>
        </a>
        <div class="liked_products" style="display:none;">
            <?if ($countFav > 0):
                $likedProducts = NLApparelshopUtils::getFavorits();?>
                    <?foreach ($likedProducts as $position => $offers):
                        foreach ($offers as $offerId => $count):
                            $productId = ($offerId > 0) ? $offerId : $position;?>
                            <div data-product-id="<?=$productId?>"></div>
                        <?endforeach;?>
                    <?endforeach;?>
            <?endif;?>
        </div>
    <?$frame->beginStub();?>
        <a href="javascript:;" class="button transparent add2liked inline-block-item fancybox">
            <svg class="icon">
                <use xlink:href="#svg-icon-liked"></use>
            </svg>
            <?=getMessage('FAVORITE')?>
        </a>
    <?$frame->end();?>
    <script>
        var NL_ADD_2_LIKED_DELETE = '<?=GetMessage('ADD_2_LIKED_DELETE')?>';
        var NL_ADD_2_LIKED = '<?=GetMessage('ADD_2_LIKED')?>';
    </script>
</div>