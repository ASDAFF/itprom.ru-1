<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
  die();
//test_dump($arResult);
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
Trace("start");
$Fav = new wfHighLoadBlock(3);
  $favList = $Fav->elemGet();
  $favIds = array();
  foreach($favList as $fv){
    $favIds[$fv["ID"]] = $fv["UF_FAV_ID"];
  }
  $arResult["FAVS"] = array_flip($favIds);
if (!empty($arResult['ITEMS'])) {
  //$countAll = 0;
  $countAll = CIBlockSection::GetSectionElementsCount($arResult["ID"]);
//  test_dump($countAll);
//  if(!empty($_GET["item_count"])) $countAll = $_GET["item_count"];
//  else $countAll = $_SESSION["mywf"]["el_cnt"];
//  foreach ($arResult["ITEMS"] as $item) {
//    test_dump($item["NAME"]);
//  }

//  test_dump(count($arResult["ITEMS"]));
//
//  test_dump($arResult);

  ?>
  <script type="text/javascript">
    var page = 1;
    var numPages = Math.ceil(<?=$countAll?>/<?=$arParams["PAGE_ELEMENT_COUNT"]?>);
    $(show_more_callback);
    function show_more_callback(){
      $(".btn-show").on("click",function(){
        var url = "<?$APPLICATION->GetCurDir();?>";
        page++;

        if(page <= numPages){
          $.get(url,{PAGEN_1:page, ajaxw:"Y"},function(d){
            var newd = d.split("<!--RestartBuffer-->");
            $("#wf-product-catalog").find("ul").append(newd[1]);
            init();
          });
        }
        if(page == numPages) {
          $(".btn-show, .btn-show-all").hide();
        }
        return false;
      });
    }
  </script>
  <?
  CJSCore::Init(array("popup"));
  //wfDump($arResult["ITEMS"][0]);
  if($arParams["DISPLAY_TOP_PAGER"]) {
    echo $arResult["NAV_STRING"];
  }
  $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
  $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
  $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
  $propsList = array("BRAND_REF", "MANUFACTURER", "COLOR");
  $list = $APPLICATION->GetCurPageParam("",array('clear_cache','clear_cache_session','bitrix_include_areas'));
  $tiles = $APPLICATION->GetCurPageParam("view=tiles",array("view","clear_cache",'clear_cache_session','bitrix_include_areas'));
  if(!empty($_GET["sort_ord"])){
    if($_GET["sort_ord"] == "asc") $srt = "desc";
    else $srt = "asc";
    $sort = $APPLICATION->GetCurPageParam("sort_ord={$srt}",array("sort_ord"));
  }else{
    $sort = $APPLICATION->GetCurPageParam("sort=price&sort_ord=asc");
  }
  ?>
  <div class="sort-block">
    <span class="sort-title"><?=GetMessage("WF_PRODUCT_SORT_NAME")?></span>
    <a href="<?=$sort?>" class="link-sort link-price ls-asc" data-sort="asc"><?=GetMessage("WF_PRODUCT_SORT_PRICE")?></a>
    <!--a href="#" class="link-sort link-brand ls-asc" data-sort="asc"><?=GetMessage("WF_PRODUCT_SORT_BRAND")?></a-->
    <a href="<?=$list?>" class="link-list"><?=GetMessage("WF_PRODUCT_VIEW_LIST")?></a>
    <a href="<?=$tiles?>" class="link-table"><?=GetMessage("WF_PRODUCT_VIEW_TABLE")?></a>
  </div>
  <div class="product-catalog product-catalog02" id="wf-product-catalog">
    <ul style="position: relative;">
      <?
      if(isset($_GET["ajaxw"])){
        Trace("before restart");
        $APPLICATION->RestartBuffer();
        Trace("after restart");
        include ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
        Trace("after include");
      }?>
      <!--RestartBuffer-->
      <?
      $PAGE_NUM = $_GET["PAGEN_1"];

      $num=0;
      foreach($arResult["ITEMS"] as $key => $arItem):
        $key = $key + $PAGE_NUM*12;
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
        $strMainID = $this->GetEditAreaId($arItem['ID']);
        $isOffers = count($arItem["OFFERS"])>0;
        $arItemIDs = array(
          'ID' => $strMainID,
          'PICT' => $strMainID . '_pict',
          'SECOND_PICT' => $strMainID . '_secondpict',
          'QUANTITY' => $strMainID . '_quantity',
          'QUANTITY_DOWN' => $strMainID . '_quant_down',
          'QUANTITY_UP' => $strMainID . '_quant_up',
          'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
          'BUY_LINK' => $strMainID . '_buy_link',
          'SUBSCRIBE_LINK' => $strMainID . '_subscribe',
          'PRICE' => $strMainID . '_price',
          'DSC_PERC' => $strMainID . '_dsc_perc',
          'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',
          'PROP_DIV' => $strMainID . '_sku_tree',
          'PROP' => $strMainID . '_prop_',
          'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
          'BASKET_PROP_DIV' => $strMainID . '_basket_prop',
        );

        $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
        $strTitle = isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $arItem['NAME'];
        $discPrice = ceil($arItem['MIN_PRICE']['DISCOUNT_VALUE']);
        $minPrice = ceil($arItem['MIN_PRICE']['VALUE']);
        ?>
        <li>
          <div class="hold" id="<?=$strMainID?>">
            <div class="visual">
              <a id="<?= $arItemIDs['PICT']; ?>" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                <img class="sm-img" src="<?= $arItem['PREVIEW_PICTURE_SM']['src'];?>" width="<?= $arItem['PREVIEW_PICTURE_SM']['width'];?>" height="<?= $arItem['PREVIEW_PICTURE_SM']['height'];?>" title="<?=$strTitle;?>" alt="<?=$strTitle;?>" />
                <div class="labels">
                  <?if(!empty($arItem["PROPERTIES"]["NEWPRODUCT"]["VALUE_ENUM_ID"])):?><span class="new"><?=$arItem["PROPERTIES"]["NEWPRODUCT"]["NAME"]?></span><?endif;?>
                  <?if(!empty($arItem["PROPERTIES"]["SALELEADER"]["VALUE_ENUM_ID"])):?><span class="hit"><?=$arItem["PROPERTIES"]["SALELEADER"]["NAME"]?></span><?endif;?>
                  <?if(!empty($arItem["PROPERTIES"]["SPECIALOFFER"]["VALUE_ENUM_ID"]) or ($minPrice > $discPrice)):?><span class="sale"><?=$arItem["PROPERTIES"]["SPECIALOFFER"]["NAME"]?></span><?endif;?>
                </div>
              </a>
            </div>
            <div class="block">
              <div class="description">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="product-title"><?=$arItem["NAME"]?></a>
                <p>
                  <?
                  $iterator = 1;
                  //This foreach disabled, may be we will remove it soon
                  foreach($propsList as $value):?>
                      <? break;?>
                    <?if(!empty($arItem["PROPERTIES"][$value]["VALUE"])):
                      if($iterator%4 == 0) echo "<br/>";?>
                      <span class="text-medium"><?=$arItem["PROPERTIES"][$value]["NAME"]?>:</span>
                      <span class="text-regular"><?=$arItem["PROPERTIES"][$value]["VALUE"]?></span>
                      <?$iterator++;?>
                    <?endif;?>
                  <?endforeach;?>
                  <?
                    $p = $arItem["PROPERTIES"];
                  //test_dump($p);
                  ?>

                  <?/* if ($p["BRAND_REF"]["NAME"] != null) { */?><!--
                  <span class="text-medium">Производитель: </span>
                  <span class="text-regular"><?/*=$p["BRAND_REF"]["VALUE"]*/?></span>
                  <br />
                  --><?/* } */?>

                  <span class="text-medium">Размеры (ШxВxГ):</span>
                  <span class="text-regular"><?=$p["WIDTH"]["VALUE"]?>x<?=$p["HEIGHT"]["VALUE"]?>x<?=$p["DEPTH"]["VALUE"]?> мм</span>
                  <br />

                  <? if ($p["HEAT_POWER"]["VALUE"] != null) { ?>
                  <span class="text-medium">Мощность нагревателя:</span>
                  <span class="text-regular"><?=$p["HEAT_POWER"]["VALUE"]?> Вт</span>
                  <br />
                  <? } ?>

                  <? if ($p["IP_CLASS"]["VALUE"] != null) { ?>
                  <span class="text-medium">Класс защиты:</span>
                  <span class="text-regular"><?=$p["IP_CLASS"]["VALUE"]?></span>
                  <br />
                  <? } ?>
                </p>
              </div>
              <div class="wrap-block">
                <div class="box">
                  <div class="col-left">
                    <?

                    if($minPrice > $discPrice):?>
                    <span class="price" id="<?=$arItemIDs['PRICE']?>"><span class="my-digit"><?=$discPrice?></span>&nbsp;<span class="rouble">&#8399;</span>
                      <noindex><span class="oldPrice"><?=$minPrice?>&nbsp;</span></noindex>
                    </span>
                    <?else:?>
                      <span class="price" id="<?=$arItemIDs['PRICE']?>"><span class="my-digit"><?=$minPrice?></span>&nbsp;<span class="rouble">&#8399;</span></span>
                    <?endif;?>
                    <?if ($arItem['CAN_BUY']):?>
                      <span class="available"></span>
                      </div>
                      <a href="javascript:void(0);" id="<?= $arItemIDs['BUY_LINK']?>" price-val="<?=$minPrice?>" class="link-basket<?if($isOffers):?> no-animation<?endif?>" rel="nofollow"><?=$arParams["MESS_BTN_BUY"]?></a>
                    <?else:?>
                      <span class="expected"><?=$arParams["MESS_NOT_AVAILABLE"]?></span>
                      </div>
                      <a href="javascript:void(0);" class="link-question" rel="nofollow">?</a>
                    <?endif;?>
                </div>
              <form id="dop_options_container_<?=$num?>" class="dop_options" method="post" action="" style="margin-top:10px;">
                <!--                TODO: delete ajaxw from url with special function   -->
                <?
                $frame = $this->createFrame("dop_options_container_$num",false);
                ++$num;
                $frame->setAnimation(true);
                $frame->begin("Loading...");

                $compareUrl = str_replace("ajaxw=Y&", "", $arItem["~COMPARE_URL"]);
                $compareUrl = str_replace("ajaxw=Y", "", $compareUrl);
                ?>
                <?
                if ($_SESSION["CATALOG_COMPARE_LIST"][4]["ITEMS"][$arItem["ID"]] != null)
                  $checked = "";
                else
                  $checked = "";
                ?>

                <input type="checkbox" id="ch7<?=$key?>" class="srav checkbox" name="my_srav[]" data-count="sravCount" <?=$checked?> wf-elem-id="<?=$arItem["ID"]?>" value="<?=$compareUrl?>" />
                <label for="ch7<?=$key?>" class="myChb hitro-label"><?=GetMessage("CT_BCS_TPL_MESS_BTN_COMPARE")?></label>

                <?
                if($USER->IsAuthorized()){
                  $disabled = "";
                }else{
                  $disabled = "disabled";
                }
                if(in_array($arItem["ID"],array_flip($arResult["FAVS"]))){
                  $checked = "checked";
                  $favVal = $arResult["FAVS"][$arItem["ID"]];
                }else{
                  $checked = "";
                  $favVal = $arItem["ID"];
                }
                ?>
                <input type="checkbox" id="ch8<?=$key?>" class="fav checkbox" name="my_fav[]" data-count="favCount" value="<?=$favVal?>" elem-val="<?=$arItem["ID"]?>" <?=$checked?> <?=$disabled?>/>
                <label for="ch8<?=$key?>" class="myChb hitro-label"><?=GetMessage("WF_FAVORITES")?></label>
                <?
                  $frame->end();
                ?>
              </form>
              <?
              $arJSParams = array(
                  'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                  'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                  'SHOW_ADD_BASKET_BTN' => false,
                  'SHOW_BUY_BTN' => true,
                  'SHOW_ABSENT' => true,
                  'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
                  'SECOND_PICT' => $arItem['SECOND_PICT'],
                  'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
                  'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
                  'DEFAULT_PICTURE' => array(
                      'PICTURE' => $arItem['PRODUCT_PREVIEW'],
                      'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
                  ),
                  'VISUAL' => array(
                      'ID' => $arItemIDs['ID'],
                      'PICT_ID' => $arItemIDs['PICT'],
                      'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
                      'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                      'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                      'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                      'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
                      'PRICE_ID' => $arItemIDs['PRICE'],
                      'TREE_ID' => $arItemIDs['PROP_DIV'],
                      'TREE_ITEM_ID' => $arItemIDs['PROP'],
                      'BUY_ID' => $arItemIDs['BUY_LINK'],
                      'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
                      'DSC_PERC' => $arItemIDs['DSC_PERC'],
                      'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
                      'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
                  ),
                  'BASKET' => array(
                      'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                      'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                      'SKU_PROPS' => $arItem['OFFERS_PROP_CODES']
                  ),
                  'PRODUCT' => array(
                      'ID' => $arItem['ID'],
                      'NAME' => $arItem['~NAME'],
                      'CAN_BUY' => $arItem["CAN_BUY"],
                      'ADD_URL' => $arItem['~ADD_URL'],
                      'PICT' => $arItem['PREVIEW_PICTURE'],
                  ),
                  'OFFERS' => $arItem['JS_OFFERS'],
                  'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
                  'TREE_PROPS' => $arSkuProps,
                  'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
              );
              ?>
            </div>
          </div>
        </li>
      <?endforeach;?>
      <!--RestartBuffer-->
       <?if(isset($_GET["ajaxw"])){
        die();
      }
      ?>
    </ul>
  </div>
  <?if(!isset($_GET["SHOWALL_1"]) and ($countAll > $arParams["PAGE_ELEMENT_COUNT"])):?>
    <div class="btn-row">
      <div class="row">
        <?if ($arParams["DISPLAY_BOTTOM_PAGER"]){
          $arResult["NAV_STRING"];
        }?>
        <a href="#" class="btn-show"><?=GetMessage("WF_PRODUCT_LIST_SHOW_MORE",array("#WARES_ONPAGE#"=>$arParams["PAGE_ELEMENT_COUNT"]))?></a>
      </div>
      <div class="row">
        <a href="<?=$APPLICATION->GetCurDir();?>?SHOWALL_1=1" class="btn-show-all">
          <?=GetMessage("WF_PRODUCT_LIST_SHOW_ALL",array("#WARES_COUNT#"=>$countAll))?>
        </a>
      </div>
    </div>
  <?endif;?>
  <script type="text/javascript">
    function init2() {
      tickOffCompareCheckboxes();
      if ( $('input:checkbox').not(".superIgnore").length > 0)
        var _checkbox = $('input:checkbox').not(".superIgnore").checkbox();
      checkboxStyling('.styledRadio', '.styledLabel');
      $('.styledLabel').on('click', function(e){
        checkboxStyling('.styledRadio', '.styledLabel');
      });
      checkbox_change_events($);
      addToBacketEvent($);
      addToBacketAnimationEvent($);
    }

    $(checkbox_change_events);
    function checkbox_change_events($){
      $(".srav").not(".added").on("change", function(){
        var url = "";
        var _this = this;
        callback = function (result) {
          countAnimate(_this);
        }
        if($(this).is(":checked")){
          url = $(this).val();
          $.post(url,{},callback);
        }else{
          var id = $(this).attr("wf-elem-id");
          url = "/catalog/compare.php";
          var requestData = {action:"DELETE_FROM_COMPARE_RESULT",IBLOCK_ID:<?=$arParams["IBLOCK_ID"]?>,ID:[id]};
          $.post(url, requestData,callback);
        }
      });
      $(".fav").not(".added").on("change",function(){
        var _this = this;
        var url = "<?=SITE_TEMPLATE_PATH?>/ajax/favorites.php";
        var requestData = {};
        var elem = $(this).val();
        var elemVal = $(this).attr("elem-val");
        var that = $(this);
        if($(this).is(":checked")){
          requestData = {elemId:elem, action:"add"};
          $.post(url,requestData,function(d){
            that.val(d);
            countAnimate(_this);
          });
        }else{
          requestData = {elemId:elem, action:"delete"};
          $.post(url,requestData,function(d){
            that.val(elemVal);
            subsFav();
          });
        }
      });
      $("body").on("click",".dop_options .myChb",function(){
        var fora = $(this).attr("for");
        if($("#"+fora).is(":disabled")) alert("<?=GetMessage("WF_AUTHORIZE")?>");
      });
      $(".srav, .fav").addClass("added");
    }


    /* Adding to basket */
    function addToBacketEvent($) {
      $(".link-basket").not(".added").on("click", function () {
        var wareId = $(this).attr("id").split('_')[2];
        if (isNaN(wareId)) {
          return false;
        }
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
    }
    function addToBacketAnimationEvent($) {
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
//    $(function(){
//      $("body").on("change",".srav",function(){
//        var url = "";
//        if($(this).is(":checked")){
//          url = $(this).val();
//          $.post(url,{},function(d){});
//        }else{
//          var id = $(this).attr("wf-elem-id");
//          url = "/catalog/compare/";
//          var requestData = {action:"DELETE_FROM_COMPARE_RESULT",IBLOCK_ID:<?//=$arParams["IBLOCK_ID"]?>//,ID:[id]};
//          $.get(url, requestData,function(d){console.log(d);});
//        }
//      });
//      $("body").on("change",".fav",function(){
//          var url = "<?//=SITE_TEMPLATE_PATH?>///ajax/favorites.php";
//          var requestData = {};
//          var elem = $(this).val();
//          var elemVal = $(this).attr("elem-val");
//          var that = $(this);
//          if($(this).is(":checked")){
//            requestData = {elemId:elem, action:"add"};
//            $.post(url,requestData,function(d){
//              that.val(d);
//            });
//          }else{
//            requestData = {elemId:elem, action:"delete"};
//            $.post(url,requestData,function(d){
//              that.val(elemVal);
//              subsFav();
//            });
//          }
//      });
//      $("body").on("click",".dop_options .myChb",function(){
//        var fora = $(this).attr("for");
//        if($("#"+fora).is(":disabled")) alert("<?//=GetMessage("WF_AUTHORIZE")?>//");
//      });
//    });
  </script>
  <!-- SEO-article goes here -->
  <style>
    .text-description-content {
      overflow: hidden;
      position: relative;
      text-align: justify;
      padding:45px 35px 0px 35px;
      font: 15px/20px 'ubunturegular', Arial, Helvetica, sans-serif;
      color:#787878;
    }
    .box-hide {
      max-height: 300px;
    }
    .text-description-more {
      text-align: right;
      font: 16px/20px 'ubunturegular', Arial, Helvetica, sans-serif;
      padding:20px 35px 45px 0px;
    }

  </style>
  <script type="text/javascript">
    function seoshowmore() {
      $("#short_text").switchClass("box-hide", "box-show");
    }
  </script>
  <div id="text-description-page" class="text-description-page">
    <div id="short_text" class="text-description-content box-hide">
      <p>
        <?= $arResult["DESCRIPTION"] ?>
      </p>
    </div>
    <div class="text-description-more">
      <a onclick="seoshowmore()" rel="nofollow" href="#text-description-page" id="short_text_show_link" class="novisited arrow-link text-description-more-link">
        <span class="xhr arrow-link-inner">Читать полностью</span>&nbsp;→
      </a>
    </div>
  </div>

  <?
}
?>