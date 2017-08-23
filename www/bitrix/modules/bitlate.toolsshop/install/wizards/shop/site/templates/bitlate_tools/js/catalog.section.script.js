(function (window) {

if (!!window.JCCatalogSection)
{
	return;
}

var BasketButton = function(params)
{
	BasketButton.superclass.constructor.apply(this, arguments);
	this.nameNode = BX.create('span', {
		props : { className : 'bx_medium bx_bt_button', id : this.id },
		style: typeof(params.style) === 'object' ? params.style : {},
		text: params.text
	});
	this.buttonNode = BX.create('span', {
		attrs: { className: params.ownerClass },
		style: { marginBottom: '0', borderBottom: '0 none transparent' },
		children: [this.nameNode],
		events : this.contextEvents
	});
	if (BX.browser.IsIE())
	{
		this.buttonNode.setAttribute("hideFocus", "hidefocus");
	}
};
BX.extend(BasketButton, BX.PopupWindowButton);

window.JCCatalogSection = function (arParams)
{
	this.productType = 0;
	this.showQuantity = true;
	this.showAbsent = true;
	this.secondPict = false;
	this.showOldPrice = false;
	this.showFullPrice = false;
	this.showPercent = false;
	this.showSkuProps = false;
	this.basketAction = 'ADD';
	this.showClosePopup = false;
	this.useCompare = false;
	this.visual = {
		ID: '',
		PICT_ID: '',
		SECOND_PICT_ID: '',
		QUANTITY_ID: '',
		QUANTITY_UP_ID: '',
		QUANTITY_DOWN_ID: '',
		PRICE_ID: '',
		DSC_PERC: '',
		SECOND_DSC_PERC: '',
		DISPLAY_PROP_DIV: '',
		BASKET_PROP_DIV: ''
	};
	this.product = {
		checkQuantity: false,
		maxQuantity: 0,
		stepQuantity: 1,
		isDblQuantity: false,
		canBuy: true,
		canSubscription: true,
		name: '',
		pict: {},
		id: 0,
		addUrl: '',
		buyUrl: ''
	};

	this.basketMode = '';
	this.basketData = {
		useProps: false,
		emptyProps: false,
		quantity: 'quantity',
		props: 'prop',
		basketUrl: '',
		sku_props: '',
		sku_props_var: 'basket_props',
		add_url: '',
		buy_url: ''
	};

	this.compareData = {
		compareUrl: '',
		comparePath: ''
	};

	this.defaultPict = {
		pict: null,
		secondPict: null
	};

	this.checkQuantity = false;
	this.maxQuantity = 0;
	this.stepQuantity = 1;
	this.isDblQuantity = false;
	this.canBuy = true;
	this.currentBasisPrice = {};
	this.canSubscription = true;
	this.precision = 6;
	this.precisionFactor = Math.pow(10,this.precision);

	this.offers = [];
	this.offerNum = 0;
	this.treeProps = [];
	this.obTreeRows = [];
	this.showCount = [];
	this.showStart = [];
	this.selectedValues = {};

	this.obProduct = null;
	this.obQuantity = null;
	this.obQuantityUp = null;
	this.obQuantityDown = null;
	this.obPict = null;
	this.obSecondPict = null;
	this.obPrice = null;
	this.obPriceHover = null;
	this.obTree = null;
	this.obBuyBtn = null;
	this.obBasketActions = null;
	this.obNotAvail = null;
	this.obDscPerc = null;
	this.obSecondDscPerc = null;
	this.obSkuProps = null;
	this.obMeasure = null;
	this.obCompare = null;

	this.obPopupWin = null;
	this.basketUrl = '';
	this.basketParams = {};

	this.treeRowShowSize = 5;
	this.treeEnableArrow = { display: '', cursor: 'pointer', opacity: 1 };
	this.treeDisableArrow = { display: '', cursor: 'default', opacity:0.2 };

	this.lastElement = false;
	this.containerHeight = 0;

	this.errorCode = 0;

	if ('object' === typeof arParams)
	{
		this.productType = parseInt(arParams.PRODUCT_TYPE, 10);
		this.showQuantity = arParams.SHOW_QUANTITY;
		this.showAbsent = arParams.SHOW_ABSENT;
		this.secondPict = !!arParams.SECOND_PICT;
		this.showOldPrice = !!arParams.SHOW_OLD_PRICE;
		this.showFullPrice = !!arParams.SHOW_FULL_PRICE;
		this.showPercent = !!arParams.SHOW_DISCOUNT_PERCENT;
		this.showSkuProps = !!arParams.SHOW_SKU_PROPS;
		if (!!arParams.ADD_TO_BASKET_ACTION)
		{
			this.basketAction = arParams.ADD_TO_BASKET_ACTION;
		}
		this.showClosePopup = !!arParams.SHOW_CLOSE_POPUP;
		this.useCompare = !!arParams.DISPLAY_COMPARE;

		this.visual = arParams.VISUAL;
		switch (this.productType)
		{
			case 0://no catalog
			case 1://product
			case 2://set
				if (!!arParams.PRODUCT && 'object' === typeof(arParams.PRODUCT))
				{
					if (this.showQuantity)
					{
						this.product.checkQuantity = arParams.PRODUCT.CHECK_QUANTITY;
						this.product.isDblQuantity = arParams.PRODUCT.QUANTITY_FLOAT;
						if (this.product.checkQuantity)
						{
							this.product.maxQuantity = (this.product.isDblQuantity ? parseFloat(arParams.PRODUCT.MAX_QUANTITY) : parseInt(arParams.PRODUCT.MAX_QUANTITY, 10));
						}
						this.product.stepQuantity = (this.product.isDblQuantity ? parseFloat(arParams.PRODUCT.STEP_QUANTITY) : parseInt(arParams.PRODUCT.STEP_QUANTITY, 10));

						this.checkQuantity = this.product.checkQuantity;
						this.isDblQuantity = this.product.isDblQuantity;
						this.maxQuantity = this.product.maxQuantity;
						this.stepQuantity = this.product.stepQuantity;
						if (this.isDblQuantity)
						{
							this.stepQuantity = Math.round(this.stepQuantity*this.precisionFactor)/this.precisionFactor;
						}
					}
					this.product.canBuy = arParams.PRODUCT.CAN_BUY;
					this.product.canSubscription = arParams.PRODUCT.SUBSCRIPTION;
					if (!!arParams.PRODUCT.BASIS_PRICE)
					{
						this.currentBasisPrice = arParams.PRODUCT.BASIS_PRICE;
					}

					this.canBuy = this.product.canBuy;
					this.canSubscription = this.product.canSubscription;

					this.product.name = arParams.PRODUCT.NAME;
					this.product.pict = arParams.PRODUCT.PICT;
					this.product.id = arParams.PRODUCT.ID;
					if (!!arParams.PRODUCT.ADD_URL)
					{
						this.product.addUrl = arParams.PRODUCT.ADD_URL;
					}
					if (!!arParams.PRODUCT.BUY_URL)
					{
						this.product.buyUrl = arParams.PRODUCT.BUY_URL;
					}
					if (!!arParams.BASKET && 'object' === typeof(arParams.BASKET))
					{
						this.basketData.useProps = !!arParams.BASKET.ADD_PROPS;
						this.basketData.emptyProps = !!arParams.BASKET.EMPTY_PROPS;
					}
				}
				else
				{
					this.errorCode = -1;
				}
				break;
			case 3://sku
				if (!!arParams.OFFERS && BX.type.isArray(arParams.OFFERS))
				{
					if (!!arParams.PRODUCT && 'object' === typeof(arParams.PRODUCT))
					{
						this.product.name = arParams.PRODUCT.NAME;
						this.product.id = arParams.PRODUCT.ID;
					}
					this.offers = arParams.OFFERS;
					this.offerNum = 0;
					if (!!arParams.OFFER_SELECTED)
					{
						this.offerNum = parseInt(arParams.OFFER_SELECTED, 10);
					}
					if (isNaN(this.offerNum))
					{
						this.offerNum = 0;
					}
					if (!!arParams.TREE_PROPS)
					{
						this.treeProps = arParams.TREE_PROPS;
					}
					if (!!arParams.DEFAULT_PICTURE)
					{
						this.defaultPict.pict = arParams.DEFAULT_PICTURE.PICTURE;
						this.defaultPict.secondPict = arParams.DEFAULT_PICTURE.PICTURE_SECOND;
					}
				}
				break;
			default:
				this.errorCode = -1;
		}
		if (!!arParams.BASKET && 'object' === typeof(arParams.BASKET))
		{
			if (!!arParams.BASKET.QUANTITY)
			{
				this.basketData.quantity = arParams.BASKET.QUANTITY;
			}
			if (!!arParams.BASKET.PROPS)
			{
				this.basketData.props = arParams.BASKET.PROPS;
			}
			if (!!arParams.BASKET.BASKET_URL)
			{
				this.basketData.basketUrl = arParams.BASKET.BASKET_URL;
			}
			if (3 === this.productType)
			{
				if (!!arParams.BASKET.SKU_PROPS)
				{
					this.basketData.sku_props = arParams.BASKET.SKU_PROPS;
				}
			}
			if (!!arParams.BASKET.ADD_URL_TEMPLATE)
			{
				this.basketData.add_url = arParams.BASKET.ADD_URL_TEMPLATE;
			}
			if (!!arParams.BASKET.BUY_URL_TEMPLATE)
			{
				this.basketData.buy_url = arParams.BASKET.BUY_URL_TEMPLATE;
			}
			if (this.basketData.add_url === '' && this.basketData.buy_url === '')
			{
				this.errorCode = -1024;
			}
		}
		if (this.useCompare)
		{
			if (!!arParams.COMPARE && typeof(arParams.COMPARE) === 'object')
			{
				if (!!arParams.COMPARE.COMPARE_PATH)
				{
					this.compareData.comparePath = arParams.COMPARE.COMPARE_PATH;
				}
				if (!!arParams.COMPARE.COMPARE_URL_TEMPLATE)
				{
					this.compareData.compareUrl = arParams.COMPARE.COMPARE_URL_TEMPLATE;
				}
				else
				{
					this.useCompare = false;
				}
			}
			else
			{
				this.useCompare = false;
			}
		}

		this.lastElement = (!!arParams.LAST_ELEMENT && 'Y' === arParams.LAST_ELEMENT);
	}
	if (0 === this.errorCode)
	{
		BX.ready(BX.delegate(this.Init,this));
	}
};

window.JCCatalogSection.prototype.Init = function()
{
	var i = 0,
		strPrefix = '',
		TreeItems = null;

	this.obProduct = BX(this.visual.ID);
	if (!this.obProduct)
	{
		this.errorCode = -1;
	}
	this.obPict = BX(this.visual.PICT_ID);
	if (!this.obPict)
	{
		this.errorCode = -2;
	}
	if (this.secondPict && !!this.visual.SECOND_PICT_ID)
	{
		this.obSecondPict = BX(this.visual.SECOND_PICT_ID);
	}
	this.obPrice = BX(this.visual.PRICE_ID);
	this.obPriceHover = BX(this.visual.PRICE_HOVER_ID);
	this.obEconomyHover = BX(this.visual.ECONOMY_ID);
	this.obActionEconomy = BX(this.visual.ACTION_ECONOMY_ID);
	if (!this.obPrice)
	{
		this.errorCode = -16;
	}
	if (this.showQuantity && !!this.visual.QUANTITY_ID)
	{
        this.obQuantity = BX(this.visual.QUANTITY_ID);
		if (!!this.visual.QUANTITY_UP_ID)
		{
			this.obQuantityUp = BX(this.visual.QUANTITY_UP_ID);
		}
		if (!!this.visual.QUANTITY_DOWN_ID)
		{
			this.obQuantityDown = BX(this.visual.QUANTITY_DOWN_ID);
		}
	}
	if (3 === this.productType && this.offers.length > 0)
	{
		if (!!this.visual.TREE_ID)
		{
			this.obTree = BX(this.visual.TREE_ID);
			if (!this.obTree)
			{
				this.errorCode = -256;
			}
			strPrefix = this.visual.TREE_ITEM_ID;
			for (i = 0; i < this.treeProps.length; i++)
			{
				this.obTreeRows[i] = {
					LEFT: BX(strPrefix+this.treeProps[i].ID+'_left'),
					RIGHT: BX(strPrefix+this.treeProps[i].ID+'_right'),
					LIST: BX(strPrefix+this.treeProps[i].ID+'_list'),
					CONT: BX(strPrefix+this.treeProps[i].ID+'_cont')
				};
				if (!this.obTreeRows[i].LEFT || !this.obTreeRows[i].RIGHT || !this.obTreeRows[i].LIST || !this.obTreeRows[i].CONT)
				{
					this.errorCode = -512;
					break;
				}
			}
		}
		if (!!this.visual.QUANTITY_MEASURE)
		{
			this.obMeasure = BX(this.visual.QUANTITY_MEASURE);
		}
	}
	this.obBasketActions = BX(this.visual.BASKET_ACTIONS_ID);
	if (!!this.obBasketActions)
	{
		if (!!this.visual.BUY_ID)
		{
			this.obBuyBtn = BX(this.visual.BUY_ID);
		}
	}
	this.obNotAvail = BX(this.visual.NOT_AVAILABLE_MESS);

	if (this.showPercent)
	{
		if (!!this.visual.DSC_PERC)
		{
			this.obDscPerc = BX(this.visual.DSC_PERC);
		}
		if (this.secondPict && !!this.visual.SECOND_DSC_PERC)
		{
			this.obSecondDscPerc = BX(this.visual.SECOND_DSC_PERC);
		}
	}

	if (this.showSkuProps)
	{
		if (!!this.visual.DISPLAY_PROP_DIV)
		{
			this.obSkuProps = BX(this.visual.DISPLAY_PROP_DIV);
		}
	}
	if (0 === this.errorCode)
	{
		if (this.showQuantity)
		{
			if (!!this.obQuantityUp)
			{
                BX.bind(this.obQuantityUp, 'click', BX.delegate(this.QuantityUp, this));
			}
			if (!!this.obQuantityDown)
			{
				BX.bind(this.obQuantityDown, 'click', BX.delegate(this.QuantityDown, this));
			}
			if (!!this.obQuantity)
			{
				BX.bind(this.obQuantity, 'change', BX.delegate(this.QuantityChange, this));
			}
		}
		switch (this.productType)
		{
			case 1://product
				break;
			case 3://sku
				if (this.offers.length > 0)
				{
					TreeItems = BX.findChildren(this.obTree, {tagName: 'div'}, true);
					if (!!TreeItems && 0 < TreeItems.length)
					{
						for (i = 0; i < TreeItems.length; i++)
						{
							BX.bind(TreeItems[i], 'click', BX.delegate(this.SelectOfferProp, this));
						}
					}
					for (i = 0; i < this.obTreeRows.length; i++)
					{
						BX.bind(this.obTreeRows[i].LEFT, 'click', BX.delegate(this.RowLeft, this));
						BX.bind(this.obTreeRows[i].RIGHT, 'click', BX.delegate(this.RowRight, this));
					}
                    for (i = 0; i < this.offers.length; i++)
					{
                        if (!!this.obBasketActions) {
                            var buyButton = BX(this.visual.BUY_ID + this.offers[i].ID);
                            if (this.basketAction === 'ADD')
                                BX.bind(buyButton, 'click', BX.delegate(this.Add2Basket, this));
                            else
                                BX.bind(buyButton, 'click', BX.delegate(this.BuyBasket, this));
                        }
                        if (this.useCompare)
                        {
                            var obOfferCompare = BX(this.visual.COMPARE_LINK_ID + this.offers[i].ID);
                            if (!!obOfferCompare) {
                                BX.bind(obOfferCompare, 'click', BX.proxy(this.Compare, this));
                            }
                        }
					}
					this.SetCurrent();
				}
				break;
		}
		if (3 != this.productType)
        {
            if (!!this.obBuyBtn)
            {
                if (this.basketAction === 'ADD')
                    BX.bind(this.obBuyBtn, 'click', BX.delegate(this.Add2Basket, this));
                else
                    BX.bind(this.obBuyBtn, 'click', BX.delegate(this.BuyBasket, this));
            }
            if (this.useCompare)
            {
                this.obCompare = BX(this.visual.COMPARE_LINK_ID);
                if (!!this.obCompare)
                    BX.bind(this.obCompare, 'click', BX.proxy(this.Compare, this));
            }
        }
	}
};

window.JCCatalogSection.prototype.QuantityUp = function()
{
	var curValue = 0,
		boolSet = true,
		calcPrice;

	if (0 === this.errorCode && this.showQuantity && this.canBuy)
	{
		curValue = (this.isDblQuantity ? parseFloat(this.obQuantity.value) : parseInt(this.obQuantity.value, 10));
		if (!isNaN(curValue))
		{
            curValue += this.stepQuantity;
			if (this.checkQuantity)
			{
				if (curValue > this.maxQuantity)
				{
					boolSet = false;
				}
			}
			if (boolSet)
			{
				if (this.isDblQuantity)
				{
					curValue = Math.round(curValue*this.precisionFactor)/this.precisionFactor;
				}
				this.obQuantity.value = curValue;
                calcPrice = {
                    ECONOMY: this.currentBasisPrice.ECONOMY * curValue,
					DISCOUNT_VALUE: this.currentBasisPrice.DISCOUNT_VALUE * curValue,
					VALUE: this.currentBasisPrice.VALUE * curValue,
					DISCOUNT_DIFF: this.currentBasisPrice.DISCOUNT_DIFF * curValue,
					DISCOUNT_DIFF_PERCENT: this.currentBasisPrice.DISCOUNT_DIFF_PERCENT,
					CURRENCY: this.currentBasisPrice.CURRENCY,
                    PRICES: [],
				};
                var currentPrices = this.currentBasisPrice.PRICES;
                if (currentPrices != undefined && currentPrices.length > 1) {
                    for (i = 0; i < currentPrices.length; i++)
                    {
                        calcPrice.PRICES[i] = {
                            TITLE: currentPrices[i].TITLE,
                            CURRENCY: currentPrices[i].CURRENCY,
                            ECONOMY: currentPrices[i].ECONOMY * curValue,
                            DISCOUNT_VALUE: currentPrices[i].DISCOUNT_VALUE * curValue,
                            VALUE: currentPrices[i].VALUE * curValue
                        };
                    }
                }
				this.setPrice(calcPrice);
			}
		}
	}
};

window.JCCatalogSection.prototype.QuantityDown = function()
{
	var curValue = 0,
		boolSet = true,
		calcPrice;

	if (0 === this.errorCode && this.showQuantity && this.canBuy)
	{
		curValue = (this.isDblQuantity ? parseFloat(this.obQuantity.value): parseInt(this.obQuantity.value, 10));
		if (!isNaN(curValue))
		{
			curValue -= this.stepQuantity;
			if (curValue < this.stepQuantity)
			{
				boolSet = false;
			}
			if (boolSet)
			{
				if (this.isDblQuantity)
				{
					curValue = Math.round(curValue*this.precisionFactor)/this.precisionFactor;
				}
				this.obQuantity.value = curValue;
				calcPrice = {
                    ECONOMY: this.currentBasisPrice.ECONOMY * curValue,
					DISCOUNT_VALUE: this.currentBasisPrice.DISCOUNT_VALUE * curValue,
					VALUE: this.currentBasisPrice.VALUE * curValue,
					DISCOUNT_DIFF: this.currentBasisPrice.DISCOUNT_DIFF * curValue,
					DISCOUNT_DIFF_PERCENT: this.currentBasisPrice.DISCOUNT_DIFF_PERCENT,
					CURRENCY: this.currentBasisPrice.CURRENCY,
                    PRICES: [],
				};
                var currentPrices = this.currentBasisPrice.PRICES;
                if (currentPrices != undefined && currentPrices.length > 1) {
                    for (i = 0; i < currentPrices.length; i++)
                    {
                        calcPrice.PRICES[i] = {
                            TITLE: currentPrices[i].TITLE,
                            CURRENCY: currentPrices[i].CURRENCY,
                            ECONOMY: currentPrices[i].ECONOMY * curValue,
                            DISCOUNT_VALUE: currentPrices[i].DISCOUNT_VALUE * curValue,
                            VALUE: currentPrices[i].VALUE * curValue
                        };
                    }
                }
				this.setPrice(calcPrice);
			}
		}
	}
};

window.JCCatalogSection.prototype.QuantityChange = function()
{
	var curValue = 0,
		calcPrice,
		intCount,
		count;

	if (0 === this.errorCode && this.showQuantity)
	{
		if (this.canBuy)
		{
			curValue = (this.isDblQuantity ? parseFloat(this.obQuantity.value) : parseInt(this.obQuantity.value, 10));
			if (!isNaN(curValue))
			{
				if (this.checkQuantity)
				{
					if (curValue > this.maxQuantity)
					{
						curValue = this.maxQuantity;
					}
				}
				if (curValue < this.stepQuantity)
				{
					curValue = this.stepQuantity;
				}
				else
				{
					count = Math.round((curValue*this.precisionFactor)/this.stepQuantity)/this.precisionFactor;
					intCount = parseInt(count, 10);
					if (isNaN(intCount))
					{
						intCount = 1;
						count = 1.1;
					}
					if (count > intCount)
					{
						curValue = (intCount <= 1 ? this.stepQuantity : intCount*this.stepQuantity);
						curValue = Math.round(curValue*this.precisionFactor)/this.precisionFactor;
					}
				}
				this.obQuantity.value = curValue;
			}
			else
			{
				this.obQuantity.value = this.stepQuantity;
			}
		}
		else
		{
			this.obQuantity.value = this.stepQuantity;
		}
		calcPrice = {
			ECONOMY: this.currentBasisPrice.ECONOMY * this.obQuantity.value,
			DISCOUNT_VALUE: this.currentBasisPrice.DISCOUNT_VALUE * this.obQuantity.value,
			VALUE: this.currentBasisPrice.VALUE * this.obQuantity.value,
			DISCOUNT_DIFF: this.currentBasisPrice.DISCOUNT_DIFF * this.obQuantity.value,
			DISCOUNT_DIFF_PERCENT: this.currentBasisPrice.DISCOUNT_DIFF_PERCENT,
			CURRENCY: this.currentBasisPrice.CURRENCY,
            PRICES: [],
		};
        var currentPrices = this.currentBasisPrice.PRICES;
        if (currentPrices != undefined && currentPrices.length > 1) {
            for (i = 0; i < currentPrices.length; i++)
            {
                calcPrice.PRICES[i] = {
                    TITLE: currentPrices[i].TITLE,
                    CURRENCY: currentPrices[i].CURRENCY,
                    ECONOMY: currentPrices[i].ECONOMY * this.obQuantity.value,
                    DISCOUNT_VALUE: currentPrices[i].DISCOUNT_VALUE * this.obQuantity.value,
                    VALUE: currentPrices[i].VALUE * this.obQuantity.value
                };
            }
        }
		this.setPrice(calcPrice);
	}
};

window.JCCatalogSection.prototype.QuantitySet = function(index)
{
	if (0 === this.errorCode)
	{
		this.canBuy = this.offers[index].CAN_BUY;
		if (this.canBuy)
		{
			if (!!this.obBasketActions)
			{
				BX.style(this.obBasketActions, 'display', '');
			}
			if (!!this.obNotAvail)
			{
				BX.style(this.obNotAvail, 'display', 'none');
			}
		}
		else
		{
			if (!!this.obBasketActions)
			{
				BX.style(this.obBasketActions, 'display', 'none');
			}
			if (!!this.obNotAvail)
			{
				BX.style(this.obNotAvail, 'display', '');
			}
		}
		if (this.showQuantity)
		{
			this.isDblQuantity = this.offers[index].QUANTITY_FLOAT;
			this.checkQuantity = this.offers[index].CHECK_QUANTITY;
			if (this.isDblQuantity)
			{
				this.maxQuantity = parseFloat(this.offers[index].MAX_QUANTITY);
				this.stepQuantity = Math.round(parseFloat(this.offers[index].STEP_QUANTITY)*this.precisionFactor)/this.precisionFactor;
			}
			else
			{
				this.maxQuantity = parseInt(this.offers[index].MAX_QUANTITY, 10);
				this.stepQuantity = parseInt(this.offers[index].STEP_QUANTITY, 10);
			}

			this.obQuantity.value = this.stepQuantity;
			this.obQuantity.disabled = !this.canBuy;
            if (!this.canBuy) {
                $('#' + this.visual.TREE_ID + ' .product-count').hide();
            } else {
                $('#' + this.visual.TREE_ID + ' .product-count').show();
            }
			if (!!this.obMeasure)
			{
				if (!!this.offers[index].MEASURE)
				{
					BX.adjust(this.obMeasure, { html : this.offers[index].MEASURE});
				}
				else
				{
					BX.adjust(this.obMeasure, { html : ''});
				}
			}
		}
		this.currentBasisPrice = this.offers[index].BASIS_PRICE;
	}
};

window.JCCatalogSection.prototype.SelectOfferProp = function()
{
	var i = 0,
		value = '',
		strTreeValue = '',
		arTreeItem = [],
		RowItems = null,
		target = BX.proxy_context;

	if (!!target && target.hasAttribute('data-treevalue'))
	{
		strTreeValue = target.getAttribute('data-treevalue');
		arTreeItem = strTreeValue.split('_');
		if (this.SearchOfferPropIndex(arTreeItem[0], arTreeItem[1]))
		{
			RowItems = BX.findChildren(target.parentNode, {tagName: 'div'}, false);
			if (!!RowItems && 0 < RowItems.length)
			{
				for (i = 0; i < RowItems.length; i++)
				{
					value = RowItems[i].getAttribute('data-onevalue');
					if (value === arTreeItem[1])
					{
						BX.addClass(RowItems[i], 'bx_active');
					}
					else
					{
						BX.removeClass(RowItems[i], 'bx_active');
					}
				}
			}
		}
	}
};

window.JCCatalogSection.prototype.SearchOfferPropIndex = function(strPropID, strPropValue)
{
	var strName = '',
		arShowValues = false,
		i, j,
		arCanBuyValues = [],
		allValues = [],
		index = -1,
		arFilter = {},
		tmpFilter = [];

	for (i = 0; i < this.treeProps.length; i++)
	{
		if (this.treeProps[i].ID === strPropID)
		{
			index = i;
			break;
		}
	}

	if (-1 < index)
	{
		for (i = 0; i < index; i++)
		{
			strName = 'PROP_'+this.treeProps[i].ID;
			arFilter[strName] = this.selectedValues[strName];
		}
		strName = 'PROP_'+this.treeProps[index].ID;
		arShowValues = this.GetRowValues(arFilter, strName);
		if (!arShowValues)
		{
			return false;
		}
		if (!BX.util.in_array(strPropValue, arShowValues))
		{
			return false;
		}
		arFilter[strName] = strPropValue;
		for (i = index+1; i < this.treeProps.length; i++)
		{
			strName = 'PROP_'+this.treeProps[i].ID;
			arShowValues = this.GetRowValues(arFilter, strName);
			if (!arShowValues)
			{
				return false;
			}
			allValues = [];
			if (this.showAbsent)
			{
				arCanBuyValues = [];
				tmpFilter = [];
				tmpFilter = BX.clone(arFilter, true);
				for (j = 0; j < arShowValues.length; j++)
				{
					tmpFilter[strName] = arShowValues[j];
					allValues[allValues.length] = arShowValues[j];
					if (this.GetCanBuy(tmpFilter))
						arCanBuyValues[arCanBuyValues.length] = arShowValues[j];
				}
			}
			else
			{
				arCanBuyValues = arShowValues;
			}
			if (!!this.selectedValues[strName] && BX.util.in_array(this.selectedValues[strName], arCanBuyValues))
			{
				arFilter[strName] = this.selectedValues[strName];
			}
			else
			{
				if (this.showAbsent)
					arFilter[strName] = (arCanBuyValues.length > 0 ? arCanBuyValues[0] : allValues[0]);
				else
					arFilter[strName] = arCanBuyValues[0];
			}
			this.UpdateRow(i, arFilter[strName], arShowValues, arCanBuyValues);
		}
		this.selectedValues = arFilter;
		this.ChangeInfo();
	}
	return true;
};

window.JCCatalogSection.prototype.RowLeft = function()
{
	var i = 0,
		strTreeValue = '',
		index = -1,
		target = BX.proxy_context;

	if (!!target && target.hasAttribute('data-treevalue'))
	{
		strTreeValue = target.getAttribute('data-treevalue');
		for (i = 0; i < this.treeProps.length; i++)
		{
			if (this.treeProps[i].ID === strTreeValue)
			{
				index = i;
				break;
			}
		}
		if (-1 < index && this.treeRowShowSize < this.showCount[index])
		{
			if (0 > this.showStart[index])
			{
				this.showStart[index]++;
				BX.adjust(this.obTreeRows[index].LIST, { style: { marginLeft: this.showStart[index]*20+'%' }});
				BX.adjust(this.obTreeRows[index].RIGHT, { style: this.treeEnableArrow });
			}

			if (0 <= this.showStart[index])
			{
				BX.adjust(this.obTreeRows[index].LEFT, { style: this.treeDisableArrow });
			}
		}
	}
};

window.JCCatalogSection.prototype.RowRight = function()
{
	var i = 0,
		strTreeValue = '',
		index = -1,
		target = BX.proxy_context;

	if (!!target && target.hasAttribute('data-treevalue'))
	{
		strTreeValue = target.getAttribute('data-treevalue');
		for (i = 0; i < this.treeProps.length; i++)
		{
			if (this.treeProps[i].ID === strTreeValue)
			{
				index = i;
				break;
			}
		}
		if (-1 < index && this.treeRowShowSize < this.showCount[index])
		{
			if ((this.treeRowShowSize - this.showStart[index]) < this.showCount[index])
			{
				this.showStart[index]--;
				BX.adjust(this.obTreeRows[index].LIST, { style: { marginLeft: this.showStart[index]*20+'%' }});
				BX.adjust(this.obTreeRows[index].LEFT, { style: this.treeEnableArrow });
			}

			if ((this.treeRowShowSize - this.showStart[index]) >= this.showCount[index])
			{
				BX.adjust(this.obTreeRows[index].RIGHT, { style: this.treeDisableArrow });
			}
		}
	}
};

window.JCCatalogSection.prototype.UpdateRow = function(intNumber, activeID, showID, canBuyID)
{
	var i = 0,
		showI = 0,
		value = '',
		dataTreeVal = '',
		countShow = 0,
		strNewLen = '',
		obData = {},
		pictMode = false,
		extShowMode = false,
		isCurrent = false,
		selectIndex = 0,
		obLeft = this.treeEnableArrow,
		obRight = this.treeEnableArrow,
		currentShowStart = 0,
		RowItems = null;

    if (-1 < intNumber && intNumber < this.obTreeRows.length)
	{
		RowItems = BX.findChildren(this.obTreeRows[intNumber].LIST, {tagName: 'div'}, false);
        if (!!RowItems && 0 < RowItems.length)
		{
			pictMode = ('PICT' === this.treeProps[intNumber].SHOW_MODE);
			countShow = showID.length;
			extShowMode = this.treeRowShowSize < countShow;
			strNewLen = 'auto';
			obData = {
				props: { className: '' },
				style: {
					width: strNewLen
				}
			};
			if (pictMode)
			{
				obData.style.paddingTop = strNewLen;
			}
            obData.style.lineHeight = '0';
			for (i = 0; i < RowItems.length; i++)
			{
				value = RowItems[i].getAttribute('data-onevalue');
				dataTreeVal = RowItems[i].getAttribute('data-treevalue');
                isCurrent = (value === activeID);
				if (BX.util.in_array(value, canBuyID))
				{
					obData.props.className = (isCurrent ? 'inline-block-item bx_active' : 'inline-block-item');
                    if (isCurrent) {
                        $('#' + this.visual.ID + '_prop_' + dataTreeVal).attr('checked', 'checked');
                    } else {
                        $('#' + this.visual.ID + '_prop_' + dataTreeVal).removeAttr('checked');
                    }
				}
				else
				{
					obData.props.className = (isCurrent ? 'inline-block-item bx_active bx_missing' : 'inline-block-item bx_missing');
                    if (isCurrent) {
                        $('#' + this.visual.ID + '_prop_' + dataTreeVal).attr('checked', 'checked');
                    } else {
                        $('#' + this.visual.ID + '_prop_' + dataTreeVal).removeAttr('checked');
                    }
				}
				obData.style.display = 'none';
				if (BX.util.in_array(value, showID))
				{
					obData.style.display = '';
					if (isCurrent)
					{
						selectIndex = showI;
					}
					showI++;
				}
				BX.adjust(RowItems[i], obData);
			}

			obData = {
				style: {
					width: 'auto',
				}
			};
			/*if (pictMode)
			{
				BX.adjust(this.obTreeRows[intNumber].CONT, {props: {className: (extShowMode ? 'bx_item_detail_scu full' : 'bx_item_detail_scu')}});
			}
			else
			{
				BX.adjust(this.obTreeRows[intNumber].CONT, {props: {className: (extShowMode ? 'bx_item_detail_size full' : 'bx_item_detail_size')}});
			}*/
			if (extShowMode)
			{
				if (selectIndex +1 === countShow)
				{
					obRight = this.treeDisableArrow;
				}
				if (this.treeRowShowSize <= selectIndex)
				{
					currentShowStart = this.treeRowShowSize - selectIndex - 1;
				}
				if (0 === currentShowStart)
				{
					obLeft = this.treeDisableArrow;
				}
				BX.adjust(this.obTreeRows[intNumber].LEFT, {style: obLeft });
				BX.adjust(this.obTreeRows[intNumber].RIGHT, {style: obRight });
			}
			else
			{
				BX.adjust(this.obTreeRows[intNumber].LEFT, {style: {display: 'none'}});
				BX.adjust(this.obTreeRows[intNumber].RIGHT, {style: {display: 'none'}});
			}
			BX.adjust(this.obTreeRows[intNumber].LIST, obData);
			this.showCount[intNumber] = countShow;
			this.showStart[intNumber] = currentShowStart;
		}
	}
};

window.JCCatalogSection.prototype.GetRowValues = function(arFilter, index)
{
	var i = 0,
		j,
		arValues = [],
		boolSearch = false,
		boolOneSearch = true;

	if (0 === arFilter.length)
	{
		for (i = 0; i < this.offers.length; i++)
		{
			if (!BX.util.in_array(this.offers[i].TREE[index], arValues))
			{
				arValues[arValues.length] = this.offers[i].TREE[index];
			}
		}
		boolSearch = true;
	}
	else
	{
		for (i = 0; i < this.offers.length; i++)
		{
			boolOneSearch = true;
			for (j in arFilter)
			{
				if (arFilter[j] !== this.offers[i].TREE[j])
				{
					boolOneSearch = false;
					break;
				}
			}
			if (boolOneSearch)
			{
				if (!BX.util.in_array(this.offers[i].TREE[index], arValues))
				{
					arValues[arValues.length] = this.offers[i].TREE[index];
				}
				boolSearch = true;
			}
		}
	}
	return (boolSearch ? arValues : false);
};

window.JCCatalogSection.prototype.GetCanBuy = function(arFilter)
{
	var i = 0,
		j,
		boolSearch = false,
		boolOneSearch = true;

	for (i = 0; i < this.offers.length; i++)
	{
		boolOneSearch = true;
		for (j in arFilter)
		{
			if (arFilter[j] !== this.offers[i].TREE[j])
			{
				boolOneSearch = false;
				break;
			}
		}
		if (boolOneSearch)
		{
			if (this.offers[i].CAN_BUY)
			{
				boolSearch = true;
				break;
			}
		}
	}
	return boolSearch;
};

window.JCCatalogSection.prototype.SetCurrent = function()
{
	var i = 0,
		j = 0,
		arCanBuyValues = [],
		strName = '',
		arShowValues = false,
		arFilter = {},
		tmpFilter = [],
		current = this.offers[this.offerNum].TREE;

	for (i = 0; i < this.treeProps.length; i++)
	{
		strName = 'PROP_'+this.treeProps[i].ID;
		arShowValues = this.GetRowValues(arFilter, strName);
		if (!arShowValues)
		{
			break;
		}
		if (BX.util.in_array(current[strName], arShowValues))
		{
			arFilter[strName] = current[strName];
		}
		else
		{
			arFilter[strName] = arShowValues[0];
			this.offerNum = 0;
		}
		if (this.showAbsent)
		{
			arCanBuyValues = [];
			tmpFilter = [];
			tmpFilter = BX.clone(arFilter, true);
			for (j = 0; j < arShowValues.length; j++)
			{
				tmpFilter[strName] = arShowValues[j];
				if (this.GetCanBuy(tmpFilter))
				{
					arCanBuyValues[arCanBuyValues.length] = arShowValues[j];
				}
			}
		}
		else
		{
			arCanBuyValues = arShowValues;
		}
		this.UpdateRow(i, arFilter[strName], arShowValues, arCanBuyValues);
	}
	this.selectedValues = arFilter;
	this.ChangeInfo();
};

window.JCCatalogSection.prototype.ChangeInfo = function()
{
	var i = 0,
		j,
		index = -1,
		boolOneSearch = true;

	for (i = 0; i < this.offers.length; i++)
	{
		boolOneSearch = true;
		for (j in this.selectedValues)
		{
			if (this.selectedValues[j] !== this.offers[i].TREE[j])
			{
				boolOneSearch = false;
				break;
			}
		}
		if (boolOneSearch)
		{
			index = i;
			break;
		}
	}
	if (-1 < index)
	{
		if (!!this.obPict)
		{
			if (!!this.offers[index].PREVIEW_PICTURE)
			{
				BX.adjust(this.obPict, {props: {src: this.offers[index].PREVIEW_PICTURE.SRC}});
			}
			else
			{
				BX.adjust(this.obPict, {props: {src: this.defaultPict.pict.SRC}});
			}
		}
		if (this.secondPict && !!this.obSecondPict)
		{
			if (!!this.offers[index].PREVIEW_PICTURE_SECOND)
			{
				BX.adjust(this.obSecondPict, {props: {src: this.offers[index].PREVIEW_PICTURE_SECOND.SRC}});
			}
			else if (!!this.offers[index].PREVIEW_PICTURE.SRC)
			{
				BX.adjust(this.obSecondPict, {props: {src: this.offers[index].PREVIEW_PICTURE.SRC}});
			}
			else if (!!this.defaultPict.secondPict)
			{
				BX.adjust(this.obSecondPict, {props: {src: this.defaultPict.secondPict.SRC}});
			}
			else
			{
				BX.adjust(this.obSecondPict, {props: {src: this.defaultPict.pict.SRC}});
			}
		}
		/*if (this.showSkuProps && !!this.obSkuProps)
		{
			if (0 === this.offers[index].DISPLAY_PROPERTIES.length)
			{
				BX.adjust(this.obSkuProps, {style: {display: 'none'}, html: ''});
			}
			else
			{
				BX.adjust(this.obSkuProps, {style: {display: ''}, html: this.offers[index].DISPLAY_PROPERTIES});
			}
		}*/
        /*if (this.offers[index].SHOW_BASKET_BUTTON == "N") {
            this.obBuyBtn.href = (!!this.basketData.basketUrl ? this.basketData.basketUrl : BX.message('BASKET_URL'));
            this.obBuyBtn.text = BX.message('ADD_TO_BASKET');
        } else {
            this.obBuyBtn.href = "javascript:;";
            this.obBuyBtn.text = BX.message('ADD_TO_BASKET_BUTTON');
        }*/
        
        for (i = 0; i < this.offers.length; i++)
        {
            if (!!this.obBasketActions) {
                var buyButton = BX(this.visual.BUY_ID + this.offers[i].ID);
                if (i == index) {
                    BX.adjust(buyButton, {style: {display: ''}});
                } else {
                    BX.adjust(buyButton, {style: {display: 'none'}});
                }
            }
            
            var likedCompare = BX(this.visual.LIKED_COMPARE_ID + this.offers[i].ID);
                if (!!likedCompare) {
                if (i == index) {
                    BX.adjust(likedCompare, {style: {display: ''}});
                } else {
                    BX.adjust(likedCompare, {style: {display: 'none'}});
                }
            }
            var obPropTable = BX(this.visual.PROP_TABLE + this.offers[i].ID);
            if (!!obPropTable) {
                if (i == index) {
                    BX.adjust(obPropTable, {style: {display: ''}});
                } else {
                    BX.adjust(obPropTable, {style: {display: 'none'}});
                }
            }
            var obQuantityMax = BX(this.visual.QUANTITY_MAX + this.offers[i].ID);
            if (!!obQuantityMax) {
                if (i == index) {
                    BX.adjust(obQuantityMax, {style: {display: ''}});
                } else {
                    BX.adjust(obQuantityMax, {style: {display: 'none'}});
                }
            }
        }
        this.setPrice(this.offers[index].PRICE);
		this.offerNum = index;
		this.QuantitySet(this.offerNum);
	}
};

window.JCCatalogSection.prototype.setPrice = function(price)
{
	var strPrice,
		obData;

	if (!!this.obPrice)
	{
        if (price.PRICES != undefined && price.PRICES.length > 1) {
            strPrice = BX.Currency.currencyFormat(price.DISCOUNT_VALUE, price.CURRENCY, true);
            if (this.showOldPrice && (price.DISCOUNT_VALUE !== price.VALUE))
            {
                strPrice += ' <span class="old">'+BX.Currency.currencyFormat(price.VALUE, price.CURRENCY, true)+'</span>';
            }
            BX.adjust(this.obPrice, {html: strPrice});
            if (!!this.obActionEconomy) {
                if (this.showOldPrice && (price.DISCOUNT_VALUE !== price.VALUE))
                {
                    strEconomy = BX.Currency.currencyFormat(price.ECONOMY, price.CURRENCY, true);
                    BX.adjust(this.obActionEconomy, {html: strEconomy});
                } else {
                    BX.adjust(this.obActionEconomy, {html: ' '});
                }
            }
            if (this.showFullPrice) {
                this.obPriceHover = this.obPrice;
            }
            if (!!this.obPriceHover) {
                strPriceHover = '';
                for (i = 0; i < price.PRICES.length; i++)
                {
                    if (this.showFullPrice) {
                        strPriceHover += '<div class="price-block">';
                    } else {
                        strPriceHover += '<div class="price-block">';
                    }
                    strPriceHover += '<div class="product-info-caption">' + price.PRICES[i].TITLE + '</div>';
                    strPriceHover += '<div class="price">' + BX.Currency.currencyFormat(price.PRICES[i].DISCOUNT_VALUE, price.PRICES[i].CURRENCY, true);
                    if (this.showOldPrice && (price.PRICES[i].DISCOUNT_VALUE !== price.PRICES[i].VALUE))
                    {
                        strPriceHover += '<span class="old">' + BX.Currency.currencyFormat(price.PRICES[i].VALUE, price.PRICES[i].CURRENCY, true) + '</span></div>';
                        strPriceHover += '<div class="economy">' + this.visual.ECONOMY_HTML.replace('#ECONOMY_PRICE#', BX.Currency.currencyFormat(price.PRICES[i].ECONOMY, price.PRICES[i].CURRENCY, true));
                    }
                    strPriceHover += '</div></div>';
                }
                BX.adjust(this.obPriceHover, {html: strPriceHover});
            }
        } else {
            strPrice = BX.Currency.currencyFormat(price.DISCOUNT_VALUE, price.CURRENCY, true);
            if (this.showOldPrice && (price.DISCOUNT_VALUE !== price.VALUE))
            {
                strPrice += ' <span class="old">'+BX.Currency.currencyFormat(price.VALUE, price.CURRENCY, true)+'</span>';
            }
            BX.adjust(this.obPrice, {html: strPrice});
            if (this.showFullPrice) {
                this.obPriceHover = this.obPrice;
            }
            if (!!this.obPriceHover) {
                strPriceHover = '<div class="price">' + strPrice + '</div>';
                if (this.showOldPrice && (price.DISCOUNT_VALUE !== price.VALUE))
                {
                    strPriceHover += '<div class="economy">' + this.visual.ECONOMY_HTML.replace('#ECONOMY_PRICE#', BX.Currency.currencyFormat(price.ECONOMY, price.CURRENCY, true)) + '</div>';
                }
                BX.adjust(this.obPriceHover, {html: strPriceHover});
            } else {
                strEconomyHover = '';
                if (!!this.obEconomyHover) {
                    if (this.showOldPrice && (price.DISCOUNT_VALUE !== price.VALUE))
                    {
                        strEconomyHover = this.visual.ECONOMY_HTML.replace('#ECONOMY_PRICE#', BX.Currency.currencyFormat(price.ECONOMY, price.CURRENCY, true));
                        BX.adjust(this.obEconomyHover, {html: strEconomyHover});
                        BX.style(this.obEconomyHover, 'display', '');
                    } else {
                        BX.adjust(this.obEconomyHover, {html: ' '});
                        BX.style(this.obEconomyHover, 'display', 'none');
                    }
                }
            }
            if (!!this.obActionEconomy) {
                if (this.showOldPrice && (price.DISCOUNT_VALUE !== price.VALUE))
                {
                    strEconomy = BX.Currency.currencyFormat(price.ECONOMY, price.CURRENCY, true);
                    BX.adjust(this.obActionEconomy, {html: strEconomy});
                } else {
                    BX.adjust(this.obActionEconomy, {html: ' '});
                }
            }
        }
	}
};

window.JCCatalogSection.prototype.Compare = function()
{
	var compareParams, compareLink;
	if (!!this.compareData.compareUrl)
	{
		switch (this.productType)
		{
			case 0://no catalog
			case 1://product
			case 2://set
				compareLink = this.compareData.compareUrl.replace('#ID#', this.product.id.toString());
				break;
			case 3://sku
				compareLink = this.compareData.compareUrl.replace('#ID#', this.offers[this.offerNum].ID);
				break;
		}
		compareParams = {
			ajax_action: 'Y'
		};
		BX.ajax.loadJSON(
			compareLink,
			compareParams,
			BX.proxy(this.CompareResult, this)
		);
	}
};

window.JCCatalogSection.prototype.CompareResult = function(result)
{
	var popupContent, popupButtons, popupTitle;
	if (!!this.obPopupWin)
	{
		this.obPopupWin.close();
	}
	if (typeof result !== 'object')
	{
		return false;
	}
	if (result.STATUS === 'OK')
	{
		BX.onCustomEvent('OnCompareChange');
        var compareUrl = (!!this.compareData.comparePath) ? this.compareData.comparePath : '';
        switch (this.productType)
        {
            case 1://
            case 2://
                var productId = this.product.id;
                break;
            case 3:
                var productId = this.offers[this.offerNum].ID;
                break;
        }
        add2compare(productId, result.COUNT, BX.message('BTN_COMPARE_REDIRECT'), compareUrl);
	}
	return false;
};

window.JCCatalogSection.prototype.CompareRedirect = function()
{
	if (!!this.compareData.comparePath)
	{
		location.href = this.compareData.comparePath;
	}
	else
	{
		this.obPopupWin.close();
	}
};

window.JCCatalogSection.prototype.InitBasketUrl = function()
{
	this.basketUrl = (this.basketMode === 'ADD' ? this.basketData.add_url : this.basketData.buy_url);
	switch (this.productType)
	{
		case 1://product
		case 2://set
			this.basketUrl = this.basketUrl.replace('#ID#', this.product.id.toString());
			break;
		case 3://sku
			this.basketUrl = this.basketUrl.replace('#ID#', this.offers[this.offerNum].ID);
			break;
	}
	this.basketParams = {
		'ajax_basket': 'Y'
	};
	if (this.showQuantity)
	{
		this.basketParams[this.basketData.quantity] = this.obQuantity.value;
	}
	if (!!this.basketData.sku_props)
	{
		this.basketParams[this.basketData.sku_props_var] = this.basketData.sku_props;
	}
};

window.JCCatalogSection.prototype.FillBasketProps = function()
{
	if (!this.visual.BASKET_PROP_DIV)
	{
		return;
	}
	var
		i = 0,
		propCollection = null,
		foundValues = false,
		obBasketProps = null;

	if (this.basketData.useProps && !this.basketData.emptyProps)
	{
		if (!!this.obPopupWin && !!this.obPopupWin.contentContainer)
		{
			obBasketProps = this.obPopupWin.contentContainer;
		}
	}
	else
	{
		obBasketProps = BX(this.visual.BASKET_PROP_DIV);
	}
	if (!!obBasketProps)
	{
		propCollection = obBasketProps.getElementsByTagName('select');
		if (!!propCollection && !!propCollection.length)
		{
			for (i = 0; i < propCollection.length; i++)
			{
				if (!propCollection[i].disabled)
				{
					switch(propCollection[i].type.toLowerCase())
					{
						case 'select-one':
							this.basketParams[propCollection[i].name] = propCollection[i].value;
							foundValues = true;
							break;
						default:
							break;
					}
				}
			}
		}
		propCollection = obBasketProps.getElementsByTagName('input');
		if (!!propCollection && !!propCollection.length)
		{
			for (i = 0; i < propCollection.length; i++)
			{
				if (!propCollection[i].disabled)
				{
					switch(propCollection[i].type.toLowerCase())
					{
						case 'hidden':
							this.basketParams[propCollection[i].name] = propCollection[i].value;
							foundValues = true;
							break;
						case 'radio':
							if (propCollection[i].checked)
							{
								this.basketParams[propCollection[i].name] = propCollection[i].value;
								foundValues = true;
							}
							break;
						default:
							break;
					}
				}
			}
		}
	}
	if (!foundValues)
	{
		this.basketParams[this.basketData.props] = [];
		this.basketParams[this.basketData.props][0] = 0;
	}
};

window.JCCatalogSection.prototype.Add2Basket = function()
{
	this.basketMode = 'ADD';
	this.Basket();
};

window.JCCatalogSection.prototype.BuyBasket = function()
{
	this.basketMode = 'BUY';
	this.Basket();
};

window.JCCatalogSection.prototype.SendToBasket = function()
{
	if (!this.canBuy)
	{
		return;
	}
	this.InitBasketUrl();
	this.FillBasketProps();
    
    $.fancybox.helpers.overlay.open({
        closeClick: false,
        parent: $('body'),
    });
    $.fancybox.showLoading();
	BX.ajax.loadJSON(
		this.basketUrl,
		this.basketParams,
		BX.delegate(this.BasketResult, this)
	);
};

window.JCCatalogSection.prototype.Basket = function()
{
    var contentBasketProps = '';
	if (!this.canBuy)
	{
		return;
	}
	switch (this.productType)
	{
	case 1://product
	case 2://set
        var $self = $("#" + this.visual.BUY_ID);
        if (!$self.hasClass('in_basket')) {
            this.SendToBasket();
        }
		break;
	case 3://sku
        var $self = $("#" + this.visual.BUY_ID + this.offers[this.offerNum].ID);
        if (!$self.hasClass('in_basket')) {
            this.SendToBasket();
        }
		break;
	}
};

window.JCCatalogSection.prototype.BasketResult = function(arResult)
{
	var strContent = '',
		strPict = '',
		successful,
		buttons = [];

	if (!!this.obPopupWin)
	{
		this.obPopupWin.close();
	}
	if ('object' !== typeof arResult)
	{
		return false;
	}
    successful = (arResult.STATUS === 'OK');
	if (successful && this.basketAction === 'BUY')
	{
		this.BasketRedirect();
	}
	else
	{
		var $self = null;
        if (successful)
		{
            BX.onCustomEvent('OnBasketChange');
			switch(this.productType)
			{
			case 1://
			case 2://
				strPict = this.product.pict.SRC;
                $self = $("#" + this.visual.BUY_ID);
                this.obBuyBtn.href = (!!this.basketData.basketUrl ? this.basketData.basketUrl : BX.message('BASKET_URL'));
                $("#" + this.visual.BUY_ID + " span").html(BX.message('ADD_TO_BASKET'));
				break;
			case 3:
				strPict = (!!this.offers[this.offerNum].PREVIEW_PICTURE ?
					this.offers[this.offerNum].PREVIEW_PICTURE.SRC :
					this.defaultPict.pict.SRC
				);
                $self = $("#" + this.visual.BUY_ID + this.offers[this.offerNum].ID);
                var buyButton = BX(this.visual.BUY_ID + this.offers[this.offerNum].ID);
                buyButton.href = (!!this.basketData.basketUrl ? this.basketData.basketUrl : BX.message('BASKET_URL'));
                $("#" + this.visual.BUY_ID + this.offers[this.offerNum].ID + " span").html(BX.message('ADD_TO_BASKET'));
				break;
			}
		}
        preview2Basket($self);
	}
    $.fancybox.hideLoading();
    $.fancybox.helpers.overlay.close();
};

window.JCCatalogSection.prototype.BasketRedirect = function()
{
	location.href = (!!this.basketData.basketUrl ? this.basketData.basketUrl : BX.message('BASKET_URL'));
};
})(window);