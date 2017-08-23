<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Список производителей и брендов сантехники | Интернет-магазин Cантехники+");
$APPLICATION->SetTitle("Бренды");
?>
<div class="wrapper">
  <div class="container">
    <div class="container-hold">
      <div class="content-about2">
		  <h1>Продаваемые бренды</h1>
		</div>
      <?$APPLICATION->IncludeComponent(
	"bitrix:highloadblock.list", 
	"brands", 
	array(
		"BLOCK_ID" => "#HLB_BRANDS#",
		"DETAIL_URL" => SITE_DIR."brands/#brand_id#/"
	),
	false
);?>

    </div>
  </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>