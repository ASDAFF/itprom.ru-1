<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!CModule::IncludeModule("highloadblock"))
	return;

$COLOR_ID = $_SESSION["NL_HBLOCK_COLOR_ID"];
unset($_SESSION["NL_HBLOCK_COLOR_ID"]);

$SOCIAL_ID = $_SESSION["NL_HBLOCK_SOCIAL_ID"];
unset($_SESSION["NL_HBLOCK_SOCIAL_ID"]);

$SOCIAL_TYPE_ID = $_SESSION["NL_SOCIAL_TYPE_ID"];
unset($_SESSION["NL_SOCIAL_TYPE_ID"]);

//adding rows
WizardServices::IncludeServiceLang("references.php", LANGUAGE_ID);

use Bitrix\Highloadblock as HL;
global $USER_FIELD_MANAGER;

if ($COLOR_ID)
{
	$hldata = HL\HighloadBlockTable::getById($COLOR_ID)->fetch();
	$hlentity = HL\HighloadBlockTable::compileEntity($hldata);

	$entity_data_class = $hlentity->getDataClass();
	$arColors = array(
		"PURPLE" => "references_files/iblock/0d3/0d3ef035d0cf3b821449b0174980a712.jpg",
		"BROWN" => "references_files/iblock/f5a/f5a37106cb59ba069cc511647988eb89.jpg",
		"SEE" => "references_files/iblock/f01/f01f801e9da96ae5a7f26aae01255f38.jpg",
		"BLUE" => "references_files/iblock/c1b/c1ba082577379bdc75246974a9f08c8b.jpg",
		"ORANGERED" => "references_files/iblock/0ba/0ba3b7ecdef03a44b145e43aed0cca57.jpg",
		"REDBLUE" => "references_files/iblock/1ac/1ac0a26c5f47bd865a73da765484a2fa.jpg",
		"RED" => "references_files/iblock/0a7/0a7513671518b0f2ce5f7cf44a239a83.jpg",
		"GREEN" => "references_files/iblock/b1c/b1ced825c9803084eb4ea0a742b2342c.jpg",
		"WHITE" => "references_files/iblock/b0e/b0eeeaa3e7519e272b7b382e700cbbc3.jpg",
		"BLACK" => "references_files/iblock/d7b/d7bdba8aca8422e808fb3ad571a74c09.jpg",
		"PINK" => "references_files/iblock/1b6/1b61761da0adce93518a3d613292043a.jpg",
		"AZURE" => "references_files/iblock/c2b/c2b274ad2820451d780ee7cf08d74bb3.jpg",
		"JEANS" => "references_files/iblock/24b/24b082dc5e647a3a945bc9a5c0a200f0.jpg",
		"BEIGE" => "references_files/iblock/64f/88a96213ea5d03946dd07ae0e6cd1838.jpg",
		"GOLD" => "references_files/iblock/d72/d72c1b36ea66f726f51f7eecc828f69d.png",
		"ORANGE" => "references_files/iblock/afe/afe9015e621735f902a0f03edc491274.png",
		"YELLOW" => "references_files/iblock/88d/88d24ce03fad98620846881a884ca916.png",
		"GRAY" => "references_files/iblock/091/091661fda6f263d65415cb38de90ba63.png",
	);
	$sort = 0;
	foreach($arColors as $colorName=>$colorFile)
	{
		$sort+= 100;
		$arData = array(
			'UF_NAME' => GetMessage("WZD_REF_COLOR_".$colorName),
			'UF_FILE' =>
				array (
					'name' => ToLower($colorName).".jpg",
					'type' => 'image/jpeg',
					'tmp_name' => WIZARD_ABSOLUTE_PATH."/site/services/iblock/".$colorFile
				),
			'UF_SORT' => $sort,
			'UF_DEF' => ($sort > 100) ? "0" : "1",
			'UF_XML_ID' => ToLower($colorName)
		);
		$USER_FIELD_MANAGER->EditFormAddFields('HLBLOCK_'.$COLOR_ID, $arData);
		$USER_FIELD_MANAGER->checkFields('HLBLOCK_'.$COLOR_ID, null, $arData);

		$result = $entity_data_class::add($arData);
	}
}

if ($SOCIAL_ID) {
    COption::SetOptionString("bitlate.toolsshop", "NL_HBLOCK_SOCIAL_ID", $SOCIAL_ID, false, WIZARD_SITE_ID);
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."/include/social_links.php", array("NL_SOCIAL_ID" => $SOCIAL_ID));
}

if ($SOCIAL_ID && $SOCIAL_TYPE_ID)
{
	
	$hldata = HL\HighloadBlockTable::getById($SOCIAL_ID)->fetch();
	$hlentity = HL\HighloadBlockTable::compileEntity($hldata);

	$entity_data_class = $hlentity->getDataClass();
	$arSocials = array(
		"facebook" => "http://facebook.com",
		"vk" => "http://vk.com",
		"ok" => "http://ok.ru",
		"twitter" => "http://twitter.com",
		"google" => "http://google.com",
		"instagram" => "https://www.instagram.com/",
	);
	$sort = 0;
	$typeList = array();
	$rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => $SOCIAL_TYPE_ID));
	while ($arRes = $rsEnum->Fetch()) {
		$typeList[$arRes["VALUE"]] = $arRes["ID"];
	}
	foreach($arSocials as $socialType=>$socialLink)
	{
		$sort+= 100;
		$arData = array(
			'UF_TYPE' => $typeList[$socialType],
			'UF_LINK' => $socialLink,
			'UF_SORT' => $sort,
		);
		$USER_FIELD_MANAGER->EditFormAddFields('HLBLOCK_'.$SOCIAL_ID, $arData);
		$USER_FIELD_MANAGER->checkFields('HLBLOCK_'.$SOCIAL_ID, null, $arData);

		$result = $entity_data_class::add($arData);
	}
}
?>