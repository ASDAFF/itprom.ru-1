<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

$arComponentParameters = array(
    "GROUPS" => array(
    ),
    "PARAMETERS" => array(
        "SORT_LIST_CODES" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("SORT_LIST_CODES"),
            'TYPE' => 'STRING',
            "MULTIPLE" => "Y",
            "DEFAULT" => array(
                0 => 'price_asc',
                1 => 'price_desc',
                2 => 'manufacture',
                3 => 'manufacture_price_asc',
            ),
        ),
        "SORT_LIST_FIELDS" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("SORT_LIST_FIELDS"),
            'TYPE' => 'STRING',
            "MULTIPLE" => "Y",
            "DEFAULT" => array(
                0 => 'PROPERTY_MIN_PRICE',
                1 => 'PROPERTY_MIN_PRICE',
                2 => 'PROPERTY_MANUFACTURE.NAME',
                3 => 'PROPERTY_MANUFACTURE.NAME;PROPERTY_MIN_PRICE',
            ),
        ),
        "SORT_LIST_ORDERS" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("SORT_LIST_ORDERS"),
            'TYPE' => 'STRING',
            "MULTIPLE" => "Y",
            "DEFAULT" => array(
                0 => 'asc,nulls',
                1 => 'desc,nulls',
                2 => 'asc,nulls',
                3 => 'asc;asc,nulls',
            ),
        ),
        "SORT_LIST_NAME" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("SORT_LIST_NAME"),
            'TYPE' => 'STRING',
            "MULTIPLE" => "Y",
            "DEFAULT" => array(
                0 => GetMessage("SORT_LIST_NAME_PRICE_ASC"),
                1 => GetMessage("SORT_LIST_NAME_PRICE_DESC"),
                2 => GetMessage("SORT_LIST_NAME_MANUFACTURE"),
                3 => GetMessage("SORT_LIST_NAME_MANUFACTURE_PRICE"),
            ),
        ),
    ),
);