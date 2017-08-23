<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?
$img = 0;
if (intval($arResult["DETAIL_PICTURE"]['ID']))
    $img = $arResult["DETAIL_PICTURE"]['ID'];
elseif (intval($arResult["PREVIEW_PICTURE"]['ID']))
    $img = $arResult["PREVIEW_PICTURE"]['ID'];

if ($img)
    $pic = CFile::ResizeImageGet($img, array('width' => 385, 'height' => 210), BX_RESIZE_IMAGE_EXACT, true);
?>
<div class="row inner-content-action">
    <?if (!empty($pic['src'])):?>
        <div class="inner-content-preview columns large-7 xxlarge-5">
            <img src="<?=$pic['src']?>" alt="<?=$arResult["NAME"]?>">
        </div>
        <div class="inner-content-info columns large-5 xxlarge-7">
    <?endif;?>
        <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
            <span class="label secondary"><?=$arResult["DISPLAY_ACTIVE_FROM"]?><?if ($arResult['ACTIVE_TO']):?> – <?=ConvertTimeStamp(strtotime($arResult['ACTIVE_TO']), $arParams["DETAIL_ACTIVE_DATE_FORMAT"])?><?endif;?></span>
        <?endif;?>
        <p>
        <?if(strlen($arResult["DETAIL_TEXT"])>0):?>
            <?echo $arResult["DETAIL_TEXT"];?>
        <?else:?>
            <?echo $arResult["PREVIEW_TEXT"];?>
        <?endif?>
        </p>
    <?if (!empty($pic['src'])):?>
        </div>
    <?endif;?>
</div>