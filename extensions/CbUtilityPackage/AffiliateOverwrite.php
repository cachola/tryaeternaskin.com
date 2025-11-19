<?php

namespace Extension\CbUtilityPackage;

use Application\Config;
use Application\CrmPayload;
use Application\Session;

class AffiliateOverwrite
{
    public function performOverwrite()
    {
        $isPrepaidFlow       = Session::get('steps.meta.isPrepaidFlow');
        $isScrapFlow         = Session::get('steps.meta.isScrapFlow');
        $overwriteAffiliates = array();
        $affiliates          = array();
        $extensionAffiliates = array();
        $affiliates          = CrmPayload::get('affiliates');

        $enableOverwriteForPrepaid = Config::extensionsConfig(
            'CbUtilityPackage.enable_overwrite_prepaid'
        );
        $enableOverwriteForOfferFilter = Config::extensionsConfig(
            'CbUtilityPackage.enable_overwrite_order_filter'
        );

        if ($enableOverwriteForPrepaid == false && $enableOverwriteForOfferFilter == false) {
            return;
        }

        if ($enableOverwriteForPrepaid == true) {
            if ($isPrepaidFlow === true) {
                foreach ($affiliates as $key => $value) {
                    $extensionAffiliates[$key] = Config::extensionsConfig(
                        'CbUtilityPackage.prepaid_' . $key);
                }
                CrmPayload::update(array('affiliates' => $extensionAffiliates));
            }
        }

        $extensionAffiliates = array();

        if ($enableOverwriteForOfferFilter == true) {
            if ($isScrapFlow === true) {
                foreach ($affiliates as $key => $value) {
                    $extensionAffiliates[$key] = Config::extensionsConfig(
                        'CbUtilityPackage.scrap_' . $key);
                }
                CrmPayload::update(array('affiliates' => $extensionAffiliates));
            }
        }
    }

    public function performSplitOverwrite()
    {
        if (CrmPayload::get('meta.isSplitOrder') !== true) {
            return;
        }
        $overwriteAffiliates = array();
        $affiliates          = array();
        $extensionAffiliates = array();
        $affiliates          = CrmPayload::get('affiliates');

        $enableOverwriteForSplitOfferFilter = Config::extensionsConfig(
            'CbUtilityPackage.enable_overwrite_split_order'
        );

        if ($enableOverwriteForSplitOfferFilter == false) {
            return;
        }

        foreach ($affiliates as $key => $value) {
            $extensionAffiliates[$key] = Config::extensionsConfig(
                'CbUtilityPackage.split_' . $key);
        }
        CrmPayload::update(
            array(
                'affiliates' => array_filter($extensionAffiliates),
            )
        );

    }
}
