<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>


<li id="comparelist-container">
  <a href="<?=$arParams["COMPARE_URL"]?>"><?=GetMessage("CATALOG_COMPARE_ELEMENTS")?></a>
  <?
  if(count($arResult)>0) $class="sravCount--active";
  else $class="";

  //$frame = $this->createFrame("comparelist-container",false)->begin();
  ?>
  <span class="sravCount <?=$class?>"><?=count($arResult)?></span>
  <span id="srav" class="add-block new"><?=GetMessage("WF_CATALOG_ELS")?></span>
  <?
  //$frame->end();
  ?>
</li>
<!--div class="catalog-compare-list">
<a name="compare_list"></a>
<?if(count($arResult)>0):?>
	<form action="<?=$arParams["COMPARE_URL"]?>" method="get">
	<table class="data-table" cellspacing="0" cellpadding="0" border="0">
		<thead>
		<tr>
			<td align="center" colspan="2"><?=GetMessage("CATALOG_COMPARE_ELEMENTS")?></td>
		</tr>
		</thead>
		<?foreach($arResult as $arElement):?>
		<tr>
			<td><input type="hidden" name="ID[]" value="<?=$arElement["ID"]?>" /><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></td>
			<td><noindex><a href="<?=$arElement["DELETE_URL"]?>" rel="nofollow"><?=GetMessage("CATALOG_DELETE")?></a></noindex></td>
		</tr>
		<?endforeach?>
	</table>
	<?if(count($arResult)>=2):?>
		<br /><input type="submit"  value="<?=GetMessage("CATALOG_COMPARE")?>" />
		<input type="hidden" name="action" value="COMPARE" />
		<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
	<?endif;?>
	</form>
<?endif;?>
</div-->