<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="column profile-column-item newsletter" data-order="5">
    <div class="profile-block">
        <div class="profile-block-caption">
            <svg class="icon">
                <use xlink:href="#svg-icon-subscribe"></use>
            </svg>
            <?=GetMessage("CT_BSE_SUBSCRIPTION_FORM_TITLE")?>
        </div>
        <div class="profile-block-wrap">
            <form action="<?=$arResult["FORM_ACTION"]?>" method="post" id="form_subscr_personal" data-ajax="<?=SITE_DIR?>nl_ajax/subscribe.php">
                <input type="text" placeholder="<?=GetMessage("CT_BSE_EMAIL_LABEL")?>" name="EMAIL" value="<?echo $arResult["SUBSCRIPTION"]["EMAIL"]!=""? $arResult["SUBSCRIPTION"]["EMAIL"]: $arResult["REQUEST"]["EMAIL"];?>" class="hollow">
                <?if (count($arResult["RUBRICS"]) == 0):?>
                    <input type="hidden" name="RUB_ID[]" value="0" />
                <?else:?>
                    <fieldset class="checkbox">
                        <?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
                            <input type="checkbox" name="RUB_ID[]" value="<?=$itemValue["ID"]?>" id="subscribe<?=$itemID?>" class="show-for-sr"<?if($itemValue["CHECKED"]) echo " checked"?>>
                            <label for="subscribe<?=$itemID?>"><?echo $itemValue["NAME"]?></label>
                        <?endforeach;?>
                    </fieldset>
                <?endif;?>
                <?echo bitrix_sessid_post();?>
                <input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
                <?if($arResult["ID"] > 0 && $arResult["SUBSCRIPTION"]["ACTIVE"] != "Y"):?>
                    <input type="hidden" name="action" value="activate" />
                    <input id="subscribe-submit-btn" style="display:none" type="submit" name="activate" value="<?echo GetMessage("CT_BSE_BTN_ADD_SUBSCRIPTION")?>">
                <?else:?>
                    <input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
                    <input id="subscribe-submit-btn" style="display:none" type="submit" name="Save" value="<?echo GetMessage("CT_BSE_BTN_SEND")?>" />
                <?endif;?>
                <?foreach($arResult["MESSAGE"] as $itemID=>$itemValue)
                    echo '<p>'.ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"OK")).'</p>';
                foreach($arResult["ERROR"] as $itemID=>$itemValue)
                    echo '<p>'.ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"ERROR")).'</p>';?>
                <a href="javascript:void(0)" onclick="$('#subscribe-submit-btn').click(); return false;" class="button small secondary"><?=GetMessage(($arResult["ID"] > 0 && $arResult["SUBSCRIPTION"]["ACTIVE"] == "Y") ? "CT_BSE_BTN_EDIT_SUBSCRIPTION" : "CT_BSE_BTN_ADD_SUBSCRIPTION")?></a>
            </form>
        </div>
    </div>
</div>