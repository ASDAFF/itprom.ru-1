<? if($_REQUEST["is_ajax_call"] !== "y") if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($_REQUEST["is_ajax_call"] === "y"){

	$sid = $_REQUEST['site_id'];
	$sid .= "";
	define("SITE_ID", $sid);
	require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
  include_once 'iblocks.php';
	require_once("lang/".LANGUAGE_ID."/template.php");
	
	if($_REQUEST["add2basket_srch"]  === "y" )
	{
		$APPLICATION->RestartBuffer();
		$message = "error";
		if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")){
			if(Add2BasketByProductID($_REQUEST['id'])){
				$message = GetMessage("INBASKET");
			}
		}
		echo $message;
		require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");
		die();
	}
}
	$save_param = new CPHPCache();
	if($_REQUEST["is_ajax_call"] === "y"){
		$lifetime = 60*60*24;
	}
	else{
		$lifetime = $arParams['CACHE_TIME'] ? intval($arParams['CACHE_TIME']) : 60*60*24;
		if ($this->arParams["CACHE_TYPE"] == "N" || ($this->arParams["CACHE_TYPE"] == "A" && COption::getOptionString("main", "component_cache_on", "Y") == "N")){
			CPHPCache::Clean("cache_wf_prms".SITE_ID, "/");
		}elseif($save_param->InitCache($lifetime, "cache_wf_prms".SITE_ID, "/")) {
			$vars = $save_param->GetVars();
			if($arParams != $vars["arParams"]) CPHPCache::Clean("cache_wf_prms".SITE_ID, "/");
		}
	}

	if($save_param->InitCache($lifetime, "cache_wf_prms".SITE_ID, "/")) :
		$vars = $save_param->GetVars();
		$arParams = $vars["arParams"];
	else:
		if($_REQUEST["is_ajax_call"] === "y"):
			die("cache");
		endif;
	endif;
	if($save_param->StartDataCache()):
		$save_param->EndDataCache(array(
			"arParams"    => $arParams,
		)); 
	endif;	

if($_REQUEST["is_ajax_call"] === "y"){
		
	/*AJAX SEARCH*/	
	$query = ltrim($_REQUEST["q"]);

  if(!isset($arParams["PAGE_2"]) || strlen($arParams["PAGE_2"])<=0) $arParams["PAGE_2"] = "#SITE_DIR#search/catalog.php";
	if(CModule::IncludeModule("search")){
    
    CUtil::decodeURIComponent($query);
		$categoryfilter = $_REQUEST["cat"];
		if(!isset($categoryfilter)) $categoryfilter = $_REQUEST["search_category"];
		if(!isset($categoryfilter)) $categoryfilter = "all";

		$arResult["alt_query"] = "";
		if($arParams["USE_LANGUAGE_GUESS"] !== "N"){
			$arLang = CSearchLanguage::GuessLanguage($query);
			if(is_array($arLang) && $arLang["from"] != $arLang["to"])
				$arResult["alt_query"] = CSearchLanguage::ConvertKeyboardLayout($query, $arLang["from"], $arLang["to"]);
		}

		$arResult["query"] = $query;
		$arResult["phrase"] = stemming_split($query, LANGUAGE_ID);
	}
  if($_REQUEST["is_before"] === "y"){
    function redirect($url){
      header('Location: '.$url);
      die('Location: '.$url." die");
    }

    function try_find($tree, $len_q){
      foreach ($tree as $item) {
        $sc = $item["NAME"];
        $sc_len = mb_strlen($sc);
        if($sc_len > 2)
          if($sc_len - $len_q <= 2 || $len_q >= 5) 
            redirect(SITE_DIR.substr( $item["URL"], 1 ));
      }
    }

    if($arParams["SEARCH_IN_TREE"] == "Y")
    {
      if(isset($_REQUEST["q"]))
        $q = trim($_REQUEST["q"]);
      else
        $q = false;

      $arQuery = array();
      if($q!==false)
      {
        if(CModule::IncludeModule("search"))
        {
          $arLang = CSearchLanguage::GuessLanguage($q);
          if(is_array($arLang) && $arLang["from"] != $arLang["to"])
            $arQuery["QUERY"] = htmlspecialcharsex(CSearchLanguage::ConvertKeyboardLayout($q, $arLang["from"], $arLang["to"]));
          else
            $arQuery["QUERY"] = htmlspecialcharsex($q);
        }
        else
          $arQuery["QUERY"] = htmlspecialcharsex($q);
      }
      else
        $arQuery["QUERY"] = false;

      if($arQuery["QUERY"]){
        $qu = $arQuery["QUERY"];
        $len_q = mb_strlen($qu);
        if($len_q > 3){
          if(CModule::IncludeModule("iblock")) {
            /*IBLOCKS*/
            $tree = array();
            $subq = mb_substr($qu, 0, $len_q-1);
            $res = CIBlock::GetList(
              Array(), 
              Array(
                'SITE_ID'=>SITE_ID, 
                'ACTIVE'=>'Y', 
                "%NAME" => $subq
              ), true
            );
            while($ar_res = $res->Fetch())
            {
              if($ar_res["LIST_PAGE_URL"])
              {
                $tree[] = array(
                  "NAME" => $ar_res["NAME"],
                  "URL" => $ar_res["LIST_PAGE_URL"],
                );
              }
            }
            try_find($tree, $len_q);

            /*SECTIONS*/
            $tree = array();
            $delete_sec = array();
            $arFilter = array(
              "ACTIVE" => "Y", 
              "GLOBAL_ACTIVE" => "Y", 
              "IBLOCK_ACTIVE" => "Y", 
              "%NAME" => $subq
            );
            $obSection = CIBlockSection::GetList(Array("depth_level"=>"asc"), $arFilter);
            while($item = $obSection->GetNext()){
              if(isset($delete_sec[$item["CODE"]]))
              {
                if(isset($tree[$item["CODE"]]))
                  $tree[$item["CODE"]] = NULL;
                continue;
              }
              else
                $delete_sec[$item["CODE"]] = true;
              $tree[$item["CODE"]] = array(
                "NAME" => $item["NAME"],
                "URL" => $item["SECTION_PAGE_URL"] ? $item["SECTION_PAGE_URL"] : $item["LIST_PAGE_URL"],
              );
            }
            try_find($tree, $len_q);
          }
        }
      }
    }

    if($arParams["CATEGORY_".$categoryfilter]){

      $exFILTER = array(
        0 => CSearchParameters::ConvertParamsToFilter($arParams, "CATEGORY_".$categoryfilter),
      );
      $exFILTER[0]["LOGIC"] = "OR";

      if($arParams["CHECK_DATES"] === "Y")
        $exFILTER["CHECK_DATES"] = "Y";

      $params = array("q" => $_REQUEST["q"]);

      $cat_url = CHTTP::urlAddParams(
        str_replace("#SITE_DIR#", SITE_DIR, $arParams["PAGE_2"])
        ,$params
        ,array("encode"=>true)
      ).CSearchTitle::MakeFilterUrl("f", $exFILTER);

      $cat_url = htmlspecialcharsex($cat_url);
    }

    if(!$cat_url)
    {
      $cat_url = CHTTP::urlAddParams(
        str_replace("#SITE_DIR#", SITE_DIR, $arParams["PAGE"])
        ,array("q" => $_REQUEST["q"])
        ,array("encode"=>true)
      );
    }
    redirect($cat_url);
  }
	if(!empty($query) && CModule::IncludeModule("search"))
	{	

		$arParams["NUM_CATEGORIES"] = intval($arParams["NUM_CATEGORIES"]);
		if($arParams["NUM_CATEGORIES"] <= 0)
			$arParams["NUM_CATEGORIES"] = 1;

		$arParams["TOP_COUNT"] = intval($arParams["TOP_COUNT"]);
		if($arParams["TOP_COUNT"] <= 0)
			$arParams["TOP_COUNT"] = 5;

		$arOthersFilter = array("LOGIC"=>"OR");

		for($i = 0; $i < $arParams["NUM_CATEGORIES"]; $i++)
		{

			if($categoryfilter != "all")
				if(intval($categoryfilter) != $i)
					continue;

			$category_title = trim($arParams["CATEGORY_".$i."_TITLE"]);
			if(empty($category_title))
			{
				if(is_array($arParams["CATEGORY_".$i]))
					$category_title = implode(", ", $arParams["CATEGORY_".$i]);
				else
					$category_title = trim($arParams["CATEGORY_".$i]);
			}
			if(empty($category_title))
				continue;

			$arResult["CATEGORIES"][$i] = array(
				"TITLE" => htmlspecialcharsbx($category_title),
				"ITEMS" => array()
			);

			$exFILTER = array(
				0 => CSearchParameters::ConvertParamsToFilter($arParams, "CATEGORY_".$i),
			);
			$exFILTER[0]["LOGIC"] = "OR";

			if($arParams["CHECK_DATES"] === "Y")
				$exFILTER["CHECK_DATES"] = "Y";

			$arOthersFilter[] = $exFILTER;

			$j = 0;
			$obTitle = new CSearchTitle;
			if($obTitle->Search(
				$arResult["alt_query"]? $arResult["alt_query"]: $arResult["query"]
				,$arParams["TOP_COUNT"]
				,$exFILTER
				,false
				,$arParams["ORDER"]
			))
			{
				while($ar = $obTitle->Fetch())
				{
					$j++;
					if($j > $arParams["TOP_COUNT"])
					{
						$params = array("q" => $arResult["alt_query"]? $arResult["alt_query"]: $arResult["query"]);

						$url = CHTTP::urlAddParams(
							str_replace("#SITE_DIR#", SITE_DIR, $arParams["PAGE_2"])
							,$params
							,array("encode"=>true)
						).CSearchTitle::MakeFilterUrl("f", $exFILTER);

						$arResult["CATEGORIES"][$i]["ITEMS"][] = array(
							"NAME" => GetMessage("MORE_CATEGORY"),
							"URL" => htmlspecialcharsex($url),
							"MORE" => "Y"
						);
						break;
					}
					else
					{
						$arResult["CATEGORIES"][$i]["ITEMS"][] = array(
							"NAME" => $ar["NAME"],
							"URL" => htmlspecialcharsbx($ar["URL"]),
							"MODULE_ID" => $ar["MODULE_ID"],
							"PARAM1" => $ar["PARAM1"],
							"PARAM2" => $ar["PARAM2"],
							"ITEM_ID" => $ar["ITEM_ID"],
						);
					}
				}
			}
			if(!$j)
			{
				unset($arResult["CATEGORIES"][$i]);
			}
		}
		if($arParams["SHOW_OTHERS"] === "Y" && $categoryfilter == "all")
		{
			$arResult["CATEGORIES"]["others"] = array(
				"TITLE" => htmlspecialcharsbx($arParams["CATEGORY_OTHERS_TITLE"]),
				"ITEMS" => array(),
			);

			$j = 0;
			$obTitle = new CSearchTitle;
			if($obTitle->Search($arResult["alt_query"]? $arResult["alt_query"]: $arResult["query"],$arParams["TOP_COUNT"],$arOthersFilter,true,$arParams["ORDER"])){
				while($ar = $obTitle->Fetch()){
					$j++;
					if($j > $arParams["TOP_COUNT"])
					{
						//it's really hard to make it working
						break;
					}
					else
					{
						$arResult["CATEGORIES"]["others"]["ITEMS"][] = array(
							"NAME" => $ar["NAME"],
							"URL" => htmlspecialcharsbx($ar["URL"]),
							"MODULE_ID" => $ar["MODULE_ID"],
							"PARAM1" => $ar["PARAM1"],
							"PARAM2" => $ar["PARAM2"],
							"ITEM_ID" => $ar["ITEM_ID"],
						);
					}
				}
			}
			if(!$j)	unset($arResult["CATEGORIES"]["others"]);
		}

		if(!empty($arResult["CATEGORIES"])){
			$arResult["CATEGORIES"]["all"] = array(
				"TITLE" => "",
				"ITEMS" => array()
			);

			$params = array(
				"q" => $arResult["alt_query"]? $arResult["alt_query"]: $arResult["query"],
			);
			$url = CHTTP::urlAddParams(str_replace("#SITE_DIR#", SITE_DIR, $arParams["PAGE"]),$params,array("encode"=>true));
			$arResult["CATEGORIES"]["all"]["ITEMS"][] = array(
				"NAME" => GetMessage("ALL_RESULTS"),
				"URL" => $url,
			);
		}

	}
//You may customize user card fields to display
$arResult['USER_PROPERTY'] = array(
	"UF_DEPARTMENT",
);
$arIBlocks = array();
$arResult["SEARCH"] = array();
foreach($arResult["CATEGORIES"] as $category_id => $arCategory){
	foreach($arCategory["ITEMS"] as $i => $arItem){
		if(isset($arItem["ITEM_ID"]))
			$arResult["SEARCH"][] = &$arResult["CATEGORIES"][$category_id]["ITEMS"][$i];
	}
}

foreach($arResult["SEARCH"] as $i => $arItem){
	switch($arItem["MODULE_ID"]){
		case "iblock":
			if(CModule::IncludeModule("catalog")){
				$arParams["CURRENCY"] = $arParams["CURRENCY"] ? $arParams["CURRENCY"] : CCurrency::GetBaseCurrency();
				$arConvertParams = array('CURRENCY_ID'=> $arParams["CURRENCY"]);
				$ProductPrarams  = CCatalogProduct::GetByID($arItem["ITEM_ID"]);
				//echo $ProductPrarams[VAT_INCLUDED];
				$arPrices = CatalogGetPriceTableEx($arItem["ITEM_ID"], 0, array(), 'Y', $arConvertParams);
				unset($arResult["SEARCH"][$i]["MIN_PRICE"]);
				unset($arResult["SEARCH"][$i]["PRICES"]);
				foreach($arParams["PRICE_CODE"] as $key => $prid)
				{
					if($arPrices["MATRIX"][$prid][0]){
						if(isset($arResult["SEARCH"][$i]["MIN_PRICE"])){
							if($arPrices["MATRIX"][$prid][0]["ORIG_DISCOUNT_PRICE"])
								$price_orig_val = $arPrices["MATRIX"][$prid][0]["ORIG_DISCOUNT_PRICE"];
							else
								$price_orig_val = $arPrices["MATRIX"][$prid][0]["DISCOUNT_PRICE"];
							if($arResult["SEARCH"][$i]["MIN_PRICE"]["DISCOUNT_PRICE"] > $price_orig_val)
								$arResult["SEARCH"][$i]["MIN_PRICE"] = $arPrices["MATRIX"][$prid][0];
						}	
						else
							$arResult["SEARCH"][$i]["MIN_PRICE"] = $arPrices["MATRIX"][$prid][0];
					}else{
            $arResult["SEARCH"][$i]["MIN_PRICE"] = $arPrices["MATRIX"][1][0];
          }
				}
        
				if(isset($arResult["SEARCH"][$i]["MIN_PRICE"])){
					$arResult["SEARCH"][$i]["PRICES"] = array();
					$arResult["SEARCH"][$i]["PRICES"]["PRICE"] = CurrencyFormat($arResult["SEARCH"][$i]["MIN_PRICE"]["PRICE"], $arParams["CURRENCY"]);
					$arResult["SEARCH"][$i]["PRICES"]["DISCOUNT_PRICE"] = CurrencyFormat($arResult["SEARCH"][$i]["MIN_PRICE"]["DISCOUNT_PRICE"], $arParams["CURRENCY"]);
				}
			}
		/* price end */
		/* preview start */
			if(CModule::IncludeModule('iblock'))
			{
				$ar_res = CIBlockElement::GetByID($arItem["ITEM_ID"])->GetNextElement();
				if($ar_res){
				    $field = $ar_res->GetFields();
				    $props = $ar_res->GetProperties();
				    if($field['PREVIEW_PICTURE'])
					    $arResult["SEARCH"][$i]["PREVIEW_PICTURE"] = CFile::GetPath($field['PREVIEW_PICTURE']);	
					$arResult["SEARCH"][$i]["FOR_ORDER"] = $props['FOR_ORDER'];	
					
					if(!is_array($arResult["SEARCH"][$i]["PRICES"]) && is_array($props['PRICE_BASE']))
					{
						$arResult["SEARCH"][$i]["PRICES"] = array();
						$arResult["SEARCH"][$i]["PRICES"]["PRICE"] = $props['PRICE_BASE']["VALUE"]." <span class='rubl'>".GetMessage('RUB')."</span>";		
					}
				}
			}
			if(CModule::IncludeModule("catalog"))
			{
				$db_res = CCatalogProduct::GetList( 
					array(), 
					array("ID" => $arItem["ITEM_ID"]), 
					false, 
					false, 
					array("QUANTITY", "QUANTITY_TRACE", "CAN_BUY_ZERO")
				);
				while ($ar_res = $db_res->Fetch()) {
					$arResult["SEARCH"][$i]["QUANTITY"] = $ar_res["QUANTITY"];
					$arResult["SEARCH"][$i]["QUANTITY_TRACE"] = $ar_res["QUANTITY_TRACE"];
					$arResult["SEARCH"][$i]["CAN_BUY_ZERO"] = $ar_res["CAN_BUY_ZERO"];
				}
			}
		/* preview end */
			break;
	}
}
					
$arParams['PHOTO_SIZE'] = $arParams['PHOTO_SIZE'] ? intval($arParams['PHOTO_SIZE']) : 5 ;

if(!empty($arResult["CATEGORIES"])):
 // ----- find photo ---------

	$arParams['IMAGE'] = 'MORE_PHOTO';
	$arParams['HEIGHT'] = '50';
	$arParams['WIDTH'] = '50';
	$obCache = new CPHPCache; 

	function GetIBlockSection2($ID, $TYPE = "")
	{
		$ID = intval($ID);
		if($ID > 0)
		{
			$iblockSection = CIBlockSection::GetList(array(), array(
				"ID" => $ID,
				"ACTIVE" => "Y",
			));
			if($arIBlockSection = $iblockSection->GetNext())
			{
				return $arIBlockSection;
			}
		}
		return false;
	}

	foreach($arResult["CATEGORIES"] as $category_id => $arCategory){
		foreach($arCategory["ITEMS"] as &$arItem)
		{
			$pathResizeImage = NULL;
			$image = NULL;
			$arElement = NULL;
			$section = NULL;
			$arIBlockSection = NULL;
      if(CModule::IncludeModule("iblock")){
        $cache_id = 'ajax-search-w'.$arItem['ITEM_ID']; 
        if($_REQUEST["clear_cache"] == "Y")
          CPHPCache::Clean($cache_id, "/");
        if($obCache->InitCache($arParams["CACHE_TIME"], $cache_id, "/")) {
          $vars = $obCache->GetVars();
          $pathResizeImage = $vars["PRODUCT_PICTURE_SRC"];
          $section = $vars["SECTION"];
        }
        else{
          if($arItem['ITEM_ID'][0] == "S"){
            $section = array();
            $section_id = intval(substr($arItem['ITEM_ID'], 1));

            $arIBlockSection = GetIBlockSection2($section_id);
            $image =  CFile::GetFileArray($arIBlockSection["PICTURE"]);

            $image = $image["SRC"];
            if(!$image) 
              $section["NOT_IMAGE"] = true;
            if(CCatalog::GetByID($arItem['PARAM2']))
              $section["CATALOG"] = true;	
          }else{
            $arElement = wfIBSearchElementsByProp(false, array("ID" =>$arItem['ITEM_ID']),array("PROPERTY_BRAND_REF","PROPERTY_MANUFACTURER", "DETAIL_PICTURE"));
            $image = $arElement[0]["DETAIL_PICTURE"];
            $producer = $arElement[0]["BRAND_REF"];
            $brandCountry = $arElement[0]["MANUFACTURER"];
          }
          $ResizeParams = array('width' => $arParams['WIDTH'], 'height' => $arParams['HEIGHT']);
          $ResizeImage = CFile::ResizeImageGet($image, $ResizeParams,  BX_RESIZE_IMAGE_PROPORTIONAL, true);
          $pathResizeImage = $ResizeImage['src'];
        }
        if($obCache->StartDataCache()):
          $obCache->EndDataCache(array("SECTION" => $section, "PRODUCT_PICTURE_SRC" => $pathResizeImage, "PRODUCT_BRAND" => $producer, "PRODUCT_COUNTRY" => $brandCountry)); 
        endif;

        $arItem['SECTION'] = $section;
        $arItem['PRODUCT_PICTURE_SRC'] = $pathResizeImage;
        $arItem['PRODUCT_BRAND'] = $producer;
        $arItem['PRODUCT_COUNTRY'] = $brandCountry;
      }
		}
	}
		unset($obCache);
endif;
 // ----- end find photo -----

/*AJAX.PHP START*/
		if(!empty($query))
			require_once("ajax.php");
		require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");
		die();
	}
/*AJAX.PHP END*/


/**/
if ($this->__folder) {
	$pathToTemplateFolder = $this->__folder;
} else {
	$pathToTemplateFolder = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', dirname(__FILE__));
}
/*COLOR*/
	$arColorSchemes = array ('red', 'green', 'ice', 'metal', 'pink', 'yellow') ;
	$color_scheme = 'red';
	if($arParams['COLOR_SCHEME'] && in_array($arParams['COLOR_SCHEME'], $arColorSchemes, true))
		$color_scheme = $arParams['COLOR_SCHEME'];
	$APPLICATION->SetAdditionalCSS("{$pathToTemplateFolder}/css_color/{$color_scheme}.css");
/*JQUERY*/
	if($arParams['INCLUDE_JQUERY'] == 'Y')
		CJSCore::Init(array("jquery"));
/*SELECTBOX*/
	$APPLICATION->AddHeadScript("{$pathToTemplateFolder}/selectbox.js");
?>
