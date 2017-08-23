<?
IncludeModuleLangFile(__FILE__);

class CGMExport 
{
	public static function AgentRun($profileID,$in_agent="N") //создаем агента с профилем $profileID
	{
		global $DB;$agent_ID=0;
		$pr= CProfileAdmin::GetByID($profileID)->Fetch();
		$datacheck = date("d.m.Y H:i:s",$pr["DATA_START"]);
		$agent_period = intval($pr["PERIOD"]);
		if ($agent_period<=0) $agent_period = 86400;
		if ($profileID>0)
		{
			if ($in_agent=="Y")
			{	CAgent::RemoveAgent("CGM::ReturnXMLData(".$profileID.");", "acrit.googlemerchant");}
			else
			{
				$arAgent = CAgent::GetList(array(), array("NAME"=>"CGM::ReturnXMLData(".$profileID.");"))->Fetch();
				if(!$arAgent)
				{
					$agent_ID=CAgent::AddAgent("CGM::ReturnXMLData(".$profileID.");", "acrit.googlemerchant", "N", $agent_period, $datacheck, "Y",$datacheck,100);
				}
				elseif($arAgent)
				{
					if($arAgent['NEXT_EXEC']>$datacheck) $datacheck=$arAgent['NEXT_EXEC'];
					CAgent::Update($arAgent['ID'], array("AGENT_INTERVAL"=>$agent_period,"ACTIVE"=>"Y","NEXT_EXEC"=>$datacheck));
				}
			}	
		}
		return $agent_ID;

	}
	public static function CronRun($profileID,$in_cron="N") 
	{
		define("path2export","/bitrix/php_interface/include/catalog_export/");
		$pr= CProfileAdmin::GetByID($profileID)->Fetch();
		$cron_period=intval($pr['PERIOD']);
		$cron_period=($cron_period<=0) ? 86400 : $cron_period;
		$data=date("d.m.Y H:i:s",$pr['DATA_START']);
		$d=explode(" ",$data);
		$t=explode(":",$d[1]);
		$cron_hour=intval($t[0]);$cron_minute=intval($t[1]);
		$cron_hour=($cron_hour<=0) ? 0 : $cron_hour;
		$cron_minute=($cron_minute<=0) ? 0 : $cron_minute;
		$cron_php_path=COption::GetOptionString("acrit.googlemerchant","php_path");
		$cron_php_path=(strlen($cron_php_path)>0) ? $cron_php_path : getPHPExecutableFromPath();
		if (file_exists($_SERVER["DOCUMENT_ROOT"].path2export."acrit_gm_cron.php"))
		{
			CheckDirPath($_SERVER["DOCUMENT_ROOT"].path2export);
			$tmp_file_size = filesize($_SERVER["DOCUMENT_ROOT"].path2export."acrit_gm_cron.php");
			$fp = fopen($_SERVER["DOCUMENT_ROOT"].path2export."acrit_gm_cron.php", "rb");
			$tmp_data = fread($fp, $tmp_file_size);
			fclose($fp);
			$tmp_data = str_replace("#DOCUMENT_ROOT#", $_SERVER["DOCUMENT_ROOT"], $tmp_data);
			$tmp_data = str_replace("#PHP_PATH#", $cron_php_path, $tmp_data);
			$fp = fopen($_SERVER["DOCUMENT_ROOT"].path2export."acrit_gm_cron.php", "w+");
			fwrite($fp, $tmp_data);
			fclose($fp);
		}
		$cfg_data = "";
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg"))
		{
			$cfg_file_size = filesize($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg");
			$cfg_file_size=($cfg_file_size!=0) ? $cfg_file_size : 1;
			$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg", "rb");
			$cfg_data = fread($fp, $cfg_file_size);
			fclose($fp);
		}
		CheckDirPath($_SERVER["DOCUMENT_ROOT"].path2export."logs/");
		if ($in_cron=="Y")
		{
			$cfg_data = preg_replace("#^.*?".preg_quote(path2export)."acrit_gm_cron.php ".$profileID." *>.*?$#im", "", $cfg_data);
		}
		else
		{
			if ($cron_period>0)
			{
				$strTime = "0 */".$cron_period." * * * ";
			}
			else
			{
				$strTime = intval($cron_minute)." ".intval($cron_hour)." * * * ";
			}
			if (strlen($cfg_data)>0) $cfg_data .= "\n";
			$cfg_data = preg_replace("#^.*?".preg_quote(path2export)."acrit_gm_cron.php ".$profileID." *>.*?$#im", "", $cfg_data);
			$cfg_data .= $strTime.$cron_php_path." -f ".$_SERVER["DOCUMENT_ROOT"].path2export."acrit_gm_cron.php ".$profileID." >".$_SERVER["DOCUMENT_ROOT"].path2export."logs/".$profileID.".txt\n";
		}	
		CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/");
		$cfg_data = preg_replace("#[\r\n]{2,}#im", "\n", $cfg_data);
		$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg", "wb");
		fwrite($fp, $cfg_data);
		fclose($fp);
		$arRetval = array();
		@exec("crontab ".$_SERVER["DOCUMENT_ROOT"]."/bitrix/crontab/crontab.cfg", $arRetval, $return_var);
	}
	public function SQLCondition($Condition)
	{
		$CONDITION_COUNT=count($Condition);
		$Filter=array();
		if(is_array($Condition) && $CONDITION_COUNT>0)
		{
			foreach($Condition as $id=>$cnd)
			{
				foreach($cnd as $cond)
				{
					$strSQL='#RULES##PROP#';
					$strSQLCatalog='#RULES#CATALOG_#PROP#';
					$rules='';
					if($cond['LOGIC']=="or")
						$logic="OR";
					elseif($cond['LOGIC']=="and")
						$logic="AND";
					if($cond['RULES']=='equal')
						$rules='';
					elseif($cond['RULES']=='not')
						$rules="!";
					elseif($cond['RULES']=='great')
						$rules=">";
					elseif($cond['RULES']=='less')
						$rules="<";
					elseif($cond['RULES']=='eqgr')
						$rules=">=";
					elseif($cond['RULES']=='eqls')
						$rules="<=";
					if($cond['PROPERTY']=="QUANTITY" || in_array("PRICE",explode("_",$cond['PROPERTY'])))
					{
						$st=str_replace("#PROP#",trim($cond['PROPERTY']),str_replace("#RULES#",$rules,$strSQLCatalog));
					}
					elseif($cond['PROPERTY']=="DATE_CREATE")
					{
					$st=str_replace("#PROP#",$cond['PROPERTY'],str_replace("#RULES#",$rules,$strSQL));
					$cond['VALUE']=ConvertDateTime($cond['VALUE'], "YYYY-MM-DD")." 00:00:00";
					if($cond['RULES']=="equal")
					{
							$Filter[]=array(">=DATE_CREATE"=>ConvertDateTime($cond['VALUE'], "YYYY-MM-DD")." 00:00:00");
							$Filter[]=array("<=DATE_CREATE"=>ConvertDateTime($cond['VALUE'], "YYYY-MM-DD")." 23:59:59");
							$st='';$cond['VALUE']='';
					}
					}
					else
					{
						$prop=$this->GetProp($cond['PROPERTY']);
						$st=str_replace("#PROP#",$prop,str_replace("#RULES#",$rules,$strSQL));
					}
					$Filter[$id][]=array($st=>$cond['VALUE']);
				}
			}
		}
		return $Filter;
	}
	public static function GetProp($strProp)
	{
        $prop='';
		$propert=array("ID","CODE","NAME","ACTIVE","DATE_CREATE","CREATED_BY","DETAIL_PAGE_URL","SHOW_COUNTER","QUANTITY");
		if(in_array($strProp,$propert))
		{	
			$prop=$strProp;
		}
		else
		{
			$res = CIBlockProperty::GetByID(intval($strProp));
					if($ar_res = $res->GetNext())
					{
						if($ar_res['PROPERTY_TYPE']=="L")
							$prop="PROPERTY_".$ar_res['CODE'];
						else
							$prop="PROPERTY_".$ar_res['CODE'];
					}
		}
		return $prop;
	}
	public static function ReturnMas()
	{
		$type=array(
			"gm"=>array("CODE"=>"gm","NAME"=>GetMessage('ACRIT_CORE'),
				"FIELDS"=>array(
					array("CODE"=>"title","NAME"=>GetMessage("ACRIT_GM_TITLE"),"SET"=>"Y","VALUE"=>""),			
					array("CODE"=>"g:link_href","NAME"=>GetMessage('ACRIT_GM_LINK_HREF'),"SET"=>"Y","VALUE"=>""),			
					array("CODE"=>"description","NAME"=>GetMessage('ACRIT_GM_DESCRIPTION'),"SET"=>"Y","VALUE"=>""),			
					array("CODE"=>"g:id","NAME"=>GetMessage('ACRIT_GM_ID'),"SET"=>"Y","VALUE"=>""),			
					array("CODE"=>"g:condition","NAME"=>GetMessage('ACRIT_ID_CONDITION'),"SET"=>"Y","VALUE"=>""),			
					array("CODE"=>"g:price","NAME"=>GetMessage('ACRIT_ID_PRICE'),"SET"=>"Y","VALUE"=>""),			
					array("CODE"=>"g:availability","NAME"=>GetMessage('ACRIT_ID_AVALIB'),"SET"=>"Y","VALUE"=>""),			
					array("CODE"=>"g:image_link","NAME"=>GetMessage('ACRIT_ID_IMAGE_LINK'),"SET"=>"Y","VALUE"=>""),			
					array("CODE"=>"g:additional_image_link","NAME"=>GetMessage('ACRIT_ID_ADD_IMAGE'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:country","NAME"=>GetMessage('ACRIT_ID_SHIPPING_COUNTRY'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:service","NAME"=>GetMessage('ACRIT_ID_SHIPPING_SERVICE'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:shipping_price","NAME"=>GetMessage('ACRIT_ID_SHIPPING_PRICE'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:gtin","NAME"=>GetMessage('ACRIT_ID_GTIN'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:brand","NAME"=>GetMessage('ACRIT_ID_BRAND'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:mpn","NAME"=>GetMessage('ACRIT_ID_MPN'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:product_type","NAME"=>GetMessage('ACRIT_ID_PRODUCT_TYPE'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:shipping_weight","NAME"=>GetMessage('ACRIT_GM_WEIGHT'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:google_product_category","NAME"=>GetMessage('ACRIT_ID_GOOGLE_CATALOG'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:gender","NAME"=>GetMessage('ACRIT_ID_GENDER'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:age_group","NAME"=>GetMessage('ACRIT_ID_AGE_GROUP'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:sale_price","NAME"=>GetMessage('ACRIT_ID_SALEPRICE'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:sale_price_effective_date","NAME"=>GetMessage('ACRIT_ID_SALEDATE'),"SET"=>"N","VALUE"=>""),	
					array("CODE"=>"g:adult","NAME"=>GetMessage('ACRIT_ID_ADULT'),"SET"=>"N","VALUE"=>""),								
					array("CODE"=>"g:color","NAME"=>GetMessage('ACRIT_ID_COLOR'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:size","NAME"=>GetMessage('ACRIT_ID_SIZE'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:material","NAME"=>GetMessage('ACRIT_ID_MATERIAL'),"SET"=>"N","VALUE"=>""),			
					array("CODE"=>"g:pattern","NAME"=>GetMessage('ACRIT_ID_PATTERN'),"SET"=>"N","VALUE"=>""),		
					array("CODE"=>"g:item_group_id","NAME"=>GetMessage('ACRIT_ID_ITEM_GROUP'),"SET"=>"N","VALUE"=>""),								
					array("CODE"=>"g:adwords_grouping","NAME"=>GetMessage('ACRIT_ADWORDS_GROUPING'),"SET"=>"N","VALUE"=>""),								
					array("CODE"=>"g:adwords_labels","NAME"=>GetMessage('ACRIT_ADWORDS_LABEL'),"SET"=>"N","VALUE"=>""),
					array("CODE"=>"g:adwords_redirect","NAME"=>GetMessage('ACRIT_ADWORDS_REDIRECT'),"SET"=>"N","VALUE"=>""),
					array("CODE"=>"g:custom_label_0","NAME"=>GetMessage('ACRIT_CUSTOM_LABEL_0'),"SET"=>"N","VALUE"=>""),
					array("CODE"=>"g:custom_label_1","NAME"=>GetMessage('ACRIT_CUSTOM_LABEL_1'),"SET"=>"N","VALUE"=>""),
					array("CODE"=>"g:custom_label_2","NAME"=>GetMessage('ACRIT_CUSTOM_LABEL_2'),"SET"=>"N","VALUE"=>""),
					array("CODE"=>"g:custom_label_3","NAME"=>GetMessage('ACRIT_CUSTOM_LABEL_3'),"SET"=>"N","VALUE"=>""),
					array("CODE"=>"g:custom_label_4","NAME"=>GetMessage('ACRIT_CUSTOM_LABEL_4'),"SET"=>"N","VALUE"=>""),
					array("CODE"=>"g:excluded_destination","NAME"=>GetMessage('ACRIT_EXCLUDED_DEST'),"SET"=>"N","VALUE"=>""),
					array("CODE"=>"g:expiration_date","NAME"=>GetMessage('ACRIT_EXPIRATION_DATE'),"SET"=>"N","VALUE"=>""),
					),
					"HEADER"=>"<?xml version=\"1.0\"?><feed xmlns=\"http://www.w3.org/2005/Atom\" xmlns:g=\"http://base.google.com/ns/1.0\">"),
		);
	return $type;
	}
}
