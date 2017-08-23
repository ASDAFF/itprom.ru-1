<?php

class CBitlateToolsMainEventHandler
{
	public static function OnBeforeUserRegisterHandler(&$arFields)
	{
		$arFields['NAME'] = trim($arFields['NAME']);

		if (empty($arFields['LAST_NAME'])) {
			$names = explode(' ', $arFields['NAME']);

			if (count($names) == 2) {
				$arFields['LAST_NAME'] = $names[0];
				$arFields['NAME'] = $names[1];
			} elseif (count($names) == 3) {
				$arFields['LAST_NAME'] = $names[0];
				$arFields['NAME'] = $names[1];
				$arFields['SECOND_NAME'] = $names[2];
			}
		}

		$arFields["LOGIN"] = $arFields["EMAIL"];
	}
}