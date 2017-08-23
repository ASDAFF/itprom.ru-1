<?
IncludeModuleLangFile( __FILE__ );

$arEncodings = array(
    "cp1251" => "cp1251",
    "utf8" => "utf8"
);
                  
$activeChecked = ( $arProfile["ACTIVE"] == "Y" ) ? 'checked="checked"' : "";
$profileDefaults = $obProfileUtils->GetDefaults( $arProfile["IBLOCK_ID"], true );

$dbProcessProfiles = $obProfile->GetProcessList(
    array(
        $by => $order
    ),
    array()
);

$arActualProfileNames = array();
while( $arProcessProfile = $dbProcessProfiles->Fetch() ){
    $arActualProfileNames[] = $arProcessProfile["NAME"];
}

if( !in_array( $arProfile["TYPE"], $arActualProfileNames ) ){
    $profileDefaults["PROFILE_CODE"] = $arProfile["TYPE"];
}
else{
    $bCorrentProfileName = false;
    $iProfileNameIndex = 1;
    while( !$bCorrentProfileName ){
        if( !in_array( $arProfile["TYPE"].$iProfileNameIndex, $arActualProfileNames ) ){
            $profileDefaults["PROFILE_CODE"] = $arProfile["TYPE"].$iProfileNameIndex;
            $bCorrentProfileName = true;
        }
        $iProfileNameIndex++;
    }
}    

$bViewCatalogOnly = $arProfile["VIEW_CATALOG"] == "Y" ? 'checked="checked"' : "";
$bShowSubsection = $arProfile["CHECK_INCLUDE"] == "Y" ? 'checked="checked"' : "";
$bUseSKU = $arProfile["USE_SKU"] == "Y" ? 'checked="checked"' : "";
$bUseIblockCategory = $arProfile["USE_IBLOCK_CATEGORY"] == "Y" ? 'checked="checked"' : "";
$bUseIblockProductCategory = $arProfile["USE_IBLOCK_PRODUCT_CATEGORY"] == "Y" ? 'checked="checked"' : "";
?>

<tr class="heading" align="center">
    <td colspan="2"><b><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_GENERAL" )?></b></td>
</tr>
<tr>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l">
            <span id="hint_PROFILE[ACTIVE]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[ACTIVE]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_ACTIVE_HELP" )?>' );</script>
            <label for="PROFILE[ACTIVE]"><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_ACTIVE" )?></label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="checkbox" name="PROFILE[ACTIVE]" <?=$activeChecked?> value="Y" />
            <i><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_ACTIVE_DESC" )?></i>
        </td>
    </tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[NAME]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[NAME]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_NAME_HELP" )?>' );</script>
        <label for="PROFILE[NAME]"><b><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_NAME" )?></b></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r" id="profile_name">
        <input type="text" size="30" name="PROFILE[NAME]" value="<?=( ( strlen( trim( htmlspecialcharsbx( $arProfile["NAME"] ) ) ) > 0 ) ? htmlspecialcharsbx( $arProfile["NAME"] ) : $profileDefaults["PROFILE_CODE"] );?>"/>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[CODE]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[CODE]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_CODE_HELP" )?>' );</script>
        <label for="PROFILE[CODE]"><b><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_CODE" )?></b> </label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r" id="profile_code">
        <input type="text" size="30" name="PROFILE[CODE]" value="<?=( ( strlen( trim( htmlspecialcharsbx( $arProfile["CODE"] ) ) ) > 0 ) ? htmlspecialcharsbx( $arProfile["CODE"] ) : $profileDefaults["PROFILE_CODE"] );?>"/>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[DESCRIPTION]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[DESCRIPTION]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_DESCRIPTION_HELP" )?>' );</script>
        <label for="PROFILE[DESCRIPTION]"><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_DESCRIPTION" )?></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <textarea id="PROFILE[DESCRIPTION]" rows="5" cols="23" name="PROFILE[DESCRIPTION]"><?=( ( strlen( trim( $arProfile["DESCRIPTION"] ) ) > 0 ) ? htmlspecialcharsbx( $arProfile["DESCRIPTION"] ) : $profileDefaults["SITE_NAME"] );?></textarea>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[SHOPNAME]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[SHOPNAME]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_SHOPNAME_HELP" )?>' );</script>
        <label for="PROFILE[SHOPNAME]"><b><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_SHOPNAME" )?></b></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input id="PROFILE[SHOPNAME]" type="text" size="30" name="PROFILE[SHOPNAME]" value="<?=( ( strlen( trim( $arProfile["SHOPNAME"] ) ) > 0 ) ? htmlspecialcharsbx( $arProfile["SHOPNAME"] ) : $profileDefaults["SITE_NAME"] );?>"/>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[COMPANY]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[COMPANY]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_COMPANY_HELP" )?>' );</script>
        <label for="PROFILE[COMPANY]"><b><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_COMPANY" )?></b></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input id="PROFILE[COMPANY]" type="text" size="30" name="PROFILE[COMPANY]" value="<?=( ( strlen( trim( $arProfile["COMPANY"] ) ) > 0 ) ? htmlspecialcharsbx( $arProfile["COMPANY"] ) : $profileDefaults["SITE_NAME"] );?>"/>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[DOMAIN_NAME]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[DOMAIN_NAME]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_DOMAIN_NAME_HELP" )?>' );</script>
        <label for="PROFILE[DOMAIN_NAME]"><b><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_DOMAIN_NAME" )?></b></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input id="PROFILE[DOMAIN_NAME]" type="text" size="30" name="PROFILE[DOMAIN_NAME]" value="<?=( ( strlen( trim( $arProfile["DOMAIN_NAME"] ) ) > 0 ) ? $arProfile["DOMAIN_NAME"] : $profileDefaults["DOMAIN_NAME"] );?>"/>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[LID]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[LID]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_SITE_HELP" )?>' );</script>
        <label for="PROFILE[LID]"><b><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_SITE" )?></b></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r"><?=CLang::SelectBox( "PROFILE[LID]", $arProfile["LID"], "", "" )?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[ENCODING]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[ENCODING]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_ENCODING_HELP" )?>' );</script>
        <label for="PROFILE[ENCODING]"><b><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_ENCODING" )?></b></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <select name="PROFILE[ENCODING]">
            <?foreach( $arEncodings as $encodingCode => $encodingValue ){?>
                <?$selectedEncoding = ( $arProfile["ENCODING"] == $encodingCode ) ? "selected" : "";?>
                <option value="<?=$encodingCode?>" <?=$selectedEncoding?>><?=$encodingValue?></option>
            <?}?>
        </select>
    </td>
</tr>
<tr class="heading" align="center">
    <td colspan="2"><b><?=GetMessage( "ACRIT_EXPORTPRO_IBLOCK_SECTION_SHOW" )?></b></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[VIEW_CATALOG]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[VIEW_CATALOG]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_ONLY_CATALOG_HELP" )?>' );</script>
        <label for="PROFILE[VIEW_CATALOG]"><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_ONLY_CATALOG" )?></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input type="checkbox" name="PROFILE[VIEW_CATALOG]" <?=$bViewCatalogOnly?> value="Y" />
        <i><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_ONLY_CATALOG_DESC" )?></i>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[CHECK_INCLUDE]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[CHECK_INCLUDE]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_CHECK_INCLUDE_HELP" )?>' );</script>
        <label for="PROFILE[CHECK_INCLUDE]"><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_CHECK_INCLUDE" )?></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input type="checkbox" name="PROFILE[CHECK_INCLUDE]" <?=$bShowSubsection?> value="Y" />
        <i><?=GetMessage( "ACRIT_EP1_CHECK_INCLUDE_DESC" )?></i>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[USE_SKU]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[USE_SKU]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_USE_SKU_HELP" )?>' );</script>
        <label for="PROFILE[USE_SKU]"><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_USE_SKU" )?></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input type="checkbox" name="PROFILE[USE_SKU]" <?=$bUseSKU?> value="Y" />
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[USE_IBLOCK_CATEGORY]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[USE_IBLOCK_CATEGORY]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_USE_IBLOCK_CATEGORY_HELP" )?>' );</script>
        <label for="PROFILE[USE_IBLOCK_CATEGORY]"><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_USE_IBLOCK_CATEGORY" )?></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input type="checkbox" name="PROFILE[USE_IBLOCK_CATEGORY]" <?=$bUseIblockCategory?> value="Y" />
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[USE_IBLOCK_PRODUCT_CATEGORY]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[USE_IBLOCK_PRODUCT_CATEGORY]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_STEP1_USE_IBLOCK_PRODUCT_CATEGORY_HELP" )?>' );</script>
        <label for="PROFILE[USE_IBLOCK_PRODUCT_CATEGORY]"><?=GetMessage( "ACRIT_EXPORTPRO_STEP1_USE_IBLOCK_PRODUCT_CATEGORY" )?></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input type="checkbox" name="PROFILE[USE_IBLOCK_PRODUCT_CATEGORY]" <?=$bUseIblockProductCategory?> value="Y" />
    </td>
</tr>
<tr class="heading" align="center">
    <td colspan="2"><b><?=GetMessage( "ACRIT_EXPORTPRO_IBLOCK_SELECT" )?></b></td>
</tr>
<tr id="tr_iblock_showtype">
    <td width="40%" class="adm-detail-content-cell-l">
        <span id="hint_PROFILE[SETUP][IBLOCK_SHOWTYPE]"></span><script type="text/javascript">BX.hint_replace( BX( 'hint_PROFILE[SETUP][IBLOCK_SHOWTYPE]' ), '<?=GetMessage( "ACRIT_EXPORTPRO_IBLOCK_SHOWTYPE_HELP" )?>' );</script>
        <label for="PROFILE[SETUP][IBLOCK_SHOWTYPE]"><?=GetMessage( "ACRIT_EXPORTPRO_IBLOCK_SHOWTYPE" )?></label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <?foreach( $obProfileUtils->GetIblockShowType() as $type ){
            $checked = ( !empty( $arProfile["SETUP"]["IBLOCK_SHOWTYPE"] ) ) ? ( ( $type == $arProfile["SETUP"]["IBLOCK_SHOWTYPE"] ) ? 'checked="checked"' : "" ) : ( ( $type == "hierarchical" ) ? 'checked="checked"' : "" )?>
            <input type="radio" name="PROFILE[SETUP][IBLOCK_SHOWTYPE]" value="<?=$type?>" <?=$checked?> onchange="ChangeIblockShowType( this.value )"><?=GetMessage( "ACRIT_EXPORTPRO_IBLOCK_SHOWTYPE_".strtoupper( $type ) )?>
        <?}?>
    </td>
</tr>
<tr id="tr_iblock_data">
    <td colspan="2">
        <?$categories = $obProfileUtils->GetSections(
            $arProfile["IBLOCK_ID"],
            $arProfile["CHECK_INCLUDE"] == "Y"
        );?>
        <?if( $arProfile["SETUP"]["IBLOCK_SHOWTYPE"] == "tree" ){?>
            <?$arIblockTreeList = $obProfileUtils->GetIBlockTreeShowType(
                $arProfile["LID"],
                $arProfile["VIEW_CATALOG"] == "Y",
                false,
                $arProfile["CHECK_INCLUDE"] == "Y"
            );
            ?>
            
            <p id="select_iblock_tree">
                <?if( !empty( $arIblockTreeList ) ){?>
                    <select multiple="multiple" name="PROFILE[SETUP][IBLOCK_TREE][]" class="category_select">
                        <?foreach( $arIblockTreeList as $iblockTypeIndex => $arIblockTypeData ){
                            $selectedIblockType = "";
                            if( in_array( $iblockTypeIndex, $arProfile["IBLOCK_TYPE_ID"] ) ){
                                $selectedIblockType = 'selected="selected"';
                            }?>
                            <option value="ibtype:<?=$iblockTypeIndex?>" <?=$selectedIblockType?>><?=$arIblockTypeData["NAME"]?></option>
                            
                            <?foreach( $arIblockTypeData["IBLOCK"] as $iblockIndex => $arIblockData ){
                                $selectedIblock = "";
                                if( in_array( $iblockIndex, $arProfile["IBLOCK_ID"] ) ){
                                    $selectedIblock = 'selected="selected"';
                                }?>
                                <option value="ib:<?=$iblockIndex?>" <?=$selectedIblock?>>&nbsp;&nbsp;.&nbsp;&nbsp;<?=$arIblockData["NAME"]?></option>

                                <?$arProcessSectionList = array();
                                foreach( $arIblockData["SECTIONS"] as $arSectionDepth ){
                                    foreach( $arSectionDepth as $sectionIndex => $arSectionData ){
                                        $arProcessSectionList[$sectionIndex] = $arSectionData; 
                                    }
                                }

                                asort( $arProcessSectionList );

                                foreach( $arProcessSectionList as $sectionIndex => $arSectionData ){
                                    $selectedSection = "";
                                    if( in_array( $sectionIndex, $arProfile["CATEGORY"] ) ){
                                        $selectedSection = 'selected="selected"';                                                                                              
                                    }?>

                                    <option value="section:<?=$sectionIndex?>" <?=$selectedSection?>>&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;<?=$arSectionData["NAME"]?></option>     
                                <?}   
                            }
                        }?>
                    </select>
                <?}?>
            </p>
        <?}
        else{?>
            <?$ibtypes = $obProfileUtils->GetIBlockTypes(
                $arProfile["LID"],
                $arProfile["VIEW_CATALOG"] == "Y",
                false
            );?>
            <p id="ibtype_select_block">
                <select multiple="multiple" name="PROFILE[IBLOCK_TYPE_ID][]">
                    <?foreach( $ibtypes as $id => $type ){
                        $selected = "";
                        if( is_array( $arProfile["IBLOCK_TYPE_ID"] ) )
                            if( in_array( $id, $arProfile["IBLOCK_TYPE_ID"] ) )
                                $selected = 'selected="selected"';?>
                        <option value="<?=$id?>" <?=$selected?>><?=$type["NAME"]?></option>
                    <?}?>
                </select>
            </p>
            <p id="iblock_select_block">
                <select multiple="multiple" name="PROFILE[IBLOCK_ID][]">
                    <?$iblocks = array();
                    if( $bUseIblockProductCategory ){
                        $productIbCategories = array();
                    }
            
                    foreach( $ibtypes as $type ){
                        if( is_array( $type["IBLOCK"] ) ){
                            foreach( $type["IBLOCK"] as $id => $iblock ){
                                $iblocks[] = array(
                                    "ID" => $id,
                                    "NAME" => $iblock
                                );
                                if( CModule::IncludeModule( "catalog" ) ){
                                    $arProductCatalog = CCatalog::GetByIDExt( $id );
                                
                                    if( $bUseIblockProductCategory && ( intval( $arProductCatalog["PRODUCT_IBLOCK_ID"] ) > 0 ) && !$arProductCatalog["OFFERS_IBLOCK_ID"] ){
                                        $productIbCategories = $obProfileUtils->GetSections(
                                            array( $arProductCatalog["PRODUCT_IBLOCK_ID"] ),
                                            $arProfile["CHECK_INCLUDE"] == "Y"
                                        );
                                    }
                                }
                                $selected = "";
                                if( is_array( $arProfile["IBLOCK_ID"] ) )
                                    if( in_array( $id, $arProfile["IBLOCK_ID"] ) )
                                        $selected = 'selected="selected"';?>
                                
                                <option value="<?=$id?>" <?=$selected?>><?=$iblock?></option>
                            <?}
                        }
                    }?>
                </select>
            </p>
            <p id="section_select_block">
                <?if( !empty( $categories ) ){?>
                    <select multiple="multiple" name="PROFILE[CATEGORY][]" class="category_select">
                        <?$sect = array();
                        foreach( $categories as $depth )
                            foreach( $depth as $id => $section )
                                $sect[$id] = $section;
                        
                        asort( $sect );
                        
                        foreach( $sect as $id => $section ){
                            $selected = "";
                            if( is_array( $arProfile["CATEGORY"] ) )
                                if( in_array( $id, $arProfile["CATEGORY"] ) )
                                    $selected = 'selected="selected"';?>
                            
                            <option value="<?=$id?>" <?=$selected?>><?=$section["NAME"]?></option>
                        <?}?>
                    </select>
                <?}?>
            </p>
        <?}?>
    </td>
</tr>