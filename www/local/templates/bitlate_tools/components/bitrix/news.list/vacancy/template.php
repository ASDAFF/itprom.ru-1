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
?>
<?if (count($arResult["ITEMS"]) > 0):?>
    <ul class="accordion" data-accordion>
        <?foreach($arResult["ITEMS"] as $arItem):
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            $pic = false;
            if (!empty($arItem['PREVIEW_PICTURE'])) {
                $pic = CFile::resizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 140, 'height' => 140), BX_RESIZE_IMAGE_EXACT, true);
            }?>
            <li class="accordion-item" data-accordion-item id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <a href="#" class="accordion-title inline-block-container">
                    <span class="arrow inline-block-item vertical-middle"></span>
                    <span class="desc row inline-block-item vertical-middle">
                        <strong class="name column large-6"><?=$arItem['NAME']?></strong>
                        <?if ($arItem["DISPLAY_PROPERTIES"]["PAYMENT"]):?>
                            <span class="info column large-6"><?=GetMessage("CT_PAYMENT")?> <span class="value"><?=$arItem["DISPLAY_PROPERTIES"]["PAYMENT"]["DISPLAY_VALUE"]?></span></span>
                        <?elseif (strlen($arItem["PREVIEW_TEXT"]) > 0):?>
                            <span class="info value column large-6"><?=$arItem["PREVIEW_TEXT"]?></span>
                        <?endif;?>
                    </span>
                </a>
                <div class="accordion-content row" data-tab-content>
                    <div class="inner-content-vacancy-info columns large-8 xxlarge-9">
                        <p><?=$arItem["DETAIL_TEXT"]?></p>
                    </div>
                    <div class="columns large-4 xxlarge-3">
                        <?if ($arItem["DISPLAY_PROPERTIES"]["PHONE"]):?>
                            <div class="inner-content-vacancy-param"><?=GetMessage("CT_PHONE")?> <span class="value"><?=$arItem["DISPLAY_PROPERTIES"]["PHONE"]["DISPLAY_VALUE"]?></span></div>
                        <?endif;?>
                        <?if ($arItem["DISPLAY_PROPERTIES"]["EMAIL"]):?>
                            <div class="inner-content-vacancy-param"><?=GetMessage("CT_EMAIL")?> <a href="mailto:<?=$arItem["DISPLAY_PROPERTIES"]["EMAIL"]["DISPLAY_VALUE"]?>"><?=$arItem["DISPLAY_PROPERTIES"]["EMAIL"]["DISPLAY_VALUE"]?></a></div>
                            <div class="inner-content-vacancy-param"><a href="mailto:<?=$arItem["DISPLAY_PROPERTIES"]["EMAIL"]["DISPLAY_VALUE"]?>" class="button tiny"><?=GetMessage("CT_RESUME")?></a></div>
                        <?endif;?>
                    </div>
                </div>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>