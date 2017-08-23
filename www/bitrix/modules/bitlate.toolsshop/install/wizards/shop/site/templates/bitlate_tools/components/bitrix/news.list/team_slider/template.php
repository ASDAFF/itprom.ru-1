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
    <h3><?=$arParams["PAGER_TITLE"]?></h3>
    <div class="owl-carousel inner-team text-center">
        <?foreach($arResult["ITEMS"] as $arItem):
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            $pic = false;
            if (!empty($arItem['PREVIEW_PICTURE'])) {
                $pic = CFile::resizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 140, 'height' => 140), BX_RESIZE_IMAGE_EXACT, true);
            }?>
            <div class="item inner-content-team" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="preview float-center">
                    <?if ($pic !== false):?>
                        <img src="<?=$pic['src']?>" alt="<?=$arItem['NAME']?>">
                    <?endif;?>
                </div>
                <div>
                    <strong class="name"><?=$arItem['NAME']?></strong>
                    <div class="status contact"><?=$arItem['PREVIEW_TEXT']?></div>
                </div>
            </div>
        <?endforeach;?>
    </div>
<?endif;?>