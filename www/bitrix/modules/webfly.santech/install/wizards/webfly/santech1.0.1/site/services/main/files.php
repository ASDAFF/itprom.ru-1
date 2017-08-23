<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if (!defined("WIZARD_SITE_ID") or !defined("WIZARD_SITE_DIR")) return;

$path = str_replace("//", "/", WIZARD_ABSOLUTE_PATH . "/site/public/" . LANGUAGE_ID . "/");
$handle = @opendir($path);
CModule::IncludeModule("search");
if ($handle) {
  while ($file = readdir($handle)) {
    if (in_array($file, array(".", ".."))) continue;
    CopyDirFiles($path . $file, WIZARD_SITE_PATH . "/" . $file, $rewrite = true, $recursive = true, $delete_after_copy = false);
  }
}else{
  $_SESSION["WF_SETUP_ERRORS"][] = "Failed to copy template updates!";
}
CSearch::ReIndexAll(false, 0, array(WIZARD_SITE_ID, WIZARD_SITE_DIR));

WizardServices::PatchHtaccess(WIZARD_SITE_PATH);

WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . "brands/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . "catalog/", Array("SITE_DIR" => WIZARD_SITE_DIR));
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . "favorites/", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "_index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));

?>