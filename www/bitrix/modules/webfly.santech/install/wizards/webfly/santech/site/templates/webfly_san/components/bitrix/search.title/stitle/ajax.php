<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>		
<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):
	foreach($arCategory["ITEMS"] as $i => $arItem):
	  $curId = "elem-it-".$arItem['PARAM2']."-".$arItem['ITEM_ID'];
		if(is_array($arItem['SECTION'])):?>
			<li>
				<div class="sim-img" id="<?=$curId?>-photo">
					<img src="<?=$arItem['PRODUCT_PICTURE_SRC']?>" alt="" />
				</div>
				<div class="name">
					<a href="<?= $arItem["URL"]?>"><?=$arItem['SECTION']["CATALOG"]?GetMessage('SECTION_CATALOG'):GetMessage('SECTION');?> <?echo $arItem["NAME"];?></a>
				</div>
				<div style="clear:both;"></div>
			</li>
		<?elseif($category_id === "all"):?>
			<li class="noitem all">
				<div class="name">
					<a href="<?= $arItem["URL"]?>"><?= $arItem["NAME"]?></a>
				</div>
				<div style="clear:both;"></div>
			</li>
		<?elseif($category_id === "other"):?>
			<li class="noitem other">
				<div class="name">
					<a href="<?= $arItem["URL"]?>"><?= $arItem["NAME"]?></a>
				</div>
				<div style="clear:both;"></div>
			</li>
		<?elseif($arItem["MORE"] == "Y"):?>
			<li class="noitem i_all">
				<a href="<?= $arItem["URL"]?>"> <?= $arItem["NAME"]?></a><div style="clear:both;"></div>
			</li>
		<?else:?>
			<li>
				<div class="li_line sim-img" id="<?=$curId?>-photo">
					<?if(isset($arItem["PRODUCT_PICTURE_SRC"])):?>
						<img src="<?=$arItem['PRODUCT_PICTURE_SRC']?>" alt="" />
					<?endif;?>
				</div>
				<div class="li_line name">
					<a href="<?= $arItem["URL"]?>"> <?= $arItem["NAME"];?></a>
				</div>
				<?if(isset($arItem["PRICES"])):
					unset($price_disc);
					$price = str_replace(GetMessage('RUB_REPLACE'), '&nbsp;<span class="rouble">&#8399;</span>', $arItem["PRICES"]["PRICE"]);
					if($arItem["PRICES"]["DISCOUNT_PRICE"] !== $arItem["PRICES"]["PRICE"]){
						if(isset($arItem["PRICES"]["DISCOUNT_PRICE"]))
							$price_disc = str_replace(GetMessage('RUB_REPLACE'), '&nbsp;<span class="rouble">&#8399;</span>',  $arItem["PRICES"]["DISCOUNT_PRICE"]);
					}		
				?>
        <div class="li_line info">
			Производитель: <?=$arItem["PRODUCT_BRAND"]?><br/>
		  Страна: <?=$arItem["PRODUCT_COUNTRY"]?>
        </div>

					<div class="li_line buy-block">		
						<?if($arItem["FOR_ORDER"]["VALUE"] == "Y"):?>
							<div class="have for_order"><?=GetMessage("HAVE_ORDER")?></div>
						<?elseif($arItem["QUANTITY_TRACE"] == "Y" && $arItem["QUANTITY"] == 0 && $arItem["CAN_BUY_ZERO"] != "Y"):?>
							<div class="have not_available"><?=GetMessage("HAVE_NOTAVAIABLE")?></div>
						<?else:?>
							<a class="add2basket link-basket" id="<?=$curId?>"><?=GetMessage("ADD2BASKET")?></a>
						<?endif;?>
					</div>									
					<div class="li_line price">
						<?if(isset($price_disc)):?>
							<div class="discount">
								<?=$price_disc?>
							</div>
							<div class="not_discount">
								<?=$price?>
							</div>
						<?else:?>
							<?=$price;?>
						<?endif;?>
					</div>
				<?endif;?>
				<div style="clear:both;"></div>
			</li>
		<?endif;?>
	<?endforeach;?>
<?endforeach;?>
