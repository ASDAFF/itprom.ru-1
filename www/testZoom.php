<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");

$anypath = '/bitrix/templates/webfly_san/';
$imgpath = '/upload/';
$APPLICATION->SetAdditionalCSS($anypath.'css/anythingzoomer.css');

$APPLICATION->AddHeadScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
$APPLICATION->AddHeadScript($anypath.'js/jquery.anythingzoomer.js');
?><div class="wrapper">
	<div class="container">
		<div class="container-hold">
		<h1 class="" style="text-align: center;"><br></h1><h1 class="" style="text-align: center;">Zoom it!<br>
		</h1>
		<div id="zoom" style="position:relative;">
			<div class="small">
 <img alt="small rushmore" src="<?=$imgpath.'rushmore_small.jpg'?>">
			</div>
			 <!-- the large content can be cloned from the small content -->
			<div class="large">
 <img alt="big rushmore" src="<?=$imgpath.'rushmore.jpg'?>">
			</div>
		</div>
		 <script>
	  $(function(){
		$("#zoom").anythingZoomer();
	  });
	</script>
	<br><br><br>
</div></div></div>
 <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>