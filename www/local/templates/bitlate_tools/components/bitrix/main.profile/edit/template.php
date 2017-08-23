<?
/**
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div id="profile-data" class="fancybox-block">
    <div class="fancybox-block-caption"><?=GetMessage('PROFILE_EDIT_TITLE')?></div>
    <?if ($arResult['strProfileError'] != ''):?>
        <div class="callout text-center error" data-closable=""><?=$arResult["strProfileError"]?></div>
    <?endif;?>
    <?if ($arResult['DATA_SAVED'] == 'Y'):?>
        <div class="callout text-center error" data-closable=""><?=GetMessage('PROFILE_DATA_SAVED')?></div>
    <?endif;?>
    <div class="fancybox-block-wrap">
        <script>
            $(document).ready(function() {
                initValidate("#profile-data form");
            })
        </script>
        <form class="form fancybox-block-form" method="post" action="<?=$arResult["FORM_TARGET"]?>" data-ajax="<?=SITE_DIR?>nl_ajax/profile_user.php">
            <input type="text" name="LAST_NAME" value="<?=$arResult["arUser"]["LAST_NAME"]?>" placeholder="<?=GetMessage('LAST_NAME')?>" />
            <input type="text" name="NAME" value="<?=$arResult["arUser"]["NAME"]?>" placeholder="<?=GetMessage('NAME')?>" />
            <input type="text" name="EMAIL" value="<? echo $arResult["arUser"]["EMAIL"]?>" placeholder="<?=GetMessage('EMAIL')?>" />
            <input type="text" name="PERSONAL_PHONE" class="phone" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" placeholder="<?=GetMessage('USER_PHONE')?>" />
            <button type="submit" class="small-12 button small fancybox-button text-center"><?=GetMessage('PROFILE_SAVE')?></button>
            <?=$arResult["BX_SESSION_CHECK"]?>
            <input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
            <input type="hidden" name="lang" value="<?=LANG?>" />
            <input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
            <input type="hidden" name="save" value="<?=GetMessage('PROFILE_SAVE')?>" />
        </form>
        <script>
            $(document).ready(function() {
                <?if ($arResult["DATA_SAVED"] == 'Y'):?>
                    $.ajax({
                        type: 'GET',
                        url: '<?=SITE_DIR?>nl_ajax/profile_user_info.php',
                        success: function(data){
                            $('.profile-container .column.contact-information').replaceWith(data);
                            $('.profile-column-container').isotope('destroy');
                            $('.profile-column-container').isotope(profileGridOptions);
                        }
                    });
                <?endif;?>
            })
        </script>
    </div>
</div>