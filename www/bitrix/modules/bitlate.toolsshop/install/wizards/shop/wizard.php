<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");

class SelectSiteStep extends CSelectSiteWizardStep
{
    function InitStep()
    {
        $wizard =& $this->GetWizard();
        parent::InitStep();

        //$this->SetTitle(GetMessage("NL_WIZ_STEP_SITE_SET"));
        //$this->SetNextCaption(GetMessage("NEXT_BUTTON"));
        //$this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("NL_WIZ_SITE").'</div>';
        //$this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title"><a href = "http://bitlate.ru/">'.GetMessage("NL_WIZ_SITE_DESCRITION").'</a></div>';
        $wizard->solutionName = "adaptiv_shop";


        /*global $SHOWIMAGEFIRST;
        $SHOWIMAGEFIRST = true;

        $this->content .= '<div class="inst-template-list-block">';
        foreach ($arTemplateOrder as $templateID)
        {
            $arTemplate = $arTemplateInfo[$templateID];

            if (!$arTemplate)
                continue;

            $this->content .= '<div class="inst-template-description">';
            $this->content .= $this->ShowRadioField("wizTemplateID", $templateID, Array("id" => $templateID, "class" => "inst-template-list-inp"));

            global $SHOWIMAGEFIRST;
            $SHOWIMAGEFIRST = true;

            if ($arTemplate["SCREENSHOT"] && $arTemplate["PREVIEW"])
                $this->content .= CFile::Show2Images($arTemplate["PREVIEW"], $arTemplate["SCREENSHOT"], 150, 150, ' class="inst-template-list-img"');
            else
                $this->content .= CFile::ShowImage($arTemplate["SCREENSHOT"], 150, 150, ' class="inst-template-list-img"', "", true);

            $this->content .= '<label for="'.$templateID.'" class="inst-template-list-label">'.$arTemplate["NAME"]."</label>";
            $this->content .= "</div>";
        }

        $this->content .= "</div>";*/
    }
}


class SelectTemplateStep extends CSelectTemplateWizardStep
{
}

class SelectThemeStep extends CSelectThemeWizardStep
{
}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
    function InitStep()
    {
        $wizard =& $this->GetWizard();
        $wizard->solutionName = "adaptiv_shop";
        parent::InitStep();

        $templateID = $wizard->GetVar("templateID");

        $this->SetTitle(GetMessage("NL_WIZ_STEP_SITE_SET"));
        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
    }

	function ShowStep()
	{
		$wizard =& $this->GetWizard();

		$this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("NL_WIZ_SITE").'</div>';
			$this->content .= '
			<div class="wizard-input-form-block">
				<label for="siteName" class="wizard-input-title">'.GetMessage("NL_COMPANY_NAME").':</label>
				'.$this->ShowInputField('text', 'siteName', array("id" => "siteName", "class" => "wizard-field")).'
			</div>';

			$this->content .= '
			<div class="wizard-input-form-block">
				<label class="wizard-input-title" for="sitePhone">'.GetMessage("NL_SITE_PHONE").':</label><br />
				'.$this->ShowInputField("text", "sitePhone", array("id" => "sitePhone", "class" => "wizard-field")).'
			</div>';

			$this->content .= '
			<div class="wizard-input-form-block">
				<label class="wizard-input-title" for="siteEmail">'.GetMessage("NL_SITE_EMAIL").':</label><br />
				'.$this->ShowInputField("text", "siteEmail", array("id" => "siteEmail", "class" => "wizard-field")).'
			</div>
		</div>';

		//Интернет-магазин(продажи) email
		$this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("NL_WIZ_SHOP").'</div>';
		$this->content .= '
		<div class="wizard-input-form-block">
			<label class="wizard-input-title" for="shopEmail">'.GetMessage("NL_SHOP_EMAIL").':</label>
			'.$this->ShowInputField('text', 'shopEmail', array("id" => "shopEmail", "class" => "wizard-field")).'
		</div>';
		$this->content .= GetMessage("NL_WIZ_SITE_DESCRITION").'<a target = "_blank" href = "http://bitlate.ru/">'.'bitlate.ru'.'</a>';
	}
	
	function OnPostForm()
	{
		$wizard =& $this->GetWizard();
		$siteName = $wizard->GetVar("siteName");
		$sitePhone = $wizard->GetVar("sitePhone");
		$siteEmail = $wizard->GetVar("siteEmail");
		$shopEmail = $wizard->GetVar("shopEmail");
		if (strlen($siteName) <= 0) {
			$this->SetError(str_replace("#FIELD_NAME#", GetMessage("NL_COMPANY_NAME"), GetMessage("NL_WIZ_ERROR_REQUIRED")), "siteName");
		}
		if (strlen($sitePhone) <= 0) {
			$this->SetError(str_replace("#FIELD_NAME#", GetMessage("NL_SITE_PHONE"), GetMessage("NL_WIZ_ERROR_REQUIRED")), "sitePhone");
		}
		if (strlen($siteEmail) <= 0) {
			$this->SetError(str_replace("#FIELD_NAME#", GetMessage("NL_SITE_EMAIL"), GetMessage("NL_WIZ_ERROR_REQUIRED")), "siteEmail");
		} elseif (!check_email($siteEmail)) {
			$this->SetError(str_replace("#FIELD_NAME#", GetMessage("NL_SITE_EMAIL"), GetMessage("NL_WIZ_ERROR_EMAIL")), "siteEmail");
		}
		if (strlen($shopEmail) > 0 && !check_email($shopEmail)) {
			$this->SetError(str_replace("#FIELD_NAME#", GetMessage("NL_SHOP_EMAIL"), GetMessage("NL_WIZ_ERROR_EMAIL")), "shopEmail");
		}
	}
}

class DataInstallStep extends CDataInstallWizardStep
{
    function CorrectServices(&$arServices)
    {

        $wizard =& $this->GetWizard();
        if($wizard->GetVar("installDemoData") != "Y")
        {
        }

        //$this->content .= GetMessage("NL_WIZ_SITE_DESCRITION").'<a href = "http://bitlate.ru/">'.'bitlate.ru'.'</a>';
    }
}

class FinishStep extends CFinishWizardStep
{
}
?>