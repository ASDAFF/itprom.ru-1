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

//<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
//    <a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="https://example.com/books">
//        <span itemprop="name">Books</span>
//        <img itemprop="image" src="http://example.com/images/icon-bookicon.png" alt="Books"/></a>
//        <meta itemprop="position" content="1" />
//  </li>

$strReturn .= '<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumbs">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1) {
        $linkHash = 'bx_sub_breadcrumb_' . md5($arResult[$index]["LINK"]);
        $isSubBreadcrumbs = ($GLOBALS[$linkHash] != '') ? true : false;
        $strReturn .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.$arResult[$index]["LINK"].'" itemprop="name" itemprop="item" title="'.$title.'"'. (($isSubBreadcrumbs) ? ' data-toggle="' . $linkHash . '"' : '') . '>' . $title . '</a>' . (($GLOBALS[$linkHash]) ? $GLOBALS[$linkHash] : '') . '<meta itemprop="position" content="' . ($index+1) . '" /></li>';
    } else {
        $strReturn .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="#" itemprop="name">'.$title.'</a><meta itemprop="position" content="' . ($index+1) . '" /></li>';
    }
}

$strReturn .= '</ol>';

return $strReturn;
