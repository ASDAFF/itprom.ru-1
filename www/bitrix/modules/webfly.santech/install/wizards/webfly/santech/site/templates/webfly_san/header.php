<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?
IncludeTemplateLangFile(__FILE__);
require_once 'settings.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <? $url = $APPLICATION->GetCurDir();
    $APPLICATION->ShowHead(); ?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/all.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/change.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.jscrollpane.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/themes/backgrounds.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.tiles.css");?>
    <?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/pult.css");?>
    <?php
    if(!empty($WF_Settings["theme"]) and ($WF_Settings["theme"]!="default")){
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/themes/{$WF_Settings["theme"]}-bg.css");
    }
    if(!empty($WF_Settings["buttons"])){
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/themes/{$WF_Settings["buttons"]}-buttons.css");
    }
    if(!empty($WF_Settings["shadows"]) and ($WF_Settings["shadows"]!="default")){
      $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/themes/noshadow.css");
    }
    ?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-1.11.1.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-migrate-1.2.1.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-ui-1.9.2.custom.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/clear-form-fields.js");?>
    <?if($url != '/personal/order/make/'):?>
      <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/form.js");?>
    <?endif;?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.mousewheel.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.jscrollpane.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/respond.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.tiles.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.maskedinput.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.easing.1.3.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/accounting.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/site.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/hammer.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/hammer.jquery.min.js");?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/pult.js");?>
    <?if(!empty($_POST["pult_theme"])):?>
      <script type="text/javascript">
        $(function(){
          $(".pult").find(".icon-gear").click();
          $(".icon-default").addClass("icon-active");
        });
      </script>
    <?endif?>
  </head>
  <body <?if(!empty($WF_Settings["bg"]) and ($WF_Settings["bg"] != "default")):?> class="<?=$WF_Settings["bg"]?>"<?endif?>>
    <div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
    <?if($USER->IsAdmin()):?>
      <div class="pult">
        <span class="icon-gear" title="<?=GetMessage("WF_SELECT_THEME")?>"></span>
        <form method="POST" action="<?=SITE_TEMPLATE_PATH?>/ajax/pult.php" name="pult_form">
          <button class="icon-default" type="button" title="<?=GetMessage("WF_RESET_TO_DEFAULTS")?>"></button>
          <h4><?=GetMessage("WF_SELECT_THEME")?>:</h4>
          <label for="sky" class="pultLabel"><input type="radio" class="superIgnore" name="pult_theme" id="sky" value="default" <?if($WF_Settings["theme"] == "default"):?> checked <?endif?>/><span class="sky"><?=GetMessage("WF_THEME_SKY")?></span></label>
          <label for="sunny" class="pultLabel"><input type="radio" class="superIgnore" name="pult_theme" id="sunny" value="sunny" <?if($WF_Settings["theme"] == "sunny"):?> checked <?endif?>/><span class="sunny"><?=GetMessage("WF_THEME_SUNNY")?></span></label>
          <label for="sweet" class="pultLabel"><input type="radio" class="superIgnore" name="pult_theme" id="sweet" value="sweet" <?if($WF_Settings["theme"] == "sweet"):?> checked <?endif?>/><span class="sweet"><?=GetMessage("WF_THEME_SWEET")?></span></label>
          <label for="coral" class="pultLabel"><input type="radio" class="superIgnore" name="pult_theme" id="coral" value="coral" <?if($WF_Settings["theme"] == "coral"):?> checked <?endif?>/><span class="coral"><?=GetMessage("WF_THEME_CORAL")?></span></label>
          <div class="clearfix"></div>
          <h4><?=GetMessage("WF_ACTIVES_COLOR")?>:</h4>
          <label for="coral-active" class="pultLabel"><input type="radio" class="superIgnore" name="pult_buttons" id="coral-active" value="coral" <?if($WF_Settings["buttons"]=="coral"):?> checked <?endif?>/><span class="coral"><?=GetMessage("WF_ACTIVES_CORAL")?></span></label>
          <label for="sky-active" class="pultLabel"><input type="radio" class="superIgnore" name="pult_buttons" id="sky-active" value="sky" <?if($WF_Settings["buttons"] == "sky"):?> checked <?endif?>/><span class="sky"><?=GetMessage("WF_ACTIVES_SKY")?></span></label>
          <label for="sunny-active" class="pultLabel"><input type="radio" class="superIgnore" name="pult_buttons" id="sunny-active" value="sunny" <?if($WF_Settings["buttons"] == "sunny"):?> checked <?endif?>/><span class="sunny"><?=GetMessage("WF_ACTIVES_SUNNY")?></span></label>
          <label for="sweet-active" class="pultLabel"><input type="radio" class="superIgnore" name="pult_buttons" id="sweet-active" value="sweet" <?if($WF_Settings["buttons"] == "sweet"):?> checked <?endif?>/><span class="sweet"><?=GetMessage("WF_ACTIVES_SWEET")?></span></label>
          <div class="clearfix"></div>
          <label for="shadow" class="pultLabel shLabel"><input class="superIgnore" type="radio" name="pult_shadows" id="shadow" value="default" <?if($WF_Settings["shadows"] == "default"):?> checked <?endif?>/><span><?=GetMessage("WF_THEME_WITH_SHADOWS")?></span></label>
          <label for="noshadow" class="pultLabel shLabel"><input class="superIgnore" type="radio" name="pult_shadows" id="noshadow" value="flat" <?if($WF_Settings["shadows"]=="flat"):?> checked <?endif?>/><span><?=GetMessage("WF_THEME_FLAT")?></span></label>
          <div class="clearfix"></div>
          <h4><?=GetMessage("WF_SELECT_BACKGROUND")?>:</h4>
          <label for="bg-default" class="pultLabel bg-preview bg-default"><input class="superIgnore" type="radio" name="pult_bg" id="bg-default" value="default" <?if($WF_Settings["bg"] == "default"):?> checked <?endif?>/></label>
          <label for="agsquare" class="pultLabel bg-preview agsquare"><input class="superIgnore" type="radio" name="pult_bg" id="agsquare" value="agsquare" <?if($WF_Settings["bg"]=="agsquare"):?> checked <?endif?>/></label>
          <label for="wild_oliva" class="pultLabel bg-preview wild_oliva"><input class="superIgnore" type="radio" name="pult_bg" id="wild_oliva" value="wild_oliva" <?if($WF_Settings["bg"]=="wild_oliva"):?> checked <?endif?>/></label>
          <label for="kindajean" class="pultLabel bg-preview kindajean" style="margin-right: 0;"><input class="superIgnore" type="radio" name="pult_bg" id="kindajean" value="kindajean" <?if($WF_Settings["bg"]=="kindajean"):?> checked <?endif?>/></label>
          <div class="clearfix"></div>
          <input type="button" name="apply" class="btn-gray pult-button" value="<?=GetMessage("WF_BUTTON_APPLY")?>"/>
        </form>
      </div>
    <?endif;?>
    <!--    Fixed-header -->
    <div id="header">
      <div class="header-top">
        <div class="header-center">
          <div class="input-block">
            <?if($USER->IsAuthorized()):?>
              <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", Array(
                  "REGISTER_URL" => "",	// Страница регистрации
                  "FORGOT_PASSWORD_URL" => "",	// Страница забытого пароля
                  "PROFILE_URL" => "",	// Страница профиля
                  "SHOW_ERRORS" => "N",	// Показывать ошибки
                  ),
                  false
                );?>
            <?else:?>
              <a href="#" class="link-input"><span class="icon20px icon-enter"></span><?=GetMessage("WF_AUTH_ENTER")?></a>
              <div class="popup-input popup-enter">
                <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", Array(
                  "REGISTER_URL" => "",	// Страница регистрации
                  "FORGOT_PASSWORD_URL" => "",	// Страница забытого пароля
                  "PROFILE_URL" => SITE_DIR."personal/",	// Страница профиля
                  "SHOW_ERRORS" => "N",	// Показывать ошибки
                  ),
                  false
                );?>
              </div>
            <?endif?>
            <div class="popup-input popup-password">
              <?$APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd", "frgt", Array());?>
            </div>
            <div class="popup-input popup-registration">
              <?$APPLICATION->IncludeComponent(
                "bitrix:main.register",
                "register",
                Array(
                  "SHOW_FIELDS" => array("NAME","PERSONAL_PHONE"),
                  "REQUIRED_FIELDS" => array(),
                  "AUTH" => "Y",
                  "USE_BACKURL" => "Y",
                  "SUCCESS_PAGE" => SITE_DIR."/",
                  "SET_TITLE" => "N",
                  "USER_PROPERTY" => array(),
                  "USER_PROPERTY_NAME" => "",
                  "CACHE_TYPE" => "A",
                  "CACHE_TIME" => "36000000",
                )
              );?>
            </div>
          </div>
          <div class="help-block">
            <a href="<?=SITE_DIR?>about/"><span class="icon20px icon-help"></span><?=GetMessage("WF_HELP")?></a>
          </div>
          <?$APPLICATION->IncludeComponent("bitrix:menu", "main_top", Array(
            "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
              "MENU_CACHE_TYPE" => "A",	// Тип кеширования
              "MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
              "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
              "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
              "MAX_LEVEL" => "1",	// Уровень вложенности меню
              "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
              "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
              "DELAY" => "N",	// Откладывать выполнение шаблона меню
              "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
            ),
            false,
            array(
            "ACTIVE_COMPONENT" => "Y"
            )
          );?>
        </div>
      </div>
      <div class="header-info">
        <div class="header-center">
          <div class="col20">
            <h1 class="logo"><a href="<?=SITE_DIR?>"><?=GetMessage("WF_HEADER_MAG");?></a></h1>
          </div>
          <div class="col20">
            <span class="header-phone">  
              <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/header/tel.php"));?>
            </span>
          </div>
          <div class="col20">
            <span class="header-phone">
              <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/header/8800.php"));?>
              <span class="small-text"><a href="#"><?=GetMessage("WF_HEADER_CALL_ME");?></a></span>
            </span>
          </div>
          <div class="col20 small-text">
            <span class="icon40px icon-time"></span>
            <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/header/tel_calls.php"));?>
          </div>
          <div class="col20 small-text">
            <span class="icon40px icon-dostavka"></span>
            <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/header/delivery.php"));?>
          </div>
        </div>
      </div>
    </div>
    <!--    Navigation -->
    <div class="wrapper nav-wrapper">
      <div class="line-top-colors"></div>
      <?$APPLICATION->IncludeComponent("bitrix:menu", "rubrikator", Array(
        "ROOT_MENU_TYPE" => "catalog",	// Тип меню для первого уровня
        "MENU_CACHE_TYPE" => "A",	// Тип кеширования
        "MENU_CACHE_TIME" => "604800",	// Время кеширования (сек.)
        "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
        "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
        "MAX_LEVEL" => "2",
        "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
        "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
        "DELAY" => "N",	// Откладывать выполнение шаблона меню
        "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
        "INCLUDE_JQUERY" => "Y",	// Подключить JQuery из ядра
        "VIEW_HIT" => "Y",	// Выводить лидеров просмотров
        "PRICE_CODE" => "BASE",	// Тип цены для лидеров просмотров
        "CURRENCY" => "RUB",	// Валюта для цены лидеров просмотров
        ),
        false
      );?>
      <?$APPLICATION->IncludeComponent("bitrix:search.title","stitle",Array(
        "SHOW_INPUT" => "Y",
        "INPUT_ID" => "title-search-input",
        "CONTAINER_ID" => "title-search",
        "PRICE_CODE" => array("BASE","RETAIL"),
        "PRICE_VAT_INCLUDE" => "Y",
        "PREVIEW_TRUNCATE_LEN" => "150",
        "SHOW_PREVIEW" => "Y",
        "PREVIEW_WIDTH" => "75",
        "PREVIEW_HEIGHT" => "75",
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
        "PAGE" => SITE_DIR."search/index.php",
        "NUM_CATEGORIES" => "3",
        "TOP_COUNT" => "10",
        "ORDER" => "date",
        "USE_LANGUAGE_GUESS" => "Y",
        "CHECK_DATES" => "Y",
        "SHOW_OTHERS" => "Y",
        "CATEGORY_0_TITLE" => "Новости",
        "CATEGORY_0" => array("iblock_news"),
        "CATEGORY_0_iblock_news" => array("all"),
        "CATEGORY_1_TITLE" => "Форумы",
        "CATEGORY_1" => array("forum"),
        "CATEGORY_1_forum" => array("all"),
        "CATEGORY_2_TITLE" => "Каталоги",
        "CATEGORY_2" => array("iblock_books"),
        "CATEGORY_2_iblock_books" => "all",
        "CATEGORY_OTHERS_TITLE" => "Прочее"
      )
      );?>
    </div>