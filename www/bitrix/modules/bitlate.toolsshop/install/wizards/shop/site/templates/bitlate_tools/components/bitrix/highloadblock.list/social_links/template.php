<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (!empty($arResult['ERROR']))
    return false;

if (!empty($arResult['rows'])):?>
    <div class="footer-line-top-caption"><?=GetMessage('TITLE')?></div>
    <ul class="footer-line-top-social inline-block-container">
        <?foreach ($arResult['rows'] as $arItem):?>
            <li class="inline-block-item icon-social-<?=$arItem['UF_TYPE']?>">
                <a href="<?=$arItem['UF_LINK']?>" target="_blank">
                    <svg class="icon">
                        <use xlink:href="#svg-icon-social-<?=$arItem['UF_TYPE']?>"></use>
                    </svg>
                </a>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>