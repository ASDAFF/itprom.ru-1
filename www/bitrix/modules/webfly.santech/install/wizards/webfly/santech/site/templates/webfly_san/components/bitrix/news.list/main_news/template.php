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
<div class="heading-blog">
  <h2 class="title-type01"><?=GetMessage("WF_COMPANY_NEWS")?></h2>
  <a href="<?=SITE_DIR?>news/" class="heading-link"><?=GetMessage("WF_READ_NEWS")?></a>
  <div class="clearfix"></div>
</div>
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
      <?
      $startDate = strtolower(FormatDate("j F", MakeTimeStamp($arItem["ACTIVE_FROM"])));
      ?>
      <span class="blog-date"><?=$startDate;?></span>
      <p><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></p>
    </div>
  </li>
<?endforeach;?>
  </ul>