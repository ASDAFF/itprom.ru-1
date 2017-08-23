<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!IsModuleInstalled("highloadblock") && file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/highloadblock/"))
{
	$installFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/highloadblock/install/index.php";
	if (!file_exists($installFile))
		return false;

	include_once($installFile);

	$moduleIdTmp = str_replace(".", "_", "highloadblock");
	if (!class_exists($moduleIdTmp))
		return false;

	$module = new $moduleIdTmp;
	if (!$module->InstallDB())
		return false;
	$module->InstallEvents();
	if (!$module->InstallFiles())
		return false;
}

if (!CModule::IncludeModule("highloadblock"))
	return;

use Bitrix\Highloadblock as HL;

$dbHblock = HL\HighloadBlockTable::getList(
	array(
		"filter" => array("NAME" => "ColorReference")
	)
);
if (!$dbHblock->Fetch())
{
	$data = array(
		'NAME' => 'ColorReference',
		'TABLE_NAME' => 'eshop_color_reference',
	);

	$result = HL\HighloadBlockTable::add($data);
	$COLOR_ID = $result->getId();
	
	$_SESSION["NL_HBLOCK_COLOR_ID"] = $COLOR_ID;

	$hldata = HL\HighloadBlockTable::getById($COLOR_ID)->fetch();
	$hlentity = HL\HighloadBlockTable::compileEntity($hldata);

	//adding user fields
	$arUserFields = array (
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$COLOR_ID,
			'FIELD_NAME' => 'UF_NAME',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_COLOR_NAME',
			'SORT' => '100',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$COLOR_ID,
			'FIELD_NAME' => 'UF_FILE',
			'USER_TYPE_ID' => 'file',
			'XML_ID' => 'UF_COLOR_FILE',
			'SORT' => '200',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$COLOR_ID,
			'FIELD_NAME' => 'UF_LINK',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_COLOR_LINK',
			'SORT' => '300',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$COLOR_ID,
			'FIELD_NAME' => 'UF_SORT',
			'USER_TYPE_ID' => 'double',
			'XML_ID' => 'UF_COLOR_SORT',
			'SORT' => '400',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'N',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$COLOR_ID,
			'FIELD_NAME' => 'UF_DEF',
			'USER_TYPE_ID' => 'boolean',
			'XML_ID' => 'UF_COLOR_DEF',
			'SORT' => '500',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'N',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$COLOR_ID,
			'FIELD_NAME' => 'UF_XML_ID',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_XML_ID',
			'SORT' => '600',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'Y',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'N',
		)
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
			WizardServices::IncludeServiceLang("references.php", $languageID);
			$arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
		}

		$arFields["EDIT_FORM_LABEL"] = $arLabelNames;
		$arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
		$arFields["LIST_FILTER_LABEL"] = $arLabelNames;

		$ID_USER_FIELD = $obUserField->Add($arFields);
	}
}

$dbHblock = HL\HighloadBlockTable::getList(
	array(
		"filter" => array("NAME" => "NLSocialReference" . WIZARD_SITE_ID)
	)
);
$resHblock = $dbHblock->Fetch();
if (!$resHblock)
{
	$data = array(
		'NAME' => 'NLSocialReference' . WIZARD_SITE_ID,
		'TABLE_NAME' => 'nl_social_reference_' . WIZARD_SITE_ID,
	);

	$result = HL\HighloadBlockTable::add($data);
	$SOCIAL_ID = $result->getId();
	
	$hldata = HL\HighloadBlockTable::getById($SOCIAL_ID)->fetch();
	$hlentity = HL\HighloadBlockTable::compileEntity($hldata);

	//adding user fields
	$arUserFields = array (
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$SOCIAL_ID,
			'FIELD_NAME' => 'UF_TYPE',
			'USER_TYPE_ID' => 'enumeration',
			'XML_ID' => 'UF_NL_SOCIAL_TYPE',
			'SORT' => '100',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$SOCIAL_ID,
			'FIELD_NAME' => 'UF_LINK',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_NL_SOCIAL_LINK',
			'SORT' => '200',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$SOCIAL_ID,
			'FIELD_NAME' => 'UF_SORT',
			'USER_TYPE_ID' => 'double',
			'XML_ID' => 'UF_NL_SOCIAL_SORT',
			'SORT' => '300',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'N',
		)
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
			WizardServices::IncludeServiceLang("references.php", $languageID);
			$arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
		}

		$arFields["EDIT_FORM_LABEL"] = $arLabelNames;
		$arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
		$arFields["LIST_FILTER_LABEL"] = $arLabelNames;

		$ID_USER_FIELD = $obUserField->Add($arFields);
		if ($arFields["USER_TYPE_ID"] == 'enumeration' && $ID_USER_FIELD > 0) {
			$UserTypeEnum = new CUserFieldEnum();
			$UserTypeEnum->SetEnumValues($ID_USER_FIELD, array(
				"n0" => array(
					"SORT" => 100,
					"XML_ID" => "facebook",
					"VALUE" => "facebook",
					"DEF" => "Y",
				),
				"n1" => array(
					"SORT" => 200,
					"XML_ID" => "vk",
					"VALUE" => "vk",
					"DEF" => "N",
				),
				"n2" => array(
					"SORT" => 300,
					"XML_ID" => "ok",
					"VALUE" => "ok",
					"DEF" => "N",
				),
				"n3" => array(
					"SORT" => 400,
					"XML_ID" => "twitter",
					"VALUE" => "twitter",
					"DEF" => "N",
				),
				"n4" => array(
					"SORT" => 500,
					"XML_ID" => "google",
					"VALUE" => "google",
					"DEF" => "N",
				),
                "n5" => array(
					"SORT" => 600,
					"XML_ID" => "instagram",
					"VALUE" => "instagram",
					"DEF" => "N",
				),
			));
			$_SESSION["NL_SOCIAL_TYPE_ID"] = $ID_USER_FIELD;
		}
	}
} else {
	$SOCIAL_ID = $resHblock["ID"];
}
$_SESSION["NL_HBLOCK_SOCIAL_ID"] = $SOCIAL_ID;
?>