<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->AddHeadScript('https://code.jquery.com/jquery-latest.min.js');
$fancypath = '/bitrix/templates/webfly_san/js/fancybox/';

$APPLICATION->AddHeadScript($fancypath . "lib/jquery.mousewheel-3.0.6.pack.js");
$APPLICATION->AddHeadScript($fancypath . 'source/jquery.fancybox.pack.js?v=2.1.5');
$APPLICATION->SetAdditionalCSS($fancypath . 'source/jquery.fancybox.css?v=2.1.5');
//helpers etc
$APPLICATION->SetAdditionalCSS($fancypath . 'source/helpers/jquery.fancybox-buttons.css?v=1.0.5');
$APPLICATION->AddHeadScript($fancypath . "source/helpers/jquery.fancybox-buttons.js?v=1.0.5");
$APPLICATION->AddHeadScript($fancypath . "source/helpers/jquery.fancybox-media.js?v=1.0.6");

$APPLICATION->SetAdditionalCSS($fancypath . 'source/helpers/jquery.fancybox-thumbs.css?v=1.0.7');
$APPLICATION->AddHeadScript($fancypath . "source/helpers/jquery.fancybox-thumbs.js?v=1.0.7");

$APPLICATION->SetTitle("Сертификаты");


?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("a.fancyimages").fancybox();
        });
    </script>

<div class="content-text-inner">
    <h1>Сертификаты</h1>
    <p>
        Компания ITProm уже много лет предоставляет свои услуги и продукцию клиентам на рынке. Мы обеспечиваем покупателей широким ассортиментом качественного недорогого оборудования. Наша организация работает не только в пределах Российской Федерации, но и имеет выходы в страны СНГ.
    </p>
    <br>
    <p style="width:100%; text-align:center;">
        <a class="fancyimages" href="/upload/medialibrary/c42/c42a62894cd7da2cc227c95ce9bfef0e.png"> <img alt="Свидетельство на товарный знак ITProm" src="/upload/medialibrary/c42/c42a62894cd7da2cc227c95ce9bfef0e.png" title="Свидетельство на товарный знак ITProm" style="width:17%; margin-right:3%;> </a> <a class=" href=" /upload/medialibrary/a4d/a4dd298ec60a75a96cc46a5412095afe.png"> <img alt="Свидетельство на товарный знак ITProm" src="/upload/medialibrary/a4d/a4dd298ec60a75a96cc46a5412095afe.png" style="width:17%; margin-right:3%;" title="Свидетельство на товарный знак ITProm"> </a> <a class="fancyimages" href="/upload/medialibrary/f7c/f7c96766e0398fd8207b3eae8d660892.jpg"> <img src="/upload/medialibrary/f7c/f7c96766e0398fd8207b3eae8d660892.jpg" style="width:17%; margin-right:3%;" title="Сертификаты" alt="Сертификаты"> </a> <a class="fancyimages" href="/upload/medialibrary/d01/d01cd4993e5f6802e8341cf1a148c8ca.png"> <img src="/upload/medialibrary/d01/d01cd4993e5f6802e8341cf1a148c8ca.png" style="width:17%; margin-right:3%;" title="Сертификаты" alt="Сертификаты"> </a> <a class="fancyimages" href="/upload/medialibrary/598/5983d4292b55718b114c8095a30dbc77.png"> <img src="/upload/medialibrary/598/5983d4292b55718b114c8095a30dbc77.png" style="width:17%; margin-right:3%;" title="Сертификаты" alt="Сертификаты"> </a> <a class="fancyimages" href="/upload/medialibrary/150/150880f07c0db702f73c97c743767967.jpg"> <img src="/upload/medialibrary/150/150880f07c0db702f73c97c743767967.jpg" style="width:17%; margin-right:3%;" title="Сертификаты" alt="Сертификаты"> </a> <a class="fancyimages" href="/upload/medialibrary/1ee/1ee42fb7c7a49b9bae3d0b980beedd61.jpg"><img alt="Сертификат таможенного союза на соответствие" src="/upload/medialibrary/1ee/1ee42fb7c7a49b9bae3d0b980beedd61.jpg" style="width:17%; margin-right:3%;" title="Сертификат таможенного союза на соответствие"> </a>

        <a class="fancyimages" href="/upload/medialibrary/bd2/bd2a7f17a04c31aa4d693429963a8ac0.jpg"><img style="width:17%; margin-right:3%;" alt="Сертификат Риттал ИТПРОМ" src="/upload/medialibrary/bd2/bd2a7f17a04c31aa4d693429963a8ac0.jpg" title="Сертификат Риттал ИТПРОМ"> </a> <br>

    </p>
    <h2>
        Быть лучшими — это не призвание, а тяжелый труд </h2>
    <p>
        Фирма все время увеличивает рынок сбыта оборудования. Тщательно следя за современными мировыми тенденциями, мы добились того, что ITProm стала известным брендом. Компания не гнушается обмениваться опытом с зарубежными партнерами, заимствовать и успешно применять технологические улучшения. Учась на собственных и чужих ошибках, нам удалось вывести идеальную формулу между качеством, ценой и обслуживанием потребителя. Для нас в первую очередь важно доверие клиентов, их заинтересованность в дальнейшем сотрудничестве с ITProm. Компания стала лучшей по причине того, что мы представляем себя на месте покупателя. Хотел бы кто-то из нас получить некачественный товар за большие деньги? Конечно, нет. Наши клиенты чувствуют такое отношение к себе и рекомендуют нас своим партнерам.
    </p>
    <h2>
        В чем секрет продуктивной деятельности ITProm? </h2>
    <p>
        Чтобы занимать лидирующую позицию на рынке, фирме пришлось пройти долгий путь. Секрет нашего успеха заключается в том, что мы не гонимся за прибылью в ущерб качеству продукции. Товар полностью сертифицирован и соответствует всем международным стандартам. Все изделия прошли лабораторные испытания. Это гарантирует, что они абсолютно безопасны в эксплуатации.
    </p>
    <p>
        Благодаря тому, что мы предлагаем покупателям полный пакет услуг, начиная с проектирования и заканчивая обслуживанием, клиенты могут быть абсолютно уверены в надежности сервиса на каждом этапе.
    </p>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>