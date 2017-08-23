<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("WF_IBLOCK_MENU_TEMPLATE_NAME"),
	"DESCRIPTION" => GetMessage("WF_IBLOCK_MENU_TEMPLATE_DESC"),
	"ICON" => "/images/menu_ext.gif",
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "romza",
		"NAME" => GetMessage("WF_COMPONENTS"),
		"CHILD" => array(
			"ID" => "catalog_wf",
			"NAME" => GetMessage("WF_IBLOCK_DESC_CATALOG"),
			"SORT" => 30
		)
	)
);
?>