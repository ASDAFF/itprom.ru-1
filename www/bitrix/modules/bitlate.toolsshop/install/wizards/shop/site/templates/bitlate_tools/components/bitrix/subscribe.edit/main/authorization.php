<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//*************************************
//show current authorization section
//*************************************
?>

<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
    <?echo bitrix_sessid_post();?>
    <p><?echo GetMessage("subscr_title_auth")?></p>
    <p>
        <?echo GetMessage("adm_auth_user")?>
        <?echo htmlspecialcharsbx($USER->GetFormattedName(false));?> [<?echo htmlspecialcharsbx($USER->GetLogin())?>]
    </p>

    <?if($arResult["ID"]==0):?>
        <?echo GetMessage("subscr_auth_logout1")?> <a class="button"  href="<?echo $arResult["FORM_ACTION"]?>?logout=YES&amp;sf_EMAIL=<?echo $arResult["REQUEST"]["EMAIL"]?><?echo $arResult["REQUEST"]["RUBRICS_PARAM"]?>"><?echo GetMessage("adm_auth_logout")?></a><?echo GetMessage("subscr_auth_logout2")?><br />
    <?else:?>
        <?echo GetMessage("subscr_auth_logout3")?> <a class="button"  href="<?echo $arResult["FORM_ACTION"]?>?logout=YES&amp;sf_EMAIL=<?echo $arResult["REQUEST"]["EMAIL"]?><?echo $arResult["REQUEST"]["RUBRICS_PARAM"]?>"><?echo GetMessage("adm_auth_logout")?></a><?echo GetMessage("subscr_auth_logout4")?><br />
    <?endif;?>
</form>
<br />