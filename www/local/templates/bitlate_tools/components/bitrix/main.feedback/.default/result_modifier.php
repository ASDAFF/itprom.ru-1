<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$strError = '';
if(!empty($arResult["ERROR_MESSAGE"])) {
    foreach($arResult["ERROR_MESSAGE"] as $v) {
        $strError .= $v . '<br />';
    }
    $arResult["ERROR_MESSAGE"] = $strError;
    if(strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"]))
        $arResult["ERROR_FIELDS"][] = 'EMAIL';
    if($arParams["USE_CAPTCHA"] == "Y") {
        include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
        $captcha_code = $_POST["captcha_sid"];
        $captcha_word = $_POST["captcha_word"];
        $cpt = new CCaptcha();
        $captchaPass = COption::GetOptionString("main", "captcha_password", "");
        if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0){
            if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass)) {
                $arResult["ERROR_FIELDS"][] = 'CAPTCHA';
            }
        }
        else
            $arResult["ERROR_FIELDS"][] = 'CAPTCHA';
    }
} else {
    $arResult["AUTHOR_NAME"] = '';
    $arResult["AUTHOR_EMAIL"] = '';
}