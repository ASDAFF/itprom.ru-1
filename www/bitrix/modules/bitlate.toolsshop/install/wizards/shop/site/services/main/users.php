<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

//adding user fields
$arUserFields = array (
	array (
		'ENTITY_ID' => 'USER',
		'FIELD_NAME' => 'UF_NL_FAVORITES',
		'USER_TYPE_ID' => 'string',
		'XML_ID' => 'UF_NL_FAVORITES',
		'SORT' => '100',
		'MULTIPLE' => 'N',
		'MANDATORY' => 'N',
		'SHOW_FILTER' => 'N',
		'SHOW_IN_LIST' => 'Y',
		'EDIT_IN_LIST' => 'N',
		'IS_SEARCHABLE' => 'N',
	),
);
$arLanguages = Array();
$rsLanguage = CLanguage::GetList($by, $order, array());
while($arLanguage = $rsLanguage->Fetch())
	$arLanguages[] = $arLanguage["LID"];

$obUserField  = new CUserTypeEntity;
foreach ($arUserFields as $arFields)
{
	$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arFields["ENTITY_ID"], "FIELD_NAME" => $arFields["FIELD_NAME"]));
	if ($dbRes->Fetch())
		continue;

	$arLabelNames = Array();
	foreach($arLanguages as $languageID)
	{
		$arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
	}

	$arFields["EDIT_FORM_LABEL"] = $arLabelNames;
	$arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
	$arFields["LIST_FILTER_LABEL"] = $arLabelNames;

	$obUserField->Add($arFields);
}