<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);
?>
<form action="<?=SITE_DIR?>catalog/search/" method="get" class="search-from search-from-header relative">
    <button type="submit">
        <svg class="icon">
            <use xlink:href="#svg-icon-search"></use>
        </svg>
    </button>
    <input type="text" placeholder="<?=getMessage('SEARCH_STRING')?>" name="q" id="<?echo $INPUT_ID?>">
    <div class="dropdown-pane dropdown-custom" id="search-dropdown"></div>
</form>
<script>
    BX.ready(function(){
        var searchTitle = new JCTitleSearch({
            'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
            'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
            'INPUT_ID': '<?echo $INPUT_ID?>',
            'MIN_QUERY_LEN': 2
        });
        
        searchTitle.ShowResult = function(result)
        {
            if(result != null)
                $('#search-dropdown').html(result);

            if($('#search-dropdown').html() != '')
                $('#search-dropdown').addClass('is-open');
            else
                $('#search-dropdown').removeClass('is-open');
            
        };        
    });
</script>
