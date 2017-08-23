<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Галерея работ");
?><div class="wrapper">
	<div class="container">
		<div class="container-hold">
			<h1>Галерея работ</h1>
			 <?$APPLICATION->IncludeComponent(
	"bitrix:photogallery_user",
	"",
	Array(
		"ADDITIONAL_SIGHTS" => array(""),
		"ALBUM_PHOTO_THUMBS_SIZE" => "120",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"DATE_TIME_FORMAT_DETAIL" => "",
		"DATE_TIME_FORMAT_SECTION" => "",
		"ELEMENTS_PAGE_ELEMENTS" => "",
		"ELEMENT_SORT_FIELD" => "",
		"ELEMENT_SORT_ORDER" => "",
		"GALLERY_AVATAR_SIZE" => "50",
		"GALLERY_GROUPS" => array("1"),
		"IBLOCK_ID" => "14",
		"IBLOCK_TYPE" => "news",
		"INDEX_PAGE_TOP_ELEMENTS_COUNT" => "45",
		"JPEG_QUALITY" => "",
		"JPEG_QUALITY1" => "",
		"MODERATE" => "N",
		"MODERATION" => "N",
		"ONLY_ONE_GALLERY" => "N",
		"ORIGINAL_SIZE" => "1280",
		"PAGE_NAVIGATION_TEMPLATE" => "",
		"PATH_TO_FONT" => "default.ttf",
		"PATH_TO_USER" => "",
		"PUBLIC_BY_DEFAULT" => "N",
		"SECTION_PAGE_ELEMENTS" => "",
		"SECTION_SORT_BY" => "",
		"SECTION_SORT_ORD" => "",
		"SEF_MODE" => "N",
		"SET_TITLE" => "Y",
		"SHOW_CONTROLS_BUTTONS" => "Y",
		"SHOW_NAVIGATION" => "Y",
		"SHOW_ONLY_PUBLIC" => "N",
		"SHOW_TAGS" => "N",
		"THUMBNAIL_SIZE" => "100",
		"UPLOAD_MAX_FILE_SIZE" => "64",
		"USE_COMMENTS" => "N",
		"USE_LIGHT_VIEW" => "Y",
		"USE_RATING" => "N",
		"USE_WATERMARK" => "Y",
		"VARIABLE_ALIASES" => Array(
			"ACTION" => "ACTION",
			"ELEMENT_ID" => "ELEMENT_ID",
			"PAGE_NAME" => "PAGE_NAME",
			"SECTION_ID" => "SECTION_ID",
			"USER_ALIAS" => "USER_ALIAS",
			"USER_ID" => "USER_ID"
		),
		"WATERMARK_COLOR" => "#FF00EE",
		"WATERMARK_FILE" => "",
		"WATERMARK_FILE_ORDER" => "usual",
		"WATERMARK_MIN_PICTURE_SIZE" => "800",
		"WATERMARK_POSITION" => "tl",
		"WATERMARK_RULES" => "ALL",
		"WATERMARK_SIZE" => "%3",
		"WATERMARK_TEXT" => "ITProm",
		"WATERMARK_TRANSPARENCY" => "50",
		"WATERMARK_TYPE" => "TEXT"
	)
);?>
		</div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>