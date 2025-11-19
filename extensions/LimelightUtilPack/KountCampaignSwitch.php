<?php

namespace Extension\LimelightUtilPack;

use Application\Config;
use Application\Session;
use Application\Model\Configuration;
use Application\Model\Campaign;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Request;

class KountCampaignSwitch
{

    protected $curlResponse, $curlPostData = array();
    public $kountConfig;

    public function __construct()
    {
        $this->currentStep = (int) Session::get('steps.current.id');
        $this->pageType = Session::get('steps.current.pageType');
        $this->crmType = Session::get('crmType');
        $this->activate = Config::extensionsConfig('LimelightUtilPack.membership_service');
        $this->kountConfig = Config::extensionsConfig('LimelightUtilPack');
    }

    public function processScreeningOrder()
    {
        if (
                empty($this->kountConfig['enable_screeningbased_campaign_switch']) 
                || 
                $this->pageType == "leadpage"
                ||
                Session::has('screenBasedCampaignSwitch')
            )
        {
            return;
        }

        $crmResponse = CrmResponse::all();

        if ($crmResponse['success'])
        {
            return;
        }

        Session::set('screenBasedCampaignSwitch', true);
        $this->screenBasedCampaignSwitch();
        $this->placeNewOrder();
    }

    private function screenBasedCampaignSwitch()
    {
        $screeningBasedMainCampaigns = preg_split("/\\r\\n|\\r|\\n/", $this->kountConfig['screening_based_main_campaigns']);
        if (!empty($screeningBasedMainCampaigns[0]))
        {
            $this->switchCampign($screeningBasedMainCampaigns);
        }
    }

    private function switchCampign($param)
    {
        foreach ($param as $mainCampaignsVal)
        {
            $mainCampaignData = explode("|", $mainCampaignsVal);
            $mainCampaignInfo[$mainCampaignData[0]] = $mainCampaignData[1];
        }

        if (!empty($mainCampaignInfo[$this->currentStep]))
        {
            $camID = $mainCampaignInfo[$this->currentStep];
            $cInfo = Campaign::find($camID);
            CrmPayload::set(
                    'campaignId', $cInfo['campaignId']
            );
            Session::set('steps.meta.skipPixelFire', true);
        }
    }

    public function switchSplitCampign()
    {
        if (!empty($this->kountConfig['enable_screeningbased_campaign_switch']) && Session::has('screenBasedCampaignSwitch'))
        {
            $screeningBasedSplitCampaigns = preg_split("/\\r\\n|\\r|\\n/", $this->kountConfig['screening_based_split_campaigns']);
            if (!empty($screeningBasedSplitCampaigns[0]))
            {
                $this->switchCampign($screeningBasedSplitCampaigns);
            }
        }
    }

    public function processScreeningUpsell()
    {
        if (!empty($this->kountConfig['enable_screeningbased_campaign_switch']) && Request::attributes()->get('action') == "upsell" && Session::has('screenBasedCampaignSwitch'))
        {
            $screeningBasedUpsellCampaigns = preg_split("/\\r\\n|\\r|\\n/", $this->kountConfig['screening_based_main_campaigns']);
            if (!empty($screeningBasedUpsellCampaigns[0]))
            {
                $this->switchCampign($screeningBasedUpsellCampaigns);
            }
        }
    }

    private function placeNewOrder()
    {
        $configuration = new Configuration(CrmPayload::get('meta.configId'));
        $crmId = $configuration->getCrmId();
        $crm = $configuration->getCrm();
        $crmType = $crm['crm_type'];
        $crmClass = sprintf(
                '\Application\Model\%s', ucfirst($crmType)
        );
        $crmInstance = new $crmClass($crmId);

        call_user_func_array(array($crmInstance, CrmPayload::get('meta.crmMethod')), array());
      
    }

}
