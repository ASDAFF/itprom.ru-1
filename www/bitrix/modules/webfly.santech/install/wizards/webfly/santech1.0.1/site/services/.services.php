<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arServices = Array(
	"main" => Array(
		"NAME" => GetMessage("SERVICE_MAIN_SETTINGS"),
		"STAGES" => Array(
			"files.php", // Copy public files
			"template.php", // Copy template files
		),
	),

	"iblock" => Array(
		"NAME" => GetMessage("SERVICE_IBLOCK"),
		"STAGES" => Array(
      "types.php",//iblock types (offers and options)
      "options.php",//options
			"offers.php",//offers
      "finish.php"//replaces remaining
		),
	),
);
?>