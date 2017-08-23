<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
CModule::IncludeModule('iblock');
foreach($arResult["ITEMS"] as $key => $arItem){
  $arResult["ITEMS"][$key]["SMALL_PIC"] = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'],	array("width" => 88, "height" => 88),	BX_RESIZE_IMAGE_EXACT, true, $arFilter);
}
?>