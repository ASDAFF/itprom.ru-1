<?php
function wfGetPluralEnum($number, $text){
  global $WF_CONFIG;
  if(!is_array($text)) $labels = explode("|",$WF_CONFIG["PLURALS"][$text]);
  else $labels = $text;
  $variant = array (2, 0, 1, 1, 1, 2);
  return $number." ".$labels[ ($number%100 > 4 && $number%100 < 20)? 2 : $variant[min($number%10, 5)] ];
}
function wfDiffDate($date1, $date2){
  $endDay = strtotime($date2);
  $startDay = strtotime($date1);
  $difference = $endDay - $startDay;
  $return['days'] = floor($difference / 86400);
  $return['hours'] = floor($difference / 3600) % 24;
  $return['minutes'] = floor($difference / 60) % 60;
  return $return;
}