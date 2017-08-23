<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<div class="c1">
  <div class="content-blog">
    <?
    //wfDump($arResult["ITEMS"]);
    $first = true;
    foreach($arResult["ITEMS"] as $arItem):?>
      <?
      $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
      $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
      if($first){?>
        <h1><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h1>
      <?}?>
      <div class="block" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?if(!$first):?>
          <h2><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h2>
        <?endif;?>
        <div class="heading-views">
          <span class="date"><?=$arItem["DATE_ACTIVE_FROM"]?></span>
          <?
			if(!empty($arItem["PROPERTIES"]["CATEGORY"]["VALUE"]))
          foreach ($arItem["PROPERTIES"]["CATEGORY"]["VALUE"] as $key => $value){?>
            <a href="#" class="link-views" enumId = "<?=$arItem["PROPERTIES"]["CATEGORY"]["VALUE_ENUM_ID"][$key]?>"><?=$value?></a>
          <?}?>
          <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="views-type01"><?=(empty($arItem["SHOW_COUNTER"])?"0":$arItem["SHOW_COUNTER"])?></a>
          <a href="#" class="views-type02">0</a>
        </div>
        <div class="visual">
          <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" /></a>
        </div>
		  <noindex><p><?=$arItem["PREVIEW_TEXT"]?> </p></noindex>
      </div>
      <?$first = false;?>
    <?endforeach;?>
    <?=$arResult["NAV_STRING"]?>
  </div>
</div>
