<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include_once '../wfunctions/highloadblocks.php';
$action = $_POST["action"];
$elemId = $_POST["elemId"];
$Fav = new wfHighLoadBlock("#HLB_FAV#");
switch ($action){
  case 'delete':
    $Fav->elemDelete($elemId);
    break;
  case 'add':default:
    echo $Fav->elemAdd($elemId);
}
die();