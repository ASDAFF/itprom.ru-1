<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if(!CModule::IncludeModule("iblock"))
	return;

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH."/ibexp/ru/sanfeed.xml";
$iblockCode = "feedback";//_".WIZARD_SITE_ID;
$iblockType = "feedback";

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
$iblockID = false;
if ($arIBlock = $rsIBlock->Fetch())
{
	$iblockID = $arIBlock["ID"];
	if (WIZARD_INSTALL_DEMO_DATA)
	{
		CIBlock::Delete($arIBlock["ID"]); 
		$iblockID = false; 
	}
}

if($iblockID == false)
{
	$permissions = Array(
			"1" => "X",
			"2" => "R"
		);
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "content_editor"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	};
	$iblockID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFile,
		$iblockCode,
		$iblockType,
		WIZARD_SITE_ID,
		$permissions
	);
	if ($iblockID < 1) return;

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
                        'CODE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), 
                        'TAGS' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ), ), 
		"CODE" => $iblockCode, 
		"XML_ID" => $iblockCode,
		"NAME" => $iblock->GetArrayByID($iblockID, "NAME")
	);
	
	$iblock->Update($iblockID, $arFields);
}else{
	$arSites = array(); 
	$db_res = CIBlock::GetSite($iblockID);
	while ($res = $db_res->Fetch()) $arSites[] = $res["LID"]; 
	if (!in_array(WIZARD_SITE_ID, $arSites)){
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($iblockID, array("LID" => $arSites));
	}
}
//template
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/footer.php", array("WF_IB_FEEDBACK" => $iblockID));

// creating event
function UET($EVENT_NAME, $NAME, $LID, $DESCRIPTION){
	$et = new CEventType;
	$et->Add(Array(
		"LID" => $LID,
		"EVENT_NAME" => $EVENT_NAME,
		"NAME" => $NAME,
		"DESCRIPTION" => $DESCRIPTION
		)
	);
}
$em = new CEventMessage;
$langs = CLanguage::GetList(($b=""), ($o=""));
$evtMsg = 0;
while ($lang = $langs->Fetch())
{
	WizardServices::IncludeServiceLang("feedback.php", $lang["LID"]);
	$arSites = array();
	$sites = CLang::GetList($by, $order, Array("LANGUAGE_ID"=>$lang["LID"]));
	while ($site = $sites->Fetch())
	{
		$arSites[] = $site["LID"];
	}

	///////////////////// FEEDBACK_FORM /////////////////////
	$fres = CEventType::GetList(array("EVENT_NAME" => "NEW_FEEDBACK_FORM", "LID" => $lang["LID"]));
	if (!$fres->Fetch())
	{
		UET("NEW_FEEDBACK_FORM", GetMessage("FEEDBACK_FORM_NAME"), $lang["LID"],
			"
			#AUTHOR# - ".GetMessage("FEEDBACK_FORM_AUTHOR")."
      #AUTHOR_EMAIL# - ".GetMessage("FEEDBACK_FORM_EMAIL")."
      #TEXT# - ".GetMessage("FEEDBACK_FORM_TEXT")."
      #EMAIL_FROM# - ".GetMessage("FEEDBACK_FORM_EMAIL_FROM")."
      #EMAIL_TO# - ".GetMessage("FEEDBACK_FORM_EMAIL_TO")."
      #LINK# ".GetMessage("FEEDBACK_FORM_EMAIL_TO"));
		
		if (is_array($arSites) && count($arSites)>0)
		{
			//****************************************************************
			$evtMsg = $em->Add(
				Array(
					"ACTIVE" => "Y",
					"EVENT_NAME" => "NEW_FEEDBACK_FORM",
					"LID" => $arSites,
					"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
					"EMAIL_TO" => "#EMAIL_TO#",
					"SUBJECT" => "#SITE_NAME#: ".GetMessage("FEEDBACK_FORM_DESC"),
					"MESSAGE" => GetMessage("FEEDBACK_FORM_BODY"),
					"BODY_TYPE"=>"text"));
			//****************************************************************
		}
	}else{
    $arFilter = array("EVENT_NAME" => "NEW_FEEDBACK_FORM");
    $rsMess = $em->GetList($by="site_id", $order="desc", $arFilter);
    $arMess = $rsMess->Fetch();
    $evtMsg = $arMess["ID"];
  }
}
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/footer.php", array("WF_FEEDBACK_EVENT" => $evtMsg));
?>
