<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
$errorMessage = '';
if (is_array($arParams["~AUTH_RESULT"])) {
    $errorMessage = $arParams["~AUTH_RESULT"]["MESSAGE"];
} elseif ($arParams["~AUTH_RESULT"] != '') {
    $errorMessage = $arParams["~AUTH_RESULT"];
}
if (is_array($arResult['ERROR_MESSAGE'])) {
    $errorMessage = $arResult["ERROR_MESSAGE"]["MESSAGE"];
} elseif ($arResult["ERROR_MESSAGE"] != '') {
    $errorMessage = $arResult["ERROR_MESSAGE"];
}
$isStatic = ($arParams["STATIC_FORM"] !== "N") ? true : false;
?>
<div id="login<?if ($isStatic):?>-static<?endif;?>" class="fancybox-block">
    <div class="fancybox-block-caption"><?=GetMessage("AUTH_PLEASE_AUTH")?></div>
    <?if ($errorMessage != ''):?>
        <div class="callout text-center error" data-closable=""><?=$errorMessage?></div>
    <?endif;?>
    <div class="fancybox-block-wrap fancybox-block-wrap-order">
        <script>
            $(document).ready(function() {
                initValidate("#login<?if ($isStatic):?>-static<?endif;?> form");
            })
        </script>
        <form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="form" data-ajax="<?=SITE_DIR?>nl_ajax/login.php">
            <input type="hidden" name="static" value="<?=(($isStatic) ? "Y" : "N")?>" />
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="AUTH" />
            <?if (strlen($arResult["BACKURL"]) > 0):?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>
            <?foreach ($arResult["POST"] as $key => $value):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>
            <div class="relative">
                <fieldset class="together">
                    <input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" placeholder="<?=GetMessage("AUTH_LOGIN")?>">
                    <input type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" placeholder="<?=GetMessage("AUTH_PASSWORD")?>">
                    <?if($arResult["CAPTCHA_CODE"]):?>
                        <div class="table-container captha-block">
                            <div class="table-item vertical-top">
                                <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                                <input class="bx-auth-input" type="text" name="captcha_word" placeholder="<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>" maxlength="50" value="" size="15" />
                            </div>
                            <div class="table-item vertical-top text-right captha">
                                <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="125" height="45" alt="CAPTCHA" />
                            </div>
                        </div>
                    <?endif;?>
                </fieldset>
                <?if($arResult["SECURE_AUTH"]):?>
                    <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                        <div class="bx-auth-secure-icon"></div>
                    </span>
                    <noscript>
                        <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                            <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                        </span>
                    </noscript>
                    <script type="text/javascript">
                        document.getElementById('bx_auth_secure').style.display = 'inline-block';
                    </script>
                <?endif?>
                <?if ($arResult["STORE_PASSWORD"] == "Y" && 0):?>
                    <input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" /><label for="USER_REMEMBER">&nbsp;<?=GetMessage("AUTH_REMEMBER_ME")?></label>
                <?endif?>
                <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
                    <a href="#forgot" class="forgot fancybox"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
                <?endif?>
            </div>
            <input type="hidden" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
            <button type="submit" class="small-12 button small fancybox-button text-center"><?=GetMessage("AUTH_AUTHORIZE")?></button>
        </form>
    </div>
    <?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
        <div class="fancybox-block-wrap">
            <div class="text-center not-is-account"><?=GetMessage("AUTH_FIRST_ONE")?></div>
            <a href="#registration" data-href="<?=$arResult["AUTH_REGISTER_URL"]?>" data-static="registration" class="small-12 button small fancybox-button text-center secondary <?if (!$isStatic):?>fancybox<?endif;?> show-static"><?=GetMessage("AUTH_REGISTER")?></a>
        </div>
    <?endif?>

    <?if($arResult["AUTH_SERVICES"]):?>
    <?
    $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
        array(
            "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
            "CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
            "AUTH_URL" => $arResult["AUTH_URL"],
            "POST" => $arResult["POST"],
            "SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
            "FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
            "AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
        ),
        $component,
        array("HIDE_ICONS"=>"Y")
    );
    ?>
    <?endif?>
</div>