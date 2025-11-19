<?php

namespace Application\Model;

use Application\Config;
use Application\Http;
use Application\Logger;
use Application\Request;
use Application\Session;
use Detection\MobileDetect;

class Pixel
{

    private $previousStepId, $currentStepId, $previousConfigId, $currentConfigId;
    private $currentStepPixels;

    public function __construct()
    {
        $this->currentStepPixels = array();
        $this->currentStepId     = (int) Session::get('steps.current.id');
        $this->currentConfigId   = (int) Session::get('steps.current.configId');
        if (Session::has('steps.previous.configId') !== true) {
            $this->previousConfigId = (int) Session::get('steps.current.configId');
        }
        else
        {
            $this->previousConfigId = (int) Session::get('steps.previous.configId');
        }
        $this->previousStepId   = (int) Session::get('steps.previous.id');
        
        $this->loadPixelsByConfigId($this->previousConfigId);
    }

    public function getHeadPixelsAsHtml()
    {
        $headPixelsHtml = '';
        foreach ($this->currentStepPixels as $pixel) {
            if ($pixel['pixel_placement'] !== 'head') {
                continue;
            }
            $headPixelsHtml .= $this->parsePixel($pixel);
        }
        return $headPixelsHtml;
    }

    public function getTopPixelsAsHtml()
    {
        $topPixelsHtml = '';
        foreach ($this->currentStepPixels as $pixel) {
            if ($pixel['pixel_placement'] !== 'top') {
                continue;
            }
            $topPixelsHtml .= $this->parsePixel($pixel);
        }
        return $topPixelsHtml;
    }

    public function getBottomPixelsAsHtml()
    {
        $bottomPixelsHtml = '';
        foreach ($this->currentStepPixels as $pixel) {
            if ($pixel['pixel_placement'] !== 'bottom') {
                continue;
            }
            $bottomPixelsHtml .= $this->parsePixel($pixel);
        }
        return $bottomPixelsHtml;
    }
    
    public function setClickID()
    {

        if (Session::get('pixels.clickIdGenerated') === true) {
            return;
        }

        $this->loadPixelsByConfigId($this->currentConfigId);

        foreach ($this->currentStepPixels as $pixel) {
            if ($this->isValidDevice($pixel) === false) {
                continue;
            }

            if ($this->isValidAffiliates($pixel) === false) {
                continue;
            }

            if (!empty($pixel['click_pixel'])) {
                $clickId = $this->getClickID($pixel['click_pixel']);
                if (!empty($clickId)) {
                    Session::set('affiliates.clickId', $clickId);
                    Session::set('queryParams.click_id', $clickId);
                    Session::set('pixels.clickIdGenerated', true);
                }
            }

        }
    }

    public function hasClickPixels()
    {
        $this->loadPixelsByConfigId($this->currentConfigId);
        foreach ($this->currentStepPixels as $pixel) {
            if (!empty($pixel['click_pixel'])) {
                return true;
            }
        }
    }

    private function loadPixelsByConfigId($configId)
    {
        $this->currentStepPixels = array();
        $pixels                  = Config::pixels();
        foreach ($pixels as $pixel) {
            if ($pixel['configuration_id'] === $configId) {
                array_push($this->currentStepPixels, $pixel);
            }
        }
    }

    private function parsePixel($pixel)
    {
        if ($this->pixelTriggers($pixel) === false) {
            return '';
        }      

        switch ($pixel['pixel_type']) {

            case 'HTML':
                return $this->parseHtmlPixel($pixel);

            case 'Postback':
                return $this->parsePostbackPixel($pixel);

            case 'Postback + 3rd Party Pixels':
                return $this->parsePostback3rdPartyPixel($pixel);

            case 'Cake Postback':
                return $this->parseCakePostbackPixel($pixel);

            case 'Cake Postback + 3rd Party Pixels':
                return $this->parseCakePostback3rdPartyPixel($pixel);

            case 'HasOffers Postback':
                return $this->parseHasOffersPostbackPixel($pixel);

            case 'HasOffers Postback + 3rd Party Pixels':
                return $this->parseHasOffersPostback3rdPartyPixel($pixel);

            case 'HitPath Postback':
                return $this->parseHitPathPostbackPixel($pixel);

            case 'HitPath Postback + 3rd Party Pixels':
                return $this->parseHasOffersPostback3rdPartyPixel($pixel);
                
            case 'General':
                return $this->parseHtmlPixel($pixel);
                
            case 'Decline':
                return $this->parseHtmlPixel($pixel);
                
            case 'Submission':
                return $this->parseHtmlPixel($pixel);
        }
    }

    protected function parseHitPathPostback3rdPartyPixels($pixel)
    {
        $url = $this->parseTokens($pixel['convert_pixel']);
        $this->doPostBack($url);

        if (!empty($pixel['third_party_postback_url'])) {
            $url = $this->parseTokens(trim($pixel['third_party_postback_url']));
            $this->doPostBack($url);
        }

        if (!empty($pixel['third_party_html'])) {
            return $this->parseTokens(trim($pixel['third_party_html']));
        }
    }

    protected function parseHitPathPostbackPixel($pixel)
    {
        $url = $this->parseTokens($pixel['convert_pixel']);
        $this->doPostBack($url);
        return sprintf(
            '<!-- HitPath Postback Triggered%s%s%s/HitPath Postback Triggered -->',
            PHP_EOL, $url, PHP_EOL
        );
    }

    protected function parseHasOffersPostback3rdPartyPixel($pixel)
    {
        $url = $this->parseTokens($pixel['convert_pixel']);
        $this->doPostBack($url);

        if (!empty($pixel['third_party_postback_url'])) {
            $url = $this->parseTokens($trim($pixel['third_party_postback_url']));
            $this->doPostBack($url);
        }

        if (!empty($pixel['third_party_html'])) {
            return $this->parseTokens(trim($pixel['third_party_html']));
        }
    }

    protected function parseHasOffersPostbackPixel($pixel)
    {
        $url = $this->parseTokens($pixel['convert_pixel']);
        $this->doPostBack($url);
        return sprintf(
            '<!-- HasOffers Postback Triggered%s%s%s/HasOffers Postback Triggered -->',
            PHP_EOL, $url, PHP_EOL
        );
    }

    protected function parseCakePostback3rdPartyPixel($pixel)
    {
        if (!empty($pixel['convert_pixel'])) {
            $url = $this->parseTokens(trim($pixel['convert_pixel']));
            $this->doPostBack($url);
        }
        if (!empty($pixel['third_party_postback_url'])) {
            $url = $this->parseTokens(trim($pixel['third_party_postback_url']));
            $this->doPostBack($url);
        }
        if (!empty($pixel['third_party_html'])) {
            return $this->parseTokens(trim($pixel['third_party_html']));
        }
    }

    protected function parseCakePostbackPixel($pixel)
    {
        $url = $this->parseTokens($pixel['convert_pixel']);
        $this->doPostBack($url);
        return sprintf(
            '<!-- Cake Postback Triggered%s%s%s/Cake Postback Triggered -->',
            PHP_EOL, $url, PHP_EOL
        );
    }

    protected function parsePostback3rdPartyPixel($pixel)
    {
        if (!empty($pixel['postback_url'])) {
            $url = $this->parseTokens(trim($pixel['postback_url']));
            $this->doPostBack($url);
        }

        if (!empty($pixel['third_party_postback_url'])) {
            $url = $this->parseTokens(trim($pixel['third_party_postback_url']));
            $this->doPostBack($url);
        }

        if (!empty($pixel['third_party_html'])) {
            return $this->parseTokens(trim($pixel['third_party_html']));
        }

        return '';
    }

    protected function parsePostbackPixel($pixel)
    {
        $url = $this->parseTokens($pixel['postback_url']);
        $this->doPostBack($url);
        return '';
    }

    protected function parseHtmlPixel($pixel)
    {
        return $this->parseTokens($pixel['html_pixel']);
    }

    protected function htmlPixel($pixelHtml)
    {
        return sprintf('<img src="%s" style="display: none">', $pixelHtml);
    }

    private function parseTokens($stringWithTokens)
    {
        return preg_replace_callback(
            "/\{([a-z0-9_]+)\}/i", function ($data) {

                if ($data[1] === 'order_id' || $data[1] === 'orderId') {
                    return Session::get(
                        sprintf('steps.%d.orderId', $this->previousStepId)
                    );
                }
                
                if ($data[1] === 'order_total' || $data[1] === 'orderTotal') {
                    $orderTotal = $this->getOrderTotal();
                    return $orderTotal;
                }
                
                $formData = array(
                    'firstName',
                    'lastName',
                    'email',
                    'phone',
                    'shippingCity',
                    'shippingState',
                    'shippingCountry'
                );
                
                foreach($formData as $formTokens) {
                    if ($data[1] === $formTokens) {
                        return Session::get(
                            sprintf('customer.%s', $formTokens)
                        );
                    }
                }
                
                if ($data[1] === 'campaign_id' || $data[1] === 'campaignId') {
                	$products = Session::get(
			                        sprintf('steps.%d.products', $this->previousStepId)
			                    );
                    return $products[0]['campaignId'];
                }

                if ($data[1] === 'card_type' || $data[1] === 'cardType') {
                	return Session::get('customer.cardType');
                }

                $param = strtolower(str_replace('_', '', $data[1]));

                $affiliates = array_change_key_case(Session::get('affiliates'));

                foreach ($affiliates as $key => $value) {
                    if ($param === $key) {
                        return $value;
                    }
                }

            }, $stringWithTokens
        );
    }
    
    private function getOrderTotal()
    {
        $products = Session::get(
                sprintf('steps.%d.products', $this->previousStepId)
            );
        $orderTotal = 0.00;
        
        if(!empty($products)) 
        {
            foreach ($products as $value)
            {
                $orderTotal += ($value['productPrice'] * $value['productQuantity']) + $value['shippingPrice'];
            }
        }
        
        return $orderTotal;
    }

    protected function doPostBack($postbackUrl)
    {
        $response = Http::get(
            $postbackUrl, array(), array(CURLOPT_CONNECTTIMEOUT => 5)
        );
        if (DEV_MODE) {
            Logger::write('postBack', $response);
        }
        if (!empty($response['curlError'])) {
            return '';
        }
        return $response;
    }
    
    protected function getClickID($url)
    {
        $response = $this->doPostBack($this->parseTokens($url));
        if (!empty($response['curlError'])) {
            return '';
        }

        $data = explode('=', $response);
        if (!empty($data) && is_array($data) && !empty($data[1])) {
            return $data[1];
        }

        return '';
    }

    protected function pixelTriggers($pixel)
    {
        if(Session::has(sprintf('extensions.delayedTransactions.steps.%d.main',$this->previousStepId)) && $pixel['pixel_type'] != 'General')
        {
            return false;
        }
        
        if (Session::has(
                sprintf('steps.%d.pending', $this->previousStepId)
            )) 
        {
            return false;
        }
        
        if (Session::get(sprintf('steps.meta.skipPixelFire')) === true && $pixel['pixel_type'] != 'General') {
            return false;
        }
        
        $isValidDevice = $this->isValidDevice($pixel);
        
        if(
            $pixel['pixel_type'] == 'Submission' && 
            $isValidDevice && 
            !Session::get('steps.meta.isPrepaidFlow') && 
            !Session::get('steps.meta.isScrapFlow') 
            )
        {
            Session::set(
                sprintf(
                    'submissionPixels.pixel.%d.%s',
                    $pixel['id'], $pixel['pixel_placement']
                ), $pixel['html_pixel']
            );
        }

        if (
            !Session::has(
                sprintf('steps.%d.orderId', $this->previousStepId)
            )
                && 
                $pixel['pixel_type'] != 'General'
                && 
                $pixel['pixel_type'] != 'Decline'
        ) {
            return false;
        }

        if (
            Session::get(
                sprintf(
                    'pixels.fireStatus.%d.%d',
                    $this->previousConfigId, $pixel['id']
                )
            ) === true
                && 
                $pixel['pixel_type'] != 'General'
                && 
                $pixel['pixel_type'] != 'Decline'
        ) {
            return false;
        }

        if (
            $pixel['prepaid'] === false &&
            Session::get('steps.meta.isPrepaidFlow') === true  && 
            $pixel['pixel_type'] != 'General'
        ) {
            return false;
        }

        if (
            Session::get('steps.meta.isScrapFlow') === true  && 
            $pixel['pixel_type'] != 'General'
        ) {
            return false;
        }

        if (false === $this->isValidAffiliates($pixel)) {
            return false;
        }

        if (
            !empty($pixel['page']) &&
            basename(
                Request::server()->get('SCRIPT_NAME')
            ) !== basename($pixel['page'])
        ) {
            return false;
        }

        if ($isValidDevice && $pixel['pixel_type'] != 'General' && $pixel['pixel_type'] != 'Decline') {
            Session::set(
                sprintf(
                    'pixels.fireStatus.%d.%d',
                    $this->previousConfigId, $pixel['id']
                ), true
            );
            return true;
        }
        
        if (
            Session::get(
                sprintf(
                    'generalPixels.fireStatus.%d',
                    $pixel['id']
                )
            ) === true
                && $pixel['pixel_type'] == 'General'
        ) {
            return false;
        }
        
        if($pixel['pixel_type'] == 'General' && $isValidDevice)
        {
            if(!empty($pixel['multi_fire'])){
                return true;
            }else{
                Session::set(
                    sprintf(
                        'generalPixels.fireStatus.%d',
                        $pixel['id']
                    ), true
                );
                return true;
            }
            
        }
        
        if($pixel['pixel_type'] == 'Decline' && $isValidDevice)
        {
            Session::set(
                sprintf(
                    'declinePixels.pixel.%d.%s',
                    $pixel['id'], $pixel['pixel_placement']
                ), $pixel['html_pixel']
            );
           
            return false;
        }
        
        return false;
    }

    private function isValidAffiliates($pixel)
    {
        if ($affiliate = json_decode($pixel['affiliate_id'], true)) {
            if (
                !empty($affiliate['value']) &&
                Session::get(
                    sprintf('affiliates.%s', $affiliate['key'])
                ) !== $affiliate['value']
            ) {
                return false;
            }
        }

        if ($subAffiliate = json_decode($pixel['sub_id'], true)) {
            if (
                !empty($affiliate['value']) &&
                Session::get(
                    sprintf('affiliates.%s', $subAffiliate['key'])
                ) !== $subAffiliate['value']
            ) {
                return false;
            }
        }

        return true;
    }

    private function isValidDevice($pixel)
    {

        if ($devices = json_decode($pixel['device'], true)) {

            if (!in_array('all', $devices)) {

                $detect = new MobileDetect();

                $ua  = '';
                $oss = json_decode($pixel['os'], true);
                $oss = is_array($oss) && !in_array('All', $oss) ? $oss : array();

                if ($detect->isMobile() && !$detect->isTablet()) {
                    $ua = 'mobile';
                }

                if ($detect->isTablet()) {
                    $ua = 'tablet';
                }

                if (!$detect->isMobile() && !$detect->isTablet()) {
                    $ua = 'desktop';
                }

                if ($detect->isAndroidOS() && in_array('AndroidOS', $oss)) {
                    $ua = 'AndroidOS';
                }

                if ($detect->isIphone() && in_array('iOS', $oss)) {
                    $ua = 'iOS';
                }

                if (!in_array($ua, array_merge($devices, $oss))) {
                    return false;
                }
            }
        }

        return true;
    }

}
