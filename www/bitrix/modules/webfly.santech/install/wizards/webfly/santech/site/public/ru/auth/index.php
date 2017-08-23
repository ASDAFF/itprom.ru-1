<?if (isset($_GET["register"]) && $_GET["register"] == "yes"):
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
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
else:
        define("NEED_AUTH", true);
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
        if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0) 
            LocalRedirect($backurl);
        $APPLICATION->SetTitle("Авторизация");
        ?>
        <p>Вы зарегистрированы и успешно авторизовались.</p>
 
        <p>Используйте административную панель в верхней части экрана для быстрого доступа к функциям управления структурой и информационным наполнением сайта. Набор кнопок верхней панели отличается для различных разделов сайта. Так отдельные наборы действий предусмотрены для управления статическим содержимым страниц, динамическими публикациями (новостями, каталогом, фотогалереей) и т.п.</p>
 
        <p><a href="<?=SITE_DIR?>">Вернуться на главную страницу</a></p>
        <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
endif?>