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

if(empty($arResult["BRAND_BLOCKS"])) return;
foreach ($arResult["BRAND_BLOCKS"] as $blockId => $arBB){
  $brandID = 'brand_'.$arResult['ID'].'_'.$this->randString();
  $html = '';?>
  <a title="<?=$arResult['NAME']?>" alt="<?=$arResult['NAME']?>" href="<?=SITE_DIR?>brands/<?=htmlspecialcharsbx($blockId)?>/" class="brand-logo" 
     style='background: url("<?=$arBB['PICT']['SRC']?>") no-repeat;' title="<?=$arBB['DESCRIPTION']?>"><?=$arBB['LINK']?></a>
<?}?>