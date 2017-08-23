<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
if (!defined("WIZARD_TEMPLATE_ID"))
    return;
$bitrixTemplatePath = "/local/templates/" . WIZARD_TEMPLATE_ID;
$bitrixTemplateDir = $_SERVER["DOCUMENT_ROOT"] . $bitrixTemplatePath;
CopyDirFiles(
    $_SERVER["DOCUMENT_ROOT"] . WizardServices::GetTemplatesPath(WIZARD_RELATIVE_PATH . "/site") . "/" . WIZARD_TEMPLATE_ID,
    $bitrixTemplateDir,
    $rewrite = true,
    $recursive = true,
    $delete_after_copy = false
);
/*CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/pay.php", Array("SITE_TEMPLATE_PATH" => $bitrixTemplatePath));
CWizardUtil::ReplaceMacros(
    $bitrixTemplateDir."/adaptiv_shop/include/logo.php",
    Array(
        "SITE_TITLE" => htmlspecialcharsbx($wizard->GetVar("siteName")),
    )
);
CWizardUtil::ReplaceMacros(
    $bitrixTemplateDir."adaptiv_shop/include/copyright.php",
    Array(
        "siteCopyright" => htmlspecialcharsbx($wizard->GetVar("siteCopyright")),
    )
);*/
//Attach template to default site
$obSite = CSite::GetList($by = "def", $order = "desc", Array("LID" => WIZARD_SITE_ID));
if ($arSite = $obSite->Fetch()) {
    $arTemplates = Array();
    $arTemplates[] = Array("CONDITION" => "", "SORT" => 1, "TEMPLATE" => "bitlate_tools");
    $arFields = Array(
        "TEMPLATE" => $arTemplates,
        "NAME" => $arSite["NAME"],
    );
    $obSite = new CSite();
    $obSite->Update($arSite["LID"], $arFields);
}

COption::SetOptionString("main", "wizard_template_id", WIZARD_TEMPLATE_ID, false, WIZARD_SITE_ID);

$siteName = $wizard->GetVar("siteName");
COption::SetOptionString("main","site_name",$siteName);

$siteEmail = $wizard->GetVar("siteEmail");
COption::SetOptionString("main","email_from",$siteEmail);
?>