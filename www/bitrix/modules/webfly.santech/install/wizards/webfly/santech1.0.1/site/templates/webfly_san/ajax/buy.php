<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
include_once "../wfunctions/iblocks.php";
$id = $_POST["id"];
$price = $_POST["cost"];

$rWare = CCatalogProduct::GetList(array("SORT"=>"ASC"),array("ID"=>$id),false,false,false);
$ware = $rWare->Fetch();

$name = $ware["ELEMENT_NAME"];
$optionNames = "";
if(!empty($_POST["options"])){
  $opts = wfIBSearchElementsByProp("#IBLOCK_OPTIONS#",array("ID"=>$_POST["options"]),array("CODE"));
  foreach($opts as $option){
    $optionNames = $option["NAME"];
  }
  $name .= " ({$optionNames})";
}

/*if(!empty($_POST["credit"])){
  $optionNames .= ", ".($_POST["credit"]);
}*/

$arFields = array(
  "PRODUCT_ID" => $id,
  "PRODUCT_PRICE_ID" => 0,
  "PRICE" => $price,
  "CURRENCY" => "RUB",
  "WEIGHT" => 0,
  "QUANTITY" => 1,
  "LID" => LANG,
  "DELAY" => "N",
  "CAN_BUY" => "Y",
  "NAME" => $name,
  "NOTES" => "",
);
/*$arProps = array();

$arProps[] = array(
  "NAME" => "Содержимое",
  "CODE" => "WF_PACK_CONTENT",
  "VALUE" => "$names"
);
if(!empty($names2)){
  $arProps[] = array(
    "NAME" => "Содержимое ч2",
    "CODE" => "WF_PACK_CONTENT2",
    "VALUE" => "$names2"
  );
}
$arProps[] = array(
  "NAME" => "IDs",
  "CODE" => "WF_PACK_TORGS",
  "VALUE" => "$torgs"
);


$arFields["PROPS"] = $arProps;
*/
CSaleBasket::Add($arFields);
?>