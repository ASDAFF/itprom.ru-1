<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
include_once '../wfunctions/highloadblocks.php';
$Set = new wfHighLoadBlock("4");
if(isset($_POST["action"]) and ($_POST["action"] == "reset")) $data = array("UF_THEME" => "default", "UF_BUTTONS" => "default", "UF_SHADOWS" => "default", "UF_BG" => "default");
else $data = array("UF_THEME" => $_POST["theme"], "UF_BUTTONS" => $_POST["actives"], "UF_SHADOWS" => $_POST["shadow"], "UF_BG" => $_POST["bg"]);
$Set->elemModify(1,$data);

?>