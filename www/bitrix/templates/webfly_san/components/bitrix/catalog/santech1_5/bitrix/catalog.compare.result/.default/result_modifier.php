<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["ITEMS"] as $key => $arItem){
  $arResult["ITEMS"][$key]["PIC_D"] = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]["ID"], 
          array('width'=>95, 'height'=>125), BX_RESIZE_IMAGE_PROPORTIONAL, true);
}
?>