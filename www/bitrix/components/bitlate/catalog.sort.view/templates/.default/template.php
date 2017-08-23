<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<div class="row">
    <div class="column large-3 hide-for-xlarge">
        <a href="javascript:;" class="button filter-mobile-toggle"><?=getMessage('FILTERS_TITLE')?></a>
    </div>
    <div class="column large-6 xlarge-8">
        <?if (!empty($arResult['SORT_VARIANTS']) && is_array($arResult['SORT_VARIANTS'])):?>
            <div class="catalog-sorting">
                <label>
                    <span><?=getMessage('SORT_TITLE')?>:</span>
                    <select>
                        <?foreach ($arResult['SORT_VARIANTS'] as $code => $arSort):
                            $sortUrl = $APPLICATION->GetCurPageParam("sort=".$code."&load=Y", array("sort", "load"));?>
                            <option <?=$arSort['SELECTED'] == 'Y' ? 'selected' : ''?> value="<?=$sortUrl?>" data-sort-code="<?=$code?>"><?=$arSort['title']?></option>
                        <?endforeach;?>
                    </select>
                </label>
            </div>
        <?endif;?>
    </div>
    <div class="column large-3 xlarge-4">
        <?if (!empty($arResult['VIEW_VARIANTS']) && is_array($arResult['VIEW_VARIANTS'])):?>
            <div class="catalog-view-select">
                <?$i = 0;
                foreach ($arResult['VIEW_VARIANTS'] as $arView):
                    $i++;
                    if ($arResult['VIEW_DEFAULT'] == $arView['CODE']) {
                        $link = $APPLICATION->GetCurPageParam('', array("view", "load"));
                        $linkAjax = $APPLICATION->GetCurPageParam('load=Y', array("view", "load"));
                    } else {
                        $link = $APPLICATION->GetCurPageParam("view=".$arView['CODE'], array("view", "load"));
                        $linkAjax = $APPLICATION->GetCurPageParam("view=".$arView['CODE']."&load=Y", array("view", "load"));
                    }?>
                    <a href="<?=$link?>" data-ajax="<?=$linkAjax?>" class="catalog-view-select__item<?if ($arView['CODE'] == 'list'):?> show-for-large<?endif;?><?if ($arResult['VIEW'] == $arView['CODE']):?> selected<?endif;?>" title="<?=$arView['TITLE']?>" data-view-code="<?=$arView['CODE']?>">
                        <svg class="icon">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-view-<?=$arView['ICON']?>"></use>
                        </svg>
                    </a>
                <?endforeach;?>
            </div>
        <?endif;?>
    </div>
</div>