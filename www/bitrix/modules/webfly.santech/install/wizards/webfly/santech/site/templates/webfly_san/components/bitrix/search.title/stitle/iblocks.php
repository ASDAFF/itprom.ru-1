<?php
CModule::IncludeModule("iblock");
function wfIBGetFirstElement($IBLOCK_ID, $fields = array(), $sort = array("SORT" => "ASC")){
  $arOrder = $sort;
  $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, "ACTIVE" => "Y");
  $arSelect = array("ID","IBLOCK_ID","NAME","CODE");
  if(!empty($fields)) $arSelect = array_merge($arSelect, $fields);
  $arGroupBy = false;
  $elm = CIBlockElement::GetList($arOrder,$arFilter,$arGroupBy,false,$arSelect);
  $first = array();
  if($el = $elm->Fetch()){
    $first = array("CODE" => $el["CODE"]);
  }else return false;
  if(!empty($first)) return $first;
  else return false;
}
function wfIBGetAllElementsForMenu($IBLOCK_ID, $fields = array(), $limit = 0, $sort = array("SORT" => "ASC")){
  $arOrder = $sort;
  $arFilter = array("IBLOCK_ID" => $IBLOCK_ID, "ACTIVE" => "Y");
  $arSelect = array("ID","IBLOCK_ID","NAME","DETAIL_PAGE_URL");
  if(!empty($fields)) $arSelect = array_merge($arSelect, $fields);
  $arGroupBy = false;
  if($limit >0) $arNavStartParams = array("nTopCount" => $limit);
  else $arNavStartParams = false;
  $elm = CIBlockElement::GetList($arOrder,$arFilter,$arGroupBy,$arNavStartParams,$arSelect);
  $menu = array();
  while($el = $elm->GetNext()){
    $array = array("NAME" => $el["NAME"], "URL" => $el["DETAIL_PAGE_URL"], "ID" => $el["ID"]);
    if(in_array("PREVIEW_PICTURE",$fields)) $array["IMAGE_P"] = CFile::GetPath($el["PREVIEW_PICTURE"]);
    if(in_array("DETAIL_PICTURE",$fields)) $array["IMAGE_D"] = CFile::GetPath($el["DETAIL_PICTURE"]);
    foreach($fields as $value){
      if (substr_count($value,"PROPERTY_") > 0) $array[str_replace("PROPERTY_","",$value)] = $el[$value."_VALUE"];
      else $array[$value] = $el[$value];
    }
    $menu[] = $array;
  }
  return $menu;
}
function wfIBSearchElementsByProp($IBLOCK_ID = false, $prop = array(), $fields = array(), $limit = 0){
  if(empty($prop)) return false;
  $arOrder = array("SORT" => "ASC");
  if(!empty($IBLOCK_ID)) $arFilter["IBLOCK_ID"] = $IBLOCK_ID;
  $arFilter["ACTIVE"] = "Y";
  $arFilter = array_merge($arFilter,$prop);
  $arSelect = array("ID","IBLOCK_ID","NAME","DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PREVIEW_TEXT");
  if(!empty($fields)) $arSelect = array_merge($arSelect, $fields);
  $arGroupBy = false;
  if($limit >0) $arNavStartParams = array("nTopCount" => $limit);
  else $arNavStartParams = false;
  $elm = CIBlockElement::GetList($arOrder,$arFilter,$arGroupBy,$arNavStartParams,$arSelect);
  $result = array();
  while($el = $elm->GetNext()){
    $array = array("NAME" => $el["NAME"], "URL" => $el["DETAIL_PAGE_URL"], "ID" => $el["ID"], "TEXT" => $el["PREVIEW_TEXT"]);
    $array["IMAGE_P"] = CFile::GetPath($el["PREVIEW_PICTURE"]);
    foreach($fields as $value){
      if (substr_count($value,"PROPERTY_") > 0) $array[str_replace("PROPERTY_","",$value)] = $el[$value."_VALUE"];
      else $array[$value] = $el[$value];
    }
    $result[] = $array;
  }
  return $result;
}
function wfGetIBlockInfo($IBLOCK_ID, $filter = array()){
  $arSort = array("SORT" => "ASC");
  $arFilter = array("ID" => $IBLOCK_ID);
  if(!empty($filter)) $arFilter = array_merge($arFilter, $filter);
  $res = CIBlock::GetList($arSort, $arFilter, true);
  $iblocks = array();
  while($ibInfo = $res->GetNext()){
    $iblocks[] = $ibInfo;
  }
  return $iblocks;
}