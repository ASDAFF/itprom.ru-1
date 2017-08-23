<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результат оплаты");
?>
  <div class="wrapper">
  <div class="container">
    <div class="container-hold">
      <div class="content-about">
  <?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
	Array(
		"PAY_SYSTEM_ID" => "",
		"PERSON_TYPE_ID" => ""
	),
false
);?>
        </div>
    </div>
  </div>
</div>
  <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>