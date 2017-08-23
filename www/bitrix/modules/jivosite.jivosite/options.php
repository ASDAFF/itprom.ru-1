<?
if (!$USER->IsAdmin())
    return;

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/jivosite.jivosite/config.php');
IncludeModuleLangFile(__FILE__);

if (isset($_POST['set_sites'])) {

    if (isset($_POST['sites'])) {
        $sites = json_encode($_POST['sites']);
    } else {
        $sites = array();
    }

    COption::SetOptionString("jivosite.jivosite", "sites", $sites);
}
?>
<style>
    p.comment{
        width: 500px;
        font-style: italic;
        color: #888;
    }
    .adm-designed-checkbox-label {
        margin: 0 0 5px 0;
    }
</style>
<img src="http://jivo-userdata.s3.amazonaws.com/mail-images/logo-new.png" alt="jivo-logo" style="margin: 10px 0 20px 0;">

<?
$token = COption::GetOptionString("jivosite.jivosite", "auth_token");
if ($token) {
    ?>

    <form action="https://<?= JIVO_BASE_URL ?>/integration/login" target="_blank">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input type="hidden" name="partner" value="bitrix">
        <input type="submit" value="<?= GetMessage('GOTO_ADMIN') ?>">
    </form>

<? } ?>

<?= GetMessage('SETUP_AIR') ?>


