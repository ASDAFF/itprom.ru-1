<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!CModule::IncludeModule("blog")) {
	return false;
}

$blogUrl = 'NL_CATALOG_REVIEWS_' . WIZARD_SITE_ID;
$blogExist = false;
$blogGroupExist = false;

$blogIterator = CBlog::GetList(
	array(),
	array('URL' => $blogUrl, "GROUP_SITE_ID" => WIZARD_SITE_ID),
	false,
	false,
	array('ID', 'GROUP_ID', 'EMAIL_NOTIFY', 'GROUP_SITE_ID')
);
if ($blog = $blogIterator->Fetch())
{
	$blogExist = true;
	$blogGroupExist = true;
}
unset($blogIterator);
if ($blogGroupExist)
{
	$blogGroupID = (int)$blog['GROUP_ID'];
	$blogID = (int)$blog['ID'];
}
else
{
	$fields = array(
		'SITE_ID' => WIZARD_SITE_ID,
		'NAME' => GetMessage('IBLOCK_CSC_BLOG_GROUP_NAME')
	);
	$blogGroupIterator = CBlogGroup::GetList(array(), $fields, false, false, array('ID'));
	if ($blogGroup = $blogGroupIterator->Fetch())
	{
		$blogGroupID = (int)$blogGroup['ID'];
	}
	else
	{
		$blogGroupID = (int)CBlogGroup::Add($fields);
	}
	unset($fields);
	if ($blogGroupID > 0)
	{
		if (!$blogExist)
		{
			$fields = array(
				"NAME" => GetMessage("IBLOCK_CSC_BLOG_NAME"),
				"DESCRIPTION" => GetMessage("IBLOCK_CSC_BLOG_DESCRIPTION"),
				"GROUP_ID" => $blogGroupID,
				"ENABLE_COMMENTS" => 'Y',
				"ENABLE_IMG_VERIF" => 'Y',
				"EMAIL_NOTIFY" => 'Y',
				"URL" => $blogUrl,
				"ACTIVE" => "Y",
				"OWNER_ID" => 1,
				"SEARCH_INDEX" => "N",
				"AUTO_GROUPS" => "N",
				"PERMS_POST" => array(
					1 => BLOG_PERMS_READ,
					2 => BLOG_PERMS_READ
				),
				"PERMS_COMMENT" => array(
					1 => BLOG_PERMS_WRITE,
					2 => BLOG_PERMS_WRITE
				),
				"=DATE_CREATE" => $DB->GetNowFunction(),
				"=DATE_UPDATE" => $DB->GetNowFunction()
			);

			$blogID = (int)CBlog::Add($fields);
			unset($fields);
			if ($blogID > 0) {
				//adding user fields
				$arUserFields = array (
					array (
						'ENTITY_ID' => 'BLOG_COMMENT',
						'FIELD_NAME' => 'UF_NL_RATING',
						'USER_TYPE_ID' => 'integer',
						'XML_ID' => 'UF_NL_RATING',
						'SORT' => '100',
						'MULTIPLE' => 'N',
						'MANDATORY' => 'N',
						'SHOW_FILTER' => 'N',
						'SHOW_IN_LIST' => 'Y',
						'EDIT_IN_LIST' => 'Y',
						'IS_SEARCHABLE' => 'N',
					),
					array (
						'ENTITY_ID' => 'BLOG_COMMENT',
						'FIELD_NAME' => 'UF_NL_AVATAR',
						'USER_TYPE_ID' => 'file',
						'XML_ID' => 'UF_NL_AVATAR',
						'SORT' => '200',
						'MULTIPLE' => 'N',
						'MANDATORY' => 'N',
						'SHOW_FILTER' => 'N',
						'SHOW_IN_LIST' => 'Y',
						'EDIT_IN_LIST' => 'Y',
						'IS_SEARCHABLE' => 'N',
						'SETTINGS' => array(
							'EXTENSIONS' => 'jpg, jpeg, png, bmp',
						),
					),
				);
				$arLanguages = Array();
				$rsLanguage = CLanguage::GetList($by, $order, array());
				while($arLanguage = $rsLanguage->Fetch())
					$arLanguages[] = $arLanguage["LID"];

				$obUserField  = new CUserTypeEntity;
				foreach ($arUserFields as $arFields)
				{
					$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arFields["ENTITY_ID"], "FIELD_NAME" => $arFields["FIELD_NAME"]));
					if ($dbRes->Fetch())
						continue;

					$arLabelNames = Array();
					foreach($arLanguages as $languageID)
					{
						$arLabelNames[$languageID] = GetMessage($arFields["FIELD_NAME"]);
					}

					$arFields["EDIT_FORM_LABEL"] = $arLabelNames;
					$arFields["LIST_COLUMN_LABEL"] = $arLabelNames;
					$arFields["LIST_FILTER_LABEL"] = $arLabelNames;

					$ID_USER_FIELD = $obUserField->Add($arFields);
				}
			}
		}
	}
}