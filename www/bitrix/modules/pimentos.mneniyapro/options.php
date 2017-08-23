<?
$rights = $GLOBALS["APPLICATION"]->GetGroupRight("pimentos.mneniyapro");
if ($rights > "D"):
IncludeModuleLangFile(__FILE__);
	$settings = @unserialize(COption::GetOptionString("pimentos.mneniyapro", "settings"));
	if($REQUEST_METHOD == "POST" && check_bitrix_sessid())
	{
		$settings = array();
		$settings["date_interval"] = $_REQUEST["settings"]["date_interval"];
		$settings["code"]          = $_REQUEST["settings"]["code"];
		$settings["export_status"] = $_REQUEST["export_status"];
		COption::SetOptionString("pimentos.mneniyapro", "settings", serialize($settings));	
	}
	
$aTabs = array(
	array(
		"DIV" => "edit1", "TAB" => GetMessage("MODULE_SETTINGS_TAB"), "TITLE" => GetMessage("MODULE_SETTINGS_TAB_TITLE"),
	),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);
?><form method="POST" action="<?=$APPLICATION->GetCurPage()?>?mid=pimentos.mneniyapro&lang=<?=LANGUAGE_ID?>">
<?=bitrix_sessid_post()?>
<?
$tabControl->Begin();
$tabControl->BeginNextTab();
?>
<tr>
	<td><?=GetMessage("MODULE_EXPORT_TITLE")?>:</td>
	<td>
		<select name="settings[date_interval]">
		<? if(isset($settings['date_interval'])){?>
			<option value="7" <?=($settings['date_interval'] == 7 ? 'selected="selected"' : '')?> >7 <?=GetMessage("MODULE_DAYS")?></option>
			<option value="14"<?=($settings['date_interval'] == 14 ? 'selected="selected"' : '')?> >14 <?=GetMessage("MODULE_DAYS")?></option>
			<option value="180" <?=($settings['date_interval'] == 180 ? 'selected="selected"' : '')?> >180 <?=GetMessage("MODULE_DAYS")?></option>
		<?}else{?>
			<option value="7">7 <?=GetMessage("MODULE_DAYS")?></option>
			<option value="14" selected="selected">14 <?=GetMessage("MODULE_DAYS")?></option>
			<option value="180">180 <?=GetMessage("MODULE_DAYS")?></option>
		<?}?>
		</select>
	</td>
</tr>
<?if (CModule::IncludeModule('sale')){?>
<tr>
	<td><?=GetMessage("MODULE_SETTINGS_STATUS_TITLE")?>:</td>
	<td>
		<select name="export_status[]" multiple="" class="adm-select-multiple">
		<?$statuses = CSaleStatus::GetList(array(), array('LID' => LANGUAGE_ID));?>
		<?while ($status = $statuses->Fetch()){?>
			<option value="<?=$status['ID']?>" <?if(isset($settings["export_status"]) && is_array($settings["export_status"]) && in_array($status['ID'], $settings["export_status"])) echo 'selected';?> ><?=$status['NAME']?></option>
		<?}?>
		</select>
	</td>
</tr>
<tr>
	<td><?=GetMessage("MODULE_SETTINGS_CODE_TITLE")?>:</td>
	<td><textarea class="typearea" name="settings[code]" style="width:325px; height:90px"><?if(isset($settings['code'])){ echo $settings['code'];}?></textarea></td>
</tr>

<tr>
	<td><?=GetMessage("MODULE_SETTINGS_TEMPLATE_TITLE")?>:</td>
	<td><div style="padding: 25px;border: 1px solid #C5C6C8;width: 45%;text-align: center;">&#60;!--Mneniya.pro--&#62;</div></td>
</tr>
<?}?>
<?$tabControl->Buttons();?>
<input type="submit" name="save" <?if ($rights<'W') echo "disabled" ?> value="<?echo GetMessage('MAIN_SAVE')?>" class="adm-btn-save">
<input onClick="location.href = 'http://dev.mneniya.pro/bitrix/index.php?sitename=<?=$_SERVER['HTTP_HOST']?>'" type="button" name="goto" value="<?=GetMessage("MODULE_SETTINGS_TO_PORTAL_TITLE")?>">
<?$tabControl->End();?>
</form>
<?endif;?>