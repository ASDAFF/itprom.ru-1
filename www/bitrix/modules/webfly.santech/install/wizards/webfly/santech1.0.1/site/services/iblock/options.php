<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock")) return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH . "/ibexp/ru/sanopts.xml";
$iblockCode = "options"; //_".WIZARD_SITE_ID;
$iblockType = "references";

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
$iblockID = false;
if ($arIBlock = $rsIBlock->Fetch()) {
  $iblockID = $arIBlock["ID"];
}

if ($iblockID == false) {
  $permissions = Array(
      "1" => "X",
      "2" => "R"
  );
  $dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "content_editor"));
  if ($arGroup = $dbGroup->Fetch()) {
    $permissions[$arGroup["ID"]] = 'W';
  }
  $iblockID = WizardServices::ImportIBlockFromXML($iblockXMLFile, $iblockCode, $iblockType, WIZARD_SITE_ID, $permissions);

  $iblock = new CIBlock;
	$arFields = Array(
		"ACTIVE" => "Y",
		"FIELDS" => array ( 'IBLOCK_SECTION' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
                        'ACTIVE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ),
                        'ACTIVE_FROM' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '=today', ),
                        'ACTIVE_TO' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
                        'SORT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
                        'NAME' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
                        'PREVIEW_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'FROM_DETAIL' => 'N', 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', ), ), 
                        'PREVIEW_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ), 'PREVIEW_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 
                        'DETAIL_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => array ( 'SCALE' => 'N', 'WIDTH' => '', 'HEIGHT' => '', 'IGNORE_ERRORS' => 'N', ), ), 
                        'DETAIL_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ),
                        'DETAIL_TEXT' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
                        'XML_ID' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
                        'CODE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => array("UNIQUE"=>"Y", "TRANSLITERATION" => "Y", "TRANS_LEN" => 100, "TRANS_CASE" => "L", "TRANS_SPACE" => "_", "TRANS_OTHER" => "_", "TRANS_EAT" => "Y", "USE_GOOGLE" => "Y") ),
                        'TAGS' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), ),
		"CODE" => $iblockCode,
		"XML_ID" => $iblockCode,
		"NAME" => $iblock->GetArrayByID($iblockID, "NAME")
	);
	$iblock->Update($iblockID, $arFields);
  if ($iblockID < 1){
    $_SESSION["WF_SETUP_ERRORS"][] = "Failed to export options IB!";
    return;
  }
}else{
  $arSites = array();
  $db_res = CIBlock::GetSite($iblockID);
  while ($res = $db_res->Fetch())
    $arSites[] = $res["LID"];
  if (!in_array(WIZARD_SITE_ID, $arSites)) {
    $arSites[] = WIZARD_SITE_ID;
    $iblock = new CIBlock;
    $iblock->Update($iblockID, array("LID" => $arSites));
  }
}
if(empty($iblockID)) $_SESSION["WF_SETUP_ERRORS"][] = "Failed to export options IB!";
//public_files
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/catalog/index.php", array("IBLOCK_OPTIONS" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/favorites/index.php", array("IBLOCK_OPTIONS" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "_index.php", array("IBLOCK_OPTIONS" => $iblockID));
//template files
$templatePath = $_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/components/bitrix";
CWizardUtil::ReplaceMacros($templatePath."/catalog/santech1_5/bitrix/catalog.element/advance/result_modifier.php", array("IBLOCK_OPTIONS" => $iblockID));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/ajax/buy.php", array("IBLOCK_OPTIONS" => $iblockID));
//creating options link
$ib = new CIBlock();
$res = $ib->GetList(array(),array("CODE" => "santech"));
$catalog = $res->Fetch();
$catalogId = $catalog["ID"];
if(!empty($catalogId)){
  WizardServices::IncludeServiceLang("texts.php", "ru");
  $ibProp = new CIBlockProperty();
  $arPropNew = array(
      "NAME"=>GetMessage("PROP_OPTIONS"), "CODE"=>"PRODUCT",
      "ACTIVE"=>"Y", "SORT"=>100, "USER_TYPE" => 'EList', "MULTIPLE" => "Y",
			"PROPERTY_TYPE"=>"E",	"IBLOCK_ID"=> $catalogId,
      "HINT" => GetMessage("PROP_OPTIONS_HINT"),
      "LINK_IBLOCK_ID" => $iblockID);
  $arPropID = $ibProp->Add($arPropNew);
  if(empty($arPropID)) $_SESSION["WF_SETUP_ERRORS"][] = "Failed to create options property!";
}else{
  $_SESSION["WF_SETUP_ERRORS"][] = "Failed to found catalog!";
}
?>