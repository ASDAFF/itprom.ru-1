<?
IncludeModuleLangFile(__FILE__);

if(class_exists("bitlate_toolsshop")) return;

class bitlate_toolsshop extends CModule
{
	var $MODULE_ID = "bitlate.toolsshop";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	var $errors;

	function bitlate_toolsshop()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		
		$this->PARTNER_NAME = GetMessage("BLTOOLS_TTNMSAT_COMPANY_NAME");
		$this->PARTNER_URI = GetMessage("BLTOOLS_TTNMSAT_PARTNER_URI");
		$this->MODULE_NAME = GetMessage("BLTOOLS_TTNMSAT_INSTALL_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("BLTOOLS_TTNMSAT_INSTALL_DESCRIPTION");
	}
	
	
	function InstallFiles()
	{
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . $this->MODULE_ID . "/install/wizards", $_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/" . $this->MODULE_ID, false, true);
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/" . $this->MODULE_ID . "/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/", false, true);
		return true;
	}


	function UnInstallFiles()
	{
        DeleteDirFilesEx("/bitrix/wizards/{$this->MODULE_ID}");
		return true;
	}
	
	
	function DoInstall()
	{
		global $APPLICATION, $step;
		
		$POST_RIGHT = $APPLICATION->GetGroupRight($this->MODULE_ID);
		if($POST_RIGHT == "W")
		{
			$step = intval($step);
			
			if($step<2)
			{
				$APPLICATION->IncludeAdminFile(GetMessage('BLTOOLS_TTNMSAT_INST_INSTALL_TITLE'),$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/step1.php");
			}
			elseif($step==2)
			{
				
				$this->InstallDB();
				$this->InstallFiles();
				
				$APPLICATION->IncludeAdminFile(GetMessage('BLTOOLS_TTNMSAT_INST_INSTALL_TITLE'),$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/step2.php");
			}
		}
	}
	
	function DoUninstall()
	{
		global $APPLICATION, $step;

		$POST_RIGHT = $APPLICATION->GetGroupRight($this->MODULE_ID);
		if($POST_RIGHT == "W")
		{
			$step = IntVal($step);
			if($step<2)
			{
				$APPLICATION->IncludeAdminFile(GetMessage('BLTOOLS_TTNMSAT_INST_UNINSTALL_TITLE'), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/unstep1.php");
			}
			elseif($step==2)
			{
				$this->UnInstallDB();
				
				$this->UnInstallFiles();
				
				$GLOBALS["errors"] = $this->errors;
				
				$APPLICATION->IncludeAdminFile(GetMessage('BLTOOLS_TTNMSAT_INST_UNINSTALL_TITLE'), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/unstep2.php");
			}
		}
	}

	function InstallDB()
	{

		global $APPLICATION;

		$this->errors = false;

		if($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}
		else
		{
			RegisterModule($this->MODULE_ID);
            
            RegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", $this->MODULE_ID, "CBitlateToolsIBlockElementHandler", "OnAfterIBlockElementAdd");
            RegisterModuleDependences("iblock", "OnAfterIBlockElementUpdate", $this->MODULE_ID, "CBitlateToolsIBlockElementHandler", "OnAfterIBlockElementUpdateHandler");
            RegisterModuleDependences("catalog", "OnPriceAdd", $this->MODULE_ID, "CBitlateToolsIBlockElementHandler", "OnPriceUpdateHandler");
            RegisterModuleDependences("catalog", "OnPriceUpdate", $this->MODULE_ID, "CBitlateToolsIBlockElementHandler", "OnPriceUpdateHandler");

            RegisterModuleDependences("blog", "OnCommentAdd", $this->MODULE_ID, "CBitlateToolsBlogCommentHandler", "OnCommentAdd");
            RegisterModuleDependences("blog", "OnCommentUpdate", $this->MODULE_ID, "CBitlateToolsBlogCommentHandler", "OnCommentUpdate");
            RegisterModuleDependences("blog", "OnCommentDelete", $this->MODULE_ID, "CBitlateToolsBlogCommentHandler", "OnCommentDelete");
            RegisterModuleDependences("main", "OnBeforeUserRegister", $this->MODULE_ID, "CBitlateToolsMainEventHandler", "OnBeforeUserRegisterHandler");
			return true;
		}
	}

	function UnInstallDB()
	{
		global $APPLICATION;
		$this->errors = false;

		UnRegisterModuleDependences("iblock", "OnAfterIBlockElementAdd", $this->MODULE_ID, "CBitlateToolsIBlockElementHandler", "OnAfterIBlockElementAdd");
        UnRegisterModuleDependences("iblock", "OnAfterIBlockElementUpdate", $this->MODULE_ID, "CBitlateToolsIBlockElementHandler", "OnAfterIBlockElementUpdateHandler");
        UnRegisterModuleDependences("catalog", "OnPriceAdd", $this->MODULE_ID, "CBitlateToolsIBlockElementHandler", "OnPriceUpdateHandler");
        UnRegisterModuleDependences("catalog", "OnPriceUpdate", $this->MODULE_ID, "CBitlateToolsIBlockElementHandler", "OnPriceUpdateHandler");

        UnRegisterModuleDependences("blog", "OnCommentAdd", $this->MODULE_ID, "CBitlateToolsBlogCommentHandler", "OnCommentAdd");
        UnRegisterModuleDependences("blog", "OnCommentUpdate", $this->MODULE_ID, "CBitlateToolsBlogCommentHandler", "OnCommentUpdate");
        UnRegisterModuleDependences("blog", "OnCommentDelete", $this->MODULE_ID, "CBitlateToolsBlogCommentHandler", "OnCommentDelete");
        UnRegisterModuleDependences("main", "OnBeforeUserRegister", $this->MODULE_ID, "CBitlateToolsMainEventHandler", "OnBeforeUserRegisterHandler");
        UnRegisterModule($this->MODULE_ID);

		if($this->errors !== false)
		{
			$APPLICATION->ThrowException(implode("<br>", $this->errors));
			return false;
		}

		return true;
	}




}
?>