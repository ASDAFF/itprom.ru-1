<?if (CModule::IncludeModule("iblock"))
	IncludeModuleLangFile(__FILE__);
?>
<?if(!check_bitrix_sessid()) return;?>
<?
echo CAdminMessage::ShowMessage(Array(
		"TYPE" => "OK",
		"MESSAGE" => GetMessage("MODULE_INSTALL_END_TITLE"),
		"DETAILS" => '',
		"HTML" => true,
	));
?>