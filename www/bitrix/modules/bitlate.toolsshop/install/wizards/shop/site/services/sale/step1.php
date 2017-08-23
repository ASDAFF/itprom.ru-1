<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

//Настройки сайта
$siteTelephone = $wizard->GetVar("sitePhone");
COption::SetOptionString("shop", "sitePhone", $siteTelephone, false, WIZARD_SITE_ID);
$siteEmail = $wizard->GetVar("siteEmail");
COption::SetOptionString("shop", "siteEmail", $siteEmail, false, WIZARD_SITE_ID);
COption::SetOptionString('main', 'email_from', $siteEmail);
$siteName = $wizard->GetVar("siteName");
COption::SetOptionString("shop", "siteName", $siteName, false, WIZARD_SITE_ID);
COption::SetOptionString('main', 'site_name', $siteName);

//Настройка интернет-маганиза
$shopEmail = $wizard->GetVar("shopEmail");
COption::SetOptionString('sale', 'order_email', $shopEmail);

if(!CModule::IncludeModule('sale'))
	return;

$defCurrency = "RUB";

//Добавление типа пательщика - физ. лицо, если еще нет
$arPersonTypeNames = array();
$dbPerson = CSalePersonType::GetList(array(), array("LID" => WIZARD_SITE_ID));
while ($arPerson = $dbPerson->Fetch())
{
	$arPersonTypeNames[$arPerson["ID"]] = $arPerson["NAME"];
}
$fizExist = in_array(GetMessage("SALE_WIZARD_PERSON_1"), $arPersonTypeNames);
if ($fizExist)
{
	$arGeneralInfo["personType"]["fiz"] = array_search(GetMessage("SALE_WIZARD_PERSON_1"), $arPersonTypeNames);
	CSalePersonType::Update(array_search(GetMessage("SALE_WIZARD_PERSON_1"), $arPersonTypeNames), Array(
			"ACTIVE" => "Y",
		)
	);
}
else
{
	$arGeneralInfo["personType"]["fiz"] = CSalePersonType::Add(Array(
		"LID" => WIZARD_SITE_ID,
		"NAME" => GetMessage("SALE_WIZARD_PERSON_1"),
		"SORT" => "100"
		)
	);
}
//Добавление групп свойств заказа, если еще нет
if ($fizExist)
{
	$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList(Array(), Array("PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"], "NAME" => GetMessage("SALE_WIZARD_PROP_GROUP_FIZ1")), false, false, array("ID"));
	if ($arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext())
		$arGeneralInfo["propGroup"]["user_fiz"] = $arSaleOrderPropsGroup["ID"];

	$dbSaleOrderPropsGroup = CSaleOrderPropsGroup::GetList(Array(),Array("PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"], "NAME" => GetMessage("SALE_WIZARD_PROP_GROUP_FIZ2")), false, false, array("ID"));
	if ($arSaleOrderPropsGroup = $dbSaleOrderPropsGroup->GetNext())
		$arGeneralInfo["propGroup"]["adres_fiz"] = $arSaleOrderPropsGroup["ID"];

}
else
{
	$arGeneralInfo["propGroup"]["user_fiz"] = CSaleOrderPropsGroup::Add(Array("PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"], "NAME" => GetMessage("SALE_WIZARD_PROP_GROUP_FIZ1"), "SORT" => 100));
	$arGeneralInfo["propGroup"]["adres_fiz"] = CSaleOrderPropsGroup::Add(Array("PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"], "NAME" => GetMessage("SALE_WIZARD_PROP_GROUP_FIZ2"), "SORT" => 200));
}

		
//propGroup список свойств
$arProps = Array();

$arProps[] = Array(
	"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
	"NAME" => GetMessage("SALE_WIZARD_PROP_FIO"),
	"TYPE" => "TEXT",
	"REQUIED" => "Y",
	"DEFAULT_VALUE" => "",
	"SORT" => 100,
	"USER_PROPS" => "Y",
	"IS_LOCATION" => "N",
	"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
	"SIZE1" => 40,
	"SIZE2" => 0,
	"DESCRIPTION" => "",
	"IS_EMAIL" => "N",
	"IS_PROFILE_NAME" => "Y",
	"IS_PAYER" => "Y",
	"IS_LOCATION4TAX" => "N",
	"CODE" => "NAME",
	"IS_FILTERED" => "Y",
);
$arProps[] = Array(
	"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
	"NAME" => GetMessage("SALE_WIZARD_PROP_EMAIL"),
	"TYPE" => "TEXT",
	"REQUIED" => "Y",
	"DEFAULT_VALUE" => "",
	"SORT" => 110,
	"USER_PROPS" => "Y",
	"IS_LOCATION" => "N",
	"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
	"SIZE1" => 40,
	"SIZE2" => 0,
	"DESCRIPTION" => "",
	"IS_EMAIL" => "Y",
	"IS_PROFILE_NAME" => "N",
	"IS_PAYER" => "N",
	"IS_LOCATION4TAX" => "N",
	"CODE" => "EMAIL",
	"IS_FILTERED" => "Y",
);
$arProps[] = Array(
	"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
	"NAME" => GetMessage("SALE_WIZARD_PROP_TEL"),
	"TYPE" => "TEXT",
	"REQUIED" => "Y",
	"DEFAULT_VALUE" => "",
	"SORT" => 120,
	"USER_PROPS" => "Y",
	"IS_LOCATION" => "N",
	"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
	"SIZE1" => 0,
	"SIZE2" => 0,
	"DESCRIPTION" => "",
	"IS_EMAIL" => "N",
	"IS_PROFILE_NAME" => "N",
	"IS_PAYER" => "N",
	"IS_LOCATION4TAX" => "N",
	"CODE" => "PHONE",
	"IS_FILTERED" => "N",
);
$arProps[] = Array(
	"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
	"NAME" => GetMessage("SALE_WIZARD_PROP_INDEX"),
	"TYPE" => "TEXT",
	"REQUIED" => "N",
	"DEFAULT_VALUE" => "101000",
	"SORT" => 150,
	"USER_PROPS" => "Y",
	"IS_LOCATION" => "N",
	"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
	"SIZE1" => 8,
	"SIZE2" => 0,
	"DESCRIPTION" => "",
	"IS_EMAIL" => "N",
	"IS_PROFILE_NAME" => "N",
	"IS_PAYER" => "N",
	"IS_LOCATION4TAX" => "N",
	"CODE" => "ZIP",
	"IS_FILTERED" => "N",
	"IS_ZIP" => "Y",
);
$arProps[] = Array(
	"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
	"NAME" => GetMessage("SALE_WIZARD_PROP_ADDRESS"),
	"TYPE" => "TEXT",
	"REQUIED" => "Y",
	"DEFAULT_VALUE" => '',
	"SORT" => 140,
	"USER_PROPS" => "Y",
	"IS_LOCATION" => "N",
	"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["user_fiz"],
	"SIZE1" => 40,
	"SIZE2" => 0,
	"DESCRIPTION" => "",
	"IS_EMAIL" => "N",
	"IS_PROFILE_NAME" => "N",
	"IS_PAYER" => "N",
	"IS_LOCATION4TAX" => "N",
	"CODE" => "ADDRESS",
	"IS_FILTERED" => "Y",
);
$arProps[] = Array(
	"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
	"NAME" => GetMessage("SALE_WIZARD_PROP_CITY"),
	"TYPE" => "LOCATION",
	"REQUIED" => "Y",
	"DEFAULT_VALUE" => '',
	"SORT" => 130,
	"USER_PROPS" => "Y",
	"IS_LOCATION" => "Y",
	"PROPS_GROUP_ID" => $arGeneralInfo["propGroup"]["adres_fiz"],
	"SIZE1" => 40,
	"SIZE2" => 0,
	"DESCRIPTION" => "",
	"IS_EMAIL" => "N",
	"IS_PROFILE_NAME" => "N",
	"IS_PAYER" => "N",
	"IS_LOCATION4TAX" => "N",
	"CODE" => "CITY",
	"IS_FILTERED" => "N",
	"INPUT_FIELD_LOCATION" => ""
);

$propCityId = 0;
foreach($arProps as $prop)
{
	$variants = Array();
	if(!empty($prop["VARIANTS"]))
	{
		$variants = $prop["VARIANTS"];
		unset($prop["VARIANTS"]);
	}

	if ($prop["CODE"] == "LOCATION" && $propCityId > 0)
	{
		$prop["INPUT_FIELD_LOCATION"] = $propCityId;
		$propCityId = 0;
	}

	$dbSaleOrderProps = CSaleOrderProps::GetList(array(), array("PERSON_TYPE_ID" => $prop["PERSON_TYPE_ID"], "CODE" =>  $prop["CODE"]));
	if ($arSaleOrderProps = $dbSaleOrderProps->GetNext())
		$id = $arSaleOrderProps["ID"];
	else
		$id = CSaleOrderProps::Add($prop);

	if ($prop["CODE"] == "CITY")
	{
		$propCityId = $id;
	}
	if(strlen($prop["CODE"]) > 0)
	{
		//$arGeneralInfo["propCode"][$prop["CODE"]] = $prop["CODE"];
		$arGeneralInfo["propCodeID"][$prop["CODE"]] = $id;
		$arGeneralInfo["properies"][$prop["PERSON_TYPE_ID"]][$prop["CODE"]] = $prop;
		$arGeneralInfo["properies"][$prop["PERSON_TYPE_ID"]][$prop["CODE"]]["ID"] = $id;
	}

	if(!empty($variants))
	{
		foreach($variants as $val)
		{
			$val["ORDER_PROPS_ID"] = $id;
			CSaleOrderPropsVariant::Add($val);
		}
	}
}

//Добавление платежных систем
$arPaySystems = Array();
//Наличные курьеру
$arPaySystemTmp = Array(
	"NAME" => GetMessage("SALE_WIZARD_PS_CASH"),
	"SORT" => 80,
	"ACTIVE" => "Y",
	"DESCRIPTION" => GetMessage("SALE_WIZARD_PS_CASH_DESCR"),
	"CODE_TEMP" => "cash");
if($fizExist)
{
	$arPaySystemTmp["ACTION"][] = Array(
		"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
		"NAME" => GetMessage("SALE_WIZARD_PS_CASH"),
		"ACTION_FILE" => "/bitrix/modules/sale/payment/cash",
		"RESULT_FILE" => "",
		"NEW_WINDOW" => "N",
		"PARAMS" => "",
		"HAVE_PAYMENT" => "Y",
		"HAVE_ACTION" => "N",
		"HAVE_RESULT" => "N",
		"HAVE_PREPAY" => "N",
		"HAVE_RESULT_RECEIVE" => "N",
	);
}

$arPaySystems[] = $arPaySystemTmp;

//Яндекс.Деньги
$arPaySystems[] = Array(
	"NAME" => GetMessage("SALE_WIZARD_YMoney"),
	"SORT" => 50,
	"DESCRIPTION" => "",
	"CODE_TEMP" => "yandex_3x",
	"ACTION" => Array(Array(
		"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
		"NAME" => GetMessage("SALE_WIZARD_YMoney"),
		"ACTION_FILE" => "/bitrix/modules/sale/payment/yandex_3x",
		"RESULT_FILE" => "",
		"NEW_WINDOW" => "N",
		"PARAMS" => serialize(Array(
			"ORDER_ID" => Array("TYPE" => "ORDER", "VALUE" => "ID"),
			"USER_ID" => Array("TYPE" => "PROPERTY", "VALUE" => "FIO"),
			"ORDER_DATE" => Array("TYPE" => "ORDER", "VALUE" => "DATE_INSERT"),
			"SHOULD_PAY" => Array("TYPE" => "ORDER", "VALUE" => "PRICE"),
			"PAYMENT_VALUE" => Array("VALUE" => "PC"),
			"IS_TEST" => Array("VALUE" => "Y"),
			"CHANGE_STATUS_PAY" => Array("VALUE" => "Y"),
			"SHOP_ID" => Array("TYPE" => "", "VALUE" => ""),
			"SCID" => Array("TYPE" => "", "VALUE" => ""),
			"SHOP_KEY" => Array("TYPE" => "", "VALUE" => ""),
		)),
		"HAVE_PAYMENT" => "Y",
		"HAVE_ACTION" => "N",
		"HAVE_RESULT" => "N",
		"HAVE_PREPAY" => "N",
		"HAVE_RESULT_RECEIVE" => "Y",
	))
);

//Наложенный платеж
$arPaySystems[] = Array(
	"NAME" => GetMessage("SALE_WIZARD_PS_COLLECT"),
	"SORT" => 110,
	"ACTIVE" => "Y",
	"DESCRIPTION" => GetMessage("SALE_WIZARD_PS_COLLECT_DESCR"),
	"CODE_TEMP" => "collect",
	"ACTION" => Array(
		Array(
			"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
			"NAME" => GetMessage("SALE_WIZARD_PS_COLLECT"),
			"ACTION_FILE" => "/bitrix/modules/sale/payment/payment_forward_calc",
			"RESULT_FILE" => "",
			"NEW_WINDOW" => "N",
			"HAVE_PAYMENT" => "Y",
			"HAVE_ACTION" => "N",
			"HAVE_RESULT" => "N",
			"HAVE_PREPAY" => "N",
			"HAVE_RESULT_RECEIVE" => "N",
		)
	)
);

//Банковские карты
$logo = $_SERVER["DOCUMENT_ROOT"].WIZARD_SERVICE_RELATIVE_PATH ."/images/yandex_cards.gif";
$arPicture = CFile::MakeFileArray($logo);
$arPaySystems[] = Array(
	"NAME" => GetMessage("SALE_WIZARD_YCards"),
	"SORT" => 60,
	"DESCRIPTION" => "",
	"CODE_TEMP" => "yandex_3x",
	"ACTION" => Array(Array(
		"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
		"NAME" => GetMessage("SALE_WIZARD_YCards"),
		"ACTION_FILE" => "/bitrix/modules/sale/payment/yandex_3x",
		"RESULT_FILE" => "",
		"NEW_WINDOW" => "N",
		"PARAMS" => serialize(Array(
			"ORDER_ID" => Array("TYPE" => "ORDER", "VALUE" => "ID"),
			"USER_ID" => Array("TYPE" => "PROPERTY", "VALUE" => "FIO"),
			"ORDER_DATE" => Array("TYPE" => "ORDER", "VALUE" => "DATE_INSERT"),
			"SHOULD_PAY" => Array("TYPE" => "ORDER", "VALUE" => "PRICE"),
			"PAYMENT_VALUE" => Array("VALUE" => "AC"),
			"IS_TEST" => Array("VALUE" => "Y"),
			"CHANGE_STATUS_PAY" => Array("VALUE" => "Y"),
			"SHOP_ID" => Array("TYPE" => "", "VALUE" => ""),
			"SCID" => Array("TYPE" => "", "VALUE" => ""),
			"SHOP_KEY" => Array("TYPE" => "", "VALUE" => ""),
		)),
		"HAVE_PAYMENT" => "Y",
		"HAVE_ACTION" => "N",
		"HAVE_RESULT" => "N",
		"HAVE_PREPAY" => "N",
		"HAVE_RESULT_RECEIVE" => "Y",
		"LOGOTIP" => $arPicture
	))
);

//Терминалы
$logo = $_SERVER["DOCUMENT_ROOT"].WIZARD_SERVICE_RELATIVE_PATH ."/images/yandex_terminals.gif";
$arPicture = CFile::MakeFileArray($logo);
$arPaySystems[] = Array(
	"NAME" => GetMessage("SALE_WIZARD_YTerminals"),
	"SORT" => 70,
	"DESCRIPTION" => "",
	"CODE_TEMP" => "yandex_3x",
	"ACTION" => Array(Array(
		"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
		"NAME" => GetMessage("SALE_WIZARD_YTerminals"),
		"ACTION_FILE" => "/bitrix/modules/sale/payment/yandex_3x",
		"RESULT_FILE" => "",
		"NEW_WINDOW" => "N",
		"PARAMS" => serialize(Array(
			"ORDER_ID" => Array("TYPE" => "ORDER", "VALUE" => "ID"),
			"USER_ID" => Array("TYPE" => "PROPERTY", "VALUE" => "FIO"),
			"ORDER_DATE" => Array("TYPE" => "ORDER", "VALUE" => "DATE_INSERT"),
			"SHOULD_PAY" => Array("TYPE" => "ORDER", "VALUE" => "PRICE"),
			"PAYMENT_VALUE" => Array("VALUE" => "GP"),
			"IS_TEST" => Array("VALUE" => "Y"),
			"CHANGE_STATUS_PAY" => Array("VALUE" => "Y"),
			"SHOP_ID" => Array("TYPE" => "", "VALUE" => ""),
			"SCID" => Array("TYPE" => "", "VALUE" => ""),
			"SHOP_KEY" => Array("TYPE" => "", "VALUE" => ""),
		)),
		"HAVE_PAYMENT" => "Y",
		"HAVE_ACTION" => "N",
		"HAVE_RESULT" => "N",
		"HAVE_PREPAY" => "N",
		"HAVE_RESULT_RECEIVE" => "Y",
		"LOGOTIP" => $arPicture
	))
);

//Web Money
$arPaySystems[] = Array(
	"NAME" => GetMessage("SALE_WIZARD_PS_WM"),
	"SORT" => 90,
	"ACTIVE" => "N",
	"DESCRIPTION" => GetMessage("SALE_WIZARD_PS_WM_DESCR"),
	"CODE_TEMP" => "webmoney",
	"ACTION" => Array(Array(
		"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
		"NAME" => GetMessage("SALE_WIZARD_PS_WM"),
		"ACTION_FILE" => "/bitrix/modules/sale/payment/webmoney_web",
		"RESULT_FILE" => "",
		"NEW_WINDOW" => "Y",
		"PARAMS" => "",
		"HAVE_PAYMENT" => "Y",
		"HAVE_ACTION" => "N",
		"HAVE_RESULT" => "Y",
		"HAVE_PREPAY" => "N",
		"HAVE_RESULT_RECEIVE" => "N",
	))
);

//Сбербанк
$arPaySystems[] = Array(
	"NAME" => GetMessage("SALE_WIZARD_PS_SB"),
	"SORT" => 110,
	"DESCRIPTION" => GetMessage("SALE_WIZARD_PS_SB_DESCR"),
	"CODE_TEMP" => "sberbank",
	"ACTION" => Array(Array(
		"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
		"NAME" => GetMessage("SALE_WIZARD_PS_SB"),
		"ACTION_FILE" => "/bitrix/modules/sale/payment/sberbank_new",
		"RESULT_FILE" => "",
		"NEW_WINDOW" => "Y",
		"PARAMS" => serialize(Array(
			"COMPANY_NAME" => Array("TYPE" => "", "VALUE" => $shopOfName),
			"INN" => Array("TYPE" => "", "VALUE" => $shopINN),
			"KPP" => Array("TYPE" => "", "VALUE" => $shopKPP),
			"SETTLEMENT_ACCOUNT" => Array("TYPE" => "", "VALUE" => $shopNS),
			"BANK_NAME" => Array("TYPE" => "", "VALUE" => $shopBANK),
			"BANK_BIC" => Array("TYPE" => "", "VALUE" => $shopBANKREKV),
			"BANK_COR_ACCOUNT" => Array("TYPE" => "", "VALUE" => $shopKS),
			"ORDER_ID" => Array("TYPE" => "ORDER", "VALUE" => "ACCOUNT_NUMBER"),
			"DATE_INSERT" => Array("TYPE" => "ORDER", "VALUE" => "DATE_INSERT_DATE"),
			"PAYER_CONTACT_PERSON" => Array("TYPE" => "PROPERTY", "VALUE" => "FIO"),
			"PAYER_ZIP_CODE" => Array("TYPE" => "PROPERTY", "VALUE" => "ZIP"),
			"PAYER_COUNTRY" => Array("TYPE" => "PROPERTY", "VALUE" => "LOCATION_COUNTRY"),
			"PAYER_REGION" => Array("TYPE" => "PROPERTY", "VALUE" => "LOCATION_REGION"),
			"PAYER_CITY" => Array("TYPE" => "PROPERTY", "VALUE" => "LOCATION_CITY"),
			"PAYER_ADDRESS_FACT" => Array("TYPE" => "PROPERTY", "VALUE" => "ADDRESS"),
			"SHOULD_PAY" => Array("TYPE" => "ORDER", "VALUE" => "PRICE"),
		)),
		"HAVE_PAYMENT" => "Y",
		"HAVE_ACTION" => "N",
		"HAVE_RESULT" => "N",
		"HAVE_PREPAY" => "N",
		"HAVE_RESULT_RECEIVE" => "N",
	))

);

//PayPal
$arPaySystems[] = Array(
	"NAME" => "PayPal",
	"SORT" => 90,
	"DESCRIPTION" => "",
	"CODE_TEMP" => "paypal",
	"ACTION" => Array(Array(
		"PERSON_TYPE_ID" => $arGeneralInfo["personType"]["fiz"],
		"NAME" => "PayPal",
		"ACTION_FILE" => "/bitrix/modules/sale/payment/paypal",
		"RESULT_FILE" => "",
		"NEW_WINDOW" => "N",
		"PARAMS" => serialize(Array(
			"ORDER_ID" => Array("TYPE" => "ORDER", "VALUE" => "ID"),
			"DATE_INSERT" => Array("TYPE" => "ORDER", "VALUE" => "DATE_INSERT_DATE"),
			"SHOULD_PAY" => Array("TYPE" => "ORDER", "VALUE" => "SHOULD_PAY"),
			"CURRENCY" => Array("TYPE" => "ORDER", "VALUE" => "CURRENCY"),
		)),
		"HAVE_PAYMENT" => "Y",
		"HAVE_ACTION" => "N",
		"HAVE_RESULT" => "N",
		"HAVE_PREPAY" => "N",
		"HAVE_RESULT_RECEIVE" => "Y",
	))

);

foreach($arPaySystems as $val)
{
	$dbSalePaySystem = CSalePaySystem::GetList(array(), array("LID" => WIZARD_SITE_ID, "NAME" => $val["NAME"]), false, false, array("ID", "NAME"));
	if ($arSalePaySystem = $dbSalePaySystem->GetNext())
	{
		if ($arSalePaySystem["NAME"] == GetMessage("SALE_WIZARD_PS_SB") || $arSalePaySystem["NAME"] == GetMessage("SALE_WIZARD_PS_BILL") || $arSalePaySystem["NAME"] == GetMessage("SALE_WIZARD_PS_OS"))
		{
			foreach($val["ACTION"] as $action)
			{
				$arGeneralInfo["paySystem"][$val["CODE_TEMP"]][$action["PERSON_TYPE_ID"]] = $arSalePaySystem["ID"];
				$action["PAY_SYSTEM_ID"] = $arSalePaySystem["ID"];
				$dbSalePaySystemAction = CSalePaySystemAction::GetList(array(), array("PAY_SYSTEM_ID" =>  $arSalePaySystem["ID"], "PERSON_TYPE_ID" => $action["PERSON_TYPE_ID"]), false, false, array("ID"));
				if ($arSalePaySystemAction = $dbSalePaySystemAction->GetNext())
				{
					CSalePaySystemAction::Update($arSalePaySystemAction["ID"], $action);
				}
				else
				{
					if (strlen($action["ACTION_FILE"]) > 0
						&& file_exists($_SERVER["DOCUMENT_ROOT"].$action["ACTION_FILE"]."/logo.gif"))
					{
						$action["LOGOTIP"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$action["ACTION_FILE"]."/logo.gif");
					}

					CSalePaySystemAction::Add($action);
				}
			}
		}
	}
	else
	{
		$id = CSalePaySystem::Add(
			Array(
				"LID" => WIZARD_SITE_ID,
				"CURRENCY" => $defCurrency,
				"NAME" => $val["NAME"],
				"ACTIVE" => ($val["ACTIVE"] == "N") ? "N" : "Y",
				"SORT" => $val["SORT"],
				"DESCRIPTION" => $val["DESCRIPTION"]
			)
		);

		foreach($val["ACTION"] as &$action)
		{
			$arGeneralInfo["paySystem"][$val["CODE_TEMP"]][$action["PERSON_TYPE_ID"]] = $id;
			$action["PAY_SYSTEM_ID"] = $id;
			if (
				strlen($action["ACTION_FILE"]) > 0
				&& file_exists($_SERVER["DOCUMENT_ROOT"].$action["ACTION_FILE"]."/logo.gif")
				&& !is_array($action["LOGOTIP"])
			)
			{
				$action["LOGOTIP"] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$action["ACTION_FILE"]."/logo.gif");
			}

			CSalePaySystemAction::Add($action);
		}
	}
}

$bStatusP = false;
$dbStatus = CSaleStatus::GetList(Array("SORT" => "ASC"));
while($arStatus = $dbStatus->Fetch())
{
	$arFields = Array();
	foreach($arLanguages as $langID)
	{
		WizardServices::IncludeServiceLang("step1.php", $langID);
		$arFields["LANG"][] = Array("LID" => $langID, "NAME" => GetMessage("WIZ_SALE_STATUS_".$arStatus["ID"]), "DESCRIPTION" => GetMessage("WIZ_SALE_STATUS_DESCRIPTION_".$arStatus["ID"]));
	}
	$arFields["ID"] = $arStatus["ID"];
	CSaleStatus::Update($arStatus["ID"], $arFields);
	if($arStatus["ID"] == "P")
		$bStatusP = true;
}
if(!$bStatusP)
{
	$arFields = Array("ID" => "P", "SORT" => 150);
	foreach($arLanguages as $langID)
	{
		WizardServices::IncludeServiceLang("step1.php", $langID);
		$arFields["LANG"][] = Array("LID" => $langID, "NAME" => GetMessage("WIZ_SALE_STATUS_P"), "DESCRIPTION" => GetMessage("WIZ_SALE_STATUS_DESCRIPTION_P"));
	}

	$ID = CSaleStatus::Add($arFields);
	if ($ID !== '')
	{
		CSaleStatus::CreateMailTemplate($ID);
	}
}

if(CModule::IncludeModule("currency"))
{
	$dbCur = CCurrency::GetList($by="currency", $o = "asc");
	while($arCur = $dbCur->Fetch())
	{
		if($lang == "ru")
			CCurrencyLang::Update($arCur["CURRENCY"], $lang, array("DECIMALS" => 2, "HIDE_ZERO" => "Y"));
		elseif($arCur["CURRENCY"] == "EUR")
			CCurrencyLang::Update($arCur["CURRENCY"], $lang, array("DECIMALS" => 2, "FORMAT_STRING" => "&euro;#"));
	}
}
WizardServices::IncludeServiceLang("step1.php", $lang);

if (CModule::IncludeModule("catalog"))
{
	$dbVat = CCatalogVat::GetListEx(
		array(),
		array('RATE' => 0),
		false,
		false,
		array('ID', 'RATE')
	);
	if(!($dbVat->Fetch()))
	{
		$arF = array("ACTIVE" => "Y", "SORT" => "100", "NAME" => GetMessage("WIZ_VAT_1"), "RATE" => 0);
		CCatalogVat::Add($arF);
	}
	$dbVat = CCatalogVat::GetListEx(
		array(),
		array('RATE' => GetMessage("WIZ_VAT_2_VALUE")),
		false,
		false,
		array('ID', 'RATE')
	);
	if(!($dbVat->Fetch()))
	{
		$arF = array("ACTIVE" => "Y", "SORT" => "200", "NAME" => GetMessage("WIZ_VAT_2"), "RATE" => GetMessage("WIZ_VAT_2_VALUE"));
		CCatalogVat::Add($arF);
	}
	$dbResultList = CCatalogGroup::GetList(array(), array("CODE" => "BASE"));
	if($arRes = $dbResultList->Fetch())
	{
		$arFields = Array();
		foreach($arLanguages as $langID)
		{
			WizardServices::IncludeServiceLang("step1.php", $langID);
			$arFields["USER_LANG"][$langID] = GetMessage("WIZ_PRICE_NAME");
		}
		$arFields["BASE"] = "Y";
		if($wizard->GetVar("installPriceBASE") == "Y"){
			$db_res = CCatalogGroup::GetGroupsList(array("CATALOG_GROUP_ID"=>'1', "BUY"=>"Y"));
			if ($ar_res = $db_res->Fetch())
			{
				$wizGroupId[] = $ar_res['GROUP_ID'];
			}
			$wizGroupId[] = 2;
			$arFields["USER_GROUP"] = $wizGroupId;
			$arFields["USER_GROUP_BUY"] = $wizGroupId;
		}
		CCatalogGroup::Update($arRes["ID"], $arFields);
	}
}
