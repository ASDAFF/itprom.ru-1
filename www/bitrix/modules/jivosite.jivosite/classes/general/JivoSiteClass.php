<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/jivosite.jivosite/config.php');

class JivoSiteClass{
    public function addScriptTag() {

        global $APPLICATION;

        if(self::isAdminPage() || self::isEditMode()) {
            return;
        }

        $add_script = false;
        $sites = COption::GetOptionString("jivosite.jivosite", "sites");
        $sites = json_decode($sites, true);
        if(isset($sites) and is_array($sites)) {
            foreach ($sites as $site => $value) {
                if ($site == SITE_ID) {
                    $add_script = true;
                }
            }
            if (!$add_script) {
                return;
            }
        }

        $widget_id = COption::GetOptionString("jivosite.jivosite", "widget_id");
        //$APPLICATION->AddHeadScript("//".JIVO_CODE_URL."/script/widget/$widget_id");
        $APPLICATION->AddHeadString("\n<!-- BEGIN JIVOSITE CODE -->
        <script type='text/javascript'>
            (function(){
                var widget_id = '$widget_id';
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = '//code.jivosite.com/script/widget/'+widget_id;
                var ss = document.getElementsByTagName('script')[0];
                ss.parentNode.insertBefore(s, ss);
            })();
        </script>
        <!-- END JIVOSITE CODE -->\n");
    }

    static private function isAdminPage() {
        return defined('ADMIN_SECTION');
    }

    static private function isEditMode() {
        if(isset($_SESSION["SESS_INCLUDE_AREAS"]) && $_SESSION["SESS_INCLUDE_AREAS"]) {
            return true;
        }

        if (isset($_GET["bitrix_include_areas"]) && $_GET["bitrix_include_areas"] == "Y") {
            return true;
        }

        $aUserOpt = CUserOptions::GetOption("global", "settings");
        if(isset($aUserOpt["panel_dynamic_mode"]) && $aUserOpt["panel_dynamic_mode"] == "Y") {
            return true;
        }

        return false;
    }
}