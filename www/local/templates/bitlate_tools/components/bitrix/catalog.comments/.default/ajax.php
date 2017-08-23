<?
define("NO_KEEP_STATISTIC", true);
define('NO_AGENT_CHECK', true);
define("NO_AGENT_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('DisableEventsCheck', true);

if (isset($_REQUEST['SITE_ID']) && !empty($_REQUEST['SITE_ID']))
{
	if (!is_string($_REQUEST['SITE_ID']))
		die();
	if (preg_match('/^[a-z0-9_]{2}$/i', $_REQUEST['SITE_ID']) === 1)
		define('SITE_ID', $_REQUEST['SITE_ID']);
}
else
{
	die();
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule('bitlate.toolsshop');
$_POST = NLApparelshopUtils::prepareRequest($_POST);
$_REQUEST = NLApparelshopUtils::prepareRequest($_REQUEST);

if(
	isset($_REQUEST["IBLOCK_ID"])
	&& isset($_REQUEST["ELEMENT_ID"])
)
{
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.comments",
		"",
		array(
			"ELEMENT_ID" => $_REQUEST['ELEMENT_ID'],
			"IBLOCK_ID" => $_REQUEST['IBLOCK_ID'],
			"URL_TO_COMMENT" => "",
			"WIDTH" => 0,
			"BLOG_FROM_AJAX" => "Y",
			"COMMENTS_COUNT" => "5",
			"BLOG_USE" => 'Y',
			"FB_USE" => "Y",
			"VK_USE" => "Y",
			"CACHE_TYPE" => 'N',
			"CACHE_TIME" => 0,
			"BLOG_TITLE" => "",
			"BLOG_URL" => 'NL_CATALOG_REVIEWS_' . SITE_ID,
			"PATH_TO_SMILE" => "",
			"EMAIL_NOTIFY" => "Y",
			"AJAX_POST" => "Y",
			"SHOW_SPAM" => "Y",
			"SHOW_RATING" => "N",
			"TEMPLATE_THEME" => "site",
		),
		false
	);
}
die();