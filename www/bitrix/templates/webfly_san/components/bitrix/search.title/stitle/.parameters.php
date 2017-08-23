<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arPrice = array();
if(CModule::IncludeModule("catalog"))
{
	$rsPrice=CCatalogGroup::GetList($v1="sort", $v2="asc");
	while($arr=$rsPrice->Fetch()) $arPrice[$arr["ID"]] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];
}
else{
	$arPrice = $arProperty_N;
}
$arCurrency = array();
$BaseCurrency = "USD";
if(CModule::IncludeModule("currency")){  
	$BaseCurrency = CCurrency::GetBaseCurrency();
	$lcur = CCurrency::GetList(($by="name"), ($order1="asc"), LANGUAGE_ID);
	while($lcur_res = $lcur->Fetch())
	{
		$arCurrency[$lcur_res["CURRENCY"]] = $lcur_res["FULL_NAME"];
	}
} 
global $arComponentParameters;
unset($arComponentParameters['PARAMETERS']["PAGE"]);
$arComponentParameters["GROUPS"]["VISUAL"] = array(
	"NAME" => GetMessage("GROUPS_VISUAL"),
	"SORT" => '400',
);

$arComponentParameters["PARAMETERS"]["CATEGORY_0_TITLE"]["DEFAULT"] = GetMessage("FIND_ALL");

$arTemplateParameters = array(
	"PRICE_CODE" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("IBLOCK_PRICE_CODE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arPrice,
		"DEFAULT" => array(
			0 => "0",
			1 => "1",
			2 => "2",
			3 => "3",
		),
	),
	"SEARCH_IN_TREE" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("SEARCH_IN_TREE"), 
		"TYPE" => "CHECKBOX",
		"DEFAULT" => 'Y'
	),
	"PAGE" => array(
		"PARENT" => "URL_TEMPLATES",
		"NAME" => GetMessage("PAGE"),
		"TYPE" => "STRING",
		"DEFAULT" => "#SITE_DIR#search/index.php",
	),
	"PAGE_2" => array(
		"PARENT" => "URL_TEMPLATES",
		"NAME" => GetMessage("PAGE_2"),
		"TYPE" => "STRING",
		"DEFAULT" => "#SITE_DIR#search/catalog.php",
	),
	
	"CURRENCY" => array(
		"PARENT" => "VISUAL",
		"NAME" => GetMessage("CURRENCY"),
		"TYPE" => "LIST",
		"VALUES" => $arCurrency,
		"DEFAULT" => $BaseCurrency,
	),
	"CACHE_TIME"  =>  Array(
		"NAME" => GetMessage("CACHE_TIME"),
		"DEFAULT"=>86400,
	),
	"INCLUDE_JQUERY" => Array(
		"NAME" => GetMessage("INCLUDE_JQUERY"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => 'Y'
	),
);
$arTemplateParameters["EXAMPLE_ENABLE"] = array(
	"PARENT" => "VISUAL",
	"NAME" => GetMessage("EXAMPLE_ENABLE"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
	"REFRESH" => "Y",
);

if($arCurrentValues["EXAMPLE_ENABLE"] == "Y")
	$arTemplateParameters["EXAMPLES"] = array(		
		"PARENT" => "VISUAL",
		"NAME" => GetMessage("EXAMPLES"),
		"TYPE" => "STRING",
		"MULTIPLE" => "Y",
		"ADDITIONAL_VALUES" => "Y",
	);


?>
