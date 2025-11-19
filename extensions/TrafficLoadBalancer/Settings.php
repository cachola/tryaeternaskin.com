<?php

namespace Extension\TrafficLoadBalancer;

use Application\Config;
use Application\Http;
use Application\Registry;
use Application\Request;
use Application\Session;
use Lazer\Classes\Database;

class Settings
{

    private function __construct()
    {
        return;
    }

    public static function getLocal()
    {
        $percentage    = array(1 => 0, 2 => 0);
        $percentage[1] = (int) Config::advanced('scrapper.percentage.1');
        $percentage[2] = (int) Config::advanced('scrapper.percentage.2');
        $affiliates    = array_replace(
            self::initializeAffiliates(), Session::get('affiliates', array())
        );
        $affiliateSettings  = Database::table('affiliates')->findAll()->asArray();
        $mappedAffiliates   = self::mapAffiliateKeys($affiliates);
        $selectedAffiliates = self::initializeAffiliates();
        $enableAdvancedAffiliateLogic = Config::extensionsConfig('TrafficLoadBalancer.enable_advanced_affiliate_logic_local');
        foreach ($affiliateSettings as $affiliateSetting) {
            $matched = true;
            foreach ($mappedAffiliates as $key => $value) {
                if ($affiliateSetting[$key] !== $value) {
                    $matched = false;
                    break; 
                }
            }
            if ($matched) {
                if (trim($affiliateSetting['scrap_step_1']) !== '') {
                    $percentage[1] = (int) $affiliateSetting['scrap_step_1'];
                }
                if (trim($affiliateSetting['scrap_step_2']) !== '') {
                    $percentage[2] = (int) $affiliateSetting['scrap_step_2'];
                }
                $selectedAffiliates = $affiliates;
                break;
            }
        }
        
        if(count(array_filter($selectedAffiliates)) == 0 && $enableAdvancedAffiliateLogic) {
            $updatedAffilitesLogic = self::advancedAffilitesLogic();
            $percentage = $updatedAffilitesLogic['percentage'];
            $selectedAffiliates = $updatedAffilitesLogic['affiliates'];
        }
        
        return array(
            'percentage' => $percentage, 'affiliates' => $selectedAffiliates,
        );
    }

    private static function advancedAffilitesLogic()
    {
        $percentage    = array(1 => 0, 2 => 0);
        $percentage[1] = (int) Config::advanced('scrapper.percentage.1');
        $percentage[2] = (int) Config::advanced('scrapper.percentage.2');
        $affiliates    = array_replace(
            self::initializeAffiliates(), Session::get('affiliates', array())
        );
        $affiliateSettings  = Database::table('affiliates')->findAll()->asArray();
        $mappedAffiliates   = self::mapAffiliateKeys($affiliates);
        $selectedAffiliates = self::initializeAffiliates();
        $matchedArr = array();
        $lastMatched = array();

        foreach ($affiliateSettings as $k => $affiliateSetting) {
            $matched = true;           
            foreach ($mappedAffiliates as $key => $value) {
                if (!empty($affiliateSetting[$key]) && !empty($value) && $affiliateSetting[$key] == $value) {
                    $lastMatched[$key] = $affiliateSetting['id'];
                }
            }
        }
        
        if(array_key_exists('affid', $lastMatched) || array_key_exists('afid', $lastMatched)) {
            $v = array_count_values($lastMatched);
            $maxs = array_keys($v, max($v));  
            $matchKey = $maxs[0] - 1;
            if (trim($affiliateSettings[$matchKey]['scrap_step_1']) !== '') {
                $percentage[1] = (int) $affiliateSettings[$matchKey]['scrap_step_1'];
            }
            if (trim($affiliateSettings[$matchKey]['scrap_step_2']) !== '') {
                $percentage[2] = (int) $affiliateSettings[$matchKey]['scrap_step_2'];
            }
            $selectedAffiliates = $affiliates;
        }
            
        return array(
            'percentage' => $percentage, 'affiliates' => $selectedAffiliates,
        );
    }

    public static function getRemote()
    {

        $offerUrl   = sprintf('%s/', rtrim(Request::getOfferUrl(), '/'));
        $affiliates = self::mapAffiliateKeys(Session::get('affiliates', array()));

        $gateWaySwitcherId = Config::settings('gateway_switcher_id');
        $queryParams       = array(
            'offer_url'        => $offerUrl,
            'conf_scrap_count' => 0,
        );

        if (!empty($affiliates)) {
            $queryParams = array_replace($queryParams, $affiliates);
             $subaffiliatePost = Config::extensionsConfig('TrafficLoadBalancer.subaffiliate_post');            
            if(!$subaffiliatePost)
            {
                unset($queryParams['c1']);
                unset($queryParams['c2']);
                unset($queryParams['c3']);
                unset($queryParams['c4']);
                unset($queryParams['c5']);
                unset($queryParams['sId']);
            }
        }
        $queryString = http_build_query($queryParams);

        $apiEndpoint = rtrim(Registry::system('systemConstants.201CLICKS_URL'), '/api');

        $url = sprintf(
            '%s/scrapper/%s/?%s', $apiEndpoint, $gateWaySwitcherId, $queryString
        );

        $response = self::getResponse($url);
        $settings = empty($response['data']) ? array() : json_decode($response['data'], true);

        $percentage = array(
            1 => empty($settings['step1_scrap_value']) ? 0 : (int) $settings['step1_scrap_value'],
            2 => empty($settings['upsell_scrap_value']) ? 0 : (int) $settings['upsell_scrap_value'],
        );

        $affiliates = self::initializeAffiliates();

        $prepaid = !empty($settings['prepaid_check']);

        if (!empty($settings['affiliate'])) {
            if (
                !empty($settings['affiliate']['key']) &&
                !empty($settings['affiliate']['aff_unique_id'])
            ) {
                if (strtolower($settings['affiliate']['key']) === 'affid') {
                    $affiliates['affId'] = $settings['affiliate']['aff_unique_id'];
                }
                if (strtolower($settings['affiliate']['key']) === 'afid') {
                    $affiliates['afId'] = $settings['affiliate']['aff_unique_id'];
                }
            }
            $percentage[1] = (int) $settings['affiliate']['step1_scrap_value'];
            $percentage[2] = (int) $settings['affiliate']['upsell_scrap_value'];
            $prepaid       = !empty($settings['affiliate']['prepaid_check']);
        }

        if (!empty($settings['affiliate']) && !empty($settings['sub_affiliate'])) {
            $deepestSubAffiliate = end($settings['sub_affiliate']);
            $percentage[1]       = (int) $deepestSubAffiliate['step1_scrap_value'];
            $percentage[2]       = (int) $deepestSubAffiliate['upsell_scrap_value'];
            $prepaid             = $deepestSubAffiliate['prepaid_check'];

            foreach ($settings['sub_affiliate'] as $subAffiliate) {
                if (
                    !empty($subAffiliate['key']) &&
                    !empty($subAffiliate['sub_unique_aff_id'])
                ) {
                    if (strtolower($subAffiliate['key']) === 'sid') {
                        $affiliates['sId'] = $subAffiliate['sub_unique_aff_id'];
                        continue;
                    }
                    if (strtolower($subAffiliate['key']) === 'click_id') {
                        $affiliates['clickId'] = $subAffiliate['sub_unique_aff_id'];
                        continue;
                    }
                    $affiliates[$subAffiliate['key']] = $subAffiliate['sub_unique_aff_id'];
                }
            }
        }

        return array(
            'percentage' => $percentage, 'affiliates' => $affiliates, 'prepaid' => $prepaid,
        );
    }

    private static function getResponse($url)
    {
        $lbCacheFolder    = STORAGE_DIR . DS . '.lbcache';
        $lbCacheWriteable = is_writeable($lbCacheFolder);
        if (!$lbCacheWriteable) {
            return json_decode(Http::get($url), true);
        }
        $cacheFileName = $lbCacheFolder . DS . md5($url);
        if (!file_exists($cacheFileName)) {
            $response = Http::get($url);
            file_put_contents($cacheFileName, $response);
            return json_decode($response, true);
        }
        $lastCachingTime = filemtime($cacheFileName);
        $currentTime     = time();
        if (($currentTime - $lastCachingTime) < 1 * 60) {
            $response = file_get_contents($cacheFileName);
        } else {
            $response = Http::get($url);
            file_put_contents($cacheFileName, $response);
        }
        return json_decode($response, true);
    }

    public static function initializeAffiliates()
    {
        return array(
            'afId'    => '', 'affId' => '', 'sId' => '', 'c1'  => '', 'c2'  => '',
            'c3'      => '', 'c4'    => '', 'c5'  => '', 'aId' => '', 'opt' => '',
            'clickId' => '',
        );
    }

    private static function mapAffiliateKeys($affiliates)
    {
        $mapping = array(
            'afId'    => 'afid', 'affId' => 'affid', 'sId' => 'sid', 'aId' => 'aid',
            'clickId' => 'click_id',
        );
        $newAffiliates = array();
        foreach ($affiliates as $key => $value) {
            if (array_key_exists($key, $mapping)) {
                $newAffiliates[$mapping[$key]] = $value;
                continue;
            }
            $newAffiliates[$key] = $value;
        }
        return $newAffiliates;
    }
}
