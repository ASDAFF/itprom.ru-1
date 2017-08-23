<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (!empty($arResult)):
    $previousLevel = 0;?>
    <nav class="header-main-menu hide-for-small-only hide-for-medium-only hide-for-large-only">
        <div class="container row">
            <div class="header-main-menu-block float-left">
                <ul class="header-main-menu-base menu dropdown float-left" data-dropdown-menu>
                    <?foreach ($arResult as $itemIdex => $arItem):
                        if ($arItem["DEPTH_LEVEL"] > 2) continue;?>
                        <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                            <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                        <?endif?>
                        <?if ($arItem["IS_PARENT"] && $arItem["DEPTH_LEVEL"] < 2):?>
                            <li class="header-main-menu-category<?if ($arItem["SELECTED"]):?> active<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                                <ul class="menu vertical header-main-menu-dropdown is-dropdown-submenu">
                        <?else:?>
                            <?if ($arItem["PERMISSION"] > "D"):?>
                                <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                                    <li class="header-main-menu-category<?if ($arItem["SELECTED"]):?> active<?endif?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                                <?else:?>
                                    <li<?if ($arItem["SELECTED"]):?> class="active"<?endif?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                                <?endif?>
                            <?else:?>
                                <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                                    <li class="header-main-menu-category<?if ($arItem["SELECTED"]):?> active<?endif?>"><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
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
            </div>
            <ul class="header-main-menu-other menu float-right hide">
                <li class="header-main-menu-category">
                    <a href="#" data-toggle="header-main-menu-full">
                        <svg class="icon">
                            <use xlink:href="#svg-icon-menu-more"></use>
                        </svg>
                    </a>
                    <div id="header-main-menu-full" class="dropdown-pane header-main-menu-dropdow-full" data-dropdown data-hover="true" data-hover-pane="true" data-v-offset="0">
                        <span class="header-main-menu-dropdown-arrow"><span class="inner"></span></span>
                        <ul class="container"></ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?endif?>