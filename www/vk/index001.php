<?


$appId = "5153763";
$userId = "334151636";
$secretCode = "XftZbIGFnYEpJImOnEH0";

$code = "8ee64dc9a62b65d6e8";
$redirectUri = "https://itprom.ru/vk/index001.php";
$redirectUri = "https://oauth.vk.com/blank.html";
$accessToken = "a8bd1eda7c5dc82d227ce03a1f9e3c42c873d84f1796d83719390d046d930b16e2c9672422a0d8fb363c3";

function getAuthUrl()
{
    global $appId, $redirectUri;
    return
        "https://oauth.vk.com/authorize?".
        "client_id=$appId&display=page&redirect_uri=$redirectUri".
        "&scope=offline,wall&response_type=code&v=5.40";
}

function getAccessToken()
{
    global $code, $appId, $secretCode, $redirectUri;
    return
        "https://oauth.vk.com/access_token?".
        "client_id=$appId&client_secret=$secretCode&redirect_uri=$redirectUri".
        "&code=$code";
}

function wallPost($text)
{
    global $userId, $accessToken;
    $text = urlencode($text);
    $url = "https://api.vk.com/method/wall.post?owner_id=$userId&access_token=$accessToken".
    "&message=$text";

    return $url;
}

function makeLink($href)
{
    return "<div><a href=$href>$href</a></div>";
}

$url = wallPost("Салам алейкум");
//$url = getAccessToken();

?>

<div>
    <h2>Response: <?=$url?></h2>
    <?=file_get_contents($url)?>
</div>
<?

echo makeLink(getAuthUrl());

//echo makeLink(getAccessToken());

//echo makeLink(wallPost("Салам алейкум"));