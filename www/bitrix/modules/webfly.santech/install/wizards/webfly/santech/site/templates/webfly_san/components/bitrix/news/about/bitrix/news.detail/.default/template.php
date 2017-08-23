<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div id="content">
  <div class="c1">
    <div class="content-text-inner">
      <h1 style="margin-bottom: 20px;"><?=$arResult["PROPERTIES"]["SECTION"]["VALUE"]?></h1>
      <h3><?=$arResult["NAME"]?></h3>
      <?=$arResult["PREVIEW_TEXT"]?>
    </div>
  </div>
</div>
<div id="sidebar">
  <ul class="side-menu">
    <?
    $cat = $prevCat = "";
    foreach($arResult["SIDEBAR"] as $sidebar):
      $cat = $sidebar["SECTION"];
      if($cat != $prevCat):
        if($prevCat != ""):?>
            </ul>
          </li>
        <?endif?>
        <li>
          <h3><?=$cat?></h3>
          <ul>
      <?endif?>
            <li><a href="<?=$sidebar["URL"]?>"><?=$sidebar["NAME"]?></a></li>
      <?$prevCat = $cat;?>
    <?endforeach;?>
  </ul>
</div>