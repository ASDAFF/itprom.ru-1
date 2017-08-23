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
if ($arParams["REQUEST_LOAD"] == "Y") return;
?>
<div class="catalog-filters" id="catalog-filter" data-filter-tip>
    <div class="catalog-filters-inner">
        <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
            <?foreach($arResult["HIDDEN"] as $arItem):?>
                <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
            <?endforeach;?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $arParams["PARENT_SECTION_ID"],
                    "CUR_SECTION_ID" => $arParams["SECTION_ID"],
                    "SECTION_CODE" => $arParams["SECTION_CODE"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                    "TOP_DEPTH" => ($arParams["PARENT_SECTION_ID"] == 0) ? 1 : $arParams["TOP_DEPTH"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                    "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                    "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                    "ADD_SECTIONS_CHAIN" => "N",
                    "PARAMS_STRING" => $arParams["PARAMS_STRING"],
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            );?>
            <?foreach($arResult["ITEMS"] as $key=>$arItem)//prices
            {
                $key = $arItem["ENCODED_ID"];
                if(isset($arItem["PRICE"])):
                    if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                        continue;

                    $precision = 2;
                    if (Bitrix\Main\Loader::includeModule("currency"))
                    {
                        $res = CCurrencyLang::GetFormatDescription($arItem["VALUES"]["MIN"]["CURRENCY"]);
                        $precision = $res['DECIMALS'];
                    }
                    $minVal = floor($arItem["VALUES"]["MIN"]["VALUE"]);
                    $maxVal = ceil($arItem["VALUES"]["MAX"]["VALUE"]);
                    $curMinVal = floor((!$arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["VALUE"] : $arItem["VALUES"]["MIN"]["HTML_VALUE"]);
                    $curMaxVal = ceil((!$arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["VALUE"] : $arItem["VALUES"]["MAX"]["HTML_VALUE"]);
                    $priceTitle = ($arItem["CODE"] == "BASE") ? GetMessage("CT_BCSF_FILTER_PRICE_TITLE") : $arItem["NAME"];
                    if ($arItem["VALUES"]["MIN"]["CURRENCY"] == "RUB") {
                        $priceTitle .= ', ' . GetMessage("CT_BCSF_FILTER_RUB_TITLE");
                    } else {
                        $priceTitle .= ', ' . $arItem["CURRENCIES"][$arItem["VALUES"]["MIN"]["CURRENCY"]];
                    }?>
                    <div class="catalog-filters__block bx-filter-parameters-box showed">
                        <div class="heading">
                            <span><?=$priceTitle?></span>
                        </div>
                        <div class="body bx-filter-container-modef">
                            <div class="row">
                                <div class="row catalog-slider-row">
                                    <div class="column small-6">
                                        <div class="input-group">
                                            <span class="input-group-label hollow"><?=GetMessage("CT_BCSF_FILTER_FROM")?></span>
                                            <input id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" class="input-group-field hollow" value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" type="number" onkeyup="smartFilter.keyup(this)" data-tip-top="3">
                                        </div>
                                    </div>
                                    <div class="column small-6">
                                        <div class="input-group">
                                            <span class="input-group-label hollow"><?=GetMessage("CT_BCSF_FILTER_TO")?></span>
                                            <input id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" class="input-group-field hollow" value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>" type="number" onkeyup="smartFilter.keyup(this)" data-tip-top="3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="slider" data-start="<?echo $minVal?>" data-end="<?echo $maxVal?>" data-initial-start="<?echo $curMinVal?>" data-initial-end="<?echo $curMaxVal?>">
                                <span class="slider-handle" data-slider-handle role="slider" tabindex="1" aria-controls="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" aria-valuenow="<?echo $curMinVal?>"></span>
                                <span class="slider-fill" data-slider-fill></span>
                                <span class="slider-handle" data-slider-handle role="slider" tabindex="1" aria-controls="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" aria-valuenow="<?echo $curMaxVal?>"></span>
                            </div>
                        </div>
                    </div>
                <?endif;
            }
            //not prices
            foreach($arResult["ITEMS"] as $key=>$arItem)
            {
                if(
                    empty($arItem["VALUES"])
                    || isset($arItem["PRICE"])
                )
                    continue;

                if (
                    $arItem["DISPLAY_TYPE"] == "A"
                    && (
                        $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
                    )
                )
                    continue;
                if ($arItem["DISPLAY_TYPE"] == "A") {
                    $arItem["DISPLAY_EXPANDED"] = "Y";
                }
                ?>
                <div class="catalog-filters__block bx-filter-parameters-box<?if ($arItem["DISPLAY_EXPANDED"] == "Y"):?> showed<?endif?>">
                    <div class="heading">
                        <span><?=$arItem["NAME"]?></span>
                        <?if ($arItem["FILTER_HINT"] <> ""):?>
                            <i id="item_title_hint_<?echo $arItem["ID"]?>" class="fa fa-question-circle"></i>
                            <script type="text/javascript">
                                new top.BX.CHint({
                                    parent: top.BX("item_title_hint_<?echo $arItem["ID"]?>"),
                                    show_timeout: 10,
                                    hide_timeout: 200,
                                    dx: 2,
                                    preventHide: true,
                                    min_width: 250,
                                    hint: '<?= CUtil::JSEscape($arItem["FILTER_HINT"])?>'
                                });
                            </script>
                        <?endif?>
                    </div>
                    <div class="body bx-filter-container-modef"<?if ($arItem["DISPLAY_EXPANDED"] != "Y"):?> style="display:none;"<?endif?>>
                            <?
                            $arCur = current($arItem["VALUES"]);
                            switch ($arItem["DISPLAY_TYPE"])
                            {
                                case "A"://NUMBERS_WITH_SLIDER
                                    $minVal = floor($arItem["VALUES"]["MIN"]["VALUE"]);
                                    $maxVal = ceil($arItem["VALUES"]["MAX"]["VALUE"]);
                                    $curMinVal = floor((!$arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["VALUE"] : $arItem["VALUES"]["MIN"]["HTML_VALUE"]);
                                    $curMaxVal = ceil((!$arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["VALUE"] : $arItem["VALUES"]["MAX"]["HTML_VALUE"]);?>
                                    <div class="row">
                                        <div class="row catalog-slider-row">
                                            <div class="column small-6">
                                                <div class="input-group">
                                                    <span class="input-group-label hollow"><?=GetMessage("CT_BCSF_FILTER_FROM")?></span>
                                                    <input id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" class="input-group-field hollow" value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" type="number" onkeyup="smartFilter.keyup(this)" data-tip-top="3">
                                                </div>
                                            </div>
                                            <div class="column small-6">
                                                <div class="input-group">
                                                    <span class="input-group-label hollow"><?=GetMessage("CT_BCSF_FILTER_TO")?></span>
                                                    <input id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" class="input-group-field hollow" value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>" type="number" onkeyup="smartFilter.keyup(this)" data-tip-top="3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider" data-start="<?echo $minVal?>" data-end="<?echo $maxVal?>" data-initial-start="<?echo $curMinVal?>" data-initial-end="<?echo $curMaxVal?>">
                                        <span class="slider-handle" data-slider-handle role="slider" tabindex="1" aria-controls="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" aria-valuenow="<?echo $curMinVal?>"></span>
                                        <span class="slider-fill" data-slider-fill></span>
                                        <span class="slider-handle" data-slider-handle role="slider" tabindex="1" aria-controls="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" aria-valuenow="<?echo $curMaxVal?>"></span>
                                    </div>
                                    <?
                                    break;
                                case "B"://NUMBERS?>
                                    <div class="row">
                                        <div class="row catalog-slider-row">
                                            <div class="column small-6">
                                                <div class="input-group">
                                                    <span class="input-group-label hollow"><?=GetMessage("CT_BCSF_FILTER_FROM")?></span>
                                                    <input id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>" name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>" class="input-group-field hollow" value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>" type="number" onkeyup="smartFilter.keyup(this)" data-tip-top="3">
                                                </div>
                                            </div>
                                            <div class="column small-6">
                                                <div class="input-group">
                                                    <span class="input-group-label hollow"><?=GetMessage("CT_BCSF_FILTER_TO")?></span>
                                                    <input id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>" name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>" class="input-group-field hollow" value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>" type="number" onkeyup="smartFilter.keyup(this)" data-tip-top="3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    break;
                                case "G"://CHECKBOXES_WITH_PICTURES
                                    $class = "";
                                    if ($ar["CHECKED"])
                                        $class.= " bx-active";
                                    if ($ar["DISABLED"])
                                        $class.= " disabled";?>
                                    <div class="catalog-color-sets">
                                    <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                        <label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="catalog-color-sets__item bx-filter-param-label <?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>'));">
                                            <input type="checkbox" name="<?=$ar["CONTROL_NAME"]?>" id="<?=$ar["CONTROL_ID"]?>" value="<?=$ar["HTML_VALUE"]?>" <? echo $ar["CHECKED"]? 'checked="checked"': '' ?> class="show-for-sr" data-tip-top="-2">
                                            <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                <span class="color-badge" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                            <?endif?>
                                        </label>
                                    <?endforeach?>
                                    </div>
                                    <?
                                    break;
                                case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
                                    ?>
                                    <div class="bx-filter-param-btn-block">
                                    <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                        <input
                                            style="display: none"
                                            type="checkbox"
                                            name="<?=$ar["CONTROL_NAME"]?>"
                                            id="<?=$ar["CONTROL_ID"]?>"
                                            value="<?=$ar["HTML_VALUE"]?>"
                                            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                        />
                                        <?
                                        $class = "";
                                        if ($ar["CHECKED"])
                                            $class.= " bx-active";
                                        if ($ar["DISABLED"])
                                            $class.= " disabled";
                                        ?>
                                        <label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');"data-tip-top="-2">
                                            <span class="bx-filter-param-btn bx-color-sl">
                                                <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                    <span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                <?endif?>
                                            </span>
                                            <span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
                                            if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                ?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
                                            endif;?></span>
                                        </label>
                                    <?endforeach?>
                                    </div>
                                    <?
                                    break;
                                case "P"://DROPDOWN
                                    $checkedItemExist = false;
                                    ?>
                                    <div class="bx-filter-select-container">
                                        <div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')" data-tip-top="-2">
                                            <div class="bx-filter-select-text" data-role="currentOption">
                                                <?
                                                foreach ($arItem["VALUES"] as $val => $ar)
                                                {
                                                    if ($ar["CHECKED"])
                                                    {
                                                        echo $ar["VALUE"];
                                                        $checkedItemExist = true;
                                                    }
                                                }
                                                if (!$checkedItemExist)
                                                {
                                                    echo GetMessage("CT_BCSF_FILTER_ALL");
                                                }
                                                ?>
                                            </div>
                                            <div class="bx-filter-select-arrow"></div>
                                            <input
                                                style="display: none"
                                                type="radio"
                                                name="<?=$arCur["CONTROL_NAME_ALT"]?>"
                                                id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
                                                value=""
                                            />
                                            <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                                <input
                                                    style="display: none"
                                                    type="radio"
                                                    name="<?=$ar["CONTROL_NAME_ALT"]?>"
                                                    id="<?=$ar["CONTROL_ID"]?>"
                                                    value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                    <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                />
                                            <?endforeach?>
                                            <div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none;">
                                                <ul>
                                                    <li>
                                                        <label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx-filter-param-label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')" data-tip-top="-2">
                                                            <? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
                                                        </label>
                                                    </li>
                                                <?
                                                foreach ($arItem["VALUES"] as $val => $ar):
                                                    $class = "";
                                                    if ($ar["CHECKED"])
                                                        $class.= " selected";
                                                    if ($ar["DISABLED"])
                                                        $class.= " disabled";
                                                ?>
                                                    <li>
                                                        <label for="<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" data-role="label_<?=$ar["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')" data-tip-top="-2"><?=$ar["VALUE"]?></label>
                                                    </li>
                                                <?endforeach?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    break;
                                case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
                                    ?>
                                    <div class="bx-filter-select-container">
                                        <div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')" data-tip-top="-2">
                                            <div class="bx-filter-select-text fix" data-role="currentOption">
                                                <?
                                                $checkedItemExist = false;
                                                foreach ($arItem["VALUES"] as $val => $ar):
                                                    if ($ar["CHECKED"])
                                                    {
                                                    ?>
                                                        <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                            <span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                        <?endif?>
                                                        <span class="bx-filter-param-text">
                                                            <?=$ar["VALUE"]?>
                                                        </span>
                                                    <?
                                                        $checkedItemExist = true;
                                                    }
                                                endforeach;
                                                if (!$checkedItemExist)
                                                {
                                                    ?><span class="bx-filter-btn-color-icon all"></span> <?
                                                    echo GetMessage("CT_BCSF_FILTER_ALL");
                                                }
                                                ?>
                                            </div>
                                            <div class="bx-filter-select-arrow"></div>
                                            <input
                                                style="display: none"
                                                type="radio"
                                                name="<?=$arCur["CONTROL_NAME_ALT"]?>"
                                                id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
                                                value=""
                                            />
                                            <?foreach ($arItem["VALUES"] as $val => $ar):?>
                                                <input
                                                    style="display: none"
                                                    type="radio"
                                                    name="<?=$ar["CONTROL_NAME_ALT"]?>"
                                                    id="<?=$ar["CONTROL_ID"]?>"
                                                    value="<?=$ar["HTML_VALUE_ALT"]?>"
                                                    <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                />
                                            <?endforeach?>
                                            <div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none">
                                                <ul>
                                                    <li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
                                                        <label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx-filter-param-label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')" data-tip-top="-2">
                                                            <span class="bx-filter-btn-color-icon all"></span>
                                                            <? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
                                                        </label>
                                                    </li>
                                                <?
                                                foreach ($arItem["VALUES"] as $val => $ar):
                                                    $class = "";
                                                    if ($ar["CHECKED"])
                                                        $class.= " selected";
                                                    if ($ar["DISABLED"])
                                                        $class.= " disabled";
                                                ?>
                                                    <li>
                                                        <label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')" data-tip-top="-2">
                                                            <?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
                                                                <span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
                                                            <?endif?>
                                                            <span class="bx-filter-param-text">
                                                                <?=$ar["VALUE"]?>
                                                            </span>
                                                        </label>
                                                    </li>
                                                <?endforeach?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    break;
                                case "K"://RADIO_BUTTONS
                                    ?>
                                    <div class="radio">
                                        <label class="bx-filter-param-label" for="<? echo "all_".$arCur["CONTROL_ID"] ?>">
                                            <span class="bx-filter-input-checkbox">
                                                <input
                                                    type="radio"
                                                    value=""
                                                    name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
                                                    id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
                                                    onclick="smartFilter.click(this)"
                                                    data-tip-top="-5"
                                                />
                                                <span class="bx-filter-param-text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
                                            </span>
                                        </label>
                                    </div>
                                    <?foreach($arItem["VALUES"] as $val => $ar):?>
                                        <div class="radio">
                                            <label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label" for="<? echo $ar["CONTROL_ID"] ?>">
                                                <span class="bx-filter-input-checkbox <? echo $ar["DISABLED"] ? 'disabled': '' ?>">
                                                    <input
                                                        type="radio"
                                                        value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                        name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
                                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                                        <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                                        onclick="smartFilter.click(this)"
                                                        data-tip-top="-5"
                                                    />
                                                    <span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
                                                    if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                        ?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
                                                    endif;?></span>
                                                </span>
                                            </label>
                                        </div>
                                    <?endforeach;?>
                                    <?
                                    break;
                                case "U"://CALENDAR
                                    ?>
                                    <div class="bx-filter-parameters-box-container-block"><div class="bx-filter-input-container bx-filter-calendar-container">
                                        <?$APPLICATION->IncludeComponent(
                                            'bitrix:main.calendar',
                                            '',
                                            array(
                                                'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
                                                'SHOW_INPUT' => 'Y',
                                                'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)" data-tip-top="-5"',
                                                'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
                                                'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                                                'SHOW_TIME' => 'N',
                                                'HIDE_TIMEBAR' => 'Y',
                                            ),
                                            null,
                                            array('HIDE_ICONS' => 'Y')
                                        );?>
                                    </div></div>
                                    <div class="bx-filter-parameters-box-container-block"><div class="bx-filter-input-container bx-filter-calendar-container">
                                        <?$APPLICATION->IncludeComponent(
                                            'bitrix:main.calendar',
                                            '',
                                            array(
                                                'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
                                                'SHOW_INPUT' => 'Y',
                                                'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)" data-tip-top="-5"',
                                                'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
                                                'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                                'SHOW_TIME' => 'N',
                                                'HIDE_TIMEBAR' => 'Y',
                                            ),
                                            null,
                                            array('HIDE_ICONS' => 'Y')
                                        );?>
                                    </div></div>
                                    <?
                                    break;
                                default: //CHECKBOXES
                                    ?>
                                    <fieldset class="checkbox">
                                    <?foreach($arItem["VALUES"] as $val => $ar):?>
                                            <input type="checkbox" name="<? echo $ar["CONTROL_NAME"] ?>" value="<? echo $ar["HTML_VALUE"] ?>" id="<? echo $ar["CONTROL_ID"] ?>" class="show-for-sr" <? echo $ar["CHECKED"]? 'checked="checked"': '' ?> onclick="smartFilter.click(this)" data-tip-top="-5">
                                            <label data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>" class="bx-filter-param-label<? echo $ar["DISABLED"] ? ' disabled': '' ?>"><?=$ar["VALUE"];?><?if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):?> (<span class="count" data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?endif;?></label>
                                    <?endforeach;?>
                                    </fieldset>
                            <?
                            }
                            ?>
                    </div>
                </div>
            <?
            }
            ?>
            <input type="hidden" name="sort" value="<?=$arParams['REQUEST_SORT']?>" />
            <input type="hidden" name="view" value="<?=$arParams['REQUEST_VIEW']?>" />
            <input type="hidden" name="PAGE_EL_COUNT" value="<?=$arParams['REQUEST_PAGE_EL_COUNT']?>" />
            <div class="catalog-filters__buttons">
                    <input
                        class="button expanded"
                        type="submit"
                        id="set_filter"
                        name="set_filter"
                        value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
                        onclick="getCatalogItems(this, '.catalog-reload', true); return false;"
                        href="<?=$APPLICATION->GetCurPageParam('load=Y', array('del_filter'));?>"
                    />
                    <input
                        class="button expanded secondary"
                        type="submit"
                        id="del_filter"
                        name="del_filter"
                        value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
                        onclick="window.location.href = smartFilter.generateParamsUrl($(this).attr('href')); return false;"
                        href="<?=$arResult["SEF_DEL_FILTER_URL"]?>"
                    />
            </div>
            <div class="bx-filter-popup-result filter-tip" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none; top:0px; margin-top:0px;"';?> style="display: block; top:0px; margin-top:0px;">
                <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
                <a href="<?echo $arResult["FILTER_URL"]?>" data-ajax="<?echo $arResult["FILTER_URL"]?>&load=Y" target="" onclick="getCatalogItems(this, '.catalog-reload', true); return false;"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
            </div>
        </form>
    </div>
</div>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>