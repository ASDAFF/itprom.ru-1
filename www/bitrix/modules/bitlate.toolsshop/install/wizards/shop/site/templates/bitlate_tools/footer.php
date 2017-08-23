<?IncludeTemplateLangFile(__FILE__);
if (!CModule::IncludeModule('bitlate.toolsshop')) return false;
if (!$templateOptions) {
    $templateOptions = NLApparelshopUtils::initTemplateOptions();
}?>
        <?if (ERROR_404 != "Y" && (strpos($APPLICATION->GetCurDir(), $templateOptions['url_catalog']) === false || strpos($APPLICATION->GetCurDir(), $templateOptions['url_catalog_search']) === 0)):?>
                <?if ($APPLICATION->GetCurDir() == SITE_DIR):?>
                <?elseif (strpos($APPLICATION->GetCurDir(), SITE_DIR . 'company/') === 0 || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'shop/') === 0 || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'info/') === 0):?>
                            </div>
                        </article>
                    </div>
                <?elseif (($APPLICATION->GetCurDir() == SITE_DIR . 'personal/' || $APPLICATION->GetCurDir() == SITE_DIR . 'personal/profile/') && $USER->IsAuthorized()):?>
                            </article>
                        </div>
                    </div>
                <?elseif ($APPLICATION->GetCurDir() == SITE_DIR . 'personal/' || $APPLICATION->GetCurDir() == SITE_DIR . 'personal/profile/'):?>
                            </article>
                        </div>
                    </div>
                <?elseif ($APPLICATION->GetCurDir() == SITE_DIR . 'personal/cart/' || strpos($APPLICATION->GetCurDir(), SITE_DIR . 'personal/order/') === 0):?>
                        </div>
                    </div>
                <?else:?>
                        </article>
                    </div>
                <?endif;?>
            </section>
        <?endif;?>
        <footer>
            <div class="footer-line-top">
                <div class="advanced-container-medium footer-line-top-container row large-up-2 xlarge-up-3">
                    <div class="show-for-large column">
                        <?$APPLICATION->IncludeFile(
                            SITE_DIR . "include/social_links.php",
                            Array()
                        );?>
                    </div>
                    <div class="column" id="bx_subscribe_small">
                        <?$frame = new \Bitrix\Main\Page\FrameHelper("bx_subscribe_small", false);
                        $frame->begin();?>
                            <?$APPLICATION->IncludeFile(
                                SITE_DIR . "include/popup/subscribe.php",
                                Array(
                                    'TEMPLATE' => 'small',
                                    'SET_TITLE' => 'N',
                                )
                            );?>
                        <?$frame->beginStub();?>
                        <?$frame->end();?>
                    </div>
                    <div class="show-for-xlarge column">
                        <div class="float-right">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "PATH" => SITE_DIR . "include/pay.php"
                                )
                            );?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-main">
                <div class="advanced-container-medium inline-block-container text-center">
                    <div class="footer-info inline-block-item">
                        <a href="<?=SITE_DIR?>" class="footer-info-logo">
                            <?$APPLICATION->IncludeFile(
                                SITE_DIR . "include/logo.php",
                                Array(
                                    "PATH_TO_LOGO" => "/local/templates/" . SITE_TEMPLATE_ID . "/themes/" . $templateOptions['theme'] . "/images/logo.png",
                                )
                            );?>
                        </a>
                        <div class="footer-info-phone">
                            <div class="footer-info-phone-number"><?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    Array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "PATH" => SITE_DIR . "include/phone.php"
                                    )
                                );?></div>
                            <div class="footer-info-phone-link"><a href="javascript:;"><?=getMessage('REQUEST_CALL')?></a></div>
                        </div>
                        <?$orderEmail = COption::GetOptionString("sale", "order_email");
                        if ($orderEmail):?>
                            <a class="footer-info-mail" href="mailto:<?=$orderEmail?>"><?=$orderEmail?></a>
                        <?endif;?>
                    </div>
                    <nav class="footer-main-menu inline-block-item show-for-xlarge">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu", 
                            "footer", 
                            array(
                                "ROOT_MENU_TYPE" => "main_bottom",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "2",
                                "USE_EXT" => "Y",
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "bottom",
                                "DELAY" => "N"
                            ),
                            false
                        );?>
                    </nav>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="advanced-container-medium">
                    <div class="footer-copyright-company"><?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "PATH" => SITE_DIR . "include/copyright.php"
                        )
                    );?></div>
                    <div class="footer-copyright-design"><?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "PATH" => SITE_DIR . "include/developer.php"
                        )
                    );?></div>
                </div>
            </div>
        </footer>
        <a href="javascript:;" class="scroll-up-down button">
            <svg class="icon">
                <use xlink:href="#svg-icon-up-down"></use>
            </svg>
        </a>
        <div id="bx_fancybox_blocks">
            <?$frame = new \Bitrix\Main\Page\FrameHelper("bx_fancybox_blocks");
            $frame->begin();?>
                <?$APPLICATION->IncludeComponent("bitrix:main.include", "", 
                    array(
                        "AREA_FILE_SHOW" => "file", 
                        "PATH" => SITE_DIR."include/popup/service_order.php"
                    ),
                false);?>
                <?$APPLICATION->IncludeComponent("bitrix:main.include", "", 
                    array(
                        "AREA_FILE_SHOW" => "file", 
                        "PATH" => SITE_DIR."include/popup/request_call.php"
                    ),
                false);?>
                <?$APPLICATION->IncludeFile(
                    SITE_DIR . "include/favorites.php",
                    Array(
                        'USER_FAVORITES' => NLApparelshopUtils::getFavorits(),
                    )
                );?>
                <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
                array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => SITE_DIR."include/popup/buy1click.php"
                ),
                false);?>
                <?if (!$USER->IsAuthorized()):?>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/popup/login.php"
                        ),
                    false);?>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/popup/registration.php"
                    ),
                    false);?>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/popup/forgotpasswd.php"
                    ),
                    false);?>
                <?elseif ($USER->IsAuthorized() && $APPLICATION->GetCurDir() == SITE_DIR . 'personal/'):?>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/popup/profile_user_password.php"
                        ),
                        false
                    );?>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/popup/profile_user.php"
                        ),
                        false
                    );?>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/popup/profile.php"
                        ),
                    false);?>
                    <?$APPLICATION->IncludeFile(
                        SITE_DIR . "include/popup/history.php",
                        Array(
                            'POPUP' => 'Y',
                            'ORDERS_PER_PAGE' => '999',
                        )
                    );?>
                <?endif;?>
            <?$frame->beginStub();?>
            <?$frame->end();?>
        </div>
    </div>
</body>
</html>