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
<?CJSCore::Init(array("fx"));?>
<!--h 2><?= GetMessage("CT_BCSF_FILTER_TITLE")?></h 2-->
<form name="<?= $arResult["FILTER_NAME"]."_form"?>" action="<?= $arResult["FORM_ACTION"]?>" method="get" class="smartfilter choise-form">
  <fieldset>
  <?foreach($arResult["HIDDEN"] as $arItem):?>
    <input type="hidden" name="<?= $arItem["CONTROL_NAME"]?>"	id="<?= $arItem["CONTROL_ID"]?>" value="<?= $arItem["HTML_VALUE"]?>"/>
  <?endforeach;?>
  <?foreach($arResult["ITEMS"] as $key=>$arItem):
      $key = md5($key);
      ?>
      <?if(isset($arItem["PRICE"])):?>
        <?
        if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
          continue;
        $arItem["VALUES"]["MIN"]["VALUE"] = round($arItem["VALUES"]["MIN"]["VALUE"]);
        $arItem["VALUES"]["MAX"]["VALUE"] = round($arItem["VALUES"]["MAX"]["VALUE"]);
        if(isset($_GET[$arItem["VALUES"]["MIN"]["CONTROL_NAME"]])) $curMin = $_GET[$arItem["VALUES"]["MIN"]["CONTROL_NAME"]];
        else $curMin = $arItem["VALUES"]["MIN"]["VALUE"];
        if(isset($_GET[$arItem["VALUES"]["MAX"]["CONTROL_NAME"]])) $curMax = $_GET[$arItem["VALUES"]["MAX"]["CONTROL_NAME"]];
        else $curMax = $arItem["VALUES"]["MAX"]["VALUE"];
        ?>
        <div class="slider-holder">
          <div class="slide-text">
            <span class="title"><?=$arItem["NAME"]?></span>
            <span class="num-hold"><?=GetMessage("CT_BCSF_FILTER_FROM")?> 
              <span id="from" class="num">
                <input class="min-price" type="text" name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                       id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"	value="<?= $curMin?>" size="5" onchange="smartFilter.keyup(this);"/>
              </span> 
              <span class="text"><?=GetMessage("CT_BCSF_FILTER_TO")?> </span>
              <span id="to" class="num">
                <input class="max-price" type="text" name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                  id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"	value="<?= $curMax?>"	size="5" onchange="smartFilter.keyup(this);"/>
              </span>
              <span class="rouble">⃏</span>
            </span>
          </div>
          <div id="slider"></div>
        </div>
        <script type="text/javascript">
          $(function(){
            $('#slider').slider({
              range:true,
              values: [<?=$curMin?>, <?= $curMax?>],
              min: <?= $arItem["VALUES"]["MIN"]["VALUE"]?>,
              max: <?= $arItem["VALUES"]["MAX"]["VALUE"]?>,
              step:100,
              slide: function(event, ui) {
                $('#<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>').val(ui.values[0]);
                $('#<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>').val(ui.values[1]);
              },
              stop: function(event, ui){
                $('#<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>').val(ui.values[0]);
                $('#<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>').val(ui.values[1]);
                $('.min-price').trigger("change");
              }
            });
          });
        </script>
      <?endif?>
    <?endforeach?>
    <?foreach($arResult["ITEMS"] as $key=>$arItem):
      if($arItem["PROPERTY_TYPE"] == "N" ):?>
        <?
        
        if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
          continue;
        if(isset($_GET[$arItem["VALUES"]["MIN"]["CONTROL_NAME"]])) $curMin = $_GET[$arItem["VALUES"]["MIN"]["CONTROL_NAME"]];
        else $curMin = $arItem["VALUES"]["MIN"]["VALUE"];
        if(isset($_GET[$arItem["VALUES"]["MAX"]["CONTROL_NAME"]])) $curMax = $_GET[$arItem["VALUES"]["MAX"]["CONTROL_NAME"]];
        else $curMax = $arItem["VALUES"]["MAX"]["VALUE"];
        ?>
        <div class="slider-holder elem-hold-<?=$key?>">
          <div class="slide-text">
            <span class="title"><?=$arItem["NAME"]?></span>
			  <span class="num-hold"><span class="text"><?=GetMessage("CT_BCSF_FILTER_FROM")?></span>
              <span id="from" class="num">
                <input class="min-value" type="text" name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                       id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"	value="<?= $curMin?>" size="5" onchange="smartFilter.keyup(this);"/>
              </span>
              <span class="text"><?=GetMessage("CT_BCSF_FILTER_TO")?></span>
              <span id="to" class="num">
                <input class="max-value" type="text" name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                  id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"	value="<?= $curMax?>"	size="5" onchange="smartFilter.keyup(this);"/>
              </span>
              <span class="text"><?=GetMessage("WF_MILLIMETERS")?></span>
            </span>
          </div>
          <div id="slider<?=$key?>"></div>
        </div>
        <script type="text/javascript">
          $(function(){
            $('#slider<?=$key?>').slider({
              range:true,
              values: [<?=$curMin?>, <?= $curMax?>],
              min: <?= $arItem["VALUES"]["MIN"]["VALUE"]?>,
              max: <?= $arItem["VALUES"]["MAX"]["VALUE"]?>,
              step:1,
              slide: function(event, ui) {
                $('#<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>').val(ui.values[0]);
                $('#<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>').val(ui.values[1]);
              },
              stop: function(event, ui){
                $('#<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>').val(ui.values[0]);
                $('#<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>').val(ui.values[1]);
                $('.elem-hold-<?=$key++?> .min-value').trigger("change");
              }
            });
          });
        </script>
      <?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>
      <div class="blck">
        <!--h 2 class="title-type03"><?=$arItem["NAME"]?></h 2-->
		<span class="title" style="font-size: 18px; font-weight: bold"><?=$arItem["NAME"]?></span>
        <div class="hold">
          <?
          $optCount = count($arItem["VALUES"]);
          $halved = $optCount/2;
          if(ceil($halved) != $halved) $halved = floor($halved);
          $j = 0;
          ?>
          <div class="col">
          <?foreach($arItem["VALUES"] as $val => $ar):?>
            <?if($j == $halved+1){?>
              </div><div class="col">
            <?}?>
            <div class="row <?= $ar["DISABLED"] ? 'disabled': ''?>">
              <input type="checkbox" class="checkbox"	value="<?= $ar["HTML_VALUE"]?>"	name="<?= $ar["CONTROL_NAME"]?>"
                id="<?= $ar["CONTROL_ID"]?>" <?= $ar["CHECKED"]? 'checked="checked"': ''?>	onclick="smartFilter.click(this)" <?= $ar["DISABLED"] ? 'disabled': ''?>/>
              <label for="<?= $ar["CONTROL_ID"]?>" title="<?= $ar["VALUE"];?>" class="hitro-label"><?= $ar["VALUE"];?></label>
            </div>
          <?$j++?>
          <?endforeach;?>
          </div>
        </div>
      </div>
      <?endif;?>
    <?endforeach;?>
  </fieldset>
  <div style="clear: both;"></div>
  <div class="bx_filter_control_section">
    <span class="icon"></span>
    <input class="bx_filter_search_button btn-input" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" style="width:120px;float:left;"/>
    <input class="bx_filter_search_button btn-input btn-input-gray" type="button" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" style="width:120px;float:left;margin-left:8px;"
           onclick="location.href='<?=$APPLICATION->GetCurDir()?>'"/>
    <div class="bx_filter_popup_result left" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
      <?= GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
      <span class="arrow"></span>
      <a href="<?= $arResult["FILTER_URL"]?>"><?= GetMessage("CT_BCSF_FILTER_SHOW")?></a>
    </div>
  </div>
</form>
<script>
	var smartFilter = new JCSmartFilter('<?= CUtil::JSEscape($arResult["FORM_ACTION"])?>');
</script>