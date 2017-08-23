<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arServices = Array(
    'main' => Array(
        'NAME' => GetMessage("NL_SERVICE_MAIN_SETTINGS"),
        'STAGES' => Array(
            "files.php",
            "template.php",
            "theme.php",
            "users.php"
        ),
    ),
    "form" => Array(
        "NAME" => GetMessage("NL_SERVICE_FORM"),
        "STAGES" => Array(
            "form.php",
        ),
    ),
    "iblock" => Array(
        "NAME" => GetMessage("NL_SERVICE_IBLOCK_DEMO_DATA"),
        "STAGES" => Array(
            "types.php",           //типы
            "references.php",      //импорт производители
            "references2.php",     //создание hl блока цвета и hl соц сетей
            "references3.php",     //импорт цвета и соц сетей
            "advantages.php",      //импорт преимущества
            "news.php",            //импорт новости
            "catalog.php",         //импорт товаров
            "catalog2.php",        //импорт предложений
            "catalog3.php",        //настройка каталога
            "slider.php",          //импорт слайдер
            "actions.php",         //импорт акции
            "buy1click.php",       //создание ИБ купить в 1 клик
            "team.php",            //создание ИБ купить в 1 клик
            "vacancy.php",         //создание ИБ купить в 1 клик
            "services.php",        //создание ИБ купить в 1 клик
            "service_order.php",   //создание ИБ купить в 1 клик
            "config.php",           //перенос настроек
        ),
    ),
    "blog" => Array(
        "NAME" => GetMessage("NL_SERVICE_BLOG"),
        "STAGES" => Array(
            "blog.php",
        ),
    ),
    "sale" => Array(
        "NAME" => GetMessage("NL_SERVICE_SALE"),
        "STAGES" => Array(
            "locations.php",
            "step1.php",
            "step2.php",
            "step3.php",
        ),
    ),
);
?>