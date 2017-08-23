<?
if (!empty($arResult['ITEMS']))
{
	$relItemIDS = array();
	foreach ($arResult['ITEMS'] as $arItem)
		if (intval($arItem['PROPERTIES']['RELATED_ITEM']['VALUE']))
			$relItemIDS[] = intval($arItem['PROPERTIES']['RELATED_ITEM']['VALUE']);
			

	if (!empty($relItemIDS))
	{
		$resItems = CIBlockElement::GetList(array(), array('ID' => array_unique($relItemIDS)), false, false, array('NAME', 'DETAIL_PAGE_URL'));
		while ($arItem = $resItems->GetNext())
		{
			$arResult['RELATED_ITEMS'][$arItem['ID']] = $arItem;
		}
	}
}
?>