<?
IncludeModuleLangFile(__FILE__);
CModule::AddAutoloadClasses(
	'bitlate.toolsshop',
	array (
		'NLApparelshopUtils' => 'classes/nl_apparelshop_utils.php',
		'CBitlateToolsIBlockElementHandler' => 'classes/event_handlers/IBlockElementAddUpdateHandler.php',
		'CBitlateToolsBlogCommentHandler' => 'classes/event_handlers/BlogCommentHandler.php',
		'CBitlateToolsMainEventHandler' => 'classes/event_handlers/MainHandler.php',
	)
);
?>