<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $arComponentParameters;

$arComponentParameters["GROUPS"]["WF_FILTER_RUB"]= array(
	"NAME" => GetMessage("WF_GROUP_NAME"),
	"SORT" => 2000,
);

if(!CModule::IncludeModule("catalog"))
{
	$arPrice = array("YS_EMPTY" => "-----");
	foreach($arCurrentValues["IBLOCK_ID_IN"] as $id)
	if($id > 0)
	{
	    $rsPrice = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $id, 
	    	array("LOGIC" => "OR", array("PROPERTY_TYPE" => "S"), array("PROPERTY_TYPE" => "N"))));
	    while($arr=$rsPrice->Fetch())
	    {
	    	if(!in_array($arr["NAME"], $arPrice))
	    	{
	    		 $arPrice[$arr["CODE"]] = $arr["NAME"];
	    	}
	    }
	}
}
else
{	
	$rsPrice = CCatalogGroup::GetList($v1 = "sort", $v2 = "asc");
	while($arr = $rsPrice->Fetch()) 
	{
		$arPrice[$arr["NAME"]] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];
	}
}

if(CModule::IncludeModule("currency"))
{
	$rsCur = CCurrency::GetList(($by = "name"), ($order1 = "asc"), LANGUAGE_ID);
	while($arCur = $rsCur->Fetch())
	{
		$arCurrencies[$arCur["CURRENCY"]] = $arCur["CURRENCY"];
	}
}

$arTemplateParameters = array(
	"INCLUDE_JQUERY" => Array(
		"PARENT" => "WF_FILTER_RUB",
		"NAME" => GetMessage("INCLUDE_JQUERY"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => 'Y'
	),
	"VIEW_HIT" => array(
		"PARENT" => "WF_FILTER_RUB",
		"NAME" => GetMessage("VIEW_HIT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"PRICE_CODE" => array(
		"PARENT" => "WF_FILTER_RUB",
		"NAME" => GetMessage("PRICE_CODE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"VALUES" => $arPrice,
	),
	"CURRENCY" => array(
		"PARENT" => "WF_FILTER_RUB",
		"NAME" => GetMessage("CURRENCY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "N",
		"VALUES" => $arCurrencies,
	)
);

if(!CModule::IncludeModule('catalog')) unset($arTemplateParameters["CURRENCY"]);
unset($arComponentParameters['PARAMETERS']['MAX_LEVEL']);
?>