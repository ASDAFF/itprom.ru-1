<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
  die();

$this->setFrameMode(true);

if (!empty($arResult['ERROR'])) {
  echo $arResult['ERROR'];
  return false;
}
$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/js/highloadblock/css/highloadblock.css');

//test_dump($arResult);
?>
<!-- data -->

<div class="product-catalog product-catalog03">
  <ul class="bx_catalog_tile_ul">
  <?foreach ($arResult['rows'] as $row):
    $url = str_replace("#brand_code#",$row["UF_XML_ID"],$arParams["DETAIL_URL"]);
    //$url = str_replace("#brand_id#",$row["ID"],$arParams["DETAIL_URL"]);
    $myName=$row['UF_NAME'];
    $myFile=$row['UF_FILE'];?>
    <li>
      <div class="hold  brand-block" style="min-height:258px">
        <div class="visual">
          <a href="<?= $url ?>" title="<?= $myName?>">
            <?= $myFile?>
          </a>
        </div>
      </div>
    </li>
  <?endforeach?>
  </ul>
</div>