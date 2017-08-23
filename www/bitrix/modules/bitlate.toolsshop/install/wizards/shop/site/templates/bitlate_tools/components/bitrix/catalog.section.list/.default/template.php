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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));?>

<?if (0 < $arResult["SECTIONS_COUNT"]) {?>
    <div class="catalog-filters__block showed">
        <div class="heading">
            <span><?=GetMessage("CT_BCSF_FILTER_CATALOG_TITLE")?></span>
        </div>
        <div class="body">
            <ul class="catalog-categories-list">
                <?$intCurrentDepth = 1;
                $boolFirst = true;
                foreach ($arResult['SECTIONS'] as &$arSection) {
                    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                    if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL']) {
                        if (0 < $intCurrentDepth)
                            echo "\n",str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']),'<ul>';
                    } elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL']) {
                        if (!$boolFirst)
                            echo '</li>';
                    } else {
                        while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
                        {
                            echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
                            $intCurrentDepth--;
                        }
                        echo str_repeat("\t", $intCurrentDepth-1),'</li>';
                    }
                    
                    echo (!$boolFirst ? "\n" : ''),str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
                    $curUrl = explode("?", $arParams["PARAMS_STRING"]);
                    if ($curUrl[1] != '') {
                        $arSection["SECTION_PAGE_URL"] = $arSection["SECTION_PAGE_URL"] . ((strpos($arSection["SECTION_PAGE_URL"], '?') !== false) ? '&' : '?') . $curUrl[1];
                    }
                    ?>
                    <li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class="<?if($arSection['ID'] == $arParams["CUR_SECTION_ID"]):?>selected<?endif;?>"><a href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"];?></a>
                    <?$intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
                    $boolFirst = false;
                }
                unset($arSection);
                while ($intCurrentDepth > 1) {
                    echo '</li>',"\n",str_repeat("\t", $intCurrentDepth),'</ul>',"\n",str_repeat("\t", $intCurrentDepth-1);
                    $intCurrentDepth--;
                }
                if ($intCurrentDepth > 0) {
                    echo '</li>',"\n";
                }?>
            </ul>
        </div>
    </div>
<?}?>