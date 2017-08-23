<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;

if(!CModule::IncludeModule("form"))
	return;

// создание веб-формы
$idForm = "NL_CALL_BACK_FORM_" . WIZARD_SITE_ID;
$rsForm = CForm::GetBySID($idForm);
$isNewForm = true;
if ($arForm = $rsForm->Fetch()) {
	$NEW_ID = $arForm["ID"];
    $isNewForm = false;
} else {
	$arFields = array(
		"NAME"              => GetMessage('CALL_BACK_NAME'),
		"SID"               => $idForm,
		"C_SORT"            => 100,
		"BUTTON"            => GetMessage('CALL_BACK_BUTTON'),
		"DESCRIPTION"       => GetMessage('CALL_BACK_DESCRIPTION'),
		"DESCRIPTION_TYPE"  => "text",
		"arSITE"            => array(WIZARD_SITE_ID),
		"arMENU"            => array("ru" => GetMessage('CALL_BACK_NAME'), "en" => ""),
		);
	$NEW_ID = CForm::Set($arFields);
}
// создание поля Имя
$nameId = "NL_NAME_" . WIZARD_SITE_ID;
$arFields = array( 
	"FORM_ID"             => $NEW_ID,
	"ACTIVE"              => "Y",
	"TITLE"               => GetMessage('FIELDS_NAME_TITLE'),
	"SID"                 => $nameId,
	"C_SORT"              => 100,
	"ADDITIONAL"          => "N",
	"REQUIRED"            => "Y",
	"IN_RESULTS_TABLE"    => "Y",
	"IN_EXCEL_TABLE"      => "Y",
	"FIELD_TYPE"          => "text",
	"FILTER_TITLE"        => GetMessage('FIELDS_NAME_TITLE'),
	"RESULTS_TABLE_TITLE" => GetMessage('FIELDS_NAME_TITLE'),
	"arFILTER_FIELD"      => array("text")
);
$fieldID = CFormField::Set($arFields);

$arFields = array(
    "QUESTION_ID"   => $fieldID,
    "MESSAGE"       => " ",
    "C_SORT"        => 100,
    "ACTIVE"        => "Y",
    "FIELD_TYPE"    => "text",
    "FIELD_WIDTH"   => "40"
    );
$nameId = CFormAnswer::Set($arFields);

// создание поля Телефон
$telephoneId = "NL_TELEPHONE_" . WIZARD_SITE_ID;
$arFields = array( 
	"FORM_ID"             => $NEW_ID,
	"ACTIVE"              => "Y",
	"TITLE"               => GetMessage('FIELDS_PHONE_TITLE'),
	"SID"                 => $telephoneId,
	"C_SORT"              => 200,
	"ADDITIONAL"          => "N",
	"REQUIRED"            => "Y",
	"IN_RESULTS_TABLE"    => "Y",
	"IN_EXCEL_TABLE"      => "Y",
	"FIELD_TYPE"          => "text",
	"FILTER_TITLE"        => GetMessage('FIELDS_PHONE_TITLE'),
	"RESULTS_TABLE_TITLE" => GetMessage('FIELDS_PHONE_TITLE'),
	"arFILTER_FIELD"      => array("text")
);
$fieldID = CFormField::Set($arFields);

$arFields = array(
    "QUESTION_ID"   => $fieldID,
    "MESSAGE"       => " ",
    "C_SORT"        => 100,
    "ACTIVE"        => "Y",
    "FIELD_TYPE"    => "text",
    "FIELD_WIDTH"   => "40"
    );
$telephoneId = CFormAnswer::Set($arFields);

// создание статуса
$arFields = array(
    "FORM_ID"             => $NEW_ID,               // ID веб-формы
    "C_SORT"              => 100,                    // порядок сортировки
    "ACTIVE"              => "Y",                    // статус активен
    "TITLE"               => GetMessage('STATUS_TITLE'),       // заголовок статуса
    "DESCRIPTION"         => GetMessage('STATUS_DESCRIPTION'),// описание статуса
    "CSS"                 => "statusgreen",          // CSS класс
    "HANDLER_OUT"         => "",                     // обработчик
    "HANDLER_IN"          => "",                     // обработчик
    "DEFAULT_VALUE"       => "Y",                    // не по умолчанию
    "arPERMISSION_VIEW"   => array(2),               // право просмотра для всех
    "arPERMISSION_MOVE"   => array(2),               // право перевода для всех
    "arPERMISSION_EDIT"   => array(),                // право редактирование для админам
    "arPERMISSION_DELETE" => array(),                // право удаления только админам
);
CFormStatus::Set($arFields);

if ($isNewForm) {
    // создание почтового шаблона
    $siteEmail = $wizard->GetVar("siteEmail");
    $siteEmail = (strlen(trim($siteEmail)) > 0) ? $siteEmail : "#DEFAULT_EMAIL_FROM#";
    COption::SetOptionString("bitlate.toolsshop", "NL_REQUEST_CALL_EMAIL", $siteEmail, '', WIZARD_SITE_ID);
    $arFields = array(
        "ACTIVE"     => "Y",
        "EVENT_NAME" => "FORM_FILLING_" . $idForm,
        "LID"        => WIZARD_SITE_ID,
        "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
        "EMAIL_TO"   => htmlspecialcharsbx($siteEmail),
        "SUBJECT"    => GetMessage('CALL_BACK_EVENT_SUBJECT'),
        "BODY_TYPE"  => "text",
        "MESSAGE"    => str_replace("#SITE_ID#", WIZARD_SITE_ID, GetMessage('CALL_BACK_EVENT_MESSAGE')),
    );
    $obEvent = new CEventMessage;
    $eventMessageId = $obEvent->Add($arFields);

    if ($eventMessageId !== false) {
        $arFields = array(
            "arMAIL_TEMPLATE" => array($eventMessageId),
        );
        CForm::Set($arFields, $NEW_ID);
    }
}

CWizardUtil::ReplaceMacros($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/'.WIZARD_SITE_ID.'/init.php', array("NL_REQUEST_CALL_FORM_ID" => $NEW_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "/include/popup/request_call.php", array("NL_REQUEST_CALL_FORM_ID" => $NEW_ID));
?>