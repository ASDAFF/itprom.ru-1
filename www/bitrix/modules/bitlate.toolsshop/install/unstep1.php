<form action="<?=$APPLICATION->GetCurPage()?>">
<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?=LANGUAGE_ID?>">
	<input type="hidden" name="id" value="bitlate.toolsshop">
	<input type="hidden" name="uninstall" value="Y">
	<input type="hidden" name="step" value="2">
	<?=CAdminMessage::ShowMessage(GetMessage('TTNMSAT_CAUTION_MESS'))?>
	<input type="submit" name="inst" value="<?=GetMessage('TTNMSAT_UNINST_MOD')?>">
</form>