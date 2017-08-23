<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test2");
?>

<?php

$row = 1;
$section_id=19;
$prefix="TL";
if (($handle = fopen("seriesTL.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $ARTNUMBER="";
        $BRAND_REF="";
        $TB_SERIES="";
        $TB_WIDTH="";
        $TB_HEIGHT="";
        $TB_DEPTH="";
        $TB_PANELS="";
        $TB_DBK_COOL="";
        $TB_DBK_HEAT="";
        $TB_RESH="";
        $TB_FAN="";
        $TB_FAN_RESH="";
        $TB_DIN_ROZ="";
        $TB_DIN_AUTO="";
        $TB_KLEMM="";
        $TB_DIN_METIZ="";
        $TB_UTEPLITEL="";
        $TB_OPTION="";

        $PRICE_EUR="";
        $NAME="";

        $num = count($data);


        if ($row == 1) {
            $row ++;
            continue;
        }
        echo "<p> ======Описание очередного товара======= $num полей в строке $row: <br /></p>\n";
        for ($c=0; $c < $num; $c++) {
            $str = $data[$c];
            if ($c == 1) { //Производитель
                if ($str == "Риттал")
                    $BRAND_REF="rittal";
                elseif ($str == "ВЭ")
                    $BRAND_REF="ve";
            } elseif ($c == 2) { //Габариты + опция
                $r = explode("+", $str);

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
                } else {
                    echo "WRONG SIZE!";
                }
            } elseif ($c == 5) {
                if (strlen($str) > 0) {
                    $TB_DBK_COOL = "130";
                }
            } elseif ($c == 6) {
                if (strlen($str) > 0) {
                    $TB_DBK_HEAT = "132";
                }
            } elseif ($c == 8) {
                if (strlen($str) > 0) {
                    $TB_RESH = "134";
                }
            } elseif ($c == 9) {
                if (strlen($str) > 0) {
                    $TB_FAN = "136";
                }
            } elseif ($c == 10) {
                if (strlen($str) > 0) {
                    $TB_FAN_RESH = "138";
                }
            } elseif ($c == 11) {
                if (strlen($str) > 0) {
                    $TB_DIN_ROZ = "140";
                }
            } elseif ($c == 12) {
                if (strlen($str) > 0) {
                    $TB_DIN_AUTO = "142";
                }
            } elseif ($c == 13) {
                if (strlen($str) > 0) {
                    $TB_KLEMM = "144";
                }
            } elseif ($c == 14) {
                if (strlen($str) > 0) {
                    $TB_DIN_METIZ = "146";
                }
            } elseif ($c == 15) {
                if (strlen($str) > 0) {
                    $TB_UTEPLITEL = "148";
                }
            } elseif ($c == 18) { //Цена в евро
                $PRICE_EUR = str_replace(" ", "", (str_replace("€", "", $str)));
                echo  "Цена ($PRICE_EUR) евро<br />\n";
            }
        }

        $PROP_VALUES = Array($ARTNUMBER="",
            "BRAND_REF"=>$BRAND_REF,
            "TB_SERIES"=>$TB_SERIES,
            "TB_WIDTH"=>$TB_WIDTH,
            "TB_HEIGHT"=>$TB_HEIGHT,
            "TB_DEPTH"=>$TB_DEPTH,
            "TB_PANELS"=>$TB_PANELS,
            "TB_DBK_COOL"=>$TB_DBK_COOL,
            "TB_DBK_HEAT"=>$TB_DBK_HEAT,
            "TB_RESH"=>$TB_RESH,
            "TB_FAN"=>$TB_FAN,
            "TB_FAN_RESH"=>$TB_FAN_RESH,
            "TB_DIN_ROZ"=>$TB_DIN_ROZ,
            "TB_DIN_AUTO"=>$TB_DIN_AUTO,
            "TB_KLEMM"=>$TB_KLEMM,
            "TB_DIN_METIZ"=>$TB_DIN_METIZ,
            "TB_UTEPLITEL"=>$TB_UTEPLITEL,
            "TB_OPTION"=>$TB_OPTION
        );

        print_r($PROP_VALUES);

        $el = new CIBlockElement;
        //$el->Update("1043", Array("NAME" => "MYCHANGE"));

        $w = intval($TB_WIDTH);
        $h = intval($TB_HEIGHT);
        $d = intval($TB_DEPTH);

        $NAME = $prefix . "-" . $w / 10 . $h / 10 . $d;

        $arFields = array(
            "IBLOCK_ID" => 4,
            "NAME" => $NAME,
            "CODE" => "php_product" . rand(1, 10000),
            "ACTIVE" => "Y",
            "IBLOCK_SECTION_ID" => $section_id,
            "DETAIL_TEXT" => "asdf",
            "DETAIL_TEXT_TYPE" => "html",
            "PROPERTY_VALUES" => $PROP_VALUES
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

        $row++;
    }
    fclose($handle);
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>