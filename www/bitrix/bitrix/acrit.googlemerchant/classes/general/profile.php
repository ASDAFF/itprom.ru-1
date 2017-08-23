<?php
IncludeModuleLangFile(__FILE__);
class CGM
{
    function __construct ($prof)
    {
		global $USER;
		if(!is_object($USER)) $USER = new CUser;
		CModule::IncludeModule("iblock");
        if(CModule::IncludeModule("catalog"))
        {
            $this->isCat=true;
        }
        else $this->isCat=false;
        $pro=new CProfileAdmin();
		$cgm=new CGMExport();
        $pr=$pro->GetByID($prof)->Fetch();
		$this->ID=$pr["ID"];
		$this->Name=$pr["NAME"];
		$this->TYPE_RUN=$pr["TYPE_RUN"];
		$this->FEED=$pr["FEED"];
		$this->COMPANY=$pr["COMPANY"];
		$this->SHOPNAME=$pr["SHOPNAME"];
		$this->DOMAIN_NAME=$pr["DOMAIN_NAME"];
		$this->ACTIVE=($pr["ACTIVE"]=="Y") ? true: false;
		$this->ENCODING=$pr["ENCODING"];
        $this->IBLOCK_ID=unserialize(base64_decode($pr["IBLOCK_ID"]));
		$this->SECTION_ID=unserialize(base64_decode($pr["SECTION_ID"]));
		$this->GOOGLE_CATEGORY=unserialize(base64_decode($pr["GOOGLE_CATEGORY"]));
		$this->CONDITIONS=$pr["CONDITIONS"];
		$this->LID=$pr["LID"];
		$this->DETAIL_PAGE_URL=$pr["DETAIL_PAGE_URL"];
		$this->USE_SKU=($pr["USE_SKU"]=="Y") ? true: false;
		$this->CHECK_INCLUDE=($pr["CHECK_INCLUDE"]=="Y") ? true: false;
		$this->FORORDER=($pr["FORORDER"]=="Y") ? true: false;
		$this->OTHER=($pr["OTHER"]=="Y") ? true: false;
		$this->CONDITION_RULE=unserialize(base64_decode($pr["CONDITION_RULE"]));
		$this->PRICE=$pr["PRICE"];
		$this->XML_DATA=unserialize(base64_decode($pr["XML_DATA"]));
		$this->DATA_START=date("d-m-Y h:i:s",$pr["DATA_START"]);
		$this->PERIOD=(int)$pr["PERIOD"];
		$this->USE_XML_FILE=($pr["USE_XML_FILE"]=="Y") ? true: false;
		$this->URL_DATA_FILE=$pr["URL_DATA_FILE"];
		$this->NAMESCHEMA=$pr["NAMESCHEMA"];
		$this->arSelect = array("ID","CODE","LID","NAME","IBLOCK_ID","IBLOCK_SECTION_ID","IBLOCK_CODE","ACTIVE","DATE_ACTIVE_FROM","DATE_ACTIVE_TO","SORT","PREVIEW_PICTURE","PREVIEW_TEXT","TIMESTAMP_X","PREVIEW_TEXT_TYPE","DETAIL_PICTURE","DETAIL_TEXT","DETAIL_TEXT_TYPE","DATE_CREATE","CREATED_BY","DETAIL_PAGE_URL");
		$this->Filter=array("LID"=>"","IBLOCK_ID"=>"","SECTION_ID"=>"","ACTIVE"=>"Y","ACTIVE_DATE"=>"Y","INCLUDE_SUBSECTIONS" => "","IBLOCK_ACTIVE"=>"Y","SECTION_GLOBAL_ACTIVE"=>"Y");
		if(is_array($this->GOOGLE_CATEGORY) && sizeof($this->GOOGLE_CATEGORY)>0)
		{
			foreach($this->GOOGLE_CATEGORY as $id=>$gogle)
			{
				$this->GOOGLE_CATEGORY[$id]['THIS']=text2xml($gogle['THIS'],true,true,$this->ENCODING);
				$this->GOOGLE_CATEGORY[$id]['GOOGLE']=text2xml($gogle['GOOGLE'],false,true,$this->ENCODING);
			}
		}
		if($this->isCat)
            if(is_array($this->IBLOCK_ID))
            {
                foreach($this->IBLOCK_ID as $ibl)
                    $this->isCatalog[$ibl]=CCatalog::GetByID($ibl) ? true: false;
            }
            else
                $this->isCat=false;
        if($this->isCat && (is_array($this->isCatalog) && sizeof($this->isCatalog)>0))
        {
            foreach($this->isCatalog as $code=>$val)
            {
                if($val==1)
                {
                    $mxResult = CCatalogSKU::GetInfoByProductIBlock($code);
                    if (is_array($mxResult))
                    {
                        $this->sku_IBLOCK_ID[$code]=$mxResult['IBLOCK_ID'];
                        $this->sku_PROPERTY[$code]=$mxResult['SKU_PROPERTY_ID'];
                    }
                }
            }
        }
        if(CModule::IncludeModule("currency"))
        {
            $this->baseCur=CCurrency::GetbaseCurrency();
            if($this->baseCur=="RUB") $this->baseCur="RUB";
        }
        else $this->baseCur="RUB";
        $this->Filter['INCLUDE_SUBSECTIONS']=($this->CHECK_INCLUDE) ? "Y" : "N";
        if(sizeof($this->IBLOCK_ID)>0)
            foreach($this->IBLOCK_ID as $ibl)
            {
                $this->arFilter[$ibl]=$this->Filter;
                $this->arFilter[$ibl]["LID"]=$this->LID;
                $this->arFilter[$ibl]["IBLOCK_ID"]=$ibl;
                $this->arFilter[$ibl]["SECTION_ID"]=$this->GetSectionFromIB($ibl);
            }
        if(sizeof($this->CONDITION_RULE)>0)
        {
			$fltr=array();$skufil=array();$tmpFilter=array();$tmpFilter1=array();
			foreach($this->CONDITION_RULE as $al=>$rule)
            {
                if($al!="COUNT")
				{
					if($rule['VALUE']!="" && $rule['RULES']!="no" && $rule['PROPERTY']!=0 && !empty($rule['PROPERTY']))
					{
						$tmp=explode("-",$rule['PROPERTY']);
						$tmp1=explode("_",$tmp[1]);
						if(in_array("SKU",$tmp1))
						{//add sku filter
							$skufil[$tmp[0]][]=array("PROPERTY"=>$tmp1[1],"RULES"=>$rule['RULES'],"VALUE"=>$rule['VALUE']);
						}
						else
						{	    //add filter
							$fltr[$tmp[0]][]=array("PROPERTY"=>$tmp[1],"RULES"=>$rule['RULES'],"VALUE"=>$rule['VALUE']);
						}
					}
				}
            }
            if(is_array($fltr) && sizeof($fltr)>0)
                $tmpFilter=$cgm->SQLCondition($fltr);
            if(is_array($skufil) && sizeof($skufil)>0)
                $tmpFilter1=$cgm->SQLCondition($skufil);
            if(sizeof($this->IBLOCK_ID)>0)
                foreach($this->IBLOCK_ID as $ibl)
                {
                    if(sizeof($tmpFilter[$ibl])>0)
                        foreach($tmpFilter[$ibl] as $cond)
                            foreach($cond as $code=>$cnd)
                                $this->EditFilter($ibl,$code,$cnd);
                    if(sizeof($tmpFilter1[$ibl])>0)
                        foreach($tmpFilter1[$ibl] as $cond)
                            foreach($cond as $code=>$cnd)
                                $this->AddSkuFilter($ibl,$code,$cnd);
                }

        }
        if($this->CHECK_INCLUDE)
        {
            foreach($this->GOOGLE_CATEGORY as $id=>$v)
            {
                $rsParentSection = CIBlockSection::GetByID($id);
                if ($arParentSection = $rsParentSection->GetNext())
                {
                    $arFilter = array('ACTIVE'=>'Y','IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']);
                    $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
                    while ($arSect = $rsSect->GetNext())
                    {
                        $this->GOOGLE_CATEGORY[$arSect['ID']]=$v;
                    }
                }
            }
        }
		unset($pro);
    }
    public function GetSectionFromIB($id)
    {
        $mas=array();$otv=array();
        $items = GetIBlockSectionList($id);
        while($arItem = $items->GetNext())
            $mas[]=$arItem['ID'];
        if(sizeof($this->SECTION_ID)>0)
        {	foreach($this->SECTION_ID as $cat)
        {
            if(in_array($cat,$mas))
            {
                $otv[]=$cat;
            }
        }
        }
        return $otv;
    }
    public function AddSelect($p)
    {
        array_push($this->arSelect,$p);
    }
    public function EditFilter($id,$prop,$value)
    {
        $this->arFilter[$id][$prop]=$value;
    }
    public function AddSkuFilter($id,$prop,$value)
    {
        $this->arSKU_Filter[$id][$prop]=$value;
    }
    public function AddFilter($id,$value)
    {
        array_push($this->arFilter[$id],$value);
    }
    public function GetSection($IBLOCK_ID,$SECTIONS)
    {
        $strTmp="";
        if(CModule::IncludeModule("iblock"))
        {
            $arFilter=array("IBLOCK_ID"=>$IBLOCK_ID,"GLOBAL_ACTIVE"=>"Y","ID"=>$SECTIONS,"INCLUDE_SUBSECTIONS"=>($this->CHECK_INCLUDE) ? "Y" : "N");
            $db_list = CIBlockSection::GetList(Array("left_margin"=>"asc"), $arFilter, true);
            while($ar_result = $db_list->GetNext())
            {
                $strTmp.= $ar_result["NAME"]." > ";
            }
        }
        return $strTmp;
    }
    public function GetOtherSection()
    {
        $id=0;$section=array();$sections=array();
        foreach($this->XML_DATA as $dat)
            if ($dat['UNIT']=="g:product_type") {$id=$dat['ID'];break;}

        $tmp=explode("-",$id);
        $ibl=$tmp[0];
        $prop=$tmp[1];
        $arSelect = Array("ID", "NAME", "PROPERTY_".$prop);
        $arFilter = Array("IBLOCK_ID"=>$ibl, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false,false, $arSelect);
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $section[$arFields['ID']]=$arFields["PROPERTY_".$prop."_VALUE"];
        }
        $section=array_unique($section);
        $arFilter = Array("GLOBAL_ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS"=>($this->CHECK_INCLUDE) ? "Y" : "N");
        foreach($section as $sec)
            if($sec!='' || $sec!=0) $arFilter['ID'][]=$sec;
        $db_list = CIBlockSection::GetList(Array("left_margin"=>"asc"), $arFilter, false);
        while($ar_result = $db_list->GetNext())
        {
            if($ar_result["IBLOCK_SECTION_ID"]=="")
                $sections[]=array("ID"=>$ar_result['ID'],"NAME"=>$ar_result["NAME"],"PARENT"=>$ar_result["IBLOCK_SECTION_ID"]);
            else
            {
                $nav = CIBlockSection::GetNavChain(false, $ar_result["ID"]);
                while($arNav = $nav->GetNext())
                {
                    $sections[]=array("ID"=>$arNav["ID"],"NAME"=>$arNav["NAME"],"PARENT"=>$arNav["IBLOCK_SECTION_ID"]);
                }
            }
        }
        $strTmp='';
        foreach($sections as $sect)
        {
            $strTmp.=$sect["NAME"]." > ";
        }
        return $strTmp;
    }
    public function GetPropInData($name, $XML_DATA)
    {
        if(is_array($XML_DATA) && sizeof($XML_DATA)>0)
        {
            foreach($XML_DATA as $data)
            {
                if($data["UNIT"]==$name)
                    return $data["ID"];
                else
                    return false;
            }
        }
    }
    public function yandex_GetPrice($Product)
    {
		$prop=array();$value="";
        $prc=strlen($this->PRICE)>0 ? $this->PRICE : 0;
        if(!$this->isCat or !CCatalog::GetByID($Product["IBLOCK_ID"]))
        {
            foreach($this->XML_DATA as $data)
            {
                if(trim($data["UNIT"])=="g:price")
                {
                    $tmp=explode("-",$data["ID"]);
                    $tmp1=explode("_",$tmp);
                    if(in_array("PRICE",$tmp1))
                    {
                        $prop=$tmp[1];
                    }
                    elseif(in_array("SKU",$tmp1))
                    {
                        $prop=$tmp1[1];
                    }
                    $db_props = CIBlockElement::GetProperty($tmp[0], $Product["ID"], array("sort" => "asc"), Array("ID"=>$prop));
                    if($ar_props = $db_props->Fetch())
                    {	$value=$ar_props["VALUE"];}
                    else
                        $value="";
                    break;
                }
                else
                    $value=false;
            }
        }
        elseif($this->isCat)
        {
			if($prc>0)
            {
				$dbProductPrices1 = CPrice::GetList(array(), array("PRODUCT_ID" => $Product["ID"], "CATALOG_GROUP_ID" => $prc)) ;
                $price = 0 ;
                while($arProductPrice = $dbProductPrices1->Fetch())
                {
                    if($arProductPrice["PRICE"] && ($arProductPrice["PRICE"] < $price || !$price))
                        $price = $arProductPrice["PRICE"] ;
						
                    $arDissizeofs = CCatalogDiscount::GetDiscountByProduct($arProductPrice["PRODUCT_ID"], array(),  "N", $arProductPrice["CATALOG_GROUP_ID"], $this->LID);
                    foreach($arDissizeofs as $arDissizeof)
                    {
                        if($arDissizeof["VALUE_TYPE"] == "P")
                            $price_buf = $arProductPrice["PRICE"] - $arDissizeof["VALUE"] * $arProductPrice["PRICE"] / 100;
                        else
                            $price_buf = $arProductPrice["PRICE"] - $arDissizeof["VALUE"];
                        if($price_buf && ($price_buf < $price || !$price))
                            $price = $price_buf;
                    }
                }
                $value=$price;
				
            }
            else $value=false;
        }
        return $value;
    }
    public function GetElement($types,$MS)
    {
        $strXML="";
        $arSort=array("ID"=>"ASC");
        $arResult["OFFER"] = array();
        if(self::CheckArray($this->IBLOCK_ID))
        {
            foreach($this->IBLOCK_ID as $ibl)
            {
                $rsElements = CIBlockElement::Getlist($arSort, $this->arFilter[$ibl], false, false, $this->arSelect);
                if($this->DETAIL_PAGE_URL)
                    $rsElements->SetUrlTemplates($this->DETAIL_PAGE_URL);
                while($arOffer = $rsElements->GetNext())
                {
                    $flag=0;
                    if($this->USE_SKU && $this->sku_IBLOCK_ID[$ibl]>0)
                    {
                        if(is_array($this->arSKU_Filter[$ibl]) && sizeof($this->arSKU_Filter[$ibl])>0)
                        {
                            $skuFILTER=$this->arSKU_Filter[$ibl];
                            $skuFILTER["IBLOCK_ID"]=$this->sku_IBLOCK_ID[$ibl];
                            $skuFILTER[CGMExport::GetProp($this->sku_PROPERTY[$ibl])]=$arOffer["ID"];
                            $skuFILTER["ACTIVE"]="Y";
                        }
                        else
                        {
                            $skuFILTER["IBLOCK_ID"]=$this->sku_IBLOCK_ID[$ibl];
                            $skuFILTER["ACTIVE"]="Y";
                            $skuFILTER[CGMExport::GetProp($this->sku_PROPERTY[$ibl])]=$arOffer["ID"];
                        }
                        $arOfferInOb = CIBLockElement::GetList($arSort,$skuFILTER, false, false, $this->arSelect);
                        if($this->DETAIL_PAGE_URL)
                            $arOfferInOb->SetUrlTemplates($this->DETAIL_PAGE_URL);
                        while($arOfferIn=$arOfferInOb->GetNext())
                        {
                            $flag=1;
                            $arOfferIn1["g:availability"] = "in stock";
                            $arOfferIn1["g:id"]=$arOfferIn["ID"];
                            $arOfferIn1["g:condition"]=$this->CONDITIONS;
                            $arOfferIn1["g:item_group_id"]=$arOffer["ID"];
                            switch($this->NAMESCHEMA)
                            {
                                case "NAME_OFFER":
                                {
                                    $arOfferIn1["title"]=text2xml($arOffer["NAME"], true,true,$this->ENCODING);
                                    break;
                                }
                                case "NAME_OFFER_SKU":
                                {
                                    $arOfferIn1["title"]=text2xml($arOffer["NAME"]."/".$arOfferIn["NAME"],true, true,$this->ENCODING);
                                    break;
                                }
                                default:
                                    {
                                    $arOfferIn1["title"]=text2xml($arOfferIn["NAME"], true,true,$this->ENCODING);
                                    break;
                                    }
                            }
                            $arOfferIn1["g:price"] = $this->yandex_GetPrice(array("IBLOCK_ID"=>$this->sku_IBLOCK_ID[$ibl],"ID"=>$arOfferIn["ID"]));
							if($arOfferIn1["g:price"]>0)
                                $arOfferIn1["g:price"].=" ".$this->baseCur;
                            $tr = CCatalogProduct::GetByID($arOfferIn["ID"]);
                            if( $tr["QUANTITY_TRACE"] == "N" )
                                $arOfferIn1["g:availability"] = "in stock";
                            else
                            {
                                if( $tr["QUANTITY"] > 0 )
                                {
                                    $arOfferIn1["g:availability"] = "in stock";
                                }
                                else
								{
                                    if($this->FORORDER)
                                        $arOfferIn1["g:availability"] = "preorder";
                                    else
                                        $arOfferIn1["g:availability"] = "out of stock";
								}
                            }
                            $arOfferIn1["g:product_type"] = str_replace(">","&gt;",$this->GOOGLE_CATEGORY[$arOffer["IBLOCK_SECTION_ID"]]["THIS"]);
                            $arOfferIn1["g:google_product_category"] =str_replace(">","&gt;",$this->GOOGLE_CATEGORY[$arOffer["IBLOCK_SECTION_ID"] ? $arOffer["IBLOCK_SECTION_ID"] : $arOffer["IBLOCK_ID"]]["GOOGLE"]);
                            if($arOffer["DETAIL_PAGE_URL"])
                                $arOfferIn1["g:link_href"] = "http://".$this->DOMAIN_NAME. $arOffer["DETAIL_PAGE_URL"]."#".$arOfferIn["ID"];
                            else
                                $arOfferIn1["g:link_href"] = "http://".$this->DOMAIN_NAME. $arOffer["DETAIL_PAGE_URL"];

                            if($arOfferIn["PREVIEW_PICTURE"])
                            {
                                $db_file = CFile::GetByID($arOfferIn["PREVIEW_PICTURE"]);
                                if ($ar_file = $db_file->Fetch())
                                    $arOfferIn1["g:image_link"] = "http://".$this->DOMAIN_NAME."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".implode("/", array_map("rawurlencode", explode("/", $ar_file["FILE_NAME"])));
                            }
                            if($arOfferIn["DETAIL_PICTURE"])
                            {
                                $db_file = CFile::GetByID( $arOfferIn["DETAIL_PICTURE"] );
                                if ($ar_file = $db_file->Fetch())
                                    $arOfferIn1["g:image_link"] = "http://".$this->DOMAIN_NAME."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".implode("/", array_map("rawurlencode", explode("/", $ar_file["FILE_NAME"])));
                            }
                            if($this->GetPropInData("g:image_link",$this->XML_DATA))
                            {
                                $ph = CIBlockElement::GetProperty($this->sku_IBLOCK_ID, $arOfferIn["ID"], array("sort" => "asc"), Array("ID" => $this->GetPropInData("g:image_link",$this->XML_DATA)));
                                while( $ob = $ph->GetNext() )
                                {
                                    $arFile = CFile::GetFileArray( $ob["VALUE"] );
                                    if ( !empty( $arFile ) )
                                    {
                                        if ( strpos( $arFile["SRC"], "http" ) === false )
                                        {
                                            $pic = "http://".$this->DOMAIN_NAME.implode( "/", array_map( "rawurlencode", explode( "/", $arFile["SRC"] ) ) );
                                        }
                                        else
                                        {
                                            $ar = explode( "http://", $arFile["SRC"] );
                                            $pic = "http://".implode( "/", array_map( "rawurlencode", explode( "/", $ar[1] ) ) );
                                        }
                                        $arOfferIn1["g:image_link"][] = $pic;
                                    }
                                }
                            }
                            if(!$arOfferIn["g:image_link"])
                            {
                                if($arOffer["PREVIEW_PICTURE"])
                                {
                                    $db_file = CFile::GetByID($arOffer["PREVIEW_PICTURE"]);
                                    if ($ar_file = $db_file->Fetch())
                                    {
                                        $arOfferIn1["g:image_link"] = "http://".$this->DOMAIN_NAME."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".implode("/", array_map("rawurlencode", explode("/", $ar_file["FILE_NAME"])));
                                    }
                                }
                                if($arOffer["DETAIL_PICTURE"])
                                {
                                    $db_file = CFile::GetByID($arOffer["DETAIL_PICTURE"]);
                                    if ($ar_file = $db_file->Fetch())
                                    {
                                        $arOfferIn1["g:image_link"] = "http://".$this->DOMAIN_NAME."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".implode("/", array_map("rawurlencode", explode("/", $ar_file["FILE_NAME"])));
                                    }
                                }
                                if($this->GetPropInData("g:image_link",$this->XML_DATA))
                                {
                                    $ph = CIBlockElement::GetProperty($this->IBLOCK_ID, $arOffer["ID"], array("value_id" => "asc"), Array("ID" => $this->GetPropInData("g:image_link",$this->XML_DATA)))->Fetch();
                                    $db_file = CFile::GetByID($ph["VALUE"]);
                                    if ($ar_file = $db_file->Fetch())
                                    {
                                        $arOfferIn1["g:image_link"] = "http://".$this->DOMAIN_NAME."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".implode("/", array_map("rawurlencode", explode("/", $ar_file["FILE_NAME"])));
                                    }
                                }
                            }
                            if($arOfferIn["PREVIEW_TEXT"])
                            {
                                $arOfferIn["PREVIEW_TEXT"] = text2xml(($arOfferIn["PREVIEW_TEXT_TYPE"]=="html"?strip_tags(preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOfferIn["~PREVIEW_TEXT"])) : preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOfferIn["~PREVIEW_TEXT"])),true, true,$this->ENCODING);
                            }
                            if($arOfferIn["DETAIL_TEXT"])
                            {
                                $arOfferIn["DETAIL_TEXT"] = text2xml(($arOfferIn["DETAIL_TEXT_TYPE"]=="html"?strip_tags(preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOfferIn["~DETAIL_TEXT"])) : preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOfferIn["~DETAIL_TEXT"])), true,true,$this->ENCODING);
                            }
                            $arOfferIn1["description"]=(strlen($arOfferIn["PREVIEW_TEXT"])>strlen($arOfferIn["DETAIL_TEXT"]) ) ? $arOfferIn["PREVIEW_TEXT"] : $arOfferIn["DETAIL_TEXT"];
                            if($this->GetPropInData("description",$this->XML_DATA))
                            {
                                $ph = CIBlockElement::GetProperty($this->sku_IBLOCK_ID, $arOfferIn["ID"], array("value_id" => "asc"), Array("ID" => $this->GetPropInData("description",$this->XML_DATA)))->Fetch();
                                $arOfferIn1["description"] = text2xml($ph["VALUE"], true,true,$this->ENCODING);
                            }
                            if(!$arOfferIn1["description"])
                            {
                                if($arOffer["PREVIEW_TEXT"])
                                {
                                    $arOffer["PREVIEW_TEXT"] = text2xml(($arOffer["PREVIEW_TEXT_TYPE"]=="html"?strip_tags(preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOffer["~PREVIEW_TEXT"])) : preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOffer["~PREVIEW_TEXT"])),true, true,$this->ENCODING);
                                }
                                if($arOffer["DETAIL_TEXT"])
                                {
                                    $arOffer["DETAIL_TEXT"] = text2xml(($arOffer["DETAIL_TEXT_TYPE"]=="html"?strip_tags(preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOffer["~DETAIL_TEXT"])) : preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOffer["~DETAIL_TEXT"])),true, true,$this->ENCODING);
                                }
								$arOfferIn1["description"]=(strlen($arOffer["PREVIEW_TEXT"])>strlen($arOffer["DETAIL_TEXT"]) ) ? $arOffer["PREVIEW_TEXT"] : $arOffer["DETAIL_TEXT"];
                            }
                            $tmpmas=$this->GetXMLData($arOfferIn);
							if(is_array($tmpmas) && sizeof($tmpmas)>0)
                                foreach($tmpmas as $code=>$xml)
                                {
                                    $arOfferIn1[$xml["PARAM"]][]=$xml["VALUE"];
                                }
							
                            if ( intval($arOfferIn1["g:price"]) <= 0 )
                                continue;
                            foreach($arOfferIn1 as $id=>$val)
                            {
                                if(is_array($val) && sizeof($val)>0)
                                {
                                    $arOfferIn1[$id]=array_filter(array_unique($val));
                                    if(sizeof($arOfferIn1[$id])==1)
                                        $arOfferIn1[$id]=array_shift($arOfferIn1[$id]);
                                }

                            }
                            $strXML.=$this->BuildXml($arOfferIn1,$types,$MS);unset($arOfferIn1);
                        }
                        if($flag==1) continue;
                    }
                    $arOffer1["g:availability"]=true;
                    $arOffer1["g:id"]=$arOffer["ID"];
                    $arOffer1["g:condition"]=$this->CONDITIONS;
                    $arOffer1["title"]=text2xml($arOffer["NAME"],true, true,$this->ENCODING);
                    if(!$this->isCat)
                    {
                        if($this->GetPropInData("quantity",$this->XML_DATA))
                        {
                            $av = CIBlockElement::GetProperty( $arOffer["IBLOCK_ID"], $arOffer["ID"], array("sort" => "asc"), Array("ID" => $this->GetPropInData("quantity",$this->XML_DATA)) )->Fetch();
                            if( IntVal($av["VALUE"]) > 0 )
                            {
                                $arOffer1["g:availability"] = "in stock";
                            }
                            else
							{
                                if($this->FORORDER)
                                    $arOffer1["g:availability"] = "preorder";
                                else
                                    $arOffer1["g:availability"] = "out of stock";
							}
                        }
                    }
                    $arOffer1["g:price"] = $this->yandex_GetPrice(array("IBLOCK_ID"=>$ibl,"ID"=>$arOffer['ID']));
                    if($arOffer1["g:price"]>0)
                        $arOffer1["g:price"].=" ".$this->baseCur;
					
                    if($this->isCat)
                    {
                        $tr = CCatalogProduct::GetByID( $arOffer["ID"] );
                        if ( $tr["QUANTITY_TRACE"] == "N" )
                            $arOffer1["g:availability"] = "in stock";
                        else
                        {
                            if( $tr["QUANTITY"] > 0 )
                            {
                                $arOffer1["g:availability"] = "in stock";
                            }
                            else
							{
                                if($this->FORORDER)
                                    $arOffer1["g:availability"] = "preorder";
                                else
                                    $arOffer1["g:availability"] = "out of stock";
							}
                        }
                    }
                    $arOffer1["g:product_type"] = str_replace(">","&gt;",$this->GOOGLE_CATEGORY[$arOffer["IBLOCK_SECTION_ID"]]["THIS"]);
                    $arOffer1["g:google_product_category"] = str_replace(">","&gt;",$this->GOOGLE_CATEGORY[$arOffer["IBLOCK_SECTION_ID"] ? $arOffer["IBLOCK_SECTION_ID"] : $arOffer["IBLOCK_ID"]]["GOOGLE"]);
                    if($arOffer["DETAIL_PAGE_URL"])
                        $arOffer1["g:link_href"] = "http://".$this->DOMAIN_NAME. $arOffer["DETAIL_PAGE_URL"];
                    if($arOffer["PREVIEW_PICTURE"])
                    {
                        $db_file = CFile::GetByID($arOffer["PREVIEW_PICTURE"]);
                        if ($ar_file = $db_file->Fetch())
                            $arOffer1["g:image_link"] = "http://".$this->DOMAIN_NAME."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".implode("/", array_map("rawurlencode", explode("/", $ar_file["FILE_NAME"])));
                    }
                    if($arOffer["DETAIL_PICTURE"])
                    {
                        $db_file = CFile::GetByID( $arOffer["DETAIL_PICTURE"] );
                        if ($ar_file = $db_file->Fetch())
                            $arOffer1["g:image_link"] = "http://".$this->DOMAIN_NAME."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".implode("/", array_map("rawurlencode", explode("/", $ar_file["FILE_NAME"])));
                    }
                    if($this->GetPropInData("g:image_link",$this->XML_DATA))
                    {
                        $ph = CIBlockElement::GetProperty( $arOffer['IBLOCK_ID'], $arOffer["ID"], array("sort" => "asc"), Array("ID" => $this->GetPropInData("g:image_link",$this->XML_DATA)));
                        while( $ob = $ph->GetNext() )
                        {
                            $arFile = CFile::GetFileArray( $ob["VALUE"] );
                            if ( !empty( $arFile ) )
                            {
                                if ( strpos( $arFile["SRC"], "http" ) === false )
                                {
                                    $pic = "http://".$this->DOMAIN_NAME.implode( "/", array_map( "rawurlencode", explode( "/", $arFile["SRC"] ) ) );
                                }
                                else
                                {
                                    $ar = explode( "http://", $arFile["SRC"] );
                                    $pic = "http://".implode( "/", array_map( "rawurlencode", explode( "/", $ar[1] ) ) );
                                }
                                $arOffer1["g:image_link"][] = $pic;
                            }
                        }
                    }
                    if($arOffer["PREVIEW_TEXT"])
                    {
                        $arOffer["PREVIEW_TEXT"] =text2xml(($arOffer["PREVIEW_TEXT_TYPE"]=="html"?strip_tags(preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOffer["~PREVIEW_TEXT"])) : preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOffer["~PREVIEW_TEXT"])),true, true,$this->ENCODING);
                    }
                    if($arOffer["DETAIL_TEXT"])
                    {
                        $arOffer["DETAIL_TEXT"] = text2xml(($arOffer["DETAIL_TEXT_TYPE"]=="html"?strip_tags(preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOffer["~DETAIL_TEXT"])) : preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arOffer["~DETAIL_TEXT"])),true, true,$this->ENCODING);
                    }
					$arOffer1["description"]=(strlen($arOffer["PREVIEW_TEXT"])>strlen($arOffer["DETAIL_TEXT"]) ) ? $arOffer["PREVIEW_TEXT"] : $arOffer["DETAIL_TEXT"];
                    if($this->GetPropInData("description",$this->XML_DATA))
                    {
                        $ph = CIBlockElement::GetProperty($arOffer, $arOffer["ID"], array("value_id" => "asc"), Array("ID" => $this->GetPropInData("description",$this->XML_DATA)))->Fetch();
                        $arOffer1["description"] = text2xml($ph["VALUE"],true, true,$this->ENCODING);
                    }
                    $tmpmas=$this->GetXMLData($arOffer);
                    if(is_array($tmpmas) && sizeof($tmpmas)>0)
                        foreach($tmpmas as $code=>$xml)
                        {
							 $arOffer1[$xml["PARAM"]][$code]=$xml["VALUE"];
                        }

                    if( intval($arOffer1["g:price"]) <= 0 )
                        continue;
                    $strXML.=$this->BuildXml($arOffer1,$types,$MS);

                    unset($arOffer1);
                }
            }
        }
        return $strXML;
    }
    public function GetXMLData($product)
    {
        $arProp=array(	"ID"=>GetMessage("ACRIT_PROP_ID"),
            "CODE"=>GetMessage("ACRIT_PROP_CODE"),
            "NAME"=>GetMessage("ACRIT_PROP_NAME"),
            "ACTIVE"=>GetMessage("ACRIT_PROP_ACTIVE"),
            "DATE_CREATE"=>GetMessage("ACRIT_PROP_DATE_CREATE"),
            "CREATED_BY"=>GetMessage("ACRIT_PROP_CREATED_BY"),
            "DETAIL_PAGE_URL"=>GetMessage("ACRIT_PROP_DETAIL_PAGE_URL"),
            "SHOW_COUNTER"=>GetMessage("ACRIT_PROP_SHOW_COUNTER"),
            "QUANTITY"=>GetMessage("ACRIT_PROP_QUANTITY"));
        $params=array();
		if(is_array($this->XML_DATA) && sizeof($this->XML_DATA)>0)
        {
            foreach($this->XML_DATA as $xml)
            {
				$tmp1=explode("-",$xml['ID']);
                $tmp=explode("_",$tmp1[1]);
				if($tmp[0]=="SKU")
                {
                    $ibl=$this->sku_IBLOCK_ID[$tmp1[0]];
                    $prop_id=$tmp[1];
					$ph = CIBlockElement::GetProperty($ibl, $product["ID"], array("sort" => "asc"), Array("ID" =>$prop_id));
                }
                elseif($tmp[0]=="QUANTITY")
                {
                    if($this->isCat)
                    {
                        $tr = CCatalogProduct::GetByID( $product["ID"] );
                        $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($arProp[$xml["ID"]],true, true,$this->ENCODING),"CODE"=>$xml["ID"],"VALUE"=>$tr["QUANTITY"]);
                    }
					$ph=false;
                    continue;
                }
                elseif($tmp[0]=="PRICE")
                {
                    $dbProductPrices = CPrice::GetList(array(), array("PRODUCT_ID" => $product["ID"], "CATALOG_GROUP_ID" => $tmp[1])) ;
                    $price = 0 ;$names='';
                    while($arProductPrice = $dbProductPrices->Fetch())
                    {
                        if($arProductPrice["PRICE"] && ($arProductPrice["PRICE"] < $price || !$price))
                            $price = $arProductPrice["PRICE"] ;
                        $arDissizeofs = CCatalogDiscount::GetDiscountByProduct($arProductPrice["PRODUCT_ID"], array(),  "N", $arProductPrice["CATALOG_GROUP_ID"], $this->LID);
                        foreach($arDissizeofs as $arDissizeof)
                        {
                            if($arDissizeof["VALUE_TYPE"] == "P")
                                $price_buf = $arProductPrice["PRICE"] - $arDissizeof["VALUE"] * $arProductPrice["PRICE"] / 100;
                            else
                                $price_buf = $arProductPrice["PRICE"] - $arDissizeof["VALUE"];
                            if($price_buf && ($price_buf < $price || !$price))
                                $price = $price_buf;
                        }
                        $names=$arProductPrice["CATALOG_GROUP_NAME"];
                    }
                    $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($names, true,true,$this->ENCODING),"CODE"=>$xml["ID"],"VALUE"=>$price);
					$ph=false;
                    continue;
                }
                else
                {
					$ibl=$tmp1[0];
                    $prop_id=$tmp1[1];
					$mxResult = CCatalogSku::GetProductInfo($product["ID"]);
					if (is_array($mxResult))
					{	
						$ph = CIBlockElement::GetProperty($ibl, $mxResult["ID"], array("sort" => "asc"), Array("ID" =>$prop_id));
					}
					else
					{
						$ph = CIBlockElement::GetProperty($ibl, $product["ID"], array("sort" => "asc"), Array("ID" =>$prop_id));
					}
					
                }
				if(is_object($ph))
				while($ob = $ph->GetNext())
				{
                	switch($ob["PROPERTY_TYPE"])
                    {
						case "S":
                        {
                            if($ob["USER_TYPE"]=="UserID")
                            {
                                $rsUser = CUser::GetByID($ob["VALUE"]);
                                $arUser = $rsUser->Fetch();
                                $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($ob["NAME"],true, true,$this->ENCODING),"CODE"=>$ob["CODE"],"VALUE"=>text2xml($arUser["LAST_NAME"]." ".$arUser["FIRST_NAME"],true, true,$this->ENCODING));
                            }
                            else
                            {
                                $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($ob["NAME"],true, true,$this->ENCODING),"CODE"=>$ob["CODE"],"VALUE"=>text2xml($ob["VALUE"],true, true,$this->ENCODING));
                            }
                            break;
                        }
                        case "L":
                        {
                            $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($ob["NAME"],true, true,$this->ENCODING),"CODE"=>$ob["CODE"],"VALUE"=>text2xml($ob["VALUE_ENUM"],true, true,$this->ENCODING));
                            break;
                        }
                        case "E":
                        {
                            $res = CIBlockElement::GetByID($ob["VALUE"]);
                            while($ar_res = $res->GetNext())
                                $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($ob["NAME"], true,true,$this->ENCODING),"CODE"=>$ob["CODE"],"VALUE"=>text2xml($ar_res["NAME"],true, true,$this->ENCODING));
                            break;
                        }
                        case "G":
                        {
                            if($xml['UNIT']!="product_type")
                            {
                                $res = CIBlockSection::GetByID($ob["VALUE"]);
                                while($ar_res = $res->GetNext())
                                    $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($ob["NAME"], true,true,$this->ENCODING),"CODE"=>$ob["CODE"],"VALUE"=>text2xml($ar_res["NAME"],true, true,$this->ENCODING));
                                break;
                            }
                            else
                            {
                                $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($ob["NAME"],true, true,$this->ENCODING),"CODE"=>$ob["CODE"],"VALUE"=>text2xml($ob["VALUE"],true, true,$this->ENCODING));
                                break;
                            }
                        }
                        case "F":
                        {
                            $db_file = CFile::GetByID($ob["VALUE"]);
                            while ($ar_file = $db_file->Fetch())
                                $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($ob["NAME"],true, true,$this->ENCODING),"CODE"=>$ob["CODE"],"VALUE"=>"http://".$this->DOMAIN_NAME."/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".implode("/", array_map("rawurlencode", explode("/", $ar_file["FILE_NAME"]))));
                            break;
                        }
                        case "N":
                        {
                            $params[]=array("PARAM"=>$xml["UNIT"],"NAME"=>text2xml($ob["NAME"],true, true,$this->ENCODING),"CODE"=>$ob["CODE"],"VALUE"=>text2xml($ob["VALUE"],true, true,$this->ENCODING));
                            break;
                        }
                        default:
                            {
                            break;
                            }
                    }
                }
            }
        }
        return $params;
    }
    protected static function CheckArray(&$array)
    {
        if(is_array($array) && sizeof($array)>0) return true; else return false;
    }
    static function BuildXml($Offer,$types,$MS)
    {
        $xml="";
        $xml.="<entry>".PHP_EOL;
        foreach($MS['gm']['FIELDS'] as $cod)
        {
            if($cod['CODE']=='g:link_href')
            {
                if($Offer[$cod['CODE']]!='') $xml.='<link>'.$Offer[$cod['CODE']].'</link>'.PHP_EOL;
            }
            elseif($cod['CODE']=='g:additional_image_link')
            {
                if(is_array($Offer[$cod['CODE']]))
                    foreach($Offer[$cod['CODE']] as $v)
                        if($v!=='')
                            $xml.='<g:additional_image_link>'.$v.'</g:additional_image_link>'.PHP_EOL;
                        else
                            $xml.='<g:additional_image_link>'.$Offer[$cod['CODE']].'</g:additional_image_link>'.PHP_EOL;
            }
            elseif($cod['CODE']=='g:country' || $cod['CODE']=='g:service' || $cod['CODE']=='g:shipping_price')
            {
                if($Offer['g:country']!='' && $Offer['g:service']!='' && $Offer['g:shipping_price']!='')
                {
                    $xml.='<g:shipping>'.PHP_EOL;
                    $xml.='<g:country>'.$Offer['g:sizeofry'].'</g:country>'.PHP_EOL;
                    $xml.='<g:service>'.$Offer['g:service'].'</g:service>'.PHP_EOL;
                    $xml.='<g:price>'.$Offer['g:shipping_price'].'</g:price>'.PHP_EOL;
                    $xml.='/<g:shipping>\n';
                }
            }
            elseif($cod['CODE']=='g:gender')
                $xml.='<g:gender>'.CheckGender($Offer[$cod['CODE']]).'</g:gender>'.PHP_EOL;
            else
            {
                if(!is_array($Offer[$cod['CODE']]))
                {
                    if($Offer[$cod['CODE']])
                        $xml.='<'.$cod['CODE'].'>'.trim($Offer[$cod['CODE']]).'</'.$cod['CODE'].'>'.PHP_EOL;
                }
                else
                {
                    foreach($Offer[$cod['CODE']] as $cod1)
                        if($cod1) $xml.='<'.$cod['CODE'].'>'.trim($cod1).'</'.$cod['CODE'].'>'.PHP_EOL;
                }
            }
        }
        $xml.='</entry>'.PHP_EOL;
        return $xml;
    }
    public function ReturnXMLData($ID)
    {
		$l=new CGM($ID);
		if(!is_object($l)) {ShowMessage(GetMessage("ACRIT_GOOGLEMERCHANT_NOT_PROFILE"));exit();}
        $MS=CGMExport::ReturnMas();
        $arResult=$l->GetElement('gm',$MS);
		if(strlen($arResult)>0)
        {
            if($l->USE_XML_FILE)
            {
                if (strlen($l->URL_DATA_FILE) <= 0)
                {
                    ShowMessage(GetMessage('ACRIT_GOOGLEMERCHANT_BAD_FILENAME'));exit();
                }
                else
                {
                    $FILE_PATH = Rel2Abs("/",$l->URL_DATA_FILE);
                    CheckDirPath($_SERVER["DOCUMENT_ROOT"].$FILE_PATH);
                    if (!$fp = @fopen($_SERVER["DOCUMENT_ROOT"].$FILE_PATH, "wb"))
                    {
                        ShowMessage(GetMessage('ACRIT_GOOGLEMERCHANT_BAD_OPENFILE'));exit();
                    }
                    else
                    {
                        $strXMLDATA='';
                        $strXMLDATA.='<?xml version="1.0" encoding="'.$l->ENCODING.'"?>'.PHP_EOL;
                        $strXMLDATA.='<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">'.PHP_EOL;
                        $strXMLDATA.='<title>'.$l->FEED.'</title>'.PHP_EOL;
                        $strXMLDATA.='<link rel="self" href="http://'.$l->DOMAIN_NAME.'"/>'.PHP_EOL;
                        $strXMLDATA.='<updated>'.date('c').'</updated>'.PHP_EOL;
                        $strXMLDATA.='<author><name>'.$l->SHOPNAME.'</name></author>'.PHP_EOL;
                        $strXMLDATA.=$arResult;
                        $strXMLDATA.="</feed>".PHP_EOL;
                        fwrite($fp, $strXMLDATA);
                        @fclose($fp);
                    }
                }
            }
            elseif(!$l->USE_XML_FILE)
            {
                header("Content-Type: text/xml; charset='".$l->ENCODING."'");
                header("Pragma: no-cache");
                echo '<?xml version="1.0" encoding="'.$l->ENCODING.'"?>'.PHP_EOL;
                echo '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">'.PHP_EOL;
                echo '<title>'.$l->FEED.'</title>'.PHP_EOL;
                echo '<link rel="self" href="http://'.$l->DOMAIN_NAME.'"/>'.PHP_EOL;
                echo '<updated>'.date('c').'</updated> '.PHP_EOL;
                echo '<author><name>'.$l->SHOPNAME.'</name></author>'.PHP_EOL;
                echo $arResult;
                echo "</feed>".PHP_EOL;
            }
        }
        else
        {
            ShowError(GetMessage("ACRIT_GOOGLEMERCHANT_NOT_ELEMENT"));
        }
		if($l->TYPE_RUN=='agent')
		{ return "CGM::ReturnXMLData(".$ID.");";}
		global $DB;
		$now = time()+CTimeZone::GetOffset();
		$data['START_LAST_TIME_X'] = date($DB->DateFormatToPHP(FORMAT_DATETIME), $now);
		CProfileAdmin::Update($ID, $data);
		unset($data);
        unset($arResult);
	}
    
    function stripInvalidXml($value)
    {
        $ret = "";
        $current;
        if (empty($value)) 
        {
            return $ret;
        }
    
        $length = strlen($value);
        for ($i=0; $i < $length; $i++)
        {
            $current = ord($value{$i});
            if (($current == 0x9) ||
                ($current == 0xA) ||
                ($current == 0xD) ||
                (($current >= 0x20) && ($current <= 0xD7FF)) ||
                (($current >= 0xE000) && ($current <= 0xFFFD)) ||
                (($current >= 0x10000) && ($current <= 0x10FFFF)))
            {
                $ret .= chr($current);
            }
            else
            {
                $ret .= " ";
            }
        }
        return $ret;
    }
}