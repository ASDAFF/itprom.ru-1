<?
/** @var CMain $APPLICATION */
/** @var CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponent $component */
/** @var string $templateFolder */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$rating = 0;

if (isset($_POST['act']) && $_POST['act'] == 'add') {
	if (empty($arResult["MESSAGE"]) && !empty($arResult["ajax_comment"])) {
		$arResult["MESSAGE"] = GetMessage("MESS_SUCCESS");
	}
	if (!empty($arResult["MESSAGE"])) {
		$arResult["MESSAGE"] = ($arResult['Perm'] == BLOG_PERMS_PREMODERATE) ? GetMessage("MESS_PREMODERATE") : $arResult["MESSAGE"];
	}

	$rating = intval($_POST['UF_NL_RATING']);

	$result = array(
		'message' => $arResult["MESSAGE"],
		'error' => $arResult["COMMENT_ERROR"],
		'success' => !empty($arResult["ajax_comment"]),
		'close' => ($arResult['Perm'] == BLOG_PERMS_PREMODERATE) ? 'N' : 'Y'
	);
	if ($arResult["use_captcha"] === true) {
		$result['captchaCode'] = $arResult["CaptchaCode"];
	}

	echo \Bitrix\Main\Web\Json::encode($result);
	die();
}
?>
    <div id="new-comment" class="fancybox-block">
        <div class="fancybox-block-caption"><?=GetMessage("FORM_TITLE")?></div>
        <div class="callout text-center error" data-closable id="review_messages"></div>
        <div class="fancybox-block-wrap">
            <form action="<?=$_SERVER['REQUEST_URI']?>" class="form" id="form-review" method="post" enctype="multipart/form-data">
                <?=bitrix_sessid_post()?>
                <div class="rating">
                    <div class="rating-me"><?=GetMessage("LABEL_RATING")?></div>
                    <div class="rating-star relative">
                        <fieldset>
                            <input type="radio" name="UF_NL_RATING" value="1" id="rating-1" class="show-for-sr">
                            <label for="rating-1" class="rating-star-active rating-active-1"></label>
                            <input type="radio" name="UF_NL_RATING" value="2" id="rating-2" class="show-for-sr">
                            <label for="rating-2" class="rating-star-active rating-active-2"></label>
                            <input type="radio" name="UF_NL_RATING" value="3" id="rating-3" class="show-for-sr">
                            <label for="rating-3" class="rating-star-active rating-active-3"></label>
                            <input type="radio" name="UF_NL_RATING" value="4" id="rating-4" class="show-for-sr">
                            <label for="rating-4" class="rating-star-active rating-active-4"></label>
                            <input type="radio" name="UF_NL_RATING" value="5" id="rating-5" class="show-for-sr">
                            <label for="rating-5" class="rating-star-active rating-active-5"></label>
                        </fieldset>
                    </div>
                </div>
                <?if (!$USER->IsAuthorized()):?>
                    <input type="text" name="user_name" placeholder="<?=GetMessage("BLOG_USER_NAME")?>" value="<?=htmlspecialcharsEx($_SESSION["blog_user_name"])?>">
                <?endif;?>
                <textarea name="comment" placeholder="<?=GetMessage("COMMENT")?>"><?=(isset($_POST['comment']) ? $_POST['comment'] : '')?></textarea>
                <input type="file" id="comment-file-avatar" class="show-for-sr" name="UF_NL_AVATAR" accept="image/*" />
                <label for="comment-file-avatar">
                    <span class="file-image vertical-middle">
                        <svg class="icon">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-icon-profile"></use>
                        </svg>
                    </span>
                    <span class="inline-block-item vertical-middle">
                        <?=GetMessage("DOWNLOAD_PHOTO")?>
                        <span class="file-name" id="comment-file-avatar-name"></span>
                    </span>
                </label>
                <?if ($arResult["use_captcha"]===true):?>
                    <div class="table-container captha-block">
                        <div class="table-item vertical-top">
                            <input type="hidden" name="captcha_code" id="captcha_code" value="<?=$arResult["CaptchaCode"]?>" />
                            <input type="text" name="captcha_word" id="captcha_word" value="" placeholder="<?=GetMessage("MS_CAPTCHA_SYM")?>" />
                        </div>
                        <div class="table-item vertical-top text-right captha" id="div_captcha">
                        </div>
                    </div>
                <?endif;?>
                <button type="submit" class="small-12 button text-center"><?=GetMessage("BUTTON_SEND")?></button>
                <input type="hidden" name="post" value="review_add">
                <input type="hidden" name="act" id="act" value="add">
                <input type="hidden" name="post" value="Y">
                <?if (isset($_REQUEST["IBLOCK_ID"])):?>
                    <input type="hidden" name="IBLOCK_ID" value="<?=(int)$_REQUEST["IBLOCK_ID"]; ?>">
                <?endif;
                if (isset($_REQUEST["ELEMENT_ID"])):?>
                    <input type="hidden" name="ELEMENT_ID" value="<?=(int)$_REQUEST["ELEMENT_ID"]; ?>">
                <?endif;
                if (isset($_REQUEST["SITE_ID"])):?>
                    <input type="hidden" name="SITE_ID" value="<?=htmlspecialcharsbx($_REQUEST["SITE_ID"]); ?>">
                <?endif;?>
                <?if($arResult["use_captcha"]===true):?>
                    <div id="captcha_del">
                        <img src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult["CaptchaCode"]?>" width="115" height="45" id="captcha" style="visibility:hidden;" class="photo">
                        <script>
                            document.getElementById('captcha_code').value = '<?=$arResult["CaptchaCode"]?>';
                        </script>
                    </div>
                <?endif;?>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        (function(){
            var formBlock = $('#form-review');
            top.BX.unbindAll(formBlock.get(0));
            formBlock.on('submit', function(){
                var formData = formBlock.serializeArray(),
                    data = new FormData(),
                    file = $('#comment-file-avatar'),
                    messages = $('#review_messages'),
                    files = file.prop('files');
                data.append(file.attr('name'), files[0]);

                $.each(formData, function(index, item) {
                    data.append(item.name, item.value);
                });

                messages.hide();

                $.ajax({
                    url: formBlock.attr('action'),
                    data: data,
                    dataType: 'json',
                    cache: false,
                    type: 'post',
                    processData: false,
                    contentType: false
                }).done(function(data){
                    if (data.error && data.error.length) {
                        messages.html(data.error);
                        messages.show();
                    }
                    if (data.message && data.message.length) {
                        messages.html(data.message);
                        messages.show();
                    }

                    if (data.success) {
                        $('#review-reload').trigger('click');
                        $('#comment-file-avatar').val('');
                        $('#comment-file-avatar-name').html('');
                        $('#form-review .rating input').removeAttr('checked');
                        $('#form-review input[name=user_name]').val('');
                        $('#form-review textarea[name=comment]').val('');
                        if (data.close == 'Y') {
                            $('.fancybox-close').click();
                        }
                    }
                    window.BX = top.BX;
                    if (data.captchaCode) {
                        var cc;
                        if(document.cookie.indexOf('<?echo session_name()?>'+'=') == -1)
                            cc = Math.random();
                        else
                            cc = data.captchaCode;

                        BX('captcha').src='/bitrix/tools/captcha.php?captcha_code='+cc;
                        BX('captcha_code').value = cc;
                        BX('captcha_word').value = "";
                    }
                }).error(function(){
                    alert('<?=GetMessage("FORM_ERROR")?>');
                });

                return false;
            });

            var $rating = formBlock.find('.rating');

            formBlock.find('#comment-file-avatar').on('change', function(){
                formBlock.find('#comment-file-avatar-name').text($(this).val());
            });
        })();
    </script>