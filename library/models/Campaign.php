<?php

namespace Application\Model;

use Application\Config;
use Application\Session;
use Exception;

class Campaign
{

    private function __construct()
    {
        return;
    }

    public static function find($id)
    {
        $campaign = Config::campaigns(sprintf('%d', $id));
        if ($campaign === null || !is_array($campaign)) {
            if (DEV_MODE) {
                Session::set('lastException.message', sprintf(
                    'Campaign not found with id %d', $id
                ));
            }
            throw new Exception('General config error', 1001);
        }
        if (Session::get('steps.meta.isScrapFlow') === true) {
            $campaign = Config::campaigns(
                sprintf('%d', $campaign['scrap_campaign_id'])
            );
        }
        if ($campaign === null || !is_array($campaign)) {
            if (DEV_MODE) {
                Session::set('lastException.message', sprintf(
                    'Scrap campaign not found for campaign # %d', $id
                ));
            }
            throw new Exception('General config error', 1001);
        }
        if (Session::get('steps.meta.isPrepaidFlow') === true) {
            $campaign = Config::campaigns(
                sprintf('%d', $campaign['prepaid_campaign_id'])
            );
        }
        if ($campaign === null || !is_array($campaign)) {
            if (DEV_MODE) {
                Session::set('lastException.message', sprintf(
                    'Prepaid campaign not found for campaign # %d', $id
                ));
            }
            throw new Exception('General config error', 1001);
        }
        return self::getCleanedCampaign($campaign);
    }

    private static function getCleanedCampaign($campaign)
    {
        return array(
            'codebaseCampaignId' => $campaign['id'],
            'campaignId'         => $campaign['campaign_id'],
            'shippingId'         => $campaign['shipping_id'],
            'shippingPrice'      => $campaign['shipping_price'],
            'productId'          => $campaign['product_id'],
            'productPrice'       => $campaign['product_price'],
            'productKey'         => !empty($campaign['product_key']) ? $campaign['product_key'] : '',
            'productSchedule'    => !empty($campaign['product_schedule']) ? $campaign['product_schedule'] : '',
            'productScheduleQuantity' => !empty($campaign['product_schedule_quantity']) ? $campaign['product_schedule_quantity'] : 1,
            'productQuantity'      => $campaign['product_quantity'],
            'rebillProductId'      => $campaign['rebill_product_id'],
            'rebillProductPrice'   => $campaign['rebill_product_price'],
            'enableBillingModule'  => !empty($campaign['enable_billing_module']) ? $campaign['enable_billing_module'] : '',
            'offerId'              => !empty($campaign['offer_id']) ? $campaign['offer_id'] : '',
            'billingModelId'       => !empty($campaign['billing_model_id']) ? $campaign['billing_model_id'] : '',
            'trialProductId'       => !empty($campaign['trial_product_id']) ? $campaign['trial_product_id'] : '',
            'trialProductPrice'    => !empty($campaign['trial_product_price']) ? $campaign['trial_product_price'] : '',
            'trialProductQuantity' => !empty($campaign['trial_product_quantity']) ? $campaign['trial_product_quantity'] : '',
        );
    }

    public static function getProductsByCampaignIds($campaignIds)
    {
        $products = array();

        foreach ($campaignIds as $campaignId) {

            array_push($products, Campaign::find($campaignId));

        }

        return $products;
    }

}
