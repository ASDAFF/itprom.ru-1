<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Производители и бренды термошкафов ITProm");
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
		"BLOCK_ID" => "5",
		"DETAIL_URL" => SITE_DIR."brands/#brand_code#/",
		"COMPONENT_TEMPLATE" => ".default",
		"ROWS_PER_PAGE" => "",
		"PAGEN_ID" => "page",
		"FILTER_NAME" => "",
		"CHECK_PERMISSIONS" => "N"
	),
	false
);?>

    </div>
  </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>