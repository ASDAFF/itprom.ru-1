<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (!empty($arResult)):?>
    <nav class="inner-menu columns show-for-xlarge">
        <ul class="menu vertical">
            <?foreach($arResult as $itemIdex => $arItem):
                if ($arItem["DEPTH_LEVEL"] > 1) continue;?>
                <?if ($arItem["SELECTED"]):?>
                    <li class="active"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <?else:?>
                    <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <?endif?>
            <?endforeach;?>
        </ul>
    </nav>
<?endif;?>