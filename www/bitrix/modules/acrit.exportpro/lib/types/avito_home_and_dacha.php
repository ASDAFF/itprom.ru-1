<?php
IncludeModuleLangFile( __FILE__ );

$profileTypes["avito_home_and_dacha"] = array(
    "CODE" => "avito_home_and_dacha",
    "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_NAME" ),
    "DESCRIPTION" => GetMessage( "ACRIT_EXPORTPRO_PODDERJIVAETSA_ANDEK" ),
    "REG" => "http://market.yandex.ru/",
    "HELP" => "http://help.yandex.ru/partnermarket/export/feed.xml",
    "FIELDS" => array(
        array(
            "CODE" => "Id",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_ID" ),
            "VALUE" => "ID",
            "REQUIRED" => "Y",
            "TYPE" => "field",
        ),
        array(
            "CODE" => "DateBegin",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_DATEBEGIN" ),
        ),
        array(
            "CODE" => "DateEnd",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_DATEEND" ),
        ),
        array(
            "CODE" => "AdStatus",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_ADSTATUS" ),
        ),
        array(
            "CODE" => "AllowEmail",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_ALLOWEMAIL" ),
        ),
        array(
            "CODE" => "ManagerName",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_MANAGERNAME" ),
        ),
        array(
            "CODE" => "ContactPhone",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_CONTACTPHONE" ),
        ),
        array(
            "CODE" => "Region",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_REGION" ),
            "REQUIRED" => "Y",
        ),
        array(
            "CODE" => "City",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_CITY" ),
            "REQUIRED" => "Y",
        ),
        array(
            "CODE" => "District",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_DISTRICT" ),
            "REQUIRED" => "Y",
        ),
        array(
            "CODE" => "Subway",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_SUBWAY" ),
        ),
        array(
            "CODE" => "Category",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_CATEGORY" ),
            "REQUIRED" => "Y",
        ),
        array(
            "CODE" => "GoodsType",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_GOODSTYPE" ),
        ),
        array(
            "CODE" => "Title",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_TITLE" ),
            "REQUIRED" => "Y",
        ),
        array(
            "CODE" => "Description",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_DESCRIPTION" ),
            "REQUIRED" => "Y",
        ),
        array(
            "CODE" => "Price",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_PRICE" ),
            "TYPE" => "const",
            "CONTVALUE_TRUE" => "0",
        ),
        array(
            "CODE" => "Image",
            "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_IMAGE" ),
        ),
    ),
    "FORMAT" => '<?xml version="1.0"?>
<Ads formatVersion="3" target="Avito.ru">
    #ITEMS#
</Ads>',
    
    "DATEFORMAT" => "Y-m-d",
);

$bCatalog = false;
if( CModule::IncludeModule( "catalog" ) ){
    $arBasePrice = CCatalogGroup::GetBaseGroup();
    $basePriceCode = "CATALOG-PRICE_".$arBasePrice["ID"];
    $basePriceCodeWithDiscount = "CATALOG-PRICE_".$arBasePrice["ID"]."_WD";
    $bCatalog = true;
    
    $profileTypes["avito_home_and_dacha"]["FIELDS"][15] = array(
        "CODE" => "Price",
        "NAME" => GetMessage( "ACRIT_EXPORTPRO_AVITO_HOME_AND_DACHA_FIELD_PRICE" ),
        "TYPE" => "field",
        "VALUE" => $basePriceCode,
    );
}

$profileTypes["avito_home_and_dacha"]["PORTAL_REQUIREMENTS"] = GetMessage( "ACRIT_EXPORTPRO_TYPE_AVITO_HOME_AND_DACHA_PORTAL_REQUIREMENTS" );
$profileTypes["avito_home_and_dacha"]["PORTAL_VALIDATOR"] = GetMessage( "ACRIT_EXPORTPRO_TYPE_AVITO_HOME_AND_DACHA_PORTAL_VALIDATOR" );
$profileTypes["avito_home_and_dacha"]["EXAMPLE"] = GetMessage( "ACRIT_EXPORTPRO_TYPE_AVITO_HOME_AND_DACHA_EXAMPLE" );

$profileTypes["avito_home_and_dacha"]["CURRENCIES"] = "";

$profileTypes["avito_home_and_dacha"]["SECTIONS"] = "";

$profileTypes["avito_home_and_dacha"]["ITEMS_FORMAT"] = "
<Ad>
    <Id>#Id#</Id>
    <DateBegin>#DateBegin#</DateBegin>
    <DateEnd>#DateEnd#</DateEnd>
    <AdStatus>#AdStatus#</AdStatus>
    <AllowEmail>#AllowEmail#</AllowEmail>
    <ManagerName>#ManagerName#</ManagerName>
    <ContactPhone>#ContactPhone#</ContactPhone>
    <Region>#Region#</Region>
    <City>#City#</City>
    <District>#District#</District>
    <Subway>#Subway#</Subway>
    <Category>#Category#</Category>
    <GoodsType>#GoodsType#</GoodsType>
    <Title>#Title#</Title>
    <Description>#Description#</Description>
    <Price>#Price#</Price>
    <Images>
        <Image url=\"#SITE_URL##Image#\"></Image>
    </Images>
</Ad>
";