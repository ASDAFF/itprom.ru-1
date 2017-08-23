<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?
$counts = 0;
//wfDump($arResult);
foreach($arResult as $index => $arItem){
  if($arItem["DEPTH_LEVEL"] == 1) $counts++;
}
$iter = 0;//<span class="tripple-point">&nbsp;</span>
?>
<ul id="nav">
  <?foreach($arResult as $index => $arItem):
    
    $sectionId = $arItem["ITEM_INDEX"];
    if($arItem["DEPTH_LEVEL"] != 1) continue;
    $iter++;
    if($iter >($counts/2 + 1)) $class = "left-drop";
    else $class = "";
    if($iter == $counts){
      $class .= " last-child";
      $text = '<span class="tripple-point">&nbsp;</span>';
    }else{
      $text = $arItem["TEXT"];
    }
    
    ?>
    <li class="<?=$class?>">
      <a href="<?=$arItem["LINK"]?>"><span><em><?=$text?></em></span></a>
      <?if(!empty($arItem["PARAMS"]["CHILD_SECTION_ID"])){?>
        <div class="drop-nav drop-nav-phone">
          <div class="drop-nav-hold">
          <?= recursiveOutput($arResult, $arItem["PARAMS"]["CHILD_SECTION_ID"], $sectionId);?>
          </div>
        </div>
      <?}?>
    </li>
  <?endforeach;?>
</ul>
<?
/**
 * Recursive output
 * @param array $arResult menu points
 * @param array $arSections subsections for section
 * @param int $id parent id
 * @return string html code
 */
function recursiveOutput($arResult, $arSections, $id){
  $result = '';
  $cols = array();
  $iter = 0;
  $counter = 0;
  $cols[$iter] = '<div class="col">
                    <div class="block">
                      <ul>';
  foreach($arResult as $subItem){
    if(in_array($subItem["PARAMS"]["ITEM_IBLOCK_ID"],$arSections)){
      $cols[$iter] .='<li><a href="'.$subItem["LINK"].'">'.$subItem["TEXT"].'</a></li>';
      if(!empty($subItem["PARAMS"]["CHILD_SECTION_ID"])) $cols[$iter] .= getSubsections($arResult, $subItem["PARAMS"]["CHILD_SECTION_ID"]);
      $counter++;
      if($counter>10){
        $counter = 0;
        $cols[$iter] .= '</ul>
                 </div>
                </div>';
        $iter++;
        $cols[$iter] = '<div class="col">
                    <div class="block">
                      <ul>';
      }
    }else continue;
  }
  $cols[$iter] .= '</ul>
                 </div>
                </div>';
  if(!empty($arResult["HITS"][$id])){
    $rnd = rand(0,count($arResult["HITS"][$id])-1);
    $hit = $arResult["HITS"][$id][$rnd];
    $url = str_replace(".html","/",$hit["DETAIL_PAGE_URL"]);
    $cols[] = '<div class="col vBlock">
          <div class="hold noAlign">
            <div class="noAlign picBlock">
              <a href="'.$url.'">
                <img src="'.$hit["PHOTO"].'" alt="'.$hit["NAME"].'" />
                '.($hit["NEWPRODUCT"] == "Y"?'<span class="new">&nbsp;</span>':'').'
                '.($hit["SALELEADER"] == "Y"?'<span class="hit">&nbsp;</span>':'').'
              </a>
            </div>
            <div class="text-block">
              <div class="description">
                <a href="'.$url.'">'.$hit["NAME"].'</a>
              </div>
              <div class="box">
                <div class="col-left">
                  <span class="price">'.str_replace(" руб.","",$hit["PRICE"]["BASE"]["PRINT_VALUE"]).'<span class="rouble">'.GetMessage("RUB").'</span></span>
                  '.($hit["PRICE"]["BASE"]["CAN_BUY"]=="Y"?'<span class="available">'.GetMessage("AVAILABLE").'</span>':'').'
                </div>
              </div>
            </div>
          </div>
        </div>';
  }
  $result .= implode("",$cols).'<span class="shadow">&nbsp;</span>';
  return $result;
}
/**
 * Get subsection list Od third sublevel
 * @param array $arResult menu data
 * @param array $arSections section's subsection data
 * @return string html code
 */
function getSubsections($arResult, $arSections){
  $result = "<ul>";
  foreach ($arResult as $subsections){
    if(in_array($subsections["PARAMS"]["ITEM_IBLOCK_ID"],$arSections)) $result .= '<li><a href="'.$subsections["LINK"].'">'.$subsections["TEXT"].'</a></li>';
  }
  $result .= "</ul>";
  return $result;
}
?>