<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>

<?if(strlen($arResult["ERROR_MESSAGE"])>0)
    ShowError($arResult["ERROR_MESSAGE"]);?>
<?if (is_array($arResult["STORES"]) && !empty($arResult["STORES"])):
    $arPlacemarks = array();
    foreach ($arResult["STORES"] as $pid => $arProperty) {
        if (($arProperty["GPS_N"]) != 0 && ($arProperty["GPS_S"]) != 0) {
            $gpsN = substr($arProperty["GPS_N"],0,15);
            $gpsS = substr($arProperty["GPS_S"],0,15);
            $arPlacemarks[$pid]['GPS_N'] = $gpsN;
            $arPlacemarks[$pid]['GPS_S'] = $gpsS;
            $arPlacemarks[$pid]['TITLE'] = $arProperty["TITLE"];
            $arPlacemarks[$pid]['PHONE'] = $arProperty["PHONE"];
            $arPlacemarks[$pid]['URL'] = $arProperty["URL"];
        }
        $pic = false;
        if ($arProperty["IMAGE_ID"]) {
            $pic = CFile::resizeImageGet($arProperty["IMAGE_ID"], array('width' => 120, 'height' => 80), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
        }
        if ($pic !== false) {
            $arResult["STORES"][$pid]['IMAGE_URL'] = $pic['src'];
            if ($arPlacemarks[$pid]['GPS_N'] > 0) {
                $arPlacemarks[$pid]['IMAGE_URL'] = $pic['src'];
            }
        }
    }
    if (count($arPlacemarks) > 0):?>
        <div id="yandex-maps-shop" class="yandex-maps">
            <script type="text/javascript">
                initYmap('yandex-maps-shop', {
                    <?$i = 0;
                    foreach ($arPlacemarks as $mark):?>
                        <?=$i?>: {
                            'coords' : [<?=$mark['GPS_N']?>, <?=$mark['GPS_S']?>],
                            <?if ($mark["TITLE"]):?>
                                'title'  : '<?=$mark["TITLE"]?>',
                            <?endif;?>
                            'content': '<div class="inner-content-address columns table-container"><?if ($mark["IMAGE_URL"]):?><div class="preview table-item vertical-top"><img src="<?=$mark["IMAGE_URL"]?>" alt="<?=$mark["TITLE"]?>"></div><?endif;?><div class="table-item"><div class="name table-container"><?=$mark["TITLE"]?></div><?if ($mark["PHONE"]):?><div class="phone"><?=GetMessage("S_PHONE")?> <a href="tel:<?=$mark["PHONE"]?>"><?=$mark["PHONE"]?></a></div><?endif;?><a href="<?=$mark["URL"]?>" class="button tiny"><?=GetMessage("S_DETAIL")?></a></div></div>',
                        },
                        <?$i++;?>
                    <?endforeach;?>
                });
            </script>
        </div>
    <?endif;?>
    <ul class="inner-content-list row large-up-2">
        <?foreach ($arResult["STORES"] as $pid => $arProperty):?>
            <li class="inner-content-address columns table-container">
                <?if ($arProperty['IMAGE_URL']):?>
                    <div class="preview table-item vertical-top">
                        <img src="<?=$arProperty['IMAGE_URL']?>" alt="<?=$arProperty["TITLE"]?>" />
                    </div>
                <?endif;?>
                <div class="table-item">
                    <?if ($arProperty["TITLE"]):?>
                        <div class="name table-container">
                            <svg class="icon table-item vertical-top">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-placemark"></use>
                            </svg>
                            <a href="<?=$arProperty["URL"]?>" class="table-item">
                                <span><?=$arProperty["TITLE"]?></span>
                            </a>
                        </div>
                    <?endif;?>
                    <?if ($arProperty["SHOP_METRO"]):?>
                        <div class="metro">
                            <svg class="icon">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-metro"></use>
                            </svg>
                            <?=$arProperty["SHOP_METRO"]?>
                        </div>
                    <?endif;?>
                    <?if ($arProperty["PHONE"]):?>
                        <div class="phone"><?=GetMessage("S_PHONE")?> <a href="tel:<?=$arProperty["PHONE"]?>"><?=$arProperty["PHONE"]?></a></div>
                    <?endif;?>
                </div>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>
