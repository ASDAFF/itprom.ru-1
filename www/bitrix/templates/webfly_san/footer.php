<? IncludeTemplateLangFile(__FILE__); ?>
<? if (isset($GLOBALS["catdets"])): ?>
    <div class="wrapper">
        <div class="bottomprods">
            <div class="clearboth"></div>
            <div id="linkedproducts">
                <? $APPLICATION->IncludeComponent(
	"bitrix:sale.recommended.products", 
	".default", 
	array(
		"ID" => $ElementID,
		"MIN_BUYES" => "1",
		"DETAIL_URL" => $arResult["DETAIL_PAGE_URL"],
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"ELEMENT_COUNT" => "5",
		"LINE_ELEMENT_COUNT" => "5",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "4",
		"CODE" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_NAME" => "Y",
		"SHOW_IMAGE" => "Y",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"PAGE_ELEMENT_COUNT" => "30",
		"TEMPLATE_THEME" => "blue",
		"SHOW_OLD_PRICE" => "N",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"PROPERTY_CODE_4" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_4" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_4" => "MORE_PHOTO",
		"LABEL_PROP_4" => "-",
		"PROPERTY_CODE_3" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_3" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
		"OFFER_TREE_PROPS_3" => array(
		)
	),
	false
); ?>
                <? /*$APPLICATION->IncludeComponent(
            "bitrix:catalog.recommended.products",
            "detail",
            Array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "4",
                "ID" => 63870,
                "CODE" => $_REQUEST["PRODUCT_CODE"],
                "PROPERTY_LINK" => "RECOMMEND",
                "OFFERS_PROPERTY_LINK" => "RECOMMEND",
                "HIDE_NOT_AVAILABLE" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "PRODUCT_SUBSCRIPTION" => "N",
                "SHOW_NAME" => "Y",
                "SHOW_IMAGE" => "Y",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "PAGE_ELEMENT_COUNT" => "30",
                "LINE_ELEMENT_COUNT" => "3",
                "TEMPLATE_THEME" => "blue",
                "DETAIL_URL" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "86400",
                "SHOW_OLD_PRICE" => "N",
                "PRICE_CODE" => array(0=>"BASE",),
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "CONVERT_CURRENCY" => "Y",
                "CURRENCY_ID" => "RUB",
                "BASKET_URL" => "/personal/basket.php",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "USE_PRODUCT_QUANTITY" => "Y",
                "SHOW_PRODUCTS_28" => "Y",
                "PROPERTY_CODE_28" => array("WIDTH", "LENGHT"),
                "CART_PROPERTIES_28" => array("SIZE"),
                "ADDITIONAL_PICT_PROP_28" => "MORE_PHOTO",
                "LABEL_PROP_28" => "SPECIALOFFER",
                "PROPERTY_CODE_29" => array("SIZE", "COLOR"),
                "CART_PROPERTIES_29" => array("SIZE"),
                "OFFER_TREE_PROPS_29" => array("SIZE")
            )
        );*/ ?>
            </div>
        </div>
    </div>
<? endif; ?>

<!--    Bottom info here -->
<div class="wrapper info-wrapper">
    <div class="information-block" itemscope itemtype="http://schema.org/Organization">
        <div class="col-left">
            <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/footer/site.php")); ?>
            <p style="margin-top: 25px;"><a href="http://seocontext.su"
                                            target="_blank"><?= GetMessage("WF_DEVELOPMENT") ?></a>:<br/>
                SeoContext.su</p>
        </div>
        <div class="contacts">
            <div class="col20">
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/footer/social.php")); ?>
            </div>
            <div class="col20">
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/footer/paytext.php")); ?>
            </div>
            <div class="col20">
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/footer/callblock.php")); ?>
                <p><span class="small-text"><noindex><a rel="nofollow"
                                                        href="#"><?= GetMessage("WF_FOOTER_CALL_ME"); ?></a>
                        </noindex></span></p>
            </div>
        </div>
        <div class="text">
            <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/footer/disclaimer.php")); ?>
        </div>
    </div>
    <div class="google">
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-45630528-7', 'auto');
            ga('send', 'pageview');

        </script>
    </div>
    <div class="yandex">
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function () {
                    try {
                        w.yaCounter32630115 = new Ya.Metrika({
                            id: 32630115,
                            webvisor: true,
                            clickmap: true,
                            trackLinks: true,
                            accurateTrackBounce: true
                        });
                    } catch (e) {
                    }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () {
                        n.parentNode.insertBefore(s, n);
                    };
                s.type = "text/javascript";
                s.async = true;
                s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else {
                    f();
                }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript>
            <div><img src="//mc.yandex.ru/watch/32630115" style="position:absolute; left:-9999px;" alt=""/></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->
    </div>
</div>
<!-- Footer fixed -->
<div class="footer-row">

    <div class="footer-center">
        <div id="footer-feedback-container" class="block-feedback">
            <?
            $frame = new \Bitrix\Main\Page\FrameBuffered("footer-feedback-container", false);
            $frame->begin('');
            ?>
            <a href="#" class="link-feedback"><span><?= GetMessage("WF_FOOTER_FEEDBACK"); ?></span></a>
            <div class="popup-feedback" mode="" mode-mess="">
                <? $APPLICATION->IncludeComponent(
                    "webfly:message.add",
                    "main_feed",
                    array(
                        "OK_TEXT" => GetMessage("WF_OK_TEXT"),
                        "EMAIL_TO" => "info@itprom.ru",
                        "IBLOCK_TYPE" => "feedback",
                        "IBLOCK_ID" => "8",
                        "EVENT_MESSAGE_ID" => array(
                            0 => "7",
                            1 => "38",
                        ),
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "SET_TITLE" => "N",
                        "COMPONENT_TEMPLATE" => "main_feed"
                    ),
                    false
                ); ?>


            </div>
            <?
            $frame->end();
            ?>
        </div>
        <div id="bx-composite-banner" style="float: left"></div>
        <div id="footer-right-container">
            <?
            $frame = new \Bitrix\Main\Page\FrameStatic("footer-dynamic");
            $frame->setAnimation(true);
            $frame->setStub("");
            $frame->setContainerId("footer-right-container");
            $frame->startDynamicArea();
            ?>
            <span class="link-top-hold">
          <a href="#" class="link-top"> </a>
          <span class="arrow-grey"> </span>
        </span>
            <? $APPLICATION->IncludeComponent(
                "bitrix:sale.basket.basket.line",
                "footer",
                Array(
                    "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                    "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                    "SHOW_PERSONAL_LINK" => "N",
                    "SHOW_NUM_PRODUCTS" => "Y",
                    "SHOW_TOTAL_PRICE" => "Y",
                    "SHOW_EMPTY_VALUES" => "N",
                    "SHOW_PRODUCTS" => "N",
                    "POSITION_FIXED" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",

                )
            ); ?>
            <ul class="info">
                <?
                $ant = $APPLICATION->GetCurDir();
                if (substr_count($ant, "/catalog/") > 0) $showCompare = true;
                else $showCompare = false;
                $Fav = new wfHighLoadBlock("3");
                $favList = $Fav->elemGet();
                $favCount = count($favList);
                ?>
                <li <?= ($showCompare ? '' : 'style="border-right: 1px solid #c2c2c2"') ?>>
                    <a href="<?= SITE_DIR ?>favorites/"><?= GetMessage("WF_FAVORITES") ?>:</a>
                    <? if ($favCount > 0): ?>
                        <span class="favCount favCount--active"><?= $favCount ?></span>
                    <? else: ?>
                        <span class="favCount">0</span>
                    <? endif; ?>
                    <span id="fav" class="add-block new"> <?= GetMessage("WF_FAVORITES_ADDED") ?> </span>
                </li>
                <? if ($showCompare) {
                    $APPLICATION->ShowViewContent("wf_compare_list");
                }
                ?>
            </ul>
            <?
            $frame->finishDynamicArea();
            ?>
        </div>
    </div>
</div>

<!-- Other -->
<div class="bg"> </div>
<div class="bg2"> </div>
<div id="virtual" class="link-basket"></div>
<div id="virt_checked"></div>
<div class="loader_bg">
    <div class="loader" title="7">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px"
             width="60px" height="40px" viewBox="0 0 60 40" style="enable-background:new 0 0 50 50;"
             xml:space="preserve">
        <rect x="0" y="40" width="6" height="15" fill="#333" opacity="0.2">
            <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0s" dur="0.75s"
                     repeatCount="indefinite"/>
            <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0s" dur="0.75s"
                     repeatCount="indefinite"/>
            <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0s" dur="0.75s"
                     repeatCount="indefinite"/>
        </rect>
            <rect x="12" y="40" width="6" height="15" fill="#333" opacity="0.2">
                <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.15s" dur="0.75s"
                         repeatCount="indefinite"/>
                <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0.15s" dur="0.75s"
                         repeatCount="indefinite"/>
                <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0.15s" dur="0.75s"
                         repeatCount="indefinite"/>
            </rect>
            <rect x="24" y="40" width="6" height="15" fill="#333" opacity="0.2">
                <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.3s" dur="0.75s"
                         repeatCount="indefinite"/>
                <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0.3s" dur="0.75s"
                         repeatCount="indefinite"/>
                <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0.3s" dur="0.75s"
                         repeatCount="indefinite"/>
            </rect>
            <rect x="36" y="40" width="6" height="15" fill="#333" opacity="0.2">
                <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.45s" dur="0.75s"
                         repeatCount="indefinite"/>
                <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0.45s" dur="0.75s"
                         repeatCount="indefinite"/>
                <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0.45s" dur="0.75s"
                         repeatCount="indefinite"/>
            </rect>
            <rect x="48" y="40" width="6" height="15" fill="#333" opacity="0.2">
                <animate attributeName="opacity" attributeType="XML" values="0.2; 1; .2" begin="0.6s" dur="0.75s"
                         repeatCount="indefinite"/>
                <animate attributeName="height" attributeType="XML" values="15; 30; 15" begin="0.6s" dur="0.75s"
                         repeatCount="indefinite"/>
                <animate attributeName="y" attributeType="XML" values="10; 10; 10" begin="0.6s" dur="0.75s"
                         repeatCount="indefinite"/>
            </rect>
      </svg>
    </div>
</div>
</body>
</html>