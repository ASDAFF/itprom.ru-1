<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (!empty($arResult)):
    $previousLevel = 0;
    $col = 0;?>
    <ul class="inline-block-container">
        <?foreach ($arResult as $itemIdex => $arItem):
            if ($arItem["DEPTH_LEVEL"] > 2) continue;
            if ($arItem["DEPTH_LEVEL"] == 1) $col++;?>
            <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
            <?endif?>
            <?if ($arItem["IS_PARENT"] && $arItem["DEPTH_LEVEL"] < 2):?>
                <li class="inline-block-item footer-main-menu-category<?if ($col > 3):?> hide-for-xlarge-only<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                    <ul class="menu vertical footer-main-menu-list">
            <?else:?>
                <?if ($arItem["PERMISSION"] > "D"):?>
                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li class="inline-block-item footer-main-menu-category<?if ($col > 3):?> hide-for-xlarge-only<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                    <?else:?>
                        <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                    <?endif?>
                <?else:?>
                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li class="inline-block-item footer-main-menu-category"><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                    <?else:?>
                        <li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                    <?endif?>
                <?endif?>
            <?endif?>
            <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
        <?endforeach;?>
        <?if ($previousLevel > 1):?>
            <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
        <?endif?>
    </ul>
<?endif?>