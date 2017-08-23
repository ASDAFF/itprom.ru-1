<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Сантехники +\"");
?>

<h1>Hello, world!</h1>

<?php
    $el = new CIBlockElement;
    //$el->Update("1043", Array("NAME" => "MYCHANGE"));
    $arFields = array(
        "IBLOCK_ID" => 4,
        "NAME" => "ADDED FROM PHP2",
        "CODE" => "php_product" . rand(1, 10000),
        "ACTIVE" => "Y",
        "IBLOCK_SECTION_ID" => 17,
        "DETAIL_TEXT" => "asdf",
        "DETAIL_TEXT_TYPE" => "html",
        "PROPERTY_VALUES" => Array(
            "BRAND_REF" => "1marka",
            "TB_WIDTH" => 5000,
            "TB_UTEPLITEL" => 148
        )
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
                "PRICE" => 12345.65,
                "CURRENCY" => "EUR"
            );

            CPrice::Add($arFields);
        }
        else
            echo "Ошибка добавления параметров товаров";
    }
    else
        echo "Error: " . $el->LAST_ERROR . "<br>";

    $res = CIBlockElement::GetList (
        Array(),
        Array("IBLOCK_ID"=>4),
        false,
        Array (),
        Array("ID", "NAME")
    );

    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        echo "<h1>" . $arFields["NAME"] . "</h1>n<br>";
        print_r($arFields);
        echo "<br>";
    }

    //$cElement = new CIBlockElement;

    //$count = CIBlockElement::GetCount();
    //echo $count + "<br>";
    //echo CIBLockElement::Add(Array("IBLOCK_ID"=>4, "NAME"=>"TEST NAME"))

    //print_r($res)
?>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
