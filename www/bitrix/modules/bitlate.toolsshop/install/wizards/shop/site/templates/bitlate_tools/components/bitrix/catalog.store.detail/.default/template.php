<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?if (($arResult["GPS_N"]) != 0 && ($arResult["GPS_S"]) != 0):
    $gpsN = substr($arResult["GPS_N"],0,15);
    $gpsS = substr($arResult["GPS_S"],0,15);
    $pic = false;
    if ($arResult["IMAGE_ID"]) {
        $pic = CFile::resizeImageGet($arResult["IMAGE_ID"], array('width' => 120, 'height' => 80), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
    }?>
    <div id="yandex-maps-detail" class="yandex-maps">
        <script type="text/javascript">
            initYmap('yandex-maps-detail', {
                0: {
                    'coords' : [<?=$gpsN?>, <?=$gpsS?>],
                    <?if ($arResult["ADDRESS"]):?>
                        'title'  : '<?=$arResult["ADDRESS"]?>',
                    <?endif;?>
                    <?if ($arResult["ADDRESS"] || $arResult["PHONE"] || $pic !== false):?>
                        'content': '<div class="inner-content-address columns table-container"><?if ($pic !== false):?><div class="preview table-item vertical-top"><img src="<?=$pic['src']?>" alt="<?=$arResult['TITLE']?>"></div><?endif;?><?if ($arResult["ADDRESS"] || $arResult["PHONE"]):?><div class="table-item"><?if ($arResult["ADDRESS"]):?><div class="name table-container"><?=$arResult["ADDRESS"]?></div><?endif;?><?if ($arResult["PHONE"]):?><div class="phone"><?=GetMessage("S_PHONE")?> <a href="tel:<?=$arResult["PHONE"]?>"><?=$arResult["PHONE"]?></a></div><?endif;?></div><?endif;?></div>',
                    <?endif;?>
                },
            });
        </script>
    </div>
<?endif;?>
<div class="row" itemscope itemtype = "http://schema.org/Product">
    <div class="large-6 xxlarge-4 columns">
        <ul class="inner-content-list inner-content-contact-left">
            <?if ($arResult["PHONE"]):?>
                <li>
                    <?=GetMessage("S_PHONE")?>
                    <div class="value phone"><?=$arResult["PHONE"]?></div>
                </li>
            <?endif;?>
            <?if ($arResult["ADDRESS"]):?>
                <li>
                    <?=GetMessage("S_ADDRESS")?>
                    <div class="value"><?=$arResult["ADDRESS"]?></div>
                </li>
            <?endif;?>
            <?if ($arResult["EMAIL"]):?>
                <li>
                    <?=GetMessage("S_EMAIL")?>
                    <div class="value"><a href="mailto:<?=$arResult["EMAIL"]?>"><?=$arResult["EMAIL"]?></a></div>
                </li>
            <?endif;?>
            <?if ($arResult["SCHEDULE"]):?>
                <li>
                    <?=GetMessage("S_SCHEDULE")?>
                    <div class="value"><?=$arResult["SCHEDULE"]?></div>
                </li>
            <?endif;?>
        </ul>
    </div>
    <div class="inner-content-contact-right large-6 xxlarge-8 columns">
        <?if ($arResult["DESCRIPTION"] || count($arResult["SHOP_PHOTOS"]) > 0):?>
            <h3><?=GetMessage("S_TITLE")?></h3>
            <?if (count($arResult["SHOP_PHOTOS"]) > 0):?>
                <div class="row small-up-2">
                    <?foreach ($arResult["SHOP_PHOTOS"] as $photo):
                        $pic = false;
                        $pic = CFile::resizeImageGet($photo, array('width' => 307, 'height' => 189), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
                        if ($pic !== false):?>
                            <div class="column">
                                <img src="<?=$pic['src']?>" alt="<?=$arResult["TITLE"]?>" class="photo" />
                            </div>
                        <?endif;?>
                    <?endforeach;?>
                </div>
            <?endif;?>
            <p><?=$arResult["DESCRIPTION"]?></p>
        <?endif;?>
    </div>
</div>