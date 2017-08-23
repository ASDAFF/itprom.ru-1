<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if (!defined("WIZARD_DEFAULT_SITE_ID") && !empty($_REQUEST["wizardSiteID"]))
    define("WIZARD_DEFAULT_SITE_ID", $_REQUEST["wizardSiteID"]);
$arWizardDescription = Array(
    "NAME" => GetMessage("PORTAL_WIZARD_NAME"),
    "DESCRIPTION" => GetMessage("PORTAL_WIZARD_DESC"),
    "VERSION" => "1.0.2",
    "START_TYPE" => "WINDOW",
    "WIZARD_TYPE" => "INSTALL",
    "PARENT" => "wizard_sol",
    "TEMPLATES" => Array(
        Array("SCRIPT" => "wizard_sol")
    ),
    "STEPS" => Array(
        "SelectSiteStep",//Выбор сайта
        "SelectTemplateStep",//Выбор шаблона
        "SelectThemeStep",//Выбор темы
        "SiteSettingsStep",//Выбор настроке сайта
        "DataInstallStep",//Установка решения
        "FinishStep"//Завершение настройки
    ),
);

?>