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
$this->setFrameMode(true);
//*******************************************************
//************** THIS CRUSHES CSS ******************
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
/*$APPLICATION->AddHeadString('<style>
	div.header-info {-webkit-box-sizing: content-box !important;-moz-box-sizing: content-box !important;box-sizing: content-box !important;}
	.help-block{margin-top:0px !important;margin-bottom:0px !important;}
</style>');*/
//*******************************************************
$this->addExternalCss("/bitrix/css/main/gbootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");
$this->addExternalCss($this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css');


//////////////////
// Fancy Boxing //
$APPLICATION->AddHeadScript('https://code.jquery.com/jquery-latest.min.js');
$fancypath = '/bitrix/templates/webfly_san/js/fancybox/';

$APPLICATION->AddHeadScript($fancypath."lib/jquery.mousewheel-3.0.6.pack.js");
$APPLICATION->AddHeadScript($fancypath.'source/jquery.fancybox.pack.js?v=2.1.5');
$APPLICATION->SetAdditionalCSS($fancypath.'source/jquery.fancybox.css?v=2.1.5');
//helpers etc
$APPLICATION->SetAdditionalCSS($fancypath.'source/helpers/jquery.fancybox-buttons.css?v=1.0.5');
$APPLICATION->AddHeadScript($fancypath."source/helpers/jquery.fancybox-buttons.js?v=1.0.5");
$APPLICATION->AddHeadScript($fancypath."source/helpers/jquery.fancybox-media.js?v=1.0.6");

$APPLICATION->SetAdditionalCSS($fancypath.'source/helpers/jquery.fancybox-thumbs.css?v=1.0.7');
$APPLICATION->AddHeadScript($fancypath."source/helpers/jquery.fancybox-thumbs.js?v=1.0.7");


?>


<div class="bx-newslist">
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?><br />
	<?endif;?>

	<style>
		.newsection{width:100%; display:inline-block; margin-bottom:20px;}
		.newsecdivider{border-bottom:1px solid #ccc;width:100%;height:30px;}
		.secthead{width:100%; padding:20px 36px; text-align: center; font-weight:bold; font: 32px/36px 'ubuntulight', Arial, Helvetica, sans-serif; }
	</style

	<div class="row">
		<? $sec_changer = $arResult["ITEMS"][0]["IBLOCK_SECTION_ID"]; ?>
		<div style="width:100%;clear:both;"><h2 class="secthead" style="padding-top:0px !important;"><?= $arResult["SECTIONS"][$sec_changer] ?></h2></div>
		<div class="newsection">
			<?foreach($arResult["ITEMS"] as $arItem): ?>
			<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
			<? if ($sec_changer != $arItem["IBLOCK_SECTION_ID"]):?>
			<? $sec_changer = $arItem["IBLOCK_SECTION_ID"]; ?>
		</div>
		<? if ($sec_changer != null): ?>
			<div class="newsecdivider"></div>
		<?endif;?>
		<div style="width:100%;clear:both;"><h2 class="secthead"><?= $arResult["SECTIONS"][$sec_changer] ?></h2></div>
		<div class="newsection">
			<?endif;?>

			<div class="bx-newslist-container col-sm-6 col-md-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="bx-newslist-block">
					<h2 class="bx-newslist-title" style="margin:0px 30px; text-align:center;">
						<?echo $arItem["NAME"]?>
					</h2>
					<?if($arParams["DISPLAY_PICTURE"]!="N"):?>
						<?if ($arItem["VIDEO"]):?>
							<div class="bx-newslist-youtube embed-responsive embed-responsive-16by9" style="display: block;">
								<iframe
									src="<?echo $arItem["VIDEO"]?>"
									frameborder="0"
									allowfullscreen=""
									></iframe>
							</div>
						<?elseif ($arItem["SOUND_CLOUD"]):?>
							<div class="bx-newslist-audio">
								<iframe
									width="100%"
									height="166"
									scrolling="no"
									frameborder="no"
									src="https://w.soundcloud.com/player/?url=<?echo urlencode($arItem["SOUND_CLOUD"])?>&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"
									></iframe>
							</div>
						<?elseif ($arItem["SLIDER"] && count($arItem["SLIDER"]) > 1):?>
							<div class="bx-newslist-slider">
								<div class="bx-newslist-slider-container" style="width: <?echo count($arItem["SLIDER"])*100?>%;left: 0;">
									<?foreach ($arItem["SLIDER"] as $file):?>
										<div style="width: <?echo 100/count($arItem["SLIDER"])?>%;" class="bx-newslist-slider-slide">
											<img src="<?=$file["SRC"]?>" alt="<?=$file["DESCRIPTION"]?>">
										</div>
									<?endforeach?>
									<div style="clear: both;"></div>
								</div>
								<div class="bx-newslist-slider-arrow-container-left"><div class="bx-newslist-slider-arrow"><i class="fa fa-angle-left" ></i></div></div>
								<div class="bx-newslist-slider-arrow-container-right"><div class="bx-newslist-slider-arrow"><i class="fa fa-angle-right"></i></div></div>
								<ul class="bx-newslist-slider-control">
									<?foreach ($arItem["SLIDER"] as $i => $file):?>
										<li rel="<?=($i+1)?>" <?if (!$i) echo 'class="current"'?>><span></span></li>
									<?endforeach?>
								</ul>
							</div>
							<script type="text/javascript">
								BX.ready(function() {
									new JCNewsSlider('<?=CUtil::JSEscape($this->GetEditAreaId($arItem['ID']));?>', {
										imagesContainerClassName: 'bx-newslist-slider-container',
										leftArrowClassName: 'bx-newslist-slider-arrow-container-left',
										rightArrowClassName: 'bx-newslist-slider-arrow-container-right',
										controlContainerClassName: 'bx-newslist-slider-control'
									});
								});
							</script>
						<?elseif ($arItem["SLIDER"]):?>
							<div class="bx-newslist-img">
								<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
									<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
											src="<?=$arItem["SLIDER"][0]["SRC"]?>"
											width="<?=$arItem["SLIDER"][0]["WIDTH"]?>"
											height="<?=$arItem["SLIDER"][0]["HEIGHT"]?>"
											alt="<?echo $arItem["PREVIEW_TEXT"];?>"
											title="<?=$arItem["SLIDER"][0]["TITLE"]?>"
											/></a>
								<?else:?>
									<img
										src="<?=$arItem["SLIDER"][0]["SRC"]?>"
										width="<?=$arItem["SLIDER"][0]["WIDTH"]?>"
										height="<?=$arItem["SLIDER"][0]["HEIGHT"]?>"
										alt="<?echo $arItem["NAME"];?>"
										title="<?echo $arItem["PREVIEW_TEXT"];?>"
										/>
								<?endif;?>
							</div>
						<?elseif (is_array($arItem["PREVIEW_PICTURE"])):?>
							<div class="bx-newslist-img">
								<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
									<a href="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" class="lightim">
										<img
											src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
											width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
											height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
											alt="<?echo $arItem["NAME"];?>"
											title="<?echo $arItem["PREVIEW_TEXT"];?>"
											/>
									</a>
								<?else:?>
									<img
										src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
										width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
										height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
										alt="<?echo $arItem["NAME"];?>"
										title="<?echo $arItem["PREVIEW_TEXT"];?>"
										/>
								<?endif;?>
							</div>
						<?endif;?>
					<?endif;?>

					<div class="row">
						<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
							<div class="col-xs-5">
								<div class="bx-newslist-date"><i class="fa fa-calendar-o"></i> <?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
							</div>
						<?endif?>
						<?if($arParams["USE_RATING"]=="Y"):?>
							<div class="col-xs-7 text-right">
								<?$APPLICATION->IncludeComponent(
									"bitrix:iblock.vote",
									"flat",
									Array(
										"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
										"IBLOCK_ID" => $arParams["IBLOCK_ID"],
										"ELEMENT_ID" => $arItem["ID"],
										"MAX_VOTE" => $arParams["MAX_VOTE"],
										"VOTE_NAMES" => $arParams["VOTE_NAMES"],
										"CACHE_TYPE" => $arParams["CACHE_TYPE"],
										"CACHE_TIME" => $arParams["CACHE_TIME"],
										"DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
										"SHOW_RATING" => "N",
									),
									$component
								);?>
							</div>
						<?endif?>
					</div>
					<?/*
				<div class="row">
					<div class="col-xs-5">
					<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
						<div class="bx-newslist-more"><a class="btn btn-primary btn-xs" href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo GetMessage("CT_BNL_GOTO_DETAIL")?></a></div>
					<?endif;?>
					</div>
				<?
				if ($arParams["USE_SHARE"] == "Y")
				{
					?>
					<div class="col-xs-7 text-right">
						<noindex>
						<?
						$APPLICATION->IncludeComponent("bitrix:main.share", $arParams["SHARE_TEMPLATE"], array(
								"HANDLERS" => $arParams["SHARE_HANDLERS"],
								"PAGE_URL" => $arItem["~DETAIL_PAGE_URL"],
								"PAGE_TITLE" => $arItem["~NAME"],
								"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
								"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
								"HIDE" => $arParams["SHARE_HIDE"],
							),
							$component,
							array("HIDE_ICONS" => "Y")
						);
						?>
						</noindex>
					</div>
					<?
				}
				?>
				</div>
				*/?>
				</div>
			</div>
			<?endforeach;?>
		</div>
	</div>

	<div class="staffspacer"></div>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$("a.lightim").fancybox();
	});
</script>