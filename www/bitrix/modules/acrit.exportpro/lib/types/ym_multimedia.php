<?php
IncludeModuleLangFile( __FILE__ );

$profileTypes["ym_multimedia"] = array(
	"CODE" => "ym_multimedia",
    "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_NAME" ),
	"DESCRIPTION" => GetMessage( "ACRIT_EXPORTPRO_PODDERJIVAETSA_ANDEK" ),
	"REG" => "http://market.yandex.ru/",
	"HELP" => "http://help.yandex.ru/partnermarket/export/feed.xml",
	"FIELDS" => array(
		array(
			"CODE" => "ID",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_ID" ),
            "VALUE" => "ID",
			"REQUIRED" => "Y",
            "TYPE" => "field",
		),
		array(
			"CODE" => "AVAILABLE",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_AVAILABLE" ),
			"VALUE" => "",
            "TYPE" => "const",
            "CONDITION" => array(
                "CLASS_ID" => "CondGroup",
                "DATA" => array(
                    "All" => "AND",
                    "True" => "True"
                ),
                "CHILDREN" => array(
                    array(
                        "CLASS_ID" => "CondCatQuantity",
                        "DATA" => array(
                                "logic" => "EqGr",
                                "value" => "1"
                        )
                    )
                )
            ),
            "USE_CONDITION" => "Y",
            "CONTVALUE_TRUE" => "true",
            "CONTVALUE_FALSE" => "false",
		),
		array(
            "CODE" => "BID",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_BID" ),
            "VALUE" => "",
        ),
        array(
            "CODE" => "CBID",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_CBID" ),
            "VALUE" => "",
        ),
        array(
            "CODE" => "FEE",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_FEE" ),
            "VALUE" => "",
        ),
		array(
			"CODE" => "URL",
			"NAME" => "URL ".GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_URL" ),
			"VALUE" => "DETAIL_PAGE_URL",
            "TYPE" => "field",
		),
		array(
			"CODE" => "PRICE",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_PRICE" ),
			"REQUIRED" => "Y",
            "TYPE" => "const",
            "CONTVALUE_TRUE" => "0",
		),
		array(
			"CODE" => "CURRENCYID",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_CURRENCY" ),
			"REQUIRED" => "Y",
            "TYPE" => "const",
            "CONTVALUE_TRUE" => "RUB",
		),
		array(
			"CODE" => "CATEGORYID",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_CATEGORY" ),
			"VALUE" => "IBLOCK_SECTION_ID",
			"REQUIRED" => "Y",
            "TYPE" => "field",
		),
		array(
			"CODE" => "PICTURE",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_PICTURE" ),
		),
         array(
			"CODE" => "STORE",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_STORE" ),
		),
        array(
			"CODE" => "PICKUP",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_PICKUP" ),
		),
        array(
			"CODE" => "DELIVERY",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_DELIVERY" ),
		),
        array(
			"CODE" => "ARTIST",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_ARTIST" ),
		),
        array(
			"CODE" => "TITLE",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_TITLE" ),
            "VALUE" => "NAME",
            "REQUIRED" => "Y",
            "TYPE" => "field",
		),
		array(
			"CODE" => "YEAR",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_YEAR" ),
		),
		array(
            "CODE" => "MEDIA",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_MEDIA" ),
        ),        
        array(
            "CODE" => "STARRING",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_STARRING" ),
        ),
        array(
            "CODE" => "DIRECTOR",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_DIRECTOR" ),
        ),
        array(
            "CODE" => "ORIGINALNAME",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_ORIGINALNAME" ),
        ),
        array(
			"CODE" => "COUNTRY",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_COUNTRY" ),
		),
        array(
			"CODE" => "DESCRIPTION",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_DESCRIPTION" ),
		),
        array(
			"CODE" => "AGE",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_AGE" ),
		),
		array(
			"CODE" => "BARCODE",
			"NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_BARCODE" ),
		),
        array(
            "CODE" => "UTM_SOURCE",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_UTM_SOURCE" ),
            "REQUIRED" => "Y",
            "TYPE" => "const",
            "CONTVALUE_TRUE" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_UTM_SOURCE_VALUE" )
        ),
        array(
            "CODE" => "UTM_MEDIUM",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_UTM_MEDIUM" ),
            "REQUIRED" => "Y",
            "TYPE" => "const",
            "CONTVALUE_TRUE" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_UTM_MEDIUM_VALUE" )
        ),
        array(
            "CODE" => "UTM_TERM",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_UTM_TERM" ),
            "TYPE" => "field",
            "VALUE" => "ID",
        ),
        array(
            "CODE" => "UTM_CONTENT",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_UTM_CONTENT" ),
            "TYPE" => "field",
            "VALUE" => "ID",
        ),
        array(
            "CODE" => "UTM_CAMPAIGN",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_UTM_CAMPAIGN" ),
            "TYPE" => "field",
            "VALUE" => "IBLOCK_SECTION_ID",
        ),
	),
	"FORMAT" => '<?xml version="1.0" encoding="#ENCODING#"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="#DATE#">
    <shop>
        <name>#SHOP_NAME#</name>
        <company>#COMPANY_NAME#</company>
        <url>#SITE_URL#</url>
        <currencies>#CURRENCY#</currencies>
        <categories>#CATEGORY#</categories>
        <offers>
            #ITEMS#
        </offers>
    </shop>
</yml_catalog>',
    
	"DATEFORMAT" => "Y-m-d_h:i",
);

$bCatalog = false;
if( CModule::IncludeModule( "catalog" ) ){
    $arBasePrice = CCatalogGroup::GetBaseGroup();
    $basePriceCode = "CATALOG-PRICE_".$arBasePrice["ID"];
    $basePriceCodeWithDiscount = "CATALOG-PRICE_".$arBasePrice["ID"]."_WD";
    $bCatalog = true;
    
    $profileTypes["ym_multimedia"]["FIELDS"][6] = array(
        "CODE" => "PRICE",
        "NAME" => GetMessage( "ACRIT_EXPORTPRO_MARKET_MULTIMEDIA_FIELD_PRICE" ),
        "REQUIRED" => "Y",
        "TYPE" => "field",
        "VALUE" => $basePriceCode,
    );
}

$profileTypes["ym_multimedia"]["PORTAL_REQUIREMENTS"] = GetMessage( "ACRIT_EXPORTPRO_TYPE_MARKET_MULTIMEDIA_PORTAL_REQUIREMENTS" );
$profileTypes["ym_multimedia"]["PORTAL_VALIDATOR"] = GetMessage( "ACRIT_EXPORTPRO_TYPE_MARKET_MULTIMEDIA_PORTAL_VALIDATOR" );
$profileTypes["ym_multimedia"]["EXAMPLE"] = GetMessage( "ACRIT_EXPORTPRO_TYPE_MARKET_MULTIMEDIA_EXAMPLE" );

$profileTypes["ym_multimedia"]["CURRENCIES"] =
    "<currency id='#CURRENCY#' rate='#RATE#' plus='#PLUS#'></currency>".PHP_EOL;

$profileTypes["ym_multimedia"]["SECTIONS"] =
    "<category id='#ID#'>#NAME#</category>".PHP_EOL;

$profileTypes["ym_multimedia"]["ITEMS_FORMAT"] = "
<offer id=\"#ID#\" type=\"artist.title\" available=\"#AVAILABLE#\" bid=\"#BID#\" cbid=\"#CBID#\" fee=\"#FEE#\">
    <url>#SITE_URL##URL#?utm_source=#UTM_SOURCE#&amp;utm_medium=#UTM_MEDIUM#&amp;utm_term=#UTM_TERM#&amp;utm_content=#UTM_CONTENT#&amp;utm_campaign=#UTM_CAMPAIGN#</url>
    <price>#PRICE#</price>
    <currencyId>#CURRENCYID#</currencyId>
    <categoryId>#CATEGORYID#</categoryId>
    <market_category>#MARKET_CATEGORY#</market_category>
    <picture>#SITE_URL##PICTURE#</picture>
    <store>#STORE#</store>
    <pickup>#PICKUP#</pickup>
    <delivery>#DELIVERY#</delivery>
    <artist>#ARTIST#</artist>
    <year>#YEAR#</year>
    <media>#MEDIA#</media>
    <starring>#STARRING#</starring>
    <director>#DIRECTOR#</director>
    <originalName>#ORIGINALNAME#</originalName>
    <country>#COUNTRY#</country>
    <title>#TITLE#</title>
    <description>#DESCRIPTION#</description>
    <age>#AGE#</age>
    <barcode>#BARCODE#</barcode>
</offer>
";