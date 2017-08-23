<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule('sale'))
	return;

//$dbSite = CSite::GetByID(WIZARD_SITE_ID);
//if($arSite = $dbSite -> Fetch())
//	$lang = $arSite["LANGUAGE_ID"];
//if(strlen($lang) <= 0)
	$lang = "ru";
//$bRus = false;
//if($lang == "ru")
	$bRus = true;

/*$defCurrency = "EUR";
if($lang == "ru")*/
	$defCurrency = "RUB";
/*elseif($lang == "en")
	$defCurrency = "USD";*/

$delivery = $wizard->GetVar("delivery");
$shopLocalization = $wizard->GetVar("shopLocalization");

WizardServices::IncludeServiceLang("step2.php", $lang);

	$locationGroupID = 0;
	$arLocation4Delivery = Array();
	$arLocationArr = Array();

	if(\Bitrix\Main\Config\Option::get('sale', 'sale_locationpro_migrated', '') == 'Y') // CSaleLocation::isLocationProMigrated()
	{
		$res = \Bitrix\Sale\Location\LocationTable::getList(array('filter' => array('=TYPE.CODE' => 'COUNTRY'), 'select' => array('ID')));
		while($item = $res->fetch())
		{
			$arLocation4Delivery[] = Array("LOCATION_ID" => $item["ID"], "LOCATION_TYPE"=>"L");
		}
	}
	else
	{
		$dbLocation = CSaleLocation::GetList(Array(), array("LID" => $lang));
		while($arLocation = $dbLocation->Fetch())
		{
			$arLocation4Delivery[] = Array("LOCATION_ID" => $arLocation["ID"], "LOCATION_TYPE"=>"L");
			$arLocationArr[] = $arLocation["ID"];
		}

		$dbGroup = CSaleLocationGroup::GetList();
		if($arGroup = $dbGroup->Fetch())
		{
			$arLocation4Delivery[] = Array("LOCATION_ID" => $arGroup["ID"], "LOCATION_TYPE"=>"G");
		}
		else
		{
			$groupLang = array(
				array("LID" => "en", "NAME" => "Group 1")
			);

			if($bRus)
				$groupLang[] = array("LID" => $lang, "NAME" => GetMessage("SALE_WIZARD_GROUP"));
				
			$locationGroupID = CSaleLocationGroup::Add(
					array(
						"SORT" => 150,
						"LOCATION_ID" => $arLocationArr,
						"LANG" => $groupLang
					)
				);
		}
		//Location group
		if(IntVal($locationGroupID) > 0)
			$arLocation4Delivery[] = Array("LOCATION_ID" => $locationGroupID, "LOCATION_TYPE"=>"G");
	}

	
	$dbDelivery = CSaleDelivery::GetList(array(), Array("LID" => WIZARD_SITE_ID));
	if(!$dbDelivery->Fetch())
	{
		//delivery handler
		$arFields = Array(
			"NAME" => GetMessage("SALE_WIZARD_COUR"),
			"LID" => WIZARD_SITE_ID,
			"CODE" => "nl_courier",
			"PERIOD_FROM" => 0,
			"PERIOD_TO" => 0,
			"PERIOD_TYPE" => "D",
			"WEIGHT_FROM" => 0,
			"WEIGHT_TO" => 0,
			"ORDER_PRICE_FROM" => 0,
			"ORDER_PRICE_TO" => 0,
			"ORDER_CURRENCY" => $defCurrency,
			"ACTIVE" => "Y",
			"PRICE" => ($bRus ? "500" : "30"),
			"CURRENCY" => $defCurrency,
			"SORT" => 100,
			"DESCRIPTION" => GetMessage("SALE_WIZARD_COUR_DESCR"),
			"LOCATIONS" => $arLocation4Delivery,
		);
		
		CSaleDelivery::Add($arFields);
		
		$arFields = Array(
			"NAME" => GetMessage("SALE_WIZARD_COUR1"),
			"LID" => WIZARD_SITE_ID,
			"CODE" => "nl_self",
			"PERIOD_FROM" => 0,
			"PERIOD_TO" => 0,
			"PERIOD_TYPE" => "D",
			"WEIGHT_FROM" => 0,
			"WEIGHT_TO" => 0,
			"ORDER_PRICE_FROM" => 0,
			"ORDER_PRICE_TO" => 0,
			"ORDER_CURRENCY" => $defCurrency,
			"ACTIVE" => "Y",
			"PRICE" => 0,
			"CURRENCY" => $defCurrency,
			"SORT" => 200,
			"DESCRIPTION" => GetMessage("SALE_WIZARD_COUR1_DESCR"),
			"LOCATIONS" => $arLocation4Delivery,
		);
		
		CSaleDelivery::Add($arFields);
	}
	
	$dbDelivery = CSaleDeliveryHandler::GetList();
	if(!$dbDelivery->Fetch())
	{
		$arFields = Array(
			"LID" => "",
			"ACTIVE" => "N",
			"HID" => "cpcr",
			"NAME" => GetMessage("SALE_WIZARD_SPSR"),
			"SORT" => 100,
			"DESCRIPTION" => GetMessage("SALE_WIZARD_SPSR_DESCR"),
			"HANDLERS" => "/bitrix/modules/sale/delivery/delivery_cpcr.php",
			"SETTINGS" => "8",
			"PROFILES" => "",
			"TAX_RATE" => 0,
		);
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/ru/delivery/".$arFields["HID"]."_logo.gif"))
			$arFields["LOGOTIP"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/ru/delivery/".$arFields["HID"]."_logo.gif");

		CSaleDeliveryHandler::Set("cpcr", $arFields);

		$arFields = Array(
			"LID" => "",
			"ACTIVE" => "Y",
			"HID" => "russianpost",
			"NAME" => GetMessage("SALE_WIZARD_MAIL"),
			"SORT" => 200,
			"DESCRIPTION" => "",
			"HANDLERS" => "/bitrix/modules/sale/delivery/delivery_russianpost.php",
			"SETTINGS" => "23",
			"PROFILES" => "",
			"TAX_RATE" => 0,
		);

		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/ru/delivery/".$arFields["HID"]."_logo.gif"))
			$arFields["LOGOTIP"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/ru/delivery/".$arFields["HID"]."_logo.gif");

		if($delivery["russianpost"] != "Y")
			$arFields["ACTIVE"] = "N";
		CSaleDeliveryHandler::Set("russianpost", $arFields);

		//new russian post
		$arFields = Array(
			"LID" => "",
			"ACTIVE" => "Y",
			"HID" => "rus_post",
			"NAME" => GetMessage("SALE_WIZARD_MAIL2"),
			"SORT" => 400,
			"DESCRIPTION" => "",
			"HANDLERS" => "/bitrix/modules/sale/delivery/delivery_rus_post.php",
			"SETTINGS" => "23",
			"PROFILES" => "",
			"TAX_RATE" => 0,
		);

		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/ru/delivery/".$arFields["HID"]."_logo.gif"))
			$arFields["LOGOTIP"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/ru/delivery/".$arFields["HID"]."_logo.gif");

		if($delivery["rus_post"] != "Y")
			$arFields["ACTIVE"] = "N";
		CSaleDeliveryHandler::Set("rus_post", $arFields);

		$arFields = Array(
			"LID" => "",
			"ACTIVE" => "Y",
			"HID" => "rus_post_first",
			"NAME" => GetMessage("SALE_WIZARD_MAIL_FIRST"),
			"SORT" => 500,
			"DESCRIPTION" => "",
			"HANDLERS" => "/bitrix/modules/sale/delivery/delivery_rus_post_first.php",
			"SETTINGS" => "23",
			"PROFILES" => "",
			"TAX_RATE" => 0,
		);

		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/ru/delivery/".$arFields["HID"]."_logo.gif"))
			$arFields["LOGOTIP"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/ru/delivery/".$arFields["HID"]."_logo.gif");

		if($delivery["rus_post_first"] != "Y")
			$arFields["ACTIVE"] = "N";
		CSaleDeliveryHandler::Set("rus_post_first", $arFields);
				
		$arFields = Array(
			"LID" => "",
			"ACTIVE" => "Y",
			"HID" => "ups",
			"NAME" => "UPS",
			"SORT" => 300,
			"DESCRIPTION" => GetMessage("SALE_WIZARD_UPS"),
			"HANDLERS" => "/bitrix/modules/sale/delivery/delivery_ups.php",
			"SETTINGS" => "/bitrix/modules/sale/delivery/ups/ru_csv_zones.csv;/bitrix/modules/sale/delivery/ups/ru_csv_export.csv",
			"PROFILES" => "",
			"TAX_RATE" => 0,
		);

		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/delivery/".$arFields["HID"]."_logo.gif"))
			$arFields["LOGOTIP"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/delivery/".$arFields["HID"]."_logo.gif");

		if($delivery["ups"] != "Y")
			$arFields["ACTIVE"] = "N";
		CSaleDeliveryHandler::Set("ups", $arFields);
		
		$arFields = Array(
			"LID" => "",
			"ACTIVE" => "Y",
			"HID" => "dhlusa",
			"NAME" => "DHL (USA)",
			"SORT" => 300,
			"DESCRIPTION" => GetMessage("SALE_WIZARD_UPS"),
			"HANDLERS" => "/bitrix/modules/sale/delivery/delivery_dhl_usa.php ",
			"SETTINGS" => "",
			"PROFILES" => "",
			"TAX_RATE" => 0,
		);

		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/delivery/".$arFields["HID"]."_logo.gif"))
			$arFields["LOGOTIP"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/delivery/".$arFields["HID"]."_logo.gif");
		
		if($delivery["dhl"] != "Y")
			$arFields["ACTIVE"] = "N";
		CSaleDeliveryHandler::Set("dhlusa", $arFields);
}
?>