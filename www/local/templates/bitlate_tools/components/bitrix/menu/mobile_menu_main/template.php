<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (!empty($arResult)):
    $previousLevel = 0;?>
    <ul class="vertical menu<?if ($arParams["CHILD_MENU_TYPE"] != 'bottom'):?> mobile-menu-main<?endif;?>" data-drilldown data-wrapper="" data-back-button="<li class='js-drilldown-back'><a href='javascript:;'><?=getMessage('BACK')?></a></li>">
        <?foreach ($arResult as $itemIdex => $arItem):
            if ($arItem["DEPTH_LEVEL"] > 2) continue;?>
            <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
            <?endif?>
            <?if ($arItem["IS_PARENT"] && $arItem["DEPTH_LEVEL"] < 2):?>
                <li<?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                    <ul class="menu vertical">
            <?else:?>
                <?if ($arItem["PERMISSION"] > "D"):?>
                    <li<?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <?else:?>
                    <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li<?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                    <?else:?>
                        <li<?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
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