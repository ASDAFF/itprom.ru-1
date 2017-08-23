<?

require('src/VK/VK.php');

$appId = "5153763";
$userId = "334151636";
$secretCode = "XftZbIGFnYEpJImOnEH0";

$code = "8ee64dc9a62b65d6e8";
$redirectUri = "https://itprom.ru/vk/index001.php";
$redirectUri = "https://oauth.vk.com/blank.html";
$accessToken = "a8bd1eda7c5dc82d227ce03a1f9e3c42c873d84f1796d83719390d046d930b16e2c9672422a0d8fb363c3";

$vk = new \VK\VK($appId,$secretCode,$accessToken);

print_r($vk->getAccessToken('360f95056bc83f9b87'));

//$authUrl = $vk->getAuthorizeUrl('photos,wall,offline');

//$wallPostResult = $vk->api("wall.post", array(
//    'owner_id' => $userId,
//    'message' => "Ваалейкум салам"
//));



//print_r($wallPostResult);

?>

<div>
    <a href="">Auth</a>
</div>
