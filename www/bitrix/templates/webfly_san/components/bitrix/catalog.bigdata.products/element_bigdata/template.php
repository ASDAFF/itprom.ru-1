<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
$frame = $this->createFrame()->begin("");

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

$injectId = 'bigdata_recommeded_products_'.rand();
?>

<script type="text/javascript">
	BX.cookie_prefix = '<?=CUtil::JSEscape(COption::GetOptionString("main", "cookie_name", "BITRIX_SM"))?>';
	BX.cookie_domain = '<?=$APPLICATION->GetCookieDomain()?>';
	BX.current_server_time = '<?=time()?>';

	BX.ready(function(){
		bx_rcm_recommendation_event_attaching(BX('<?=$injectId?>_items'));
	});

</script>

<script type="text/javascript">
	/* Adding to basket */
	addToBasket = function addToBacketEvent($) {
		//console.log($(".link-basket").not(".added"));
		$(".link-basket").not(".added").on("click", function () {
			var wareId = $(this).attr("id").split('_')[2];
			if (isNaN(wareId)) {
				return false;
			}
			console.log(wareId);
			var url = "<?=SITE_TEMPLATE_PATH?>/ajax/buy.php",
				price = $(this).attr("price-val"),
//            options = $(".options input:checked").map(function(){return $(this).data("optid");}).get(),
				params = {id: wareId, cost: price};
			if ($(this).is(".btn-credit")) $.extend(params, {credit: "<?=GetMessage("WF_CREDIT_BUY3")?>"});
			$.post(url, params, function () {
				BX.onCustomEvent('OnBasketChange');
			});
		});
		$(".link-basket").addClass("added");
		console.log("hi");
	}
	addToBacketAnimation = function addToBacketAnimationEvent($) {
		$('.link-basket, .add-basket').not(".added1").on('click', function (event) {
			if($(this).hasClass("no-animation")) return true;
			var cartX = Math.ceil($(".basket-footer").offset().left),
				cartY = Math.ceil($(".basket-footer").offset().top); //cart coordinates
			var offsetX, offsetY;
			offsetX = Math.ceil($(this).offset().left);
			offsetY = Math.ceil($(this).offset().top);	//current button coordinates
			var virtBtn;
			if ($(this).is('.link-basket')) {
				virtBtn = '#virtual';
			}
			else {
				virtBtn = "#virtual2";
			}
			$(virtBtn).css({"left": offsetX + "px", "top": offsetY + "px"}).show(1).delay(1).queue(function () {
				$(virtBtn).css({"top": cartY, "left": cartX, 'opacity': 0, 'transform': 'scale(0.3,0.3)'}).delay(800).queue(function () {
					$(virtBtn).css({"top": 0, "left": 0, 'opacity': 1, 'transform': 'scale(1,1)'}).hide(1);
					$("#addCart").fadeIn(600).delay(1500).fadeOut(400);
					$(".basket-footer > .text").text('1').addClass('basket-count');
					$(".basket-info").fadeIn(150);
					$(this).dequeue();
				});
				$(this).dequeue();
			});
			event.preventDefault();
		});
		$('.link-basket, .add-basket').addClass("added1");
	}
</script>


<?

if (isset($arResult['REQUEST_ITEMS']))
{
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>

	<span id="<?=$injectId?>" class="bigdata_recommended_products_container"></span>

	<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script>

	<?
	$frame->end();
	return;
}


if (!empty($arResult['ITEMS']))
{
	?><script type="text/javascript">
	BX.message({
		CBD_MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CVP_TPL_MESS_BTN_BUY')); ?>',
		CBD_MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CVP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',

		CBD_MESS_BTN_DETAIL: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',

		CBD_MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
		CBD_BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
		BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
		CBD_ADD_TO_BASKET_OK: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_TITLE_ERROR: '<? echo GetMessageJS('CVP_CATALOG_TITLE_ERROR') ?>',
		CBD_TITLE_BASKET_PROPS: '<? echo GetMessageJS('CVP_CATALOG_TITLE_BASKET_PROPS') ?>',
		CBD_TITLE_SUCCESSFUL: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CVP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		CBD_BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
		CBD_BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
	});
	</script>
	<span id="<?=$injectId?>_items" class="bigdata_recommended_products_items">
	<input type="hidden" name="bigdata_recommendation_id" value="<?=htmlspecialcharsbx($arResult['RID'])?>">
	<?

	$arSkuTemplate = array();
	if(is_array($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as $iblockId => $skuProps)
		{
			$arSkuTemplate[$iblockId] = array();
			foreach ($skuProps as &$arProp)
			{
				ob_start();
				if ('TEXT' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_size full';
						$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
						$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_size';
						$strWidth = '100%';
						$strOneWidth = '20%';
						$strSlideStyle = 'display: none;';
					}
					?>
				<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
					<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_size_scroller_container">
						<div class="bx_size">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
								foreach ($arProp['VALUES'] as $arOneValue)
								{
									?>
								<li
									data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>;"
									><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span>
									</li><?
								}
								?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
					</div><?
				}
				elseif ('PICT' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_scu full';
						$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
						$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_scu';
						$strWidth = '100%';
						$strOneWidth = '20%';
						$strSlideStyle = 'display: none;';
					}
					?>
				<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
					<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

					<div class="bx_scu_scroller_container">
						<div class="bx_scu">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
								foreach ($arProp['VALUES'] as $arOneValue)
								{
									?>
								<li
									data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
									><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
							<span class="cnt"><span class="cnt_item"
													style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
													title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
									></span></span></li><?
								}
								?></ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
					</div><?
				}
				$arSkuTemplate[$iblockId][$arProp['CODE']] = ob_get_contents();
				ob_end_clean();
				unset($arProp);
			}
		}
	}

	?>

		<div class="bigdata-list">
			<div class="bigdata_title">Персональные рекомендации</div>
    <div class="product-catalog product-catalogXX">
        <ul id="accessories">
	<?
	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$strMainID = $this->GetEditAreaId($arItem['ID'] . $key);

		$arItemIDs = array(
			'ID' => $strMainID,
			'PICT' => $strMainID . '_pict',
			'SECOND_PICT' => $strMainID . '_secondpict',
			'MAIN_PROPS' => $strMainID . '_main_props',

			'QUANTITY' => $strMainID . '_quantity',
			'QUANTITY_DOWN' => $strMainID . '_quant_down',
			'QUANTITY_UP' => $strMainID . '_quant_up',
			'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
			'BUY_LINK' => $strMainID . '_buy_link',
			'BASKET_ACTIONS' => $strMainID.'_basket_actions',
			'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
			'SUBSCRIBE_LINK' => $strMainID . '_subscribe',

			'PRICE' => $strMainID . '_price',
			'DSC_PERC' => $strMainID . '_dsc_perc',
			'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

			'PROP_DIV' => $strMainID . '_sku_tree',
			'PROP' => $strMainID . '_prop_',
			'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
			'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
		);

		$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

		$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
			? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
			: $arItem['NAME']
		);
		$showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";

        //====================
        ?>
        <li class="bx_catalog_item wf-new  wf-hit " style="width: 25%">
            <div class="hold">
                <div class="visual">
                    <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" title="" alt="" id="bx_1893346188_6459464594_pict"/>
                    </a>
                </div>
                <div class="block">
                    <div class="description">
                        <a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $arItem['NAME']; ?>">
                            <? echo $arItem['NAME']; ?>
                        </a>
                    </div>
                    <div class="box" style="border-bottom: 0;">
                        <div class="col-left" style="width:150px;">
                            <span class="price">
                                <span class="my-digit"><?
                                    if (!empty($arItem['MIN_PRICE']))
                                    {
                                        if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
                                        {
                                            echo GetMessage(
                                                'CVP_TPL_MESS_PRICE_SIMPLE_MODE',
                                                array(
                                                    '#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
                                                    '#MEASURE#' => GetMessage(
                                                        'CVP_TPL_MESS_MEASURE_SIMPLE_MODE',
                                                        array(
                                                            '#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
                                                            '#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
                                                        )
                                                    )
                                                )
                                            );
                                        }
                                        else
                                        {
                                            echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                                        }
                                        if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
                                        {
                                            ?> <span style="color: #a5a5a5;font-size: 12px;font-weight: normal;white-space: nowrap;text-decoration: line-through;"><? echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?></span><?
                                        }
                                    }
                                    ?></span>&nbsp;<span class="rouble">&#8399;</span></span>
<!--                            <span class="available">В наличии</span>-->
                        </div>
                        <a href="javascript:void(0);" class="link-basket" id="bx_xx_<?=$arItem['ID']?>_buy_link"
						price-val="<?
                                    if (!empty($arItem['MIN_PRICE']))
                                    {
                                        if (isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
                                        {
                                            echo GetMessage(
                                                'CVP_TPL_MESS_PRICE_SIMPLE_MODE',
                                                array(
                                                    '#PRICE#' => $arItem['MIN_PRICE']['VALUE'],
                                                    '#MEASURE#' => GetMessage(
                                                        'CVP_TPL_MESS_MEASURE_SIMPLE_MODE',
                                                        array(
                                                            '#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
                                                            '#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
                                                        )
                                                    )
                                                )
                                            );
                                        }
                                        else
                                        {
                                            echo $arItem['MIN_PRICE']['VALUE'];
                                        }
                                        if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
                                        {
                                            echo $arItem['MIN_PRICE']['VALUE']; ?></span><?
                                        }
                                    }
                                    ?>">Купить</a>
<!--						<div class="bx_catalog_item_controls_blocktwo">-->
<!--							<a id="--><?// echo $arItemIDs['BUY_LINK']; ?><!--" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow">--><?//
//								echo('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
//								?><!--</a>-->
<!--						</div>-->
                    </div>
                </div>
            </div>
        </li>
        <?
	}
	?>
            </li>
        </ul>
    </div>

		</div>
	</span>

	<script type="application/javascript">
		$(addToBasket);
		$(addToBacketAnimation);
	</script>
<?
}


$frame->end();?>


