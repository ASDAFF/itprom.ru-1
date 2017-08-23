<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$errorMessage = '';
if (is_array($arParams["~AUTH_RESULT"])) {
    $errorMessage = $arParams["~AUTH_RESULT"]["MESSAGE"];
} elseif ($arParams["~AUTH_RESULT"] != '') {
    $errorMessage = $arParams["~AUTH_RESULT"];
}?>
<div id="change" class="fancybox-block" style="display:block;">
    <div class="fancybox-block-caption"><?=GetMessage("AUTH_CHANGE_PASSWORD")?></div>
    <?if ($errorMessage != ''):?>
        <div class="callout text-center error" data-closable="" style="max-width: 320px;"><?=$errorMessage?></div>
    <?endif;?>
    <div class="fancybox-block-wrap">
        <script>
            $(document).ready(function() {
                initValidate("#change form");
            })
        </script>
        <form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform" class="form" data-ajax="<?=SITE_DIR?>nl_ajax/changepasswd.php">
            <?if (strlen($arResult["BACKURL"]) > 0): ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <? endif ?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="CHANGE_PWD">
            <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" placeholder="<?=GetMessage("AUTH_LOGIN")?>" />
            <input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" placeholder="<?=GetMessage("AUTH_CHECKWORD")?>" />
            <input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>" autocomplete="off" />

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

            <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" placeholder="<?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>" autocomplete="off" />
            <input type="hidden" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
            <button type="submit" class="small-12 button small fancybox-button text-center"><?=GetMessage("AUTH_CHANGE")?></button>
        </form>
    </div>
</div>