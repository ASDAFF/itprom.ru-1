<?php
if (!CModule::IncludeModule("highloadblock")) return;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$Set_ID = $_SESSION["WF_IBL_SETTINGS_ID"];
unset($_SESSION["WF_IBL_SETTINGS_ID"]);
//Creating default values
$hldata = HL\HighloadBlockTable::getById($Set_ID)->fetch();
$hlentity = HL\HighloadBlockTable::compileEntity($hldata);
$hlHandler = $hlentity->getDataClass();
$getList = new Entity\Query($hlHandler);
$getList->setSelect(array('*'));
$getList->setOrder(array("ID" => "ASC"));
$getList->setFilter(array("ID"=>1));
$result = $getList->exec();
$result = new CDBResult($result);
if ($row = $result->Fetch()){
}else{
  $arData = array("UF_THEME" => "default", "UF_SHADOWS" => "default", "UF_BUTTONS" => "coral", "UF_BG" => "default");
  $hlHandler::add($arData);
}

$Brand_ID = $_SESSION["WF_IBL_BRANDS_ID"];
unset($_SESSION["WF_IBL_BRANDS_ID"]);

$hldata = HL\HighloadBlockTable::getById($Brand_ID)->fetch();
$hlentity = HL\HighloadBlockTable::compileEntity($hldata);
$hlHandler = $hlentity->getDataClass();
$sort = 100;
$arBrandsUt = array(
  "1 Marka" => "ref_files/7e44ec9828b17ace0d8f75a349b8de43.png",
  "Apollo" => "ref_files/61441e895fdde98034964c624e295f90.png",
  "AquaVita" => "ref_files/9d8f6c21dbd87f76b88a8b35e3cd0572.png",
  "BAS" => "ref_files/7eaea2afe6729ef29a25aeb82aba2513.png",
  "Cersanit" => "ref_files/9fe61dfbd7454a7ee27e41e0066fd3ba.png",
  "EAGO" => "ref_files/7d6f158e6fba7b90963c489c218fb8ef.png",
  "Kolpa-san" => "ref_files/a1906e21f88ebf48c6550117fb77b69f.png",
  "Loranto" => "ref_files/794eda4bc38c0decfb66455b436919e2.png",
  "RELISAN" => "ref_files/a3a02d848afdf90036f1def792d5adaf.png",
  "Roca" => "ref_files/bddd67008a780c90950540be078685a0.png",
  "Triton" => "ref_files/f75713924bd7964c999de3fbea43c2de.png",
  "Vayer" => "ref_files/5841ebf40c33bc9858245adfe7336427.png",
  "IDDIS" => "ref_files/85f24f3d3a9da494f411baa869b9df69.png",
  "Grohe" => "ref_files/6a2820fa128435a333ca473d06a78895.png",
  "Hansgrohe" => "ref_files/82499c22bd8a60b4ced944606973a91a.png"
);
WizardServices::IncludeServiceLang("highloadblocks.php", "ru");
foreach($arBrandsUt as $brandName => $BrandIMG){
  $lowerName = str_replace(array(" ","-"),"",strtolower($brandName));
  $arData = array("UF_NAME" => $brandName,
                  "UF_FILE" => array(
                    "name" => $lowerName.".png",
                    "type" => "image/png",
                    "tmp_name" => WIZARD_ABSOLUTE_PATH."/site/services/iblock/".$BrandIMG
                  ),
                  "UF_SORT" => $sort,
                  "UF_DESCRIPTION" => GetMessage("SHORT_DESC_".$lowerName),
                  "UF_FULL_DESCRIPTION" => GetMessage("LONG_DESC_".$lowerName),
                  "UF_LINK" => $lowerName,
                  "UF_EXTERNAL_CODE" => "",
                  "UF_XML_ID" => $lowerName
  );
  $result = $hlHandler::add($arData);
  $sort = $sort + 10;
}