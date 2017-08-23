<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<? $this->setFrameMode("true"); ?> 
<ul>
<?foreach($arParams["~AUTH_SERVICES"] as $service):?>
	<li><noindex>
    <a rel="nofollow" title="<?=htmlspecialcharsbx($service["NAME"])?>" href="javascript:void(0)" onclick="BxShowAuthFloat('<?=$service["ID"]?>', '<?=$arParams["SUFFIX"]?>')">
      <img src="<?=$this->GetFolder();?>/img/<?=htmlspecialcharsbx($service["ICON"])?>.png" width="38" height="38" alt="<?=htmlspecialcharsbx($service["ICON"])?>"/>
	</a></noindex>
  </li>
<?endforeach?>
</ul>
