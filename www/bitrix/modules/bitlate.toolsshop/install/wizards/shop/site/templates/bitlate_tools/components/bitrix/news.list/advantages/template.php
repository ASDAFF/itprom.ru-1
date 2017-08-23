<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if (count($arResult["ITEMS"]) > 0):?>
    <div class="main-plus">
        <div class="container row">
            <h2 class="main-plus-caption"><?=$arParams['PAGER_TITLE']?></h2>
            <ul class="main-plus-container inline-block-container">
                <?foreach($arResult["ITEMS"] as $k => $arItem):
                    $pic = false;
                    if (intval($arItem["PREVIEW_PICTURE"])) {
                        $pic = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"], array('width' => 200, 'height' => 115), BX_RESIZE_IMAGE_EXACT, true);
                    }?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <li class="main-plus-item inline-block-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <?if ($arItem["DISPLAY_PROPERTIES"]["TYPE_ICON"]["VALUE_XML_ID"]):?>
                            <svg class="icon main-plus-<?=$arItem["DISPLAY_PROPERTIES"]["TYPE_ICON"]["VALUE_XML_ID"]?>">
                                <use xlink:href="#svg-icon-plus-<?=$arItem["DISPLAY_PROPERTIES"]["TYPE_ICON"]["VALUE_XML_ID"]?>"></use>
                            </svg>
                        <?else:?>
                            <img src="<?=$pic['src']?>" alt="<?echo $arItem["PREVIEW_TEXT"];?>">
                        <?endif;?>
                        <div class="main-plus-text"><?echo $arItem["PREVIEW_TEXT"];?></div>
                    </li>
                <?endforeach;?>
            </ul>
        </div>
    </div>
<?endif;?>
