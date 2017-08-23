<?
IncludeModuleLangFile(__FILE__);
Class webfly_santech extends CModule
{
	const MODULE_ID = 'webfly.santech';
	var $MODULE_ID = 'webfly.santech'; 
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("webfly.santech_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("webfly.santech_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("webfly.santech_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("webfly.santech_PARTNER_URI");
	}

	function InstallDB($arParams = array())
	{
		RegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CWebflySantech', 'OnBuildGlobalMenu');
		return true;
	}
  
  function InstallFiles($arParams = array()){
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".self::MODULE_ID."/install/wizards/webfly/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/wizards/webfly/", true, true);
	}
  
  function UnInstallFiles(){
    
	}
	function UnInstallDB($arParams = array())
	{
		UnRegisterModuleDependences('main', 'OnBuildGlobalMenu', self::MODULE_ID, 'CWebflySantech', 'OnBuildGlobalMenu');
		return true;
	}

	function DoInstall(){
		global $APPLICATION;
		$this->InstallDB();
    $this->InstallFiles();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall(){
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallDB();
    //$this->UnInstallFiles();
	}
}

?>
