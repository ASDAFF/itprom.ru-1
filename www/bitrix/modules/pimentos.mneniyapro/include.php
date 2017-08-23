<?
	class CMneniyaproEdit
	{
	
		public function editContent(&$content)
		{
			$replaced_template = "<!--Mneniya.pro-->";
			
			if(strpos($content, $replaced_template) !== false)
			{
				if(CModule::IncludeModule("catalog"))
				{
					$product_id = 0;
					if(isset($_SESSION['VIEWED_PRODUCT']) && $_SESSION['VIEWED_PRODUCT'])
					{
						$product_id = $_SESSION['VIEWED_PRODUCT'];
					}
					else
					{
						$product_id = $_SESSION['LAST_VIEW_ID'];
					}
					$product_info = CCatalogProduct::GetByIDEx($product_id);
					$settings     = unserialize(COption::GetOptionString("pimentos.mneniyapro", "settings"));
					if(isset($settings["code"]) && $settings["code"])
					{
						$content      = str_replace($replaced_template, '<div class="mp-prod_id" style="display:none">'.
												$product_id.'</div>'.
												'<div class="mp-prod_name" style="display:none">'.$product_info['NAME'].'</div>'.
												$settings["code"], $content);
					}
				}
			}
		}
	}
?>