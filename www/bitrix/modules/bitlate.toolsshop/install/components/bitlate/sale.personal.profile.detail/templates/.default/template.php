<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if ($arResult["SUCCESS_MESSAGE"] != '' && $arResult["IS_NEW_PROFILE_CREATE"] == "Y") {
    $arResult["ID"] = 0;
    $arResult["NAME"] = '';
}?>
<?$idBlock = ($arResult["ID"] <= 0) ? "new-delivery" : "edit-delivery-{$arResult["ID"]}";?>
<div id="<?=$idBlock?>" class="fancybox-block delivery-form">
    <div class="fancybox-block-caption"><?=GetMessage("PROFILE_DELIVERY_TITLE")?></div>
    <?if ($arResult["ERROR_MESSAGE"]):?>
        <div class="callout text-center error" data-closable=""><?=$arResult["ERROR_MESSAGE"]?></div>
    <?endif;?>
    <?if ($arResult["SUCCESS_MESSAGE"]):?>
        <div class="callout text-center error" data-closable=""><?=$arResult["SUCCESS_MESSAGE"]?></div>
    <?endif;?>
    <div class="fancybox-block-wrap">
        <form method="post" class="form fancybox-block-form" action="<?=POST_FORM_ACTION_URI?>" data-ajax="<?=SITE_DIR?>nl_ajax/profile_edit.php">
            <?if ($arResult["ID"] <= 0):?>
                <?if (count($arResult["PERSON_TYPES"]) > 1):?>
                    <fieldset class="radio">
                        <legend><?=GetMessage("SOA_TEMPL_PERSON_TYPE")?></legend>
                        <?foreach($arResult["PERSON_TYPES"] as $v):?>
                            <input type="radio" name="PERSON_TYPE" value="<?=$v["ID"]?>"<?if ($v["CHECKED"]=="Y") echo " checked=\"checked\"";?> id="PERSON_TYPE_<?=$v["ID"]?>" class="show-for-sr">
                            <label for="PERSON_TYPE_<?=$v["ID"]?>"><?=$v["NAME"]?></label>
                        <?endforeach;?>
                        <br />
                    </fieldset>
                    <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["PERSON_TYPE"]["ID"]?>" />
                <?else:?>
                    <input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
                <?endif;?>
            <?endif;?>
            <?$rules = '';
            foreach($arResult["ORDER_PROPS"] as $vval)
            {
                $currentValue = ($arResult["SUCCESS_MESSAGE"] != '' && $arResult["IS_NEW_PROFILE_CREATE"] == "Y") ? null : $arResult["ORDER_PROPS_VALUES"]["ORDER_PROP_".$vval["ID"]];
                $name = "ORDER_PROP_".$vval["ID"];
                $class = "";
                if ($vval["CODE"] == "PHONE") {
                    $class = "phone";
                } elseif ($vval["CODE"] == "ZIP") {
                    $class = "zip";
                }
                if ($vval["REQUIED"] == "Y") {
                    $nameRule = ($vval["TYPE"] != "LOCATION") ? $name : $name.'_'.$arResult["ID"].'_val';
                    $rules .= $nameRule . ': {required: true' . (($vval["IS_EMAIL"] == "Y") ? ', email: true' : '') . '}, ';
                }
                if ($vval["TYPE"]=="CHECKBOX"):?>
                    <fieldset class="checkbox">
                        <input type="checkbox" name="<?=$name?>" value="Y" id="<?=$name?>_<?=$arResult["ID"]?>" class="show-for-sr"<?if ($currentValue=="Y" || !isset($currentValue) && $vval["DEFAULT_VALUE"]=="Y") echo " checked";?>>
                        <label for="<?=$name?>_<?=$arResult["ID"]?>"><?=$vval["NAME"]?></label>
                    </fieldset>
                    <input type="hidden" name="<?=$name?>" value="">
                <?elseif ($vval["TYPE"]=="TEXT"):?>
                    <input type="text" value="<?echo (isset($currentValue)) ? $currentValue : $vval["DEFAULT_VALUE"];?>" name="<?=$name?>" placeholder="<?=$vval["NAME"] ?>" class="<?=$class?>">
                <?elseif ($vval["TYPE"]=="SELECT"):?>
                    <select name="<?=$name?>" size="<?echo (IntVal($vval["SIZE1"])>0)?$vval["SIZE1"]:1; ?>">
                        <?foreach($vval["VALUES"] as $vvval):?>
                            <option value="<?echo $vvval["VALUE"]?>"<?if ($vvval["VALUE"]==$currentValue || !isset($currentValue) && $vvval["VALUE"]==$vval["DEFAULT_VALUE"]) echo " selected"?>><?echo $vvval["NAME"]?></option>
                        <?endforeach;?>
                    </select>
                <?elseif ($vval["TYPE"]=="MULTISELECT"):?>
                    <select multiple name="<?=$name?>[]" size="<?echo (IntVal($vval["SIZE1"])>0)?$vval["SIZE1"]:5; ?>">
                        <?
                        $arCurVal = array();
                        $arCurVal = explode(",", $currentValue);
                        for ($i = 0, $cnt = count($arCurVal); $i < $cnt; $i++)
                            $arCurVal[$i] = trim($arCurVal[$i]);
                        $arDefVal = explode(",", $vval["DEFAULT_VALUE"]);
                        for ($i = 0, $cnt = count($arDefVal); $i < $cnt; $i++)
                            $arDefVal[$i] = trim($arDefVal[$i]);
                        foreach($vval["VALUES"] as $vvval):?>
                            <option value="<?echo $vvval["VALUE"]?>"<?if (in_array($vvval["VALUE"], $arCurVal) || !isset($currentValue) && in_array($vvval["VALUE"], $arDefVal)) echo" selected"?>><?echo $vvval["NAME"]?></option>
                        <?endforeach;?>
                    </select>
                <?elseif ($vval["TYPE"]=="TEXTAREA"):?>
                    <textarea rows="<?echo (IntVal($vval["SIZE2"])>0)?$vval["SIZE2"]:4; ?>" cols="<?echo (IntVal($vval["SIZE1"])>0)?$vval["SIZE1"]:40; ?>" name="<?=$name?>"><?echo (isset($currentValue)) ? $currentValue : $vval["DEFAULT_VALUE"];?></textarea>
                <?elseif ($vval["TYPE"]=="LOCATION"):?>
                    <?$locationValue = intval($currentValue) ? $currentValue : $vval["DEFAULT_VALUE"];?>
                    <?$APPLICATION->IncludeComponent('bitrix:sale.ajax.locations', 'popup', array(
                        "AJAX_CALL" => "Y",
                        'CITY_OUT_LOCATION' => 'Y',
                        'COUNTRY_INPUT_NAME' => $name.'_'.$arResult["ID"].'_COUNTRY',
                        'CITY_INPUT_NAME' => $name.'_'.$arResult["ID"],
                        'CITY_INPUT_NAME_VAL' => $name,
                        'LOCATION_VALUE' => $locationValue,
                        'ONCHANGE' => '',
                        'RELATIVE_BLOCK' => 'Y',
                        ),
                        null,
                        array('HIDE_ICONS' => 'Y')
                    );?>
                <?elseif ($vval["TYPE"]=="RADIO"):?>
                    <fieldset class="radio">
                        <?foreach($vval["VALUES"] as $k => $vvval):?>
                            <input type="radio" name="<?=$name?>" value="<?echo $vvval["VALUE"]?>"<?if ($vvval["VALUE"]==$currentValue || !isset($currentValue) && $vvval["VALUE"]==$vval["DEFAULT_VALUE"]) echo " checked"?> id="<?=$name?>_<?=$k?>" class="show-for-sr">
                            <label for="<?=$name?>_<?=$k?>"><?echo $vvval["NAME"]?></label>
                        <?endforeach;?>
                    </fieldset>
                <?endif?>

                <?if (strlen($vval["DESCRIPTION"])>0):?>
                    <br /><small><?echo $vval["DESCRIPTION"] ?></small>
                <?endif?>
                <?
            }
            $rules = "{" . trim($rules, ', ') . "}";?>
            <script>
                $(document).ready(function(){
                    initValidateWithRules("#<?=$idBlock?> form", <?=$rules?>);
                })
            </script>
            <?=bitrix_sessid_post()?>
            <input type="hidden" name="NAME" value="<?echo $arResult["NAME"];?>">
            <input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
            <input type="hidden" name="action" value="save">
            <button type="submit" class="small-12 button small fancybox-button text-center"><?=GetMessage("SALE_SAVE")?></button>
        </form>
        <script>
            $(document).ready(function() {
                <?if ($arResult["SUCCESS_MESSAGE"] != ''):?>
                    $.ajax({
                        type: 'GET',
                        url: '<?=SITE_DIR?>nl_ajax/profile_list.php',
                        success: function(data){
                            $('.profile-container .column.shipping').replaceWith(data);
                            $('.profile-column-container').isotope('destroy');
                            $('.profile-column-container').isotope(profileGridOptions);
                        }
                    });
                <?endif;?>
            })
        </script>
    </div>
</div>