<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

//test_dump($arResult);
$this->setFrameMode(true);

$uf_iblock_id = $arResult["IBLOCK_ID"]; //ID инфоблока
$uf_section_id = $arResult["IBLOCK_SECTION_ID"];
$uf_name = Array("UF_DESCR_TEMPLATE");

$DESCRIPTION = "";

if (CModule::IncludeModule("iblock")): //подключаем модуль инфоблок для работы с классом CIBlockSection
    $uf_arresult = CIBlockSection::GetList(Array("SORT" => "­­ASC"), Array("IBLOCK_ID" => $uf_iblock_id, "ID" => $uf_section_id), false, $uf_name);
    if ($uf_value = $uf_arresult->GetNext()):
        if (strlen($uf_value["UF_DESCR_TEMPLATE"]) > 0): //проверяем что поле заполнено
            $DESCRIPTION = $uf_value["~UF_DESCR_TEMPLATE"];
            $string_to_find = "/#[A-Z_n]+#/";

            $matches = Array();
            preg_match_all($string_to_find, $DESCRIPTION, $matches);

            if (count($matches > 0)):
                $matches = $matches[0];

                for ($i = 0; $i < count($matches); $i++) {
                    $value = $matches[$i][1] != 'n';
                    $match = trim($matches[$i], "#n");

                    if ($value)
                        $replace = $arResult["PROPERTIES"][$match]["VALUE"];
                    else
                        $replace = $arResult["PROPERTIES"][$match]["NAME"];

                    $DESCRIPTION = str_replace($matches[$i], $replace, $DESCRIPTION);
                }

                $arResult["DETAIL_TEXT"] = $DESCRIPTION;
            endif;

        endif;
    endif;
endif;


$strMainID = $this->GetEditAreaId($arResult['ID']);
$isOffers = !empty($arResult["OFFERS"]);
$arItemIDs = array(
    'ID' => $strMainID,
    'PICT' => $strMainID . '_pict',
    'DISCOUNT_PICT_ID' => $strMainID . '_dsc_pict',
    'STICKER_ID' => $strMainID . '_sticker',
    'BIG_SLIDER_ID' => $strMainID . '_big_slider',
    'BIG_IMG_CONT_ID' => $strMainID . '_bigimg_cont',
    'SLIDER_CONT_ID' => $strMainID . '_slider_cont',
    'SLIDER_LIST' => $strMainID . '_slider_list',
    'SLIDER_LEFT' => $strMainID . '_slider_left',
    'SLIDER_RIGHT' => $strMainID . '_slider_right',
    'OLD_PRICE' => $strMainID . '_old_price',
    'PRICE' => $strMainID . '_price',
    'DISCOUNT_PRICE' => $strMainID . '_price_discount',
    'SLIDER_CONT_OF_ID' => $strMainID . '_slider_cont_',
    'SLIDER_LIST_OF_ID' => $strMainID . '_slider_list_',
    'SLIDER_LEFT_OF_ID' => $strMainID . '_slider_left_',
    'SLIDER_RIGHT_OF_ID' => $strMainID . '_slider_right_',
    'QUANTITY' => $strMainID . '_quantity',
    'QUANTITY_DOWN' => $strMainID . '_quant_down',
    'QUANTITY_UP' => $strMainID . '_quant_up',
    'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
    'QUANTITY_LIMIT' => $strMainID . '_quant_limit',
    'BUY_LINK' => $strMainID . '_buy_link',
    'ADD_BASKET_LINK' => $strMainID . '_add_basket_link',
    'COMPARE_LINK' => $strMainID . '_compare_link',
    'PROP' => $strMainID . '_prop_',
    'PROP_DIV' => $strMainID . '_skudiv',
    'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
    'OFFER_GROUP' => $strMainID . '_set_group_',
    'BASKET_PROP_DIV' => $strMainID . '_basket_prop',
);
$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
    ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
    : $arResult['NAME']
);
$strAlt = (
isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
    ? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
    : $arResult['NAME']
); ?>


    <div itemscope itemtype="http://schema.org/Product">

        <div class="description-product" id="<?= $arItemIDs['ID'] ?>">
            <div class="description-block" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <div class="heading">
                    <? $useBrands = ('Y' == $arParams['BRAND_USE']);
                    if ($useBrands) {
                        ?>
                        <span class="brand-text"><?= GetMessage("WF_BRAND") ?>:</span>
                        <? $APPLICATION->IncludeComponent("bitrix:catalog.brandblock", "brands2", array(
                            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            "ELEMENT_ID" => $arResult['ID'],
                            "ELEMENT_CODE" => "",
                            "PROP_CODE" => $arParams['BRAND_PROP_CODE'],
                            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                            "CACHE_TIME" => $arParams['CACHE_TIME'],
                            "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                            "WIDTH" => $arParams["DETAIL_BRAND_WIDTH"],
                            "HEIGHT" => $arParams["DETAIL_BRAND_HEIGHT"],
                            "WIDTH_SMALL" => $arParams["DETAIL_BRAND_WIDTH_SMALL"],
                            "HEIGHT_SMALL" => $arParams["DETAIL_BRAND_HEIGHT_SMALL"]
                        ),
                            $component,
                            array("HIDE_ICONS" => "N")
                        ); ?>
                    <? } ?>
                </div>
                <? if (!empty($arResult["WF-OPTIONS"])): ?>
                    <form method="post" action="">
                        <div class="code-text" style="padding-bottom: 0;"><?= GetMessage("WF_OPTIONS") ?>:</div>
                        <ul class="options">
                            <? foreach ($arResult["WF-OPTIONS"] as $key => $option):
                                ?>
                                <li>
                                    <label for="opt<?= $key ?>" class="styledLabel">
                                        <span class="checkboxArea"></span>
                                        <input type="checkbox" class="superIgnore styledRadio" name="dop_options[]"
                                               id="opt<?= $key ?>" value="<?= $option["CODE"] ?>"
                                               data-optid="<?= $option["ID"] ?>"/>
                                         <span class="tooltip-wrapper"><?= $option["NAME"] ?>
                                            <span class="tooltip-hold">
            <span class="tooltip"><?= $option["TEXT"] ?></span>
          </span>
          — <?= $option["CODE"] ?> <span class="rouble">⃏</span></span>
                                    </label>
                                </li>
                            <? endforeach ?>
                        </ul>
                    </form>
                <? endif ?>
                <? $boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
                if ($boolDiscountShow) {
                    $price = str_replace(" руб.", "", $arResult["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]);
                } else {
                    $price = str_replace(" руб.", "", $arResult["MIN_PRICE"]["PRINT_VALUE"]);
                }
                $canBuy = $arResult['CAN_BUY'];
                if (!empty($arResult["PROPERTIES"]["ARTNUMBER"]["VALUE"])):?>
                    <div class="code-text"><?= $arResult["PROPERTIES"]["ARTNUMBER"]["NAME"] ?>
                        : <?= $arResult["PROPERTIES"]["ARTNUMBER"]["VALUE"] ?></div>
                <? endif ?>
                <? if ($isOffers): ?>
                    <form method="post" action="">
                        <div class="code-text"
                             style="padding-bottom: 0;"><?= $arResult["OFFERS"][0]["PROPERTIES"]["SIZE_GENERAL"]["NAME"] ?>
                            :
                        </div>
                        <ul class="offers">
                            <? foreach ($arResult["OFFERS"] as $key => $option):
                                $priceOf = str_replace(".00", "", $option["CATALOG_PRICE_1"]);
                                if ($key == 0) {
                                    $price = $priceOf;
                                    $checked = "checked";
                                    $torgWare = $option["ID"];
                                } else {
                                    $checked = "";
                                }
                                ?>
                                <li>
                                    <label for="opt<?= $key ?>" class="styledLabel">
                                        <span class="radioArea"></span>
                                        <input type="radio" name="offers" class="styledRadio" id="opt<?= $key ?>"
                                               value="<?= $priceOf ?>"
                                               data-offerid="<?= $option["ID"] ?>" <?= $checked ?>/>
                                         <span
                                            class="tooltip-wrapper"><?= $option["PROPERTIES"]["SIZE_GENERAL"]["VALUE"] ?>
                                            <span class="tooltip-hold">
              <span class="tooltip"><?= $option["NAME"] ?></span>
            </span>
            — <?= $priceOf ?> <span class="rouble">⃏</span></span>
                                    </label>
                                </li>
                            <? endforeach ?>
                        </ul>
                    </form>
                <? endif ?>
                <span class="price-text">Цена с НДС<? //=GetMessage("WF_PRICE")?>:</span>
    <span class="price">
    <?
    if ($boolDiscountShow):?>
        <small class="oldprice" id="<?= $arItemIDs['OLD_PRICE'] ?>">
            <s><?= str_replace(" руб.", "", $arResult["MIN_PRICE"]["PRINT_VALUE"]) ?></s></small>
        <span itemprop="price" id="<?= $arItemIDs['PRICE'] ?>" class="price-val"
              data-baseprice="<?= str_replace(" ", "", $price) ?>"><?= $price ?></span> <span class="rouble">⃏</span>
        <br/>
        <small class="econ"
               id="<?= $arItemIDs['DISCOUNT_PRICE'] ?>"><?= GetMessage("WF_DISC_DIFF", array("#DISC_PRICE#" => str_replace(" руб.", "", $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF']) . '<span class="rouble">⃏</span>')) ?></small>
    <? else:?>
        <span itemprop="price" id="<?= $arItemIDs['PRICE'] ?>" class="price-val"
              data-baseprice="<?= str_replace(" ", "", $price) ?>"><?= $price ?></span> <span class="rouble">⃏</span>
    <? endif ?>
    </span>
    <span class="availability" itemprop="availability"
          href="http://schema.org/InStock"><?= GetMessage("WF_AVAIL_STATUS") ?>:
        <? if ($canBuy): ?>
            <span class="availability-has"><?= GetMessage("WF_AVAILABLE") ?></span>
        <? else: ?>
            <span class="expected"><?= $arParams["MESS_NOT_AVAILABLE"] ?></span>
        <? endif ?>
    </span>
                <?
                if ($canBuy) {
                    $buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
                    if ($isOffers) $wareId = $torgWare;
                    else {
                        $wareId = $arResult["ID"];
                    }
                    ?>
                    <noindex><a title="Купить <?= $arResult["NAME"] ?>" rel="nofollow" href="javascript:void(0);"
                                class="btn-basket" data-wareid="<?= $wareId ?>">
                            <span title="Купить <?= $arResult["NAME"] ?>" class="add-basket"
                                  id="<?= $arItemIDs['BUY_LINK'] ?>"><?= $buyBtnMessage ?></span>
                            <span class="items-cart"><?= GetMessage("WF_ADDED_TO_CART") ?></span>
                        </a></noindex>
                    <?/*<a href="javascript:void(0);" class="btn-credit" data-wareid="<?=$wareId?>"><?=GetMessage("WF_CREDIT_BUY")?><br/>
					<span class="small-text"><?=GetMessage("WF_CREDIT_BUY2",array("#PRICE#" => round($arResult["MIN_PRICE"]["DISCOUNT_VALUE"]/10).' <span class="rouble">⃏</span>'))?></span>
				  </a>*/
                    ?>
                    <?
                } else {
                    $buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
                }
                ?>

                <noindex>
                    <div class="share-article-block" id="sharticleblock">
                        <div class="social-list">
                            <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
                            <div class="yashare-auto-init" data-yashareL10n="ru"
                                 data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus"
                                 data-yashareTheme="counter"></div>
                        </div>
                        <span itemprop="priceCurrency" id="pricecurrcy">RUB</span>
                    </div>
                </noindex>

            </div>
            <div class="description-text">
                <h1 itemprop="name"><?=
                    isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
                        ? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
                        : $arResult["NAME"]
                    ?></h1>
                <div class="gallery-vertical-hold" id="<?= $arItemIDs['BIG_SLIDER_ID'] ?>">
                    <div class="gallery-vertical">
                        <a href="javascript:void(0);" class="prev" id="<?= $arItemIDs['SLIDER_LEFT'] ?>"> </a>
                        <div class="gallery">
                            <ul style="margin-top: -368px;" id="<?= $arItemIDs['SLIDER_CONT_ID'] ?>">
                                <? $i = 0; ?>
                                <? foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto) { ?>
                                    <li data-value="<?= $arOnePhoto['ID'] ?>">
                                        <a href="<?= $arOnePhoto['SRC'] ?>">
                                            <?
                                            $miscPh = "alt=\"";
                                            $curPhoto = $arResult["PROPERTIES"]["MORE_PHOTO"]["DESCRIPTION"][$i];
                                            if ($curPhoto != "") {
                                                $miscPh .= strval($curPhoto) . "\" title=\"" . strval($curPhoto);
                                            } else {
                                                $miscPh .= strval($arResult["NAME"] . " изображение " . strval($i + 2)) . "\" title=\"" . strval($arResult["NAME"] . " изображение " . strval($i + 2));
                                            }
                                            $miscPh .= "\" ";
                                            ?>
                                            <?
                                            $resized_src = GetResizedImage($arOnePhoto["ID"], 100, 100)["src"];
                                            $resized_medium_src = GetResizedImage($arOnePhoto["ID"], 500, 500)["src"];
                                            ?>
                                            <a rel="productgallery" class="fancyimages_mini"
                                               href="<?= $arOnePhoto['SRC']?>" medium_href="<?=$resized_medium_src?>">
                                                <img <?= $miscPh ?> src="<?= $resized_src ?>" width="90" height="90">
                                            </a>
                                        </a>
                                    </li>
                                    <? $i++; ?>
                                <? } ?>
                            </ul>
                        </div>
                        <a href="#" class="next" id="<?= $arItemIDs['SLIDER_RIGHT'] ?>"> </a>
                    </div>
                    <div class="visual" id="<?= $arItemIDs['BIG_IMG_CONT_ID']; ?>">
                        <?
                        $detPh = "alt=\"";
                        if ($arResult["DETAIL_PICTURE"]["ALT"] != "") {
                            $detPh .= strval($arResult["DETAIL_PICTURE"]["ALT"]);
                        } else {
                            $detPh .= strval($arResult["NAME"] . "изображение 1");
                        }
                        $detPh .= "\" title=\"";
                        if ($arResult["DETAIL_PICTURE"]["TITLE"] != "") {
                            $detPh .= strval($arResult["DETAIL_PICTURE"]["TITLE"]);
                        } else {
                            $detPh .= strval($arResult["NAME"] . "изображение 1");
                        }
                        $detPh .= "\" ";
                        ?>
                        <?
                        $resized_src = GetResizedImage($arResult["DETAIL_PICTURE"]["ID"], 500, 500)["src"];
                        ?>
                        <a rel="productgallery" class="fancyimages" href="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>">
                            <img itemprop="image" <?= $detPh ?> id="<?= $arItemIDs['PICT'] ?>" class=""
                                 src="<?= $resized_src ?>">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabset tabset-type02" id="tabset02">
            <ul class="tab-list tab-list2">
                <li><a href="javascript:void(0);"
                       class="active"><strong><?= GetMessage("WF_DESCRIPTION") ?></strong></a></li>
                <li><a href="javascript:void(0);" class=""><strong><?= GetMessage("WF_SPECS") ?></strong></a></li>
                <li><a href="javascript:void(0);" class=""><strong><?= GetMessage("WF_REVIEWS") ?></strong></a></li>
                <li><a href="javascript:void(0);" class=""><strong><?= GetMessage("WF_ACCESSORIES") ?></strong></a></li>
            </ul>
            <div class="tab-holder">
                <div class="tab active">
                    <div class="description" itemprop="description">
                        <?= $arResult["DETAIL_TEXT"] ?>
                    </div>
                </div>
                <div class="tab">
                    <? $excludeProps = array("BRAND_REF", "SPECIALOFFER", "RECOMMEND", //"ARTNUMBER",
                        "OPTIONS", "NEWPRODUCT", "SALELEADER", "MORE_PHOTO", "BLOG_POST_ID", "BLOG_COMMENTS_CNT", "TB_PANELS",) ?>
                    <? //<h3 class="description-title"><?=GetMessage("WF_MAIN")? ></h3> ?>
                    <ul class="description-list">
                        <? foreach ($arResult["PROPERTIES"] as $key => $arDp):
                            if (in_array($key, $excludeProps)) continue;
                            ?>
                            <? $tmpVal = $arDp["VALUE"]; ?>
                            <? if ($tmpVal != ""): ?>
                            <li>
                                <? /* $tmpVal = $arDp["VALUE"]; if ($tmpVal == "")  $tmpVal = "не задано"; */ ?>
                                <span class="text-left"><?= $arDp["NAME"] ?></span>
                                <span class="text-right"><?= $tmpVal ?></span>
                            </li>
                        <? endif; ?>
                        <? endforeach ?>
                    </ul>
                </div>
                <div class="tab">
                    <script type="text/javascript" src="//dev.mneniya.pro/js/itpromru/mneniyafeed.js"></script>
                    <div id="mneniyapro_feed"><a href="//mneniya.pro">Mneniya.Pro</a></div>
                    <? //if ('Y' == $arParams['USE_COMMENTS']){?>
                    <? //$APPLICATION->IncludeComponent(
                    //        "bitrix:catalog.comments",
                    //        "comments",
                    //        array(
                    //          "ELEMENT_ID" => $arResult['ID'],
                    //          "ELEMENT_CODE" => "",
                    //          "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                    //          "URL_TO_COMMENT" => "",
                    //          "WIDTH" => "800",
                    //          "COMMENTS_COUNT" => "5",
                    //          "BLOG_USE" => $arParams['BLOG_USE'],
                    //          "FB_USE" => $arParams['FB_USE'],
                    //          "FB_APP_ID" => $arParams['FB_APP_ID'],
                    //          "VK_USE" => $arParams['VK_USE'],
                    //          "VK_API_ID" => $arParams['VK_API_ID'],
                    //          "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                    //          "CACHE_TIME" => $arParams['CACHE_TIME'],
                    //          "BLOG_TITLE" => "",
                    //          "BLOG_URL" => $arParams['BLOG_URL'],
                    //          "PATH_TO_SMILE" => "",
                    //          "EMAIL_NOTIFY" => "N",
                    //          "AJAX_POST" => "Y",
                    //          "SHOW_SPAM" => "Y",
                    //          "SHOW_RATING" => "N",
                    //          "FB_TITLE" => "",
                    //          "FB_USER_ADMIN_ID" => "",
                    //          "FB_COLORSCHEME" => "light",
                    //          "FB_ORDER_BY" => "reverse_time",
                    //          "VK_TITLE" => "",
                    //          "TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
                    //        ),
                    //        $component,
                    //        array("HIDE_ICONS" => "Y")
                    //      );?>
                    <? //}?>
                </div>
                <div class="tab" id="access">

                </div>
            </div>
        </div>


        <script type="text/javascript">
            $(document).ready(function () {
                $("a.fancyimages").fancybox();
            });
        </script>

        <script type="text/javascript">
            $(function () {
                $(".btn-basket, .btn-credit").on("click", function () {
                    var wareId = $(this).data("wareid");
                    if (isNaN(wareId)) {
                        return false;
                    }
                    var url = "<?=SITE_TEMPLATE_PATH?>/ajax/buy.php",
                        price = $(".price-val").text().replace(' ', ''),
                        options = $(".options input:checked").map(function () {
                            return $(this).data("optid");
                        }).get(),
                        params = {id: wareId, cost: price, options: options};
                    if ($(this).is(".btn-credit")) $.extend(params, {credit: "<?=GetMessage("WF_CREDIT_BUY3")?>"});
                    $.post(url, params, function () {
                        location.href = "<?=$arParams["BASKET_URL"]?>";
                    });
                });
                $(".offers :radio").on("change", function () {
                    var torgId = $(".offers input:checked").data("offerid"),
                        price = $(".offers input:checked").val(),
                        oldprice = $(".price-val").text().replace(' ', '');
                    $(".btn-basket, .btn-credit").data("wareid", torgId);
                    if ($(".options li").length > 0) {
                        $(".price-val").text(price);
                        optionsClicked();
                    }
                    else {
                        var separator = $.animateNumber.numberStepFactories.separator(' ');
                        $('.price-val').prop("number", oldprice).animateNumber({number: price, numberStep: separator});
                    }
                });
            });
            BX.message({
                MESS_BTN_BUY: '<?= ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
                MESS_BTN_ADD_TO_BASKET: '<?= ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
                MESS_NOT_AVAILABLE: '<?= ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
                TITLE_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
                TITLE_BASKET_PROPS: '<?= GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
                BASKET_UNKNOWN_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
                BTN_SEND_PROPS: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
                BTN_MESSAGE_CLOSE: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>',
                SITE_ID: '<?= SITE_ID; ?>'
            });
        </script>
    </div>
<? $GLOBALS["catdets"] = $arResult["ID"]; ?>