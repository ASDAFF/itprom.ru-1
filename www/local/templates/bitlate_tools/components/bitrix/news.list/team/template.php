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
    <div class="row large-up-2">
        <?foreach($arResult["ITEMS"] as $arItem):
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            $pic = false;
            if (!empty($arItem['PREVIEW_PICTURE'])) {
                $pic = CFile::resizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 140, 'height' => 140), BX_RESIZE_IMAGE_EXACT, true);
            }?>
            <div class="inner-content-team columns table-container" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="table-item vertical-top preview">
                    <?if ($pic !== false):?>
                        <img src="<?=$pic['src']?>" alt="<?=$arItem['NAME']?>" />
                    <?endif;?>
                </div>
                <div class="table-item">
                    <strong class="name"><?=$arItem['NAME']?></strong>
                    <div class="status contact"><?=$arItem['PREVIEW_TEXT']?></div>
                    <div class="row">
                        <?if ($arItem["DISPLAY_PROPERTIES"]["PHONE"]):?>
                            <div class="contact column small-12 medium-6 large-12 xxlarge-6">
                                <div class="param"><?=GetMessage("CT_PHONE")?></div> <?=$arItem["DISPLAY_PROPERTIES"]["PHONE"]["DISPLAY_VALUE"]?>
                            </div>
                        <?endif;?>
                        <?if ($arItem["DISPLAY_PROPERTIES"]["EMAIL"]):?>
                            <div class="contact column small-12 medium-6 large-12 xxlarge-6">
                                <div class="param"><?=GetMessage("CT_EMAIL")?></div> <a href="mailto:<?=$arItem["DISPLAY_PROPERTIES"]["EMAIL"]["DISPLAY_VALUE"]?>"><?=$arItem["DISPLAY_PROPERTIES"]["EMAIL"]["DISPLAY_VALUE"]?></a>
                            </div>
                        <?endif;?>
                    </div>
                </div>
            </div>
        <?endforeach;?>
    </div>
<?endif;?>