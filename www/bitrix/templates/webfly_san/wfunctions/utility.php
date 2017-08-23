<?
function wfRefreshArray($array){
  $new = array();
  foreach($array as $value){
    $new[] = $value;
  }
  return $new;
}
function wfDump($var, $die = false){
  global $USER;
  if($USER->GetID() != 1) return false;
  echo '<pre>';
  var_dump($var);
  echo '</pre>';
  if($die) die("end!");
}
function wfShowErrors(){
  error_reporting(E_ALL ^ E_NOTICE);
  ini_set("display_errors", 1);
}
?>