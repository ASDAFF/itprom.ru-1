<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeFile(
	SITE_DIR . "include/popup/product_tab.php",
	Array(
		'TYPE' => $_REQUEST['TAB_TYPE'],
	)
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?> 