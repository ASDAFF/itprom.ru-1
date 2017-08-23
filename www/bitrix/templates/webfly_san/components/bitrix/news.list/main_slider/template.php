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
$this->setFrameMode(true);
$arItem = $arResult["ITEMS"][0];
//wfDump($arItem["DISPLAY_PROPERTIES"]["SLIDES"]["FILE_VALUE"]);
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>

<div class="promo">
  <div class="row">
    <div class="gallery-holder">
      <div class="general-gallery">
        <div class="gallery slider" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

            <?foreach($arItem["DISPLAY_PROPERTIES"]["SLIDES"]["FILE_VALUE"] as $key => $slide):?>

				<p><a href="<?=$arItem["PROPERTIES"]["LINKS"]["VALUE"][$key]?>"></a></p>
                <img src="<?=$slide["SRC"]?>" alt="<?=$slide["DESCRIPTION"]?>" />
            <?endforeach;?>

        </div>
      </div>
    </div>
    <div class="img-hold">
      <?if($arItem["PROPERTIES"]["STATIC"]["VALUE_XML_ID"] == 1):?>
        <a href="<?=$arItem["PROPERTIES"]["LINKS_PIC"]["VALUE"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" /></a>
      <?else:?>
        <a href="<?=$arItem["PROPERTIES"]["LINKS_PIC"]["VALUE"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" /></a>
      <?endif;?>
    </div>
  </div>
</div>