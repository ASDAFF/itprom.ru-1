<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
__IncludeLang($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/lang/".LANGUAGE_ID."/ajax.php", false, true);
if (!CModule::IncludeModule('bitlate.toolsshop')) return false;

if ($_SERVER["REQUEST_METHOD"]=="POST" && check_bitrix_sessid())
{
	$arResult = array();
    $arResult['success'] = false;
    switch ($_POST["action"])
	{
		case 'check':
			if (intval($_POST["ID"]) > 0 && CModule::IncludeModule('bitlate.toolsshop') && CModule::IncludeModule('catalog')) {
				$productId = $_POST["ID"];
				$offerId = 0;
				$QUANTITY = (intval($_POST["QUANTITY"]) > 0) ? intval($_POST["QUANTITY"]) : 1;
				$arElements = NLApparelshopUtils::getFavorits();
                $curCount = NLApparelshopUtils::getCountFavorits();
				$mxResult = CCatalogSku::GetProductInfo($productId);
				if (is_array($mxResult)) {
					$offerId = $productId;
					$productId = $mxResult['ID'];
				}
				$arResult['success'] = true;
                if ($arElements[$productId][$offerId] > 0) {
					unset($arElements[$productId][$offerId]);
					if (count($arElements[$productId]) == 0) {
						unset($arElements[$productId]);
					}
					$arResult['type'] = 'delete';
                    $curCount -= $QUANTITY;
				} else {
					$arElements[$productId][$offerId] = $QUANTITY;
                    $arResult['type'] = 'add';
                    $curCount += $QUANTITY;
				}
                NLApparelshopUtils::setFavorits($arElements);
                $arResult['count'] = $curCount;
			}
			break;
	}
    echo json_encode($arResult);
    die();
} else {
    $APPLICATION->IncludeFile(
        SITE_DIR . "include/favorites.php",
        Array(
            'USER_FAVORITES' => NLApparelshopUtils::getFavorits(),
        )
    );
}