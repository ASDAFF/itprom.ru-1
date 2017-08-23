<?if(!check_bitrix_sessid()) return;?>
<?if (CModule::IncludeModule("iblock"))
	IncludeModuleLangFile(__FILE__);
?>
<?
echo CAdminMessage::ShowNote(GetMessage("MODULE_UNINSTALL_END_TITLE"));
?>