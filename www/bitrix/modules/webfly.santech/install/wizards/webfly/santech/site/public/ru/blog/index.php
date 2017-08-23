<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Интернет-магазин Сантехника+  – статьи. Как выбрать ванну, как подобрать душевую кабину, как выбрать смеситель, как спланировать расстановку маленькой ванны");
$APPLICATION->SetPageProperty("description", "Мы предлагаем широкий ассортимент сантехники по доступным ценам.");
$APPLICATION->SetTitle("Блог");
?>
<div class="wrapper">
  <div class="container">
    <div class="container-hold">
      <div class="main-frame main-frame-type03">
          <?$APPLICATION->IncludeComponent(
          "bitrix:news", 
          "blog", 
          array(
            "IBLOCK_TYPE" => "content",
            "IBLOCK_ID" => "#WF_IB_BLOG#",
            "NEWS_COUNT" => "20",
            "USE_SEARCH" => "N",
            "USE_RSS" => "N",
            "USE_RATING" => "N",
            "USE_CATEGORIES" => "N",
            "USE_REVIEW" => "N",
            "USE_FILTER" => "Y",
            "SORT_BY1" => "ID",
            "SORT_ORDER1" => "ASC",
            "SORT_BY2" => "NAME",
            "SORT_ORDER2" => "ASC",
            "CHECK_DATES" => "Y",
            "SEF_MODE" => "Y",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_ELEMENT_CHAIN" => "N",
            "USE_PERMISSIONS" => "N",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "USE_SHARE" => "N",
            "PREVIEW_TRUNCATE_LEN" => "",
            "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "LIST_FIELD_CODE" => array(
              0 => "DATE_ACTIVE_FROM",
              1 => "SHOW_COUNTER",
              2 => "",
            ),
            "LIST_PROPERTY_CODE" => array(
              0 => "CATEGORY",
              1 => "",
            ),
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "DISPLAY_NAME" => "Y",
            "META_KEYWORDS" => "-",
            "META_DESCRIPTION" => "-",
            "BROWSER_TITLE" => "-",
            "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "DETAIL_FIELD_CODE" => array(
              0 => "DATE_ACTIVE_FROM",
              1 => "SHOW_COUNTER",
              2 => "",
            ),
            "DETAIL_PROPERTY_CODE" => array(
              0 => "CATEGORY",
              1 => "",
            ),
            "DETAIL_DISPLAY_TOP_PAGER" => "N",
            "DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
            "DETAIL_PAGER_TITLE" => "Страница",
            "DETAIL_PAGER_TEMPLATE" => "",
            "DETAIL_PAGER_SHOW_ALL" => "N",
            "PAGER_TEMPLATE" => "blog",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Новости",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "SEF_FOLDER" => SITE_DIR."blog/",
            "AJAX_OPTION_ADDITIONAL" => "",
            "FILTER_NAME" => "type",
            "FILTER_FIELD_CODE" => array(
              0 => "",
              1 => "",
            ),
            "FILTER_PROPERTY_CODE" => array(
              0 => "CATEGORY",
              1 => "",
            ),
            "SEF_URL_TEMPLATES" => array(
              "news" => "",
              "section" => "",
              "detail" => "#ELEMENT_CODE#/",
            )
          ),
          false
        );?>
      </div>
    </div>
  </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>