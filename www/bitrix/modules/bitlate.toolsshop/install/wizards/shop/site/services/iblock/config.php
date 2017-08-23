<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("bitlate.toolsshop"))
	return;

NLApparelshopUtils::generateIncludeFile(WIZARD_SITE_ID, WIZARD_SITE_DIR, false, WIZARD_TEMPLATE_ID);
?>