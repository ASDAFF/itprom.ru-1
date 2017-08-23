<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");



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

function add_element ($iblock_id, $section_id, $NAME, $PRICE_EUR, $P, $DETAIL_PICTURE) {
    $el = new CIBlockElement;

    //test_dump($P);

    $arFields = array(
        "IBLOCK_ID" => $iblock_id,
        "NAME" => $NAME,
        "CODE" => $P["ARTNUMBER"],
        "ACTIVE" => "Y",
        "IBLOCK_SECTION_ID" => $section_id,
        "DETAIL_TEXT" => "",
        "DETAIL_TEXT_TYPE" => "html",
        "PROPERTY_VALUES" => $P,
        "DETAIL_PICTURE" => $DETAIL_PICTURE
    );

    if ($last_el_id = $el->Add($arFields))
    {
        echo 'New ID: ' . $last_el_id . '<br>';

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

function emptyOrValue($str, $value) {
    if ($str == "")
        return "";
    else
        return $value;
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

function add_elements_from_file($filename, $iblock_id, $section_id, $series_name, $series_title_prefix, $price_multiplier) {
    $image_files = scan_Dir("images/tb-images");
    chdir("..");
    test_dump($image_files);

    //Получить мощность и IP
    $power_file = file("power_and_ip.csv");
    $power_and_ip = array_map(function ($row1) {
        return explode(';', $row1);
    }, $power_file);
    test_dump($power_file);

    $file = file($filename);
    $e1 = array_map(function ($row2) {
        return explode(';', $row2);
    }, $file);

    $el_count = count($e1);
    test_dump($el_count);

    for ($i = 1; $i < $el_count; $i++) {
        test_dump($i);
        $row = $e1[$i];
        for ($j = 5; $j <= 15; $j++) {
            if ($row[$j] != "") {
                $row[$j] = "Y";
            }
        } //вместо цен ставим "Есть" или "Нет" как бы
        $row[0] = "НЕ НУЖНО";
        $row[3] = "НЕ НУЖНО";
        $row[16] = "НЕ НУЖНО";
        $row[17] = "НЕ НУЖНО";



        unset($row[19]);
        unset($row[20]);
        unset($row[21]);
        unset($row[22]);

        $BRAND_REF="itprom";

        $TB_SERIES = "";
        if ($series_name == "TL")
            $TB_SERIES = 123;
        elseif ($series_name == "T") {
            $TB_SERIES = 124;
        } elseif ($series_name == "VT") {
            $TB_SERIES = 125;
        } elseif ($series_name == "IBL") {
            $TB_SERIES = 158;
        } elseif ($series_name == "IB") {
            $TB_SERIES = 159;
        } elseif ($series_name == "IBV") {
            $TB_SERIES = 160;
        }

        $r = explode("+", $row[2]);

        $option = "NONE";
        if (count($r) == 2) {
            $option = $r[1];
            $TB_PANELS="128";
            if (substr_count($option, "оков") > 0) {
                $TB_OPTION="150";
            } elseif (substr_count($option, "лухая") > 0) {
                $TB_OPTION="151";
            } elseif (substr_count($option, "анель") > 0) {
                $TB_OPTION="152";
            }
        }

        $size = explode("x", $r[0]);

        if (count($size) == 3) {
            echo "<p>($size[0], $size[1], $size[2]) + $option <br /></p>";
            $TB_WIDTH=$size[0];
            $TB_HEIGHT=$size[1];
            $TB_DEPTH=$size[2];
        } else
            echo "WRONG SIZE!";

        if ($series_name == "VT" || $series_name == "IBV") {
            $PRICE_EUR = str_replace(" ", "", (str_replace("€", "", $row[18+1])));
        } else {
            $PRICE_EUR = str_replace(" ", "", (str_replace("€", "", $row[18])));
        }

        echo  "Цена ($PRICE_EUR) евро<br />\n";

        $w = intval($TB_WIDTH);
        $h = intval($TB_HEIGHT);
        $d = intval($TB_DEPTH);

        $power_ip_count = count($power_and_ip);
        $count = 0;
        $p_row_id = -1;
        for ($k = 0; $k < $power_ip_count; $k++) {
            $p_row = $power_and_ip[$k];
            if ($p_row[1] == $w && $p_row[2] == $h && $p_row[3] == $d) {
                $count++;
                $p_row_id = $k;
            }
        }

        $TP_HEAT_POWER="";
        $TP_IP_CLASS="";

        //$series_from_list = explode("-", $power_and_ip[$p_row_id][0])[0];
        //test_dump($series_from_list);
        //echo "Series: " . $series_name . " = " . $series_from_list . "<br>";

        if ($count == 1) {
            $TP_HEAT_POWER = $power_and_ip[$p_row_id][4];
            $TP_IP_CLASS = $power_and_ip[$p_row_id][6];
        }

        if ($series_name == "T") {
            $TP_IP_CLASS = "157";
        } elseif ($series_name == "VT") {
            $TP_IP_CLASS = "156";
        }

        if ($count == 1)
            echo "count: " . $count . "<br>";
        else
            echo "<h1>count: " . $count . "</h1><br>";

        $NAME = $series_name . "-" . $w / 10 . $h / 10 . $d;

        //$image_prefix = $w . "-" . $h . "-" . $d . " " . $series_name . " ";
        $image_prefix = $w . "-" . $h . "-" . $d . " ";

        $image_count = count($image_files);
        $MORE_PHOTO = Array();
        $MORE_PHOTO_2D = Array();
        $DETAIL_PICTURE="";

        //Если изображение ищется для серий IB* нужно искать для соответствующих серий TL, T, VT
        $series_name_img = $series_name;
        if ($series_name == "IBL") {
            $series_name_img = "TL";
        } elseif ($series_name == "IBV") {
            $series_name_img = "VT";
        } elseif ($series_name == "IB") {
            $series_name_img = "T";
        }

        for ($k = 0; $k < $image_count; $k++) {
            $image_path = $image_files[$k];
            $image_name = basename($image_path);

            //echo "Image name " . $image_name . "<br>";

            if (0 === strpos($image_name, $image_prefix) && 0 != strpos($image_path, " " . $series_name_img . " ")) {
                echo "FOUND IMAGE! " . $image_path . "<br>";
                if (strpos($image_name, "3D") != false) {
                    $MORE_PHOTO[] = CFile::MakeFileArray($image_path);
                } else {
                    $MORE_PHOTO_2D[] = CFile::MakeFileArray($image_path);
                }
            }
        }

        if (count($MORE_PHOTO) > 0) {
            $DETAIL_PICTURE = $MORE_PHOTO[0];
            unset($MORE_PHOTO[0]);
        }

        foreach ($MORE_PHOTO_2D as $PHOTO) {
            $MORE_PHOTO[] = $PHOTO;
        }


        //test_dump($MORE_PHOTO);

        if ($TP_HEAT_POWER != "") {
            $NAME = $NAME . "-" . $TP_HEAT_POWER;
        }

        echo $NAME . "<br>";

        if ($series_name != "VT" || $series_name != "IBV") {
            $P = Array(
                "ARTNUMBER" => $NAME,
                "BRAND_REF"=> $BRAND_REF,
                "TB_SERIES"=>$TB_SERIES,
                "TB_WIDTH"=>$TB_WIDTH,
                "TB_HEIGHT"=>$TB_HEIGHT,
                "TB_DEPTH"=>$TB_DEPTH,
                "TB_PANELS"=>$TB_PANELS,
                "TB_DBK_COOL"=>emptyOrValue($row[5], 130),
                "TB_DBK_HEAT"=>emptyOrValue($row[6], 132),
                "TB_RESH"=>emptyOrValue($row[8], 134),
                "TB_FAN"=>emptyOrValue($row[9], 136),
                "TB_FAN_RESH"=>emptyOrValue($row[10], 138),
                "TB_DIN_ROZ"=>emptyOrValue($row[11], 140),
                "TB_DIN_AUTO"=>emptyOrValue($row[12], 1142),
                "TB_KLEMM"=>emptyOrValue($row[13], 144),
                "TB_DIN_METIZ"=>emptyOrValue($row[14], 146),
                "TB_UTEPLITEL"=>emptyOrValue($row[15], 148),
                "TB_OPTION"=>$TB_OPTION,
                "TP_IP_CLASS" => $TP_IP_CLASS,
                "TP_HEAT_POWER" => $TP_HEAT_POWER,
                "MORE_PHOTO" => $MORE_PHOTO
            );
        } else {
            $P = Array(
                "ARTNUMBER" => $NAME,
                "BRAND_REF"=> $BRAND_REF,
                "TB_SERIES"=>$TB_SERIES,
                "TB_WIDTH"=>$TB_WIDTH,
                "TB_HEIGHT"=>$TB_HEIGHT,
                "TB_DEPTH"=>$TB_DEPTH,
                "TB_PANELS"=>$TB_PANELS,
                "TB_DBK_COOL"=>emptyOrValue($row[5], 130),
                "TB_DBK_HEAT"=>emptyOrValue($row[6], 132),
                "TB_RESH"=>emptyOrValue($row[8], 134),
                "TB_FAN"=>emptyOrValue($row[9+1], 136),
                "TB_FAN_RESH"=>emptyOrValue($row[10+1], 138),
                "TB_DIN_ROZ"=>emptyOrValue($row[11+1], 140),
                "TB_DIN_AUTO"=>emptyOrValue($row[12+1], 1142),
                "TB_KLEMM"=>emptyOrValue($row[13+1], 144),
                "TB_DIN_METIZ"=>emptyOrValue($row[14+1], 146),
                "TB_UTEPLITEL"=>emptyOrValue($row[15+1], 148),
                "TB_OPTION"=>$TB_OPTION,
                "TP_IP_CLASS" => $TP_IP_CLASS,
                "TP_HEAT_POWER" => $TP_HEAT_POWER,
                "MORE_PHOTO" => $MORE_PHOTO
            );
        }



        $PRICE_EUR = floatval($PRICE_EUR) * $price_multiplier;

        if ($w * $w + $h * $h + $d * $d != 0) {
            add_element($iblock_id, $section_id, $series_title_prefix . " " . $NAME, $PRICE_EUR, $P, $DETAIL_PICTURE);
        } else {
            echo "Не добавлен!<br>";
            echo $w . " " . $h . " " . $d . "<br>";
        }


    }

}

clear_section(4, 40); //Удалить все элементы из серии IB
clear_section(4, 39); //Удалить все элементы из серии IBL
clear_section(4, 41); //Удалить все элементы из серии IBV

clear_section(4, 17); //Удалить все элементы из серии T
clear_section(4, 19); //Удалить все элементы из серии TL
clear_section(4, 18); //Удалить все элементы из серии VT


echo "Очищены разделы каталога T, TL, VT, IB, IBV, IBL<br>";

add_elements_from_file("seriesT.csv", 4, 17, "T", "Термобокс ", 1);
add_elements_from_file("seriesTL.csv", 4, 19, "TL", "Термобокс ", 1);
add_elements_from_file("seriesVT.csv", 4, 18, "VT", "Термобокс ", 1);

add_elements_from_file("seriesT.csv", 4, 40, "IB", "Термобокс ", 1.15);
add_elements_from_file("seriesTL.csv", 4, 39, "IBL", "Термобокс ", 1.15);
add_elements_from_file("seriesVT.csv", 4, 41, "IBV", "Термобокс ", 1.15);