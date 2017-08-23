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