<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?

IncludeTemplateLangFile(__FILE__);
require_once 'settings.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? $url = $APPLICATION->GetCurDir();
    $APPLICATION->ShowHead(); ?>
    <title><? $APPLICATION->ShowTitle() ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/all.css"); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/change.css"); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/jquery.jscrollpane.css"); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/themes/backgrounds.css"); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/jquery.tiles.css"); ?>
    <? $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/pult.css"); ?>
    <?php
    if (!empty($WF_Settings["theme"]) and ($WF_Settings["theme"] != "default")) {
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/themes/{$WF_Settings["theme"]}-bg.css");
    }
    if (!empty($WF_Settings["buttons"])) {
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/themes/{$WF_Settings["buttons"]}-buttons.css");
    }
    if (!empty($WF_Settings["shadows"]) and ($WF_Settings["shadows"] != "default")) {
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/themes/noshadow.css");
    }
    ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery-1.11.1.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery-migrate-1.2.1.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery-ui-1.9.2.custom.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/clear-form-fields.js"); ?>

    <? if ($url != '/personal/order/make/'): ?>
        <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/form.js"); ?>
    <? endif; ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.mousewheel.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.jscrollpane.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/respond.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.tiles.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.maskedinput.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.easing.1.3.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/accounting.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jquery.animateNumber.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/site.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/hammer.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/hammer.jquery.min.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/pult.js"); ?>
    <? $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "/js/jcarousellite.min.js"); ?>

    <? if (!empty($_POST["pult_theme"])): ?>
        <script type="text/javascript">
            $(function () {
                $(".pult").find(".icon-gear").click();
                $(".icon-default").addClass("icon-active");
            });
        </script>
    <? endif ?>

    <?
    //////////////////
    // Fancy Boxing //
    $APPLICATION->AddHeadScript('https://code.jquery.com/jquery-latest.min.js');
    $fancypath = '/bitrix/templates/webfly_san/js/fancybox/';

    $APPLICATION->AddHeadScript($fancypath . "lib/jquery.mousewheel-3.0.6.pack.js");
    $APPLICATION->AddHeadScript($fancypath . 'source/jquery.fancybox.pack.js?v=2.1.5');
    $APPLICATION->SetAdditionalCSS($fancypath . 'source/jquery.fancybox.css?v=2.1.5');
    //helpers etc
    $APPLICATION->SetAdditionalCSS($fancypath . 'source/helpers/jquery.fancybox-buttons.css?v=1.0.5');
    $APPLICATION->AddHeadScript($fancypath . "source/helpers/jquery.fancybox-buttons.js?v=1.0.5");
    $APPLICATION->AddHeadScript($fancypath . "source/helpers/jquery.fancybox-media.js?v=1.0.6");

    $APPLICATION->SetAdditionalCSS($fancypath . 'source/helpers/jquery.fancybox-thumbs.css?v=1.0.7');
    $APPLICATION->AddHeadScript($fancypath . "source/helpers/jquery.fancybox-thumbs.js?v=1.0.7");
    ?>

</head>
<body <? if (!empty($WF_Settings["bg"]) and ($WF_Settings["bg"] != "default")): ?> class="<?= $WF_Settings["bg"] ?>"<? endif ?>>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<? if ($USER->IsAdmin()): ?>
    <div class="pult">
        <span class="icon-gear" title="<?= GetMessage("WF_SELECT_THEME") ?>"></span>
        <form method="POST" action="<?= SITE_TEMPLATE_PATH ?>/ajax/pult.php" name="pult_form">
            <button class="icon-default" type="button" title="<?= GetMessage("WF_RESET_TO_DEFAULTS") ?>"></button>
            <h4><?= GetMessage("WF_SELECT_THEME") ?>:</h4>
            <label for="sky" class="pultLabel"><input type="radio" class="superIgnore" name="pult_theme" id="sky"
                                                      value="default" <? if ($WF_Settings["theme"] == "default"): ?> checked <? endif ?>/><span
                    class="sky"><?= GetMessage("WF_THEME_SKY") ?></span></label>
            <label for="sunny" class="pultLabel"><input type="radio" class="superIgnore" name="pult_theme" id="sunny"
                                                        value="sunny" <? if ($WF_Settings["theme"] == "sunny"): ?> checked <? endif ?>/><span
                    class="sunny"><?= GetMessage("WF_THEME_SUNNY") ?></span></label>
            <label for="sweet" class="pultLabel"><input type="radio" class="superIgnore" name="pult_theme" id="sweet"
                                                        value="sweet" <? if ($WF_Settings["theme"] == "sweet"): ?> checked <? endif ?>/><span
                    class="sweet"><?= GetMessage("WF_THEME_SWEET") ?></span></label>
            <label for="coral" class="pultLabel"><input type="radio" class="superIgnore" name="pult_theme" id="coral"
                                                        value="coral" <? if ($WF_Settings["theme"] == "coral"): ?> checked <? endif ?>/><span
                    class="coral"><?= GetMessage("WF_THEME_CORAL") ?></span></label>
            <div class="clearfix"></div>
            <h4><?= GetMessage("WF_ACTIVES_COLOR") ?>:</h4>
            <label for="coral-active" class="pultLabel"><input type="radio" class="superIgnore" name="pult_buttons"
                                                               id="coral-active"
                                                               value="coral" <? if ($WF_Settings["buttons"] == "coral"): ?> checked <? endif ?>/><span
                    class="coral"><?= GetMessage("WF_ACTIVES_CORAL") ?></span></label>
            <label for="sky-active" class="pultLabel"><input type="radio" class="superIgnore" name="pult_buttons"
                                                             id="sky-active"
                                                             value="sky" <? if ($WF_Settings["buttons"] == "sky"): ?> checked <? endif ?>/><span
                    class="sky"><?= GetMessage("WF_ACTIVES_SKY") ?></span></label>
            <label for="sunny-active" class="pultLabel"><input type="radio" class="superIgnore" name="pult_buttons"
                                                               id="sunny-active"
                                                               value="sunny" <? if ($WF_Settings["buttons"] == "sunny"): ?> checked <? endif ?>/><span
                    class="sunny"><?= GetMessage("WF_ACTIVES_SUNNY") ?></span></label>
            <label for="sweet-active" class="pultLabel"><input type="radio" class="superIgnore" name="pult_buttons"
                                                               id="sweet-active"
                                                               value="sweet" <? if ($WF_Settings["buttons"] == "sweet"): ?> checked <? endif ?>/><span
                    class="sweet"><?= GetMessage("WF_ACTIVES_SWEET") ?></span></label>
            <div class="clearfix"></div>
            <label for="shadow" class="pultLabel shLabel"><input class="superIgnore" type="radio" name="pult_shadows"
                                                                 id="shadow"
                                                                 value="default" <? if ($WF_Settings["shadows"] == "default"): ?> checked <? endif ?>/><span><?= GetMessage("WF_THEME_WITH_SHADOWS") ?></span></label>
            <label for="noshadow" class="pultLabel shLabel"><input class="superIgnore" type="radio" name="pult_shadows"
                                                                   id="noshadow"
                                                                   value="flat" <? if ($WF_Settings["shadows"] == "flat"): ?> checked <? endif ?>/><span><?= GetMessage("WF_THEME_FLAT") ?></span></label>
            <div class="clearfix"></div>
            <h4><?= GetMessage("WF_SELECT_BACKGROUND") ?>:</h4>
            <label for="bg-default" class="pultLabel bg-preview bg-default"><input class="superIgnore" type="radio"
                                                                                   name="pult_bg" id="bg-default"
                                                                                   value="default" <? if ($WF_Settings["bg"] == "default"): ?> checked <? endif ?>/></label>
            <label for="agsquare" class="pultLabel bg-preview agsquare"><input class="superIgnore" type="radio"
                                                                               name="pult_bg" id="agsquare"
                                                                               value="agsquare" <? if ($WF_Settings["bg"] == "agsquare"): ?> checked <? endif ?>/></label>
            <label for="wild_oliva" class="pultLabel bg-preview wild_oliva"><input class="superIgnore" type="radio"
                                                                                   name="pult_bg" id="wild_oliva"
                                                                                   value="wild_oliva" <? if ($WF_Settings["bg"] == "wild_oliva"): ?> checked <? endif ?>/></label>
            <label for="kindajean" class="pultLabel bg-preview kindajean" style="margin-right: 0;"><input
                    class="superIgnore" type="radio" name="pult_bg" id="kindajean"
                    value="kindajean" <? if ($WF_Settings["bg"] == "kindajean"): ?> checked <? endif ?>/></label>
            <div class="clearfix"></div>
            <input type="hidden" name="curUrl" value="<?= $APPLICATION->GetCurDir() ?>"/>
            <input type="button" name="apply" class="btn-gray pult-button"
                   value="<?= GetMessage("WF_BUTTON_APPLY") ?>"/>
        </form>
    </div>
<? endif ?>
<!--    Fixed-header -->
<div <? if (!$USER->IsAuthorized()) echo "class='fixed'" ?> id="header">
    <div class="header-top">
        <div class="header-center">
            <div id="auth-container" class="input-block">
                <?
                $frame = new \Bitrix\Main\Page\FrameBuffered("auth-container", false);
                $frame->begin('');
                ?>
                <? if ($USER->IsAuthorized()): ?>
                    <? $APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", Array(
                        "REGISTER_URL" => "",
                        "FORGOT_PASSWORD_URL" => "",
                        "PROFILE_URL" => "",
                        "SHOW_ERRORS" => "N",
                    ),
                        false
                    ); ?>
                <? else: ?>
                    <a href="#" class="link-input"><span
                            class="icon20px icon-enter"></span><?= GetMessage("WF_AUTH_ENTER") ?></a>
                    <div class="popup-input popup-enter">
                        <? $APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", Array(
                            "REGISTER_URL" => "",
                            "FORGOT_PASSWORD_URL" => "",
                            "PROFILE_URL" => "/personal/",
                            "SHOW_ERRORS" => "Y",
                        ),
                            false
                        ); ?>
                    </div>
                <? endif ?>

                <div class="popup-input popup-password">
                    <? $APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd", "frgt", Array()); ?>
                </div>
                <div class="popup-input popup-registration">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.register",
                        "register",
                        Array(
                            "SHOW_FIELDS" => array("NAME", "PERSONAL_PHONE"),
                            "REQUIRED_FIELDS" => array(),
                            "AUTH" => "Y",
                            "USE_BACKURL" => "Y",
                            "SUCCESS_PAGE" => "/",
                            "SET_TITLE" => "N",
                            "USER_PROPERTY" => array(),
                            "USER_PROPERTY_NAME" => "",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                        )
                    ); ?>
                </div>
                <? $frame->end(); ?>
            </div>
            <div class="help-block">
                <a href="/about/"><span class="icon20px icon-help"></span><?= GetMessage("WF_HELP") ?></a>
            </div>
            <? $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "main_top",
                array(
                    "ROOT_MENU_TYPE" => "top",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(),
                    "MAX_LEVEL" => "2",
                    "CHILD_MENU_TYPE" => "top",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "COMPONENT_TEMPLATE" => "main_top"
                ),
                false,
                array(
                    "ACTIVE_COMPONENT" => "Y"
                )
            ); ?>
        </div>
    </div>
    <div class="header-info">
        <div class="header-center" itemscope itemtype="http://schema.org/Organization">
            <div class="col10">
                <div class="logo">
                    <? if ($url != '/'): ?>
                        <a href="/"><?= GetMessage("WF_HEADER_MAG"); ?></a>
                    <? endif ?>
                </div>
				<span style="font-size:0px;width:0px;height:0px;overflow:hidden;color:transparent;">
					<span itemprop="name">ITProm</span>
					<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
						<span itemprop="addressLocality">г. Мытищи</span>
						<span itemprop="streetAddress">д. 31, . 2 этаж, офис 201</span>
						<span itemprop="email">info@itprom.ru</span>
					</span>
				</span>
            </div>
            <? $APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"stitle", 
	array(
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "title-search",
		"PRICE_CODE" => array(
			0 => "1",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "150",
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"PAGE" => "#SITE_DIR#search/index.php",
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "10",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "Y",
		"CHECK_DATES" => "Y",
		"SHOW_OTHERS" => "Y",
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0" => array(
			0 => "no",
		),
		"CATEGORY_0_iblock_news" => array(
			0 => "all",
		),
		"CATEGORY_1_TITLE" => "",
		"CATEGORY_1" => array(
			0 => "no",
		),
		"CATEGORY_1_forum" => array(
			0 => "all",
		),
		"CATEGORY_2_TITLE" => "",
		"CATEGORY_2" => array(
			0 => "no",
		),
		"CATEGORY_2_iblock_books" => "all",
		"CATEGORY_OTHERS_TITLE" => "",
		"COMPONENT_TEMPLATE" => "stitle",
		"SEARCH_IN_TREE" => "Y",
		"CURRENCY" => "RUB",
		"EXAMPLE_ENABLE" => "N",
		"PAGE_2" => "#SITE_DIR#search/catalog.php",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "86400",
		"INCLUDE_JQUERY" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "4",
		)
	),
	false
); ?>
            <div class="col20">
            <span class="header-phone">
              <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/header/tel.php")); ?>
            </span>
            </div>
            <div class="col20 small-text">
                <span class="icon40px icon-time"></span>
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/header/tel_calls.php")); ?>
            </div>
            <div class="col20">
            <span class="header-phone">
              <? $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/header/8800.php")); ?>
            </div>
            <div class="col20 small-text">
                <span class="icon40px icon-dostavka"></span>
                <span class="callback">
						<noindex><a href="#" rel="nofollow"><?= GetMessage("WF_HEADER_CALL_ME"); ?></a></noindex>
					</span>
                <!--                --><? /* $APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR . "include/header/delivery.php")); */ ?>
            </div>
        </div>
    </div>
</div>
<? if (!$USER->IsAuthorized()): ?>
    <div id="header-z"></div>
<? endif ?>
<!--    Navigation -->
<div class="wrapper nav-wrapper">
    <div class="line-top-colors"></div>

    <? $APPLICATION->IncludeComponent("bitrix:menu", "rubrikator", array(
	"ROOT_MENU_TYPE" => "catalog",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "604800",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => "",
		"MAX_LEVEL" => "3",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"INCLUDE_JQUERY" => "Y",
		"VIEW_HIT" => "Y",
		"PRICE_CODE" => "BASE",
		"CURRENCY" => "RUB",
		"COMPONENT_TEMPLATE" => "rubrikator"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
); ?>

</div>