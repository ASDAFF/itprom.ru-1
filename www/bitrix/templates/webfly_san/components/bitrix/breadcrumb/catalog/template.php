<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult)) return "";
$strReturn = '<ul class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">';

$num_items = count($arResult);
if(empty($arParams["START_FROM"])) $arParams["START_FROM"] = 0;
for($index = $arParams["START_FROM"], $itemSize = $num_items; $index < $itemSize; $index++){
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	
	$spantitle = '<span itemprop="name">' . $title . '</span>';
	$strReturn .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1)
		$strReturn .= '<a itemprop="item" href="' . $arResult[$index]["LINK"] . '" title="' . $title . '">' . $spantitle . '</a>';
	else $strReturn .= $spantitle;
	$strReturn .= '<met a itemprop="position" content="' . $index . '" />';
	$strReturn .= '</li>';

}

$strReturn .= '</ul>';

return $strReturn;
?>