<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if ($arParams['REQUEST_LOAD'] != 'Y'):?>
    <form action="" method="get" class="header-seacrh search-from relative">
        <button type="submit">
            <svg class="icon">
                <use xlink:href="#svg-icon-search"></use>
            </svg>
        </button>
        <input type="text" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" placeholder="<?=GetMessage('SEARCH_GO')?>">
        <input type="hidden" name="how" value="<?echo $arResult["REQUEST"]["HOW"]=="d"? "d": "r"?>" />
    </form>
<?endif;?>