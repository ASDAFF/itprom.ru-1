<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новый раздел");
?><?$APPLICATION->IncludeComponent(
	"acrit:acrit.gm", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"SEF_FOLDER" => "/novyy-razdel/",
		"SEF_MODE" => "N",
		"VARIABLE_ALIASES" => array(
			"ELEMENT_ID" => "ELEMENT_CODE",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>