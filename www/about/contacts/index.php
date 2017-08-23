<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");?>

<div class="row">
    <div class="large-6 xxlarge-4 columns">
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.store.list",
            "main",
            Array(
                "PHONE" => "Y",
                "SCHEDULE" => "Y",
                "TITLE" => "",
                "SET_TITLE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "PATH_TO_ELEMENT" => "/company/shops/#store_id#.html",
            )
        );?>
    </div>
    <div class="inner-content-contact-right large-6 xxlarge-8 columns">
        <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
            array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "/include/contacts.php"
            ),
            false
        );?>
        <div id="bx_main_feedback">
            <?$frame = new \Bitrix\Main\Page\FrameHelper("bx_main_feedback", false);
            $frame->begin();?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.feedback", 
                    ".default", 
                    array(
                        "USE_CAPTCHA" => "Y",
                        "OK_TEXT" => "Спасибо, ваш вопрос принят.",
                        "EMAIL_TO" => "office@webfly.pro",
                        "REQUIRED_FIELDS" => array(
                            0 => "NAME",
                            1 => "EMAIL",
                            2 => "MESSAGE",
                        ),
                        "EVENT_MESSAGE_ID" => array(
                        )
                    ),
                    false
                );?>
            <?$frame->beginStub();?>
            <?$frame->end();?>
        </div>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>