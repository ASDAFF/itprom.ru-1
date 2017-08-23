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
$img = 0;
if (intval($arResult["DETAIL_PICTURE"]['ID']))
    $img = $arResult["DETAIL_PICTURE"]['ID'];
elseif (intval($arResult["PREVIEW_PICTURE"]['ID']))
    $img = $arResult["PREVIEW_PICTURE"]['ID'];

if ($img)
    $pic = CFile::ResizeImageGet($img, array('width' => 160), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
?>
<div class="row inner-content-action table-container">
    <div class="inner-content-preview for-brand table-item">
        <div class="inner-content-brand">
            <?if (!empty($pic['src'])):?>
                <img src="<?=$pic['src']?>" alt="<?=$arResult["NAME"]?>">
            <?endif;?>
        </div>
    </div>
    <div class="inner-content-info table-item">
        <p>
        <?if (strlen($arResult["DETAIL_TEXT"]) > 0):?>
            <?=$arResult["DETAIL_TEXT"]?>
        <?elseif (strlen($arResult["PREVIEW_TEXT"]) > 0):?>
            <?=$arResult["PREVIEW_TEXT"]?>
        <?else:?>
            <?=GetMessage("ND_DESC_NEWS_EMPTY");?>
        <?endif;?>
        </p>
    </div>
</div>