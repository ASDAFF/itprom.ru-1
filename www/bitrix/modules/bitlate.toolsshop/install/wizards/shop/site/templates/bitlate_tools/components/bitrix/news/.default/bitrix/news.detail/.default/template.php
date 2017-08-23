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
    <?if (!empty($pic['src'])):?>
        <div class="inner-content-preview columns large-5 xxlarge-4">
            <img src="<?=$pic['src']?>" alt="<?=$arResult["NAME"]?>">
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
        <?if (count($arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["VALUE"]) > 0):?>
            <h2><?=GetMessage('PHOTOGALLERY_TITLE')?></h2>
            <div class="owl-carousel inner-carousel">
                <?if (count($arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["VALUE"]) == 1):
                    $photo = $arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["FILE_VALUE"];
                    $photoPreview = CFile::ResizeImageGet($photo['ID'], array('width' => 310, 'height' => 216), BX_RESIZE_IMAGE_EXACT, true);?>
                    <div class="item">
                        <a href="<?=$photo['SRC']?>" class="fancybox" data-fancybox-group="gallery"><img src="<?=$photoPreview['src']?>" alt="<?=$photo['DESCRIPTION']?>"></a>
                    </div>
                <?else:?>
                    <?foreach ($arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["FILE_VALUE"] as $photo):
                        $photoPreview = CFile::ResizeImageGet($photo['ID'], array('width' => 310, 'height' => 216), BX_RESIZE_IMAGE_EXACT, true);?>
                        <div class="item">
                            <a href="<?=$photo['SRC']?>" class="fancybox" data-fancybox-group="gallery"><img src="<?=$photoPreview['src']?>" alt="<?=$photo['DESCRIPTION']?>"></a>
                        </div>
                    <?endforeach;?>
                <?endif;?>
            </div>
        <?endif;?>
        <?if (strlen($arResult["DISPLAY_PROPERTIES"]["BOTTOM_TEXT"]["DISPLAY_VALUE"]) > 0):?>
            <p><?=$arResult["DISPLAY_PROPERTIES"]["BOTTOM_TEXT"]["DISPLAY_VALUE"]?></p>
        <?endif;?>
        <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
            <span class="label"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
        <?endif;?>
    <?if (!empty($pic['src'])):?>
        </div>
    <?endif;?>
</div>