<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Доставка");?>
<h2>Способы доставки</h2>
<p>Мы работаем с рядом российских компани по доставке товаров в пределах Российской Федерации и стран СНГ. Ниже приведены примерная стоимость и сроки доставки</p>
<ul class="inner-content-list row large-up-2">
    <li class="inner-content-delivery columns table-container">
        <div class="preview table-item vertical-top">
            <img src="#SITE_TEMPLATE_PATH#/images/delivery-russianpost.jpg" alt="">
        </div>
        <div class="table-item">
            <div class="param name">Почта России</div>
            <div class="param">Срок доставки: <span class="warning">10-15 дней</span></div>
            <div class="param">Стоимость: <span class="warning">от 350 рублей</span></div>
        </div>
    </li>
    <li class="inner-content-delivery columns table-container">
        <div class="preview table-item vertical-top">
            <img src="#SITE_TEMPLATE_PATH#/images/delivery-ems.jpg" alt="">
        </div>
        <div class="table-item">
            <div class="param name">EMS</div>
            <div class="param">Срок доставки: <span class="warning">5-10 дней</span></div>
            <div class="param">Стоимость: <span class="warning">от 500 рублей</span></div>
        </div>
    </li>
    <li class="inner-content-delivery columns table-container">
        <div class="preview table-item vertical-top">
            <img src="#SITE_TEMPLATE_PATH#/images/delivery-spsr.jpg" alt="">
        </div>
        <div class="table-item">
            <div class="param name">СПСР-Экспресс</div>
            <div class="param">Срок доставки: <span class="warning">3-15 дней</span></div>
            <div class="param">Стоимость: <span class="warning">от 750 рублей</span></div>
            <div class="param">Дополнительно: <span class="add">Возможность примерки</span></div>
        </div>
    </li>
    <li class="inner-content-delivery columns table-container">
        <div class="preview table-item vertical-top">
            <img src="#SITE_TEMPLATE_PATH#/images/delivery-dhl.jpg" alt="">
        </div>
        <div class="table-item">
            <div class="param name">DHL</div>
            <div class="param">Срок доставки: <span class="warning">2-5 дней</span></div>
            <div class="param">Стоимость: <span class="warning">от 1500 рублей</span></div>
            <div class="param">Дополнительно: <span class="add">Бесплатный возврат, частичный выкуп</span></div>
        </div>
    </li>
    <li class="inner-content-delivery columns table-container">
        <div class="preview table-item vertical-top">
            <img src="#SITE_TEMPLATE_PATH#/images/delivery-ups.jpg" alt="">
        </div>
        <div class="table-item">
            <div class="param name">UPS</div>
            <div class="param">Срок доставки: <span class="warning">3-15 дней</span></div>
            <div class="param">Стоимость: <span class="warning">от 1750 рублей</span></div>
        </div>
    </li>
    <li class="inner-content-delivery columns table-container">
        <div class="preview table-item vertical-top">
            <img src="#SITE_TEMPLATE_PATH#/images/delivery-pony-express.jpg" alt="">
        </div>
        <div class="table-item">
            <div class="param name">Pony Express</div>
            <div class="param">Срок доставки: <span class="warning">10-15 дней</span></div>
            <div class="param">Стоимость: <span class="warning">от 950 рублей</span></div>
            <div class="param">Дополнительно: <span class="add">Доставка габартиных грузов</span></div>
        </div>
    </li>
</ul>
<h2>Самовывоз</h2>
<p>Вы также можете забрать посылку в одном из наших пунктов выдачи</p>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.store",
    "",
    Array(
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "COMPONENT_TEMPLATE" => ".default",
        "MAP_TYPE" => "0",
        "PHONE" => "Y",
        "SCHEDULE" => "Y",
        "SEF_FOLDER" => "#SITE_DIR#company/shops/",
        "SEF_MODE" => "Y",
        "SEF_URL_TEMPLATES" => Array("element"=>"#store_id#.html","liststores"=>"index.php"),
        "SET_TITLE" => "N",
        "TITLE" => "Список складов с подробной информацией"
    )
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>