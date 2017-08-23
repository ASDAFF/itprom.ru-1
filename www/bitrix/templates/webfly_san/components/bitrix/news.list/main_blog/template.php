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
<div class="block-type01">
  <div class="heading-blog">
	  <p class="main-h2-title-type01">Блог ITProm<?/*=GetMessage("WF_COMPANY_BLOG")*/?></p>
    <a href="<?=SITE_DIR?>blog/" class="heading-link"><?=GetMessage("WF_READ_BLOG")?></a> </div>
    <ul class="blog-list">
<?foreach($arResult["ITEMS"] as $arItem):
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
      <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="title-blog"><?=$arItem["NAME"]?></a>
      <p><?=substr($arItem["PREVIEW_TEXT"], 0, 140)."..."?></p>
    </div>
  </li>
<?endforeach;?>
  </ul>
</div>