<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */
global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
    return "";

$strReturn = '';

$strReturn .= '<ul class="breadcrumbs">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1) {
        $linkHash = 'bx_sub_breadcrumb_' . md5($arResult[$index]["LINK"]);
        $isSubBreadcrumbs = ($GLOBALS[$linkHash] != '') ? true : false;
        $strReturn .= '
            <li><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'"'. (($isSubBreadcrumbs) ? ' data-toggle="' . $linkHash . '"' : '') . '>' . $title . '</a>' . (($GLOBALS[$linkHash]) ? $GLOBALS[$linkHash] : '') . '</li>';
    } else {
        $strReturn .= '
            <li>'.$title.'</li>';
    }
}

$strReturn .= '</ul>';

return $strReturn;
