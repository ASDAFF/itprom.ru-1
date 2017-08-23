<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<h4><?=GetMessage("WF_SIMILAR_BLOG")?></h4>
<ul class="topics-list">

<?
if(count($arResult["ITEMS"]) == 0) echo "<li>".GetMessage("WF_SIMILAR_NO")."</li>";
else 
foreach($arResult["ITEMS"] as $key => $arItem):
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
  <li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <div class="visual">
      <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
        <img src="<?=$arItem["SMALL_PIC"]["src"]?>" 
             alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" 
             width="<?=$arItem["SMALL_PIC"]["width"]?>" 
             height="<?=$arItem["SMALL_PIC"]["height"]?>"
             style="border-radius: <?=($arItem["SMALL_PIC"]["width"]/2)?>px;"/>
      </a>
    </div>
    <div class="text">
      <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
    </div>
  </li>
<?endforeach;?>
</ul>