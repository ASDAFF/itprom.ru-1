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
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?$errorMessage = '';
if (is_array($arParams["~AUTH_RESULT"])) {
    $errorMessage = $arParams["~AUTH_RESULT"]["MESSAGE"];
} elseif ($arParams["~AUTH_RESULT"] != '') {
    $errorMessage = $arParams["~AUTH_RESULT"];
}
$isStatic = ($arParams["STATIC_FORM"] !== "N") ? true : false;
?>
<div id="registration<?if ($isStatic):?>-static<?endif;?>" class="fancybox-block">
    <div class="fancybox-block-caption"><?=GetMessage("AUTH_REGISTER_TITLE")?></div>
    <?if ($errorMessage != ''):?>
        <div class="callout text-center error" data-closable=""><?=$errorMessage?></div>
    <?endif;?>
    <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
        <div class="callout text-center error" data-closable=""><?echo GetMessage("AUTH_EMAIL_SENT")?></div>
    <?endif?>
    <noindex>
    <div class="fancybox-block-wrap fancybox-block-wrap-order">
        <script>
            $(document).ready(function() {
                initValidate("#registration<?if ($isStatic):?>-static<?endif;?> form");
            })
        </script>
        <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
            <div><?echo GetMessage("AUTH_EMAIL_SENT")?></div>
            <?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
                <div><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div>
            <?endif?>
        <?endif?>
        <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" class="registration-form form" data-ajax="<?=SITE_DIR?>nl_ajax/registration.php">
            <?
            if (strlen($arResult["BACKURL"]) > 0)
            {
            ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?
            }
            ?>
            <input type="hidden" name="static" value="<?=(($isStatic) ? "Y" : "N")?>" />
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="REGISTRATION" />
            <input type="hidden" name="USER_LAST_NAME" value="<?=$arResult["USER_LAST_NAME"]?>" />
            <input type="hidden" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" />
            <input type="hidden" name="USER_EMAIL" value="<?=$arResult["USER_EMAIL"]?>" />
            <fieldset class="together">
                <input type="text" name="USER_FULL_NAME" maxlength="50" value="<?=htmlspecialcharsbx($_REQUEST["USER_FULL_NAME"])?>" placeholder="<?=GetMessage("AUTH_NAME")?>" />
                <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" placeholder="<?=GetMessage("AUTH_LOGIN_MIN")?>" />
                <input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" placeholder="<?=GetMessage("AUTH_PASSWORD_REQ")?>" autocomplete="off" />
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
                <input type="password" name="USER_CONFIRM_PASSWORD" class="confirm_password" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" placeholder="<?=GetMessage("AUTH_CONFIRM")?>" autocomplete="off" />
                <?// ********************* User properties ***************************************************?>
                <?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
                    <p><?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></p>
                    <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
                        <p><?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;?></p>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:system.field.edit",
                            $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                            array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
                    <?endforeach;?>
                <?endif;?>
                <?// ******************** /User properties ***************************************************?>
                <?/* CAPTCHA */
                if ($arResult["USE_CAPTCHA"] == "Y")
                {
                    ?>
                    <div class="table-container captha-block">
                        <div class="table-item vertical-top">
                            <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                            <input type="text" name="captcha_word" maxlength="50" value="" placeholder="<?=GetMessage("CAPTCHA_REGF_PROMT")?>" />
                        </div>
                        <div class="table-item vertical-top text-right captha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="125" height="45" alt="CAPTCHA" class="photo" /></div>
                    </div>
                    <?
                }
                /* CAPTCHA */
                ?>
            </fieldset>
            <input type="hidden" name="Register" value="<?=GetMessage("AUTH_REGISTER_BUTTON")?>" />
            <button type="submit" class="small-12 button small fancybox-button text-center"><?=GetMessage("AUTH_REGISTER_BUTTON")?></button>
        </form>
    </div>
    <div class="fancybox-block-wrap">
        <div class="text-center not-is-account"><?=GetMessage("AUTH_AUTH_TITLE")?></div>
        <a href="#login" data-href="<?=$arResult["AUTH_AUTH_URL"]?>" data-static="login" class="small-12 button small fancybox-button text-center secondary <?if (!$isStatic):?>fancybox<?endif;?> show-static"><?=GetMessage("AUTH_AUTH_BUTTON")?></a>
    </div>
    </noindex>
</div>