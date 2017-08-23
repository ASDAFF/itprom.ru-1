<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");

class SelectSiteStep extends CSelectSiteWizardStep
{
	function InitStep()
	{
		parent::InitStep();

		$wizard =& $this->GetWizard();
		$wizard->solutionName = "webfly_santech";
	}
}


class SelectTemplateStep extends CSelectTemplateWizardStep
{
  
}

class SelectThemeStep extends CSelectThemeWizardStep{
  function InitStep(){
    parent::InitStep();
  }
  function ShowStep(){
    $this->content = GetMessage("WF_THEMES_NO");
  }
  function OnPostForm(){
    return true;
  }
}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
	function InitStep()
	{
    $this->SetStepID("site_settings");
		$wizard =& $this->GetWizard();
		$wizard->solutionName = "webfly_santech";
		parent::InitStep();

		$templateID = $wizard->GetVar("templateID");
    $themeID = $wizard->GetVar($templateID."_themeID");

		$wizard->SetDefaultVars(
			Array(
			  "siteCopy" => $this->GetFileContent(WIZARD_SITE_PATH."include/copyright.php", GetMessage("WF_COMPANY_COPY")),
				"siteMetaDescription" => GetMessage("WF_SITE_DESC"),
				"siteMetaKeywords" => GetMessage("WF_SITE_KEYWORDS"),  
			)
		);
	}

	function ShowStep()
	{
		$wizard =& $this->GetWizard();
				
		$siteLogo = $wizard->GetVar("siteLogo", true);

		$this->content .= '<table width="100%" cellspacing="0" cellpadding="0">';

		$this->content .= '<tr><td>';
		$this->content .= '<label for="site-copy">'.GetMessage("WF_COMPANY_COPY2").'</label><br />';
		$this->content .= $this->ShowInputField("textarea", "siteCopy", Array("id" => "site-copy", "style" => "width:100%", "rows"=>"3"));
		$this->content .= '</tr></td>';

		$this->content .= '<tr><td><br /></td></tr>';

		$firstStep = COption::GetOptionString("main", "wizard_first" . substr($wizard->GetID(), 7)  . "_" . $wizard->GetVar("siteID"), false, $wizard->GetVar("siteID")); 

		$styleMeta = 'style="display:block"';
		if($firstStep == "Y") $styleMeta = 'style="display:none"';
		
		$this->content .= '<tr><td><br /></td></tr>';
		$this->content .= '<tr><td>
		<div  id="bx_metadata" '.$styleMeta.'>
			<div class="wizard-input-form-block">
				<h4 style="margin-top:0"><label for="siteMetaDescription">'.GetMessage("WF_METADATA").'</label></h4>
				<label for="siteMetaDescription">'.GetMessage("WF_METADESC").'</label>
				<div class="wizard-input-form-block-content" style="margin-top:7px;">
					<div class="wizard-input-form-field wizard-input-form-field-textarea">'.
						$this->ShowInputField("textarea", "siteMetaDescription", Array("id" => "siteMetaDescription", "style" => "width:100%", "rows"=>"3")).'</div>
				</div>
			</div>';
			$this->content .= '
			<div class="wizard-input-form-block">
				<label for="siteMetaKeywords">'.GetMessage("WF_KEYWORDS2").'</label><br>
				<div class="wizard-input-form-block-content" style="margin-top:7px;">
					<div class="wizard-input-form-field wizard-input-form-field-text">'.
						$this->ShowInputField('text', 'siteMetaKeywords', array("id" => "siteMetaKeywords", "style" => "background-color:#fff;width:100% !important")).'</div>
				</div>
			</div>
		</div>';
		
		if($firstStep == "Y")
		{
			$this->content .= '<tr><td style="padding-bottom:3px;">';
			$this->content .= $this->ShowCheckboxField("installDemoData", "Y", 
				(array("id" => "install-demo-data", "onClick" => "if(this.checked == true){document.getElementById('bx_metadata').style.display='block';}else{document.getElementById('bx_metadata').style.display='none';}")));
			$this->content .= '<label for="install-demo-data">'.GetMessage("WF_INSTALL_DEMODATA").'</label><br />';
			$this->content .= '</td></tr>';
			
			$this->content .= '<tr><td>&nbsp;</td></tr>';
		}
		else
		{
			$this->content .= $this->ShowHiddenField("installDemoData","Y");
		}
		
		$this->content .= '</table>';

		$formName = $wizard->GetFormName();
		$installCaption = $this->GetNextCaption();
		$nextCaption = GetMessage("NEXT_BUTTON");
	}

	function OnPostForm()
	{
		$wizard =& $this->GetWizard();
//		COption::SetOptionString("main", "wizard_site_logo", $res, "", $wizard->GetVar("siteID"));
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
	}
}

class FinishStep extends CFinishWizardStep
{
}
?>