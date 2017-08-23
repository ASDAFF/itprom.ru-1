<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница2");
?><div class="wrapper">

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"tree2", 
	array(
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COUNT_ELEMENTS" => "Y",
		"HIDE_SECTION_NAME" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "catalog",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array(
			0 => "NAME",
			1 => "DESCRIPTION",
			2 => "PICTURE",
			3 => "",
		),
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_SECT_SERIES_NAME",
			1 => "UF_SECT_DESCRIPTION",
			2 => "UF_SECT_CHARACTER",
			3 => "UF_SHOW_ON_MAIN_PAGE",
			4 => "",
		),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "2",
		"VIEW_MODE" => "TILE",
		"COMPONENT_TEMPLATE" => "tree2"
	),
	false
);?>

</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>