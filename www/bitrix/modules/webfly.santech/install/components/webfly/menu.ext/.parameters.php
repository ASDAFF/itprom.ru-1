<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arTypesEx = Array("all"=> GetMessage("CP_BMS_ALL"));
$db_iblock_type = CIBlockType::GetList(Array("SORT"=>"ASC"));
while($arRes = $db_iblock_type->Fetch())
	if($arIBType = CIBlockType::GetByIDLang($arRes["ID"], LANG))
		$arTypesEx[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arIBType["NAME"];



$arIBlocks = Array("all"=> GetMessage("CP_BMS_ALL"));
if(in_array("all", $arCurrentValues["IBLOCK_TYPE"])) $arCurrentValues["IBLOCK_TYPE"] = array();


$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => $arCurrentValues["IBLOCK_TYPE"]));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

if(is_array($arCurrentValues["IBLOCK_ID"]))
if(in_array("all", $arCurrentValues["IBLOCK_ID"])) $arCurrentValues["IBLOCK_ID"] = array();
$db_list = CIBlockSection::GetList(Array("IBLOCK_ID"=>"asc"), Array('IBLOCK_ID'=>$arCurrentValues["IBLOCK_ID"]), false);
while($ar_result = $db_list->Fetch()){
    $ibl = CIBlock::GetByID($ar_result[IBLOCK_ID])->Fetch();
	$arSection[$ar_result["ID"]] = "[".$ar_result["ID"]."] "."[{$ibl[NAME]}] ".$ar_result["NAME"];
}


$depth_level = array(
	"1" => GetMessage("CP_BMS_DEPTH_LEVEL_1"),
	"2" => GetMessage("CP_BMS_DEPTH_LEVEL_2"),
	"3" => GetMessage("CP_BMS_DEPTH_LEVEL_3"),
	"4" => GetMessage("CP_BMS_DEPTH_LEVEL_4")
);

$depth_level_sections = array(
	'0' => GetMessage('CP_BMS_ALL'),
	'1' => '1',
	'2' => '2',
	'3' => '3',
	'4' => '4'
);

$hide_values = array(
	"ACTIVE" => GetMessage("HIDE_ELEMENT_ACTIVE"),
	"N" => GetMessage("HIDE_ELEMENT_NOT"),
);
if(CModule::IncludeModule("catalog"))
	$hide_values["AVAILABLE"] = GetMessage("HIDE_ELEMENT_AVAILABLE");

$arComponentParameters = array(
	"GROUPS" => array(
		"SORT_PARAMS" => array(
			"NAME" => GetMessage("SORT_PARAMS"),
			"SORT" => 2000,
		),
	),
	"PARAMETERS" => array(
		"ID" => Array(
			"PARENT" => "BASE",
			"NAME"=>GetMessage("CP_BMS_ID"),
			"TYPE"=>"STRING",
			"DEFAULT"=>'={$_REQUEST["ID"]}',
		),
		"IBLOCK_TYPE" => Array(
			"PARENT" => "BASE",
			"NAME"=>GetMessage("CP_BMS_IBLOCK_TYPE"),
			"TYPE"=>"LIST",
			"VALUES"=>$arTypesEx,
			"MULTIPLE"=>"Y",
			"DEFAULT"=>"catalog",
			"ADDITIONAL_VALUES"=>"Y",
			"REFRESH" => "Y",
		),
		"IBLOCK_TYPE_MASK" => Array(
			"PARENT" => "BASE",
			"NAME"=>GetMessage("IBLOCK_TYPE_MASK"),
			"TYPE"=>"STRING",
			"MULTIPLE"=>"Y",
			"DEFAULT"=>"catalog_%",
			"ADDITIONAL_VALUES"=>"Y",
		),
		"IBLOCK_ID" => Array(
			"PARENT" => "BASE",
			"NAME"=>GetMessage("CP_BMS_IBLOCK_ID"),
			"TYPE"=>"LIST",
			"VALUES"=>$arIBlocks,
			"DEFAULT"=>'1',
			"MULTIPLE"=>"Y",
			"ADDITIONAL_VALUES"=>"N",
			"REFRESH" => "Y",
		),		
		
		"DEPTH_LEVEL_START" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CP_BMS_DEPTH_LEVEL_START"),
			"TYPE" => "LIST",
			"VALUES" => $depth_level,
			"DEFAULT" => "1",
		),
		"DEPTH_LEVEL_FINISH" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CP_BMS_DEPTH_LEVEL_FINISH"),
			"TYPE" => "LIST",
			"VALUES" => $depth_level,
			"DEFAULT" => "4",
		),
		"DEPTH_LEVEL_SECTIONS" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CP_BMS_DEPTH_LEVEL_SECTIONS"),
			"TYPE" => "LIST",
			"VALUES" => $depth_level_sections,
			"DEFAULT" => "0",
		),
		
		"IBLOCK_TYPE_URL" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE_URL"),
			"TYPE" => "STRING",
			"DEFAULT" => "/catalog/#IBLOCK_TYPE#/",
		),
		
		"IBLOCK_TYPE_URL_REPLACE" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE_URL_REPLACE"),
			"TYPE" => "STRING",
			"DEFAULT" => "catalog_",
		),
				
		"IBLOCK_TYPE_SORT_FIELD" => array(
			"PARENT" => "SORT_PARAMS",
			"NAME" => GetMessage("IBLOCK_TYPE_SORT_FIELD"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"name" => GetMessage("IBLOCK_SORT_NAME"),
				"sort" => GetMessage("IBLOCK_SORT_SORT"),
				"id" => GetMessage("IBLOCK_SORT_ID"),
			),
			"DEFAULT" => "id",
		),
		"IBLOCK_TYPE_SORT_ORDER" => array(
			"PARENT" => "SORT_PARAMS",
			"NAME" => GetMessage("SORT_ORDER"),
			"TYPE" => "LIST",
			"VALUES" => array(
			    "asc" => GetMessage("IBLOCK_SORT_ASC"),
			    "desc" => GetMessage("IBLOCK_SORT_DESC")
			),
			"DEFAULT" => "asc",
		),
		
		"IBLOCK_SORT_FIELD" => array(
			"PARENT" => "SORT_PARAMS",
			"NAME" => GetMessage("IBLOCK_SORT_FIELD"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"id" => GetMessage("IBLOCK_SORT_ID"),
				"iblock_type" => GetMessage("IBLOCK_SORT_IBLOCK_TYPE"),
				"name" => GetMessage("IBLOCK_SORT_NAME"),
				"active" => GetMessage("IBLOCK_SORT_ACTIVE"), 
				"code" => GetMessage("IBLOCK_SORT_CODE"),
				"sort" => GetMessage("IBLOCK_SORT_SORT"),
				"element_cnt" => GetMessage("IBLOCK_SORT_ELEMENT_CNT"),		
				"timestamp_x" => GetMessage("IBLOCK_SORT_DATE"),
			),
			"DEFAULT" => "sort",
			//"ADDITIONAL_VALUES" => "Y",
		),
		"IBLOCK_SORT_ORDER" => array(
			"PARENT" => "SORT_PARAMS",
			"NAME" => GetMessage("SORT_ORDER"),
			"TYPE" => "LIST",
			"VALUES" => array(
			    "asc" => GetMessage("IBLOCK_SORT_ASC"),
			    "desc" => GetMessage("IBLOCK_SORT_DESC")
			),
			"DEFAULT" => "asc",
		),
		
		"SECTION_SORT_FIELD" => array(
			"PARENT" => "SORT_PARAMS",
			"NAME" => GetMessage("SECTION_SORT_FIELD"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"sort" => GetMessage("IBLOCK_SORT_SORT"),
			),
			"DEFAULT" => "sort",
		),
		
		"SECTION_SORT_ORDER" => array(
			"PARENT" => "SORT_PARAMS",
			"NAME" => GetMessage("SORT_ORDER"),
			"TYPE" => "LIST",
			"VALUES" => array(
			    "asc" => GetMessage("IBLOCK_SORT_ASC"),
			    "desc" => GetMessage("IBLOCK_SORT_DESC")
			),
			"DEFAULT" => "asc",
		),
		
		"ELEMENT_SORT_FIELD" => array(
			"PARENT" => "SORT_PARAMS",
			"NAME" => GetMessage("ELEMENT_SORT_FIELD"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"id" => GetMessage("ELEMENT_SORT_ID"),
				"sort" => GetMessage("IBLOCK_SORT_SORT"),
				"timestamp_x" => GetMessage("IBLOCK_SORT_DATE"),
				"name" => GetMessage("IBLOCK_SORT_NAME"),
				"active_from" => GetMessage("ELEMENT_SORT_ACTIVE_FROM"),
				"active_to" => GetMessage("ELEMENT_SORT_ACTIVE_TO"),
				"code" => GetMessage("IBLOCK_SORT_CODE"),
				"iblock_id" => GetMessage("ELEMENT_SORT_IBLOCK_ID"),
				"modified_by" => GetMessage("ELEMENT_SORT_MODIFIED_BY"),
				"active" => GetMessage("IBLOCK_SORT_ACTIVE"),
				"rand" => GetMessage("ELEMENT_RAND"),
				"xml_id" => GetMessage("ELEMENT_XML_ID"),
				"tags" => GetMessage("ELEMENT_TAGS"),
				"created" => GetMessage("ELEMENT_CREATED"),
				"created_date" => GetMessage("ELEMENT_CREATED_DATE"),
			),
			"DEFAULT" => "sort",
			//"ADDITIONAL_VALUES" => "Y",
		),
		
		"ELEMENT_SORT_ORDER" => array(
			"PARENT" => "SORT_PARAMS",
			"NAME" => GetMessage("SORT_ORDER"),
			"TYPE" => "LIST",
			"VALUES" => array(
			    "asc" => GetMessage("IBLOCK_SORT_ASC"),
			    "nulls,asc" => GetMessage("ELEMENT_SORT_NULLS_ASC"),
				"asc,nulls" => GetMessage("ELEMENT_SORT_ASC_NULLS"),
			    "desc" => GetMessage("IBLOCK_SORT_DESC"),
				"nulls,desc" => GetMessage("ELEMENT_SORT_NULLS_DESC"),
			    "desc,nulls" => GetMessage("ELEMENT_SORT_DESC_NULLS")
			),
			"DEFAULT" => "asc",
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
		
		"HIDE_ELEMENT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("HIDE_ELEMENT"),
			"TYPE" => "LIST",
			"VALUES" => $hide_values,
			"DEFAULT" => "N",
		),
		
		"ELEMENT_CNT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ELEMENT_CNT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
	),
);
if(CModule::IncludeModule("catalog"))
{
$arComponentParameters['PARAMETERS']['ELEMENT_CNT_AVAILABLE'] = array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ELEMENT_CNT_AVAILABLE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		);
}
?>