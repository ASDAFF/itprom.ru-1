<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div id="custom-menu">
    <div class="header">
        <span class="title float-left"><?=GetMessage('CUSTOM_MENU_TITLE')?></span>
        <button type="button" class="toggle  float-right" data-tooltip aria-haspopup="true" data-click-open="false" data-disable-hover="true" data-tooltip-class="tooltip tooltip-fixed" title="<?=GetMessage('CUSTOM_MENU_TITLE')?>">
            <span class="line relative"></span>
            <span class="line center-line"></span>
            <span class="line relative"></span>
        </button>
        <div class="clearfix"></div>
    </div>
    <form action="<?=SITE_DIR?>" class="body">
        <fieldset class="radio-color">
            <legend><?=GetMessage('CUSTOM_MENU_COLOR_TITLE')?></legend>
            <?foreach ($arResult['THEME_LIST'] as $k => $themeInfo):?>
                <input type="radio" name="custom_color" class="show-for-sr custom-option" value="<?=$APPLICATION->GetCurPageParam("theme=" . $themeInfo['CODE'], array("theme"))?>" id="custom-color-<?=$k?>"<?if ($themeInfo['CODE'] == $arResult['CUR_THEME']):?> checked="checked"<?endif;?>>
                <label for="custom-color-<?=$k?>" class="row">
                    <span class="small-6 column" style="background-color: <?=$themeInfo['COLOR_1']?>;"></span>
                    <span class="small-6 column" style="background-color: <?=$themeInfo['COLOR_2']?>;"></span>
                </label>
            <?endforeach;?>
        </fieldset>
    </form>
</div>