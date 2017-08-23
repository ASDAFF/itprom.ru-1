<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
CModule::IncludeModule('bitlate.toolsshop');?>

<?if (!empty($arResult["STORES"])):?>
    <ul class="product-existence">
        <?foreach($arResult["STORES"] as $arProperty):?>
            <li class="row" style="display: <? echo ($arParams['SHOW_EMPTY_STORE'] == 'N' && isset($arProperty['REAL_AMOUNT']) && $arProperty['REAL_AMOUNT'] <= 0 ? 'none' : ''); ?>;">
                <div class="small-6 medium-9 columns">
                    <?if (isset($arProperty["TITLE"])):?>
                        <a href="<?=$arProperty["URL"]?>" class="product-existence-address"><?=$arProperty["TITLE"]?></a><?if (isset($arProperty["PHONE"])):?><a href="tel:<?=$arProperty["PHONE"]?>" class="product-existence-phone"><?=GetMessage('S_PHONE')?> <?=$arProperty["PHONE"]?><?endif;?></a>
                    <?endif;?>
                </div>
                <?$quantityInfo = NLApparelshopUtils::getProductAmount(intval($arProperty['REAL_AMOUNT']), $arParams['MIN_AMOUNT'], $arParams['MAX_AMOUNT']);
                $quantityText = ($arParams['USE_MIN_AMOUNT'] == "Y") ? $quantityInfo['text'] : $quantityInfo['products'];?>
                <div class="small-6 medium-3 columns" id="<?=$arResult['JS']['ID']?>_<?=$arProperty['ID']?>">
                    <div class="existence <?=$quantityInfo['class']?> float-right" title="<?=$quantityText?>">
                        <div class="existence-icon">
                            <div class="existence-icon-active"></div>
                        </div>
                        <span class="existence-count"><?=$quantityText?></span>
                    </div>
                </div>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>
<?if (isset($arResult["IS_SKU"]) && $arResult["IS_SKU"] == 1):
    foreach ($arResult['JS']['SKU'] as $offerId => $stores) {
        foreach ($stores as $storeId => $amount) {
            $quantityInfo = NLApparelshopUtils::getProductAmount(intval($amount), $arParams['MIN_AMOUNT'], $arParams['MAX_AMOUNT']);
            $quantityText = ($arParams['USE_MIN_AMOUNT'] == "Y") ? $quantityInfo['text'] : $quantityInfo['products'];
            $arResult['JS']['SKU'][$offerId][$storeId] = '<div class="existence ' . $quantityInfo['class'] . ' float-right" title="' . $quantityText . '"><div class="existence-icon"><div class="existence-icon-active"></div></div><span class="existence-count">' . $quantityText . '</span></div>';
        }
    }
    $quantityInfo = NLApparelshopUtils::getProductAmount(0, $arParams['MIN_AMOUNT'], $arParams['MAX_AMOUNT']);
    $quantityText = ($arParams['USE_MIN_AMOUNT'] == "Y") ? $quantityInfo['text'] : $quantityInfo['products'];
    $arResult['JS']['MESSAGES']['ABSENT'] = '<div class="existence ' . $quantityInfo['class'] . ' float-right" title="' . $quantityText . '"><div class="existence-icon"><div class="existence-icon-active"></div></div><span class="existence-count">' . $quantityText . '</span></div>';?>
    <script type="text/javascript">
        var obStoreAmount = new JCCatalogStoreSKU(<? echo CUtil::PhpToJSObject($arResult['JS'], false, true, true); ?>);
    </script>
<?endif;?>