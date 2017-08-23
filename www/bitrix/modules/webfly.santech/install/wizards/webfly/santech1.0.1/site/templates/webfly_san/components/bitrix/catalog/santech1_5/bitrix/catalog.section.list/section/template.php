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
$_SESSION["mywf"]["el_cnt"] = $arResult['SECTION']["ELEMENT_CNT"];
$this->setFrameMode(true);
$arViewModeList = $arResult['VIEW_MODE_LIST'];
$arViewStyles = array(
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
$shortText = explode("*MORE*",$arResult["SECTION"]["~DESCRIPTION"]);
?>
<div class="content-text">
  <h1><?=isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
			? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
			: $arResult['SECTION']['NAME']?></h1>
  <?=$shortText[0]?>
  <?if(!empty($shortText[1])):?>
    <div class="more-details" style="display:none;">
      <?=$shortText[1]?>
    </div>
  <a href="javascript:void(0);" class="more"><span class="text1">Подробнее</span><span class="text2">Свернуть</span></a>
  <?endif;?>
</div>
<?
if (0 < $arResult["SECTIONS_COUNT"]){?>
<div class="product-catalog product-catalog03 myProdCat section">
<ul class="<?= $arCurView['LIST']; ?>">
<?
	switch ($arParams['VIEW_MODE']){
    case 'TILE':default:
			foreach ($arResult['SECTIONS'] as &$arSection){
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

				if (false === $arSection['PICTURE'])
					$arSection['PICTURE'] = array(
						'SRC' => $arCurView['EMPTY_IMG'],
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
				?>
        <li id="<?= $this->GetEditAreaId($arSection['ID']); ?>">
          <div class="hold">
            <div class="visual">
              <a href="<?= $arSection['SECTION_PAGE_URL']; ?>" title="<?= $arSection['PICTURE']['TITLE']; ?>">
                <img width="50" height="40" alt="<?=$arSection['PICTURE']['ALT']?>" src="<?=$arSection['PICTURE']['SRC']?>">
              </a>
            </div>
            <div class="block">
              <div class="description">
                <a href="<?= $arSection['SECTION_PAGE_URL']; ?>" title="<?= $arSection['PICTURE']['TITLE']; ?>" class="section-head"><h2><?=$arSection["NAME"]?></h2></a>
              </div>
            </div>
          </div>
        </li><?
			}       
			unset($arSection);
			break;
	}
?>
</ul>
</div>
<?
	echo ('LINE' != $arParams['VIEW_MODE'] ? '<div style="clear: both;"></div>' : '');
}
?>