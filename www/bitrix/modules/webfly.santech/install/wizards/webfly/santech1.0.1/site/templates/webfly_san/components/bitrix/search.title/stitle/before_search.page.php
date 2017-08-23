<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

function redirect($url, &$flag){
	if(!$flag) return;
	$flag = false;
	header('Location: '.$url);
}

$toSearchPage = true; //for redirect

if(isset($_REQUEST["site_dir"]))
	$site_dir = $_REQUEST["site_dir"];
else
	$site_dir = SITE_DIR;

/*---START GET QUERY---*/
	if(isset($_REQUEST["q"]))
		$q = trim($_REQUEST["q"]);
	else
		$q = false;
		
	$arQuery = array();
	if($q!==false)
	{
		if(CModule::IncludeModule("search"))
		{
			$arLang = CSearchLanguage::GuessLanguage($q);
			if(is_array($arLang) && $arLang["from"] != $arLang["to"])
				$arQuery["QUERY"] = htmlspecialcharsex(CSearchLanguage::ConvertKeyboardLayout($q, $arLang["from"], $arLang["to"]));
			else
				$arQuery["QUERY"] = htmlspecialcharsex($q);
		}
		else
			$arQuery["QUERY"] = htmlspecialcharsex($q);
	}
	else
		$arQuery["QUERY"] = false;

/*---END GET QUERY---*/
if($arQuery["QUERY"]){

	/*---START TREE ---*/
		$obCache = new CPHPCache;
		if($obCache->InitCache(86400, 'search-tree', "/"))	{
			$vars = $obCache->GetVars();
			$tree = $vars["TREE"];
		} else {
			$tree = array();
			if(CModule::IncludeModule("iblock")) { 
				$obSection = CIBlockSection::GetTreeList();
				while($item = $obSection->GetNext()){
					$tree[] = $item;
				}
			}
		}
		if($obCache->StartDataCache()) {
			$obCache->EndDataCache(array(
				"TREE"    => $tree,
				)); 
		}
	/*---END TREE--*/
	
	/*---START SEARCH IN TREE ---*/
		foreach ($tree as $item) {
			$sc = $item["NAME"];
			$qu = $arQuery["QUERY"];
			$len_q = strlen($qu);
			if($len_q > 1){
			if(strlen($sc) - $len_q <= 2 || $len_q >= 5) {
				if(stripos($sc, $qu) !== false) {
					redirect($site_dir.substr( $item["SECTION_PAGE_URL"], 1 ), $toSearchPage);
					break;
				}elseif(stripos($sc, substr($qu, 0, $len_q-1)) !== false){
					redirect($site_dir.substr( $item["SECTION_PAGE_URL"], 1 ), $toSearchPage);
					break;
				}
			}}
		}
	/*---END SEARCH IN TREE ---*/
}

if(isset($_REQUEST["search_page"]))
	$page = $_REQUEST["search_page"];
else
	$page = '/search/catalog.php';

redirect($page.'?q='.$_REQUEST["q"], $toSearchPage);
?>