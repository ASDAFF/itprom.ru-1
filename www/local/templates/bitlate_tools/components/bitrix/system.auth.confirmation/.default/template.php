<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arResult["SHOW_FORM"]):?>
    <div id="confirmation" class="fancybox-block" style="display: block;">
        <div class="fancybox-block-caption"><?=GetMessage("CT_BSAC_CONFIRM_TITLE")?></div>
        <?if ($arResult["MESSAGE_TEXT"] != ''):?>
            <div class="callout text-center error" data-closable=""><?=$arResult["MESSAGE_TEXT"]?></div>
        <?endif;?>
        <div class="fancybox-block-wrap fancybox-block-wrap-order">
            <script>
                $(document).ready(function(){
                    initValidate("#confirmation form");
                })
            </script>
            <form method="post" action="<?echo $arResult["FORM_ACTION"]?>" class="form" data-ajax="<?=SITE_DIR?>nl_ajax/confirmation.php">
                <input type="text" name="<?echo $arParams["LOGIN"]?>" maxlength="50" value="<?echo (strlen($arResult["LOGIN"]) > 0? $arResult["LOGIN"]: $arResult["USER"]["LOGIN"])?>" placeholder="<?=GetMessage("CT_BSAC_LOGIN")?>" />
                <input type="text" name="<?echo $arParams["CONFIRM_CODE"]?>" maxlength="50" value="<?echo $arResult["CONFIRM_CODE"]?>" placeholder="<?=GetMessage("CT_BSAC_CONFIRM_CODE")?>" />
                <button type="submit" class="small-12 button small fancybox-button text-center"><?=GetMessage("CT_BSAC_CONFIRM")?></button>
                <input type="hidden" name="<?echo $arParams["USER_ID"]?>" value="<?echo $arResult["USER_ID"]?>" />
            </form>
        </div>
    </div>
<?elseif(!$USER->IsAuthorized()):?>
    <?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "", array());?>
<?endif?>