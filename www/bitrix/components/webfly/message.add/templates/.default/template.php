<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<script type="text/javascript">
  /**
   * Form validation with ajax submit
   * @returns {Boolean} 
   */
  function validateForm(){
    $(".message-info").hide();
    $(".error").removeClass("error");
    var name = $("#name").val();
    var nameVal = $("#name").attr("min-val");
    if(name.length < nameVal){
      throwError("#name","<?=GetMessage("WF_NAME_VAL")?>");
      return false;
    }
    var email = $("#email").val();
    var emailVal = $("#email").attr("min-val");
    if(email.length < emailVal){
      throwError("#email","<?=GetMessage("WF_EMAIL_VAL")?>");
      return false;
    }
    var mess = $("#message").val();
    var messVal = $("#message").attr("min-val");
    if(mess.length < messVal){
      throwError("#message","<?=GetMessage("WF_MESSAGE_VAL")?>");
      return false;
    }
    /*$(".input-form").ajaxSubmit({
      url: "/message.php"
    });*/
    var url = "/message.php";
    var data = {
      ajaxm: 1,
      name: name,
      email: email,
      message: mess,
      p_email_to: "<?=$arParams["EMAIL_TO"]?>",
      p_ib_type: "<?=$arParams["IBLOCK_TYPE"]?>",
      p_ib_id: "<?=$arParams["IBLOCK_ID"]?>",
      p_evt_id: "<?=implode("|",$arParams["EVENT_MESSAGE_ID"])?>",
      p_cache_t: "<?=$arParams["CACHE_TYPE"]?>",
      p_cache_ti: "<?=$arParams["CACHE_TIME"]?>",
      p_set_t: "<?=$arParams["SET_TITLE"]?>",
      p_template: "main_feed"
    };
    var html = $(".holder").html();
    $.post(url, data, function(){
      $(".holder").html("<?=$arParams["OK_TEXT"]?>");
    });
    setTimeout(function(){
      $(".btn-close-type01").click();
      $(".holder").html(html);
    },2700);
  }
  /**
   * We throw errors at you
   * @param {string} id index of error ridden field (with #)
   * @param {string} message error message
   * @returns {undefined} nothing
   * */
  function throwError(id,message){
    $(".message-info").text(message).show();
    $(id).parent().addClass("error");
    $(id).focus();
  }
</script>
<a href="#" class="btn-close-type01">&nbsp;</a>
<span class="title"><?=GetMessage("WF_HEAD")?></span>
<div class="holder">
  <form action="<?=SITE_TEMPLATE_PATH?>/ajax/message.php" class="input-form" method="POST">
    <fieldset>
      <div class="col-left">
        <div class="row">
          <label><?=GetMessage("WF_NAME")?></label>
          <span class="input-type01"><input type="text" name="name" value="" id="name" min-val="3"/></span>
        </div>
        <div class="row">
          <label><?=GetMessage("WF_EMAIL")?></label>
          <span class="input-type01"><input type="text" name="email" value="" id="email" min-val="3"/></span>
        </div>
        <div class="row">
          <label><?=GetMessage("WF_MESSAGE")?></label>
          <span class="textarea-type01"><textarea cols="30" rows="10" name="message" id="message" min-val="10"></textarea></span>
        </div>
      </div>
      <div class="col-right">
        <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/feedback/socblock.php"));?>
        <span class="message-info" style="display:none;"><?=GetMessage("WF_ERROR_FIELDS")?></span>
        <span class="messages-caller" style="display:none;"><?=GetMessage("WF_CALLER_MSG")?></span>
        <span class="messages-qware" style="display:none;"><?=GetMessage("WF_QWARE_MSG")?></span>
        <div class="row-btn-f">
          <input type="button" class="btn-input" value="<?=GetMessage("WF_SUBMIT")?>" onClick="validateForm();"/>
        </div>
      </div>
    </fieldset>
  </form>
</div>