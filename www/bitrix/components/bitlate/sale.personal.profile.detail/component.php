<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("sale"))
{
	ShowError(GetMessage("SALE_MODULE_NOT_INSTALL"));
	return;
}
if (!$USER->IsAuthorized())
{
	$APPLICATION->AuthForm(GetMessage("SALE_ACCESS_DENIED"));
}

$errorMessage = '';
$successMessage = '';
$bInitVars = false;
$isNewProfileCreate = "N";

$ID = 0;
if (isset($arParams['ID']))
	$ID = (int)$arParams['ID'];
if ($ID < 0) {
	$ID = 0;
}
if ($ID == 0) {
	/* Person Type Begin */
	$dbPersonType = CSalePersonType::GetList(array("SORT" => "ASC", "NAME" => "ASC"), array("LID" => SITE_ID, "ACTIVE" => "Y"));
	$curPersonType = IntVal($_POST['PERSON_TYPE']);
	while($arPersonType = $dbPersonType->GetNext())
	{
		$arResult["PERSON_TYPES"][$arPersonType["ID"]] = $arPersonType;
	}
	foreach ($arResult["PERSON_TYPES"] as $personTypeID => $arPersonType) {
		if ($curPersonType == $arPersonType["ID"] || $curPersonType <= 0)
		{
			$curPersonType = $arPersonType["ID"];
			$arResult["PERSON_TYPES"][$personTypeID]["CHECKED"] = "Y";
		}
	}
}

$arParams['PATH_TO_LIST'] = (isset($arParams['PATH_TO_LIST']) ? trim($arParams['PATH_TO_LIST']) : '');
if ($arParams['PATH_TO_LIST'] == '')
	$arParams['PATH_TO_LIST'] = htmlspecialcharsbx($APPLICATION->GetCurPage());
$arParams["PATH_TO_DETAIL"] = trim($arParams["PATH_TO_DETAIL"]);
if ($arParams["PATH_TO_DETAIL"] == '')
	$arParams["PATH_TO_DETAIL"] = htmlspecialcharsbx($APPLICATION->GetCurPage()."?ID=#ID#");


$arParams["SET_TITLE"] = ($arParams["SET_TITLE"] == "N" ? "N" : "Y" );
if($arParams["SET_TITLE"] == 'Y')
	$APPLICATION->SetTitle(GetMessage("SPPD_TITLE").$ID);

if (!empty($_POST["reset"]))
	LocalRedirect($arParams["PATH_TO_LIST"]);

if ($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["action"] == "save" && check_bitrix_sessid() && $ID <= 0) {
	$arUserProps["PERSON_TYPE_ID"] = $curPersonType;
	$NAME = '';
	$dbOrderProps = CSaleOrderProps::GetList(
			array("SORT" => "ASC", "NAME" => "ASC"),
			array(
					"PERSON_TYPE_ID" => $arUserProps["PERSON_TYPE_ID"],
					"USER_PROPS" => "Y", "ACTIVE" => "Y", "UTIL" => "N"
				),
			false,
			false,
			array("ID", "PERSON_TYPE_ID", "NAME", "TYPE", "REQUIED", "DEFAULT_VALUE", "SORT", "USER_PROPS", "IS_LOCATION", "PROPS_GROUP_ID", "SIZE1", "SIZE2", "DESCRIPTION", "IS_EMAIL", "IS_PROFILE_NAME", "IS_PAYER", "IS_LOCATION4TAX", "CODE", "SORT")
		);
	while ($arOrderProps = $dbOrderProps->GetNext())
	{
		$bErrorField = false;
		$curVal = $_POST["ORDER_PROP_".$arOrderProps["ID"]];
		
		if ($NAME == '') {
			$NAME = Trim($curVal);
			$arResult["NAME"] = $NAME;
		}
		
		if ($arOrderProps["TYPE"] == "LOCATION" && $arOrderProps["IS_LOCATION"] == "Y")
		{
			$DELIVERY_LOCATION = IntVal($curVal);
			if (IntVal($curVal) <= 0)
				$bErrorField = true;
		}
		elseif ($arOrderProps["IS_PROFILE_NAME"] == "Y" || $arOrderProps["IS_PAYER"] == "Y" || $arOrderProps["IS_EMAIL"] == "Y")
		{
			if ($arOrderProps["IS_PROFILE_NAME"] == "Y")
			{
				$PROFILE_NAME = Trim($curVal);
				if (strlen($PROFILE_NAME) <= 0)
					$bErrorField = true;
			}
			if ($arOrderProps["IS_PAYER"] == "Y")
			{
				$PAYER_NAME = Trim($curVal);
				if (strlen($PAYER_NAME) <= 0)
					$bErrorField = true;
			}
			if ($arOrderProps["IS_EMAIL"] == "Y")
			{
				$USER_EMAIL = Trim($curVal);
				if (strlen($USER_EMAIL) <= 0 || !check_email($USER_EMAIL))
					$bErrorField = true;
			}
		}
		elseif ($arOrderProps["REQUIED"] == "Y")
		{
			if ($arOrderProps["TYPE"] == "TEXT" || $arOrderProps["TYPE"] == "TEXTAREA" || $arOrderProps["TYPE"] == "RADIO" || $arOrderProps["TYPE"] == "SELECT")
			{
				if (strlen($curVal) <= 0)
					$bErrorField = true;
			}
			elseif ($arOrderProps["TYPE"] == "LOCATION")
			{
				if (IntVal($curVal) <= 0)
					$bErrorField = true;
			}
			elseif ($arOrderProps["TYPE"] == "MULTISELECT")
			{
				if (!is_array($curVal) || count($curVal) <= 0)
					$bErrorField = true;
			}
		}
		if ($bErrorField)
			$errorMessage .= GetMessage("SALE_NO_FIELD")." \"".$arOrderProps["NAME"]."\".<br />";
	}
	if (strlen($errorMessage) <= 0)
	{
		$arFields = array(
			"NAME" => $NAME,
			"USER_ID" => IntVal($USER->GetID()),
			"PERSON_TYPE_ID" => $arUserProps["PERSON_TYPE_ID"]
		);
		$ID = CSaleOrderUserProps::Add($arFields);
		if (!$ID)
			$errorMessage .= GetMessage("SALE_ERROR_EDIT_PROF")."<br />";
	}

	if (strlen($errorMessage) <= 0)
	{
		$dbOrderProps = CSaleOrderProps::GetList(
				array("SORT" => "ASC", "NAME" => "ASC"),
				array(
						"PERSON_TYPE_ID" => $arUserProps["PERSON_TYPE_ID"],
						"USER_PROPS" => "Y", "ACTIVE" => "Y", "UTIL" => "N"
					),
				false,
				false,
				array("ID", "PERSON_TYPE_ID", "NAME", "TYPE", "REQUIED", "DEFAULT_VALUE", "SORT", "USER_PROPS", "IS_LOCATION", "PROPS_GROUP_ID", "SIZE1", "SIZE2", "DESCRIPTION", "IS_EMAIL", "IS_PROFILE_NAME", "IS_PAYER", "IS_LOCATION4TAX", "CODE", "SORT")
			);
		while ($arOrderProps = $dbOrderProps->GetNext())
		{
			$curVal = $_POST["ORDER_PROP_".$arOrderProps["ID"]];
			if ($arOrderProps["TYPE"]=="MULTISELECT")
			{
				$curVal = "";
				for ($i = 0, $cnt = count($_POST["ORDER_PROP_".$arOrderProps["ID"]]); $i < $cnt; $i++)
				{
					if ($i > 0)
						$curVal .= ",";
					$curVal .= $_POST["ORDER_PROP_".$arOrderProps["ID"]][$i];
				}
			}

			if (isset($_POST["ORDER_PROP_".$arOrderProps["ID"]]))
			{

				$arFields = array(
						"USER_PROPS_ID" => $ID,
						"ORDER_PROPS_ID" => $arOrderProps["ID"],
						"NAME" => $arOrderProps["NAME"],
						"VALUE" => $curVal
					);

				CSaleOrderUserPropsValue::Add($arFields);
			}
		}
	}
	
	if (strlen($errorMessage) > 0)
		$bInitVars = True;
	
	if ($_POST["action"] == "save" && strlen($errorMessage) <= 0) {
		$successMessage = GetMessage("SALE_SUCCESS_ADD_PROF");
        $isNewProfileCreate = "Y";
    }
}
elseif ($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["action"] == "save" && check_bitrix_sessid() && $ID > 0)
{
	$dbUserProps = CSaleOrderUserProps::GetList(
			array("DATE_UPDATE" => "DESC"),
			array(
					"ID" => $ID,
					"USER_ID" => IntVal($USER->GetID())
				),
			false,
			false,
			array("ID", "PERSON_TYPE_ID", "DATE_UPDATE")
		);
	if (!($arUserProps = $dbUserProps->Fetch()))
		$errorMessage .= GetMessage("SALE_NO_PROFILE")."<br />";

	if (strlen($errorMessage) <= 0)
	{
		$NAME = "";
		$dbOrderProps = CSaleOrderProps::GetList(
				array("SORT" => "ASC", "NAME" => "ASC"),
				array(
						"PERSON_TYPE_ID" => $arUserProps["PERSON_TYPE_ID"],
						"USER_PROPS" => "Y", "ACTIVE" => "Y", "UTIL" => "N"
					),
				false,
				false,
				array("ID", "PERSON_TYPE_ID", "NAME", "TYPE", "REQUIED", "DEFAULT_VALUE", "SORT", "USER_PROPS", "IS_LOCATION", "PROPS_GROUP_ID", "SIZE1", "SIZE2", "DESCRIPTION", "IS_EMAIL", "IS_PROFILE_NAME", "IS_PAYER", "IS_LOCATION4TAX", "CODE", "SORT")
			);
		while ($arOrderProps = $dbOrderProps->GetNext())
		{
			$bErrorField = false;
			$curVal = $_POST["ORDER_PROP_".$arOrderProps["ID"]];
			
			if ($NAME == '') {
				$NAME = Trim($curVal);
				$arResult["NAME"] = $NAME;
			}

			if ($arOrderProps["TYPE"] == "LOCATION" && $arOrderProps["IS_LOCATION"] == "Y")
			{
				$DELIVERY_LOCATION = IntVal($curVal);
				if (IntVal($curVal) <= 0)
					$bErrorField = true;
			}
			elseif ($arOrderProps["IS_PROFILE_NAME"] == "Y" || $arOrderProps["IS_PAYER"] == "Y" || $arOrderProps["IS_EMAIL"] == "Y")
			{
				if ($arOrderProps["IS_PROFILE_NAME"] == "Y")
				{
					$PROFILE_NAME = Trim($curVal);
					if (strlen($PROFILE_NAME) <= 0)
						$bErrorField = true;
				}
				if ($arOrderProps["IS_PAYER"] == "Y")
				{
					$PAYER_NAME = Trim($curVal);
					if (strlen($PAYER_NAME) <= 0)
						$bErrorField = true;
				}
				if ($arOrderProps["IS_EMAIL"] == "Y")
				{
					$USER_EMAIL = Trim($curVal);
					if (strlen($USER_EMAIL) <= 0 || !check_email($USER_EMAIL))
						$bErrorField = true;
				}
			}
			elseif ($arOrderProps["REQUIED"] == "Y")
			{
				if ($arOrderProps["TYPE"] == "TEXT" || $arOrderProps["TYPE"] == "TEXTAREA" || $arOrderProps["TYPE"] == "RADIO" || $arOrderProps["TYPE"] == "SELECT")
				{
					if (strlen($curVal) <= 0)
						$bErrorField = true;
				}
				elseif ($arOrderProps["TYPE"] == "LOCATION")
				{
					if (IntVal($curVal) <= 0)
						$bErrorField = true;
				}
				elseif ($arOrderProps["TYPE"] == "MULTISELECT")
				{
					if (!is_array($curVal) || count($curVal) <= 0)
						$bErrorField = true;
				}
			}
			if ($bErrorField)
				$errorMessage .= GetMessage("SALE_NO_FIELD")." \"".$arOrderProps["NAME"]."\".<br />";
		}
	}

	if (strlen($errorMessage) <= 0)
	{
		$arFields = array("NAME" => $NAME);
		if (!CSaleOrderUserProps::Update($ID, $arFields))
			$errorMessage .= GetMessage("SALE_ERROR_EDIT_PROF")."<br />";
	}

	if (strlen($errorMessage) <= 0)
	{
		CSaleOrderUserPropsValue::DeleteAll($ID);

		$dbOrderProps = CSaleOrderProps::GetList(
				array("SORT" => "ASC", "NAME" => "ASC"),
				array(
						"PERSON_TYPE_ID" => $arUserProps["PERSON_TYPE_ID"],
						"USER_PROPS" => "Y", "ACTIVE" => "Y", "UTIL" => "N"
					),
				false,
				false,
				array("ID", "PERSON_TYPE_ID", "NAME", "TYPE", "REQUIED", "DEFAULT_VALUE", "SORT", "USER_PROPS", "IS_LOCATION", "PROPS_GROUP_ID", "SIZE1", "SIZE2", "DESCRIPTION", "IS_EMAIL", "IS_PROFILE_NAME", "IS_PAYER", "IS_LOCATION4TAX", "CODE", "SORT")
			);
		while ($arOrderProps = $dbOrderProps->GetNext())
		{
			$curVal = $_POST["ORDER_PROP_".$arOrderProps["ID"]];
			if ($arOrderProps["TYPE"]=="MULTISELECT")
			{
				$curVal = "";
				for ($i = 0, $cnt = count($_POST["ORDER_PROP_".$arOrderProps["ID"]]); $i < $cnt; $i++)
				{
					if ($i > 0)
						$curVal .= ",";
					$curVal .= $_POST["ORDER_PROP_".$arOrderProps["ID"]][$i];
				}
			}

			if (isset($_POST["ORDER_PROP_".$arOrderProps["ID"]]))
			{

				$arFields = array(
						"USER_PROPS_ID" => $ID,
						"ORDER_PROPS_ID" => $arOrderProps["ID"],
						"NAME" => $arOrderProps["NAME"],
						"VALUE" => $curVal
					);

				CSaleOrderUserPropsValue::Add($arFields);
			}
		}
	}
	
	if (strlen($errorMessage) > 0)
		$bInitVars = True;

	if ($_POST["action"] == "save" && strlen($errorMessage) <= 0)
		$successMessage = GetMessage("SALE_SUCCESS_EDIT_PROF");
}

$arResult["ORDER_PROPS"] = Array();
if ($ID > 0) {
	$dbUserProps = CSaleOrderUserProps::GetList(
		array("DATE_UPDATE" => "DESC"),
		array(
			"USER_ID" => IntVal($GLOBALS["USER"]->GetID()),
			"ID" => $ID
		),
		false,
		false,
		array("ID", "NAME", "USER_ID", "PERSON_TYPE_ID", "DATE_UPDATE")
	);
	if ($arUserProps = $dbUserProps->GetNext())
	{
		if(!$bInitVars && $ID > 0)
			$arResult = $arUserProps;
		elseif ($bInitVars)
		{
			foreach($_POST as $k => $v)
			{
				$arResult[$k] = htmlspecialcharsbx($v);
				$arResult['~'.$k] = $v;
			}
		}
	}
} else {
	$arUserProps["PERSON_TYPE_ID"] = $curPersonType;
}
if ($arUserProps) {
	$arResult["ERROR_MESSAGE"] = $errorMessage;
	$arResult["SUCCESS_MESSAGE"] = $successMessage;
	$arResult["IS_NEW_PROFILE_CREATE"] = $isNewProfileCreate;

	$arResult["TITLE"] = str_replace("#ID#", $arUserProps["ID"], GetMessage("SPPD_PROFILE_NO"));
	$arResult["PERSON_TYPE"] = CSalePersonType::GetByID($arUserProps["PERSON_TYPE_ID"]);
	$arResult["PERSON_TYPE"]["NAME"] = htmlspecialcharsEx($arResult["PERSON_TYPE"]["NAME"]);

	// get prop description
	$arrayTmp = Array();
	$propsOfTypeLocation = array();
	$dbOrderPropsGroup = CSaleOrderPropsGroup::GetList(
				array("SORT" => "ASC", "NAME" => "ASC"),
				array("PERSON_TYPE_ID" => $arUserProps["PERSON_TYPE_ID"]),
				false,
				false,
				array("ID", "PERSON_TYPE_ID", "NAME", "SORT")
			);
	while ($arOrderPropsGroup = $dbOrderPropsGroup->GetNext())
	{
		$dbOrderProps = CSaleOrderProps::GetList(
				array("SORT" => "ASC", "NAME" => "ASC"),
				array(
						"PERSON_TYPE_ID" => $arUserProps["PERSON_TYPE_ID"],
						"PROPS_GROUP_ID" => $arOrderPropsGroup["ID"],
						"USER_PROPS" => "Y", "ACTIVE" => "Y", "UTIL" => "N"
					),
				false,
				false,
				array("ID", "PERSON_TYPE_ID", "NAME", "TYPE", "REQUIED", "DEFAULT_VALUE", "SORT", "USER_PROPS", "IS_LOCATION", "PROPS_GROUP_ID", "SIZE1", "SIZE2", "DESCRIPTION", "IS_EMAIL", "IS_PROFILE_NAME", "IS_PAYER", "IS_LOCATION4TAX", "CODE", "SORT")
			);
		while($arOrderProps = $dbOrderProps->GetNext())
		{
			if ($arOrderProps["REQUIED"]=="Y" || $arOrderProps["IS_EMAIL"]=="Y" || $arOrderProps["IS_PROFILE_NAME"]=="Y" || $arOrderProps["IS_LOCATION"]=="Y" || $arOrderProps["IS_PAYER"]=="Y")
				$arOrderProps["REQUIED"] = "Y";
			if (in_array($arOrderProps["TYPE"], Array("SELECT", "MULTISELECT", "RADIO")))
			{
				$dbVars = CSaleOrderPropsVariant::GetList(($by="SORT"), ($order="ASC"), Array("ORDER_PROPS_ID"=>$arOrderProps["ID"]));
				while ($vars = $dbVars->GetNext())
					$arOrderProps["VALUES"][] = $vars;
			}
			elseif($arOrderProps["TYPE"]=="LOCATION")
			{
				$propsOfTypeLocation[$arOrderProps['ID']] = true; // required for mapping ID<=>CODE below

				// perfomance hole
				$dbVars = CSaleLocation::GetList(Array("SORT"=>"ASC", "COUNTRY_NAME_LANG"=>"ASC", "CITY_NAME_LANG"=>"ASC"), array(), LANGUAGE_ID);
				while($vars = $dbVars->GetNext())
					$arOrderProps["VALUES"][] = $vars;
			}
			$arrayTmp[$arOrderProps["SORT"]] = $arOrderProps;
		}
	}
	$arResult["ORDER_PROPS"] = $arrayTmp;
    ksort($arResult["ORDER_PROPS"]);
			
	// get prop values
	$arPropValsTmp = Array();
	if (!$bInitVars && $ID > 0)
	{
		$dbPropVals = CSaleOrderUserPropsValue::GetList(
				array("SORT" => "ASC"),
				array("USER_PROPS_ID" => $arUserProps["ID"]),
				false,
				false,
				array("ID", "ORDER_PROPS_ID", "VALUE", "SORT")
			);
		while ($arPropVals = $dbPropVals->GetNext())
		{
			$arPropValsTmp["ORDER_PROP_".$arPropVals["ORDER_PROPS_ID"]] = $arPropVals["VALUE"];
		}
	}
	elseif ($bInitVars)
	{
		foreach ($_REQUEST as $key => $value)
		{
			if (substr($key, 0, strlen("ORDER_PROP_"))=="ORDER_PROP_")
				$arPropValsTmp[$key] = htmlspecialcharsbx($value);
		}
	}
	$arResult["ORDER_PROPS_VALUES"] = $arPropValsTmp;
} else {
	$arResult["ERROR_MESSAGE"] = GetMessage("SALE_NO_PROFILE");
}

$this->IncludeComponentTemplate();
?>