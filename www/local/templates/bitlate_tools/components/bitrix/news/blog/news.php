<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
  die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<div id="content">
  <?if($arParams["USE_FILTER"]=="Y"):?>
  <?$APPLICATION->IncludeComponent(
    "bitrix:catalog.filter",
    "",
    Array(
      "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
      "IBLOCK_ID" => $arParams["IBLOCK_ID"],
      "FILTER_NAME" => $arParams["FILTER_NAME"],
      "FIELD_CODE" => $arParams["FILTER_FIELD_CODE"],
      "PROPERTY_CODE" => $arParams["FILTER_PROPERTY_CODE"],
      "CACHE_TYPE" => $arParams["CACHE_TYPE"],
      "CACHE_TIME" => $arParams["CACHE_TIME"],
      "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    ),
    $component
  );
  ?>
  <?endif?>
  
  <?$APPLICATION->IncludeComponent(
      "bitrix:news.list", "", Array(
      "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
      "IBLOCK_ID" => $arParams["IBLOCK_ID"],
      "NEWS_COUNT" => $arParams["NEWS_COUNT"],
      "SORT_BY1" => $arParams["SORT_BY1"],
      "SORT_ORDER1" => $arParams["SORT_ORDER1"],
      "SORT_BY2" => $arParams["SORT_BY2"],
      "SORT_ORDER2" => $arParams["SORT_ORDER2"],
      "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
      "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
      "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
      "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
      "IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
      "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
      "SET_TITLE" => $arParams["SET_TITLE"],
      "SET_STATUS_404" => $arParams["SET_STATUS_404"],
      "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
      "CACHE_TYPE" => $arParams["CACHE_TYPE"],
      "CACHE_TIME" => $arParams["CACHE_TIME"],
      "CACHE_FILTER" => $arParams["CACHE_FILTER"],
      "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
      "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
      "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
      "PAGER_TITLE" => $arParams["PAGER_TITLE"],
      "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
      "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
      "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
      "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
      "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
      "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
      "DISPLAY_NAME" => "Y",
      "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
      "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
      "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
      "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
      "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
      "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
      "FILTER_NAME" => $arParams["FILTER_NAME"],
      "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
      "CHECK_DATES" => $arParams["CHECK_DATES"],
          ), $component
  );
  ?>
</div>
<div id="sidebar">
  <div class="block-type03">
    <?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "blog_subscribe", Array(
      "USE_PERSONALIZATION" => "Y",	// Определять подписку текущего пользователя
      "SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
      "PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php",	// Страница редактирования подписки (доступен макрос #SITE_DIR#)
      "CACHE_TYPE" => "A",	// Тип кеширования
      "CACHE_TIME" => "3600",	// Время кеширования (сек.)
      ),
      false
    );?>
  </div>
  <div class="block-type05">
    <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"blog_news", 
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
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
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
<div class="aside">
  <div class="topics">
    <div class="topic-block">
      <?$APPLICATION->IncludeComponent("bitrix:news.list", "blog_popular", Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],	// Тип информационного блока (используется только для проверки)
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],	// Код информационного блока
        "NEWS_COUNT" => "4",	// Количество новостей на странице
        "SORT_BY1" => "SHOW_COUNTER",	// Поле для первой сортировки новостей
        "SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
        "SORT_BY2" => "NAME",	// Поле для второй сортировки новостей
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
        "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
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
    <div class="topic-block" style="display:none;">
      <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/blog_groups.php"));?>
    </div>
    <div class="topic-block" style="display:none;">
      <?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "blog_subscribe_m", Array(
        "USE_PERSONALIZATION" => "Y",	// Определять подписку текущего пользователя
        "SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
        "PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php",	// Страница редактирования подписки (доступен макрос #SITE_DIR#)
        "CACHE_TYPE" => "A",	// Тип кеширования
        "CACHE_TIME" => "3600",	// Время кеширования (сек.)
        ),
        false
      );?>
      <div class="share-article-block">
        <h4><?=GetMessage("WF_SHARE_BLOCK_HEAD")?></h4>
        <div class="social-list">
          <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
          <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus" data-yashareTheme="counter" ></div> 
        </div>
      </div>
    </div>
  </div>
</div>