<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$_POST["name"] = iconv("utf-8","windows-1251",$_POST["name"]);
$_POST["message"] = iconv("utf-8","windows-1251",$_POST["message"]);?>
<?$APPLICATION->IncludeComponent(
  "webfly:message.add", 
  $_POST["p_template"], 
  array(
    "OK_TEXT" => "",
    "EMAIL_TO" => $_POST["p_email_to"],
    "IBLOCK_TYPE" => $_POST["p_ib_type"],
    "IBLOCK_ID" => $_POST["p_ib_id"],
    "EVENT_MESSAGE_ID" => explode("|",$_POST["p_evt_id"]),
    "CACHE_TYPE" => $_POST["p_cache_t"],
    "CACHE_TIME" => $_POST["p_cache_ti"],
    "SET_TITLE" => $_POST["p_set_t"]
  ),
  false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>