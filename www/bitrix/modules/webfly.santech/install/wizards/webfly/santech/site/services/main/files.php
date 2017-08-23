<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!defined("WIZARD_SITE_ID")) return;

if (!defined("WIZARD_SITE_DIR")) return;
 
if (WIZARD_INSTALL_DEMO_DATA){
	$path = str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/public/".LANGUAGE_ID."/");
	
	$handle = @opendir($path);
  CModule::IncludeModule("search");
	if ($handle){
		while ($file = readdir($handle)){
			if (in_array($file, array(".", ".."))) continue;
			CopyDirFiles(
				$path.$file,
				WIZARD_SITE_PATH."/".$file,
				$rewrite = true, 
				$recursive = true,
				$delete_after_copy = false
			);
		}
	}
  $p = str_replace("//", "/", WIZARD_ABSOLUTE_PATH."/site/services/main/components/");
  if (is_dir($p)){
    $dir = opendir($p);
    while ($item = readdir($dir)){
      if($item == ".." or $item == ".") continue;
      CopyDirFiles($p.'/'.$item, $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$item, $ReWrite = true, $Recursive = true);
    }
    closedir($dir);
  }
  CSearch::ReIndexAll(false, 0, Array(WIZARD_SITE_ID, WIZARD_SITE_DIR));

	WizardServices::PatchHtaccess(WIZARD_SITE_PATH);

	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."about/", Array("SITE_DIR" => WIZARD_SITE_DIR));
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."auth/", Array("SITE_DIR" => WIZARD_SITE_DIR));
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."blog/", Array("SITE_DIR" => WIZARD_SITE_DIR));
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."brands/", Array("SITE_DIR" => WIZARD_SITE_DIR));
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."catalog/", Array("SITE_DIR" => WIZARD_SITE_DIR));
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."favorites/", Array("SITE_DIR" => WIZARD_SITE_DIR));
	WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."login/", Array("SITE_DIR" => WIZARD_SITE_DIR));
  WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."news/", Array("SITE_DIR" => WIZARD_SITE_DIR));
  WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."personal/", Array("SITE_DIR" => WIZARD_SITE_DIR));
  WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH."search/", Array("SITE_DIR" => WIZARD_SITE_DIR));
  
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));

	$arUrlRewrite = array(); 
	if (file_exists(WIZARD_SITE_ROOT_PATH."/urlrewrite.php")){
		include(WIZARD_SITE_ROOT_PATH."/urlrewrite.php");
	}

    $arNewUrlRewrite = array(
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."about/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"".WIZARD_SITE_DIR."about/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."blog/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"".WIZARD_SITE_DIR."blog/index.php",
	),
  array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."news/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"".WIZARD_SITE_DIR."news/index.php",
	),
  array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."brands/([0-9]+)/#",
		"RULE"	=>	"brand_id=$1",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."brands/detail.php",
	),
  array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."catalog/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:catalog",
		"PATH"	=>	"".WIZARD_SITE_DIR."catalog/index.php",
	),
  array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."delivery/#",
		"RULE"	=>	"",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."adults/index.php",
	),
  array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."guaranty/#",
		"RULE"	=>	"",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."adults/index.php",
	),
  array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."kredit/#",
		"RULE"	=>	"",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."adults/index.php",
	),
  array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."oplata/#",
		"RULE"	=>	"",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."adults/index.php",
	),
  array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."personal/order/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:sale.personal.order",
		"PATH"	=>	"".WIZARD_SITE_DIR."personal/order/index.php",
	)
);
	foreach ($arNewUrlRewrite as $arUrl)
	{
		if (!in_array($arUrl, $arUrlRewrite))
		{
			CUrlRewriter::Add($arUrl);
		}
	}
}

function ___writeToAreasFile($fn, $text)
{
	if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS"))
		@chmod($abs_path, BX_FILE_PERMISSIONS);

	$fd = @fopen($fn, "wb");
	if(!$fd)
		return false;

	if(false === fwrite($fd, $text))
	{
		fclose($fd);
		return false;
	}

	fclose($fd);

	if(defined("BX_FILE_PERMISSIONS"))
		@chmod($fn, BX_FILE_PERMISSIONS);
}

CheckDirPath(WIZARD_SITE_PATH."include/");

$wizard =& $this->GetWizard();

___writeToAreasFile(WIZARD_SITE_PATH."include/copyright.php", $wizard->GetVar("siteCopy"));

if (WIZARD_INSTALL_DEMO_DATA)
{ 
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_DESCRIPTION" => htmlspecialcharsbx($wizard->GetVar("siteMetaDescription"))));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/.section.php", array("SITE_KEYWORDS" => htmlspecialcharsbx($wizard->GetVar("siteMetaKeywords"))));
}
?>