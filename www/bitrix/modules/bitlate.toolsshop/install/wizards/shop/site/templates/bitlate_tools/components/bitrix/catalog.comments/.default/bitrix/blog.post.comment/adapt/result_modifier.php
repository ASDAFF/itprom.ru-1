<?
/** @var CMain $APPLICATION */
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponent $component */
/** @var string $templateFolder */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!function_exists("__MPF_ImageResizeHandler"))
{
	function __MPF_ImageResizeHandler(&$arCustomFile)
	{
		$arResizeParams = array("width" => 400, "height" => 400);

		if ((!is_array($arCustomFile)) || !isset($arCustomFile['fileID']))
			return false;

		$fileID = $arCustomFile['fileID'];

		$arFile = CFile::MakeFileArray($fileID);
		if (CFile::CheckImageFile($arFile) === null)
		{
			$aImgThumb = CFile::ResizeImageGet(
				$fileID,
				array("width" => 60, "height" => 60),
				BX_RESIZE_IMAGE_EXACT,
				true
			);
			$arCustomFile['img_thumb_src'] = $aImgThumb['src'];

			if (!empty($arResizeParams))
			{
				$aImgSource = CFile::ResizeImageGet(
					$fileID,
					array("width" => $arResizeParams["width"], "height" => $arResizeParams["height"]),
					BX_RESIZE_IMAGE_PROPORTIONAL,
					true
				);
				$arCustomFile['img_source_src'] = $aImgSource['src'];
				$arCustomFile['img_source_width'] = $aImgSource['width'];
				$arCustomFile['img_source_height'] = $aImgSource['height'];
			}
		}

	}
}

if (!empty($arParams["UPLOAD_FILE_PARAMS"]))
{
	$bNull = null;
	__MPF_ImageResizeHandler($bNull, $arParams["UPLOAD_FILE_PARAMS"]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['mfi_mode']) && ($_REQUEST['mfi_mode'] == "upload"))
{
	AddEventHandler('main',  "main.file.input.upload", '__MPF_ImageResizeHandler');
}

foreach ($arResult['Comments'] as $comment) {
	if ($comment["PUBLISH_STATUS"] == BLOG_PUBLISH_STATUS_PUBLISH) {
		$curComment = "";
		$resComments = (isset($arResult['PagesComment'])) ? $arResult['PagesComment']  : $arResult['CommentsResult'] ;
		foreach ($resComments as $page => $pageComments) {
			foreach ($pageComments as $idComment => $oneComment) {
				if ($comment['ID'] == $oneComment['ID']) {
					$oneComment["urlToAuthor"] = "";
					$oneComment["urlToBlog"] = "";
					$curComment = $oneComment;
					unset($resComments[$page][$idComment]);
				}
			}
		}
		if ($curComment != "") {
			$arResult['ITEMS'][$comment['ID']] = $curComment;
		}
	}
}
krsort($arResult['ITEMS']);