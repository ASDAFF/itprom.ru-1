<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");

class SelectSiteStep extends CSelectSiteWizardStep{
	function InitStep(){
		parent::InitStep();

		$wizard =& $this->GetWizard();
		$wizard->solutionName = "webfly_santech";
		$this->SetNextStep("site_settings");
	}
}

class SiteSettingsStep extends CSiteSettingsWizardStep{
	function InitStep(){
		$this->SetStepID("site_settings");
		$wizard =& $this->GetWizard();
		$wizard->solutionName = "webfly_santech";
		parent::InitStep();
	}

	function ShowStep()
	{
		$wizard =& $this->GetWizard();

		$siteLogo = $wizard->GetVar("siteLogo", true);

		$this->content .= GetMessage("WF_INSTALL_UPDATE");

		$formName = $wizard->GetFormName();
		$installCaption = $this->GetNextCaption();
		$nextCaption = GetMessage("NEXT_BUTTON");
	}

	function OnPostForm()
	{
		$wizard =& $this->GetWizard();
	}
}
class DataInstallStep extends CDataInstallWizardStep
{
}
class FinishStep extends CFinishWizardStep
{
}
?>