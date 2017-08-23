<?php
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

if (!CModule::IncludeModule("highloadblock")) return;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
$dbHblock = HL\HighloadBlockTable::getList(
	array(
		"filter" => array("NAME" => "Favorites")
	)
);
//Favorites Highloadblock
$fres = $dbHblock->Fetch();
if (!$fres){
	$data = array(
		'NAME' => 'Favorites',
		'TABLE_NAME' => 'eshop_favorites',
	);

	$result = HL\HighloadBlockTable::add($data);
	$Fav_ID = $result->getId();

	$hldata = HL\HighloadBlockTable::getById($Fav_ID)->fetch();
	$hlentity = HL\HighloadBlockTable::compileEntity($hldata);

	//adding user fields
	$arUserFields = array (
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Fav_ID,
			'FIELD_NAME' => 'UF_USER_ID',
			'USER_TYPE_ID' => 'double',
			'XML_ID' => 'UF_USER_XML_ID',
			'SORT' => '100',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Fav_ID,
			'FIELD_NAME' => 'UF_FAV_ID',
			'USER_TYPE_ID' => 'double',
			'XML_ID' => 'UF_FAV_XML_ID',
			'SORT' => '200',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'Y',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Fav_ID,
			'FIELD_NAME' => 'UF_XML_ID',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_XML_ID',
			'SORT' => '300',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'Y',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
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
			WizardServices::IncludeServiceLang("highloadblocks.php", $languageID);
			$arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
		}

		$arFields["EDIT_FORM_LABEL"] = $arLabelNames;
		$arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
		$arFields["LIST_FILTER_LABEL"] = $arLabelNames;

		$ID_USER_FIELD = $obUserField->Add($arFields);
	}
}else{
  $Fav_ID = $fres["ID"];
}
//public
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/favorites/index.php", array("HLB_FAV" => $Fav_ID));
//templates 
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/components/bitrix/catalog/santech/bitrix/catalog.section/list/result_modifier.php", array("HLB_FAV" => $Fav_ID));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/components/bitrix/catalog/santech/bitrix/catalog.section/tiles/result_modifier.php", array("HLB_FAV" => $Fav_ID));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/components/bitrix/catalog.section/list/result_modifier.php", array("HLB_FAV" => $Fav_ID));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/components/bitrix/catalog.section/tiles/result_modifier.php", array("HLB_FAV" => $Fav_ID));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/components/bitrix/catalog.top/main_topcat/result_modifier.php", array("HLB_FAV" => $Fav_ID));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/footer.php", array("HLB_FAV" => $Fav_ID));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/ajax/favorites.php", array("HLB_FAV" => $Fav_ID));

//Settings Highloadblock

$dbHblock = HL\HighloadBlockTable::getList(
	array(
		"filter" => array("NAME" => "Settings")
	)
);
$fres = $dbHblock->Fetch();
if (!$fres){
	$data = array(
		'NAME' => 'Settings',
		'TABLE_NAME' => 'wf_settings',
	);

	$result = HL\HighloadBlockTable::add($data);
	$Set_ID = $result->getId();

	$hldata = HL\HighloadBlockTable::getById($Set_ID)->fetch();
	$hlentity = HL\HighloadBlockTable::compileEntity($hldata);

	//adding user fields
	$arUserFields = array (
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Set_ID,
			'FIELD_NAME' => 'UF_BG',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_BG_XML',
			'SORT' => '100',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Set_ID,
			'FIELD_NAME' => 'UF_BUTTONS',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_BUTTONS_XML',
			'SORT' => '200',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Set_ID,
			'FIELD_NAME' => 'UF_SHADOWS',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_SHADOWS_XML',
			'SORT' => '300',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
    array (
			'ENTITY_ID' => 'HLBLOCK_'.$Set_ID,
			'FIELD_NAME' => 'UF_THEME',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_THEME_XML',
			'SORT' => '400',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
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
			WizardServices::IncludeServiceLang("highloadblocks.php", $languageID);
			$arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
		}

		$arFields["EDIT_FORM_LABEL"] = $arLabelNames;
		$arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
		$arFields["LIST_FILTER_LABEL"] = $arLabelNames;

		$ID_USER_FIELD = $obUserField->Add($arFields);
	}
}else{
  $Set_ID = $fres["ID"];
}

$_SESSION["WF_IBL_SETTINGS_ID"] = $Set_ID;
//templates
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/settings.php", array("HLB_PULT" => $Set_ID));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/ajax/pult.php", array("HLB_PULT" => $Set_ID));

//Brands Highloadblock

$dbHblock = HL\HighloadBlockTable::getList(
	array(
		"filter" => array("NAME" => "Brands")
	)
);
$fres = $dbHblock->Fetch();
if (!$fres){
  $data = array(
		'NAME' => 'Brands',
		'TABLE_NAME' => 'wf_brand_reference',
	);
  
  $result = HL\HighloadBlockTable::add($data);
	$Brand_ID = $result->getId();

	$hldata = HL\HighloadBlockTable::getById($Brand_ID)->fetch();
	$hlentity = HL\HighloadBlockTable::compileEntity($hldata);

	//adding user fields
	$arUserFields = array (
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Brand_ID,
			'FIELD_NAME' => 'UF_NAME',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_BRAND_NAME',
			'SORT' => '100',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Brand_ID,
			'FIELD_NAME' => 'UF_FILE',
			'USER_TYPE_ID' => 'file',
			'XML_ID' => 'UF_BRAND_FILE',
			'SORT' => '200',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Brand_ID,
			'FIELD_NAME' => 'UF_LINK',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_BRAND_LINK',
			'SORT' => '300',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Brand_ID,
			'FIELD_NAME' => 'UF_DESCRIPTION',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_BRAND_DESCR',
			'SORT' => '400',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Brand_ID,
			'FIELD_NAME' => 'UF_FULL_DESCRIPTION',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_BRAND_FULL_DESCR',
			'SORT' => '500',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Brand_ID,
			'FIELD_NAME' => 'UF_SORT',
			'USER_TYPE_ID' => 'double',
			'XML_ID' => 'UF_BRAND_SORT',
			'SORT' => '600',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'N',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Brand_ID,
			'FIELD_NAME' => 'UF_EXTERNAL_CODE',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_BRAND_EXTERNAL_CODE',
			'SORT' => '700',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'N',
		),
		array (
			'ENTITY_ID' => 'HLBLOCK_'.$Brand_ID,
			'FIELD_NAME' => 'UF_XML_ID',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_BRAND_XML_ID',
			'SORT' => '800',
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
	foreach ($arUserFields as $arFields){
		$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arFields["ENTITY_ID"], "FIELD_NAME" => $arFields["FIELD_NAME"]));
		if ($dbRes->Fetch())
			continue;

		$arLabelNames = Array();
		foreach($arLanguages as $languageID)
		{
			WizardServices::IncludeServiceLang("highloadblocks.php", $languageID);
			$arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
		}

		$arFields["EDIT_FORM_LABEL"] = $arLabelNames;
		$arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
		$arFields["LIST_FILTER_LABEL"] = $arLabelNames;

		$ID_USER_FIELD = $obUserField->Add($arFields);
	}
}
else{
  $Brand_ID = $fres["ID"];
}
$_SESSION["WF_IBL_BRANDS_ID"] = $Brand_ID;
//public
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/brands/index.php", array("HLB_BRANDS" => $Brand_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/brands/detail.php", array("HLB_BRANDS" => $Brand_ID));