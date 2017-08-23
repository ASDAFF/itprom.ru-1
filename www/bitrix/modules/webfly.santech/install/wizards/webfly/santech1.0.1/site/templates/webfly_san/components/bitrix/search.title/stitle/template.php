<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$inpId = trim($arParams["~INPUT_ID"]);
if(strlen($inpId) <= 0)	$inpId = "wft-search-input";
$inpId = CUtil::JSEscape($inpId);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "wft-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($this->__folder)
	$pathToTemplateFolder = $this->__folder ;
else
	$pathToTemplateFolder = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', dirname(__FILE__));

$preSearchPath = "{$pathToTemplateFolder}/result_modifier.php";
if($arParams["SHOW_INPUT"] !== "N"):?>
	<div id="<?=$CONTAINER_ID?>">
		<form action="<?=$preSearchPath?>" id="search_form" class="search-form">
			<input type="hidden" name="site_id" value="<?=SITE_ID;?>"/>
      <fieldset>
        <label><?=GetMessage("WF_SEARCH_WARES");?></label>
        <input type="button" class="btn-search s_submit" value="<?=GetMessage("WF_SEARCH");?>" onclick="$('#search_form').submit();"/>
        <div class="input-search-hold">
          <div class="input-search">
            <input type="text" class="txt" name="q" id="<?= $inpId?>" autocomplete="off"  value="<?= htmlspecialcharsbx($_REQUEST["q"])?>" placeholder="<?=GetMessage("WF_SEARCH_EXAMPLE");?>" />
          </div>
        </div>
			<?/*<input type="hidden" name="search_page" value="<?=$arResult["FORM_ACTION"];?>">*/?>
        <select id="search_select" name="search_category" style="display: none;">
          <?if( $arParams["NUM_CATEGORIES"] > 1):?>
            <option value='all'><?=GetMessage('CATEGORY_ALL');?></option>
          <?endif;?>
          <?for($i = 0; $i < $arParams["NUM_CATEGORIES"]; $i++):
            $category_title = trim($arParams["CATEGORY_".$i."_TITLE"]);
            if(empty($category_title)){
              if(is_array($arParams["CATEGORY_".$i]))
                $category_title = implode(", ", $arParams["CATEGORY_".$i]);
              else
                $category_title = trim($arParams["CATEGORY_".$i]);
            }
            if(empty($category_title))
              continue;
          ?>
            <option value='<?=$i;?>'><?=$category_title;?></option>
          <?endfor;?>
        </select>
      </fieldset>
      <input type="hidden" name="is_ajax_call" value="y"/>
      <input type="hidden" name="is_before" value="y"/>
		</form>
		<?if($arParams["EXAMPLE_ENABLE"] == "Y"):
			$list = $arParams["EXAMPLES"];
			if(!end($list))
				array_pop($list);
			$example = $list[array_rand($list)];
			if($example):?>
			<span class="example"><?=GetMessage('EXAMPLE');?><a href="javascript:void(0);"><?=$example;?></a></span>
		<?endif;endif;?>
	</div>
<?endif;?>
<script type="text/javascript">
var jsControl = new wfJTitleSearch({
	'AJAX_PAGE' : '<?=$preSearchPath?>',
	'CONTAINER_ID': '<?= $CONTAINER_ID?>',
	'INPUT_ID': '<?= $inpId?>',
	'MIN_QUERY_LEN': 2,
	'SITE_ID': '<?=SITE_ID;?>',
	'CLEAR_CACHE': '<?=$_REQUEST['clear_cache'];?>'
});
</script>
