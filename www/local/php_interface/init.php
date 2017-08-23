<?
define('PRODUCT_DEFAULT_RATING', 3);
define("BX_PULL_SKIP_INIT", true);

if($_GET["shmeall"] == "cathay"){
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
    ini_set("display_errors", 1);
}


function PR($o, $bool = false)
{
    $bt =  debug_backtrace();
    $bt = $bt[0];
    $dRoot = $_SERVER["DOCUMENT_ROOT"];
    $dRoot = str_replace("/","\\",$dRoot);
    $bt["file"] = str_replace($dRoot,"",$bt["file"]);
    $dRoot = str_replace("\\","/",$dRoot);
    $bt["file"] = str_replace($dRoot,"",$bt["file"]);
    global $USER;
    if ($USER->isAdmin() || $bool){
        ?>
        <div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;'>
            <div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?=$bt["file"]?> [<?=$bt["line"]?>]</div>
            <pre style='padding:10px;'><?print_r($o)?></pre>
        </div>
        <?
    }
}
function IsMainPage()
{
    $m_url = trim($_SERVER['REQUEST_URI'],"/");
    $m_url1 = str_split($m_url);
    if($m_url == "" || $m_url1[0] == "?")
    {
        return true;
    }
    return false;
}
function objectToArray($object)
{
    if(!is_object($object) && !is_array($object)){
        return $object;
    }
    if(is_object($object))
    {
        $object = get_object_vars( $object );
    }
    return array_map( 'objectToArray', $object);
}

function test_dump($v) {
    global $USER;
    if ($USER -> isAdmin()) {
        echo "<pre>";
        var_dump($v);
        echo "</pre>";
    }
}

define("TRACE_FILENAME",$_SERVER["DOCUMENT_ROOT"]."/log/trace_".date("Ymd").".log");

function Trace($object)
{
    if ($fp = @fopen(TRACE_FILENAME, "ab+"))
    {
        if (flock($fp, LOCK_EX))
        {
            @fwrite($fp,print_r($object,true));
            @fwrite($fp, "\r\n----------\r\n");
            @fflush($fp);
            @flock($fp, LOCK_UN);
            @fclose($fp);
        }
    }
}

function GetResizedImage($id, $width, $height) {
    $arSize = Array (
        "width" => $width,
        "height" => $height,
    );
    $file = CFile::GetFileArray($id);
    $resized = CFile::ResizeImageGet($file, $arSize);

    return $resized;
}