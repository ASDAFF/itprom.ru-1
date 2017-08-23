<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if ($arResult["NavRecordCount"] == 0 || $arResult["NavPageCount"] == 1)
	return;

$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
$pageUrl = explode("?", $APPLICATION->GetCurPageParam("", array("load", "PAGEN_" . $arResult["NavNum"])));
$strNavQueryString = ($pageUrl[1] != "" ? $pageUrl[1]."&amp;" : "");
?>
<div class="catalog-pagination">
<?

if ($arResult["NavPageCount"] > 7):
	if ($arResult["NavPageNomer"] <= 4)://Находимся в начале пагинатора
		if ($arResult["NavPageNomer"] > 1):
?>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">&nbsp;</a>
<?
		endif;
		$endPage = $arResult["NavPageNomer"] > 1 ? $arResult["NavPageNomer"] + 1 : 3;
		for ($i = 1; $i <= $endPage; $i++):
?>	
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$i?>" title="<?=$i?>" <?if ($arResult["NavPageNomer"] == $i):?>class="selected"<?endif;?>><?=$i?></a>
<?
		endfor;
		$middlePage = $endPage + intval(($arResult["NavPageCount"] - $endPage)/2);
?>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$middlePage?>">&hellip;</a>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">&nbsp;</a>
<?
	elseif ($arResult["NavPageNomer"] <= $arResult["NavPageCount"] - 4 ): //Находимся в середине пагинатора
?>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">&nbsp;</a>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
<?
		$middleStartPage = $arResult["NavPageNomer"] - 1 - intval($arResult["NavPageNomer"]/2 - 1);
?>	
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$middleStartPage?>">&hellip;</a>
<?
		for ($i = $arResult["NavPageNomer"] - 1; $i <= $arResult["NavPageNomer"] + 1; $i++):
?>	
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$i?>" <?if ($arResult["NavPageNomer"] == $i):?>class="selected"<?endif;?>><?=$i?></a>
<?
		endfor;
		$middleEndPage = $arResult["NavPageNomer"] + 1 + intval(($arResult["NavPageCount"] - $arResult["NavPageNomer"] + 1)/2);
?>	
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$middleEndPage?>">&hellip;</a>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">&nbsp;</a>
<?
	elseif ($arResult["NavPageNomer"] > $arResult["NavPageCount"] - 4 ): //Находимся в конце пагинатора
		$startPage = $arResult["NavPageNomer"] < $arResult["NavPageCount"] ? $arResult["NavPageNomer"] - 1 : $arResult["NavPageCount"] - 2;
		$middlePage = $startPage - intval(($startPage - 1)/2);
?>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">&nbsp;</a>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$middlePage?>">&hellip;</a>
<?
		
		for ($i = $startPage; $i <= $arResult["NavPageCount"]; $i++):
?>	
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$i?>" <?if ($arResult["NavPageNomer"] == $i):?>class="selected"<?endif;?>><?=$i?></a>
<?
		endfor;
		
		if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
?>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">&nbsp;</a>
<?
		endif;	
	endif;
else:
	if ($arResult["NavPageNomer"] > 1):
?>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">&nbsp;</a>
<?
	endif;
	for ($i = 1; $i < $arResult['NavPageCount'] + 1; $i++):
?>	
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$i?>" <?if ($arResult["NavPageNomer"] == $i):?>class="selected"<?endif;?>><?=$i?></a>
<?
	endfor;
	if ($arResult["NavPageNomer"] < $arResult['NavPageCount']):
?>
	<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">&nbsp;</a>
<?
	endif;
endif;	
?>
<?if($arResult['bShowAll']){?>
	<a href="<?=$arResult['sUrlPathParams']; ?>SHOWALL_<?=$arResult["NavNum"]?>=1&SIZEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageSize"]?>" class="showAll" ><?=getMessage('SHOW_ALL')?></a>
<?}?>
</div> 