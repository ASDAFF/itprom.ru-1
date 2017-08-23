<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if($USER->IsAuthorized()):?>
  <p><?= GetMessage("MAIN_REGISTER_AUTH")?></p>
<?else:?>
  <a href="#" class="btn-close-type01">&nbsp;</a>
  <span class="title"><?= GetMessage("AUTH_REGISTER")?></span>
  <form class="input-form" method="post" action="<?=SITE_TEMPLATE_PATH?>/ajax/register.php" name="regform">
    <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
    <input type="hidden" value="REGISTRATION" name="TYPE"/>
    <fieldset>
      <div class="row">
        <label><?= GetMessage("REGISTER_FIELD_NAME")?></label>
        <span class="input-type01">
          <input size="30" type="text" name="REGISTER[NAME]" value="<?=$arResult["VALUES"]["NAME"]?>" class=""/>
        </span>
      </div>
      <div class="row">
        <label><?= GetMessage("REGISTER_FIELD_PERSONAL_PHONE")?>:</label>
        <span class="input-type01">
          <input size="30" type="text" name="REGISTER[PERSONAL_PHONE]" value="<?=$arResult["VALUES"]["PERSONAL_PHONE"]?>" class="phone-input"/>
        </span>
      </div>
      <div class="row">
        <label><?= GetMessage("REGISTER_FIELD_EMAIL")?>:</label>
        <span class="input-type01">
          <input class="wf_login" size="30" type="text" name="REGISTER[LOGIN]" value="<?=$arResult["VALUES"]["PASSWORD"]?>">
          <input class="wf_email" type="hidden" name="REGISTER[EMAIL]" value="<?=$arResult["VALUES"]["EMAIL"]?>">
        </span>
      </div>
      <div class="row">
        <label><?= GetMessage("REGISTER_FIELD_PASSWORD")?>:</label>
        <span class="input-type01">
          <input size="30" type="password" name="REGISTER[PASSWORD]" value="<?=$arResult["VALUES"]["PASSWORD"]?>" autocomplete="off"/>
        </span>
      </div>
      <div class="row">
        <label><?= GetMessage("REGISTER_FIELD_CONFIRM_PASSWORD")?>:</label>
        <span class="input-type01">
          <input size="30" type="password" name="REGISTER[CONFIRM_PASSWORD]" value="<?=$arResult["VALUES"]["CONFIRM_PASSWORD"]?>" autocomplete="off" />
        </span>
      </div>
      <?if ($arParams["USE_CAPTCHA"] == "Y"){?>
        <div class="row">
          <label><?=GetMessage("REGISTER_CAPTCHA_TITLE")?>:</label>
          <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
          <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
          <span class="input-type01">
            <input type="text" name="captcha_word" maxlength="50" value="" />
          </span>
        </div>
      <?}?>
      <div class="row row-link">
        <?=GetMessage("WF_CONFIDENTIAL_POLICY")?><a href="#"><?=GetMessage("WF_CONFIDENTIAL_POLICY2")?></a>
      </div>
      <div class="row-btn-f">
        <input type="button" class="btn-input" name="reg_submit_button" value="<?=GetMessage("WF_REG_ME")?>" onClick="setEmailAndSubmit();"/>
        <input type="hidden" name="register_submit_button" value="1"/>
      </div>
      <!--div class="social-box">
        <span class="title-sicial"><?=GetMessage("WF_SOCIAL_REG")?></span>
        <?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "login", array(
          "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
          "SUFFIX" => "form",
            ), $component, array("HIDE_ICONS" => "Y")
          );
        ?>
      </div-->
    </fieldset>
  </form>
  <small class="notification"><?= $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></small>
  <script type="text/javascript">
    function setEmailAndSubmit(){
      $(".wf_email").val($(".wf_login").val());
      $("[name='regform']").submit();
    }
  </script>
<?endif?>