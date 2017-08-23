<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog"))
    return;

$useStoreControl = "Y";
$curUseStoreControl = COption::GetOptionString("catalog", "default_use_store_control", "N");
COption::SetOptionString("catalog", "default_use_store_control", $useStoreControl);

if($useStoreControl == "Y")
{
    $siteName = htmlspecialcharsbx($wizard->GetVar("siteName"));
    $sitePhone = htmlspecialcharsbx($wizard->GetVar("sitePhone"));
    $siteEmail = htmlspecialcharsbx($wizard->GetVar("siteEmail"));
    $fileArray = CFile::MakeFileArray(WIZARD_ABSOLUTE_PATH . GetMessage("STORE_IMAGE_1"));
    $fId = CFile::SaveFile($fileArray, "store");
    $arStoreFields = array(
        "TITLE" => ($siteName) ? $siteName : GetMessage("STORE_NAME_1"),
        "ADDRESS" => GetMessage("STORE_ADR_1"),
        "DESCRIPTION" => GetMessage("STORE_DESCR_1"),
        "GPS_N" => GetMessage("STORE_GPS_N_1"),
        "GPS_S" => GetMessage("STORE_GPS_S_1"),
        "PHONE" => ($sitePhone) ? $sitePhone : GetMessage("STORE_PHONE_1"),
        "EMAIL" => ($siteEmail) ? $siteEmail : GetMessage("STORE_EMAIL_1"),
        "SCHEDULE" => GetMessage("STORE_PHONE_SCHEDULE_1"),
        "IMAGE_ID" => $fId,
        "SITE_ID" => WIZARD_SITE_ID,
    );
    $newStoreId = CCatalogStore::Add($arStoreFields);
    if($newStoreId)
    {
        CCatalogDocs::synchronizeStockQuantity($newStoreId);
    }
    $fileArray = CFile::MakeFileArray(WIZARD_ABSOLUTE_PATH . GetMessage("STORE_IMAGE_2"));
    $fId = CFile::SaveFile($fileArray, "store");
    $arStoreFields = array(
        "TITLE" => GetMessage("STORE_NAME_2"),
        "ADDRESS" => GetMessage("STORE_ADR_2"),
        "DESCRIPTION" => GetMessage("STORE_DESCR_2"),
        "GPS_N" => GetMessage("STORE_GPS_N_2"),
        "GPS_S" => GetMessage("STORE_GPS_S_2"),
        "PHONE" => GetMessage("STORE_PHONE_2"),
        "EMAIL" => ($siteEmail) ? $siteEmail : GetMessage("STORE_EMAIL_2"),
        "SCHEDULE" => GetMessage("STORE_PHONE_SCHEDULE_2"),
        "IMAGE_ID" => $fId,
        "SITE_ID" => WIZARD_SITE_ID,
    );
    $newStoreId2 = CCatalogStore::Add($arStoreFields);
    if($newStoreId2)
    {
        CCatalogDocs::synchronizeStockQuantity($newStoreId2);
    }
    //adding user fields
	$arUserFields = array (
		array (
			'ENTITY_ID' => 'CAT_STORE',
			'FIELD_NAME' => 'UF_NL_SHOP_MAIN',
			'USER_TYPE_ID' => 'boolean',
			'XML_ID' => 'UF_NL_SHOP_MAIN',
			'SORT' => '100',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
            'SETTINGS' => array(
                'DEFAULT_VALUE' => '0',
            ),
		),
		array (
			'ENTITY_ID' => 'CAT_STORE',
			'FIELD_NAME' => 'UF_NL_SHOP_METRO',
			'USER_TYPE_ID' => 'string',
			'XML_ID' => 'UF_NL_SHOP_METRO',
			'SORT' => '200',
			'MULTIPLE' => 'N',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
		),
		array (
			'ENTITY_ID' => 'CAT_STORE',
			'FIELD_NAME' => 'UF_NL_SHOP_PHOTOS',
			'USER_TYPE_ID' => 'file',
			'XML_ID' => 'UF_NL_SHOP_PHOTOS',
			'SORT' => '300',
			'MULTIPLE' => 'Y',
			'MANDATORY' => 'N',
			'SHOW_FILTER' => 'N',
			'SHOW_IN_LIST' => 'Y',
			'EDIT_IN_LIST' => 'Y',
			'IS_SEARCHABLE' => 'Y',
            'SETTINGS' => array(
                'LIST_WIDTH' => '307',
                'LIST_HEIGHT' => '189',
                'EXTENSIONS' => 'jpg, gif, bmp, png, jpeg',
            ),
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
			WizardServices::IncludeServiceLang("catalog.php", $languageID);
			$arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
		}

		$arFields["EDIT_FORM_LABEL"] = $arLabelNames;
		$arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
		$arFields["LIST_FILTER_LABEL"] = $arLabelNames;

		$ID_USER_FIELD = $obUserField->Add($arFields);
	}
    if ($newStoreId) {
        $fileArray = CFile::MakeFileArray(WIZARD_ABSOLUTE_PATH . GetMessage("STORE_PHOTO_1"));
        $fId = CFile::SaveFile($fileArray, "store");
        $GLOBALS["USER_FIELD_MANAGER"]->Update("CAT_STORE", $newStoreId, array('UF_NL_SHOP_MAIN' => 1));
        $GLOBALS["USER_FIELD_MANAGER"]->Update("CAT_STORE", $newStoreId, array('UF_NL_SHOP_METRO' => GetMessage('STORE_METRO_1')));
        $GLOBALS["USER_FIELD_MANAGER"]->Update("CAT_STORE", $newStoreId, array('UF_NL_SHOP_PHOTOS' => array($fId)));
    }
    if ($newStoreId2) {
        $fileArray = CFile::MakeFileArray(WIZARD_ABSOLUTE_PATH . GetMessage("STORE_PHOTO_2"));
        $fId = CFile::SaveFile($fileArray, "store");
        $GLOBALS["USER_FIELD_MANAGER"]->Update("CAT_STORE", $newStoreId2, array('UF_NL_SHOP_METRO' => GetMessage('STORE_METRO_2')));
        $GLOBALS["USER_FIELD_MANAGER"]->Update("CAT_STORE", $newStoreId2, array('UF_NL_SHOP_PHOTOS' => array($fId)));
    }
}

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH . "/xml/" . LANGUAGE_ID . "/catalog.xml";

$iblockCode = "NL_GOODS_" . WIZARD_SITE_ID;
$iblockType = "catalog";

CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFile, array("NL_GOODS" => $iblockCode));

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
$IBLOCK_CATALOG_ID = false;
if ($arIBlock = $rsIBlock->Fetch())
{
	$IBLOCK_CATALOG_ID = $arIBlock["ID"];
}

if (WIZARD_INSTALL_DEMO_DATA && $IBLOCK_CATALOG_ID)
{
	$boolFlag = true;
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_CATALOG_ID);
	if (!empty($arSKU))
	{
		$boolFlag = CCatalog::UnLinkSKUIBlock($IBLOCK_CATALOG_ID);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't unlink iblocks";
			}
			//die($strError);
		}
		$boolFlag = CIBlock::Delete($arSKU['IBLOCK_ID']);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't delete offers iblock";
			}
			//die($strError);
		}
	}
	if ($boolFlag)
	{
		$boolFlag = CIBlock::Delete($IBLOCK_CATALOG_ID);
		if (!$boolFlag)
		{
			$strError = "";
			if ($ex = $APPLICATION->GetException())
			{
				$strError = $ex->GetString();
			}
			else
			{
				$strError = "Couldn't delete catalog iblock";
			}
			//die($strError);
		}
	}
	if ($boolFlag)
	{
		$IBLOCK_CATALOG_ID = false;
	}
}

if($IBLOCK_CATALOG_ID == false)
{
	$permissions = Array(
		"1" => "X",
		"2" => "R"
	);
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "sale_administrator"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	}
	$dbGroup = CGroup::GetList($by = "", $order = "", Array("STRING_ID" => "content_editor"));
	if($arGroup = $dbGroup -> Fetch())
	{
		$permissions[$arGroup["ID"]] = 'W';
	}
	if ($_SESSION["WIZARD_MANUFACTURE_IBLOCK_CODE"])
	{
		$IBLOCK_MANUFACTURE_CODE = $_SESSION["WIZARD_MANUFACTURE_IBLOCK_CODE"];
		unset($_SESSION["WIZARD_MANUFACTURE_IBLOCK_CODE"]);
	}
	CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFile, array("NL_MANUFACTURE" => $IBLOCK_MANUFACTURE_CODE));
	
	$IBLOCK_CATALOG_ID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFile,
		$iblockCode,
		$iblockType,
		WIZARD_SITE_ID,
		$permissions
	);
	if ($IBLOCK_CATALOG_ID < 1)
		return;
}
else
{
	$arSites = array();
	$db_res = CIBlock::GetSite($IBLOCK_CATALOG_ID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"];
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($IBLOCK_CATALOG_ID, array("LID" => $arSites));
	}
}
$_SESSION["WIZARD_CATALOG_IBLOCK_ID"] = $IBLOCK_CATALOG_ID;
?>