<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(strlen($arResult["ERROR_MESSAGE"])):?>
	<?=ShowError($arResult["ERROR_MESSAGE"]);?>
<?else:?>
<div class="fancybox-block" style="display:block;">
    <div class="fancybox-block-caption"><?=str_replace("#ID#", $arResult["ID"], GetMessage("SPOD_ORDER"))?> <span><?=$arResult["DATE_INSERT_FORMATED"]?></span></div>
    <div class="fancybox-block-wrap fancybox-block-wrap-order">
        <div><strong><?=GetMessage("SPOD_ORDER_STATUS")?>:</strong> <?=$arResult["STATUS"]["NAME"]?></div>
        <div class="price-block"><strong><?=GetMessage("SPOD_ORDER_PRICE")?>:</strong> <?=$arResult["PRICE_FORMATED"]?></div>
        <div><strong><?=GetMessage("SPOD_ORDER_DELIVERY")?>:</strong> <?=$arResult["DELIVERY"]["NAME"]?></div>
        <div><strong><?=GetMessage("SPOD_PAY_SYSTEM")?>:</strong> <?=$arResult["PAY_SYSTEM"]["NAME"]?></div>
    </div>
    <div class="fancybox-block-wrap fancybox-block-wrap-order">
        <ul class="product-list-mini">
            <li><strong><?=GetMessage("SPOD_ORDER_BASKET")?></strong></li>
            <?foreach($arResult["BASKET"] as $prod):
                $hasLink = !empty($prod["DETAIL_PAGE_URL"]);?>
                <li>
                    <?if($hasLink):?>
                        <a href="<?=$prod["DETAIL_PAGE_URL"]?>" class="product-list-mini-link table-container" target="_blank">
                    <?endif?>
                    <div class="product-list-mini-preview table-item">
                        <?if($prod['PICTURE']['SRC']):?>
                            <img src="<?=$prod['PICTURE']['SRC']?>" alt="">

                        <?endif?>
                    </div>
                    <div class="table-item">
                        <span class="product-list-mini-desc"><?=$prod["NAME"]?></span>
                        <span class="product-list-mini-details">
                            <?=GetMessage("SPOD_QUANTITY")?>: <?=$prod["QUANTITY"]?><?=GetMessage("SPOD_DEFAULT_MEASURE")?>.<br>
                            <?if($arResult['HAS_PROPS']):
                                $actuallyHasProps = is_array($prod["PROPS"]) && !empty($prod["PROPS"]);
                                if($actuallyHasProps):?>
                                    <?foreach($prod["PROPS"] as $prop):?>
                                        <nobr><?=$prop["NAME"]?>:</nobr> <?=$prop["VALUE"]?><br>
                                    <?endforeach?>
                                <?endif?>
                            <?endif?>
                        </span>
                        <span class="product-list-mini-desc price-block"><?=CCurrencyLang::CurrencyFormat($prod["PRICE"] * $prod["QUANTITY"], $prod["CURRENCY"])?></span>
                    </div>
                    <?if($hasLink):?>
                        </a>
                    <?endif?>
                </li>
            <?endforeach;?>
            <?foreach ($arResult['PAYMENT'] as $payment):?>
                <?if ($payment["CAN_REPAY"]=="Y"):?>
                    <div class="bx_payment_block">
                        <?if($payment["PAY_SYSTEM"]["PSA_NEW_WINDOW"] != "Y"):?>
                                <?
                                $ORDER_ID = $ID;

                                try
                                {
                                    include($payment["PAY_SYSTEM"]["PSA_ACTION_FILE"]);
                                }
                                catch(\Bitrix\Main\SystemException $e)
                                {
                                    if($e->getCode() == CSalePaySystemAction::GET_PARAM_VALUE)
                                        $message = GetMessage("SOA_TEMPL_ORDER_PS_ERROR");
                                    else
                                        $message = $e->getMessage();

                                    ShowError($message);
                                }
                                ?>
                                <script>
                                    $(".bx_payment_block input[type=submit]").addClass("red-button");
                                </script>
                        <?endif?>
                        <?if($payment["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
                            <a href="<?=$payment["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" class="red-button" target="_blank"><?=GetMessage("SPOD_REPEAT_PAY")?></a>
                            <div class="clear-all"></div>
                        <?endif?>
                    </div>
                <?endif?>
            <?endforeach;?>
        </ul>
    </div>
</div>
<?endif;?>
