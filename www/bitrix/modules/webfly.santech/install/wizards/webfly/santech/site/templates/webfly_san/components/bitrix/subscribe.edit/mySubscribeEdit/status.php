<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//status and unsubscription/activation section
//***********************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="get">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="myTable">
	<thead><tr><td colspan="3"><?= GetMessage("subscr_title_status")?></td></tr></thead>
	<tr valign="top">
		<td nowrap><?= GetMessage("subscr_conf")?></td>
		<td nowrap class="<?= ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? "notetext":"errortext")?>"><?= ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></td>
		<td width="60%" rowspan="5">
			<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y"):?>
				<p><?= GetMessage("subscr_title_status_note1")?></p>
			<?elseif($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
				<p><?= GetMessage("subscr_title_status_note2")?></p>
				<p><?= GetMessage("subscr_status_note3")?></p>
			<?else:?>
				<p><?= GetMessage("subscr_status_note4")?></p>
				<p><?= GetMessage("subscr_status_note5")?></p>
			<?endif;?>
		</td>
	</tr>
	<tr>
		<td nowrap><?= GetMessage("subscr_act")?></td>
		<td nowrap class="<?= ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? "notetext":"errortext")?>"><?echo ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></td>
	</tr>
	<tr>
		<td nowrap><?= GetMessage("adm_id")?></td>
		<td nowrap><?= $arResult["SUBSCRIPTION"]["ID"];?>&nbsp;</td>
	</tr>
	<tr>
		<td nowrap><?= GetMessage("subscr_date_add")?></td>
		<td nowrap><?= $arResult["SUBSCRIPTION"]["DATE_INSERT"];?>&nbsp;</td>
	</tr>
	<tr>
		<td nowrap><?= GetMessage("subscr_date_upd")?></td>
		<td nowrap><?= $arResult["SUBSCRIPTION"]["DATE_UPDATE"];?>&nbsp;</td>
	</tr>
	<?if($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"):?>
		<tfoot><tr><td colspan="3">
		<?if($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
			<input  class="btn-gray" type="submit" name="unsubscribe" value="<?echo GetMessage("subscr_unsubscr")?>" />
			<input type="hidden" name="action" value="unsubscribe" />
		<?else:?>
			<input  class="btn-input" type="submit" name="activate" value="<?echo GetMessage("subscr_activate")?>" />
			<input type="hidden" name="action" value="activate" />
		<?endif;?>
		</td></tr></tfoot>
	<?endif;?>
</table>
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?echo bitrix_sessid_post();?>
</form>
<br />