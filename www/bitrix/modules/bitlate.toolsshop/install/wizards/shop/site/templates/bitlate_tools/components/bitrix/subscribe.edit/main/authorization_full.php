<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//******************************************
//subscription authorization form
//******************************************
?>
<form id="form_subscr_auth" action="<?echo $arResult["FORM_ACTION"].($_SERVER["QUERY_STRING"]<>""? "?".htmlspecialcharsbx($_SERVER["QUERY_STRING"]):"")?>" method="post" data-ajax="<?=SITE_DIR?>nl_ajax/subscribe_edit.php" class="form">
	<p><?echo GetMessage("subscr_auth_sect_title")?></p>
	<input type="text" name="sf_EMAIL" size="20" value="<?echo $arResult["REQUEST"]["EMAIL"];?>" placeholder="<?echo GetMessage("subscr_auth_email")?>" />
	<input type="password" name="AUTH_PASS" size="20" value="" placeholder="<?echo GetMessage("subscr_auth_pass_title")?>" />
	<p><?echo GetMessage("adm_auth_note")?></p>
	<input id="subscribe_full_auth_submit" style="display:none" type="submit" name="autorize" value="<?echo GetMessage("adm_auth_butt")?>" />
	<input type="hidden" name="action" value="authorize" />
	<?echo bitrix_sessid_post();?>
	<a href="JavaScript:void(0)" onclick="$('#subscribe_full_auth_submit').click(); return false;" class="button small" title=""><?echo GetMessage("adm_auth_butt")?></a>
</form>
<br />
<form id="form_subscr_sendpassword" action="<?=$arResult["FORM_ACTION"]?>" data-ajax="<?=SITE_DIR?>nl_ajax/subscribe_edit.php" class="form">
	<p><?echo GetMessage("subscr_pass_title")?></p>
	<input type="text" name="sf_EMAIL" size="20" value="<?echo $arResult["REQUEST"]["EMAIL"];?>" placeholder="<?echo GetMessage("subscr_auth_email")?>" />
	<p><?echo GetMessage("subscr_pass_note")?></p>
	<input id="subscribe_full_auth_sendpass" style="display:none"  type="submit" name="sendpassword" value="<?echo GetMessage("subscr_pass_button")?>" />
    <input type="hidden" name="action" value="sendpassword" />
	<?echo bitrix_sessid_post();?>
	<a href="JavaScript:void(0)" onclick="$('#subscribe_full_auth_sendpass').click(); return false;" class="button small" title=""><?echo GetMessage("subscr_pass_button")?></a>
</form>
<br />
