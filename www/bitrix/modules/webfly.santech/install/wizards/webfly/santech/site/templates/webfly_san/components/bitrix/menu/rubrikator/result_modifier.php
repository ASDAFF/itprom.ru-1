<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arParams["RUB_SIGN"] != "N") $arParams["RUB_SIGN"] = "Y";
if ($arParams["VIEW_HIT"] == "Y") {
	$obCache = new CPHPCache;
	$life_time = $arParams['MENU_CACHE_TIME'] ? IntVal($arParams['MENU_CACHE_TIME']) : 604800;
	$cache_id = "menu_hits_horizontal";
	
	if ($obCache->InitCache($life_time, $cache_id, "/")) {
		$vars = $obCache->GetVars();

		if(is_array($vars['MENU_HITS']) && count($vars['MENU_HITS']) > 0)
			$arResult['HITS'] = $vars['MENU_HITS'];
	}

	if (!is_array($arResult['HITS']))
	{
		if ($arResult[0]['PARAMS']['FROM_IBLOCK'] == 1) {
			$fromIb = true;
		}

		$arHits = array();

		if (CModule::IncludeModule('catalog')) {
			$arPrice = CCatalogGroup::GetList(array(), array("NAME" => $arParams["PRICE_CODE"]), false, false, array("ID"))->Fetch();
		}

		foreach($arResult as $index => &$arItem) {
			if($arItem['DEPTH_LEVEL'] == 1 && $index !== 'HITS') {	
				$arSelect = array(
				   "ID",
				   "NAME",
				   "CODE",
				   "IBLOCK_ID",
				   "IBLOCK_SECTION_ID",
				   "DETAIL_PAGE_URL",
				   "DETAIL_PICTURE",
				   "PREVIEW_PICTURE",
				   "CATALOG_GROUP_".$arPrice["ID"],
           "PROPERTY_NEWPRODUCT",
           "PROPERTY_SALELEADER",
           "PROPERTY_SPECIAL_OFFER",
				  );

				$arFilter = $arItem['PARAMS']['FILTER'];
				
				if (!is_array($arFilter) || empty($arFilter)) {
					$arFilter = array("ACTIVE" => "Y", "CATALOG_AVAILABLE" => "Y");

					$arIbType = CIBlockType::GetList(array(), array("NAME" => $arItem["TEXT"]))->Fetch();
					if (!empty($arIbType)) {
						$arFilter += array("IBLOCK_TYPE" => $arIbType["ID"]);
					} else {
						$arIb = CIBlock::GetList(array(), array("NAME" => $arItem["TEXT"], 'SITE_ID' => SITE_ID, 'ACTIVE' => 'Y'))->Fetch();

						if(!empty($arIb)) {
							$arFilter += array("IBLOCK_ID" => $arIb["ID"]);
						} else {
							//$from = 'section';

							$arSect = CIBlockSection::GetList(array(), array("NAME" => $arItem["TEXT"], "DEPTH_LEVEL" => "1", 'ACTIVE' => 'Y'))->Fetch();

							$arFilter += array("SECTION_ID" => $arSect["ID"], "INCLUDE_SUBSECTIONS" => "Y");
						}
					}
				}
        $arFilter += array("!PROPERTY_SALELEADER" => false);
				$dbRes = CIBlockElement::GetList(array("PROPERTY_WEEK_COUNTER" => "desc"), $arFilter, false, array("nTopCount" => 3), $arSelect);

				while( $obEl = $dbRes->GetNextElement() ) {
					$arFields = $obEl->GetFields();

					if (!empty($arFields["IBLOCK_SECTION_ID"])) {
						$arSec = $arSect;
					}
          $path = (!empty($arFields['DETAIL_PICTURE'])) ? $arFields['DETAIL_PICTURE'] : $arFields['PREVIEW_PICTURE'];
          if(empty($path))
          {
            $arProp = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array(),
              array('CODE' => 'MORE_PHOTO'))->Fetch();
            $path = $arProp["VALUE"];
          }
          $path = CFile::ResizeImageGet($path, array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, false);
          $path = $path['src'];

					if (CModule::IncludeModule('catalog')) {
						$arResultPrices = CIBlockPriceTools::GetCatalogPrices($arFields["IBLOCK_ID"], array($arParams["PRICE_CODE"]));

						$arProduct = CCatalogProduct::GetByID($arFields["ID"]);
						$arProduct['VAT_INCLUDED'] = ($arProduct['VAT_INCLUDED']=='Y') ? true : false;
						
			  			$arPrices = CIBlockPriceTools::GetItemPrices($arFields["IBLOCK_ID"], $arResultPrices,
			  				$arFields, $arProduct['VAT_INCLUDED'], array("CURRENCY_ID" => $arParams["CURRENCY"]));
					}

					$arHits[$index][] = array(
						"NAME" => $arFields["NAME"],
						"SECTION" => $arSec["NAME"],
						"SECTION_PAGE_URL" => $arSec["SECTION_PAGE_URL"],
						"DETAIL_PAGE_URL" => $arFields["DETAIL_PAGE_URL"],
						"PHOTO" => $path,
						"PRICE" => $arPrices,
						"SALELEADER" => $arFields["PROPERTY_SALELEADER_VALUE"],
						"NEWPRODUCT" => $arFields["PROPERTY_NEWPRODUCT_VALUE"],
						"SPECIAL_OFFER" => $arFields["PROPERTY_SPECIAL_OFFER_VALUE"],
					);
				} // while( $obEl = $dbRes->GetNextElement() )

				$arResult['HITS'][$index] = $arHits[$index];

			} // if($arParams["VIEW_HIT"] == "Y" && $arItem['DEPTH_LEVEL'] == 1)

		} // foreach($arResult as &$arItem => $index)

		if($obCache->StartDataCache($life_time, $cache_id, "/"))
		{
			$obCache->EndDataCache(array("MENU_HITS" => $arHits)); 
		}

	} // if(!is_array($arResult['HITS']))

	unset($obCache);
}


?>