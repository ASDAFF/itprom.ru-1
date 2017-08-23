<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="content-blog">
  <h1><a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><?=$arResult["NAME"]?></a></h1>
  <div class="block">
    <div class="heading-views">
      <span class="date"><?=$arResult["DATE_ACTIVE_FROM"]?></span>
      <?
      $_POST["WF_BLOG_DETAIL_ID"] = $arResult["ID"];
      $_POST["WF_BLOG_CATEGORY_ENUM"] = $arResult["PROPERTIES"]["CATEGORY"]["VALUE_ENUM_ID"];
      ?>
      <?foreach ($arResult["PROPERTIES"]["CATEGORY"]["VALUE"] as $key => $value){?>
        <a href="#" class="link-views" enumId = "<?=$arItem["PROPERTIES"]["CATEGORY"]["VALUE_ENUM_ID"][$key]?>"><?=$value?></a>
      <?}?>
      <span class="views-type01"><?=$arResult["SHOW_COUNTER"]?></span>
      <span class="views-type02">0</span>
    </div>
    <div class="visual">
      <a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>" /></a>
    </div>
    <div><?=$arResult["~DETAIL_TEXT"]?></div>
    <p><a href="<?=$arResult["LIST_PAGE_URL"]?>" class="btn-input btn-input-gray" style="width: 180px;height:35px;"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></p>
    <div class="comments-block">
      <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/hc_widget.php"));?>
    </div>
  </div>
</div>