<?if(!check_bitrix_sessid()) return;?>
<?if(is_array($errors) && count($errors)>0):?>
	<?foreach($errors as $val):?>
		<?$alErrors .= $val."<br>";?>
	<?endforeach;?>
	<?=CAdminMessage::ShowMessage(Array("TYPE"=>"ERROR", "MESSAGE" =>GetMessage('TTNMSAT_ERR_INST'), "DETAILS"=>$alErrors, "HTML"=>true));?>
<?else:?>
	<?=CAdminMessage::ShowNote(GetMessage('TTNMSAT_SUCC_INST'));?>
    <p><a href="wizard_list.php?lang=<?=LANG?>"><?=GetMessage('TTNMSAT_WIZARD_LIST')?></a></p>
<?endif;?>

<form action="<?=$APPLICATION->GetCurPage()?>">
	<input type="hidden" name="lang" value="<?=LANG?>">
	<input type="submit" name="" value="<?=GetMessage('TTNMSAT_BACK_TO_LIST')?>">
</form>