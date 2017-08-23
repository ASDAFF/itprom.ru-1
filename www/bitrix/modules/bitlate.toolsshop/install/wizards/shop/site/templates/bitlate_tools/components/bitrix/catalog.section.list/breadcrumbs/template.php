<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$arSectionsDepth = array();
$curMaxDepth = 1;
$isRootSection = false;
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));?>

<?if (0 < $arResult["SECTIONS_COUNT"]) {
    $intCurrentDepth = 1;
    $boolFirst = true;
    foreach ($arResult['SECTIONS'] as &$arSection) {
        if ($arSection['DEPTH_LEVEL'] == 1 && $arSection['ID'] != $arParams['ROOT_SECTION_ID']) {
            $isRootSection = false;
        }
        if ($arSection['DEPTH_LEVEL'] == 2) {
            $isRootSection = ($arSection['IBLOCK_SECTION_ID'] == $arParams['ROOT_SECTION_ID']) ? true : false;
        }
        if ($arSection['DEPTH_LEVEL'] == 1) {
            $arSectionsDepth[$arSection['DEPTH_LEVEL']]['SECTIONS'][$arSection['ID']] = array(
                'NAME' => $arSection['NAME'],
                'LINK' => $arSection['SECTION_PAGE_URL'],
                'IBLOCK_SECTION_ID' => $arSection['IBLOCK_SECTION_ID'],
            );
        }
        if (!$isRootSection) {
            continue;
        }
        if ($arSection['DEPTH_LEVEL'] != 1) {
            $arSectionsDepth[$arSection['DEPTH_LEVEL']]['SECTIONS'][$arSection['ID']] = array(
                'NAME' => $arSection['NAME'],
                'LINK' => $arSection['SECTION_PAGE_URL'],
                'IBLOCK_SECTION_ID' => $arSection['IBLOCK_SECTION_ID'],
            );
        }
        if ($arSection['ID'] == $arParams["CUR_SECTION_ID"]) {
            $arSectionsDepth[$arSection['DEPTH_LEVEL']]['SECTIONS'][$arSection['ID']]['CURRENT'] = "Y";
            $arSectionsDepth[$arSection['DEPTH_LEVEL']]['CODE'] = md5($arSectionsDepth[$arSection['DEPTH_LEVEL']]['SECTIONS'][$arSection['ID']]['LINK']);
            $parentSection = $arSection['IBLOCK_SECTION_ID'];
            $currentDepthLevel = $arSection['DEPTH_LEVEL'];
            while ($parentSection > 0) {
                $currentDepthLevel--;
                if ($arSectionsDepth[$currentDepthLevel]['SECTIONS'][$parentSection]['NAME'] != '') {
                    $arSectionsDepth[$currentDepthLevel]['SECTIONS'][$parentSection]['CURRENT'] = "Y";
                    $arSectionsDepth[$currentDepthLevel]['CODE'] = md5($arSectionsDepth[$currentDepthLevel]['SECTIONS'][$parentSection]['LINK']);
                    $parentSection = $arSectionsDepth[$currentDepthLevel]['SECTIONS'][$parentSection]['IBLOCK_SECTION_ID'];
                } else {
                    $parentSection = 0;
                }
            }
        }
    }
    unset($arSection);
}
$arResult['SECTIONS_DEPTH'] = array();
if ($arSectionsDepth) {
    foreach ($arSectionsDepth as $depth => $arParams) {
        if (count($arParams['SECTIONS']) > 1) {
            $content = '<ul id="bx_sub_breadcrumb_' . $arParams['CODE'] . '" class="menu vertical dropdown-pane product-breadcrumbs-dropdown" data-dropdown data-hover="true" data-hover-pane="true">';
            foreach ($arParams['SECTIONS'] as $arSection) {
                if ($arSection['CURRENT'] != 'Y') {
                    $content .= '<li><a href="' . $arSection['LINK'] . '">' . $arSection['NAME'] . '</a></li>';
                }
            }
            $content .= '</ul>';
            $arResult['SECTIONS_DEPTH']['bx_sub_breadcrumb_' . $arParams['CODE']] = $content;
        }
    }
}
?>