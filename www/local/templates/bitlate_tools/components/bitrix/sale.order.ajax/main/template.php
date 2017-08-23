<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$isConfirm = false;
CModule::IncludeModule('bitlate.toolsshop');
if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] != "N") {
    if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y") {
        if(strlen($arResult["REDIRECT_URL"]) == 0) {
            $isConfirm = true;
        }
    }
}
if (!$isConfirm):?>
    <nav class="show-for-large">
        <ul class="breadcrumbs cart" id="nav_delivery">
            <li class="active"><a href="<?=$arParams['PATH_TO_BASKET']?>" class="float-right"><span>1</span> <?=GetMessage("SALE_BASKET")?></a></li>
            <li class="active"><div class="float-right"><span>2</span> <?=GetMessage("SALE_CONTACTS_AND_DELIVERY")?></div></li>
            <li><div class="float-right"><span>3</span> <?=GetMessage("SALE_PAY")?></div></li>
        </ul>
        <ul class="breadcrumbs cart" id="nav_payment" style="display: none;">
            <li class="active"><div class="float-right"><span>1</span> <?=GetMessage("SALE_BASKET")?></div></li>
            <li class="active"><a href="#" class="float-right" onclick="showDelivery(); return false;"><span>2</span> <?=GetMessage("SALE_CONTACTS_AND_DELIVERY")?></a></li>
            <li class="active"><div class="float-right"><span>3</span> <?=GetMessage("SALE_PAY")?></div></li>
        </ul>
    </nav>
    <article class="inner-container cart-container">
        <div>
<?endif;?>
<?if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");
?>
<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>

<?
if (!function_exists("getColumnName"))
{
	function getColumnName($arHeader)
	{
		return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
	}
}

if (!function_exists("cmpBySort"))
{
	function cmpBySort($array1, $array2)
	{
		if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
			return -1;

		if ($array1["SORT"] > $array2["SORT"])
			return 1;

		if ($array1["SORT"] < $array2["SORT"])
			return -1;

		if ($array1["SORT"] == $array2["SORT"])
			return 0;
	}
}
?>

<div class="bx_order_make">
	<?
	if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
	{
		if(!empty($arResult["ERROR"]))
		{
			foreach($arResult["ERROR"] as $v)
				echo ShowError($v);
		}
		elseif(!empty($arResult["OK_MESSAGE"]))
		{
			foreach($arResult["OK_MESSAGE"] as $v)
				echo ShowNote($v);
		}

		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
	}
	else
	{
		if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
		{
			if(strlen($arResult["REDIRECT_URL"]) == 0)
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
			}
		}
		else
		{
			?>
			<script type="text/javascript">

			<?if(CSaleLocation::isLocationProEnabled()):?>

				<?
				// spike: for children of cities we place this prompt
				$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
				?>

				BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
					'source' => $this->__component->getPath().'/get.php',
					'cityTypeId' => intval($city['ID']),
					'messages' => array(
						'otherLocation' => '--- '.GetMessage('SOA_OTHER_LOCATION'),
						'moreInfoLocation' => '--- '.GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
						'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.GetMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
							'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
							'#ANCHOR_END#' => '</a>'
						)).'</div>'
					)
				))?>);

			<?endif?>

			var BXFormPosting = false;
			function submitForm(val)
			{
				if (BXFormPosting === true)
					return true;

				BXFormPosting = true;
				if(val != 'Y')
					BX('confirmorder').value = 'N';

				var orderForm = BX('ORDER_FORM');
				$.fancybox.helpers.overlay.open({
                    closeClick: false,
                    parent: $('body'),
                });
                $.fancybox.showLoading();

				<?if(CSaleLocation::isLocationProEnabled()):?>
					BX.saleOrderAjax.cleanUp();
				<?endif?>

				BX.ajax.submit(orderForm, ajaxResult);

				return true;
			}

			function ajaxResult(res)
			{
				var orderForm = BX('ORDER_FORM');
				try
				{
					// if json came, it obviously a successfull order submit

					var json = JSON.parse(res);
					$.fancybox.hideLoading();
                    $.fancybox.helpers.overlay.close();
                    initSelect('#ORDER_FORM select');

					if (json.error)
					{
						BXFormPosting = false;
						return;
					}
					else if (json.redirect)
					{
						window.top.location.href = json.redirect;
					}
				}
				catch (e)
				{
					// json parse failed, so it is a simple chunk of html

					BXFormPosting = false;
					BX('order_form_content').innerHTML = res;

					<?if(CSaleLocation::isLocationProEnabled()):?>
						BX.saleOrderAjax.initDeferredControl();
					<?endif?>
				}
				$.fancybox.hideLoading();
                $.fancybox.helpers.overlay.close();
                initSelect('#ORDER_FORM select');
                var propRules = $.parseJSON($('#prop-rules-object').html());
                if (propRules) {
                    if ($.data($('#ORDER_FORM')[0], "validator")) {
                        $.data($('#ORDER_FORM')[0], "validator").destroy();
                    }
                    initValidateOrder('#ORDER_FORM', propRules);
                    if ($('.location-block-wrapper input.bx-ui-sls-fake[type=text]').length) {
                        $('.location-block-wrapper input.bx-ui-sls-fake[type=text]').rules('add', {
                            required: true
                        });
                    }
                }
				BX.onCustomEvent(orderForm, 'onAjaxSuccess');
			}

			function SetContact(profileId)
			{
				BX("profile_change").value = "Y";
				submitForm();
			}
            
            function showPayment()
            {
                if ($('#ORDER_FORM').valid()) {
                    BX('new_step').value = 'payment';
                    submitForm('N');
                }
            }
            
            function showDelivery()
            {
                BX('new_step').value = 'delivery';
                submitForm('N');
            }
			</script>
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?>
                <form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data" class="form">
				<?=bitrix_sessid_post()?>
				<div id="order_form_content">
				<?
			}
			else
			{
				$APPLICATION->RestartBuffer();
			}
            $curStep = ($_REQUEST['cur_step'] == 'payment') ? 'payment' : 'delivery';
            $newStep = ($_REQUEST['new_step'] == 'payment') ? 'payment' : 'delivery';
            if ($curStep != $newStep) {
                if (!array_key_exists('ERROR', $arResult) || !is_array($arResult['ERROR']) || empty($arResult['ERROR'])) {?>
                    <script>
                        top.BX('cur_step').value = '<?=$newStep?>';
                        <?if ($newStep == 'payment'):?>
                            top.BX.adjust(top.BX('nav_delivery'), {style: {display: 'none'}});
                            top.BX.adjust(top.BX('nav_payment'), {style: {display: ''}});
                        <?else:?>
                            top.BX.adjust(top.BX('nav_payment'), {style: {display: 'none'}});
                            top.BX.adjust(top.BX('nav_delivery'), {style: {display: ''}});
                        <?endif;?>
                    </script>
                    <?$curStep = $newStep;
                } else {?>
                    <script>
                        top.BX('new_step').value = '<?=$curStep?>';
                    </script>
                <?}
            }

			if($_REQUEST['PERMANENT_MODE_STEPS'] == 1)
			{
				?>
				<input type="hidden" name="PERMANENT_MODE_STEPS" value="1" />
				<?
			}
            $prodCount = count($arResult["GRID"]["ROWS"]);
            ?>
            <div class="bx_ordercart text-center">
                <div class="cart-caption"><?=($curStep == 'delivery') ? GetMessage('SALE_CONTACTS_AND_DELIVERY') : GetMessage('SALE_PAY')?></div>
                <div class="cart-caption-desc price-block bx_ordercart_order_sum"><?=$prodCount?> <?=NLApparelshopUtils::nl_inclination($prodCount, GetMessage('NL_PRODUCT_1'), GetMessage('NL_PRODUCT_2'), GetMessage('NL_PRODUCT_10'))?> <?=GetMessage('NL_ON')?> <?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></div>
            </div>
			<?if(!empty($arResult["ERROR"]) && $_REQUEST['profile_change'] != "Y" && $_POST["is_ajax_post"] == "Y")
			{?>
                <div class="callout text-center error" data-closable><?=implode("<br />", $arResult["ERROR"])?></div>
				<script type="text/javascript">
					top.BX.scrollToNode(top.BX('ORDER_FORM'));
				</script>
				<?
			}
            $iBlock = 1;
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");
            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");?>
            <div class="cart-footer" <?if ($curStep != 'delivery'):?> style="display:none;"<?endif;?>>
                <button type="submit" class="button" onclick="showPayment(); return false;"><?=GetMessage("SOA_TEMPL_PAYMENT_BUTTON")?></button>
                <div class="clearfix"></div>
            </div>
            <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");

			
			if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
				echo $arResult["PREPAY_ADIT_FIELDS"];
			?>
            <div class="cart-footer bx_ordercart_order_pay_center"  <?if ($curStep == 'delivery'):?> style="display:none;"<?endif;?>>
                <button type="submit" class="button" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON"><?=GetMessage("SOA_TEMPL_BUTTON")?></button>
                <div class="clearfix"></div>
            </div>
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?>
					</div>
					<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
					<input type="hidden" name="profile_change" id="profile_change" value="N">
					<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
					<input type="hidden" name="json" value="Y">
					<input type="hidden" name="cur_step" id="cur_step" value="<?=$curStep?>">
					<input type="hidden" name="new_step" id="new_step" value="<?=$curStep?>">
				</form>
				<?
				if($arParams["DELIVERY_NO_AJAX"] == "N")
				{
					?>
					<div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
					<?
				}
			}
			else
			{
				?>
				<script type="text/javascript">
					top.BX('confirmorder').value = 'Y';
					top.BX('profile_change').value = 'N';
				</script>
				<?
				die();
			}
		}
	}
	?>
	</div>
</div>

<?if(CSaleLocation::isLocationProEnabled()):?>

	<div style="display: none">
		<?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.steps", 
			".default", 
			array(
			),
			false
		);?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.search", 
			".default", 
			array(
			),
			false
		);?>
	</div>

<?endif?>
<?if (!$isConfirm):?>
        </div>
    </article>
<?endif?>