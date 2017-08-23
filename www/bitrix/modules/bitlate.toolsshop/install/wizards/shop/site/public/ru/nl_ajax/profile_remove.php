<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
__IncludeLang($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/lang/" . LANGUAGE_ID . "/ajax.php");

$arResult = array(
	'success' => 'N',
	'error' => '',
	'message' => ''
);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && check_bitrix_sessid()) {
	global $USER;
	$id = intval($_REQUEST['id']);
	if ($id > 0) {
		if (CModule::IncludeModule("sale")) {
			$dbUserProps = CSaleOrderUserProps::GetList(
				array(),
				array(
					"ID" => $id,
					"USER_ID" => IntVal($USER->GetID())
				)
			);
			if ($arUserProps = $dbUserProps->Fetch())
			{
				if (CSaleOrderUserProps::Delete($arUserProps["ID"]))
				{
					$arResult['success'] = "Y";
					$arResult['id'] = $id;
					$arResult['message'] = GetMessage('T_DELETE_ADDRESS_SUCCESS');
				}
			}
		}
	}
	if ($arResult['success'] != "Y") {
		$arResult['error'] = GetMessage('T_DELETE_ADDRESS_ERROR');
	}
}

echo \Bitrix\Main\Web\Json::encode($arResult);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?> 