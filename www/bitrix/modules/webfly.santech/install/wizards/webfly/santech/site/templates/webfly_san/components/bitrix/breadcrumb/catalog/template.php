<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult)) return "";
$strReturn = '<ul class="breadcrumbs">';

$num_items = count($arResult);
if(empty($arParams["START_FROM"])) $arParams["START_FROM"] = 0;
for($index = $arParams["START_FROM"], $itemSize = $num_items; $index < $itemSize; $index++){
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1) 
  $strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a></li>';
	else $strReturn .= '<li>'.$title.'</li>';
}

$strReturn .= '</ul>';

return $strReturn;
?>