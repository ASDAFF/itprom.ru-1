<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
?>
<form id="form_subscr_setting" action="<?=$arResult["FORM_ACTION"]?>" method="post" data-ajax="<?=SITE_DIR?>nl_ajax/subscribe_edit.php" class="form">
    <?echo bitrix_sessid_post();?>
    <br />
    <input type="text" name="EMAIL" placeholder="<?echo GetMessage("subscr_email")?>" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"];?>" size="30" maxlength="255" />
    <?if (count($arResult["RUBRICS"]) == 0):?>
        <input type="hidden" name="RUB_ID[]" value="0" />
    <?else:?>
        <br />
        <fieldset class="checkbox">
            <?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
                <input type="checkbox" name="RUB_ID[]" value="<?=$itemValue["ID"]?>" id="subscribe<?=$itemID?>" class="show-for-sr"<?if($itemValue["CHECKED"]) echo " checked"?>>
                <label for="subscribe<?=$itemID?>"><?echo $itemValue["NAME"]?></label>
            <?endforeach;?>
        </fieldset>
        <br />
    <?endif;?>
    <fieldset class="radio">
        <legend><?echo GetMessage("subscr_fmt")?></legend>
        <input type="radio" name="FORMAT" value="text"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked"?> id="format-text" class="show-for-sr">
        <label for="format-text"><?echo GetMessage("subscr_text")?></label>
        <input type="radio" name="FORMAT" value="html"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked"?> id="format-html" class="show-for-sr">
        <label for="format-html">HTML</label>
    </fieldset>

    <p><br /><?echo GetMessage("subscr_settings_note1")?><br />
    <?echo GetMessage("subscr_settings_note2")?></p>

	<input id="subscribe_settings_submit" style="display:none" type="submit" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?>" />
	<input id="subscribe_settings_reset" style="display:none" type="reset" value="<?echo GetMessage("subscr_reset")?>" name="reset" />

	<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
	<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
	<?if($_REQUEST["register"] == "YES"):?>
		<input type="hidden" name="register" value="YES" />
	<?endif;?>
	<?if($_REQUEST["authorize"]=="YES"):?>
		<input type="hidden" name="authorize" value="YES" />
	<?endif;?>
    <a href="JavaScript:void(0)" onclick="$('#subscribe_settings_submit').click(); return false;" class="button small" title=""><?echo ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?></a>
    <a href="JavaScript:void(0)" onclick="$('#subscribe_settings_reset').click(); return false;" class="button small" title=""><?echo GetMessage("subscr_reset")?></a>
</form>
<br />