<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//status and unsubscription/activation section
//***********************************
?>
<form id="form_subsr_status" action="<?=$arResult["FORM_ACTION"]?>" method="get" data-ajax="<?=SITE_DIR?>nl_ajax/subscribe_edit.php" class="form">
    <p><strong><?echo GetMessage("subscr_title_status")?></strong></p>
    <p><?echo GetMessage("subscr_conf")?> <?echo ($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?></p>

    <?if($arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y"):?>
        <p><?echo GetMessage("subscr_title_status_note1")?></p>
    <?elseif($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
        <p><?echo GetMessage("subscr_title_status_note2")?><br />
        <?echo GetMessage("subscr_status_note3")?></p>
    <?else:?>
        <p><?echo GetMessage("subscr_status_note4")?><br />
        <?echo GetMessage("subscr_status_note5")?></p>
    <?endif;?>
    
    <p>
        <?echo GetMessage("subscr_act")?>
        <?echo ($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"? GetMessage("subscr_yes"):GetMessage("subscr_no"));?>
    </p>
    <p>
        <?echo GetMessage("adm_id")?>
        <?echo $arResult["SUBSCRIPTION"]["ID"];?>
    </p>
    <p>
        <?echo GetMessage("subscr_date_add")?>
        <?echo $arResult["SUBSCRIPTION"]["DATE_INSERT"];?>
    </p>
    <p>
        <?echo GetMessage("subscr_date_upd")?>
        <?echo $arResult["SUBSCRIPTION"]["DATE_UPDATE"];?>
    </p>
    <?if($arResult["SUBSCRIPTION"]["CONFIRMED"] == "Y"):?>
        <?if($arResult["SUBSCRIPTION"]["ACTIVE"] == "Y"):?>
            <input id="subscribe_status_unsubscribe" style="display:none"  type="submit" name="unsubscribe" value="<?echo GetMessage("subscr_unsubscr")?>" />
            <input type="hidden" name="action" value="unsubscribe" />
            <a href="JavaScript:void(0)" onclick="$('#subscribe_status_unsubscribe').click(); return false;" class="button small" title=""><?echo GetMessage("subscr_unsubscr")?></a>
        <?else:?>
            <input id="subscribe_status_activate" style="display:none" type="submit" name="activate" value="<?echo GetMessage("subscr_activate")?>" />
            <input type="hidden" name="action" value="activate" />
            <a href="JavaScript:void(0)" onclick="$('#subscribe_status_activate').click(); return false;" class="button small" title=""><?echo GetMessage("subscr_activate")?></a>
        <?endif;?>
    <?endif;?>
    <input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
    <?echo bitrix_sessid_post();?>
</form>
<br />