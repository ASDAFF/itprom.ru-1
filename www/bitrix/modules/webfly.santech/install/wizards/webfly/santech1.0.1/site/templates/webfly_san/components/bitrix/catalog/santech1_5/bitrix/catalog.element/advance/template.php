<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$isOffers = !empty($arResult["OFFERS"]);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
<div class="description-product" id="<?=$arItemIDs['ID']?>">
  <div class="description-block">
    <div class="heading">
      <?$useBrands = ('Y' == $arParams['BRAND_USE']);
      if ($useBrands){?>
        <span class="brand-text"><?=GetMessage("WF_BRAND")?>:</span>
        <?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", "brands2", array(
        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ELEMENT_ID" => $arResult['ID'],
        "ELEMENT_CODE" => "",
        "PROP_CODE" => $arParams['BRAND_PROP_CODE'],
        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
        "CACHE_TIME" => $arParams['CACHE_TIME'],
        "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
        "WIDTH" => $arParams["DETAIL_BRAND_WIDTH"],
        "HEIGHT" => $arParams["DETAIL_BRAND_HEIGHT"],
        "WIDTH_SMALL" => $arParams["DETAIL_BRAND_WIDTH_SMALL"],
        "HEIGHT_SMALL" => $arParams["DETAIL_BRAND_HEIGHT_SMALL"]
        ),
        $component,
        array("HIDE_ICONS" => "Y")
      );?>
      <?}?>
    </div>
    <?if(!empty($arResult["WF-OPTIONS"])):?>
    <form method="post" action="">
      <div class="code-text" style="padding-bottom: 0;"><?=GetMessage("WF_OPTIONS")?>:</div>
      <ul class="options">
        <?foreach($arResult["WF-OPTIONS"] as $key => $option):
          ?>
        <li>
          <label for="opt<?=$key?>">
            <input type="checkbox" name="dop_options[]" id="opt<?=$key?>" value="<?=$option["CODE"]?>" data-optid="<?=$option["ID"]?>"/>
          &nbsp;<span class="tooltip-wrapper"><?=$option["NAME"]?>
          <span class="tooltip-hold">
            <span class="tooltip"><?=$option["TEXT"]?></span>
          </span>
          Ч <?=$option["CODE"]?>&nbsp;<span class="rouble">&#8399;</span></span>
          </label>
        </li>
        <?endforeach?>
      </ul>
    </form>
    <?endif?>
    <?
    $boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
    if($boolDiscountShow){
      $price = str_replace(" руб.","",$arResult["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]);
    }else{
      $price = str_replace(" руб.","",$arResult["MIN_PRICE"]["PRINT_VALUE"]);
    }
    $canBuy = $arResult['CAN_BUY'];
    if(!empty($arResult["PROPERTIES"]["ARTNUMBER"]["VALUE"])):?>
      <div class="code-text"><?=$arResult["PROPERTIES"]["ARTNUMBER"]["NAME"]?>: <?=$arResult["PROPERTIES"]["ARTNUMBER"]["VALUE"]?></div>
    <?endif?>
    <?if($isOffers):?>
      <form method="post" action="">
        <div class="code-text" style="padding-bottom: 0;"><?=$arResult["OFFERS"][0]["PROPERTIES"]["SIZE_GENERAL"]["NAME"]?>:</div>
        <ul class="offers">
          <?foreach($arResult["OFFERS"] as $key => $option):
            $priceOf = str_replace(".00","",$option["CATALOG_PRICE_1"]);
            if($key == 0){
              $price = $priceOf;
              $checked = "checked";
              $torgWare = $option["ID"];
            }else{
              $checked = "";
            }
            ?>
          <li>
            <label for="opt<?=$key?>" class="styledLabel">
              <span class="radioArea"></span>
              <input type="radio" name="offers" class="styledRadio" id="opt<?=$key?>" value="<?=$priceOf?>" data-offerid="<?=$option["ID"]?>" <?=$checked?>/>
            &nbsp;<span class="tooltip-wrapper"><?=$option["PROPERTIES"]["SIZE_GENERAL"]["VALUE"]?>
            <span class="tooltip-hold">
              <span class="tooltip"><?=$option["NAME"]?></span>
            </span>
            Ч <?=$priceOf?>&nbsp;<span class="rouble">&#8399;</span></span>
            </label>
          </li>
          <?endforeach?>
        </ul>
      </form>
    <?endif?>
    <span class="price-text"><?=GetMessage("WF_PRICE")?>:</span>
    <span class="price">
    <?
    if($boolDiscountShow):?>
      <small class="oldprice" id="<?= $arItemIDs['OLD_PRICE']?>"><s><?=str_replace(" руб.","",$arResult["MIN_PRICE"]["PRINT_VALUE"])?></s></small>
      &nbsp;<span id="<?= $arItemIDs['PRICE']?>" class="price-val" data-baseprice="<?=str_replace(" ","",$price)?>"><?=$price?></span> <span class="rouble">&#8399;</span>
      <br/><small class="econ" id="<?= $arItemIDs['DISCOUNT_PRICE']?>"><?=GetMessage("WF_DISC_DIFF", array ("#DISC_PRICE#" => str_replace(" руб.","",$arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF']).'<span class="rouble">&#8399;</span>'))?></small>
    <?else:?>
      <span id="<?=$arItemIDs['PRICE']?>" class="price-val" data-baseprice="<?=str_replace(" ","",$price)?>"><?=$price?></span> <span class="rouble">&#8399;</span>
    <?endif?>
    </span>
    <span class="availability"><?=GetMessage("WF_AVAIL_STATUS")?>:
      <?if($canBuy):?>
        <span class="availability-has"><?=GetMessage("WF_AVAILABLE")?></span>
      <?else:?>
        <span class="expected"><?=$arParams["MESS_NOT_AVAILABLE"]?></span>
      <?endif?>
    </span>
    <?
    if ($canBuy){
      $buyBtnMessage = ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
      if($isOffers) $wareId = $torgWare;
      else{
        $wareId = $arResult["ID"];
      }
      ?>
      <a href="javascript:void(0);" class="btn-basket" data-wareid="<?=$wareId?>">
        <span class="add-basket" id="<?=$arItemIDs['BUY_LINK']?>"><?=$buyBtnMessage?></span>
        <span class="items-cart"><?=GetMessage("WF_ADDED_TO_CART")?></span>
      </a>
      <a href="javascript:void(0);" class="btn-credit" data-wareid="<?=$wareId?>"><?=GetMessage("WF_CREDIT_BUY")?><br/>
        <span class="small-text"><?=GetMessage("WF_CREDIT_BUY2",array("#PRICE#" => round($arResult["MIN_PRICE"]["DISCOUNT_VALUE"]/10).' <span class="rouble">&#8399;</span>'))?></span>
      </a>
    <?
    }else{
      $buyBtnMessage = ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
    }
    ?>
  </div>
  <div class="description-text">
    <h1><?=
			isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			: $arResult["NAME"]
		 ?></h1>
    <div class="gallery-vertical-hold" id="<?= $arItemIDs['BIG_SLIDER_ID']?>">
      <div class="gallery-vertical">
        <a href="javascript:void(0);" class="prev" id="<?=$arItemIDs['SLIDER_LEFT']?>">&nbsp;</a>
        <div class="gallery">
          <ul style="margin-top: -368px;" id="<?= $arItemIDs['SLIDER_CONT_ID']?>">
            <?foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto){?>
              <li data-value="<?=$arOnePhoto['ID']?>">
                <a href="<?=$arOnePhoto['SRC']?>"><img src="<?=$arOnePhoto['SRC']?>" width="90" height="90" alt=""></a>
              </li>
            <?}?>
          </ul>
        </div>
        <a href="#" class="next" id="<?=$arItemIDs['SLIDER_RIGHT']?>">&nbsp;</a>
      </div>
      <div class="visual" id="<?= $arItemIDs['BIG_IMG_CONT_ID']; ?>">
        <img id="<?= $arItemIDs['PICT']?>" class="" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>">
      </div>
    </div>
  </div>
</div>
<div class="tabset tabset-type02" style="padding-bottom: 3px;">
  <ul class="tab-list tab-list2">
    <li><a href="javascript:void(0);" class="active"><strong><?=GetMessage("WF_DESCRIPTION")?></strong></a></li>
    <li><a href="javascript:void(0);" class=""><strong><?=GetMessage("WF_SPECS")?></strong></a></li>
    <li><a href="javascript:void(0);" class=""><strong><?=GetMessage("WF_REVIEWS")?></strong></a></li>
    <li><a href="javascript:void(0);" class=""><strong><?=GetMessage("WF_ACCESSORIES")?></strong></a></li>
  </ul>
  <div class="tab-holder">
    <div class="tab active">
      <?=$arResult["DETAIL_TEXT"]?>
    </div>
    <div class="tab">
      <?$excludeProps = array("BRAND_REF", "SPECIALOFFER", "ARTNUMBER", "RECOMMEND")?>
      <h3 class="description-title"><?=GetMessage("WF_MAIN")?></h3>
      <ul class="description-list">
        <?foreach($arResult["DISPLAY_PROPERTIES"] as $key => $arDp):
          if(in_array($key,$excludeProps)) continue;
          ?>
          <li>
            <span class="text-left"><?=$arDp["NAME"]?></span>
            <span class="text-right"><?=$arDp["VALUE"]?></span>
          </li>
        <?endforeach?>
      </ul>
    </div>
    <div class="tab">
      <?
      if ('Y' == $arParams['USE_COMMENTS']){?>
      <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.comments",
        "comments",
        array(
          "ELEMENT_ID" => $arResult['ID'],
          "ELEMENT_CODE" => "",
          "IBLOCK_ID" => $arParams['IBLOCK_ID'],
          "URL_TO_COMMENT" => "",
          "WIDTH" => "800",
          "COMMENTS_COUNT" => "5",
          "BLOG_USE" => $arParams['BLOG_USE'],
          "FB_USE" => $arParams['FB_USE'],
          "FB_APP_ID" => $arParams['FB_APP_ID'],
          "VK_USE" => $arParams['VK_USE'],
          "VK_API_ID" => $arParams['VK_API_ID'],
          "CACHE_TYPE" => $arParams['CACHE_TYPE'],
          "CACHE_TIME" => $arParams['CACHE_TIME'],
          "BLOG_TITLE" => "",
          "BLOG_URL" => $arParams['BLOG_URL'],
          "PATH_TO_SMILE" => "",
          "EMAIL_NOTIFY" => "N",
          "AJAX_POST" => "Y",
          "SHOW_SPAM" => "Y",
          "SHOW_RATING" => "N",
          "FB_TITLE" => "",
          "FB_USER_ADMIN_ID" => "",
          "FB_COLORSCHEME" => "light",
          "FB_ORDER_BY" => "reverse_time",
          "VK_TITLE" => "",
          "TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
        ),
        $component,
        array("HIDE_ICONS" => "Y")
      );?>
      <?}?>
    </div>
    <div class="tab"><?/*Inserts here*/?></div>
  </div>
</div>
<script type="text/javascript">
  $(function(){
    $(".btn-basket, .btn-credit").on("click",function(){
      var wareId = $(this).data("wareid");
      if(isNaN(wareId)){
        return false;
      }
      var url = "<?=SITE_TEMPLATE_PATH?>/ajax/buy.php";
      var price = $(".price-val").text().replace(' ','');
      var options = $(".options input:checked").map(function(){return $(this).data("optid");}).get();
      var params = {id:wareId,cost:price,options:options};
      if($(this).is(".btn-credit")) $.extend(params,{credit:"<?=GetMessage("WF_CREDIT_BUY3")?>"});
      $.post(url,params,function(){
        location.href="<?=$arParams["BASKET_URL"]?>";
      });
    });
    $(".offers :radio").on("change",function(){
      var torgId = $(".offers input:checked").data("offerid");
      var price = $(".offers input:checked").val();
      var oldprice = $(".price-val").text().replace(' ','');
      $(".btn-basket, .btn-credit").data("wareid",torgId);
      if($(".options li").length > 0){
        $(".price-val").text(price);
        optionsClicked();
      }
      else{
        var separator = $.animateNumber.numberStepFactories.separator(' ');
        $('.price-val').prop("number", oldprice).animateNumber({number: price, numberStep:separator});
      }
    });
  });
  BX.message({
    MESS_BTN_BUY: '<?= ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
    MESS_BTN_ADD_TO_BASKET: '<?= ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
    MESS_NOT_AVAILABLE: '<?= ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
    TITLE_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
    TITLE_BASKET_PROPS: '<?= GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
    BASKET_UNKNOWN_ERROR: '<?= GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
    BTN_SEND_PROPS: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
    BTN_MESSAGE_CLOSE: '<?= GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>',
    SITE_ID: '<?= SITE_ID; ?>'
  });
</script>