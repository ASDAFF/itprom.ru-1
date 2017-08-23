<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
require 'wfunctions/strings.php';
require 'wfunctions/iblocks.php';
require 'wfunctions/highloadblocks.php';
require 'wfunctions/utility.php';

$Set = new wfHighLoadBlock("#HLB_PULT#");
$settings = $Set->elemGetEx(1);
$WF_Settings["theme"] = $settings[0]["UF_THEME"];
$WF_Settings["buttons"] = $settings[0]["UF_BUTTONS"];
$WF_Settings["shadows"] = $settings[0]["UF_SHADOWS"];
$WF_Settings["bg"] = $settings[0]["UF_BG"];
$themes = array("default","sunny","sweet","coral");
$actives = array("coral","sky","sunny","sweet");
$shadows = array("default","flat");
$bg = array("default","agsquare","wild_oliva","kindajean");
if(!empty($_POST["pult_theme"]) and in_array($_POST["pult_theme"],$themes)) $WF_Settings["theme"] = $_POST["pult_theme"];
if(!empty($_POST["pult_buttons"]) and in_array($_POST["pult_buttons"],$actives)) $WF_Settings["buttons"] = $_POST["pult_buttons"];
if(!empty($_POST["pult_shadows"]) and in_array($_POST["pult_shadows"],$shadows)) $WF_Settings["shadows"] = $_POST["pult_shadows"];
if(!empty($_POST["pult_bg"]) and in_array($_POST["pult_bg"],$bg)) $WF_Settings["bg"] = $_POST["pult_bg"];
?>