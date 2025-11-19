<?php

namespace Extension\CbUtilityPackage;

use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Session;
use Application\Model\Configuration;

class PreserveGateway extends Common
{
    public function __construct()
    {
        parent::__construct();
        $this->preserveGatewayUpsells = Config::extensionsConfig('CbUtilityPackage.preserve_gateway_upsells');
        $this->upsellSteps            = Config::extensionsConfig('CbUtilityPackage.upsell_steps');
        try{
            $this->configuration = new Configuration();
        }
        catch (Exception $ex){
            
        }
    }

    public function preserveUpsellGateways()
    {
        $preserveSteps = explode(',', $this->upsellSteps);
        if (empty($this->preserveGatewayUpsells) || !in_array($this->currentStepId, $preserveSteps)) {
            return;
        }
        
        $gatewayId = Session::get('steps.1.gatewayId');
        
        if (empty($gatewayId)) {
            $this->getGatewayId();
        }

        CrmPayload::set('forceGatewayId', Session::get('steps.1.gatewayId'));
        CrmPayload::set('preserveGateway', 1);
    }
    
    public function getGatewayId() {
        if($this->configuration->getCrmType() != 'konnektive') {
            return;
        }
        CrmPayload::set('orderId', Session::get('steps.1.orderId'));
        $crmClass = sprintf(
                '\Application\Model\%s', ucfirst($this->configuration->getCrmType())
        );
        $crmInstance = new $crmClass($this->configuration->getCrm()['id']);

        call_user_func(array($crmInstance, 'transactionQuery'));

        Session::set('gateway_info_payload', CrmPayload::all());
        Session::set('gateway_info_response', CrmResponse::all());

        if (CrmResponse::has('success') && CrmResponse::get('transactionInfo')) {
            $crmResponse = CrmResponse::all();
            foreach ($crmResponse as $key => $value) {
                if ($key === 'success') {
                    continue;
                }
                $gID = trim($crmResponse['transactionInfo']['data'][0]['merchantId']);
                Session::set('steps.1.gatewayId', $gID);
            }
        }
    }

}