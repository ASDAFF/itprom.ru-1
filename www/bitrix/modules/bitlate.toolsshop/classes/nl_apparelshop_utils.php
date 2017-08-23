<?php
__IncludeLang($_SERVER['DOCUMENT_ROOT'] . "/local/templates/bitlate_tools/lang/" . LANGUAGE_ID . "/ajax.php", false, true);
if (!class_exists('NLApparelshopUtils')) {
class NLApparelshopUtils
{
    public static function getThemeList() {
        return array(
            // 5 - default
            0 => array(
                'CODE' => 'indigo_red',
                'COLOR_1' => '#264f85',
                'COLOR_2' => '#d8192b',
            ),
            1 => array(
                'CODE' => 'green_red',
                'COLOR_1' => '#28ab5c',
                'COLOR_2' => '#ee4a39',
            ),
            2 => array(
                'CODE' => 'blue_red',
                'COLOR_1' => '#45a9c2',
                'COLOR_2' => '#f7627a',
            ),
            3 => array(
                'CODE' => 'indigo_orange',
                'COLOR_1' => '#10599b',
                'COLOR_2' => '#ff6f02',
            ),
            4 => array(
                'CODE' => 'black_yellow',
                'COLOR_1' => '#222222',
                'COLOR_2' => '#ffc601',
            ),
            5 => array(
                'CODE' => 'brown_red',
                'COLOR_1' => '#533f34',
                'COLOR_2' => '#c02344',
            ),
        );
    }
    
    public static function getGenerateOptions() {
        return array(
            'NL_CATALOG_TYPE',
            'NL_CATALOG_ID',
            'NL_CATALOG_OFFERS_TYPE',
            'NL_CATALOG_OFFERS_ID',
            'NL_CATALOG_PROPERTY_CODE',
            'NL_CATALOG_OFFERS_PROPERTY_CODE',
            'NL_CATALOG_CART_PRODUCT_PROPERTIES_CODE',
            'NL_CATALOG_CART_OFFERS_PROPERTY_CODE',
            'NL_CATALOG_PRICE_CODE',
            'NL_HIDE_NOT_AVAILABLE',
            'NL_CATALOG_COMPONENT_TEMPLATE',
            'NL_CATALOG_MAIN_LIST',
            'NL_CATALOG_ADD_PICT_PROP',
            'NL_CATALOG_OFFER_ADD_PICT_PROP',
            'NL_CATALOG_SORT_LIST_CODES',
            'NL_CATALOG_SORT_LIST_FIELDS',
            'NL_CATALOG_SORT_LIST_ORDERS',
            'NL_CATALOG_SORT_LIST_NAME',
            'NL_CATALOG_USE_COMPARE',
            'NL_CATALOG_USE_AMOUNT',
            'NL_CATALOG_STORES',
            'NL_CATALOG_USE_MIN_AMOUNT',
            'NL_CATALOG_MIN_AMOUNT',
            'NL_CATALOG_MAX_AMOUNT',
            'NL_CATALOG_USE_BIG_DATA',
            'NL_CATALOG_BIG_DATA_RCM_TYPE',
            'NL_CATALOG_PAGE_TO_LIST',
            'NL_CATALOG_SEF_FOLDER',
            'NL_CATALOG_SEF_URL_TEMPLATES_SECTIONS',
            'NL_CATALOG_SEF_URL_TEMPLATES_SECTION',
            'NL_CATALOG_SEF_URL_TEMPLATES_ELEMENT',
            'NL_CATALOG_SEF_URL_TEMPLATES_COMPARE',
            'NL_CATALOG_SEF_URL_TEMPLATES_SEARCH',
            'NL_SET_STATUS_404',
            'NL_SHOW_404',
            'NL_MESSAGE_404',
            'NL_SLIDER_PAGE_ELEMENT_COUNT',
            'NL_SLIDER_ELEMENT_SORT_FIELD',
            'NL_SLIDER_ELEMENT_SORT_ORDER',
            'NL_SLIDER_ELEMENT_SORT_FIELD2',
            'NL_SLIDER_ELEMENT_SORT_ORDER2',
            'NL_MAIN_TABS_ELEMENT_SORT_FIELD',
            'NL_MAIN_TABS_ELEMENT_SORT_ORDER',
            'NL_MAIN_TABS_ELEMENT_SORT_FIELD2',
            'NL_MAIN_TABS_ELEMENT_SORT_ORDER2',
        );
    }
    
    public static function getMultyOptions() {
        return array(
            'NL_CATALOG_PRICE_CODE',
            'NL_CATALOG_PROPERTY_CODE',
            'NL_CATALOG_OFFERS_PROPERTY_CODE',
            'NL_CATALOG_CART_PRODUCT_PROPERTIES_CODE',
            'NL_CATALOG_CART_OFFERS_PROPERTY_CODE',
            'NL_CATALOG_STORES',
            'NL_CATALOG_PAGE_TO_LIST',
            'NL_CATALOG_SORT_LIST_CODES',
            'NL_CATALOG_SORT_LIST_FIELDS',
            'NL_CATALOG_SORT_LIST_ORDERS',
            'NL_CATALOG_SORT_LIST_NAME',
        );
    }
    
    public static function getViewListInfo() {
        return array(
            0 => array(
                'CODE' => 'board',
                'ICON' => 'tile',
                'TITLE' => GetMessage('NL_CATALOG_VIEW_MAIN'),
            ),
            1 => array(
                'CODE' => 'list',
                'ICON' => 'list',
                'TITLE' => GetMessage('NL_CATALOG_VIEW_LIST'),
            ),
            2 => array(
                'CODE' => 'mini',
                'ICON' => 'mini',
                'TITLE' => GetMessage('NL_CATALOG_VIEW_MINI'),
            ),
        );
    }
    
    public static function sendAjaxHeader() {
        if (ToUpper(SITE_CHARSET) != "UTF-8" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: text/html; charset=utf-8');
        }
    }
    
    public static function prepareRequest($data) {
        if (ToUpper(SITE_CHARSET) != "UTF-8" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (is_array($data)) {
                foreach ($data as $k => $val) {
                    $data[$k] = utf8win1251($val);
                }
            } else {
                $data = utf8win1251($data);
            }
        }
        return $data;
    }
    
    public static function nl_highloadblock_sort($a, $b) {
        if ($a['UF_SORT'] == $b['UF_SORT']) return 0;
        return ($a['UF_SORT'] < $b['UF_SORT']) ? -1 : 1;
    }

    public static function nl_truncate_text($text, $size) {
        $size = intval($size);
        if (strlen($text) > $size && $size > 0){
            $text = substr($text, 0, $size);
            $pos = strrpos($text, ' ');
            $text = substr($text, 0, $pos) . '...';
        }
        return $text;
    }

    public static function nl_inclination($n, $s1, $s2, $s3){
        $m = $n % 10;
        $j = $n % 100;
        if ($m == 0 || $m >= 5 || ($j >= 10 && $j <= 20)) return $s3;
        if ($m >= 2 && $m <= 4) return $s2;
        return $s1;
    }
    
    public static function getGenerateFiles() {
        return array("product_tab.php", "product_slider.php", "catalog.php", "favorites.php", "compare_list.php", "search_title.php");
    }
    
    public static function getGenerateDataName() {
        return $_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/bitlate.toolsshop/install/data/";
    }
    
    public static function getGenerateCopyName($templateName) {
        return $_SERVER['DOCUMENT_ROOT'] . "/local/templates/{$templateName}/include/#SITE_ID#/";
    }
    
    public static function getGenerateIncludeName($templateName) {
        return $_SERVER['DOCUMENT_ROOT'] . "/local/templates/{$templateName}/include/";
    }
    
    public static function getGenerateDeleteDir($templateName) {
        return $_SERVER['DOCUMENT_ROOT'] . "/local/templates/{$templateName}/include/#SITE_ID#/delete/";
    }
    
    public static function generateIncludeFile($siteLID, $siteDir, $changeProps = true, $templateName = 'bitlate_main') {
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/wizard.php");
        $generateFiles = self::getGenerateFiles();
        $fileIncludeDir = self::getGenerateIncludeName($templateName);
        if (!file_exists($fileIncludeDir)) {
            mkdir($fileIncludeDir, 0777);
        }
        foreach ($generateFiles as $file) {
            $fileCopyDir = str_replace('#SITE_ID#', $siteLID, self::getGenerateCopyName($templateName));
            $fileCopyName = $fileCopyDir . $file;
            $fileDeleteDir = str_replace('#SITE_ID#', $siteLID, self::getGenerateDeleteDir($templateName));
            $fileDataName = self::getGenerateDataName() . $file;
            if (file_exists($fileDataName)) {
                $i = 0;
                $fileDeleteName = $fileDeleteDir . $file . '_' . $i;
                while (file_exists($fileDeleteName) && $i < 999) {
                    $i++;
                    $fileDeleteName = $fileDeleteDir . $file . '_' . $i;
                }
                if (!file_exists($fileDeleteDir)) {
                    mkdir($fileDeleteDir, 0777);
                }
                if (!file_exists($fileCopyDir)) {
                    mkdir($fileCopyDir, 0777);
                }
                if (file_exists($fileCopyName)) {
                    copy($fileCopyName, $fileDeleteName);
                }
                copy($fileDataName, $fileCopyName);
                $macrosParams = array();
                foreach (self::getGenerateOptions() as $option) {
                    $optionVal = COption::GetOptionString("bitlate.toolsshop", $option, false, $siteLID);
                    if (in_array($option, self::getMultyOptions())) {
                        $valArr = explode('|', $optionVal);
                        $optionVal = "array(\n";
                        foreach ($valArr as $i => $val) {
                            if (!empty($val)) {
                                $optionVal .= "\t\t\t{$i} => \"{$val}\",\n";
                            }
                        }
                        $optionVal .= "\t\t)";
                    }
                    $macrosParams[$option] = $optionVal;
                }
                $macrosParams['SITE_DIR'] = $siteDir;
                $macrosParams['NL_IBLOCK_ID_NEWS'] = COption::GetOptionString("bitlate.toolsshop", "NL_NEWS_ID", false, $siteLID);
                $macrosParams['NL_IBLOCK_ID_ACTIONS'] = COption::GetOptionString("bitlate.toolsshop", "NL_MAIN_ACTIONS_ID", false, $siteLID);
                CWizardUtil::ReplaceMacros($fileCopyName, $macrosParams);
            }
            
        }
        if ($changeProps === true) {
            $catalogIblockId = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_ID", false, $siteLID);
            $mainSliderIblockId = COption::GetOptionString("bitlate.toolsshop", "NL_MAIN_SLIDER_ID", false, $siteLID);
            $mainActionIblockId = COption::GetOptionString("bitlate.toolsshop", "NL_MAIN_ACTIONS_ID", false, $siteLID);
            $dbProp = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $mainSliderIblockId, 'CODE' => 'RELATED_ITEM'));
            while ($arProp = $dbProp->GetNext()) {
                $arFields = Array(
                    "LINK_IBLOCK_ID" => $catalogIblockId,
                );
                $ibp = new CIBlockProperty;
                $ibp->Update($arProp['ID'], $arFields);
            }
            $dbProp = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $mainActionIblockId, 'CODE' => 'ACTION_PRODUCTS'));
            while ($arProp = $dbProp->GetNext()) {
                $arFields = Array(
                    "LINK_IBLOCK_ID" => $catalogIblockId,
                );
                $ibp = new CIBlockProperty;
                $ibp->Update($arProp['ID'], $arFields);
            }
        }
    }
    
    public static function getThemeListCode() {
        $themeList = self::getThemeList();
        $themeCodes = array();
        foreach ($themeList as $themeInfo) {
            $themeCodes[] = $themeInfo['CODE'];
        }
        return $themeCodes;
    }
    
    public static function initTemplateOptions() {
        global $APPLICATION, $USER;
        $result = array();
        if (!empty($_REQUEST['theme']) && $USER->IsAdmin()) {
            if (in_array($_REQUEST['theme'], self::getThemeListCode())) {
                $themeValue = COption::SetOptionString("main", "theme_value", $_REQUEST['theme'], false, SITE_ID);
                LocalRedirect($APPLICATION->GetCurPageParam('', array('theme')));
                die();
            }
        }
        $result['theme'] = COption::GetOptionString("main", "theme_value", false, SITE_ID);
        $result['use_compare'] = COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_USE_COMPARE", false, SITE_ID);
        $result['url_catalog'] = str_replace('#SITE_DIR#', SITE_DIR, COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_SEF_FOLDER", false, SITE_ID));
        $result['url_catalog_search'] = $result['url_catalog'] . str_replace('#SITE_DIR#', SITE_DIR, COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_SEF_URL_TEMPLATES_SEARCH", false, SITE_ID));
        return $result;
    }
    
    public static function getViewList() {
        $result = array();
        $list = self::getViewListInfo();
        foreach ($list as $info) {
            $result[$info['CODE']] = $info['TITLE'];
        }
        return $result;
    }
    
	public static function getTopTableBuy1Click() {
		__IncludeLang($_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . "/lang/" . LANGUAGE_ID . "/ajax.php", false, true);
		$tmpCart = '<table border="1" width="100%" cellpadding="0" cellspacing="0">';
		$tmpCart .= '<tr>';
		$tmpCart .= '<td>ID</td>';
		$tmpCart .= '<td>' . GetMessage('T_B1C_TABLE_NAME') . '</td>';
		$tmpCart .= '<td>' . GetMessage('T_B1C_TABLE_QUANTITY') . '</td>';
		$tmpCart .= '<td>' . GetMessage('T_B1C_TABLE_PRICE') . '</td>';
		$tmpCart .= '<td>' . GetMessage('T_B1C_TABLE_SUM') . '</td>';
		$tmpCart .= '</tr>';
		return $tmpCart;
	}
	
	public static function getRowTableBuy1Click($id, $detailUrl, $name, $params, $quantity, $onePrice, $totalPrice) {
		$name = htmlspecialcharsbx($name);
		$quantity = intval($quantity);
		$tmpCart = '<tr>';
		$tmpCart .= "<td>{$id}</td>";
		$tmpCart .= "<td><a href=\"http://{$_SERVER['HTTP_HOST']}{$detailUrl}\">{$name}</a> {$params}</td>";
		$tmpCart .= "<td>{$quantity}</td>";
		$tmpCart .= "<td>{$onePrice}</td>";
		$tmpCart .= "<td>{$totalPrice}</td>";
		$tmpCart .= '</tr>';
		return $tmpCart;
	}
	
	public static function getBottomTableBuy1Click($totalPrice) {
		$tmpCart = '<tr>';
		$tmpCart .= '<td colspan="4"><b>' . GetMessage('T_B1C_TABLE_TOTAL') . '</b></td>';
		$tmpCart .= '<td>' . $totalPrice . '</td>';
		$tmpCart .= '</tr>';
		$tmpCart .= '</table>';
		return $tmpCart;
	}
	
	public static function getPropsStr($offerId, $iblockId, $propsArray) {
		$propsStrArray = array();
		$productProperties = CIBlockPriceTools::GetOfferProperties(
			$offerId,
			$iblockId,
			$propsArray,
			array()
		);
		if (count($productProperties) > 0) {
			foreach ($productProperties as $prop) {
				$propsStrArray[] .= "{$prop['NAME']}: {$prop['VALUE']}";
			}
		}
		return " (" . implode(", ", $propsStrArray) . ")";
	}
	
	public static function getFavorits() {
        global $USER, $APPLICATION;
        CModule::IncludeModule('iblock');
        CModule::IncludeModule('catalog');
        $arElements = array();
        if (!$USER->IsAuthorized()) {
            $tmpArElements = unserialize($APPLICATION->get_cookie('nl_favorites'));
        } else {
            $idUser = $USER->GetID();
            $rsUser = CUser::GetByID($idUser);
            $arUser = $rsUser->Fetch();
            $tmpArElements = unserialize($arUser['UF_NL_FAVORITES']);
        }
        if (is_array($tmpArElements) && count($tmpArElements) > 0) {
            $arFilter = array(
                "IBLOCK_ID" => COption::GetOptionString("bitlate.toolsshop", "NL_CATALOG_ID", false, SITE_ID),
                "IBLOCK_LID" => SITE_ID,
                "IBLOCK_ACTIVE" => "Y",
                "ACTIVE_DATE" => "Y",
                "ACTIVE" => "Y",
                "CHECK_PERMISSIONS" => "Y",
                "MIN_PERMISSION" => "R",
                "INCLUDE_SUBSECTIONS" => "Y",
            );
            foreach ($tmpArElements as $elId => $element) {
                $arFilter["ID"][] = $elId;
            }
            $arRes = CIBlockElement::GetList(array("sort" => "asc"), $arFilter, false, false, array('ID', 'IBLOCK_ID'));
            while ($arFields = $arRes->GetNext()) {
                $mxResult = CCatalogSKU::getExistOffers($arFields["ID"]);
                if ($mxResult[$arFields["ID"]] === true) {
                    if (!$tmpArElements[$arFields["ID"]][0]) {
                        $arElements[$arFields["ID"]] = $tmpArElements[$arFields["ID"]];
                    }
                } else {
                    if ($tmpArElements[$arFields["ID"]][0] > 0) {
                        $arElements[$arFields["ID"]] = $tmpArElements[$arFields["ID"]];
                    }
                }
            }
        } else {
            $arElements = $tmpArElements;
        }
		return $arElements;
	}
	
	public static function getCountFavorits() {
		$arElements = self::getFavorits();
		$countFav = 0;
		if (is_array($arElements) && count($arElements) > 0) {
			foreach ($arElements as $arElement) {
				$countFav += count($arElement);
			}
		}
		return $countFav;
	}
	
	public static function setFavorits($arElements) {
		global $USER, $APPLICATION;
		if (!$USER->IsAuthorized()) {
			$APPLICATION->set_cookie("nl_favorites", serialize($arElements));
		} else {
			$idUser = $USER->GetID();
			$USER->Update($idUser, Array("UF_NL_FAVORITES" => serialize($arElements)));
		}
		return true;
	}
    
    public static function getProductAmount($quantity, $minAmount, $maxAmount) {
        $quantity = intval($quantity);
        $result = array('count' => $quantity, 'products' => $quantity . " " . self::nl_inclination($quantity, GetMessage('NL_PRODUCT_1'), GetMessage('NL_PRODUCT_2'), GetMessage('NL_PRODUCT_10')));
        if ($minAmount > 0 && $maxAmount > 0) {
            if ($quantity == 0) {
                $result['class'] = 'nope';
                $result['text'] = GetMessage('CATALOG_EMPTY_AMOUNT');
            } elseif ($quantity < $minAmount) {
                $result['class'] = 'few';
                $result['text'] = GetMessage('CATALOG_FEW_AMOUNT');
            } elseif ($quantity > $maxAmount) {
                $result['class'] = 'many';
                $result['text'] = GetMessage('CATALOG_MANY_AMOUNT');
            } else {
                $result['class'] = 'mean';
                $result['text'] = GetMessage('CATALOG_MEAN_AMOUNT');
            }
        }
        return $result;
    }
    
    public static function getFileSize($size) {
        $filesizename = array("b", " Kb", " Mb", " Gb", " Tb", " Pb", " Eb", " Zb", " Yb");
        return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 b';
    }
    
    public static function getFileExtention($fileName) {
        $pathInfo = pathinfo($fileName);
        return $pathInfo['extension'];
    }
}
}