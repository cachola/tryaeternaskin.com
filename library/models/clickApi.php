<?php

namespace Application\Model;

use Application\CrmPayload;
use Application\Config;
use Application\Http;
use Application\Session;
use Application\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Application\TmpLogger;

class clickApi
{
    private $endPoint;
    private $params;
    private $affiliates;
    private $accesor;
    private $campaignId;
    private $url;
    private $apiToken;
    private $funnelId;
    private $internalCampaignId;
    private $funnelOrigin ;
    public $totalProducts;
    public $mainAcceptPrepaid;

    public function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->totalProducts=0;
        $this->mainAcceptPrepaid=false;
        // $this->funnelId=env('FUNNEL_ID', 0);
        $this->funnelId='34';
        $this->funnelOrigin='Tryaeternaskin_sample';
        //   $this->campaignId = CrmPayload::get('campaignId');
        $dev=env('IS_DEV', false);
        $rem=env('FORCE_REMOTE_CLICK_SERVER', false);
        $cond=env('IS_DEV', false) && !env('FORCE_REMOTE_CLICK_SERVER', false);
        if (env('MOCK_SERVER', false) && !env('FORCE_REMOTE_CLICK_SERVER', false)) {
            $this->endPoint = 'http://clickapi.local';
            $this->apiToken = 'eyJpdiI6Imttbk5ybWJMVHMyUGVoOURVemhYTHc9PSIsInZhbHVlIjoiSFA0VG1DM0FNMFNiZWNjN1FUNkRoTm5OYUMzSXN4cjBId2lHRjI1aEl5QnRxUHE3WFRTRXM5NTdOS053eUY5dHdqeGlNdThnSkR2WTRpTkpRU0YyZVU3OE9hcjNwWHNLNXlaUWxVOHFMdnc9IiwibWFjIjoiMDE2Nzg2ZDAzMDg4ODVkZjIxMWRlNzJlMjQyOTJkMzhlOTA4MzFjMWMyMmRjYmEwN2EwYTMyZjI1YTgwZjM4MSJ9';
        } else {
            $this->endPoint = env('clickApiEndPoint', '');
            // $this->apiToken = env('clickApiToken', '');
            $this->apiToken ='eyJpdiI6InpPUURsZHBXUzZyeDVOTE9STnpRRXc9PSIsInZhbHVlIjoiS1Zjd0U2WkxSN3oxbHZqSU5nRHA4d1RqM1N4akgrXC8xZFJzYzBwTU8wYndwM2MwcVpHWUJjUXlscFNWdmVwZGlwcEJmMWcwbFBGNXJvMDlDKzNqRGY3bERvNUw1VkhBVGtJdnZWSVExUVlZPSIsIm1hYyI6IjM2NzQwNDIxNDYyYWVhOWU4MGZkMzUxNWY3OTY3YTdjNTEyOWU0Njk2MzMxMjkwN2IwOWI4N2FhYjBiMTk2YTQifQ==';
        }
    }

    public function buyClick()
    {
        if (! env('ENABLE_CLICK_API', false)) {
            return;
        }
        if (!Session::get('clickApi_sent')) {
            Session::set('clickApi_sent', true);
            $this->beforeAnyCrmClassMethodCall();
            // $this->params = array_replace($this->params, CrmPayload::all());
            $this->affiliates =  array_replace($this->payload, Session::get('affiliates'));
            $this->campaignId = CrmPayload::get('campaignId');
            $this->prepareParams();
            $this->url = $this->endPoint . '/api/v1/clicks';
            $resp = $this->httpSend('POST');
            Tmplogger::logdev('requests', print_r($resp, true));
          
            //test
            $scrap_allways=false;
            Session::set('api_click_id', $resp['api_click_id'], true);
            Session::set('isScrapFlow', $resp['no_cred' ] || $scrap_allways);
            // Session::set('user_has_prepaid_card',  $resp['no_cred' ] || $scrap_allways);
      
            Session::set('clickApi_campaign', $this->getCampaign());
            if (Session::get('isScrapFlow')) {
                Session::set('int_campaign_id', $resp['int_campaign_id']);
            } else {
                Session::set('int_campaign_id', 0);
            }
        }
        $this->switchAffiliates();
    }

    public function test($iterations)
    {
        for ($i = 0; $i < $iterations; $i++) {
            # code...
            $this->buyClick();
            $this->convertClick();
            Session::set('clickApi_sent', false);
        }
    }
    public function convertClick($order_id=null, $convert_at=null)
    {
        if (Session::get('clickApi_sent')) {
            $this->campaignId = Session::get('clickApi_campaign');
            $this->beforeAnyCrmClassMethodCall();
            $click =  strval(Session::get('api_click_id'));
            $upFields = array();
            $upFields['no_cred'] = Session::get('isScrapFlow')? 1 : 0;
            $upFields['amount'] = $this->totalProducts;
            $upFields['api_token'] = $this->apiToken;
            $upFields['order_id'] = $order_id;
            $upFields['convert_at'] = $convert_at;
            $this->params = array_replace($this->params, $upFields);
            $this->url = $this->endPoint . '/api/v1/clicks/convert/' . $click;
            $resp = $this->httpSend('POST');
        }
    }
    public function sendEclick()
    {
        if (Session::get('clickApi_sent')) {
            $this->beforeAnyCrmClassMethodCall();
            $click =  strval(Session::get('api_click_id'));
            $upFields = array();
            $upFields['e_click'] = $_SESSION['tidSession'];
            $upFields['api_token'] = $this->apiToken;
            $this->params = array_replace($this->params, $upFields);
            $this->url = $this->endPoint . '/api/v1/clicks/updateclick/' . $click;
            $resp = $this->httpSend('POST');
        }
    }
    public function prepareParams()
    {
        $affiliates = $this->affiliates;
        $affiliates = $affiliates == null ?  array() : $affiliates;
        $prepParams = array_filter(array(
            'api_token' => $this->apiToken,
            'funnel_id' => (int) $this->funnelId ,
            'campaign_id' => (int) $this->campaignId,
            'querystring' => http_build_query(Session::get('queryParams', '')),
            'request_uri' => $this->requestUrl(),
            'client_ip' => '192.168.50.2', //Request::getClientIp(),
            'funnel_origin' => $this->funnelOrigin,
            'referer' =>$_SESSION['httpReferer'],
            'user_agent' => $_SESSION['httpUserAgent'],
        ));
        $this->params = array_replace($this->params, $prepParams);
    }
    public function requestUrl()
    {
        $http = 'http';
        if (isset($_SERVER['HTTPS'])) {
            $http = 'https';
        }
        $host = $_SERVER['HTTP_HOST'];
        $requestUri = $_SERVER['REQUEST_URI'];
        return $http . '://' .$host .  $requestUri;
    }
    private function httpSend($method)
    {
        $opt=array();
     

        if (env('IS_DEV', false)) {
            $opt=array(
                    CURLOPT_CONNECTTIMEOUT => 30,
                    CURLOPT_TIMEOUT => 30);
        } else {
            $opt=array(
                    CURLOPT_CONNECTTIMEOUT => 5,
                    CURLOPT_TIMEOUT => 5);
        }
        $response = Http::customRequest($this->url, $this->params, array('Accept: application/json'), $method, $opt);
        $resp = json_decode($response, true);
        return $resp;
    }

    protected function beforeAnyCrmClassMethodCall()
    {
        $this->params = $this->response = $this->payload = array();
    }


    private function switchAffiliates()
    {
        if (Session::get('clickApi_sent')) {
            if (Session::get('isScrapFlow') === true) {
                $affiliates          = array();
                $extensionAffiliates = array();
                $affiliates          = CrmPayload::get('affiliates');
                foreach ($affiliates as $key => $value) {
                    $extensionAffiliates[$key] = Config::extensionsConfig(
                        'CbUtilityPackage.scrap_' . $key
                    );
                }
                if (isset($extensionAffiliates['afId'])) {
                    $extensionAffiliates['AFID'] = $extensionAffiliates['afId'];
                }
                if (isset($extensionAffiliates['sId'])) {
                    $extensionAffiliates['SID'] = $extensionAffiliates['sId'];
                }
                CrmPayload::update(array('affiliates' => $extensionAffiliates));
            }
        }
    }

    public function getCampaign($getNormalCampaign=false, $currentStepid=0)
    {
        // $configId = Session::get('steps.current.configId');
        // $config = Config::configurations(sprintf('%d', $configId));
        // $campaign = Config::campaigns(sprintf('%d', $config['campaign_ids'][0]));
        // $this->campaignId = CrmPayload::get('campaignId');

        $this->campaignId = 950;
        if (!$getNormalCampaign) {
            // if (env('ENABLE_CLICK_API', false)) {
            switch ($currentStepid) {
                    // case '2':
                    //                     if (Session::get('isScrapFlow') === true) {
                    //                         $this->campaignId = 655;
                    //                     } elseif (Session::get('steps.meta.isPrepaidFlow') === true && !$this->mainAcceptPrepaid) {
                    //                         $this->campaignId = 654;
                    //                     } else {
                    //                         $this->campaignId = 653;
                    //                     }

                    //                    break;
                    // case '3':
                    //      $this->campaignId = 656;
                    // case '4':
                    //      $this->campaignId = 656;
                    // case '99':
                    //      $this->campaignId = 656;                        
                    //                    break;

                    
                    default:
                                        if (Session::get('isScrapFlow') === true) {
                                            $this->campaignId = 952;
                                        } elseif (Session::get('steps.meta.isPrepaidFlow') === true && !$this->mainAcceptPrepaid) {
                                            $this->campaignId = 951;
                                        }
               
                        break;
                }
            // }
        }
        return $this->campaignId;
    }
}
