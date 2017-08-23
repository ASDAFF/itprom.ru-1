<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;

if (!CModule::IncludeModule("iblock")) die();
if (!isset($arParams["CACHE_TIME"])) $arParams["CACHE_TIME"] = 3600;
if ($arParams["CACHE_TYPE"] == "N" || $arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N")
  $arParams["CACHE_TIME"] = 0;
if (empty($arParams["IBLOCK_TYPE_SORT_FIELD"])) $arParams["IBLOCK_TYPE_SORT_FIELD"] = "name";
if (empty($arParams["IBLOCK_TYPE_SORT_ORDER"])) $arParams["IBLOCK_TYPE_SORT_ORDER"] = "asc";
if (empty($arParams["IBLOCK_SORT_FIELD"])) $arParams["IBLOCK_SORT_FIELD"] = "sort";
if (empty($arParams["IBLOCK_SORT_ORDER"])) $arParams["IBLOCK_SORT_ORDER"] = "asc";
if (empty($arParams["SECTION_SORT_FIELD"])) $arParams["SECTION_SORT_FIELD"] = "left_margin";
if (empty($arParams["SECTION_SORT_ORDER"])) $arParams["SECTION_SORT_ORDER"] = "asc";
if (empty($arParams["ELEMENT_SORT_FIELD"])) $arParams["ELEMENT_SORT_FIELD"] = "sort";
if (empty($arParams["ELEMENT_SORT_ORDER"])) $arParams["ELEMENT_SORT_ORDER"] = "asc";
if (empty($arParams['SHOW_BY_CLICK'])) $arParams['SHOW_BY_CLICK'] = 'N';
$arParams["IBLOCK_TYPE"] = $arParams["IBLOCK_TYPE"];
while(true) {
  if (is_array($arParams["IBLOCK_ID"])) {
    if (!in_array('all', $arParams['IBLOCK_ID']))
      break;
  }
  $arParams["IBLOCK_ID"] = array();
};
foreach ($arParams["IBLOCK_ID"] as $index => $IBlock){
  if ($IBlock === "") unset($arParams["IBLOCK_ID"][$index]);
}
if (!is_array($arParams["SECTION_ID"])) $arParams["SECTION_ID"] = array();
foreach ($arParams["SECTION_ID"] as $index => $Sect){
  if ($Sect === "") unset($arParams["SECTION_ID"][$index]);
}
$arParams["DEPTH_LEVEL_SECTIONS"] = intval($arParams["DEPTH_LEVEL_SECTIONS"]);
if ($arParams["DEPTH_LEVEL_SECTIONS"] < 0) $arParams["DEPTH_LEVEL_SECTIONS"] = 0;
$ib_types_flag = 1;
$ib_flag = 1;
$ib_sections_flag = 1;
$ib_elements_flag = 1;
$depthLevel = 0;
$level = 0;
$arResult = array();
if (!isset($arParams["HIDE_ELEMENT"])) $arParams["HIDE_ELEMENT"] = 'N';
switch ($arParams["HIDE_ELEMENT"]) {
  case 'AVAILABLE':
  case 'ACTIVE':
    $bIncCnt = true;
    break;
  case 'N':
  default:
    $bIncCnt = false;
    break;
}
if ($arParams["ELEMENT_CNT"] == "Y") {
  $bIncCnt = true;
}
$obCache = new CPHPCache;
$lifeTime = $arParams["CACHE_TIME"];
$cacheId = SITE_ID . serialize($arParams) . $USER->GetUserGroupString();
if ($obCache->StartDataCache($lifeTime, $cacheId, "/")) {
  $arFilterDefault = array("ACTIVE" => "Y", "CATALOG_AVAILABLE" => "Y");
  if ($arParams["DEPTH_LEVEL_FINISH"] >= 1) {
    $i = 0;
    $arOrder = array($arParams['IBLOCK_TYPE_SORT_FIELD'] => $arParams['IBLOCK_TYPE_SORT_ORDER']);
    $arFilter = ($arParams['IBLOCK_TYPE_SORT_FIELD'] == 'name') ? array('LANGUAGE_ID' => LANGUAGE_ID) : array();
    if (is_set($arParams["IBLOCK_TYPE"]) && !is_array($arParams["IBLOCK_TYPE"])) {
      $arFilter['ID'] = $arParams["IBLOCK_TYPE"];
    }
    $ibTypes = CIBlockType::GetList($arOrder, $arFilter);
    while ($arIbType = $ibTypes->Fetch()) {
      $continue = true;
      if (is_array($arParams["IBLOCK_TYPE"])) {
        if (in_array($arIbType["ID"], $arParams["IBLOCK_TYPE"])) $continue = false;
        if(!empty($arParams["IBLOCK_TYPE_MASK"])){
          foreach ($arParams["IBLOCK_TYPE_MASK"] as $val) {
            $val = substr($val, 0, -1);
            if (!empty($val) && strpos($arIbType["ID"], $val) !== false) {
              $continue = false;
              break;
            }
          }
        }
      } else $continue = false;
      if ($continue) continue;
      $level = 1 - ($arParams["DEPTH_LEVEL_START"] - 1);
      $arIBType = (empty($arIbType['NAME'])) ? CIBlockType::GetByIDLang($arIbType["ID"], LANG) : $arIbType;
      if ($arIBType) {
        $mainCnt = 0;
        $mainIndex = 0;
        if ($arParams["DEPTH_LEVEL_START"] <= 1) {
          $depthLevel = $level;
          $url = str_replace("#IBLOCK_TYPE#", $arIbType["ID"], $arParams["IBLOCK_TYPE_URL"]);
          $url = str_replace($arParams['IBLOCK_TYPE_URL_REPLACE'], "", $url);
          $arResult[$i] = array($arIBType["NAME"], $url, array());
          $arResult[$i][3] = array("FROM_IBLOCK" => "1", "IS_PARENT" => "", "DEPTH_LEVEL" => $depthLevel, "FILTER" => $arFilterDefault + array("IBLOCK_TYPE" => $arIbType['ID']));
          $mainIndex = $i;
          $i++;
        }
        if ($arParams["DEPTH_LEVEL_FINISH"] >= 2) {
          $arFilter = Array('TYPE' => $arIbType["ID"], 'ID' => $arParams["IBLOCK_ID"], 'SITE_ID' => SITE_ID, 'ACTIVE' => 'Y', "CNT_ACTIVE" => 'Y');
          $res = CIBlock::GetList(array($arParams['IBLOCK_SORT_FIELD'] => $arParams['IBLOCK_SORT_ORDER']), $arFilter, $bIncCnt);
          while ($arRes = $res->GetNext()) {
            if ($arRes["ELEMENT_CNT"] <= 0 && $arParams["HIDE_ELEMENT"] != 'N')
              continue;
            if ($arParams["HIDE_ELEMENT"] == 'AVAILABLE') {
              $availCnt = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arRes["ID"], "ACTIVE" => "Y", "CATALOG_AVAILABLE" => 'Y'), false, false, array("ID"));
              $availCnt = $availCnt->SelectedRowsCount();
              if ($availCnt <= 0)
                continue;
            }
            $replaceTemp = array("#IBLOCK_CODE#", "#IBLOCK_ID#", "#IBLOCK_TYPE#");
            $replace = array($arRes["CODE"], $arRes["ID"], $arIbType["ID"]);
            $listPageUrl = str_replace($replaceTemp, $replace, $arRes['LIST_PAGE_URL']);
            $replaceTemp = array("#CODE#", "#ID#", "#TYPE#");
            $listPageUrl = str_replace($replaceTemp, $replace, $listPageUrl);
            $listPageUrl = str_replace("#IBLOCK_CODE#", $arRes["CODE"], $arRes['LIST_PAGE_URL']);
            $listPageUrl = str_replace("#IBLOCK_ID#", $arRes["ID"], $listPageUrl);
            $listPageUrl = str_replace("#CODE#", $arRes["CODE"], $listPageUrl);
            $listPageUrl = str_replace("#ID#", $arRes["ID"], $listPageUrl);
            $listPageUrl = str_replace("#TYPE#", $arIbType["ID"], $listPageUrl);
            $listPageUrl = str_replace("#IBLOCK_TYPE#", $arIbType["ID"], $listPageUrl);
            $level = 2 - ($arParams["DEPTH_LEVEL_START"] - 1);
            if ($arParams["DEPTH_LEVEL_START"] <= 2) {
              if ($depthLevel < $level)
                if ($arParams["DEPTH_LEVEL_START"] <= 1)
                  $arResult[$i - 1][3]["IS_PARENT"] = 1;
              $depthLevel = $level;
              $arResult[$i] = array($arRes["NAME"], $listPageUrl, array());
              if ($arParams["ELEMENT_CNT"] == "Y") {
                if ($arParams["ELEMENT_CNT_AVAILABLE"] == "Y") {
                  if ($arParams["HIDE_ELEMENT"] != 'AVAILABLE') {
                    $availCnt = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $arRes["ID"], "ACTIVE" => "Y", "CATALOG_AVAILABLE" => 'Y'), false, false, array("ID"));
                    $availCnt = $availCnt->SelectedRowsCount();
                  }
                  $mainCnt += $availCnt;
                  $cnt = $availCnt;
                } else {
                  $mainCnt += $arRes["ELEMENT_CNT"];
                  $cnt = $arRes["ELEMENT_CNT"];
                }
              }
              $arResult[$i][3] = Array("FROM_IBLOCK" => "1", "IS_PARENT" => "", "DEPTH_LEVEL" => $depthLevel, "PICTURE" => CFile::GetPath($arRes["PICTURE"]), "ELEMENT_CNT" => $cnt);
              if ($level == 1) {
                $arResult[$i][3]["FILTER"] = $arFilterDefault + array("IBLOCK_ID" => $arRes['ID']);
              }
              $arResult[$i][3]["ITEM_IBLOCK_ID"] = $arRes["ID"];
              $i++;
            } 
            if ($arParams["DEPTH_LEVEL_FINISH"] >= 3) {
              $arFilter = array("IBLOCK_ID" => $arRes["ID"], "ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y", "CNT_ACTIVE" => 'Y');
              if ($arParams["DEPTH_LEVEL_SECTIONS"] > 0) {
                $arFilter['<=DEPTH_LEVEL'] = $arParams["DEPTH_LEVEL_SECTIONS"];
              }
              $resSect = CIBlockSection::GetList(Array("left_margin" => "asc"), $arFilter, $bIncCnt);
              while ($arResSect = $resSect->GetNext()) {
                $level = 3 + ($arResSect["DEPTH_LEVEL"] - 1) - ($arParams["DEPTH_LEVEL_START"] - 1);
                if ($arResSect["ELEMENT_CNT"] <= 0 && $arParams["HIDE_ELEMENT"] != 'N') continue;
                if ($arParams["HIDE_ELEMENT"] == 'AVAILABLE') {
                  $availCnt = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $ar_res["ID"], "SECTION_ID" => $arResSect["ID"], "INCLUDE_SUBSECTIONS" => 'Y', "ACTIVE" => "Y", "CATALOG_AVAILABLE" => 'Y'), false, false, array("ID"));
                  $availCnt = $availCnt->SelectedRowsCount();
                  if ($availCnt <= 0) continue;
                }
                if ($arParams["DEPTH_LEVEL_START"] <= 3) {
                  if ($depthLevel < $level)
                    if ($arParams["DEPTH_LEVEL_START"] <= 2 || $arResSect["DEPTH_LEVEL"] > 1) $arResult[$i - 1][3]["IS_PARENT"] = 1;
                  $depthLevel = $level;
                  $arResult[$i] = array($arResSect["NAME"], $arResSect["SECTION_PAGE_URL"], array());
                  $child = array();
                  $resSubs = CIBlockSection::GetList(array("left_margin" => "asc"), array("SECTION_ID" => $arResSect["ID"]), false);
                  for ($f = 1; $arResSubs = $resSubs->Fetch(); $f++) {
                    $child[$f] = $arResSubs["ID"];
                  }
                  if ($arParams["ELEMENT_CNT"] == "Y") {
                    if ($arParams["ELEMENT_CNT_AVAILABLE"] == "Y") {
                      if ($arParams["HIDE_ELEMENT"] != 'AVAILABLE') {
                        $availCnt = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $ar_res["ID"], "SECTION_ID" => $arResSect["ID"], "INCLUDE_SUBSECTIONS" => 'Y', "ACTIVE" => "Y", "CATALOG_AVAILABLE" => 'Y'), false, false, array("ID"));
                        $availCnt = $availCnt->SelectedRowsCount();
                      }
                      $cnt = $availCnt;
                    } else
                      $cnt = $arResSect["ELEMENT_CNT"];
                  }
                  $arResult[$i][3] = Array("FROM_IBLOCK" => "1", "IS_PARENT" => "", "DEPTH_LEVEL" => $depthLevel, "PICTURE" => CFile::GetPath($arResSect["PICTURE"]), "ELEMENT_CNT" => $cnt, "CHILD_SECTION_ID" => $child);
                  if ($level == 1) {
                    $arResult[$i][3]["FILTER"] = $arFilterDefault + array("SECTION_ID" => $arResSect["ID"], "INCLUDE_SUBSECTIONS" => "Y");
                  }
                  $arResult[$i][3]["ITEM_IBLOCK_ID"] = $arResSect["ID"];
                  $i++;
                }
                if ($arParams["DEPTH_LEVEL_FINISH"] >= 4) {
                  $resElem = CIBlockElement::GetList(Array($arParams["ELEMENT_SORT_FIELD"] => $arParams["ELEMENT_SORT_ORDER"]), Array("IBLOCK_ID" => $ar_res["ID"], "SECTION_ID" => $arResSect["ID"]));
                  while ($arResElem = $resElem->GetNext()) {
                    $level = 3 + $arResSect["DEPTH_LEVEL"] - ($arParams["DEPTH_LEVEL_START"] - 1);
                    if ($arParams["DEPTH_LEVEL_START"] <= 4) {
                      if ($depthLevel < $level)
                        if ($arParams["DEPTH_LEVEL_START"] <= 3)
                          $arResult[$i - 1][3]["IS_PARENT"] = 1;
                      $depthLevel = $level;
                      $arResult[$i] = array($arResElem["NAME"], $arResElem["DETAIL_PAGE_URL"], $arResult[$i][2] = array(), array("FROM_IBLOCK" => "1", "IS_PARENT" => "", "DEPTH_LEVEL" => $depthLevel));
                      $i++;
                    }
                  }
                } 
              } 
            } 
          } 

          if ($arParams["DEPTH_LEVEL_START"] <= 1) $arResult[$mainIndex][3]["ELEMENT_CNT"] = $mainCnt;
          if ($arParams["HIDE_ELEMENT"] != 'N') {
            if (isset($arResult[$mainIndex + 1])) {
              if ($arResult[$mainIndex + 1][3]["IS_PARENT"] == 1 && $arResult[$mainIndex][3]["DEPTH_LEVEL"] == $arResult[$mainIndex + 1][3]["DEPTH_LEVEL"]) {
                unset($arResult[$mainIndex]);
              }
              if ($arResult[$mainIndex][3]["DEPTH_LEVEL"] == 1 && $arResult[$mainIndex][3]["IS_PARENT"] != 1) {
                unset($arResult[$mainIndex]);
              }
            } else unset($arResult[$mainIndex]);
          }
        } 
      } 
    } 
  } 
  $obCache->EndDataCache(array('arResult' => $arResult));
}else{
  $cachedData = $obCache->GetVars();
  $arResult = $cachedData['arResult'];
}
return $arResult;
?>