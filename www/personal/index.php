<?
define('NEED_AUTH', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<div class="profile-column-container large-up-2 xlarge-up-3">
    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
        array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR . "include/popup/profile_user_info.php"
        ),
        false
    );?>
    <?if (CModule::IncludeModule('bitlate.toolsshop')):?>
        <div class="column profile-column-item" data-order="2">
            <div class="profile-block">
                <div class="profile-block-caption">
                    <svg class="icon">
                        <use xlink:href="#svg-icon-liked"></use>
                    </svg>
                    Избранное
                </div>
                <div class="profile-block-wrap">
                    <?if ($countFav = NLApparelshopUtils::getCountFavorits()):?>
                        <p>У Вас в избранном <?=$countFav?> <?=NLApparelshopUtils::nl_inclination($countFav, 'товар', 'товара', 'товаров')?></p>
                        <a href="#liked" class="button small secondary fancybox">Изменить</a>
                    <?else:?>
                        <p>У Вас нет товаров в избранном</p>
                    <?endif;?>
                </div>
            </div>
        </div>
    <?endif;?>
    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
        array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR . "include/popup/profile_list.php"
        ),
        false
    );?>
    <?$APPLICATION->IncludeFile(
        SITE_DIR . "include/popup/subscribe.php",
        Array(
            'TEMPLATE' => '',
            'SET_TITLE' => 'N',
        )
    );?>
    <?$APPLICATION->IncludeFile(
        SITE_DIR . "include/popup/history.php",
        Array(
            'POPUP' => 'N',
            'ORDERS_PER_PAGE' => '2',
        )
    );?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>