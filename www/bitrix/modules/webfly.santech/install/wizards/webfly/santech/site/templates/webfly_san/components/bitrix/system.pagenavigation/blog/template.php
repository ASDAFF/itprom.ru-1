<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$ClientID = 'navigation_'.$arResult['NavNum'];

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
?>
<div class="page-block">
  <span class="title"><?=GetMessage("pages")?></span>
  <?
  $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
  $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
    // to show always first and last pages
  $arResult["nStartPage"] = $arResult["NavPageCount"];
  $arResult["nEndPage"] = 1;

  $sPrevHref = '';
  if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]){
    $bPrevDisabled = false;
    if ($arResult["bSavePage"]){
      $sPrevHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
    } else {
      if ($arResult["NavPageCount"] == $arResult["NavPageNomer"]){
        $sPrevHref = $arResult["sUrlPath"].$strNavQueryStringFull;
      } else {
        $sPrevHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
      }
    }
  } else {
    $bPrevDisabled = true;
  }

  $sNextHref = '';
  if ($arResult["NavPageNomer"] > 1){
    $bNextDisabled = false;
    $sNextHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1);
  }else{
    $bNextDisabled = true;
  }
  if ($bPrevDisabled):?>
    <span class="disabled prev"><?=GetMessage("nav_prev")?></span>
  <?else:?>
    <a href="<?=$sPrevHref;?>" id="<?=$ClientID?>_previous_page" class="prev"><?=GetMessage("nav_prev")?></a>
  <?endif;?>
  <?if ($bNextDisabled):?>
    <span class="disabled next"><?=GetMessage("nav_next")?></span>
  <?else:?>
    <a href="<?=$sNextHref;?>" id="<?=$ClientID?>_next_page" class="next"><?=GetMessage("nav_next")?></a>
  <?endif;?>
</div>
<?CJSCore::Init();?>
<script type="text/javascript">
	BX.bind(document, "keydown", function (event) {
    event = event || window.event;
		if (!event.ctrlKey)	return;
		var target = event.target || event.srcElement;
		if (target && target.nodeName && (target.nodeName.toUpperCase() == "INPUT" || target.nodeName.toUpperCase() == "TEXTAREA")) return;
		var key = (event.keyCode ? event.keyCode : (event.which ? event.which : null));
		if (!key)	return;

		var link = null;
		if (key == 39) link = BX('<?=$ClientID?>_next_page');
		else if (key == 37)	link = BX('<?=$ClientID?>_previous_page');
		if (link && link.href) document.location = link.href;
	});
</script>