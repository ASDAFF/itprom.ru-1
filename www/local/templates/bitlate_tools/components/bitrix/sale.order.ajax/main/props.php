<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");
?>
<?$bHideProps = false;
if (is_array($arResult["ORDER_PROP"]["USER_PROFILES"]) && !empty($arResult["ORDER_PROP"]["USER_PROFILES"])):?>
    <div class="cart-content" <?if ($curStep != 'delivery'):?> style="display:none;"<?endif;?>>
        <?if ($arParams["ALLOW_NEW_PROFILE"] == "Y"):?>
            <div class="float-center large-7 xlarge-5 relative">
                <div class="cart-content-counter show-for-large"><?=$iBlock?></div>
                <?$iBlock++;?>
                <label for="ID_PROFILE_ID">
                    <strong><?=GetMessage("SOA_TEMPL_PROP_CHOOSE")?></strong>
                    <select name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
                        <option value="0"><?=GetMessage("SOA_TEMPL_PROP_NEW_PROFILE")?></option>
                        <?foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles) {?>
                            <option value="<?=$arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected=\"selected\"";?>><?=$arUserProfiles["NAME"]?></option>
                        <?}?>
                    </select>
                </label>
            </div>
        <?else:?>
            <div class="float-center large-7 xlarge-5 relative">
                <div class="cart-content-counter show-for-large"><?=$iBlock?></div>
                <?$iBlock++;?>
                <label for="delivery-profile">
                    <strong><?=GetMessage("SOA_TEMPL_EXISTING_PROFILE")?></strong>
                    <?if (count($arResult["ORDER_PROP"]["USER_PROFILES"]) == 1):?>
                        <select name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
                            <option value="<?=$arUserProfiles["ID"]?>" selected="selected"><?=$arUserProfiles["NAME"]?></option>
                        </select>
                        <input type="hidden" name="PROFILE_ID" id="ID_PROFILE_ID" value="<?=$arUserProfiles["ID"]?>" />
                    <?else:?>
                        <select name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
                            <?foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles) {?>
                                <option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected=\"selected\"";?>><?=$arUserProfiles["NAME"]?></option>
                            <?}?>
                        </select>
                    <?endif;?>
                </label>
            </div>
        <?endif;?>
    </div>
<?endif;?>
<div class="cart-content" <?if ($curStep != 'delivery'):?> style="display:none;"<?endif;?>>
    <div class="float-center large-7 xlarge-5 relative">
        <div class="cart-content-counter show-for-large"><?=$iBlock?></div>
        <?$iBlock++;?>
        <input type="hidden" name="showProps" id="showProps" value="<?=($_POST["showProps"] == 'Y' ? 'Y' : 'N')?>" />
        <fieldset class="input row" id="sale_order_props">
            <?
            PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"]);
            PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"]);
            ?>
        </fieldset>
    </div>
</div>
<?if(!CSaleLocation::isLocationProEnabled()):?>
	<div style="display:none;">

		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.ajax.locations",
			$arParams["TEMPLATE_LOCATION"],
			array(
				"AJAX_CALL" => "N",
				"COUNTRY_INPUT_NAME" => "COUNTRY_tmp",
				"REGION_INPUT_NAME" => "REGION_tmp",
				"CITY_INPUT_NAME" => "tmp",
				"CITY_OUT_LOCATION" => "Y",
				"LOCATION_VALUE" => "",
				"ONCITYCHANGE" => "submitForm()",
			),
			null,
			array('HIDE_ICONS' => 'Y')
		);?>

	</div>
<?endif?>
