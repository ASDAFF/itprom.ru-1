<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if (!empty($arResult["STORE"])):?>
    <ul class="inner-content-list inner-content-contact-left">
        <?if ($arResult["STORE"]["PHONE"]):?>
            <li>
                <?=GetMessage("S_PHONE")?>
                <div class="value phone"><?=$arResult["STORE"]["PHONE"]?></div>
            </li>
        <?endif;?>
        <?if ($arResult["STORE"]["ADDRESS"]):?>
            <li>
                <?=GetMessage("S_ADDRESS")?>
                <div class="value"><?=$arResult["STORE"]["ADDRESS"]?></div>
            </li>
        <?endif;?>
        <?if ($arResult["STORE"]["EMAIL"]):?>
            <li>
                <?=GetMessage("S_EMAIL")?>
                <div class="value"><a href="mailto:<?=$arResult["STORE"]["EMAIL"]?>"><?=$arResult["STORE"]["EMAIL"]?></a></div>
            </li>
        <?endif;?>
        <?if ($arResult["STORE"]["SCHEDULE"]):?>
            <li>
                <?=GetMessage("S_SCHEDULE")?>
                <div class="value"><?=$arResult["STORE"]["SCHEDULE"]?></div>
            </li>
        <?endif;?>
    </ul>
<?else:?>
    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
        array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR . "include/schedule.php"
        ),
        false
    );?>
<?endif;?>
