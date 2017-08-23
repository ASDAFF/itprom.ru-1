<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($arParams['POPUP'] == 'Y'):?>
    <div id="all-history" class="fancybox-block">
        <div class="fancybox-block-caption"><?=GetMessage('ORDER_LIST_TITLE')?></div>
        <div class="fancybox-block-wrap">
<?else:?>
    <div class="column profile-column-item history" data-order="4">
        <div class="profile-block">
            <div class="profile-block-caption">
                <svg class="icon">
                    <use xlink:href="#svg-icon-history"></use>
                </svg>
                <?=GetMessage('ORDER_LIST_TITLE')?>
            </div>
            <div class="profile-block-wrap">
<?endif;?>
<?if (!empty($arResult['ORDERS']) && is_array($arResult['ORDERS'])):?>
    <ul class="profile-block-list" data-ajax="<?=SITE_DIR?>nl_ajax/history_order.php">
        <?foreach ($arResult['ORDERS'] as $arData):?>
            <li>
                <a href="#" class="profile-order-<?=$arData['ORDER']['ID']?>"><?=GetMessage('STPOL_ORDER_NO')?><?=$arData['ORDER']['ACCOUNT_NUMBER']?></a> <span class="profile-block-list-date"><?=GetMessage('STPOL_FROM')?> <?=$arData['ORDER']['DATE_INSERT_FORMATED']?></span>
                <div class="profile-block-list-status price-block"><?=$arData['ORDER']['FORMATED_PRICE']?>  <?=$arResult['INFO']['STATUS'][$arData['ORDER']['STATUS_ID']]['NAME']?></div>
                <?if ($arParams['POPUP'] == 'Y'):?>
                    <script>
                        $(document).ready(function(){
                            $(".profile-order-<?=$arData['ORDER']['ID']?>").fancybox({
                                type: 'ajax',
                                href: "<?=SITE_DIR?>nl_ajax/history_order.php?ID=<?=$arData['ORDER']['ID']?>",
                                padding: 0
                            });
                        });
                    </script>
                <?endif;?>
            </li>
        <?endforeach;?>
    </ul>
    <?if ($arParams['POPUP'] != 'Y'):?>
        <a href="#all-history" class="button small secondary fancybox"><?=GetMessage('ORDER_LIST_SHOW_ALL')?></a>
    <?endif;?>
<?else:?>
    <p class="order"><?=GetMessage('ORDER_LIST_EMPTY')?></p>
<?endif;?>
<?if ($arParams['POPUP'] == 'Y'):?>
        </div>
    </div>
<?else:?>
            </div>
        </div>
    </div>
<?endif;?>