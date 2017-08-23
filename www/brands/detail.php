<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренд ");
$brandId = $_REQUEST["brand_id"];
?><div class="wrapper">
	<div class="container">
		<div class="container-hold">
			<div class="main-frame main-frame-type01 brand-detail">
				<div id="content">
					<div class="c1">
						<?$APPLICATION->IncludeComponent("intsys:highloadblock.view", "brand", Array(
	"BLOCK_ID" => "5",	// ID инфоблока
		"ROW_ID" => $brandId,	// ID записи
		"LIST_URL" => "/brands/",	// Путь к странице списка записей
	),
	false
);?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>