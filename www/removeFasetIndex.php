<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $USER;
if (!($USER -> isAdmin())) {
    echo "<h1>NOT ADMIN!</h1>";
    die();
}

$iblockId = 4;
if (CModule::IncludeModule('iblock')) {
    Bitrix\Iblock\PropertyIndex\Manager::DeleteIndex($iblockId);
    Bitrix\Iblock\PropertyIndex\Manager::markAsInvalid($iblockId);
}