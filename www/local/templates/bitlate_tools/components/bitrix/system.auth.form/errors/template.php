<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']):?>
    <div class="error-block hide"><div class="callout text-center error" data-closable=""><?=$arResult['ERROR_MESSAGE']['MESSAGE']?><?if ($arResult['NEW_USER_REGISTRATION'] === "Y" && $arResult['ERROR_MESSAGE']['TYPE'] === "OK"):?><br /><?=GetMessage("AUTH_EMAIL_SENT")?><?endif;?></div></div>
<?endif;?>