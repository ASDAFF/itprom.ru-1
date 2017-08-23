<?php
if (count($arResult["PROFILES"]) > 0) {
	foreach($arResult["PROFILES"] as $k => $val) {
		$dbPropVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), Array("USER_PROPS_ID" => $val["ID"], "PROP_CODE" => array("CITY", "ADDRESS")));
		$location = array();
		while ($arPropVals = $dbPropVals->Fetch())
		{
			if ($arPropVals["PROP_CODE"] == "CITY") {
				$arCity = CSaleLocation::GetByID($arPropVals["VALUE"]);
				if ($arCity['CITY_NAME_LANG'] != '') {
					$location[0] = GetMessage("PROFILE_LIST_CITY") . " " . $arCity['CITY_NAME_LANG'];
				}
			} elseif ($arPropVals["PROP_CODE"] == "ADDRESS") {
				$location[1] = $arPropVals['VALUE'];
			}
		}
		if (count($location) > 0) {
			ksort($location);
			$arResult["PROFILES"][$k]["NAME"] = implode(', ', $location);
		}
	}
}