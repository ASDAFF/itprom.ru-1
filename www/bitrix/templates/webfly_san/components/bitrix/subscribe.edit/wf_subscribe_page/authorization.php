<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//*************************************
//show current authorization section
//*************************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
<?echo bitrix_sessid_post();?>
<h4><?echo GetMessage("subscr_title_auth")?></h4>
<p><?echo GetMessage("adm_auth_user")?><br/>
		<?echo htmlspecialcharsbx($USER->GetFormattedName(false));?> <strong>[<?echo htmlspecialcharsbx($USER->GetLogin())?>]</strong>.</p>
	<p style="margin-top: 15px;"><?if($arResult["ID"]==0):?>
			<?echo GetMessage("subscr_auth_logout1")?> <a href="<?echo $arResult["FORM_ACTION"]?>?logout=YES&amp;sf_EMAIL=<?echo $arResult["REQUEST"]["EMAIL"]?><?echo $arResult["REQUEST"]["RUBRICS_PARAM"]?>"><?echo GetMessage("adm_auth_logout")?></a><?echo GetMessage("subscr_auth_logout2")?><br />
		<?else:?>
			<?echo GetMessage("subscr_auth_logout3")?> <a href="<?echo $arResult["FORM_ACTION"]?>?logout=YES&amp;sf_EMAIL=<?echo $arResult["REQUEST"]["EMAIL"]?><?echo $arResult["REQUEST"]["RUBRICS_PARAM"]?>"><?echo GetMessage("adm_auth_logout")?></a><?echo GetMessage("subscr_auth_logout4")?><br />
			<?endif;?></p>
</form>

