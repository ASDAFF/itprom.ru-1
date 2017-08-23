<?
class CBitlateToolsBlogCommentHandler
{
	public static function OnCommentAdd($ID, $arFields)
	{
		$postId = $arFields["POST_ID"];
		static::reCalcProductRating($postId);
	}

	public static function OnCommentUpdate($ID, $arFields)
	{
		$arComment = CBlogComment::GetByID($ID);
		if (is_array($arComment)) {
			$postId = $arComment["POST_ID"];
			static::reCalcProductRating($postId);
		}
	}

	public static function OnCommentDelete($ID)
	{
		$arComment = CBlogComment::GetByID($ID);
		if (is_array($arComment)) {
			$postId = $arComment["POST_ID"];
			static::reCalcProductRating($postId, array('!ID' => $ID));
		}
	}

	public static function reCalcProductRating($blogPostId, $filterEx = array())
	{
		$blogPostId = intval($blogPostId);

		if (empty($blogPostId))
			return;

		CModule::IncludeModule('iblock');

		/** @noinspection PhpDynamicAsStaticMethodCallInspection */
		$dbResult = CIBlockElement::GetList(
			array('ID' => 'ASC'),
			array(
				'PROPERTY_BLOG_POST_ID' => $blogPostId
			),
			false,
			false,
			array('ID', 'IBLOCK_ID', 'PROPERTY_BLOG_POST_ID', 'PROPERTY_BLOG_POST_ID', 'PROPERTY_DEFAULT_RATING')
		);

		if ($arItem = $dbResult->Fetch()) {
			$filter = array('POST_ID' => $blogPostId, 'PUBLISH_STATUS' => BLOG_PUBLISH_STATUS_PUBLISH);

			/** @noinspection PhpDynamicAsStaticMethodCallInspection */
			$dbCommentResult = CBlogComment::GetList(
				array('ID' => 'ASC'),
				array_merge($filter, $filterEx),
				false,
				false,
				array("ID", "BLOG_ID", "POST_ID", "UF_NL_RATING")
			);

			$commentCnt = 0;
			$commentRatingCnt = 0;
			$ratingSum = 0;

			while ($arComment = $dbCommentResult->Fetch()) {
				$arComment['UF_NL_RATING'] = intval($arComment['UF_NL_RATING']);

				if ($arComment['UF_NL_RATING'] > 5)
					$arComment['UF_NL_RATING'] = 5;

				if ($arComment['UF_NL_RATING'] > 0) {
					$ratingSum += $arComment['UF_NL_RATING'];
					$commentRatingCnt++;
				}
				$commentCnt++;
			}
			if (!empty($arItem['PROPERTY_DEFAULT_RATING_VALUE'])) {
				$arItem['PROPERTY_DEFAULT_RATING_VALUE'] = intval($arItem['PROPERTY_DEFAULT_RATING_VALUE']);

				if ($arItem['PROPERTY_DEFAULT_RATING_VALUE'] > 5)
					$arItem['PROPERTY_DEFAULT_RATING_VALUE'] = 5;

				if ($arItem['PROPERTY_DEFAULT_RATING_VALUE'] > 0) {
					$ratingSum += $arItem['PROPERTY_DEFAULT_RATING_VALUE'];
					$commentCnt++;
					$commentRatingCnt++;
				}
			}
			CIBlockElement::SetPropertyValuesEx($arItem['ID'], $arItem['IBLOCK_ID'], array(
				'BLOG_COMMENTS_CNT' => $commentCnt,
				'vote_count' => $commentRatingCnt,
				'vote_sum' => $ratingSum,
				'rating' => ($ratingSum / $commentRatingCnt),
			));

			global $CACHE_MANAGER;
			$CACHE_MANAGER->ClearByTag("product_".$arItem['ID']);
		}
	}
}