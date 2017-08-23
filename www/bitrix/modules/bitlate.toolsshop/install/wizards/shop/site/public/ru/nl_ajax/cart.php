<?
define("NOT_CHECK_PERMISSIONS", true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
__IncludeLang($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/lang/".LANGUAGE_ID."/ajax.php", false, true);

$arResult = array();
$arResult['success'] = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && check_bitrix_sessid())
{
    switch ($_POST["action"])
    {
        case 'quantity':
            if (\Bitrix\Main\Loader::includeModule("sale")) {
                CModule::IncludeModule('bitlate.toolsshop');
                $id = intval($_POST['id']);
                $quantity = $_POST['quantity'];
                if ($id > 0) {
                    $dbBasketItems = CSaleBasket::GetList(
                        array(),
                        array(
                            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                            "LID" => SITE_ID,
                            "ORDER_ID" => "NULL",
                            "ID" => $id,
                        ),
                        false,
                        false,
                        array('ID', 'DELAY', 'CAN_BUY', 'SET_PARENT_ID', 'TYPE')
                    );
                    $arItem = $dbBasketItems->Fetch();
                    if ($arItem && !CSaleBasketHelper::isSetItem($arItem)) {
                        $isFloatQuantity = ((isset($arItem["MEASURE_RATIO"]) && floatval($arItem["MEASURE_RATIO"]) > 0 && $arItem["MEASURE_RATIO"] != 1) || $_POST['useFloatQuantity'] == "Y") ? true : false;
                        $quantity = ($isFloatQuantity === true) ? floatval($quantity) : intval($quantity);
                        if (CSaleBasket::Update($arItem["ID"], array('QUANTITY' => $quantity))) {
                            $arResult['success'] = true;
                            $arResult['item_count'] = 0;
                            $total = 0;
                            $currency = '';
                            $dbRes = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "ORDER_ID" => "NULL", "LID" => SITE_ID));
                            while ($arRes = $dbRes->Fetch()) {
                                $arResult['item_count']++;
                                $total += $arRes['PRICE']*$arRes['QUANTITY'];
                                $currency = $arRes['CURRENCY'];
                                if ($arRes['ID'] == $arItem['ID']) {
                                    $arResult['full_price'] = CCurrencyLang::CurrencyFormat($arRes['PRICE']*$arRes['QUANTITY'], $arRes['CURRENCY']);
                                }
                            }
                            $arResult['total'] = CCurrencyLang::CurrencyFormat($total, $currency);
                            $arResult['product_total'] = $arResult['item_count'].' '.NLApparelshopUtils::nl_inclination($arResult['item_count'], GetMessage("NL_PRODUCT_1"), GetMessage("NL_PRODUCT_2"), GetMessage("NL_PRODUCT_10")) . ' ' . GetMessage("NL_ON") . ' ' . $arResult['total'];
                        }
                    }
                }
            } 
            else
                $arResult['error'][] = 'module_include';
            break;
        case 'delete':
            if (\Bitrix\Main\Loader::includeModule("sale")) {
                $id = intval($_POST['id']);
                if ($id > 0) {
                    $dbBasketItems = CSaleBasket::GetList(
                        array(),
                        array(
                            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                            "LID" => SITE_ID,
                            "ORDER_ID" => "NULL",
                            "ID" => $id,
                        ),
                        false,
                        false,
                        array('ID', 'DELAY', 'CAN_BUY', 'SET_PARENT_ID', 'TYPE')
                    );
                    $arItem = $dbBasketItems->Fetch();
                    if ($arItem && !CSaleBasketHelper::isSetItem($arItem)) {
                        if (CSaleBasket::Delete($arItem["ID"])) {
                            $arResult['success'] = true;
                        }
                    }
                }
            } 
            else
                $arResult['error'][] = 'module_include';
            break;
    }
}
echo json_encode($arResult);
die();