<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$ids = array();
foreach($arResult as $key => $val){
  $ids[] = $val["PRODUCT_ID"];
	$img = "";
	if ($val["DETAIL_PICTURE"] > 0)
		$img = $val["DETAIL_PICTURE"];
	elseif ($val["PREVIEW_PICTURE"] > 0)
		$img = $val["PREVIEW_PICTURE"];

	$file = CFile::ResizeImageGet($img, array('width'=>$arParams["VIEWED_IMG_WIDTH"], 'height'=>$arParams["VIEWED_IMG_HEIGHT"]), BX_RESIZE_IMAGE_PROPROTIONAL, true);

	$val["PICTURE"] = $file;
	$arResult[$key] = $val;
}

$elems = wfIBSearchElementsByProp($arResult[0]["IBLOCK_ID"], array("ID" => $ids), array("PROPERTY_NEWPRODUCT", "PROPERTY_SALELEADER", "PROPERTY_SPECIALOFFER"));
$newElems = array();
foreach($elems as $elem){
  $newElems[$elem["ID"]] = $elem;
}
$arResult["ELEMS"] = $newElems;
?>