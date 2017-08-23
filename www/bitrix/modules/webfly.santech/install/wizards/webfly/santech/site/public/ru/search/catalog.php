<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("РџРѕРёСЃРє");?>

<?
CModule::IncludeModule('iblock');
$res = CIBlockType::GetList(array(), array("ACTIVE" => "Y"));
$arr = array();
while($r = $res->GetNext()){
    if(substr_count($r[ID], "catalog_"))
        $arr[] = "iblock_".$r[ID];
}

$sort = $_REQUEST['by']?$_REQUEST['by']:'rank'; $sort = ($sort == 'rank')?$sort:'date';
$APPLICATION->IncludeComponent("bitrix:search.page", "search", array(
	"RESTART" => "Y",
	"NO_WORD_LOGIC" => "N",
	"CHECK_DATES" => "N",
	"USE_TITLE_RANK" => "N",
	"DEFAULT_SORT" => "rank",
	"FILTER_NAME" => "arrFilter",
	"arrFILTER" => $arr,
	"SHOW_WHERE" => "N",
	"SHOW_WHEN" => "N",
	"PAGE_RESULT_COUNT" => "10",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "N",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"DISPLAY_TOP_PAGER" => "Y",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Результаты поиска",
	"PAGER_SHOW_ALWAYS" => "Y",
	"PAGER_TEMPLATE" => "",
	"USE_LANGUAGE_GUESS" => "Y",
	"TAGS_SORT" => "NAME",
	"TAGS_PAGE_ELEMENTS" => "20",
	"TAGS_PERIOD" => "",
	"TAGS_URL_SEARCH" => "",
	"TAGS_INHERIT" => "Y",
	"FONT_MAX" => "50",
	"FONT_MIN" => "10",
	"COLOR_NEW" => "000000",
	"COLOR_OLD" => "C8C8C8",
	"PERIOD_NEW_TAGS" => "",
	"SHOW_CHAIN" => "Y",
	"COLOR_TYPE" => "Y",
	"WIDTH" => "100%",
	"USE_SUGGEST" => "N",
	"SHOW_RATING" => "Y",
	"PATH_TO_USER_PROFILE" => "/people/user/#USER_ID#/",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>