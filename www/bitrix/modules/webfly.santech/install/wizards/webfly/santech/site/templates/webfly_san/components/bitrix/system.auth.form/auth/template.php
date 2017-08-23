<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
  <? if ($arResult["FORM_TYPE"] == "login"){ 
    if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']) ShowMessage($arResult['ERROR_MESSAGE']);?>
    <a href="#" class="btn-close-type01">&nbsp;</a>
    <span class="title"><?= GetMessage("WF_LOGIN_SITE")?></span>
    <form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>" class="input-form">
      <? if ($arResult["BACKURL"] <> ''): ?>
        <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>" />
      <? endif ?>
      <? foreach ($arResult["POST"] as $key => $value): ?>
        <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
      <? endforeach ?>
      <input type="hidden" name="AUTH_FORM" value="Y" />
      <input type="hidden" name="TYPE" value="AUTH" />
      <fieldset>
        <div class="row">
          <label><?= GetMessage("AUTH_LOGIN")?>:</label>
          <span class="input-type01">
            <input type="text" name="USER_LOGIN" maxlength="50" value="<?= $arResult["USER_LOGIN"] ?>" size="17" />
          </span>
        </div>
        <div class="row">
          <label><?= GetMessage("AUTH_PASSWORD")?>:</label>
          <span class="input-type01">
            <input type="password" name="USER_PASSWORD" maxlength="50" size="17" />
          </span>
          <? if ($arResult["SECURE_AUTH"]): ?>
            <span class="bx-auth-secure" id="bx_auth_secure<?= $arResult["RND"] ?>" title="<?= GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
              <div class="bx-auth-secure-icon"></div>
            </span>
            <noscript>
            <span class="bx-auth-secure" title="<?= GetMessage("AUTH_NONSECURE_NOTE") ?>">
              <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
            </span>
            </noscript>
            <script type="text/javascript">
              document.getElementById('bx_auth_secure<?= $arResult["RND"] ?>').style.display = 'inline-block';
            </script>
          <? endif ?>
        </div>
        <div class="row-btn-f">
          <input type="submit" name="Login" value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>" class="btn-input"/>
        </div>
        
        <div class="row row-link">
          <? if ($arResult["NEW_USER_REGISTRATION"] == "Y"): ?>
            <noindex><a href="<?= $arResult["AUTH_REGISTER_URL"]?>" class="align-left" rel="nofollow"><?= GetMessage("AUTH_REGISTER") ?></a></noindex>
          <? endif ?>
          <noindex><a href="<?= $arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="align-right" rel="nofollow"><?= GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex>
        </div>
        <? if ($arResult["AUTH_SERVICES"]): ?>
          <div class="social-box">
            <span class="title-sicial"><?= GetMessage("socserv_as_user_form") ?></span>
            <?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "login", array(
                  "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
                  "SUFFIX" => "form",
                      ), $component, array("HIDE_ICONS" => "Y")
              );
            ?>
          </div>
        <? endif ?>
      </fieldset>
    </form>

    <? if ($arResult["AUTH_SERVICES"]){
      $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", array(
          "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
          "AUTH_URL" => $arResult["AUTH_URL"],
          "POST" => $arResult["POST"],
          "POPUP" => "Y",
          "SUFFIX" => "form",
          ), $component, array("HIDE_ICONS" => "Y")
      );
    }
//if($arResult["FORM_TYPE"] == "login")
  }else{?>
    <form action="<?= $arResult["AUTH_URL"] ?>">
		<a href="#" class="link-authorized" title="<?= GetMessage("AUTH_PROFILE") ?>"><?= $arResult["USER_NAME"]?> [<?= $arResult["USER_LOGIN"] ?>]</a>
      <? foreach ($arResult["GET"] as $key => $value): ?>
        <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
      <? endforeach ?>
        <input type="hidden" name="logout" value="yes" />


	 		<div class="popup-input popup-authorized">
        <a href="#" class="btn-close-type01">&nbsp;</a>
        <ul>
          <li><a href="<?=SITE_DIR?>personal/order/">История заказов</a></li>
          <li><a href="<?=SITE_DIR?>personal/profile/">Профили покупателя</a></li>
          <li><a href="<?=SITE_DIR?>personal/">Настройки пользователя</a></li>
          <li><a href="<?=SITE_DIR?>personal/subscribe/">Настройки рассылок</a></li>
        </ul>
				<input type="submit" name="logout_butt" class="btn-input" value="<?= GetMessage("AUTH_LOGOUT_BUTTON") ?>" />
      </div>
		</form>
  <?}?>


