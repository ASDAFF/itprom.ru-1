<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog"))
    return;

$iblockXMLFileOffers = WIZARD_SERVICE_RELATIVE_PATH . "/xml/" . LANGUAGE_ID . "/catalog_sku.xml";

$iblockCodeOffers = "NL_GOODS_OFFERS_" . WIZARD_SITE_ID;
$iblockTypeOffers = "offers";
$iblockCatalogCode = "NL_GOODS_" . WIZARD_SITE_ID;
$iblockManufactureCode = "NL_MANUFACTURE_" . WIZARD_SITE_ID;

CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFileOffers, array("NL_GOODS_OFFERS" => $iblockCodeOffers));
// костыль с xml_id
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFileOffers, array("NL_GOODS" => "NL_GOODS"));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"] . $iblockXMLFileOffers, array("NL_MANUFACTURE" => $iblockManufactureCode));

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCodeOffers, "TYPE" => $iblockTypeOffers));
$IBLOCK_OFFERS_ID = false;
if ($arIBlock = $rsIBlock->Fetch())
{
	$IBLOCK_OFFERS_ID = $arIBlock["ID"];
	if (WIZARD_INSTALL_DEMO_DATA)
	{
		CIBlock::Delete($arIBlock["ID"]);
		$IBLOCK_OFFERS_ID = false;
	}
}

if($IBLOCK_OFFERS_ID == false)
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
	
	$IBLOCK_OFFERS_ID = WizardServices::ImportIBlockFromXML(
		$iblockXMLFileOffers,
		$iblockCodeOffers,
		$iblockTypeOffers,
		WIZARD_SITE_ID,
		$permissions
	);
	
	if ($IBLOCK_OFFERS_ID < 1)
		return;
}
else
{
	$arSites = array();
	$db_res = CIBlock::GetSite($IBLOCK_OFFERS_ID);
	while ($res = $db_res->Fetch())
		$arSites[] = $res["LID"];
	if (!in_array(WIZARD_SITE_ID, $arSites))
	{
		$arSites[] = WIZARD_SITE_ID;
		$iblock = new CIBlock;
		$iblock->Update($IBLOCK_OFFERS_ID, array("LID" => $arSites));
	}
}
$_SESSION["WIZARD_OFFERS_IBLOCK_ID"] = $IBLOCK_OFFERS_ID;
?>