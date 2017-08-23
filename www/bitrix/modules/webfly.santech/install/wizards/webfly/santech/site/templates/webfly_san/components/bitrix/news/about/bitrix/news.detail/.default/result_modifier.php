<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult["SIDEBAR"] = wfIBGetAllElementsForMenu($arParams["IBLOCK_ID"],array("PROPERTY_SECTION"),0,array("PROPERTY_SECTION" => "ASC"));
?>