<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if (!empty($arResult["STORE"])):
    if ($arResult["STORE"]["GPS_N"] != 0 && $arResult["STORE"]["GPS_S"] != 0) {
        $arResult["STORE"]["GPS_N"] = substr($arResult["STORE"]["GPS_N"],0,15);
        $arResult["STORE"]["GPS_S"] = substr($arResult["STORE"]["GPS_S"],0,15);
    }
    $pic = false;
    if ($arResult["STORE"]["IMAGE_ID"]) {
        $pic = CFile::resizeImageGet($arResult["STORE"]["IMAGE_ID"], array('width' => 120, 'height' => 80), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
    }
    if ($pic !== false) {
        $arResult["STORES"][$pid]['IMAGE_URL'] = $pic['src'];
        if ($arResult["STORE"]['GPS_N'] > 0) {
            $arResult["STORE"]['IMAGE_URL'] = $pic['src'];
        }
    }
   if ($arResult["STORE"]["GPS_N"] != 0 && $arResult["STORE"]["GPS_S"] != 0):?>
        <div id="yandex-maps-shop" class="yandex-maps">
            <script type="text/javascript">
                initYmap('yandex-maps-shop', {
                    0: {
                        'coords' : [<?=$arResult["STORE"]['GPS_N']?>, <?=$arResult["STORE"]['GPS_S']?>],
                        <?if ($arResult["STORE"]["TITLE"]):?>
                            'title'  : '<?=$arResult["STORE"]["TITLE"]?>',
                        <?endif;?>
                        'content': '<div class="inner-content-address columns table-container"><?if ($arResult["STORE"]["IMAGE_URL"]):?><div class="preview table-item vertical-top"><img src="<?=$arResult["STORE"]["IMAGE_URL"]?>" alt="<?=$arResult["STORE"]["TITLE"]?>"></div><?endif;?><div class="table-item"><div class="name table-container"><?=$arResult["STORE"]["TITLE"]?></div><?if ($arResult["STORE"]["PHONE"]):?><div class="phone"><?=GetMessage("S_PHONE")?> <a href="tel:<?=$arResult["STORE"]["PHONE"]?>"><?=$arResult["STORE"]["PHONE"]?></a></div><?endif;?><a href="<?=$arResult["STORE"]["URL"]?>" class="button tiny"><?=GetMessage("S_DETAIL")?></a></div></div>',
                    },
                });
            </script>
        </div>
    <?endif;?>
<?endif;?>
