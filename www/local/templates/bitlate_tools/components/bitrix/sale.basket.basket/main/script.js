/**
 * @param couponBlock
 * @param {COUPON: string, JS_STATUS: string} oneCoupon - new coupon.
 */
function couponCreate(couponBlock, oneCoupon)
{
	var couponClass = 'disabled';

	if (!BX.type.isElementNode(couponBlock))
		return;
	if (oneCoupon.JS_STATUS === 'BAD')
		couponClass = 'bad';
	else if (oneCoupon.JS_STATUS === 'APPLYED')
		couponClass = 'good';

	couponBlock.appendChild(BX.create(
		'div',
		{
			props: {
				className: 'bx_ordercart_coupon'
			},
			children: [
				BX.create(
					'input',
					{
						props: {
							className: couponClass,
							type: 'text',
							value: oneCoupon.COUPON,
							name: 'OLD_COUPON[]'
						},
						attrs: {
							disabled: true,
							readonly: true
						}
					}
				),
				BX.create(
					'span',
					{
						props: {
							className: couponClass
						},
						attrs: {
							'data-coupon': oneCoupon.COUPON
						}
					}
				),
				BX.create(
					'div',
					{
						props: {
							className: 'bx_ordercart_coupon_notes'
						},
						html: oneCoupon.JS_CHECK_CODE
					}
				)
			]
		}
	));
}

/**
 * @param {COUPON_LIST : []} res
 */
function couponListUpdate(res)
{
	var couponBlock,
		couponClass,
		fieldCoupon,
		couponsCollection,
		couponFound,
		i,
		j,
		key;

	if (!!res && typeof res !== 'object')
	{
		return;
	}

	couponBlock = BX('coupons_block');
	if (!!couponBlock)
	{
		if (!!res.COUPON_LIST && BX.type.isArray(res.COUPON_LIST))
		{
			fieldCoupon = BX('coupon');
			if (!!fieldCoupon)
			{
				fieldCoupon.value = '';
			}
			couponsCollection = BX.findChildren(couponBlock, { tagName: 'input', property: { name: 'OLD_COUPON[]' } }, true);

			if (!!couponsCollection)
			{
				if (BX.type.isElementNode(couponsCollection))
				{
					couponsCollection = [couponsCollection];
				}
				for (i = 0; i < res.COUPON_LIST.length; i++)
				{
					couponFound = false;
					key = -1;
					for (j = 0; j < couponsCollection.length; j++)
					{
						if (couponsCollection[j].value === res.COUPON_LIST[i].COUPON)
						{
							couponFound = true;
							key = j;
							couponsCollection[j].couponUpdate = true;
							break;
						}
					}
					if (couponFound)
					{
						couponClass = 'disabled';
						if (res.COUPON_LIST[i].JS_STATUS === 'BAD')
							couponClass = 'bad';
						else if (res.COUPON_LIST[i].JS_STATUS === 'APPLYED')
							couponClass = 'good';

						BX.adjust(couponsCollection[key], {props: {className: couponClass}});
						BX.adjust(couponsCollection[key].nextSibling, {props: {className: couponClass}});
						BX.adjust(couponsCollection[key].nextSibling.nextSibling, {html: res.COUPON_LIST[i].JS_CHECK_CODE});
					}
					else
					{
						couponCreate(couponBlock, res.COUPON_LIST[i]);
					}
				}
				for (j = 0; j < couponsCollection.length; j++)
				{
					if (typeof (couponsCollection[j].couponUpdate) === 'undefined' || !couponsCollection[j].couponUpdate)
					{
						BX.remove(couponsCollection[j].parentNode);
						couponsCollection[j] = null;
					}
					else
					{
						couponsCollection[j].couponUpdate = null;
					}
				}
			}
			else
			{
				for (i = 0; i < res.COUPON_LIST.length; i++)
				{
					couponCreate(couponBlock, res.COUPON_LIST[i]);
				}
			}
		}
	}
	couponBlock = null;
}

function checkOut()
{
	if (!!BX('coupon'))
		BX('coupon').disabled = true;
	BX("basket_form").submit();
	return true;
}

function enterCoupon()
{
	var newCoupon = BX('coupon');
	if (!!newCoupon && !!newCoupon.value) {
        $.fancybox.helpers.overlay.open({
            closeClick: false,
            parent: $('body'),
        });
        $.fancybox.showLoading();
        recalcBasketAjax({'delete_coupon' : $('#coupon').attr('data-coupon'), 'delete_action' : 'Y'});
    }
}

// check if quantity is valid
// and update values of both controls (text input field for PC and mobile quantity select) simultaneously
function updateQuantity(controlId, basketId, ratio, bUseFloatQuantity)
{
	var oldVal = BX(controlId).defaultValue,
		newVal = parseFloat(BX(controlId).value) || 0,
		bIsCorrectQuantityForRatio = false;

	if (ratio === 0 || ratio == 1)
	{
		bIsCorrectQuantityForRatio = true;
	}
	else
	{

		var newValInt = newVal * 10000,
			ratioInt = ratio * 10000,
			reminder = newValInt % ratioInt,
			newValRound = parseInt(newVal);

		if (reminder === 0)
		{
			bIsCorrectQuantityForRatio = true;
		}
	}

	var bIsQuantityFloat = false;

	if (parseInt(newVal) != parseFloat(newVal))
	{
		bIsQuantityFloat = true;
	}

	newVal = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(newVal) : parseFloat(newVal).toFixed(2);

	if (bIsCorrectQuantityForRatio)
	{
		BX(controlId).defaultValue = newVal;

		BX("QUANTITY_INPUT_" + basketId).value = newVal;

		// set hidden real quantity value (will be used in actual calculation)
		BX("QUANTITY_" + basketId).value = newVal;
        $.fancybox.helpers.overlay.open({
            closeClick: false,
            parent: $('body'),
        });
        $.fancybox.showLoading();
		recalcBasketAjax({});
	}
	else
	{
		newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);

		if (newVal != oldVal)
		{
			BX("QUANTITY_INPUT_" + basketId).value = newVal;
			BX("QUANTITY_" + basketId).value = newVal;
            $.fancybox.helpers.overlay.open({
                closeClick: false,
                parent: $('body'),
            });
            $.fancybox.showLoading();
			recalcBasketAjax({});
		}else
		{
			BX(controlId).value = oldVal;
		}
	}
}

// used when quantity is changed by clicking on arrows
function setQuantity(basketId, ratio, sign, bUseFloatQuantity)
{
	var curVal = parseFloat(BX("QUANTITY_INPUT_" + basketId).value),
		newVal;

	newVal = (sign == 'up') ? curVal + ratio : curVal - ratio;

	if (newVal < 0)
		newVal = 0;

	if (bUseFloatQuantity)
	{
		newVal = newVal.toFixed(2);
	}

	if (ratio > 0 && newVal < ratio)
	{
		newVal = ratio;
	}

	if (!bUseFloatQuantity && newVal != newVal.toFixed(2))
	{
		newVal = newVal.toFixed(2);
	}

	newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);

	BX("QUANTITY_INPUT_" + basketId).value = newVal;
	BX("QUANTITY_INPUT_" + basketId).defaultValue = newVal;

    if (curVal !== newVal) {
        updateQuantity('QUANTITY_INPUT_' + basketId, basketId, ratio, bUseFloatQuantity);
    }
}

function getCorrectRatioQuantity(quantity, ratio, bUseFloatQuantity)
{
	var newValInt = quantity * 10000,
		ratioInt = ratio * 10000,
		reminder = newValInt % ratioInt,
		result = quantity,
		bIsQuantityFloat = false,
		i;
	ratio = parseFloat(ratio);

	if (reminder === 0)
	{
		return result;
	}

	if (ratio !== 0 && ratio != 1)
	{
		for (i = ratio, max = parseFloat(quantity) + parseFloat(ratio); i <= max; i = parseFloat(parseFloat(i) + parseFloat(ratio)).toFixed(2))
		{
			result = i;
		}

	}else if (ratio === 1)
	{
		result = quantity | 0;
	}

	if (parseInt(result, 10) != parseFloat(result))
	{
		bIsQuantityFloat = true;
	}

	result = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(result, 10) : parseFloat(result).toFixed(2);

	return result;
}
/**
 *
 * @param {} params
 */
function recalcBasketAjax(params)
{
	var property_values = {},
		action_var = BX('action_var').value,
		items = BX('basket_items'),
		delayedItems = BX('delayed_items'),
		postData,
		i;

	postData = {
		'sessid': BX.bitrix_sessid(),
		'site_id': BX.message('SITE_ID'),
		'props': property_values,
		'action_var': action_var,
		'select_props': BX('column_headers').value,
		'offers_props': BX('offers_props').value,
		'quantity_float': BX('quantity_float').value,
		'count_discount_4_all_quantity': BX('count_discount_4_all_quantity').value,
		'price_vat_show_value': BX('price_vat_show_value').value,
		'hide_coupon': BX('hide_coupon').value,
		'use_prepayment': BX('use_prepayment').value
	};
	postData[action_var] = 'recalculate';
	if (!!params && typeof params === 'object')
	{
		for (i in params)
		{
			if (params.hasOwnProperty(i))
				postData[i] = params[i];
		}
	}
    var items = BX.findChildren(BX('basket_items'), {tagName: 'div', className: 'cart-product-item'}, true);
	if (!!items && items.length > 0)
	{
        for (i = 0; items.length > i; i++) {
			postData['QUANTITY_' + items[i].id] = BX('QUANTITY_' + items[i].id).value;
        }
	}

	BX.ajax({
		url: '/bitrix/components/bitrix/sale.basket.basket/ajax.php',
		method: 'POST',
		data: postData,
		dataType: 'json',
		onsuccess: function(result)
		{
            if (postData['delete_action'] == 'Y') {
                $('#coupon').attr('data-coupon', $('#coupon').val());
                recalcBasketAjax({'coupon' : $('#coupon').val()});
            } else {
                $('#coupon').attr('data-coupon', $('#coupon').val());
                updateData(result);
                $.fancybox.hideLoading();
                $.fancybox.helpers.overlay.close();
            }
		}
	});
}

function updateData(result) {
    var items = result.BASKET_DATA.ITEMS.AnDelCanBuy;
    BX.onCustomEvent('OnBasketChange');
    for (i = 0; i < items.length; i++)
    {
        $('#current_price_' + items[i].ID).html(items[i].PRICE_FORMATED);
        var newOldPrice = items[i].FULL_PRICE;
        var newOldPriceFormated = items[i].FULL_PRICE_FORMATED;
        var oldPrice = $('#old_price_' + items[i].ID).attr('data-old-price');
        if (oldPrice > 0 && oldPrice > newOldPrice) {
            newOldPrice = oldPrice;
            newOldPriceFormated = $('#old_price_' + items[i].ID).html();
        }
        $('#total_price_' + items[i].ID).html(items[i].SUM);
        if (newOldPrice > items[i].PRICE) {
            $('#old_price_' + items[i].ID).html(newOldPriceFormated);
        } else {
            $('#old_price_' + items[i].ID).html('');
        }
    }
    $('#basket_items .cart-product-footer-amount .footer-amount-price').html(result.BASKET_DATA.allSum_FORMATED);
    $('#basket_items .cart-caption-desc').html(i + ' ' + inclination(i, NL_PRODUCT_1, NL_PRODUCT_2, NL_PRODUCT_10) + " " + result.BASKET_DATA.allSum_FORMATED);
    if (result.VALID_COUPON === true) {
        $('.bx_ordercart_coupon').removeClass('bad').addClass('good');
    } else {
        if (result.VALID_COUPON === false) {
            $('.bx_ordercart_coupon').removeClass('good').addClass('bad');
        } else {
            $('#coupon').attr('data-coupon', '');
            $('#coupon').val('');
            var couponsList = result.BASKET_DATA.COUPON_LIST;
            for (i = 0; i < couponsList.length; i++)
            {
                if (couponsList[i].JS_STATUS === 'APPLYED') {
                    $('.bx_ordercart_coupon').removeClass('good').removeClass('bad');
                    $('#coupon').attr('data-coupon', couponsList[i].COUPON);
                    $('#coupon').val(couponsList[i].COUPON);
                }
            }
        }
    }
}

function cartAjaxAction(url, action, id) {
    $.fancybox.helpers.overlay.open({
        closeClick: false,
        parent: $('body'),
    });
    $.fancybox.showLoading();
    BX.ajax({
        url: url,
        method: 'POST',
        data: {
            sessid: BX.bitrix_sessid(),
            action: action,
            id: id
        },
        dataType: 'json',
        onsuccess: function(result) {
            if (result.success === true) {
                $.ajax({
                    url: $('#basket_form').attr('data-ajax'),
                    success: function(data){
                        $('.cart-container').html(data);
                        BX.onCustomEvent('OnBasketChange');
                        updateAdd2Liked();
                        $.fancybox.hideLoading();
                        $.fancybox.helpers.overlay.close();
                    }
                });
            } else {
                $.fancybox.hideLoading();
                $.fancybox.helpers.overlay.close();
            }
        }
    });
}