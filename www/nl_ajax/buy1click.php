<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
__IncludeLang($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/lang/" . LANGUAGE_ID . "/ajax.php", false, true);

CModule::IncludeModule('bitlate.toolsshop');
$arResult = array();
$arResult['success'] = 'N';

if ($_SERVER["REQUEST_METHOD"] == "POST" && check_bitrix_sessid()) {
    $postData = NLApparelshopUtils::prepareRequest($_POST);
    $arResult['post'] = $postData;
    $name = trim($postData["NAME"]);
    $phone = trim($postData["PHONE"]);
    $propsArray = json_decode(base64_decode($postData["props"]));
    if (strlen($name) < 3 || preg_match('/[0-9.-]/i', $name)) {
        $arResult['error'][] = GetMessage('T_B1C_ERROR_EMPTY_NAME');
    }
    if (strlen($phone) <= 0) {
        $arResult['error'][] = GetMessage('T_B1C_ERROR_EMPTY_PHONE');
    }

    if (empty($arResult['error']) && CModule::IncludeModule('catalog') && CModule::IncludeModule('iblock')) {
        $arFields = array(
            'USER_NAME' => htmlspecialcharsbx($name),
            'USER_PHONE' => htmlspecialcharsbx($phone),
            'EMAIL_TO' => COption::GetOptionString("bitlate.toolsshop", 'NL_REQUEST_CALL_EMAIL', '#DEFAULT_EMAIL_FROM#', SITE_ID),
        );
        $res = CIBlock::GetList(array(), array("SITE_ID" => SITE_ID, "CODE" => "NL_BUY1CLICK_" . SITE_ID, "CHECK_PERMISSIONS" => "N"));
        $arRes = $res->Fetch();
        if ($arRes) {
            $arIblockElementFields = array(
                'IBLOCK_ID' => $arRes["ID"],
                'ACTIVE' => 'Y',
                'PROPERTY_VALUES' => array(
                    'NAME' => $arFields['USER_NAME'],
                    'PHONE' => $arFields['USER_PHONE'],
                ),
            );
            $tmpCart = NLApparelshopUtils::getTopTableBuy1Click();
            $total = 0;
            $currency = 0;
            $productId = intval(json_decode(base64_decode($postData['id'])));
            $offerId = intval(json_decode(base64_decode($postData['offer_id'])));
            if (isset($postData['cart']) && (json_decode(base64_decode($postData['cart'])) == 'Y')) {
                if (CModule::IncludeModule('sale')) {
                    $dbBasketItems = CSaleBasket::GetList(
                        array(
                            "NAME" => "ASC",
                            "ID" => "ASC"
                        ),
                        array(
                            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                            "LID" => SITE_ID,
                            "ORDER_ID" => "NULL"
                        ),
                        false,
                        false,
                        array()
                    );
                    if ($dbBasketItems->SelectedRowsCount() > 0) {
                        $couponsList = array();
                        while ($arItem = $dbBasketItems->Fetch()) {
                            if ($arItem['DISCOUNT_COUPON'] != '') {
                                $couponsList[$arItem['DISCOUNT_COUPON']] = $arItem['DISCOUNT_COUPON'];
                            }
                            $dbRes = CIBlockElement::GetByID($arItem['PRODUCT_ID']);
                            if ($arRes = $dbRes->GetNext()) {
                                $arIblockElementFields['PROPERTY_VALUES']['PRODUCTS'][] = $arItem['PRODUCT_ID'];
                                $mxResult = CCatalogSKU::GetInfoByOfferIBlock($arRes['IBLOCK_ID']);
                                $propsStr = "";
                                if ($mxResult !== false) {
                                    $propsStr = NLApparelshopUtils::getPropsStr($arItem['PRODUCT_ID'], $mxResult['PRODUCT_IBLOCK_ID'], $propsArray);
                                }
                                $onePrice = strip_tags(CCurrencyLang::CurrencyFormat($arItem['PRICE'], $arItem['CURRENCY']));
                                $totalPrice = strip_tags(CCurrencyLang::CurrencyFormat($arItem['PRICE'] * $arItem['QUANTITY'], $arItem['CURRENCY']));
                                $tmpCart .= NLApparelshopUtils::getRowTableBuy1Click($arItem['PRODUCT_ID'], $arItem['DETAIL_PAGE_URL'], $arItem['NAME'], $propsStr, $arItem['QUANTITY'], $onePrice, $totalPrice);
                                $total += $arItem['PRICE'] * $arItem['QUANTITY'];
                                $currency = $arItem['CURRENCY'];
                                $arIblockElementFields['PROPERTY_VALUES']['PRODUCTS'][] = $arItem['PRODUCT_ID'];
                            }
                        }
                        $tmpCart .= NLApparelshopUtils::getBottomTableBuy1Click(CCurrencyLang::CurrencyFormat($total, $currency));
                        if ($couponsList) {
                            $tmpCart = GetMessage('T_B1C_COUPON') . implode(', ', $couponsList) . '<br /><br />' . $tmpCart;
                        }
                        $arFields['CART_ITEMS'] = $tmpCart;
                        $arIblockElementFields['NAME'] = GetMessage('T_B1C_TOTAL_TEXT') . strip_tags(CCurrencyLang::CurrencyFormat($total, $currency));

                        if ($total > 0) {
                            $el = new CIBlockElement;
                            if ($orderId = $el->Add($arIblockElementFields)) {
                                CEvent::Send('NL_BUY1CLICK_' . SITE_ID, SITE_ID, $arFields, "Y");
                            } else {
                                $arResult['error'][] = GetMessage('T_B1C_ERROR_ADD');
                            }
                        } else {
                            $arResult['error'][] = GetMessage('T_B1C_ERROR_ADD_EMPTY_CART');
                        }
                    } else {
                        $arResult['error'][] = GetMessage('T_B1C_ERROR_ADD_EMPTY_CART');
                    }
                }
            } elseif ($productId > 0) {
                $dbRes = CIBlockElement::GetByID($productId);
                if ($arRes = $dbRes->GetNext()) {
                    $quantity = (intval($postData["quantity"]) > 0) ? intval($postData["quantity"]) : 1;
                    $itemId = ($offerId > 0) ? $offerId : $productId;
                    $currency = json_decode(base64_decode($postData["currency"]));
                    $price = json_decode(base64_decode($postData["price"]));
                    $onePrice = strip_tags(CCurrencyLang::CurrencyFormat($price, $currency));
                    $totalPrice = strip_tags(CCurrencyLang::CurrencyFormat($price * $quantity, $currency));
                    $arIblockElementFields['PROPERTY_VALUES']['PRODUCTS'][] = $itemId;
                    $propsStr = ($offerId > 0) ? NLApparelshopUtils::getPropsStr($offerId, $arRes['IBLOCK_ID'], $propsArray) : "";
                    $arIblockElementFields['NAME'] = GetMessage('T_B1C_TOTAL_TEXT') . $totalPrice;
                    $tmpCart .= NLApparelshopUtils::getRowTableBuy1Click($arRes['ID'], $arRes['DETAIL_PAGE_URL'], $arRes['NAME'], $propsStr, $quantity, $onePrice, $totalPrice);
                    $tmpCart .= NLApparelshopUtils::getBottomTableBuy1Click($totalPrice);
                    $arFields['CART_ITEMS'] = $tmpCart;
                    $el = new CIBlockElement;
                    $orderId = $el->Add($arIblockElementFields);
                    if ($orderId) {
                        CEvent::Send('NL_BUY1CLICK_' . SITE_ID, SITE_ID, $arFields, "Y");
                    } else {
                        $arResult['error'][] = GetMessage('T_B1C_ERROR_ADD');
                    }
                } else {
                    $arResult['error'][] = GetMessage('T_B1C_ERROR_ADD');
                }
            } else {
                $arResult['error'][] = GetMessage('T_B1C_ERROR_ADD');
            }
        } else {
            $arResult['error'][] = GetMessage('T_B1C_ERROR_ADD');
        }
    }
    
    if (empty($arResult['error'])) {
        $arResult['message'] = COption::GetOptionString("bitlate.toolsshop", 'NL_BUY1CLICK_OKKADD_MESS', GetMessage('T_B1C_SUCCESS_ADD'), SITE_ID);
        $arResult['post'] = array();
    }
} else {
    $arResult['error'][] = GetMessage('T_B1C_ERROR_ADD');
}
$APPLICATION->IncludeFile(
    SITE_DIR."include/popup/buy1click.php",
    Array(
        'arResult' => $arResult,
    )
);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?> 