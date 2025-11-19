<?php

namespace Extension\TrafficLoadBalancer;

use Application\Config;
use Application\Request;
use Application\Session;

class productScrapper
{

    public function __construct()
    {
        $this->pageType = Session::get('steps.current.pageType');
        $this->stepId   = Session::get('steps.current.id');
        $this->fileName = BASE_DIR . DS . 'storage/productOrderFilter';
    }

    public function scrapFlow()
    {
        if ($this->pageType == 'leadPage' || $this->pageType == 'thankyouPage') {
            return;
        }

        $enableProductOrderFilter = Config::extensionsConfig('TrafficLoadBalancer.enable_product_orderfilter');

        if (!$enableProductOrderFilter) {
            return;
        }

        if ($this->pageType == 'checkoutPage') {
            try
            {
                $fp       = fopen($this->fileName, 'r');
                $contents = fread($fp, filesize($this->fileName));
                fclose($fp);
                if ($contents) {
                    $contentsArray = json_decode($contents, true);
                    Session::set('extensions.trafficLoadBalancer.campaignData', $contentsArray);
                }
            } catch (Exception $ex) {
                throw ($ex);
            }

            $campaignData             = Config::extensionsConfig('TrafficLoadBalancer.product_orderfilter_configuration');
            $productOrderFilterMethod = Config::extensionsConfig('TrafficLoadBalancer.product_orderfilter_scrapping_method');
            if ($productOrderFilterMethod == 'flat') {
                $campaignData = Config::extensionsConfig('TrafficLoadBalancer.product_orderfilter_campaignid');
            }

            $configs = preg_split("/\\r\\n|\\r|\\n/", $campaignData);

            $formData = Request::form()->all();

            if (array_key_exists('campaigns', $formData)) {
                $formCampaign = $formData['campaigns'][1]['id'];
            }

            foreach ($configs as $val) {
                $productArray = array();
                if ($productOrderFilterMethod == 'flat') {
                    $campaignId = $val;
                } else {
                    $productData = explode('|', $val);
                    $campaignId  = $productData[0];
                }
                if (!empty($formCampaign) && $formCampaign == $campaignId) {
                    Session::set('extensions.trafficLoadBalancer.campaignMatch', true);
                    Session::set('extensions.trafficLoadBalancer.campaign', $campaignId);
                    break;
                }
            }

            $campaignMatch = Session::get('extensions.trafficLoadBalancer.campaignMatch');

            if (!$campaignMatch) {
                return;
            }

            $orderCount = Session::get('extensions.trafficLoadBalancer.campaignData');
            $campaign   = Session::get('extensions.trafficLoadBalancer.campaign');

            foreach ($orderCount as $key => $value) {
                if (array_key_exists($campaign, $value)) {
                    $data = $value[$campaign];
                    Session::set('extensions.trafficLoadBalancer.count', $data['count']);
                    if (in_array($data['count'], $data['random_numbers'])) {
                        Session::set('extensions.trafficLoadBalancer.orderFilter', true);
                        break;
                    }
                }
            }
        }

        $isScrap       = Session::get('extensions.trafficLoadBalancer.orderFilter');
        $campaignMatch = Session::get('extensions.trafficLoadBalancer.campaignMatch');

        if ($campaignMatch) {
            if ($isScrap) {
                Session::set('steps.meta.isScrapFlow', true);
                Session::set('extensions.trafficLoadBalancer.' . $this->stepId . '.scrapped', 0);
                Session::set('extensions.trafficLoadBalancer.' . $this->stepId . '.committed', 1);
            } else {
                Session::set('steps.meta.isScrapFlow', false);
                Session::set('extensions.trafficLoadBalancer.' . $this->stepId . '.scrapped', 0);
                Session::set('extensions.trafficLoadBalancer.' . $this->stepId . '.committed', 1);
            }
        }

    }

    public function incrementHit()
    {
        $enableProductOrderFilter = Config::extensionsConfig('TrafficLoadBalancer.enable_product_orderfilter');

        if (!$enableProductOrderFilter) {
            return;
        }

        if ($this->stepId == '2') {

            if (Session::has('extensions.trafficLoadBalancer.campaignData')) {
                $campaignData = Session::get('extensions.trafficLoadBalancer.campaignData');
                $campaign     = Session::get('extensions.trafficLoadBalancer.campaign');
                $count        = Session::get('extensions.trafficLoadBalancer.count');

                foreach ($campaignData as $key => $value) {
                    if (array_key_exists($campaign, $value)) {
                        $campaignData[$key][$campaign]['count'] = $count + 1;
                        if ($campaignData[$key][$campaign]['count'] > 100) {
                            $campaignData[$key][$campaign]['count'] = 1;
                        }
                        break;
                    }
                }

                $jsonData = json_encode($campaignData);

                $fp = fopen($this->fileName, 'r+');
                flock($fp, LOCK_EX);
                $contents = fread($fp, filesize($this->fileName));

                if ($contents) {
                    file_put_contents($this->fileName, $jsonData);
                }
            }
        }
    }

}
