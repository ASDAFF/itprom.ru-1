<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<div class="wrapper">
  <div class="container">
    <div class="container-hold">
      <div class="myContent">
    <?$APPLICATION->IncludeComponent("bitrix:main.register","",Array(
        "SHOW_FIELDS" => Array(), 
        "REQUIRED_FIELDS" => Array(), 
        "SET_TITLE" => "Y",
        "USE_CAPTCHA" => "N",
        "SUCCESS_PAGE" => SITE_DIR,
        "USER_PROPERTY" => Array(), 
        "VARIABLE_ALIASES" => Array()
        )
    );?>
      </div>
    </div>
  </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");