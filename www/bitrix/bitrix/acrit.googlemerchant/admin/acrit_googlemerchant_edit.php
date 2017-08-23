<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/acrit.googlemerchant/include.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/acrit.googlemerchant/prolog.php");
global $APPLICATION;
CJSCore::Init(array("jquery"));
$APPLICATION->AddHeadScript('/bitrix/js/iblock/iblock_edit.js');
$APPLICATION->AddHeadScript('/bitrix/js/acrit.googlemerchant/gm.js');
$APPLICATION->AddHeadScript('/bitrix/js/acrit.googlemerchant/choosen.js');
$APPLICATION->AddHeadString('<link rel="stylesheet" href="/bitrix/js/acrit.googlemerchant/choosen.css">');
$iIblock=CModule::IncludeModule("iblock") ? true:false;
$iCurrency=CModule::IncludeModule("currency")? true:false;
$iCatalog=CModule::IncludeModule("catalog")? true:false;
CModule::IncludeModule("acrit.googlemerchant");
CModule::IncludeModule("main");
IncludeModuleLangFile(__FILE__);
$POST_RIGHT = $APPLICATION->GetGroupRight("acrit.googlemerchant");
if($POST_RIGHT=="D")
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

if($iIblock)
{
	$db_iblock_type = CIBlockType::GetList();
	while($ar_iblock_type = $db_iblock_type->Fetch())
	{
		if($arIBType = CIBlockType::GetByIDLang($ar_iblock_type["ID"], LANG))
		{
			$arIBlockType[$arIBType["ID"]] = "[".$arIBType["ID"]."] ".htmlspecialcharsEx($arIBType["NAME"]);
		}   
	}
}

$ID = intval($ID);        // Id of the edited record
$bCopy = ($action == "copy");
$message = null;
$bVarsFromForm = false;
if($REQUEST_METHOD == "POST" && ($save!="" || $apply!="") && $POST_RIGHT=="W" && check_bitrix_sessid())
{
    $profile = new CProfileAdmin();
	$profile->SetSettings($IBLOCK_ID);$profile->SetSettings($SECTION_ID);$profile->SetSettings($GOOGLE_CATEGORY);
	$profile->SetSettings($CONDITION_RULE);$profile->SetSettings($XML_DATA);
    $arFields = Array(
        "NAME"    => $NAME,
        "TYPE_RUN"    => $TYPE_RUN,
        "FEED"		=> $FEED,
		"COMPANY"	=> $COMPANY,
		"SHOPNAME"	=> $SHOPNAME,
		"DESCRIPTION"	=> $DESCRIPTION,
		"DOMAIN_NAME"	=> $DOMAIN_NAME,
		"NAMESCHEMA"	=> $NAMESCHEMA,
		"ACTIVE"    => ($ACTIVE <> "Y"? "N":"Y"),
		"ENCODING"    => $ENCODING,
		"IBLOCK_ID"	=>base64_encode(serialize($IBLOCK_ID)),
		"SECTION_ID"	=>base64_encode(serialize($SECTION_ID)),
		"GOOGLE_CATEGORY"	=>base64_encode(serialize($GOOGLE_CATEGORY)),
		"CONDITIONS"	=> $CONDITIONS,
		"LID"	=> $LID,
		"DETAIL_PAGE_URL"	=> $DETAIL_PAGE_URL,
		"USE_SKU"	=>($USE_SKU <> "Y"? "N":"Y"),
		"CHECK_INCLUDE"	=>($CHECK_INCLUDE <> "Y"? "N":"Y"),
		"FORORDER"	=>($FORORDER <> "Y"? "N":"Y"),
		"OTHER"	=>($OTHER <> "Y"? "N":"Y"),
		"CONDITION_RULE"	=>base64_encode(serialize($CONDITION_RULE)),
		"PRICE"	=> $PRICE,
		"XML_DATA"	=>base64_encode(serialize($XML_DATA)),
		"DATA_START"	=> strtotime($DATA_START),
		"PERIOD"	=> $PERIOD,
		"START_LAST_TIME" => $START_LAST_TIME,
		"USE_XML_FILE"	=>($USE_XML_FILE <> "Y"? "N":"Y"),
		"URL_DATA_FILE"	=> $URL_DATA_FILE,
		"AGELEVEL" => $AGELEVEL,
		"SKU_SHABLON_PROP"=>$SKU_SHABLON_PROP,
    );

    if($ID>0)
    {
        $res = $profile->Update($ID, $arFields);
    }
    else
    {
        $ID = $profile->Add($arFields);
        $res = ($ID>0);
    }
    if($res)
    {
        if($apply!="")
            LocalRedirect("/bitrix/admin/acrit_googlemerchant_edit.php?ID=".$ID."&mess=ok&lang=".LANG."&tabControl_active_tab=".$_POST["tabControl_active_tab"]);
        else
            LocalRedirect("/bitrix/admin/acrit_googlemerchant_list.php?lang=".LANG);
    }
    else
    {
        if($e = $APPLICATION->GetException())
            $message = new CAdminMessage(GetMessage("gmprofile_save_error"), $e);
        $bVarsFromForm = true;
    }
}
ClearVars();
if($ID>0 || $copy)
{
    if($ID)$parser = CProfileAdmin::GetByID($ID);
    elseif($copy) $parser = CProfileAdmin::GetByID($copy);
    if(!$parser->ExtractFields("acrit_"))
        $ID=0;
}

if($bVarsFromForm)
    $DB->InitTableVarsForEdit("b_acrit_list_profile", "", "acrit_");
$APPLICATION->SetTitle(($ID>0? GetMessage("gmprofile_title_edit") : GetMessage("gmprofile_title_add")));
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
$aMenu = array(
    array(
        "TEXT"=>GetMessage("gmprofile_list"),
        "TITLE"=>GetMessage("gmprofile_list_title"),
        "LINK"=>"acrit_googlemerchant_list.php?lang=".LANG,
        "ICON"=>"btn_list",
    )
);
if($ID>0)
{
    $aMenu[] = array("SEPARATOR"=>"Y");
    $aMenu[] = array(
        "TEXT"=>GetMessage("gmprofile_add"),
        "TITLE"=>GetMessage("rubric_mnu_add"),
        "LINK"=>"acrit_googlemerchant_edit.php?lang=".LANG,
        "ICON"=>"btn_new",
    );
    $aMenu[] = array(
        "TEXT"=>GetMessage("gmprofile_copy"),
        "TITLE"=>GetMessage("rubric_mnu_copy"),
        "LINK"=>"acrit_googlemerchant_edit.php?copy=".$ID."&lang=".LANG,
        "ICON"=>"btn_copy",
    );
    $aMenu[] = array(
        "TEXT"=>GetMessage("gmprofile_delete"),
        "TITLE"=>GetMessage("gmprofile_mnu_del"),
        "LINK"=>"javascript:if(confirm('".GetMessage("gmprofile_mnu_del_conf")."'))window.location='acrit_googlemerchant_list.php?ID=".$ID."&action=delete&lang=".LANG."&".bitrix_sessid_get()."';",
        "ICON"=>"btn_delete",
    );
}
$context = new CAdminContextMenu($aMenu);
$context->Show();

$aTabs = array(
	array('DIV' => 'edit1', 'TAB' => GetMessage('acrit_mod_tab1'), 'TITLE' =>GetMessage('acrit_tab1_title')),
	array('DIV' => 'edit2', 'TAB' => GetMessage('acrit_mod_tab2'), 'TITLE' =>GetMessage('acrit_tab2_title')),
	array('DIV' => 'edit3', 'TAB' => GetMessage('acrit_mod_tab3'), 'TITLE' =>GetMessage('acrit_tab3_title')),
	array('DIV' => 'edit4', 'TAB' => GetMessage('acrit_mod_tab4'), 'TITLE' =>GetMessage('acrit_tab4_title')),
	array('DIV' => 'edit5', 'TAB' => GetMessage('acrit_mod_tab5'), 'TITLE' =>GetMessage('acrit_tab5_title')),
);
$tabControl = new CAdminTabControl('tabControl', $aTabs,true,true);
if(isset($_REQUEST["mess"]) && $_REQUEST["mess"] == "ok" && $ID>0)
    CAdminMessage::ShowMessage(array("MESSAGE"=>GetMessage("gmprofile_saved"), "TYPE"=>"OK"));
if($message)
    echo $message->Show();
elseif($rubric->LAST_ERROR!="")
    CAdminMessage::ShowMessage($rubric->LAST_ERROR);
if(isset($_REQUEST['end']) && $_REQUEST['end']==1 && $ID>0){
    if(isset($_GET['SUCCESS'][0])){
      foreach($_GET['SUCCESS'] as $success) CAdminMessage::ShowMessage(array("MESSAGE"=>$success, "TYPE"=>"OK"));
    }
    if(isset($_GET['ERROR'][0])){
        foreach($_GET['ERROR'] as $error) CAdminMessage::ShowMessage($error);
    }
}
$arItems = CIBlockParameters::GetPathTemplateMenuItems("DETAIL", "__SetUrlVar", "mnu_DETAIL_PAGE_URL", "DETAIL_PAGE_URL");
if($acrit_CATALOG_TYPE == 'O')
{
	$arItems[] = array("SEPARATOR" => true);
	$arItems[] = array(
		"TEXT" => GetMessage("IB_E_URL_PRODUCT_ID"),
		"TITLE" => "#PRODUCT_URL# - ".GetMessage("IB_E_URL_PRODUCT_ID"),
		"ONCLICK" => "__SetUrlVar('#PRODUCT_URL#', 'mnu_DETAIL_PAGE_URL', 'DETAIL_PAGE_URL')",
	);
}
$u = new CAdminPopupEx("mnu_DETAIL_PAGE_URL",$arItems,array("zIndex" => 2000));
$u->Show();
$coding=array("UTF-8"=>"UTF-8","UTF-16"=>"UTF-16","Latin1"=>"ISO8859-1","Windows-1251"=>"Windows-1251","ASCII"=>"ASCII");
?>
<script type="text/javascript">
var CellTPL = new Array();
<?
if(count($arCellTemplates)>0)
foreach ($arCellTemplates as $key => $value)
{?>
	CellTPL[<? echo $key; ?>] = '<? echo $value; ?>';
<?}?>
var CellAttr = new Array();
<?
if(count($arCellAttr)>0)
foreach ($arCellAttr as $key => $value)
{?>
	CellAttr[<? echo $key; ?>] = '<? echo $value; ?>';
<?}?>
</script>
 <style type="text/css" media="all">
    .chosen-rtl .chosen-drop { left: -9000px; }
  </style>
<form method="POST" id="gm-profile" Action="<?echo $APPLICATION->GetCurPage()?>" ENCTYPE="multipart/form-data" name="post_form">
<?php $tabControl->Begin();
if($ID<=0 or $ID=="")
{
$acrit_ACTIVE="Y";
$acrit_TYPE_RUN="comp";
}
$tabControl->BeginNextTab();?>
	<tr class="heading">
		<td colspan="2"><?=GetMessage("ACRIT_GENERAL_PARAMETER")?></td>
	</tr>
	<tr>
        <td width="40%" class="adm-detail-content-cell-l"><?echo GetMessage("gmprofile_active")?></td>
        <td width="60%" class="adm-detail-content-cell-r"><input type="checkbox" name="ACTIVE" value="Y"<?if($acrit_ACTIVE == "Y") echo " checked"?>></td>
    </tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="NAME"><?=GetMessage("ACRIT_GENERAL_PARAMETER_NAME")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="text" name="NAME" size="30" maxlength="255" value="<?=$acrit_NAME?>" />
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="FEED"><?=GetMessage("ACRIT_GENERAL_PARAMETER_CODE")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="text" name="FEED" size="30" maxlength="30" value="<?=$acrit_FEED?>">
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="DESCRIPTION"><?=GetMessage("ACRIT_GENERAL_PARAMETER_DESCRIPTION")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<textarea name="DESCRIPTION" cols="32" rows="7"><?=$acrit_DESCRIPTION?></textarea>
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="SHOPNAME"><?=GetMessage("ACRIT_GENERAL_PARAMENT_SHOPNAME")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="text" size="30" name="SHOPNAME" value="<?=$acrit_SHOPNAME?>" >
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="COMPANY"><?=GetMessage("ACRIT_GENERAL_PARAMETER_COMPANY_NAME")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="text" size="30" name="COMPANY" value="<?=$acrit_COMPANY?>" >
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="DOMAIN_NAME"><?=GetMessage("ACRIT_GENERAL_PARAMETER_SITE_URL")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="text" size="30" name="DOMAIN_NAME" value="<?=$acrit_DOMAIN_NAME?>" >
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="LID"><?=GetMessage("ACRIT_GENERAL_PARAMETER_SITE_ID")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<?echo CLang::SelectBox("LID", $acrit_LID);?>
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="ENCODING"><?=GetMessage("ACRIT_GENERAL_PARAMETER_ENCODING")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<select name="ENCODING">
				<option value=""><?php echo GetMessage("ACRIT_SETUP_PARAMETER_OPTION_NAMECHEMA_NON");?></value>
				<?php foreach($coding as $t=>$c){
					if($acrit_ENCODING==$t) $sel=" selected ";else $sel="";?>
					<option value="<?php echo $t;?>"<?php echo $sel;?>><?php echo $c;?></option>
				<? }?>
			</select>
		</td>
	</tr>
	<?
	$listpropsku=array("DEFAULT","FIELD*ID","FIELD*CODE");
	$listpropsku1=array(GetMessage("ACRIT_GENERAL_PARAMETER_SKU_DETAIL_DEFAULT"),"/ID",GetMessage("SYBMOL_CODE"));
	$ib=unserialize(base64_decode($acrit_IBLOCK_ID));
	if(is_array($ib) && sizeof($ib)>0)
	{
		foreach($ib as $ib_sku)
		{
			$arOffers = CCatalogSKU::GetInfoByProductIBlock($ib_sku);
			if (!empty($arOffers['IBLOCK_ID']))
			{
				$intOfferIBlockID = $arOffers['IBLOCK_ID'];
				$strPerm = 'D';
				$rsOfferIBlocks = CIBlock::GetByID($intOfferIBlockID);
				if ($arOfferIBlock = $rsOfferIBlocks->Fetch())
				{
					$bBadBlock = !CIBlockRights::UserHasRightTo($intOfferIBlockID, $intOfferIBlockID, "iblock_admin_display");
					if ($bBadBlock)
					{
						echo GetMessage("ERR_NO_ACCESS_IBLOCK_SKU");
					}
				}
				else
				{
					echo GetMessage("ERR_NO_IBLOCK_SKU_FOUND");
					
				}
				$boolOffers = true;
			}
			else
			{
				$boolOffers=false;
			}
			if ($boolOffers)
			{
				$rsProps = CIBlockProperty::GetList(array('SORT' => 'ASC'),array('IBLOCK_ID' => $intOfferIBlockID,'ACTIVE' => 'Y'));
				while ($arProp = $rsProps->Fetch())
				{
					if($arProp["PROPERTY_TYPE"]=="E")
					{
						$listpropsku[]="PROP*".$arProp["CODE"]."*ID";
						$listpropsku1[]="/".$arProp["NAME"].GetMessage("ACRIT_GENERAL_PARAMETER_SKU_DETAIL_PROPERTY_EL_ID");
						$listpropsku[]="PROP*".$arProp["CODE"]."*CODE";
						$listpropsku1[]="/".$arProp["NAME"].GetMessage("ACRIT_GENERAL_PARAMETER_SKU_DETAIL_PROPERTY_EL_CODE");
					}
					elseif($arProp["PROPERTY_TYPE"]!="F")
					{
						$listpropsku[]="PROP*".$arProp["CODE"];
						$listpropsku1[]="/".$arProp["NAME"].GetMessage("ACRIT_GENERAL_PARAMETER_SKU_DETAIL_PROPERTY");
					}
				}
			}
		}
	
	}
	$listsku=array("reference_id"=>$listpropsku,"reference"=>$listpropsku1);
	?>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="DETAIL_PAGE_URL"><?=GetMessage("ACRIT_GENERAL_PARAMETER_DETAIL_URL")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="text" size="30" id="DETAIL_PAGE_URL" name="DETAIL_PAGE_URL" value="<?=$acrit_DETAIL_PAGE_URL?>" >
			<input type="button" id="mnu_DETAIL_PAGE_URL" value="...">
			<?=SelectBoxFromArray("SKU_SHABLON_PROP", $listsku,$acrit_SKU_SHABLON_PROP,GetMessage("ACRIT_LAYER_EDIT_TYPE_DEFAULT"), "", "");?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<div class="adm-info-message">
			<?=GetMessage("ACRIT_GENERAL_PARAMETER_DETAILPATH_MESSAGE")?></div>
		</td>
	</tr>
	<tr class="heading">
		<td colspan="2"><?=GetMessage("ACRIT_GENERAL_PARAMETER_GOOGLEMERCHANT_IB")?></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<div class="adm-info-message">
			<?=GetMessage("ACRIT_GENERAL_PARAMETER_IBLOCK_MESSAGE")?></div>
		</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
		<?=GetSectionList(unserialize(base64_decode($acrit_SECTION_ID)), 'IBLOCK_TYPE_ID', 'IBLOCK_ID','SECTION_ID',array('CHECK_PERMISSIONS' => 'Y','MIN_PERMISSION' => 'W'),"","","",'','','',true,5);?>		
  	</td>
	</tr>
		<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="USE_SKU"><?=GetMessage("ACRIT_GENERAL_PARAMETER_USE_SKU")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="checkbox" size="30" id="sku" name="USE_SKU" value="Y" <?if(!$iCatalog) echo "disabled";?><?if($acrit_USE_SKU == "Y") echo "checked";?> onclick="checkSKU(this.checked);">
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="CHECK_INCLUDE"><?=GetMessage("ACRIT_GENERAL_PARAMETER_CHECK_INCLUDE")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="checkbox" size="30" name="CHECK_INCLUDE" value="Y" <?if($acrit_CHECK_INCLUDE == "Y") echo "checked";?>/>
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="OTHER"><?=GetMessage("ACRIT_GENERAL_PARAMETER_IBLOCK_CATEGORY")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="checkbox" size="30" name="OTHER" value="Y" <?if($acrit_OTHER == "Y") echo "checked";?> />
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<div class="adm-info-message">
			<?=GetMessage("ACRIT_GENERAL_PARAMETER_OTHER_MESSAGE")?></div>
		</td>
	</tr>
	<?$tabControl->BeginNextTab();?>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="NAMESCHEMA"><?=GetMessage("ACRIT_SETUP_PARAMETER_OPTION_NAMECHEMA")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<? $namesku=array("0"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_NAMECHEMA_NON"),
							"NAME_SKU"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_NAMECHEMA_NAME_SKU"),
							"NAME_OFFER"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_NAMECHEMA_NAME_OFFER"),
							"NAME_OFFER_SKU"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_NAMECHEMA_NAME_OFFER_SKU"));?>
			<select name="NAMESCHEMA">
			<?foreach($namesku as $code=>$val)
			{?>
				<option value="<?=$code?>" <?if ($code==$acrit_NAMESCHEMA) echo "selected"?>><?=$val?></option>
			<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="AGELEVEL"><?=GetMessage("ACRIT_SETUP_PARAMETER_OPTION_AGELEVEL")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<? $agelevel=array("none"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_AGELEVEL_NON"),
							"0"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_AGELEVEL_0"),
							"6"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_AGELEVEL_6"),
							"12"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_AGELEVEL_12"),
							"16"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_AGELEVEL_16"),
							"18"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_AGELEVEL_18")
							);
						?>
			<select name="AGELEVEL">
			<?foreach($agelevel as $code=>$val)
			{?>
				<option value="<?=$code?>" <?if ($code==$acrit_AGELEVEL) echo "selected"?>><?=$val?></option>
			<?}?>
			</select>
		</td>
	</tr>
	<?$arGroups = '';
		if($iCatalog)
		{
			$dbRes = CCatalogGroup::GetGroupsList(array());
			while ($arRes = $dbRes->Fetch())
			{
				if ($arRes['BUY'] == 'Y')
					$arGroups[] = $arRes['CATALOG_GROUP_ID'];
			}?>
			<tr>
				<td width="40%" class="adm-detail-content-cell-l"><?=GetMessage('ACRIT_PRICE_TYPE');?>: </td>
				<td width="40%" class="adm-detail-content-cell-r">
					<br/><select name="PRICE">
						<option value=""<? echo ($acrit_PRICE == "" || $acrit_PRICE == 0 ? ' selected' : '');?>><?=GetMessage('ACRIT_PRICE_TYPE_NONE');?></option>
						<?$dbRes = CCatalogGroup::GetList(array('SORT' => 'ASC'), array('ACTIVE' => 'Y', 'ID' => $arGroups), 0, 0, array('ID', 'NAME', 'BASE'));
						while ($arRes = $dbRes->GetNext())
						{?>
							<option value="<?=$arRes['ID']?>"<? echo ($acrit_PRICE == $arRes['ID'] ? ' selected' : '');?>><?='['.$arRes['ID'].'] '.$arRes['NAME'];?></option>
						<?}?>
					</select><br /><br />
				</td>
			</tr>
		<?}else{?>
		<tr>
				<td colspan="2"><?=GetMessage('ACRIT_CATALOG_NOT_INSTALL');?></td>
		</tr>
		<?}?>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="FORORDER"><?=GetMessage("ACRIT_GENERAL_PARAMETER_FORORDER")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="checkbox" size="30" name="FORORDER" value="Y" <?if($acrit_FORORDER == "Y") echo "checked";?>/>
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="CONDITION"><?=GetMessage("ACRIT_SETUP_PARAMETER_OPTION_CONDITION")?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<? $namesku=array("new"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_CONDITION_NEW"),
							"refurbished"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_CONDITION_REFURBISHED"),
							"used"=>GetMessage("ACRIT_SETUP_PARAMETER_OPTION_CONDITION_USED"),
							);?>
			<select name="CONDITIONS">
			<?foreach($namesku as $code=>$val)
			{?>
				<option value="<?=$code?>" <?if ($code==$acrit_CONDITIONS) echo "selected"?>><?=$val?></option>
			<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="YMLTYPE"><?=GetMessage("ACRIT_SETUP_PARAMETER_OPTION_YMLTYPE")?>:</label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="hidden" name="YMLTYPE" value="gm"/>
			<b><?=GetMessage('ACRIT_GOOGLE_MERCHANTS')?></b>
		</td>
	</tr>
	<tr class="heading">
		<td colspan="2" valign="top"><?=GetMessage("ACRIT_SETUP_PARAMETER_OPTION")?></td>
	</tr>
		<?$xml=unserialize(base64_decode($acrit_XML_DATA));?>
	<tr>
		<td colspan="2">
			<div id="config_param" style="padding: 10px auto; text-align: center;">
				<table  width="100%" class="inner" id="ACRIT_params_tbl" align="center">
					<thead>
						<tr>
							<td style="width:50%;text-align: right;padding-right:15px"><?=GetMessage("ACRIT_SETUP_PARAMETER_OPTION_XML")?></td>
							<td style="width:50%;text-align: left;padding-left:105px"><?=GetMessage("ACRIT_SETUP_PARAMETER_OPTION_XML_NAME")?></td>
						</tr>
					</thead>
					<tbody id="xmld">
						<tr id="ACRIT_params_tbl_0">
							<td id="cl1" style="text-align:right"></td>
							<td id="cl2" style="text-align:left"></td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="PARAMS_COUNT" id="PARAMS_COUNT" value="<?=count($xml)?>">
				<div style="width: 100%; text-align: center;"><input type="button" onclick="__addYP(); return false;" id="more" name="ACRIT_params_add" value="<?=GetMessage("ACRIT_SETUP_PARAMETER_OPTION_MORE")?>"></div>
			</div>
		</td>
	</tr>
	<?
	$tabControl->BeginNextTab();?>
		<tr class="heading">
		<td colspan="2" valign="top"><?=GetMessage("ACRIT_SETUP_PARAMETER_GOOGLE_CATEGORY")?></td>
	</tr>
		<?$googlecat=unserialize(base64_decode($acrit_GOOGLE_CATEGORY));?>

	<tr>
		<td colspan="2">
			<div id="google_category" style="padding: 10px auto; text-align: center;">
				<table  width="100%" class="inner" id="ACRIT_googlecategory_tbl" align="center">
					<thead>
						<tr>
							<td style="width:50%;text-align: right;padding-right:15px"><?=GetMessage("ACRIT_SETUP_PARAMETER_GOOGLE_CATEGORY_THIS")?></td>
							<td style="width:50%;text-align: left;padding-left:105px"><?=GetMessage("ACRIT_SETUP_PARAMETER_GOOGLE_CATEGORY_GOOGLE")?></td>
						</tr>
					</thead>
					<tbody id="ACRIT_googlecategory_tbl_body">
					<?if(is_array($googlecat) && sizeof($googlecat)>0){
							foreach($googlecat as $id=>$val)
							{?>
								<tr id="ACRIT_googlecategory_tbl_<?=$id?>">
								<td style="text-align:right"><input type="hidden" name="GOOGLE_CATEGORY[<?=$id?>][THIS]" value="<?=$id?>"/><span style="text-align:right"><?=$val['THIS']?></span></td>
								<td style="text-align:left"><? GetGoogleCategory('GOOGLE_CATEGORY['.$id.'][GOOGLE]',trim($val['GOOGLE']),$val['THIS'])?></td>
							</tr>
						<?}}?>
						</tbody>
					</table>
			</div>
		</td>
	</tr>
	<script>
		function SetGoogleCategory(sel,txt)
		{
            str='<?GetGoogleCategory("GOOGLE_CATEGORY[#ID#][GOOGLE]","","")?>';
            var NewRow;
			var tbl=BX("ACRIT_googlecategory_tbl_body");
			for(var i = document.getElementById("ACRIT_googlecategory_tbl_body").rows.length; i > 0;i--)
			{
				document.getElementById("ACRIT_googlecategory_tbl_body").deleteRow(i -1);
			}
			if(sel.length>0)
			{
				for(var i=0; i<sel.length; i++) 
				{
					var id='ACRIT_googlecategory_tbl_'+sel[i];
					if(BX(id)===null)
					{	
						newRow =tbl.insertRow(tbl.rows.length);
						newRow.id=id;
					}
					else 
					{
						newRow=BX(id);
					}
					str=str.replace(new RegExp('#ID#','g'),sel[i]);
					content="<td><input type='hidden' name='GOOGLE_CATEGORY["+sel[i]+"][THIS]' value='"+sel[i]+"'/><span>"+txt[i]+"</span></td><td>"+str+"</td>";
					newRow.innerHTML=content;
				}
			}
			
		}
	</script>
	<?$tabControl->BeginNextTab();?>
	<tr class="heading">
		<td colspan="2" valign="top"><?=GetMessage('ACRIT_CONDITION');?></td>
	</tr>
	<tr>
	<?
		 $logic="<select name=\'CONDITION_RULE\[XX\]\[LOGIC\]\'><option value=\'\'>".GetMessage("ACRIT_LOGIC_NOT")."</option><option value=\'and\'>".GetMessage("ACRIT_LOGIC_AND")."</option><option value=\'or\'>".GetMessage("ACRIT_LOGIC_OR")."</option></select>";
		 $rule="<select name=\'CONDITION_RULE\[XX\]\[RULES\]\'><option value=\'\'>".GetMessage("ACRIT_LOGIC_NOT")."</option><option value=\'equal\'>".GetMessage("ACRIT_RULE_EQUAL")."</option><option value=\'not\'>".GetMessage("ACRIT_RULE_NOT")."</option><option value=\'great\'>".GetMessage("ACRIT_RULE_GREAT")."</option><option value=\'less\'>".GetMessage("ACRIT_RULE_LESS")."</option><option value=\'eqgr\'>".GetMessage("ACRIT_RULE_EQGR")."</option><option value=\'eqls\'>".GetMessage("ACRIT_RULE_EQLS")."</option></select>";
		?>
		<td colspan="2" align="center">
					<div class="adm-info-message">
			<?=GetMessage("ACRIT_GENERAL_PARAMETER_RULES_MESSAGE")?></div>
		 <?php $cond=unserialize(base64_decode($acrit_CONDITION_RULE)); ?>
			<div id="config_param" style="padding: 10px auto;align: center;">
				<table  class="inner" id="condition" align="center">
					<tbody id="cond">
						<tr id="condition_tbl_0">
							<td id="cl1"></td>
							<td id="cl2"></td>
							<td id="cl3"></td>
							<td id="cl4"></td>
							<td id="cl5"></td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="CONDITION_RULE[COUNT]" id="CONDITION_COUNT" value="<?=count($cond)-1?>">
				<div style="width: 100%; text-align: center;"><input type="button" onclick="addcond('<?=$logic?>','<?=$rule?>'); return false;" id="cond_more" name="add_cond" value="<?=GetMessage('ACRIT_CONDITION_ADD');?>"></div>
			</div>
		</td>
	</tr>
	<?$tabControl->BeginNextTab();?>
	<tr class="heading">
		<td colspan="2" valign="top"><?=GetMessage('ACRIT_RUN_EXPORT');?></td>
	</tr>
	<tr>
		<td width="40%" class="adm-detail-content-cell-l">
			<label for="USE_XML_FILE"><?=GetMessage('ACRIT_GOOGLEMERCHANT_IN_FILE');?></label>
		</td>
		<td width="60%" class="adm-detail-content-cell-r">
			<input type="checkbox" size="30" name="USE_XML_FILE" value="Y" <?if($acrit_USE_XML_FILE=="Y") echo 'checked';?>>
		</td>
	</tr>
	<tr id="file_setting">
        <td colspan="2" align="center">
            <table cellpadding="0" cellspacing="0" width="100%">
        	    <tr>
			        <td width="40%" class="adm-detail-content-cell-l"><?=GetMessage('ACRIT_GOOGLEMERCHANT_FILENAME');?></td>
			        <td width="60%" class="adm-detail-content-cell-r">
				        <input type="text" id="URL_DATA_FILE" name="URL_DATA_FILE" size="30" value="<?=htmlspecialcharsbx($acrit_URL_DATA_FILE)?>">
				        <input type="button" value="<?=GetMessage('ACRIT_GOOGLEMERCHANT_DIALOG_FILENAME');?>" OnClick="BtnClick()">
				        <?
				            CAdminFileDialog::ShowScript
				            (
					            Array("event" => "BtnClick",
						                "arResultDest" => array("FORM_NAME" => "post_form", "FORM_ELEMENT_NAME" => "URL_DATA_FILE"),
						                "arPath" => array("SITE" => SITE_ID, "PATH" =>"/upload"),
						                "select" => 'F',// F - file only, D - folder only
						                "operation" => 'S',// O - open, S - save
						                "showUploadTab" => true,
						                "showAddToMenuTab" => false,
						                "fileFilter" => 'xml',
						                "allowAllFiles" => true,
						                "SaveConfig" => true,
					            )
				            );
				        ?>
			        </td>
	            </tr>
		        <tr>
			        <td width="40%" class="adm-detail-content-cell-l">
				        <label for="TYPE_RUN"><?=GetMessage('ACRIT_GOOGLEMERCHANT_TYPE_RUN');?></label>
			        </td>
			        <td width="60%" class="adm-detail-content-cell-r">
				        <input type="radio" size="30" name="TYPE_RUN" <?if($acrit_TYPE_RUN=="comp") echo "checked='true'"?> value="comp"><?=GetMessage('ACRIT_GOOGLEMERCHANT_TYPE_COMPONENT');?>
						<a href="http://<?=$acrit_DOMAIN_NAME?>/<?=COption::GetOptionString("acrit.googlemerchant","comp_path")?>/<?=$ID?>" target="_blank"><?=GetMessage("ACRIT_GENERAL_OPEN_COMP")?></a>
						<br/>
				        <input type="radio" size="30" name="TYPE_RUN" <?if($acrit_TYPE_RUN=="agent") echo "checked='true'"?> value="agent"><?=GetMessage('ACRIT_GOOGLEMERCHANT_TYPE_AGENT');?><br/>
				        <input type="radio" size="30" name="TYPE_RUN" <?if($acrit_TYPE_RUN=="cron") echo "checked='true'"?> value="cron"><?=GetMessage('ACRIT_GOOGLEMERCHANT_TYPE_CRON');?><br/>
			        </td>
		        </tr>
		        <tr>
		           <td width="40%" class="adm-detail-content-cell-l" style="vertical-align:middle">
				        <label for="DAT_START"><?=GetMessage('ACRIT_GOOGLEMERCHANT_DATE_START_END');?></label><br/>
			        </td>
			        <td width="60%" class="adm-detail-content-cell-r">
                        <?php if($ID) $acrit_DATA_START=date("d.m.Y H:i:s",$acrit_DATA_START);
							else $acrit_DATA_START=date("d.m.Y H:i:s",time());
						?>
				        <?echo CalendarDate("DATA_START", $acrit_DATA_START, "post_form", "15");?>
        			</td>
        		</tr>
        		<tr>
        			<td width="40%" class="adm-detail-content-cell-l">
        				<label for="PERIOD"><?=GetMessage("ACRIT_GOOGLEMERCHANT_PERIOD");?></label>
        			</td>
        			<td width="60%" class="adm-detail-content-cell-r">
        				<input type="text" size="30" name="PERIOD" value="<?=$acrit_PERIOD?>"/>
        			</td>
		        </tr>
            </table>
        </td>
	</tr>
<?php $tabControl->Buttons(
    array(
        "disabled"=>($POST_RIGHT<"W"),
        "back_url"=>"acrit_googlemerchant_list.php?lang=".LANG,
    )
);
echo bitrix_sessid_post();?>
<input type="hidden" name="lang" value="<?=LANG?>">
<?php if($ID>0 && !$bCopy):?>
    <input type="hidden" name="ID" value="<?=$ID?>">
<?php endif;
$tabControl->End();
$tabControl->ShowWarnings("post_form", $message);
?>
</form>
<script>
BX.ready(function()
{
   $(".chosen-select").chosen({width: "95%"}); 
  	ymlch('gm');
});
function checkSKU(val)
	{
		ymlch('gm');
		var sku;
		if(val==true) sku="Y";else if(val==false) sku="N";
		var ib=BX("IBLOCK_ID");
		var ms=getSelectedIndexes (ib);
		if(ms.length==0) 
		{
			BX("sku").checked=!val;
		}
		else
		{
			<?if($ID>0)
			{?>
				SetXMLDATA(ms,sku,'<?=$acrit_XML_DATA?>');
				SetCONDDATA(ms,sku,'<?=$acrit_CONDITION_RULE?>');
			<?}else{?>
				SetXMLDATA(ms,sku,'');
				SetCONDDATA(ms,sku,'');
			<?}?>

		SetProp(ms,sku);
		}
		
		
	};
function ymlch(val)
{
	<?if($ID>0){?>
		YMLChange(val,'gm','<?=$acrit_IBLOCK_ID?>','<?=$acrit_USE_SKU?>','<?=$acrit_XML_DATA?>');
	<?}else{?>
		var id=getSelectedIndexes(BX('IBLOCK_ID'));
		var sku=BX('sku').checked;
		if(sku==true) sku="Y";else sky="N";
		YMLChange(val,'',id,sku,'');
	<?}?>
}
var id=getSelectedIndexes(BX('IBLOCK_ID'));
<?if($ID>0){?>
	<?if($acrit_USE_SKU=="Y") $sk=true; else $sk=false;?>
	checkSKU('<?=$sk?>');
	SetXMLDATA('<?=$acrit_IBLOCK_ID?>','<?=$acrit_USE_SKU?>','<?=$acrit_XML_DATA?>');
	SetCONDDATA('<?=$acrit_IBLOCK_ID?>','<?=$acrit_USE_SKU?>','<?=$acrit_CONDITION_RULE?>');
<?}else{?>
	var sku=BX('sku').checked;
	if(sku==true) sku="Y";else sky="N";
	SetXMLDATA(id,sku,'');
	SetCONDDATA(id,sku,'');
<?}?>
</script>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>