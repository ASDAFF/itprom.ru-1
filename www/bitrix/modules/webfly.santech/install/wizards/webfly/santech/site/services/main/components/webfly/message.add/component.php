<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("iblock")) return;
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
	$arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");

if(isset($_POST["ajaxm"])){
  $arFields = Array(
    "NAME" => $_POST["name"],
    "EMAIL" => $_POST["email"],
    "EMAIL_TO" => $arParams["EMAIL_TO"],
    "TEXT" => $_POST["message"],
  );
  $ibe = new CIBlockElement;
  $preview_text = $_POST["message"];
  
  $messageParams = array(
    "IBLOCK_SECTION_ID" => false,          // 
    "IBLOCK_ID"      => $arParams["IBLOCK_ID"],
    "NAME"           => $_POST["name"], //
    "ACTIVE"         => "N",
    "ACTIVE_FROM"    => date('d.m.Y H:i'),
    "PREVIEW_TEXT"   => $preview_text,
    "CODE" => $_POST["email"]
  );
  
  if($qID = $ibe->Add($messageParams)){
    $link = "bitrix/admin/iblock_element_edit.php?IBLOCK_ID={$arParams["IBLOCK_ID"]}&type={$arParams["IBLOCK_TYPE"]}&ID={$qID}&lang=ru";
    $text = $_POST["message"]."\n\n".$link;
    $arFields = Array(
      "TEXT" => $_POST["message"],
      "AUTHOR" => $_POST['name'],
      "AUTHOR_EMAIL" => $_POST['email'],
      "EMAIL" => $_POST["email"],
      "EMAIL_TO" => $arParams["EMAIL_TO"],
      "LINK" => $link
    );
    //
    if(is_array($arParams['EVENT_MESSAGE_ID']))
      foreach($arParams['EVENT_MESSAGE_ID'] as $event){
        $rsEM = CEventMessage::GetByID($event);
        $arEM = $rsEM->Fetch();
        CEvent::Send($arEM['EVENT_NAME'], SITE_ID, $arFields,"N", $event);
      }
    else{
      $event = $arParams['EVENT_MESSAGE_ID'];
      $rsEM = CEventMessage::GetByID($event);
      $arEM = $rsEM->Fetch();
      CEvent::Send($arEM['EVENT_NAME'], SITE_ID, $arFields,"N", $event);
    }
  }
  else echo $ibe->LAST_ERROR;
}
else $this->IncludeComponentTemplate();