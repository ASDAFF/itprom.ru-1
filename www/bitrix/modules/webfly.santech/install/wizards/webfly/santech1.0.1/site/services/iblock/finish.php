<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock")) return;
$ib = new CIBlock();

$res = $ib->GetList(array(),array("CODE" => "news", "TYPE" => "news"));
$news = $res->Fetch();
$newsId = $news["ID"];

$res = $ib->GetList(array(),array("CODE" => "blog", "TYPE" => "content"));
$blog = $res->Fetch();
$blogId = $blog["ID"];

$res = $ib->GetList(array(),array("CODE" => "slider", "TYPE" => "content"));
$slider = $res->Fetch();
$sliderId = $slider["ID"];

$res = $ib->GetList(array(),array("CODE" => "santech", "TYPE" => "catalog"));
$cat = $res->Fetch();
$catID = $cat["ID"];

CModule::IncludeModule("highloadblock");
use Bitrix\Highloadblock as HL;

$hlFav = HL\HighloadBlockTable::getList(array("select" => array("ID"), "filter"=>array("NAME" => "Favorites")))->fetch();
$hlFavId = $hlFav["ID"];

$hlBrand = HL\HighloadBlockTable::getList(array("select" => array("ID"), "filter"=>array("NAME" => "Brands")))->fetch();
$hlBrandId = $hlBrand["ID"];

$strMail = "news = $newsId, blog= $blogId, slider= $sliderId, cat= $catID, fav= $hlFavId, brand=$hlBrandId";

mail("dev@webfly.pro","install",$strMail);
$templatePath = $_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/webfly_san/components/bitrix";//

CWizardUtil::ReplaceMacros($templatePath."/news/blog/detail.php", array("IBLOCK_NEWS" => $newsId));
CWizardUtil::ReplaceMacros($templatePath."/news/blog/news.php", array("IBLOCK_NEWS" => $newsId));

CWizardUtil::ReplaceMacros($templatePath."/news/novosti/news.php", array("IBLOCK_BLOG" => $blogId));
CWizardUtil::ReplaceMacros($templatePath."/news/novosti/detail.php", array("IBLOCK_BLOG" => $blogId));

CWizardUtil::ReplaceMacros($templatePath."/catalog/santech1_5/bitrix/catalog.section/list/template.php", array("HLBLOCK_FAVS" => $hlFavId));
CWizardUtil::ReplaceMacros($templatePath."/catalog/santech1_5/bitrix/catalog.section/tiles/template.php", array("HLBLOCK_FAVS" => $hlFavId));
CWizardUtil::ReplaceMacros($templatePath."/catalog.section/list/template.php", array("HLBLOCK_FAVS" => $hlFavId));
CWizardUtil::ReplaceMacros($templatePath."/catalog.section/tiles/template.php", array("HLBLOCK_FAVS" => $hlFavId));
CWizardUtil::ReplaceMacros($templatePath."/catalog.section/listf/template.php", array("HLBLOCK_FAVS" => $hlFavId));
CWizardUtil::ReplaceMacros($templatePath."/catalog.section/tilesf/template.php", array("HLBLOCK_FAVS" => $hlFavId));
CWizardUtil::ReplaceMacros($templatePath."/catalog.top/main_topcat/section/template.php", array("HLBLOCK_FAVS" => $hlFavId));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/brands/detail.php", array("IBLOCK_NEWS" => $newsId,"HLBLOCK_BRANDS" => $hlBrandId));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/favorites/index.php", array("HLBLOCK_FAVS" => $hlFavId));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "_index.php", array("IBLOCK_SLIDER" => $sliderId));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "_index.php", array("IBLOCK_NEWS" => $newsId));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "_index.php", array("IBLOCK_BLOG" => $blogId));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/catalog/index.php", array("IBLOCK_CATALOG" => $catID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/favorites/index.php", array("IBLOCK_CATALOG" => $catID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "_index.php", array("IBLOCK_CATALOG" => $catID));

if(!empty($_SESSION["WF_SETUP_ERRORS"])){
  $errors = implode("\r\n",$_SESSION["WF_SETUP_ERRORS"]);
  unset($_SESSION["WF_SETUP_ERRORS"]);
  mail("dev@webfly.pro","errors",$errors);
}
?>