<?php

namespace Extension\LimelightUtilPack;

use Application\Config;
use Application\CrmPayload;
use Application\Request;
use Application\Session;

class ExtraSources
{

    public function addParams()
    {
        if (Session::get('crmType', 'unknown') !== 'limelight') {
            return;
        }
        
        $extraSourceKeysString = Config::extensionsConfig(
            'LimelightUtilPack.extra_source_keys'
        );

        if (empty($extraSourceKeysString)) {
            return;
        }

        $extraSourceKeys = array_filter(array_map(function ($value) {
            return trim($value);
        }, explode(',', $extraSourceKeysString)));

        if (empty($extraSourceKeys) || !is_array($extraSourceKeys)) {
            return;
        }

        $extraAffiliateParams = array();
        foreach ($extraSourceKeys as $extraSourceKey) {
            $extraAffiliateParams[$extraSourceKey] = Request::query()
                ->get($extraSourceKey);
        }
        $extraAffiliateParams = array_filter($extraAffiliateParams);

        foreach ($extraAffiliateParams as $key => $value) {
            Session::set(sprintf('affiliates.%s', $key), $value);
        }

    }

    public function pushParams()
    {
        $affiliates = CrmPayload::get('affiliates');

        if (empty($affiliates) || !is_array($affiliates)) {
            $affiliates = array();
        }

        unset(
            $affiliates['affId'], $affiliates['c1'], $affiliates['c2'],
            $affiliates['c3'], $affiliates['c4'], $affiliates['c5']
        );

        $affiliates = array_filter($affiliates);

        foreach ($affiliates as $key => $value) {
            CrmPayload::set($key, $value);
        }
    }
    
    public function addExtraParams()
    {
        if (
                Session::get('crmType') !== 'limelight' ||
                Request::attributes()->get('action') === 'prospect'
        )
        {
            return;
        } 
        
        $queryParams = Session::get('queryParams');
        $customParams = array(
                            'conversion_id' => 'conversion_id',
                            'aic'           => 'referrer_id'
                        );

        if(!empty($queryParams))
        {
            foreach ($customParams as $key => $value)
            {
                if(array_key_exists($key, $queryParams) && !empty($queryParams[$key]))
                {
                    CrmPayload::set($value, $queryParams[$key]);
                }
            }
        }
        
        $formPayload = Request::form()->all();
        $extraParams = array('force_subscription_cycle', 'recurring_days');
        if(!empty($formPayload))
        {
            foreach ($extraParams as $value)
            {
                if(isset($formPayload[$value]))
                {
                    CrmPayload::set($value, $formPayload[$value]);
                }
            }
        }
    }

    public function updateCampaign()
    {
        if (
                Session::get('crmType') !== 'limelight' ||
                Session::get('steps.current.id') > 1
        )
        {
            return;
        } 

        $enableCampaignOverride = Config::extensionsConfig(
            'LimelightUtilPack.enable_campaign_override'
        );

        if(!$enableCampaignOverride)
        {
            return;
        }
        
        if(Session::has('queryParams.prospect_id') && !Session::has('campaign_override')){
            $member = new Membership;
            $params['prospect_id'] = Session::get('queryParams.prospect_id');
            $pdata = $member->viewProspect($params);

            if(!empty($pdata['campaign_id']))
            {
                CrmPayload::set('campaignId', $pdata['campaign_id']);
                CrmPayload::set('prospectId', $params['prospect_id']);
                CrmPayload::set('meta.crmMethod', 'newOrderWithProspect');
                Session::set('campaign_override', true);
            }
        }

    }

}
