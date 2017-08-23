<?
/** @var CMain $APPLICATION */
/** @var CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponent $component */
/** @var string $templateFolder */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if (isset($_POST['act']) && $_POST['act'] == 'add') {
	include $_SERVER["DOCUMENT_ROOT"].$templateFolder.'/form.php';
	die();
}
$dbResult = new CDBResult;
$dbResult->InitFromArray($arResult['ITEMS']);
$dbResult->NavStart($arParams["COMMENTS_COUNT"], false);
$arResult['PAGE'] = $dbResult->NavPageNomer;
$navString = $dbResult->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], $arParams["PAGER_SHOW_ALWAYS"]);

function __showComment($comment, $arParams)
{
	$comment["urlToAuthor"] = "";
	$comment["urlToBlog"] = "";

	$aditStyle = "";
	if($arParams["is_ajax_post"] == "Y" || $comment["NEW"] == "Y")
		$aditStyle .= " blog-comment-new";
	if($comment["AuthorIsAdmin"] == "Y")
		$aditStyle = " blog-comment-admin";
	if(IntVal($comment["AUTHOR_ID"]) > 0)
		$aditStyle .= " blog-comment-user-".IntVal($comment["AUTHOR_ID"]);
	if($comment["AuthorIsPostAuthor"] == "Y")
		$aditStyle .= " blog-comment-author";
	if($comment["PUBLISH_STATUS"] != BLOG_PUBLISH_STATUS_PUBLISH && $comment["ID"] != "preview")
		$aditStyle .= " blog-comment-hidden";
	if($comment["ID"] == "preview")
		$aditStyle .= " blog-comment-preview";

	$avatar = null;
	if (!empty($comment['COMMENT_PROPERTIES']['DATA']['UF_NL_AVATAR']['VALUE'])) {
		$avatar = CFile::ResizeImageGet($comment['COMMENT_PROPERTIES']['DATA']['UF_NL_AVATAR']['VALUE'], array('width' => 60, 'height' => 60), BX_RESIZE_IMAGE_EXACT);
    }
    $rating = 0;
	if (!empty($comment['COMMENT_PROPERTIES']['DATA']['UF_NL_RATING']['VALUE']))
		$rating = intval($comment['COMMENT_PROPERTIES']['DATA']['UF_NL_RATING']['VALUE']);
	?>
    <a name="<?=$comment["ID"]?>"></a>
    <dl class="product-comments-item <?=$aditStyle?>" id="blg-comment-<?=$comment["ID"]?>">
        <dt class="inline-block-container">
            <div class="inline-block-item product-comments-item-avatar">
                <?if ($avatar):?>
                    <img src="<?=$avatar['src']?>" alt="">
                <?else:?>
                    <svg class="icon">
                        <use xlink:href="#svg-icon-profile"></use>
                    </svg>
                <?endif;?>
            </div>
            <div class="inline-block-item product-comments-item-caption">
                <div class="name"><?=$comment["AuthorName"]?> <span><?=date('d.m.Y', strtotime($comment["DateFormated"]))?></span></div>
                <div class="rating">
                    <div class="rating-star">
                        <div class="rating-star-active" style="width: <?=($rating/5 * 100)?>%;"></div>
                    </div>
                </div>
            </div>
        </dt>
        <dd><?=$comment["TextFormated"]?></dd>
    </dl>
<?
}
?>
<a href="#new-comment" id="review-link-add" onclick="return false;" class="button small fancybox"><?=getMessage('REVIEW_BUTTON')?></a>
<?if ($arResult["is_ajax_post"] != "Y" && $arResult["CanUserComment"] && isset($_POST['first_load'])):?>
    <? include __DIR__.'/form.php'?>
<?endif;?>
<?if (!empty($arResult['ITEMS'])):
    foreach ($dbResult->arResult as $comment):
        __showComment($comment, $arParams);
    endforeach;
else:?>
    <p><?=getMessage('REVIEWS_EMPTY')?></p>
<?endif;?>
<a id="review-reload" href="<?=$APPLICATION->GetCurPageParam()?>"></a>
<script type="text/javascript">
	$(function(){
		<?if (!empty($arResult['ITEMS'])) {
			reset($arResult['ITEMS']);
			$comment = current($arResult['ITEMS']);
			ob_start();
			__showComment($comment, $arParams);
			$firstReview = ob_get_clean();
		} else {
			$firstReview = '<p id="first-review">' . getMessage('REVIEWS_EMPTY') . '</p>';
		}?>

		$('#first-review').html(<?=json_encode($firstReview)?>);
		<?if ($arResult["is_ajax_post"] != "Y"):?>
            <? if (isset($_POST['first_load'])):?>
				$('#bx_fancybox_blocks').append($('#new-comment'));
			<? endif;?>
			$(document).on("click", "#review-link-add", function() {
				$('#review_messages').hide();
				<?if($arResult["use_captcha"]===true):?>
					var im = BX('captcha');
					BX('captcha_del').appendChild(im);
					var im = BX('captcha');
					BX('div_captcha').appendChild(im);
					im.style.visibility = "visible";
				<?endif;?>
			})
			$('.product-comments .pagination a').each(function() {
                if ($(this).attr('href') != undefined && $(this).attr('onclick') == undefined) {
                    var pageUrl = $(this).attr('href');
                    if (pageUrl.indexOf("bxajaxid=") <= 0) {
                        if (pageUrl.indexOf("?") >= 0) {
                            pageUrl = pageUrl + '&bxajaxid=<?=$this->__component->arParams["AJAX_ID"]?>';
                        } else {
                            pageUrl = pageUrl + '?bxajaxid=<?=$this->__component->arParams["AJAX_ID"]?>';
                        }
                    }
                    $(this).attr('onclick', "BX.ajax.insertToNode('" + pageUrl + "', 'comp_<?=$this->__component->arParams["AJAX_ID"]?>'); return false;");
                }
                $(this).attr('href', '#');
            });
		<?endif;?>
	});
</script>
<?echo $navString;?>
<?if ($arResult["is_ajax_post"] != "Y") {
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/script.php");
} else {?>
	<script>
		<?if ($arResult["use_captcha"]===true):?>
			var cc;
			if(document.cookie.indexOf('<?echo session_name()?>'+'=') == -1)
				cc = Math.random();
			else
				cc ='<?=$arResult["CaptchaCode"]?>';

			BX('captcha').src='/bitrix/tools/captcha.php?captcha_code='+cc;
			BX('captcha_code').value = cc;
			BX('captcha_word').value = "";
		<?endif;?>
	</script>
	<?die();
}