<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

?>

<?
    echo '<script src="'.$this->GetFolder().'/js/common.js"></script>';
    echo '<link rel="stylesheet" type="text/css" href="'.$this->GetFolder().'/css/style.css"/>';
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<ul class="catalog-termo">
    <?
    $counter = 0;
    $description_class = "discription";
//    var_dump($arResult['SECTIONS']);
    foreach ($arResult["SECTIONS"] as $arSection)
    {
        if($arSection["UF_SHOW_ON_MAIN_PAGE"] != "1")
            continue;
        $counter = $counter + 1;
        if($counter % 5 == 0)
            $description_class = "discription-two";
        else $description_class = "discription";
        ?>
        <li>
            <div class="shkaf-div">
                <a href="<?=$arSection["SECTION_PAGE_URL"]?>" title="<?= $arSection["UF_BROWSER_TITLE"] ?>">
                    <p>
                        <span>
                            <?
                                if(empty($arSection["UF_SECT_SERIES_NAME"]))
                                    echo $arSection["NAME"];
                                else echo$arSection["UF_SECT_SERIES_NAME"];
                            ?>
                        </span>
                    </p>
                    <img src="<?=$arSection['PICTURE']['SRC']?>" alt="">
                    <p>
                        <?
                            $text = $arSection["UF_SECT_CHARACTER"];
                            $lines = explode('|', $text);
                            echo $lines[0].'<br/>';
                            echo $lines[1];
                        ?>
                    </p>
                </a>
                <a href="#" class="quest-about">Подробное описание</a>
                <div style="display: none;" class="<?=$description_class?>">
                    <p><?= $arSection["UF_SECT_DESCRIPTION"] ?></p>
                </div>
            </div>
        </li>
        <?
    }
    ?>
</ul>
<style>
    .shkaf-div a
    {
        text-decoration: none;
    }
    .catalog-termo *
    {
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        box-sizing:border-box;
    }

    body {
        font: 20px/18px 'Ubuntu', sans-serif !important;
        color: #404040;
    }
</style>