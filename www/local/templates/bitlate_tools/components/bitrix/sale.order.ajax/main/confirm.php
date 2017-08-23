<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<article id="order-complete" class="inner-container cart-container cart-container-pay">
    <?if (!empty($arResult["ORDER"])) {?>
        <div class="fancybox-icon float-center">
            <div class="fancybox-icon-check"></div>
        </div>
        <div class="text-center">
            <div class="cart-caption"><?=GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]))?></div>
            <div class="cart-caption-desc"><?=GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?></div>
        </div>
        <?if (!empty($arResult["PAY_SYSTEM"])) {?>
            <div class="cart-content sale_order_full_table">
                <div class="float-center large-7 xlarge-5">
                    <div class="ps_logo text-center">
                        <h2 class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></h2>
                        <?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
                        <p class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></p>
                    </div>
                </div>
                <?
                if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0) {?>
                    <?
                    if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
                    {
                        ?>
                        <script language="JavaScript">
                            window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>&PAYMENT_ID=<?=$arResult['ORDER']["PAYMENT_ID"]?>');
                        </script>
                        <?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["PAYMENT_ID"]))?>
                        <?
                        if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
                        {
                            ?><br />
                            <?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
                            <?
                        }
                    }
                    else
                    {
                        if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
                        {
                            try
                            {
                                include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
                            }
                            catch(\Bitrix\Main\SystemException $e)
                            {
                                if($e->getCode() == CSalePaySystemAction::GET_PARAM_VALUE)
                                    $message = GetMessage("SOA_TEMPL_ORDER_PS_ERROR");
                                else
                                    $message = $e->getMessage();

                                echo '<span style="color:red;">'.$message.'</span>';
                            }
                        }
                    }
                    ?>
                <?}?>
            </div>
        <?}?>
    <?} else {?>
        <div class="text-center">
            <div class="cart-caption"><?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?></div>
            <div class="cart-caption-desc"><?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?></div>
        </div>
    <?}?>
</article>
