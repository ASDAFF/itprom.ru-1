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
<form action="<?=$arResult["FORM_ACTION"]?>" class="search-form">
  <fieldset>
    <label><?=GetMessage("WF_SEARCH_WARES");?></label>
    <input type="button" class="btn-search" value="<?=GetMessage("WF_SEARCH");?>"/>
    <div class="input-search-hold">
      <div class="input-search">
        <input type="text" placeholder="<?=GetMessage("WF_SEARCH_EXAMPLE");?>" name="q" value=""/>
      </div>
    </div>
  </fieldset>
</form>