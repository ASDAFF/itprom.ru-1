<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Оплата заказа");
?>
<div class="wrapper">
  <div class="container">
    <div class="container-hold">
      <div class="content-about">
        <?$APPLICATION->IncludeComponent(
        "bitrix:sale.order.payment",
        "",
        Array(
        )
      );?>
      </div>
    </div>
  </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>