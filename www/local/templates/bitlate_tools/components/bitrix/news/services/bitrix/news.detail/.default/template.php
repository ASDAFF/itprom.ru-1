<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?
$img = 0;
if (intval($arResult["DETAIL_PICTURE"]['ID']))
    $img = $arResult["DETAIL_PICTURE"]['ID'];
elseif (intval($arResult["PREVIEW_PICTURE"]['ID']))
    $img = $arResult["PREVIEW_PICTURE"]['ID'];

if ($img)
    $pic = CFile::ResizeImageGet($img, array('width' => 300, 'height' => 233), BX_RESIZE_IMAGE_EXACT, true);
?>
<div class="row">
    <?if (!empty($pic['src']) || $arResult["DISPLAY_PROPERTIES"]["SERVICES_LIST"]["VALUE"] || $arResult["DISPLAY_PROPERTIES"]["SHOW_ORDER_BUTTON"]["VALUE"] != ""):?>
        <div class="inner-content-preview columns large-5 xxlarge-4">
            <?if (!empty($pic['src'])):?>
                <img src="<?=$pic['src']?>" alt="<?=$arResult["NAME"]?>">
            <?endif;?>
            <?if ($arResult["DISPLAY_PROPERTIES"]["SERVICES_LIST"]["VALUE"] || $arResult["DISPLAY_PROPERTIES"]["SHOW_ORDER_BUTTON"]["VALUE"] != ""):?>
                <div class="inner-content-price">
                    <?foreach ($arResult["DISPLAY_PROPERTIES"]["SERVICES_LIST"]["VALUE"] as $i => $serviceName):?>
                        <div class="table-container inner-content-price-item">
                            <div class="table-item"><?=$serviceName?></div>
                            <div class="table-item text-right"><strong><?=$arResult["DISPLAY_PROPERTIES"]["SERVICES_LIST"]["DESCRIPTION"][$i]?></strong></div>
                        </div>
                    <?endforeach;?>
                    <?if ($arResult["DISPLAY_PROPERTIES"]["SHOW_ORDER_BUTTON"]["VALUE"] != ""):?>
                        <a href="#service-order" class="button fancybox"><?=GetMessage('ORDER_TITLE')?></a>
                    <?endif;?>
                </div>
            <?endif;?>
        </div>
        <div class="inner-content-info columns large-7 xxlarge-8">
    <?endif;?>
        <p>
        <?if (strlen($arResult["DETAIL_TEXT"]) > 0):?>
            <?=$arResult["DETAIL_TEXT"]?>
        <?else:?>
            <?=$arResult["PREVIEW_TEXT"]?>
        <?endif;?>
        </p>
        <?if (strlen($arResult["DISPLAY_PROPERTIES"]["BOTTOM_TEXT"]["DISPLAY_VALUE"]) > 0):?>
            <p><?=$arResult["DISPLAY_PROPERTIES"]["BOTTOM_TEXT"]["DISPLAY_VALUE"]?></p>
        <?endif;?>
        <?if (count($arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["VALUE"]) > 0):?>
            <h2><?=GetMessage('PHOTOGALLERY_TITLE')?></h2>
            <div class="owl-carousel inner-carousel">
                <?if (count($arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["VALUE"]) == 1):
                    $photo = $arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["FILE_VALUE"];
                    $photoPreview = CFile::ResizeImageGet($photo['ID'], array('width' => 310, 'height' => 216), BX_RESIZE_IMAGE_EXACT, true);?>
                    <div class="item">
                        <a href="<?=$photo['SRC']?>" class="fancybox" rel="gallery"><img src="<?=$photoPreview['src']?>" alt="<?=$photo['DESCRIPTION']?>"></a>
                    </div>
                <?else:?>
                    <?foreach ($arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["FILE_VALUE"] as $photo):
                        $photoPreview = CFile::ResizeImageGet($photo['ID'], array('width' => 310, 'height' => 216), BX_RESIZE_IMAGE_EXACT, true);?>
                        <div class="item">
                            <a href="<?=$photo['SRC']?>" class="fancybox" rel="gallery"><img src="<?=$photoPreview['src']?>" alt="<?=$photo['DESCRIPTION']?>"></a>
                        </div>
                    <?endforeach;?>
                <?endif;?>
            </div>
        <?endif;?>
    <?if (!empty($pic['src']) || $arResult["DISPLAY_PROPERTIES"]["SERVICES_LIST"]["VALUE"] || $arResult["DISPLAY_PROPERTIES"]["SHOW_ORDER_BUTTON"]["VALUE"] != ""):?>
        </div>
    <?endif;?>
</div>