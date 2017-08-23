<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<h3><?=GetMessage("VIEW_HEADER");?></h3>
<div class="scroll-pane scroll-pane-type02">
  <div class="product-catalog product-catalog05">
    <ul>
      <?foreach($arResult as $arItem):
        if(empty($arItem["NAME"])) continue;
        $isOffers = count($arItem["OFFERS"])>0;
        ?>
        <li>
          <div class="hold">
            <div class="visual">
              <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                <img src="<?=$arItem["PICTURE"]["src"]?>" width="<?=$arItem["PICTURE"]["width"]?>" height="<?=$arItem["PICTURE"]["height"]?>" alt="<?=$arItem["NAME"]?>">
                <div class="labels">
                  <?if($arResult["ELEMS"][$arItem["PRODUCT_ID"]]["NEWPRODUCT"] == GetMessage("WF_DA")):?>
                    <span class="new"><?=GetMessage("WF_PRODUCT_NEW")?></span>
                  <?endif;?>
                  <?if($arResult["ELEMS"][$arItem["PRODUCT_ID"]]["SALELEADER"] == GetMessage("WF_DA")):?>
                    <span class="hit"><?=GetMessage("WF_PRODUCT_HIT")?></span>
                  <?endif;?>
                  <?if($arResult["ELEMS"][$arItem["PRODUCT_ID"]]["SPECIALOFFER"] == GetMessage("WF_DA")):?>
                    <span class="sale"><?=GetMessage("WF_PRODUCT_DISC")?></span>
                  <?endif;?>
                </div>
              </a>
            </div>
            <div class="block">
              <div class="description">
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
              </div>
              <div class="box">
                <div class="col-left">
                  <span class="price"><?=str_replace(" руб.","",$arItem["PRICE_FORMATED"])?> <span class="rouble">&#8399;</span></span>
                  <?if($arItem["CAN_BUY"]):?>
                    <span class="available"><?=GetMessage("WF_PRODUCT_IS")?></span>
                  <?else:?>
                    <span class="expected"><?=GetMessage("WF_PRODUCT_NOT")?></span>
                  <?endif;?>
                </div>
                <?if($arItem["CAN_BUY"]):?>
                  <a href="<?=$arItem["ADD_URL"]?>" class="link-basket2" rel="nofollow" id="ob_<?=$arItem["ID"]?>"><?=GetMessage("PRODUCT_BUY")?></a>
                <?else:?>
                  <a href="#" class="link-question">?</a>
                <?endif;?>
              </div>
            </div>
          </div>
        </li>
        <script src="text/javscript">
          <?if($isOffers):?>
            $("#ob_<?=$arItem["ID"]?>").on("click",function(){
              location.href = "<?=$arItem["DETAIL_PAGE_URL"]?>";
            });
          <?endif?>
        </script>
      <?endforeach?>
    </ul>
  </div>
</div>
<?endif?>