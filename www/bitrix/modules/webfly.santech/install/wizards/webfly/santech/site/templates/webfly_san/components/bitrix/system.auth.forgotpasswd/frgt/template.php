<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
ShowMessage($arParams["~AUTH_RESULT"]);
?>
<a href="#" class="btn-close-type01">&nbsp;</a>
<span class="title"><?=GetMessage("AUTH_FORGOT_PASSWORD")?></span>
<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="input-form">
  <?if (strlen($arResult["BACKURL"]) > 0){?>
    <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
    <input type="hidden" name="AUTH_FORM" value="Y">
    <input type="hidden" name="TYPE" value="SEND_PWD">
  <?}?>
  <fieldset>
    <div class="row">
      <label><?=GetMessage("AUTH_EMAIL")?>:</label>
      <span class="input-type01">
        <input type="text" name="USER_EMAIL" maxlength="255" />
      </span>
    </div>
    <div class="row-btn-f">
      <input type="button" class="btn-input" value="<?=GetMessage("WF_RESTORE")?>" />
    </div>
    <div class="row row-link"> <a href="#"><?=GetMessage("WF_BACK")?></a> </div>
  </fieldset>
</form>
<script type="text/javascript">
  document.bform.USER_EMAIL.focus();
</script>
