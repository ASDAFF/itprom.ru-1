<?
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_NAME"] = "Выгрузка на портал Hotline.ua";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_ID"] = "Идентификатор торгового предложения";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_CATEGORY"] = "Идентификатор категории товара.<br/>Товарное предложение может принадлежать только одной категории.<br/><b>Обязательный элемент</b>";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_CODE"] = "Код модели (артикул от производителя)";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_BARCODE"] = "Штрихкод товара, указанный производителем";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_VENDOR"] = "Производитель. Не отображается в названии предложения";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_NAME"] = "Наименование торгового предложения.<br/><b>Обязательный элемент</b>";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_DESCRIPTION"] = "Описание товара.<br/>Длина текста не более 175 символов (не включая знаки препинания),<br/> запрещено использовать HTML-теги <br/>(информация внутри тегов публиковаться не будет)";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_URL"] = "URL страницы товара.<br/>Максимальная длина URL — 512 символов.<br/>Необязательный элемент для магазинов-салонов";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_PICTURE"] = "Ссылка на картинку соответствующего товарного предложения";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_CURRENCY"] = "Идентификатор валюты товара (RUR, USD, UAH, KZT).<br/><b>Обязательный элемент</b>";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_PRICE_RUAH"] = "Актуальная розничная цена товара в гривнах с учетом всех налогов.<br/><b>Обязательный элемент</b>";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_OLDPRICE"] = "Розничная цена до скидки в грн.<br/>Подается только в гривневом эквиваленте, должна быть выше, чем действующая цена на товар, на сайте отображается в виде перечеркнутой цены рядом с действующей.";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_PRICE_RUSD"] = "Актуальная розничная цена в долларах.<br/>Если цены в прайс-листе даны только в долларах, обязательно указывать курс пересчета в элементе rate";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_STOCK_DAYS"] = "С помощью атрибута days=\" \" можно указать количество дней от заказа товара покупателем до начала процесса доставки.";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_STOCK_STOCK_STATUS"] = "Доступность товара";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_STOCK_STOCK_STATUS_DEFAULT_VALUE"] = "В наличии";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_STOCK_STOCK_GUATANTEE_TYPE"] = "Тип гарантии (официальная от производителя или собственная от магазина)";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_STOCK_STOCK_GUATANTEE_TIME"] = "Срок гарантии";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_STOCK_STOCK_ORIGINAL"] = "Оригинальность товара";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_STOCK_STOCK_ORIGINAL_CONST"] = "Оригинальность";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_STOCK_STOCK_ORIGINAL_DEFAULT_VALUE"] = "Оригинал";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_COUNTRYOFORIGIN"] = "Страна производства товара.<br/> Список стран доступен по адресу:<br/>http://partner.market.yandex.ru/pages/help/Countries.pdf";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_COUNTRYOFORIGIN_CONST"] = "Страна изготовления";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_CUSTOM"] = "Поле custom используется для отбора товаров в Управлении аукционными ставками. Читайте подробнее в разделе Аукцион Hotline Целочисленное значение: http://hotline.ua/about/auctions/";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_UTM_SOURCE"] = "UTM метка: рекламная площадка";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_UTM_SOURCE_VALUE"] = "cpc_yandex_market";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_UTM_MEDIUM"] = "UTM метка: тип рекламы";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_UTM_MEDIUM_VALUE"] = "cpc";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_UTM_TERM"] = "UTM метка: ключевая фраза";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_UTM_CONTENT"] = "UTM метка: контейнер для дополнительной информации";
$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_UTM_CAMPAIGN"] = "UTM метка: название рекламной кампании";

$MESS["ACRIT_EXPORTPRO_UA_HOTLINE_UA_FIELD_PARAM"] = "Характеристики товара";
$MESS["ACRIT_EXPORTPRO_TYPE_UA_HOTLINE_UA_PORTAL_REQUIREMENTS"] = "http://hotline.ua/about/pricelists_specs/";
$MESS["ACRIT_EXPORTPRO_TYPE_UA_HOTLINE_UA_EXAMPLE"] = "
<item>
    <id>3278</id>
    <categoryId>2</categoryId>
    <code>n456-5300em-2010</code>
    <barcode>48607830</barcode>
    <vendor>Nokia</vendor>
    <name>5300 ExpressMusic</name>
    <description>Мобильный телефон.</description>
    <url>http://shop.ua/1/2/123.html</url>
    <image>http://shop.ua/img/1/2/123.jpg</image>
    <priceRUAH>1000</priceRUAH>
    <oldprice>1200</oldprice>
    <priceRUSD>200</priceRUSD>
    <stock>В наличии</stock>
    <guarantee type=\"manufacturer\">12</guarantee>
    <param name=\"Страна изготовления\">Украина</param>
    <param name=\"Оригинальность\">Оригинал</param>
    <custom>1</custom>
</item>
";
?>