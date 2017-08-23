<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if (!defined("WIZARD_TEMPLATE_ID")) return;
if (!defined("WIZARD_TEMPLATE_ID")) define("WIZARD_TEMPLATE_ID","webfly_san");

$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"] . BX_PERSONAL_ROOT . "/templates/" . WIZARD_TEMPLATE_ID;
$pathFrom = $_SERVER["DOCUMENT_ROOT"] . WizardServices::GetTemplatesPath(WIZARD_RELATIVE_PATH . "/site") . "/" . WIZARD_TEMPLATE_ID;
CopyDirFiles($pathFrom, $bitrixTemplateDir, $rewrite = true, $recursive = true, $delete_after_copy = false);

COption::SetOptionString("webfly.santech", "wizard_template_id", WIZARD_TEMPLATE_ID, false, WIZARD_SITE_ID);
?>