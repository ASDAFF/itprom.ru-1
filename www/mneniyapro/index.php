<?
	$password = '#password#';//не изменяте данную строку!!
	if($_GET['password'] == $password)
	{
		require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
		if (CModule::IncludeModule('sale') && CModule::IncludeModule('catalog'))
		{
			$settings = @unserialize(COption::GetOptionString("pimentos.mneniyapro", "settings"));
			$site_name = (SITE_SERVER_NAME ? (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').SITE_SERVER_NAME : (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST']);
			
			if(!$settings['date_interval'])
			{
				$arFilter = Array(
					">=DATE_INSERT" => date($DB->DateFormatToPHP(CSite::GetDateFormat("SHORT")), strtotime("-14 days")),
				);
			}
			else
			{
				$arFilter = Array(
					">=DATE_INSERT" => date($DB->DateFormatToPHP(CSite::GetDateFormat("SHORT")), strtotime("-".$settings['date_interval']." days"))
				);
			}
			if($settings['export_status'])
			{
				$arFilter["STATUS_ID"] = $settings['export_status'];	
			}
			else
			{
				$arFilter["STATUS_ID"] = array('F');	
			}
			$orders = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
			$xml = '<?xml version="1.0" encoding="UTF-8"?><orders>';
			while ($order = $orders->Fetch())
			{
				$xml .= '<order>';
				$xml .= '<id>'.$order['ID'].'</id>';
				$xml .= '<customer_name>'.$order['USER_LAST_NAME'].' '.$order['USER_NAME'].'</customer_name>';
				$xml .= '<customer_email>'.$order['USER_EMAIL'].'</customer_email>';
				$xml .= '<products>';
				$basket_content = CSaleBasket::GetList(array(), array("ORDER_ID" => $order['ID']));
				while ($item = $basket_content->Fetch())
				{
					$mxResult     = CCatalogSku::GetProductInfo($item['PRODUCT_ID']);
					if(is_array($mxResult))
					{
						$product_id = $mxResult['ID'];
					}
					else
					{
						$product_id = $item['PRODUCT_ID'];
					}
					$xml         .= '<product>';
					$xml         .= '<sku>'.$product_id.'</sku>';
					$name         = htmlspecialchars($item['NAME']);
					if($name == '')
					{
						$name = htmlspecialchars($item['NAME'], ENT_QUOTES, 'cp1251');
					}
					$xml         .= '<name>'.$name.'</name>';
					$xml         .= '<delivery_date>'.date('Ymd', strtotime($item['DATE_INSERT'])).'</delivery_date>';
					$xml         .= '<url>'.$site_name.$item['DETAIL_PAGE_URL'].'</url>';					$url         = htmlspecialchars($site_name.$item['DETAIL_PAGE_URL']);					if($url == '')					{						$url = htmlspecialchars($site_name.$item['DETAIL_PAGE_URL'], ENT_QUOTES, 'cp1251');					}					$xml         .= '<url>'.$url.'</url>';					
					$xml         .= '</product>';
				}
				$xml .= '</products>';
				$xml .= '</order>';
			}
			$xml .= '</orders>';
			if(LANG_CHARSET == "windows-1251")
				$xml = iconv("windows-1251", "UTF-8", $xml);
			header('Content-Type: application/xml; charset=UTF-8');
			echo $xml;
		}
	}
?>