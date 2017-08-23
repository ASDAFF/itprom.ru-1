<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $USER;
if (!($USER -> isAdmin())) {
    echo "<h1>NOT ADMIN!</h1>";
    die();
}

//Очищает выбранный раздел от товаров
function clear_section ($iblock_id, $section_id) {
    $items_raw = CIBlockElement::GetList(
        Array("SORT" => "ASC"),
        Array("SECTION_ID" => $section_id)
    );
    while ($el = $items_raw->GetNext()) {
        $id = $el["ID"];
        //test_dump($el);
        //echo $id . "<br>";
        CIBlockElement::Delete($id);
    }
}

//Добавляет элемент в заданный инфоблок, с заданным именем, ценой, параметрами и детальной картинкой
function add_element ($iblock_id, $section_id, $NAME, $PRICE_EUR, $P, $DETAIL_PICTURE) {
    $el = new CIBlockElement;

    //test_dump($P);

    $arFields = array(
        "IBLOCK_ID" => $iblock_id,
        "NAME" => $NAME,
        "CODE" => $P["ARTNUMBER"],
        "ACTIVE" => "Y",
        "IBLOCK_SECTION_ID" => $section_id,
        "DETAIL_TEXT" => $P["DESCRIPTION_TEXT"],
        "DETAIL_TEXT_TYPE" => "html",
        "PROPERTY_VALUES" => $P,
        "DETAIL_PICTURE" => $DETAIL_PICTURE
    );

    if ($last_el_id = $el->Add($arFields))
    {
        echo "New ID: " . $last_el_id . "<br>";

        $arFields = array(
            "ID" => $last_el_id,
            "VAT_INCLUDED" => "Y"
        );

        if (CCatalogProduct::Add($arFields))
        {
            echo "Добавили параметры товара к элементу каталога " . $last_el_id . "<br>";

            $arFields = Array(
                "PRODUCT_ID" => $last_el_id,
                "CATALOG_GROUP_ID" => 1,
                "PRICE" => $PRICE_EUR,
                "CURRENCY" => "EUR"
            );

            CPrice::Add($arFields);
        }
        else
            echo "Ошибка добавления параметров товаров";
    }
    else
        echo "Error: " . $el->LAST_ERROR . "<br>";
}

function scan_Dir($dir) {
    $arrfiles = array();
    if (is_dir($dir)) {
        if ($handle = opendir($dir)) {
            chdir($dir);
            while (false !== ($r_file = readdir($handle))) {
                if ($r_file != "." && $r_file != "..") {
                    if (is_dir($r_file)) {
                        $arr = scan_Dir($r_file);
                        foreach ($arr as $value) {
                            $arrfiles[] = $dir."/".$value;
                        }
                    } else {
                        $arrfiles[] = $dir."/".$r_file;
                    }
                }
            }
            chdir("../");
        }
        closedir($handle);
    }
    return $arrfiles;
}

function add_elements_from_file($filename, $iblock_id, $section_id, $series_name, $series_title_prefix, $price_multiplier, $common_options) {
    $file = file($filename);
    $e1 = array_map(function ($row2) {
        return explode(';', $row2);
    }, $file);

    $el_count = count($e1);

    for ($i = 1; $i < $el_count; $i++) {
        test_dump($i);
        $row = $e1[$i];
        test_dump($row);

        $BRAND_REF="itprom";

        $TB_WIDTH=$row[3];
        $TB_HEIGHT=$row[2];
        $TB_DEPTH=$row[4];


        $PRICE_EUR=$row[7];

        $w = intval($TB_WIDTH);
        $h = intval($TB_HEIGHT);
        $d = intval($TB_DEPTH);

        test_dump(Array($w, $h, $d));

        $TP_IP_CLASS="";
        if ($row[1] == "21-30") {
            $TP_IP_CLASS = 164;
        } elseif ($row[1] == "21-32") {
            $TP_IP_CLASS = 165;
        } elseif ($row[1] == "21-33") {
            $TP_IP_CLASS = 166;
        } elseif ($row[1] == "21-35") {
            $TP_IP_CLASS = 167;
        }
        //Раннев сказал везде делать 31
        $TP_IP_CLASS = 168;

        $ARTNUMBER = "arm19" . "-" . $w / 10 . $h / 10 . $d . "_" . $TP_IP_CLASS;

        $NAME = $row[0];

        $MORE_PHOTO = Array();
        $MORE_PHOTO_2D = Array();

        if ($h > 1100) {
            $DETAIL_PICTURE = CFile::MakeFileArray("images/19inch/shkaf3.jpg");
            $MORE_PHOTO[] = Array();
        } else {
            $DETAIL_PICTURE = CFile::MakeFileArray("images/19inch/shkaf1.jpg");

            $MORE_PHOTO[] = Array(
                CFile::MakeFileArray("images/19inch/shkaf2.jpg")
            );
        }

        $TB_SERIES = "";

        $P = Array(
            "ARTNUMBER" => $ARTNUMBER,
            "BRAND_REF"=> $BRAND_REF,
            "TB_SERIES"=>$TB_SERIES,
            "TB_WIDTH"=>$TB_WIDTH,
            "TB_HEIGHT"=>$TB_HEIGHT,
            "TB_DEPTH"=>$TB_DEPTH,
            "TP_IP_CLASS" => $TP_IP_CLASS,
            "MORE_PHOTO" => $MORE_PHOTO,
            "DESCRIPTION_TEXT" => $row[5]
        );

        $PRICE_EUR = floatval($PRICE_EUR) * $price_multiplier;

        if ($w * $w + $h * $h + $d * $d != 0) {
            test_dump(Array($iblock_id, $section_id, $series_title_prefix . " " . $NAME, $PRICE_EUR, $P, $DETAIL_PICTURE));
            add_element($iblock_id, $section_id, $series_title_prefix . " " . $NAME, $PRICE_EUR, $P, $DETAIL_PICTURE);
        } else {
            echo "Не добавлен!<br>";
            echo $w . " " . $h . " " . $d . "<br>";
        }
    }
}

clear_section("4", "29");

add_elements_from_file("series19.csv", "4", "29", "19\"", "Термошкафы антивандальные ", 1, Array());

