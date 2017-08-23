<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "термошкафы, термошкаф, купить термошкаф,");
$APPLICATION->SetPageProperty("title", "Термошкафы ITProm");
$APPLICATION->SetPageProperty("description", "Купить термошкафы ITProm по лучшей цене с доставкой по Москве и в регионы. Огромный каталог термошкафов ITProm от производителя.");
$APPLICATION->SetTitle("Термошкафы ITProm");
?>
<div class="wrapper">
  <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"main_slider",
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "9",
		"NEWS_COUNT" => "1",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "NAME",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "STATIC",
			1 => "SLIDES",
			2 => "LINKS",
      3 => "LINKS_PIC"
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
</div>

<!--  Special block -->
<div class="wrapper">
  <div class="promo">
    <div class="row">
      <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/top_categories.php"));?>
    </div>
  </div>
</div>
<div class="wrapper">
  <div class="main-holder">
    <div class="container">
      <div class="container-hold container-hold-index">
        <!--    Left column starts here -->
        <div class="blog-col">
          <?$APPLICATION->IncludeComponent("bitrix:news.list", "main_blog", Array(
              "IBLOCK_TYPE" => "content",	// Тип информационного блока (используется только для проверки)
              "IBLOCK_ID" => "7",	// Код информационного блока
              "NEWS_COUNT" => "2",	// Количество новостей на странице
              "SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
              "SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
              "SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
              "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
              "FILTER_NAME" => "",	// Фильтр
              "FIELD_CODE" => array(	// Поля
                0 => "",
                1 => "",
              ),
              "PROPERTY_CODE" => array(	// Свойства
                0 => "",
                1 => "",
              ),
              "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
              "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
              "AJAX_MODE" => "N",	// Включить режим AJAX
              "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
              "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
              "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
              "CACHE_TYPE" => "A",	// Тип кеширования
              "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
              "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
              "CACHE_GROUPS" => "Y",	// Учитывать права доступа
              "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
              "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
              "SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
              "SET_TITLE" => "N",	// Устанавливать заголовок страницы
              "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// Включать инфоблок в цепочку навигации
              "ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
              "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
              "PARENT_SECTION" => "",	// ID раздела
              "PARENT_SECTION_CODE" => "",	// Код раздела
              "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
              "PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
              "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
              "DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
              "PAGER_TITLE" => "",	// Название категорий
              "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
              "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
              "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
              "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
              "DISPLAY_DATE" => "Y",	// Выводить дату элемента
              "DISPLAY_NAME" => "Y",	// Выводить название элемента
              "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
              "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
              "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
            ),
            false
          );?>
          <div class="block-type02">
            <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"main_news",
	array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "6",
		"NEWS_COUNT" => "2",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y"
	),
	false
);?>
          </div>
        </div>
        <!--   MainContent (tabs) starts here -->
        <div class="tabset">
          <?
//		  global $arFilter;
//		  $arFilter = array(
//			  "!PROPERTY_NEWPRODUCT" => false,
//			  "!PROPERTY_SALELEADER" => false,
//			  "!PROPERTY_SPECIALOFFER" => false
//		  );
		  $APPLICATION->IncludeComponent(
	"intsys:catalog.top",
	"main_topcat", 
	array(
		"VIEW_MODE" => "SECTION",
		"TEMPLATE_THEME" => "site",
		"PRODUCT_DISPLAY_MODE" => "N",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"ROTATE_TIMER" => "30",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Ожидается",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "4",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "name",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DISPLAY_COMPARE" => "N",
		"CACHE_FILTER" => "N",
		"ELEMENT_COUNT" => "150",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "NEWPRODUCT",
			1 => "SALELEADER",
			2 => "SPECIALOFFER",
			3 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "NAME",
			3 => "SORT",
			4 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "ARTNUMBER",
			1 => "MORE_PHOTO",
			2 => "SIZE_GENERAL",
			3 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "timestamp_x",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "0",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_PRODUCT_QUANTITY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"SHOW_PAGINATION" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_COMPARE" => "Сравнить",
		"ADD_TO_BASKET_ACTION" => "ADD"
	),
	false
);?>
        </div>
      </div>
    </div>
  </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>