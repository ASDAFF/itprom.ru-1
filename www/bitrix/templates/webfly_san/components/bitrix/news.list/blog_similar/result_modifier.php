<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
CModule::IncludeModule('iblock');
foreach($arResult["ITEMS"] as $key => $arItem){
  if(isset($_POST["WF_BLOG_DETAIL_ID"])){
    if(($_POST["WF_BLOG_DETAIL_ID"] == $arItem["ID"]) or !checkIfExists($arItem["PROPERTIES"]["CATEGORY"]["VALUE_ENUM_ID"],$_POST["WF_BLOG_CATEGORY_ENUM"])){
      unset($arResult["ITEMS"][$key]);
      continue;
    }
  }
  $arResult["ITEMS"][$key]["SMALL_PIC"] = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'],	array("width" => 55, "height" => 55),	BX_RESIZE_IMAGE_EXACT, true, $arFilter);
}
$arResult["ITEMS"] = wfRefreshArray($arResult["ITEMS"]);

function checkIfExists($one, $two){
  $isIn = false;
	if(empty($one)) return false;
  foreach($one as $value){
    if(in_array($value,$two)){
      $isIn = true;
      break;
    }
  }
  if(!$isIn){
    foreach($two as $value){
      if(in_array($value,$one)){
        $isIn = true;
        break;
      }
    }
  }
  return $isIn;
}
?>