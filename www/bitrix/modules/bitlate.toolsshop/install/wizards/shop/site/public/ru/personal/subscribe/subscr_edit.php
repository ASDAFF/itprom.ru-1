<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->IncludeFile(
	SITE_DIR . "include/popup/subscribe.php",
	Array(
		'TEMPLATE' => 'main',
		'SET_TITLE' => 'Y',
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>