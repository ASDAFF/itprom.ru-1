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
$this->setFrameMode(true);?>

<?if ($arResult['SECTIONS'] > 0):?>
    <?foreach ($arResult['SECTIONS'] as &$arSection):
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
        $pic = false;
        if (false !== $arSection['PICTURE']) {
            $pic = CFile::ResizeImageGet($arSection['PICTURE']['ID'], array('width' => 170, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
            $arSection['PICTURE']['SRC'] = $pic['src'];
        }
        if (false === $arSection['PICTURE'] || false === $pic) {
            $arSection['PICTURE'] = array(
                'SRC' => SITE_TEMPLATE_PATH . '/images/no_photo.png',
                'ALT' => (
                    '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                    ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
                    : $arSection["NAME"]
                ),
                'TITLE' => (
                    '' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                    ? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
                    : $arSection["NAME"]
                )
            );
        }?>
        <div class="item columns" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
            <div class="small-4 column">
                <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>"><img src="<? echo $arSection['PICTURE']['SRC']; ?>" alt=""></a>
            </div>
            <div class="small-8 column">
                <?if ('Y' != $arParams['HIDE_SECTION_NAME']):?>
                    <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>" class="name"><? echo $arSection['NAME']; ?><?if ($arParams["COUNT_ELEMENTS"]):?> (<?=$arSection['ELEMENT_CNT']?>)<?endif;?></a>
                <?endif;?>
                <noindex>
                <?if ('' != $arSection['DESCRIPTION']):?>
                    <div class="desc"><? echo $arSection['DESCRIPTION']; ?></div>
                <?endif;?>
                </noindex>
            </div>
        </div>
    <?endforeach;?>
<?endif;?>