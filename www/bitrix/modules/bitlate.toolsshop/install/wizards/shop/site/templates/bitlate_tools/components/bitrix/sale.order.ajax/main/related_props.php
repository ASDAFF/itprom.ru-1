<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");

$style = (is_array($arResult["ORDER_PROP"]["RELATED"]) && count($arResult["ORDER_PROP"]["RELATED"]) && ($curStep == 'delivery')) ? "" : "display:none";?>
<div class="cart-content" style="<?=$style?>">
    <div class="float-center large-7 xlarge-5 relative">
        <fieldset>
            <strong><?=GetMessage("SOA_TEMPL_RELATED_PROPS")?></strong>
            <?=PrintPropsForm($arResult["ORDER_PROP"]["RELATED"], $arParams["TEMPLATE_LOCATION"])?>
        </fieldset>
    </div>
</div>