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
$showSectionsCount = array();
foreach ($arResult['SECTIONS'] as $arSection) {
    if (array_key_exists($arSection['ID'], $arParams['SECTIONS_COUNTS'])) {
        $showSectionsCount[$arSection['ID']] = $arParams['SECTIONS_COUNTS'][$arSection['ID']];
        $parentSection = $arSection['IBLOCK_SECTION_ID'];
        $i = 0;
        while ($parentSection > 0 && $i < 10) {
            $showSectionsCount[$parentSection] += $arParams['SECTIONS_COUNTS'][$arSection['ID']];
            $newParentSection = 0;
            foreach ($arResult['SECTIONS'] as $arSection2) {
                if ($arSection2['ID'] == $parentSection) {
                    $newParentSection = $arSection2['IBLOCK_SECTION_ID'];
                    break;
                }
            }
            $parentSection = $newParentSection;
            $i++;
        }
    }
}
?>
<ul class="menu vertical">
    <li><strong><?=GetMessage('CT_BCSF_FILTER_CATALOG_TITLE')?></strong></li>
    <?foreach ($arResult['SECTIONS'] as $arSection):
        if (array_key_exists($arSection['ID'], $showSectionsCount)):?>
            <li<?if ($arParams['CUR_SECTION_ID'] == $arSection['ID']):?> class="active"<?endif;?>><a href="<?=$APPLICATION->GetCurPageParam("ssection=".$arSection['ID'], array("ssection", "load"))?>"><?=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ($arSection['DEPTH_LEVEL'] - 1))?><?=$arSection['NAME']?> (<?=$showSectionsCount[$arSection['ID']]?>)</a></li>
        <?endif;?>
    <?endforeach;?>
</ul>