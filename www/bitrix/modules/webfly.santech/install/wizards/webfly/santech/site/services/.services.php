<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arServices = Array(
	"main" => Array(
		"NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
		"STAGES" => Array(
			"files.php", // Copy bitrix files
			"template.php", // Install template
			"settings.php",//install settings
		),
	),

	"iblock" => Array(
		"NAME" => GetMessage("SERVICE_IBLOCK"),
		"STAGES" => Array(
      "types.php", //IBlock types
      "highloadblocks.php",//highloadblocks for settings, favorites and brands
      "hlfill.php",//filling highloadblocks with data
		  "catalog.php",//catalog
		  "company.php",//company
      "news.php",//news
      "blog.php",//blog
      "feedback.php",//feedback form with events
      "slider.php",//main page slider
		),
	),
);
?>