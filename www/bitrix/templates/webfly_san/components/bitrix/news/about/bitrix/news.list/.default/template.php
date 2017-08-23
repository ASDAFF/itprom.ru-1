<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<ul class="general-list">
<?
$prevCat = "";
$cat = "";
?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
  $cat = $arItem["PROPERTIES"]["SECTION"]["VALUE"];
  if($cat != $prevCat):
    if($prevCat != ""):?>
      </ul>
    </li>
    <?endif;
  ?>
	<li>
    <h2 class="title-type02"><?=$cat?></h2>
    <ul>
  <?endif;?>
	<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<a href="
			<?if ($arItem["CODE"] == "staff") { echo "/about/staff/"; } else { echo $arItem["DETAIL_PAGE_URL"]; } ?>
				"><?=$arItem["NAME"]?></a>
	</li>
  <?
  $prevCat = $cat;
endforeach;?>
</ul>