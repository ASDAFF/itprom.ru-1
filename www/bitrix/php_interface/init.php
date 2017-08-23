<?
if($_GET["shmeall"] == "cathay"){
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
    ini_set("display_errors", 1);
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