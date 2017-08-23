<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
global $APPLICATION;
if (isset($_GET['ajaxw'])) {
  $content = ob_get_contents();
  ob_end_clean();
  $APPLICATION->RestartBuffer();
  $content_html = explode('<!--RestartBuffer-->', $content);
  echo $content_html[1];
  die();
}



?>

