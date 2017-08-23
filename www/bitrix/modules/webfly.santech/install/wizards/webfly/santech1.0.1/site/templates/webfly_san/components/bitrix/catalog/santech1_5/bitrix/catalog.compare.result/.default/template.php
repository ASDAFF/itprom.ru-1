<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-compare-result">
<h1 style="padding: 30px 0 0 30px; margin-bottom: 0;">Сравнение товаров</h1>
<a name="compare_table"></a>
	<?/*?><!--noindex><p>
	<?if($arResult["DIFFERENT"]):
		?><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=N",array("DIFFERENT")))?>" rel="nofollow"><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?></a><?
	else:
		?><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?><?
	endif
	?>&nbsp;|&nbsp;<?
	if(!$arResult["DIFFERENT"]):
		?><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=Y",array("DIFFERENT")))?>" rel="nofollow"><?=GetMessage("CATALOG_ONLY_DIFFERENT")?></a><?
	else:
		?><?=GetMessage("CATALOG_ONLY_DIFFERENT")?><?
	endif?>
	</p></noindex-->
	<?if(!empty($arResult["DELETED_PROPERTIES"]) || !empty($arResult["DELETED_OFFER_FIELDS"]) || !empty($arResult["DELETED_OFFER_PROPS"])):?>
		<!--noindex><p>
		<?=GetMessage("CATALOG_REMOVED_FEATURES")?>:
		<?foreach($arResult["DELETED_PROPERTIES"] as $arProperty):?>
			<a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&pr_code=".$arProperty["CODE"],array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=$arProperty["NAME"]?></a>
		<?endforeach?>
		<?foreach($arResult["DELETED_OFFER_FIELDS"] as $code):?>
			<a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&of_code=".$code,array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=GetMessage("IBLOCK_FIELD_".$code)?></a>
		<?endforeach?>
		<?foreach($arResult["DELETED_OFFER_PROPERTIES"] as $arProperty):?>
			<a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&op_code=".$arProperty["CODE"],array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=$arProperty["NAME"]?></a>
		<?endforeach?>
		</p></noindex-->
	<?endif?>
	<?if(count($arResult["SHOW_PROPERTIES"])>0):?>
		<!--p>
		<form action="<?=$APPLICATION->GetCurPage()?>" method="get">
		<?=GetMessage("CATALOG_REMOVE_FEATURES")?>:<br />
		<?foreach($arResult["SHOW_PROPERTIES"] as $key => $arProperty):?>
      <label for="<?=$key?>_fea" class="myChb"><?=$arProperty["NAME"]?>
        <input id="<?=$key?>_fea" type="checkbox" class="checkbox" name="pr_code[]" value="<?=$arProperty["CODE"]?>" />
      </label>
		<?endforeach?>
		<?foreach($arResult["SHOW_OFFER_FIELDS"] as $code):?>
			<input type="checkbox" name="of_code[]" value="<?=$code?>" /><?=GetMessage("IBLOCK_FIELD_".$code)?><br />
		<?endforeach?>
		<?foreach($arResult["SHOW_OFFER_PROPERTIES"] as $arProperty):?>
			<input type="checkbox" name="op_code[]" value="<?=$arProperty["CODE"]?>" /><?=$arProperty["NAME"]?><br />
		<?endforeach?>
		<input type="hidden" name="action" value="DELETE_FEATURE" />
		<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
    <div style="clear:both;"></div>
		<input type="submit" value="<?=GetMessage("CATALOG_REMOVE_FEATURES")?>">
		</form>
		</p-->
	<?endif?>
  <?*/?>
<br />
<div style="clear:both;"></div>
<?//wfDump($arResult["ITEMS"])?>
<form action="<?=$APPLICATION->GetCurPage()?>" method="get">
	<table class="data-table" cellspacing="0" cellpadding="0" border="0">
		<thead>
      <?foreach($arResult["ITEMS"][0]["FIELDS"] as $code=>$field):?>
      <tr>
        <th valign="top" nowrap><?=GetMessage("IBLOCK_FIELD_".$code)?></th>
        <?foreach($arResult["ITEMS"] as $arElement):?>
          <td>
            <?switch($code):
              case "NAME":
                ?><a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="compare-title"><?=$arElement[$code]?></a><?
                if($arElement["CAN_BUY"]):?>
                  <br /><noindex><a href="<?=$arElement["BUY_URL"]?>" rel="nofollow" class="link-basket2"><?=GetMessage("CATALOG_COMPARE_BUY")?></a></noindex>
                <?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
                <br />
                <?=GetMessage("CATALOG_NOT_AVAILABLE")?><?
                endif;
                break;
              case "PREVIEW_PICTURE":
              case "DETAIL_PICTURE":
                if(is_array($arElement["FIELDS"][$code])):?>
                  <a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
                    <img border="0" src="<?=$arElement["PIC_D"]["src"]?>" width="<?=$arElement["PIC_D"]["width"]?>" 
                         height="<?=$arElement["PIC_D"]["height"]?>" alt="<?=$arElement["FIELDS"][$code]["ALT"]?>" />
                  </a>
                <?endif;
                break;
              default:
                echo $arElement["FIELDS"][$code];
                break;
            endswitch;
            ?>
          </td>
        <?endforeach?>
      </tr>
      <?endforeach;?>
		</thead>
		<?foreach($arResult["ITEMS"][0]["PRICES"] as $code=>$arPrice):?>
			<?if($arPrice["CAN_ACCESS"]):?>
			<tr>
				<th nowrap><?=$arResult["PRICES"][$code]["TITLE"]?></th>
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<td>
						<?if($arElement["PRICES"][$code]["CAN_ACCESS"]):?>
							<b><?=$arElement["PRICES"][$code]["PRINT_DISCOUNT_VALUE"]?></b>
						<?endif;?>
					</td>
				<?endforeach?>
			</tr>
			<?endif;?>
		<?endforeach;?>
		<?foreach($arResult["SHOW_PROPERTIES"] as $code=>$arProperty):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement){
				$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
				if(is_array($arPropertyValue)){
					sort($arPropertyValue);
					$arPropertyValue = implode(" / ", $arPropertyValue);
				}
				$arCompare[] = $arPropertyValue;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th nowrap>&nbsp;<?=$arProperty["NAME"]?></th>
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
            <td class="prp">
							<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</td>
						<?else:?>
						<th class="prp">
							<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</th>
						<?endif?>
					<?endforeach?>
				</tr>
			<?endif?>
		<?endforeach;?>
		<?foreach($arResult["SHOW_OFFER_FIELDS"] as $code):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement){
				$Value = $arElement["OFFER_FIELDS"][$code];
				if(is_array($Value)){
					sort($Value);
					$Value = implode(" / ", $Value);
				}
				$arCompare[] = $Value;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th valign="top" nowrap>&nbsp;<?=GetMessage("IBLOCK_FIELD_".$code)?>&nbsp;</th>
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
						<td valign="top">&nbsp;
							<?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code])?>
						</td>
						<?else:?>
						<th valign="top">&nbsp;
							<?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code])?>
						</th>
						<?endif?>
					<?endforeach?>
				</tr>
			<?endif?>
		<?endforeach;?>
		<?foreach($arResult["SHOW_OFFER_PROPERTIES"] as $code=>$arProperty):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement){
				$arPropertyValue = $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["VALUE"];
				if(is_array($arPropertyValue)){
					sort($arPropertyValue);
					$arPropertyValue = implode(" / ", $arPropertyValue);
				}
				$arCompare[] = $arPropertyValue;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th valign="top" nowrap>&nbsp;<?=$arProperty["NAME"]?>&nbsp;</th>
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
						<td valign="top">&nbsp;
							<?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</td>
						<?else:?>
						<th valign="top">&nbsp;
							<?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</th>
						<?endif?>
					<?endforeach?>
				</tr>

			<?endif?>
		<?endforeach;?>
		<tr>
        <th valign="top"><?=GetMessage("CATALOG_REMOVE")?></th>
        <?foreach($arResult["ITEMS"] as $arElement):?>
          <td valign="top" width="<?=round(100/count($arResult["ITEMS"]))?>%">
            <label for="<?=$arElement["ID"]?>-ele" class="myChb">
              <input id="<?=$arElement["ID"]?>-ele" type="checkbox" class="checkbox" name="ID[]" value="<?=$arElement["ID"]?>" />
            </label>
          </td>
        <?endforeach;?>
      </tr>
	</table>
	<br />
	<input type="submit" value="<?=GetMessage("CATALOG_REMOVE_PRODUCTS")?>" class="btn-input" style="margin-left: 40px;"/>
	<input type="hidden" name="action" value="DELETE_FROM_COMPARE_RESULT" />
	<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
</form>
<br />
</div>
