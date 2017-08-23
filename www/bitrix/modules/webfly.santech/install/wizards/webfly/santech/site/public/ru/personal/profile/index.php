<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки пользователя");
?>
<div class="wrapper">
  <div class="container">
    <div class="container-hold">
      <div class="myContent">
        <?$APPLICATION->IncludeComponent("bitrix:main.profile", "eshop_adapt", Array(
          "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
          ),
          false
        );?>
      </div>
    </div>
  </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>