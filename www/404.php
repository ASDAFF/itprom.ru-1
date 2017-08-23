<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
?>
<section class="not-found">
    <div class="advanced-container-medium">
        <div class="inline-block-container">
            <div class="inline-block-item large-6 vertical-middle not-found-index">404</div>
            <div class="inline-block-item large-6 vertical-middle not-found-desc">
                <h1>Ошибка 404<span class="hide-for-large"> — </span><br class="show-for-large">Страница не найдена</h1>
                <p>Такой страницы не существует или неправильно набран адрес.</p>
                <div>
                    <a href="<?=SITE_DIR?>" class="button primary">Перейти на главную</a>
                    или <a href="javascript:history.back();">вернуться назад</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>