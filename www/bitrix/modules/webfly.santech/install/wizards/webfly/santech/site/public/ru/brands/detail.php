<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");
$brandId = $_REQUEST["brand_id"];
?>
<div class="wrapper">
	<div class="container">
		<div class="container-hold">
		<div class="main-frame main-frame-type01 brand-detail">
		<div id="content">
			<div class="c1">
				 <?$APPLICATION->IncludeComponent(
        "bitrix:highloadblock.view",
        "brand",
        Array(
          "BLOCK_ID" => "#HLB_BRANDS#",
          "ROW_ID" => $brandId,
          "LIST_URL" => SITE_DIR."brands/"
        )
      );?>
			</div>
		</div>
		<div id="sidebar">
			<div class="block-type05">
				<?$APPLICATION->IncludeComponent("bitrix:news.list", "blog_news", Array(
        "IBLOCK_TYPE" => "news",	// Тип информационного блока (используется только для проверки)
        "IBLOCK_ID" => "#WF_IB_NEWS#",	// Код информационного блока
        "NEWS_COUNT" => "3",	// Количество новостей на странице
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
        "PAGER_TITLE" => "Новости",	// Название категорий
        "PAGER_SHOW_ALWAYS" => "Y",	// Выводить всегда
        "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
        "PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
        "DISPLAY_DATE" => "Y",	// Выводить дату элемента
        "DISPLAY_NAME" => "Y",	// Выводить название элемента
        "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
        "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
        "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
      ),
      false
    );?>
			</div>
		</div>

		</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>