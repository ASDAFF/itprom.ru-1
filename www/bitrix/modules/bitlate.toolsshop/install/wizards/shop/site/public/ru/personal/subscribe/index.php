<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рассылки");?>
<?$APPLICATION->IncludeFile(
	SITE_DIR . "include/popup/subscribe.php",
	Array(
		'TEMPLATE' => 'main',
		'SET_TITLE' => 'N',
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>