<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
if (!defined("WIZARD_SITE_ID"))
    return;
if (!defined("WIZARD_SITE_DIR"))
    return;
$path = str_replace("//", "/", WIZARD_ABSOLUTE_PATH . "/site/public/" . LANGUAGE_ID . "/");
$handle = @opendir($path);
if ($handle) {
    while ($file = readdir($handle)) {
        if (in_array($file, array(
            ".",
            "..",
            "bitrix_messages",
            "bitrix_admin",
            "bitrix_php_interface",
            "bitrix_js",
            "bitrix_images",
            "bitrix_themes"
        ))
        ) continue;
        if ($file == 'bitrix_php_interface_init')
            $to = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/' . WIZARD_SITE_ID;
        elseif ($file == 'upload')
            $to = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
        else
            $to = WIZARD_SITE_PATH . "/" . $file;
        CopyDirFiles(
            $path . $file,
            $to,
            $rewrite = true,
            $recursive = true,
            $delete_after_copy = false
        );
    }
    $siteName = htmlspecialcharsbx($wizard->GetVar("siteName"));
    $sitePhone = htmlspecialcharsbx($wizard->GetVar("sitePhone"));
    $siteEmail = htmlspecialcharsbx($wizard->GetVar("siteEmail"));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/index.php", Array("NL_SITE_EMAIL" => $siteEmail, "SITE_TEMPLATE_PATH" => '/local/templates/' . WIZARD_TEMPLATE_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/contacts/index.php", Array("NL_SITE_PHONE" => $sitePhone, "NL_SITE_EMAIL" => $siteEmail, "SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/logo.php", array("NL_SITE_NAME" => $siteName));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/pay.php", array("SITE_TEMPLATE_PATH" => '/local/templates/' . WIZARD_TEMPLATE_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/phone.php", array("NL_SITE_PHONE" => $sitePhone));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/product_slider.php", array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/schedule.php", array("NL_SITE_PHONE" => $sitePhone, "NL_SITE_EMAIL" => $siteEmail));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/login/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/nl_ajax/main_feedback.php", Array("NL_SITE_EMAIL" => $siteEmail));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/shop/delivery/index.php", Array("SITE_TEMPLATE_PATH" => '/local/templates/' . WIZARD_TEMPLATE_ID, "SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/shop/payment/index.php", Array("SITE_TEMPLATE_PATH" => '/local/templates/' . WIZARD_TEMPLATE_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . ".main_bottom.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/.bottom.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/personal/profile/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/.left.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/info/.left.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/shop/.left.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/.top.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/.site.menu.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/changepasswd.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/confirmation.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/forgotpasswd.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/history.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/login.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/profile_list.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/registration.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/nl_ajax/history_order.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/service_order.php", Array("SITE_DIR" => WIZARD_SITE_DIR, "SITE_ID" => WIZARD_SITE_ID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/brands/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/services/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/shops/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/personal/cart/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/personal/order/make/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/actions/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/company/news/index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
}

if(file_exists(WIZARD_ABSOLUTE_PATH."/site/local/"))
{
	CopyDirFiles(
		WIZARD_ABSOLUTE_PATH."/site/local/",
		$_SERVER['DOCUMENT_ROOT'].'/',
		$rewrite = true,
		$recursive = true,
		$delete_after_copy = false
	);
}

mkdir($_SERVER['DOCUMENT_ROOT']."/local/php_interface/".WIZARD_SITE_ID, 0777);

CopyDirFiles(   
	WIZARD_ABSOLUTE_PATH."/site/init/",
	$_SERVER['DOCUMENT_ROOT'].'/local/php_interface/'.WIZARD_SITE_ID.'/',
	$rewrite = true,
	$recursive = true,
	$delete_after_copy = false
);

copy(WIZARD_THEME_ABSOLUTE_PATH . "/favicon.ico", WIZARD_SITE_PATH . "favicon.ico");

$arUrlRewrite = array(); 
if (file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php"))
{
	include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
}

$arNewUrlRewrite = array(
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."company/services/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."company/services/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."personal/profile/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.profile",
		"PATH" => WIZARD_SITE_DIR."personal/profile/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."company/actions/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."company/actions/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => WIZARD_SITE_DIR."personal/order/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."company/brands/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."company/brands/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."company/shops/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => WIZARD_SITE_DIR."company/shops/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."company/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => WIZARD_SITE_DIR."company/news/index.php",
	),
	array(
		"CONDITION" => "#^".WIZARD_SITE_DIR."catalog/#",
		"RULE" => "",
		"PATH" => WIZARD_SITE_DIR."catalog/index.php",
	),
);

foreach ($arNewUrlRewrite as $arUrl)
{
	if (!in_array($arUrl, $arUrlRewrite))
	{
		CUrlRewriter::Add($arUrl);
	}
}

COption::SetOptionString("subscribe", "subscribe_section", "#SITE_DIR#personal/subscribe/");
COption::SetOptionString("bitlate.toolsshop", "NL_MODULE_SITE_ID", WIZARD_SITE_ID, false, false);
COption::SetOptionString("bitlate.toolsshop", "NL_MODULE_SITE_DIR", WIZARD_SITE_DIR, false, false);
?>