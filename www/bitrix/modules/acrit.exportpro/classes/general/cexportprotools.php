<?php

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog;

\Bitrix\Main\Loader::includeModule( "acrit.exportpro" );

Loc::loadMessages( __FILE__ );

class CAcritExportproTools{
    private $iblockIncluded = false;
    
    public function __construct(){
        $this->iblockIncluded = @CModule::IncludeModule( "iblock" );
    } 
    
    public function RoundNumber( $number, $precision, $mode, $precision_default = false ){
        switch( $mode ){
            case "UP":
                $mode = PHP_ROUND_HALF_UP;
                break;
            case "DOWN":
                $mode = PHP_ROUND_HALF_DOWN;
                break;
            case "EVEN":
                $mode = PHP_ROUND_HALF_EVEN;
                break;
            case "ODD":
                $mode = PHP_ROUND_HALF_ODD;
                break;
            default:
                $mode = PHP_ROUND_HALF_UP;
                break;
        }
        
        if( !is_numeric( $number ) && !is_float( $number ) ){
            return $number;
        }
        
        if( is_numeric( $precision ) ){
            return round( $number, abs( $precision ), $mode );
        }
        elseif( $precision_default !== false ){
            return round( $number, abs( $precision_default ), $mode );
        }
        
        return $number;
    }
    
    public function BitrixRoundNumber( $priceValue, $priceCode ){
        \Bitrix\Main\Loader::includeModule( "catalog" );
        
        $resultPrice = false;
        $arPriceCode = explode( "_", $priceCode );
        $arBitrixRoundRules = \Bitrix\Catalog\Product\Price::getRoundRules( $arPriceCode[1] );
        $resultPrice = Catalog\Product\Price::roundValue( $priceValue, $arBitrixRoundRules[0]["ROUND_PRECISION"], $arBitrixRoundRules[0]["ROUND_TYPE"] );
        
        return $resultPrice;
    }
    
    private function ArrayMultiply( &$arResult, $arTuple, $arTemp = array() ){
        if( $arTuple ){
            reset( $arTuple );
            list( $key, $head ) = each( $arTuple );
            unset( $arTuple[$key] );
            $arTemp[$key] = false;
            if( is_array( $head ) ){
                if( empty( $head ) ){
                    if( empty( $arTuple ) )
                        $arResult[] = $arTemp;
                    else
                        self::ArrayMultiply( $arResult, $arTuple, $arTemp );
                }
                else{
                    foreach( $head as $value ){
                        $arTemp[$key] = $value;
                        if( empty( $arTuple ) )
                            $arResult[] = $arTemp;
                        else
                            self::ArrayMultiply( $arResult, $arTuple, $arTemp );
                    }
                }
            }
            else{
                $arTemp[$key] = $head;
                if( empty( $arTuple ) )
                    $arResult[] = $arTemp;
                else
                    self::ArrayMultiply( $arResult, $arTuple, $arTemp );
            }
        }
        else{
            $arResult[] = $arTemp;
        }
    }
    
    public function ExportArrayMultiply( &$arResult, $arTuple, $arTemp = array() ){        
        if( count( $arTuple ) == 0 ){
            $arResult[] = $arTemp;
        }
        else{
            $head = array_shift( $arTuple );
            $arTemp[] = false;
            if( is_array( $head ) ){
                if( empty( $head ) ){
                    $arTemp[count( $arTemp ) - 1] = "";
                    self::ArrayMultiply( $arResult, $arTuple, $arTemp );
                }
                else{
                    foreach( $head as $key => $value ){
                        $arTemp[count( $arTemp ) - 1] = $value;
                        self::ExportArrayMultiply( $arResult, $arTuple, $arTemp );
                    }
                }
            }
            else{
                $arTemp[count( $arTemp ) - 1] = $head;
                self::ExportArrayMultiply( $arResult, $arTuple, $arTemp );
            }
        }
    }
    
    public function GetYandexDateTime( $dateTime ){
        global $DB;
        $resultTime = false;
        
        $localTime = new DateTime();
        $dateTimeZoneDiff = $localTime->getOffset() / 3600;
        
        $dateTimeZone = ( ( intval( $dateTimeZoneDiff ) > 0 ) ? "+" : "-" ).date( "H:i", mktime( $dateTimeZoneDiff, 0, 0, 0, 0, 0 ) );
        
        $dateTimeValue = MakeTimeStamp( $dateTime );
        $dateTimeFormattedValue = date( "Y-m-d", $dateTimeValue )."T".date( "H:i:s", $dateTimeValue );
        
        $resultTime = $dateTimeFormattedValue.$dateTimeZone;
        
        return $resultTime;
    }
    
    public function GetIblockUserFields( $iblockId ){
        $result = false;
        $dbSectionUserFields = CUserTypeEntity::GetList(
            array(),
            array(
                "ENTITY_ID" => "IBLOCK_".$iblockId."_SECTION",
                "LANG" => LANGUAGE_ID
            )
        );
        
        while( $arSectionUserFields = $dbSectionUserFields->Fetch() ){
            if( !$result ) $result = array();
            $result[] = $arSectionUserFields;
        }
        
        return $result;
    }
    
    public function CheckCondition( $arItem, $code ){
        unset( $GLOBALS["CHECK_COND"] );
        if( is_array( $arItem["SECTION_ID"] ) && is_array( $arItem["SECTION_PARENT_ID"] ) )
            $arItem["SECTION_ID"] = array_merge( $arItem["SECTION_ID"], $arItem["SECTION_PARENT_ID"] );
        
        $GLOBALS["CHECK_COND"] = $arItem;
        
        return eval( "return $code;" );
    }
    
    public function GetStringCharset( $str ){ 
        $resEncoding = "cp1251";
        
        if( preg_match( "#.#u", $str ) ){
            $resEncoding = "utf8";
        }
        
        return $resEncoding;
    }
    
    public function GetSectionNavChain( $sectionId ){
        static $arResult = null;
        if( !is_null( $arResult ) )
            return $arResult;

        $arResult = array();

        $dbSectionList = CIBlockSection::GetNavChain(
            false,
            $sectionId
        );

        while( $arSection = $dbSectionList->GetNext() ){
            $arResult[] = $arSection["ID"];
        }

        return $arResult;
    }
    
    public function AcritTruncateText( $text, $lenght ){
        $truncatedString = $text;
        
        $arMbStringData = mb_get_info();
        
        if( ( strlen( $truncatedString ) > $lenght ) && is_array( $arMbStringData ) && !empty( $arMbStringData ) ){
            $truncatedString = rtrim( mb_substr( $truncatedString, 0, $lenght, mb_detect_encoding( $truncatedString, "auto" ) ) )."...";
        }
        
        return $truncatedString;
    }
    
    public function ProcessMarketCategoriesOnEmpty( &$arCategoryList ){
        $bNotEmptyMarketCategoryListValue = false;
        
        $temp = array();
        if( is_array( $arCategoryList ) && !empty( $arCategoryList ) ){
            foreach( $arCategoryList as $k => $v ){
                $bNotEmptyCurrentMarketCategoryListValue = false;
                if( strlen( trim( $v ) ) > 0 ){
                    if( !$bNotEmptyMarketCategoryListValue ){
                        $bNotEmptyMarketCategoryListValue = true;
                    }
                    $bNotEmptyCurrentMarketCategoryListValue = true;
                }
                
                if( $bNotEmptyCurrentMarketCategoryListValue ){
                    $rsParentSection = CIBlockSection::GetByID( $k );
                    if( $arParentSection = $rsParentSection->GetNext() ){
                        $temp[$k] = $arParentSection["IBLOCK_SECTION_ID"];
        
                        $arFilter = array(
                            "IBLOCK_ID" => $arParentSection["IBLOCK_ID"],
                            ">LEFT_MARGIN" => $arParentSection["LEFT_MARGIN"],
                            "<RIGHT_MARGIN" => $arParentSection["RIGHT_MARGIN"],
                            ">DEPTH_LEVEL" => $arParentSection["DEPTH_LEVEL"]
                        );
                        
                        $rsSect = CIBlockSection::GetList(
                            array(
                                "left_margin" => "asc"
                            ),
                            $arFilter,
                            false,
                            array(
                                "ID",
                                "IBLOCK_SECTION_ID"
                            )
                        );
                        
                        while( $arSect = $rsSect->GetNext() ){
                            $temp[$arSect["ID"]] = $arSect["IBLOCK_SECTION_ID"];
                        }
                    }
                }    
            }
        }
        if( $bNotEmptyMarketCategoryListValue ){
            $maxDepth = 0;
            $i = 0;
            $rsSect = CIBlockSection::GetList( array( "DEPTH_LEVEL" => "DESC" ), array( ">IBLOCK_ID" => 0 ), false, array( "DEPTH_LEVEL" ) );
            while( $arSect = $rsSect->GetNext() ){
                $i++;
                $maxDepth = $arSect["DEPTH_LEVEL"];
                if( $i == 1 ){
                    break;
                }
            }

            foreach( $temp as $k => $v ){
                $tempCatName = "";
                if( $arCategoryList[$k] ){
                    $tempCatName = $arCategoryList[$k];
                }

                $j = 0;
                while( $j++ < $maxDepth ){
                    foreach( $temp as $k_ => $v_ ){
                        if( $v_ == $k ){
                            if( $arCategoryList[$k_] ){
                                $tempCatName = $arCategoryList[$k_];
                            }
                            else{
                                if( $tempCatName ){
                                    $arCategoryList[$k_] = $tempCatName;
                                }
                            }
                        }
                    }
                }
            }
        }
        unset( $temp );
        
        return $bNotEmptyMarketCategoryListValue;
    }
    
    public function NormalisePath( $path ){
        $arPathParts = explode( "/", $path );
        $arSafe = array();
        foreach( $arPathParts as $idx => $pathPart ){
            if( empty( $pathPart ) || ( "." == $pathPart ) ){
                continue;
            }
            elseif( ".." == $pathPart ){
                array_pop( $arSafe );
                continue;
            }
            else{
                $arSafe[] = $pathPart;
            }
        }

        $path = "/".implode( "/", $arSafe );
        return $path;
    }
    
    public function GetIblockListObject( $order, $arFilter, $arNavStartParams, $bStepExport ){
        $dbElements = false;
        
        $dbElements = CIBlockElement::GetList(
            $order,
            $arFilter,
            false,
            (  $bStepExport ) ? false : $arNavStartParams,
            array()
        );
        
        return $dbElements;
    }
    
    public function GetSiteDocumentRoot( $siteId ){
        $result = false;
        
        $dbSite = CSite::GetByID( $siteId );
        if( ( $arSite = $dbSite->Fetch() ) && ( strlen( $arSite["DOC_ROOT"] ) > 0 ) ){
            $result = $arSite["DOC_ROOT"];            
        }
        
        return $result;
    }
}