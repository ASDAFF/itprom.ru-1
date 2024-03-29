<?
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_NAME"] = "Книги (book)";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_ID"] = "Идентификатор торгового предложения";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_BID"] = "Основная ставка клика";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_AVAILABLE"] = "Cтатус доступности товара";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_URL"] = "URL страницы товара.<br/>Максимальная длина URL — 512 символов.<br/>Необязательный элемент для магазинов-салонов";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_PRICE"] = "Цена, по которой данный товар можно приобрести.<br/><b>Обязательный элемент</b>";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_CURRENCY"] = "Идентификатор валюты товара (RUR, USD, UAH, KZT).<br/><b>Обязательный элемент</b>";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_CATEGORY"] = "Идентификатор категории товара.<br/>Товарное предложение может принадлежать только одной категории.<br/><b>Обязательный элемент</b>";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_PICTURE"] = "Ссылка на картинку соответствующего товарного предложения";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_AUTHOR"] = "Автор произведения";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_NAME"] = "Наименование товарного предложения.<br/><b>Обязательный элемент</b>";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_PUBLISHER"] = "Издательство";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_SERIES"] = "Серия";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_YEAR"] = "Год издания";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_ISBN"] = "Код книги";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_VOLUME"] = "Номер тома";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_PART"] = "Номер части";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_LANGUAGE"] = "Язык произведения";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_TABLEOFCONTENTS"] = "Оглавление.<br/>Выводится информация о названиях произведений,<br/>если это сборник рассказов или стихов";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_DESCRIPTION"] = "Описание товара.<br/>Длина текста не более 175 символов (не включая знаки препинания),<br/> запрещено использовать HTML-теги <br/>(информация внутри тегов публиковаться не будет)";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_AGE"] = "Возрастная категория товара";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_STORE"] = "Покупка соответствующего товара в розничном магазине<br/>Возможные значения: true, false";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_PICKUP"] = "Возможность зарезервировать выбранный товар и забрать его самостоятельно<br/>Возможные значения: true, false";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_BINDING"] = "Переплет";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_PAGEEXTENT"] = "Количество страниц в книге";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_UTM_SOURCE"] = "UTM метка: рекламная площадка";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_UTM_SOURCE_VALUE"] = "cpc_yandex_market";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_UTM_MEDIUM"] = "UTM метка: тип рекламы";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_UTM_MEDIUM_VALUE"] = "cpc";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_UTM_TERM"] = "UTM метка: ключевая фраза";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_UTM_CONTENT"] = "UTM метка: контейнер для дополнительной информации";
$MESS["ACRIT_EXPORTPRO_WIKIMART_BOOK_FIELD_UTM_CAMPAIGN"] = "UTM метка: название рекламной кампании";
$MESS["ACRIT_EXPORTPRO_TYPE_WIKIMART_BOOK_EXAMPLE"] = "
<offer id=\"12342\" type=\"book\" available=\"true\" bid=\"17\">
    <url>http://best.seller.ru/product_page.asp?pid=14345</url>
    <price>80</price>
    <currencyId>RUR</currencyId>
    <categoryId>3</categoryId>
    <picture>http://best.seller.ru/product_page.asp?pid=14345.jpg</picture>
    <picture>http://best.seller.ru/product_page.asp?pid=14346.jpg</picture>
    <picture>http://best.seller.ru/product_page.asp?pid=14347.jpg</picture>
    <store>false</store>
    <pickup>false</pickup>
    <author>Александра Маринина</author>
    <name>Все не так. В 2 томах. Том 1</name>
    <publisher>Эксмо</publisher>
    <series>А. Маринина — королева детектива</series>
    <year>2007</year>
    <ISBN>978-5-699-23647-3</ISBN>
    <volume>2</volume>
    <part>1</part>
    <language>rus</language>
    <binding>70x90/32</binding>
    <page_extent>288</page_extent>
    <description>Все прекрасно в большом патриархальном семействе
    Руденко. Но — увы! — впечатление это обманчиво: каждого из многочисленных
    представителей семьи обуревают свои потаенные 
    страсти и запретные желания.</description>
    <age unit=\"year\">18</age>
</offer>
";
?>