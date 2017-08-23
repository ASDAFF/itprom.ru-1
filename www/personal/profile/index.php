<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки пользователя");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.profile", 
	".default", 
	array(
		"SET_TITLE" => "Y",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/personal/profile/",
		"PER_PAGE" => "20",
		"USE_AJAX_LOCATIONS" => "N",
		"SEF_URL_TEMPLATES" => array(
			"list" => "profile_list.php",
			"detail" => "profile_detail.php?ID=#ID#",
		),
		"VARIABLE_ALIASES" => array(
			"detail" => array(
				"ID" => "ID",
			),
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>