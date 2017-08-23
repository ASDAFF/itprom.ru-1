<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
  <div class="c1">
    <?$ElementID = $APPLICATION->IncludeComponent(
      "bitrix:news.detail",
      "",
      Array(
        "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
        "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
        "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
        "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
        "DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "META_KEYWORDS" => $arParams["META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
        "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
        "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
        "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
        "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
        "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
        "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
        "CHECK_DATES" => $arParams["CHECK_DATES"],
        "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
        "USE_SHARE" 			=> $arParams["USE_SHARE"],
        "SHARE_HIDE" 			=> $arParams["SHARE_HIDE"],
        "SHARE_TEMPLATE" 		=> $arParams["SHARE_TEMPLATE"],
        "SHARE_HANDLERS" 		=> $arParams["SHARE_HANDLERS"],
        "SHARE_SHORTEN_URL_LOGIN"	=> $arParams["SHARE_SHORTEN_URL_LOGIN"],
        "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
        "ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : '')
      ),
      $component
    );?>
  </div>
</div>
<div id="sidebar">
  <div class="block-type03">
    <?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "blog_subscribe", Array(
      "USE_PERSONALIZATION" => "Y",	// ���������� �������� �������� ������������
      "SHOW_HIDDEN" => "N",	// �������� ������� ������� ��������
      "PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php",	// �������� �������������� �������� (�������� ������ #SITE_DIR#)
      "CACHE_TYPE" => "A",	// ��� �����������
      "CACHE_TIME" => "3600",	// ����� ����������� (���.)
      ),
      false
    );?>
  </div>
  <div class="block-type05">
    <?$APPLICATION->IncludeComponent("bitrix:news.list", "news_blog", Array(
        "IBLOCK_TYPE" => "news",	// ��� ��������������� ����� (������������ ������ ��� ��������)
        "IBLOCK_ID" => "7",	// ��� ��������������� �����
        "NEWS_COUNT" => "5",	// ���������� �������� �� ��������
        "SORT_BY1" => "ACTIVE_FROM",	// ���� ��� ������ ���������� ��������
        "SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
        "SORT_BY2" => "SORT",	// ���� ��� ������ ���������� ��������
        "SORT_ORDER2" => "ASC",	// ����������� ��� ������ ���������� ��������
        "FILTER_NAME" => "",	// ������
        "FIELD_CODE" => array(	// ����
          0 => "",
          1 => "",
        ),
        "PROPERTY_CODE" => array(	// ��������
          0 => "",
          1 => "",
        ),
        "CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
        "DETAIL_URL" => "",	// URL �������� ���������� ��������� (�� ��������� - �� �������� ���������)
        "AJAX_MODE" => "N",	// �������� ����� AJAX
        "AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
        "AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
        "AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
        "CACHE_TYPE" => "A",	// ��� �����������
        "CACHE_TIME" => "36000000",	// ����� ����������� (���.)
        "CACHE_FILTER" => "N",	// ���������� ��� ������������� �������
        "CACHE_GROUPS" => "Y",	// ��������� ����� �������
        "PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
        "ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
        "SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
        "SET_TITLE" => "N",	// ������������� ��������� ��������
        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// �������� �������� � ������� ���������
        "ADD_SECTIONS_CHAIN" => "Y",	// �������� ������ � ������� ���������
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
        "PARENT_SECTION" => "",	// ID �������
        "PARENT_SECTION_CODE" => "",	// ��� �������
        "INCLUDE_SUBSECTIONS" => "Y",	// ���������� �������� ����������� �������
        "PAGER_TEMPLATE" => ".default",	// ������ ������������ ���������
        "DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
        "DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
        "PAGER_TITLE" => "�������",	// �������� ���������
        "PAGER_SHOW_ALWAYS" => "Y",	// �������� ������
        "PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
        "PAGER_SHOW_ALL" => "Y",	// ���������� ������ "���"
        "DISPLAY_DATE" => "Y",	// �������� ���� ��������
        "DISPLAY_NAME" => "Y",	// �������� �������� ��������
        "DISPLAY_PICTURE" => "Y",	// �������� ����������� ��� ������
        "DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
        "AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
      ),
      false
    );?>
  </div>
</div>
<div class="aside">
  <div class="topics">
    <div class="topic-block">
      <?$APPLICATION->IncludeComponent("bitrix:news.list", "blog_similar", Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],	// ��� ��������������� ����� (������������ ������ ��� ��������)
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],	// ��� ��������������� �����
        "NEWS_COUNT" => "0",	// ���������� �������� �� ��������
        "SORT_BY1" => "SHOW_COUNTER",	// ���� ��� ������ ���������� ��������
        "SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
        "SORT_BY2" => "NAME",	// ���� ��� ������ ���������� ��������
        "SORT_ORDER2" => "ASC",	// ����������� ��� ������ ���������� ��������
        "FILTER_NAME" => "",	// ������
        "FIELD_CODE" => array(	// ����
          0 => "",
          1 => "",
        ),
        "PROPERTY_CODE" => array(	// ��������
          0 => "CATEGORY",
          1 => "",
        ),
        "CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
        "DETAIL_URL" => "",	// URL �������� ���������� ��������� (�� ��������� - �� �������� ���������)
        "AJAX_MODE" => "N",	// �������� ����� AJAX
        "AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
        "AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
        "AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
        "CACHE_TYPE" => "A",	// ��� �����������
        "CACHE_TIME" => "36000000",	// ����� ����������� (���.)
        "CACHE_FILTER" => "N",	// ���������� ��� ������������� �������
        "CACHE_GROUPS" => "Y",	// ��������� ����� �������
        "PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
        "ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
        "SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
        "SET_TITLE" => "N",	// ������������� ��������� ��������
        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// �������� �������� � ������� ���������
        "ADD_SECTIONS_CHAIN" => "Y",	// �������� ������ � ������� ���������
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
        "PARENT_SECTION" => "",	// ID �������
        "PARENT_SECTION_CODE" => "",	// ��� �������
        "INCLUDE_SUBSECTIONS" => "Y",	// ���������� �������� ����������� �������
        "PAGER_TEMPLATE" => ".default",	// ������ ������������ ���������
        "DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
        "DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
        "PAGER_TITLE" => "�������",	// �������� ���������
        "PAGER_SHOW_ALWAYS" => "Y",	// �������� ������
        "PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
        "PAGER_SHOW_ALL" => "Y",	// ���������� ������ "���"
        "DISPLAY_DATE" => "Y",	// �������� ���� ��������
        "DISPLAY_NAME" => "Y",	// �������� �������� ��������
        "DISPLAY_PICTURE" => "Y",	// �������� ����������� ��� ������
        "DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
        "AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
      ),
      false
    );?>
    </div>
    <div class="topic-block" style="display:none;">
      <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/blog_groups.php"));?>
    </div>
    <div class="topic-block" style="display:none;">
      <?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "blog_subscribe_m", Array(
        "USE_PERSONALIZATION" => "Y",	// ���������� �������� �������� ������������
        "SHOW_HIDDEN" => "N",	// �������� ������� ������� ��������
        "PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php",	// �������� �������������� �������� (�������� ������ #SITE_DIR#)
        "CACHE_TYPE" => "A",	// ��� �����������
        "CACHE_TIME" => "3600",	// ����� ����������� (���.)
        ),
        false
      );?>
      <div class="share-article-block">
		<noindex>
        <h4><?=GetMessage("WF_SHARE_BLOCK_HEAD")?></h4>
        <div class="social-list">
          <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
          <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus" data-yashareTheme="counter" ></div> 
        </div>
		</noindex>
      </div>
    </div>
  </div>
</div>