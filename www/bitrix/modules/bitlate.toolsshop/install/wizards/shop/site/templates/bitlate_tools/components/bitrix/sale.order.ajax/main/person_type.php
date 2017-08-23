<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (count($arResult["PERSON_TYPE"]) > 1):?>
    <div class="cart-content" <?if ($curStep != 'delivery'):?> style="display:none;"<?endif;?>>
        <div class="float-center large-7 xlarge-5 relative">
            <div class="cart-content-counter show-for-large"><?=$iBlock?></div>
            <?$iBlock++;?>
            <label for="person-type">
                <strong><?=GetMessage("SOA_TEMPL_PERSON_TYPE")?></strong>
                <select name="PERSON_TYPE" id="person-type" onChange="submitForm()">
                    <?foreach($arResult["PERSON_TYPE"] as $v):?>
                        <option value="<?=$v["ID"]?>" id="PERSON_TYPE_<?=$v["ID"]?>"<?if ($v["CHECKED"]=="Y") echo " selected=\"selected\"";?>><?=$v["NAME"]?></option>
                    <?endforeach;?>
                </select>
                <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />
            </label>
        </div>
    </div>
<?else:
	if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
	{
		//for IE 8, problems with input hidden after ajax
		?>
		<span style="display:none;">
		<input type="text" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		<input type="text" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		</span>
		<?
	}
	else
	{
		foreach($arResult["PERSON_TYPE"] as $v)
		{
			?>
			<input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
			<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
			<?
		}
	}
endif;?>