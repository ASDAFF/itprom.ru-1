<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!empty($arResult["CATEGORIES"])):?>
    <ul>
        <?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):
            $item = current($arCategory['ITEMS']);
            if ($item['PARAM2'] == $arParams['CATEGORY_0_iblock_news'][0])
                $type = 'news';
            elseif ($item['PARAM2'] == $arParams['CATEGORY_1_iblock_news'][0])
                $type = 'actions';
            elseif ($item['PARAM2'] == $arParams['CATEGORY_2_iblock_catalog'][0])
                $type = 'catalog';
            else
                continue;?>
            <li class="header-seacrh-category-item">
                <ul<?if ($type == 'catalog'):?> class="product-list-mini"<?endif;?>>
                    <li><a href="#" class="header-seacrh-caption"><?echo $arCategory["TITLE"]?></a></li>
                    <?foreach ($arCategory['ITEMS'] as $arItem):
                        if (!isset($arItem['PARAM2']))
                            continue;
                        if ($type != 'catalog'):?>
                            <li><a href="<?=$arItem['URL']?>" class="header-seacrh-info-link"><?=$arItem['NAME']?></a></li>
                        <?else:
                            $arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];
                            $price = '';
                            foreach($arElement["PRICES"] as $code=>$arPrice) {
                                if ($arPrice["CAN_ACCESS"]) {
                                    if ($price == '') {
                                        $price = $arPrice;
                                    } elseif ($arPrice["VALUE"] < $price) {
                                        $price = $arPrice;
                                    }
                                }
                            }?>
                            <li>
                                <a href="<?=$arItem['URL']?>" class="product-list-mini-link table-container">
                                    <?if (!is_array($arElement["PICTURE"])) {
                                        $arElement["PICTURE"]["src"] = SITE_TEMPLATE_PATH . '/images/no_photo.png';
                                    }?>
                                    <span class="product-list-mini-preview table-item"><img src="<?=$arElement["PICTURE"]["src"]?>" alt="<?=htmlspecialchars(strip_tags($arItem['NAME']))?>"></span>
                                    <span class="table-item">
                                        <span class="product-list-mini-desc"><?=$arItem["NAME"]?></span>
                                        <span class="product-list-mini-desc price"><?=$price["PRINT_VALUE"]?></span>
                                    </span>
                                </a>
                            </li>
                        <?endif;
                    endforeach;?>
                </ul>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>