<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

$arComponentParameters = array(
    "GROUPS" => array(
    ),
    "PARAMETERS" => array(
        "PAGE_TO_LIST" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("PAGE_TO_LIST"),
            'TYPE' => 'STRING',
            "MULTIPLE" => "Y",
            "DEFAULT" => array(
                0 => '15',
                1 => '60',
                2 => 'ALL',
            ),
        ),
        "PAGE_ELEMENT_COUNT" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("PAGE_ELEMENT_COUNT"),
            'TYPE' => 'STRING',
            "MULTIPLE" => "N",
            "DEFAULT" => "5",
        ),
    ),
);