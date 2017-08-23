<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div id="subscribe-edit" class="fancybox-block">
    <div class="fancybox-block-caption"><?=GetMessage("subscr_title_settings")?></div>
    <?if ($arResult["MESSAGE"] || $arResult["ERROR"]):?>
        <div class="callout text-center error" data-closable>
            <?=implode('<br />', $arResult["MESSAGE"])?>
            <?=implode('<br />', $arResult["ERROR"])?>
        </div>
    <?endif;?>
    <div class="fancybox-block-wrap">
		<?
		//whether to show the forms
		if($arResult["ID"] == 0 && empty($_REQUEST["action"]) || CSubscription::IsAuthorized($arResult["ID"]))
		{
			//show confirmation form
			if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y")
			{
				include("confirmation_code.php");
			}
			//show current authorization section
			/*if($USER->IsAuthorized() && ($arResult["ID"] == 0 || $arResult["SUBSCRIPTION"]["USER_ID"] == 0))
			{
				include("authorization.php");
			}*/
			//show authorization section for new subscription
			/*if($arResult["ID"]==0 && !$USER->IsAuthorized())
			{
				if($arResult["ALLOW_ANONYMOUS"]=="N" || ($arResult["ALLOW_ANONYMOUS"]=="Y" && $arResult["SHOW_AUTH_LINKS"]=="Y"))
				{
					include("authorization_new.php");
				}
			}*/
			//setting section
			include("setting.php");
			//status and unsubscription/activation section
			if($arResult["ID"]>0)
			{
				include("status.php");
			}
		}
		else
		{
			//subscription authorization form
			include("authorization_full.php");
		}	
		?>
	</div>
</div>