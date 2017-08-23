<?
class CBitlateToolsIBlockElementHandler
{
	/**
	 * Получение мин и макс значений цены для товара
	 * 
	 * @param int $ID код товара
	 * @param int $iblockCatalogId код информационного блока товаров
	 * @return array массив мин и макс значений цены
	 */
	public static function getMinMaxPrice($ID, $iblockCatalogId) {
		$minPrice = 0;
		$maxPrice = 0;
		\Bitrix\Main\Loader::includeModule('iblock');
		\Bitrix\Main\Loader::includeModule('catalog');
		
		$arPrice = CIBlockPriceTools::GetCatalogPrices($iblockCatalogId, array('BASE'));
		
		$priceRes = CPrice::GetList(array(), array("PRODUCT_ID" => $ID, "CATALOG_GROUP_ID" => $arPrice['BASE']['ID']));
		if ($arProductPrice = $priceRes->Fetch()) {
			$minPrice = intval($arProductPrice['PRICE']);
			$maxPrice = intval($arProductPrice['PRICE']);
		}
		$arOffers = CIBlockPriceTools::GetOffersArray(array('IBLOCK_ID' => $iblockCatalogId), array($ID), array(), array(), array(), 0, $arPrice, true);
		if (!empty($arOffers) && is_array($arOffers)) {
			foreach ($arOffers as $arOffer) {
				if (intval($arOffer['PRICES']['BASE']['VALUE']) < $minPrice || !$minPrice)
					$minPrice = intval($arOffer['PRICES']['BASE']['VALUE']);

				if (intval($arOffer['PRICES']['BASE']['VALUE']) > $maxPrice || !$maxPrice)
					$maxPrice = intval($arOffer['PRICES']['BASE']['VALUE']);
			}
		}

		return array('min' => $minPrice, 'max' => $maxPrice);
	}
	
	/**
	 * Установка рейтинга по-умолчанию при создании товара
	 * 
	 * @param array $arFields массив полей элемента информационного блока
	 */
	public static function OnAfterIBlockElementAdd($arFields)
	{
		if ($arFields["RESULT"]) {
			$mxResult = CCatalogSKU::GetInfoByProductIBlock($arFields["IBLOCK_ID"]);
			// если ИБ товаров
			if (is_array($mxResult)) {
				$ID = $arFields['ID'];
				$iblockCatalogId = $mxResult['PRODUCT_IBLOCK_ID'];
				$iblockOfferId = $mxResult['IBLOCK_ID'];
				/** @noinspection PhpDynamicAsStaticMethodCallInspection */
				$dbResult = CIBlockElement::GetList(
					array('ID' => 'ASC'),
					array('ID' => $arFields['ID'], 'IBLOCK_ID' => $arFields["IBLOCK_ID"]),
					false,
					false,
					array('ID', 'NAME', 'PROPERTY_DEFAULT_RATING')
				);
				if ($arItem = $dbResult->Fetch()) {
					$arItem['PROPERTY_DEFAULT_RATING_VALUE'] = intval($arItem['PROPERTY_DEFAULT_RATING_VALUE']);

					if ($arItem['PROPERTY_DEFAULT_RATING_VALUE'] <= 0) {
						CIBlockElement::SetPropertyValuesEx($arFields['ID'], $arFields['IBLOCK_ID'], array(
							'DEFAULT_RATING' => PRODUCT_DEFAULT_RATING
						));
					}
				}
			}
		}
	}

	/**
	 * Изменение мин и макс цены товара при изменении товара
	 * 
	 * @param array $arFields массив полей элемента информационного блока
	 */
	public function OnAfterIBlockElementUpdateHandler(&$arFields) {
		if ($arFields["RESULT"]) {
			$ID = 0;
			$iblockCatalogId = 0;
			$mxResult = CCatalogSKU::GetInfoByProductIBlock($arFields["IBLOCK_ID"]);
			// если ИБ товаров
			if (is_array($mxResult)) {
				$ID = $arFields['ID'];
				$iblockCatalogId = $mxResult['PRODUCT_IBLOCK_ID'];
			}
			if ($ID > 0) {
				$price = self::getMinMaxPrice($ID, $iblockCatalogId);
				if ($price['min'] > 0 && $price['max'] > 0) {
					CIBlockElement::SetPropertyValuesEx($ID, $iblockCatalogId, array('MIN_PRICE' => $price['min'], 'MAX_PRICE' => $price['max']));
				}
			}
		}
	}
	
	/**
	 * Изменение мин и макс цены товара при добавлении/изменении ценового предложения (цены)
	 * для товара или торгового предложения
	 * 
	 * @param int $ID код ценового предложения
	 * @param array $arFields массив параметров ценового предложения
	 */
	public function OnPriceUpdateHandler($ID, $arFields) {
		if ($arFields['PRODUCT_ID'] > 0) {
			$productId = 0;
			$iblockCatalogId = 0;
			$minPrice = 0;
			$maxPrice = 0;
			$mxResult = CCatalogSku::GetProductInfo($arFields['PRODUCT_ID']);
			// если торговое предложение
			if (is_array($mxResult)) {
				$productId = $mxResult['ID'];
				$iblockCatalogId = $mxResult['IBLOCK_ID'];
			// если товар
			} else {
				$productId = $arFields['PRODUCT_ID'];
			}
			$arRes = CCatalogProduct::GetByIDEx($productId);
			if ($arRes !== false) {
				$iblockCatalogId = $arRes['IBLOCK_ID'];
				$price = self::getMinMaxPrice($productId, $iblockCatalogId);
				if ($price['min'] > 0 && $price['max'] > 0) {
					CIBlockElement::SetPropertyValuesEx($productId, $iblockCatalogId, array('MIN_PRICE' => $price['min'], 'MAX_PRICE' => $price['max']));
				}
			}
		}
	}
}