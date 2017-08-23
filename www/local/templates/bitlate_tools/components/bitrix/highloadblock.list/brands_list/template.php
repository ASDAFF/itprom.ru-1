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
<div class="main-brand hide-for-small-only">
    <div class="container row">
        <h2 class="main-brand-caption">Бренды</h2>
        <div class="main-brand-carousel owl-carousel">
  <?foreach ($arResult['rows'] as $row):
    $url = str_replace("#brand_code#",$row["UF_XML_ID"],$arParams["DETAIL_URL"]);
    //$url = str_replace("#brand_id#",$row["ID"],$arParams["DETAIL_URL"]);
    $myName=$row['UF_NAME'];
    $myFile=str_replace(array("width", "height"), array("qwe", "asd"), $row['UF_FILE']);
    ?>
      <a class="item" href="<?= $url ?>" title="<?=$myName?>">
          <?=$myFile;?>
      </a>

  <?endforeach?>
        </div>
    </div>
</div>