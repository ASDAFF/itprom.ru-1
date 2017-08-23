<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//*************************************
//show confirmation form
//*************************************
?>
<form id="form_subscr_confirmation" action="<?=$arResult["FORM_ACTION"]?>" method="get" data-ajax="<?=SITE_DIR?>nl_ajax/subscribe_edit.php" class="form">
    <input type="text" name="CONFIRM_CODE" value="<?echo $arResult["REQUEST"]["CONFIRM_CODE"];?>" placeholder="<?echo GetMessage("subscr_conf_code")?>" />
    <p><?echo GetMessage("subscr_conf_date")?><br />
    <?echo $arResult["SUBSCRIPTION"]["DATE_CONFIRM"];?></p>
    <a title="<?echo GetMessage("adm_send_code")?>"  class="button small" href="#" onclick="$('#subscribe_confirmation_submit').remove(); $('#form_subscr_confirmation').submit(); return false;"><?echo GetMessage("subscr_conf_note2")?></a>
    <a title="<?echo GetMessage("subscr_conf_button")?>"  class="button small" href="#" onclick="$('#subscribe_confirmation_sendcode').remove(); $('#form_subscr_confirmation').submit(); return false;"><?echo GetMessage("subscr_conf_button")?></a>
    <?/*<a href="#" onclick="$('#forgot_password_form').submit(); return false;" class="button small" title=""><?=GetMessage("AUTH_CHANGE")?></a>*/?>
    <input id="subscribe_confirmation_sendcode" type="hidden" name="action" value="sendcode" />
    <input id="subscribe_confirmation_submit" type="hidden" name="confirm" value="<?echo GetMessage("subscr_conf_button")?>" />
	<input type="hidden" name="ID" value="<?echo $arResult["ID"];?>" />
    <?echo bitrix_sessid_post();?>
</form>

