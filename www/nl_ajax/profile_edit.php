<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('bitlate.toolsshop');
$_POST = NLApparelshopUtils::prepareRequest($_POST);
$_REQUEST = NLApparelshopUtils::prepareRequest($_REQUEST);
$APPLICATION->IncludeComponent("bitlate:sale.personal.profile.detail","",Array(
    "PATH_TO_LIST" => "profile_list.php",
    "PATH_TO_DETAIL" => "profile_detail.php?ID=#ID#",
    "ID" => $_REQUEST["ID"],
    "USE_AJAX_LOCATIONS" => "Y",
    "SET_TITLE" => "N"
));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?> 