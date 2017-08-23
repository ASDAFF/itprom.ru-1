<?global $DOCUMENT_ROOT, $MESS;
IncludeModuleLangFile(__FILE__);

if (class_exists("pimentos_mneniyapro")) return;

Class pimentos_mneniyapro extends CModule
{
	var $MODULE_ID = "pimentos.mneniyapro";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "N";
	var $INSTALL_APP_URL = 'http://dev.mneniya.pro/bitrix/install.php';
	var $UNINSTALL_APP_URL = 'http://dev.mneniya.pro/bitrix/uninstall.php';
	var $PASSWORD;
	var $PARTNER_NAME; 
	var $PARTNER_URI;
	
	function pimentos_mneniyapro()
	{
		$arModuleVersion = array();
        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
		$this->PARTNER_NAME = "Pimentos"; 
		$this->PARTNER_URI = "http://pimentos.com.ua/";
        $this->MODULE_NAME = "Mneniya.Pro";
        $this->MODULE_DESCRIPTION = GetMessage("MODULE_DESCRIPTION");
		$this->PASSWORD =  md5(time().'pimentos.mneniyapro');
	}

	function InstallFiles($arParams = array())
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/pimentos.mneniyapro/install/module",
					 $_SERVER["DOCUMENT_ROOT"]."/", true, true);
		$this->set_password();
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/mneniyapro");
		return true;
	}
	
	function DoInstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->InstallDB();
		$this->InstallFiles();
		$this->InstallOnAppServer();
		$APPLICATION->IncludeAdminFile(GetMessage("MODULE_INSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/pimentos.mneniyapro/install/step.php");
	}

	function DoUninstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallOnAppServer();
		$APPLICATION->IncludeAdminFile(GetMessage("MODULE_UNINSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/pimentos.mneniyapro/install/unstep.php");
	}
	
	function InstallDB()
	{
		RegisterModule("pimentos.mneniyapro");
		RegisterModuleDependences("main", "OnEndBufferContent", "pimentos.mneniyapro", "CMneniyaproEdit", "editContent");
		return true;
	}

	function UnInstallDB()
	{
		UnRegisterModuleDependences("main", "OnEndBufferContent", "pimentos.mneniyapro", "CMneniyaproEdit", "editContent");
		UnRegisterModule("pimentos.mneniyapro");
		return true;
	}
	
	function InstallOnAppServer()
	{
		$data = array(
					   'sitename' => $_SERVER['SERVER_NAME'],
					   'feedurl'  => (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER["SERVER_NAME"].'/mneniyapro?password='.$this->PASSWORD
		);
		$this->send_request($this->INSTALL_APP_URL, $data);
	}
	
	function UnInstallOnAppServer()
	{
		$data = array(
					   'sitename' => (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER["SERVER_NAME"]
		);
		$this->send_request($this->UNINSTALL_APP_URL, $data);
	}
	
	function send_request($url, $params)
	{
		file_get_contents($url.'?'.http_build_query($params));
	}
	
	function set_password()
	{
		$file = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/mneniyapro/index.php");
		$file = str_replace('#password#', $this->PASSWORD, $file);
		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/mneniyapro/index.php", $file);
	}
}
?>