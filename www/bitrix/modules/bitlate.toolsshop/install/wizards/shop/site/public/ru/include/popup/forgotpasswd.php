<div class="login-block">
    <?$APPLICATION->IncludeComponent(
        "bitrix:system.auth.form",
        "errors",
        Array(
            "REGISTER_URL" => "",
            "FORGOT_PASSWORD_URL" => "",
            "PROFILE_URL" => "#SITE_DIR#personal/",
            "SHOW_ERRORS" => "Y"
        )
    );?>
    <?$APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd","",Array());?>
</div>