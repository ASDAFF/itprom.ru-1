<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div id="profile-pass" class="fancybox-block">
    <div class="fancybox-block-caption"><?=GetMessage('PROFILE_TITLE_PASSWORD')?></div>
    <?if ($arResult['strProfileError'] != ''):?>
        <div class="callout text-center error" data-closable=""><?=$arResult["strProfileError"]?></div>
    <?endif;?>
    <?if ($arResult['DATA_SAVED'] == 'Y'):?>
        <div class="callout text-center error" data-closable=""><?=GetMessage('PROFILE_PASSWORD_SAVED')?></div>
    <?endif;?>
    <div class="fancybox-block-wrap">
        <script>
            $(document).ready(function() {
                initValidate("#profile-pass form");
            })
        </script>
        <form class="form fancybox-block-form" action="<?=$arResult["FORM_TARGET"]?>" data-ajax="<?=SITE_DIR?>nl_ajax/profile_user_password.php">
            <?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
                <input type="password" name="NEW_PASSWORD" value="" autocomplete="off" placeholder="<?=GetMessage('NEW_PASSWORD_REQ')?>" />
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
                <input type="password" name="NEW_PASSWORD_CONFIRM" value="" autocomplete="off" placeholder="<?=GetMessage('NEW_PASSWORD_CONFIRM')?>" />
            <?endif?>
            <button type="submit" class="small-12 button small fancybox-button text-center"><?=GetMessage('PROFILE_SAVE')?></button>
            <?=$arResult["BX_SESSION_CHECK"]?>
            <input type="hidden" name="LAST_NAME" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
            <input type="hidden" name="NAME" value="<?=$arResult["arUser"]["NAME"]?>" />
            <input type="hidden" name="EMAIL" value="<?=$arResult["arUser"]["EMAIL"]?>" />
            <input type="hidden" name="PERSONAL_PHONE" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
            <input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
            <input type="hidden" name="lang" value="<?=LANG?>" />
            <input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
            <input type="hidden" name="save" value="<?=GetMessage('PROFILE_SAVE')?>" />
        </form>
    </div>
</div>