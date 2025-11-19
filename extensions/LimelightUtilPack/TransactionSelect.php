<?php

namespace Extension\LimelightUtilPack;

use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Http;
use Application\Model\Campaign;
use Application\Model\Configuration;
use Application\Request;
use Application\Session;
use Exception;

class TransactionSelect
{

    public function __construct()
    {
        $this->currentStepId           = (int) Session::get('steps.current.id');
        $this->currentPageType         = Session::get('steps.current.pageType');
        $this->previousStepId          = Session::get('steps.previous.id');
        $this->crmType                 = Session::get('crmType');
        $this->config                  = Config::extensionsConfig('LimelightUtilPack');
        $this->configId                = Session::get('steps.current.configId');
        $this->enableTransactionSelect = $this->config['enable_transaction_select'];
        $this->campiagns               = $this->config['routing_campaigns'];
        $this->reason                  = $this->config['reason'];
        $this->enablePixelFire         = $this->config['enable_pixel_fire'];

        try
        {
            $this->configuration = new Configuration($this->configId);
            $this->crm           = $this->configuration->getCrm();
        } catch (Exception $ex) {

        }
    }

    public function switchCampaign()
    {
        if (
            CrmPayload::get('meta.isSplitOrder') === true ||
            Request::attributes()->get('action') === 'prospect' ||
            !$this->enableTransactionSelect ||
            $this->crmType != 'limelight' ||
            Session::has(sprintf('extensions.LimelightUtilPack.TransactionSelect.step_%d', $this->currentStepId))
        ) {

            return;
        }

        $response = CrmResponse::all();

        if (
            empty($response['errors']['crmError'])
        ) {
            return;
        }

        if (
            preg_match("/Prepaid.+Not Accepted/i", $response['errors']['crmError']) &&
            !empty($response['errors']['crmError'])
        ) {
            return;
        }

        Session::set(sprintf('extensions.LimelightUtilPack.TransactionSelect.step_%d', $this->currentStepId), true);

        if (empty($response['declineOrderId'])) {
            return;
        }

        $orderViewData = $this->orderView($response['declineOrderId']);

        if (
            !preg_match("/" . $this->reason . "/i", $orderViewData['decline_reason'])
        ) {
            return;
        }

        $campaignsData = preg_split("/\\r\\n|\\r|\\n/", $this->campiagns);

        foreach ($campaignsData as $key => $val) {
            $data = explode('|', $val);
            if ($this->currentStepId == $data[0]) {
                $cbCampaign = $data[1];
                $cInfo      = Campaign::find($cbCampaign);
                CrmPayload::set(
                    'campaignId', $cInfo['campaignId']
                );
                $changeCampaign = true;
                break;
            }
        }

        if (!$changeCampaign) {
            return;
        }

        $crmType  = $this->crm['crm_type'];
        $crmClass = sprintf(
            '\Application\Model\%s', $crmType
        );

        $crmInstance = new $crmClass($this->configuration->getCrmId());
        call_user_func_array(array($crmInstance, CrmPayload::get('meta.crmMethod')), array());

        $reorderResponse = CrmResponse::all();

        if ($reorderResponse['success'] && !$this->enablePixelFire) {
            Session::set('steps.meta.skipPixelFire', true);
        }

    }

    public function switchUpsellCampaign()
    {
        if (
            $this->currentStepId > 1 &&
            Session::has(sprintf('extensions.LimelightUtilPack.TransactionSelect.step_%d', $this->previousStepId))
        ) {

            $campaignsData = preg_split("/\\r\\n|\\r|\\n/", $this->campiagns);

            foreach ($campaignsData as $key => $val) {
                $data = explode('|', $val);
                if ($this->currentStepId == $data[0]) {
                    $cbCampaign = $data[1];
                    $cInfo      = Campaign::find($cbCampaign);
                    CrmPayload::set(
                        'campaignId', $cInfo['campaignId']
                    );
                    break;
                }
            }
        }
    }

    private function orderView($orderID)
    {
        $result   = array();
        $configId = Session::get('steps.current.configId');

        $this->curlPostData['order_id'] = $orderID;
        $this->curlPostData['method']   = 'order_view';
        $this->configuration            = new Configuration($configId);

        $crmInfo = $this->configuration->getCrm();

        $this->curlPostData['username'] = $crmInfo['username'];
        $this->curlPostData['password'] = $crmInfo['password'];

        $url                = $crmInfo['endpoint'] . "/admin/membership.php";
        $this->curlResponse = Http::post($url, http_build_query($this->curlPostData));

        parse_str($this->curlResponse, $result);
        if ($result['response_code'] == 100) {
            return $result;
        }
        return false;
    }

}
