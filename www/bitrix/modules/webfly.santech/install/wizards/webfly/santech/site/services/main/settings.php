<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

COption::SetOptionString("fileman", "propstypes", serialize(array("description"=>GetMessage("MAIN_OPT_DESCRIPTION"), "keywords"=>GetMessage("MAIN_OPT_KEYWORDS"), "title"=>GetMessage("MAIN_OPT_TITLE"), "keywords_inner"=>GetMessage("MAIN_OPT_KEYWORDS_INNER"))), false, $siteID);
COption::SetOptionInt("search", "suggest_save_days", 250);
COption::SetOptionString("search", "use_tf_cache", "Y");
COption::SetOptionString("search", "use_word_distance", "Y");
COption::SetOptionString("search", "use_social_rating", "Y");
COption::SetOptionString("iblock", "use_htmledit", "Y");

//socialservices
if (COption::GetOptionString("socialservices", "auth_services") == "")
{
	$bRu = (LANGUAGE_ID == 'ru');
	$arServices = array(
		"VKontakte" => "Y",  
		"MyMailRu" => "N",
		"Twitter" => "Y",
		"Facebook" => "Y",
		"Livejournal" => "N",
		"YandexOpenID" => "N",
		"Rambler" => "N",
		"MailRuOpenID" => "N",
		"Liveinternet" => "N",
		"Blogger" => "N",
		"OpenID" => "N",
		"LiveID" => "N",
	);
	COption::SetOptionString("socialservices", "auth_services", serialize($arServices));
}
//Subscription

if(!CModule::IncludeModule("subscribe")) return;
$rubrika = new CRubric;
$sort = array("SORT" => "ASC");
$res = $rubrika->GetList($sort);
$r = $res->Fetch();
if(!$r){
  WizardServices::IncludeServiceLang("news.php", "ru");
  $arFieldsSBS = array("LID" => WIZARD_SITE_ID,
      "NAME" => GetMessage("SBS_NEWS_HEAD"),
      "ACTIVE" => "Y",
      "DESCRIPTION" => GetMessage("SBS_NEWS_DESC"),
      "VISIBLE" => "Y",
      "SORT" => "100"
      );
  $rubrika->Add($arFieldsSBS);
}
?>