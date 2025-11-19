<?php

namespace Extension\CbUtilityPackage;

use Application\Config;
use Application\CrmPayload;
use Application\Request;

class AlterAddress
{
    public function alterAddress()
    {
        $enableAlterAddress = Config::extensionsConfig('CbUtilityPackage.alter_shipping_billing_address');
        $isDownsell = Request::attributes()->get('action');
        if(!$enableAlterAddress || $isDownsell != 'downsell') {
            return;
        }

        $formData = Request::form()->all();
        $billingSameAsShipping = $formData['billingSameAsShipping'];

        if($billingSameAsShipping == 'yes') {
            return;
        }

        CrmPayload::update(
            array(
                'firstName' => $formData['billingFirstName'],
                'lastName' => $formData['billingLastName'],
                'shippingAddress1' => $formData['billingAddress1'],
                'shippingCity' => $formData['billingCity'],
                'shippingCountry' => $formData['billingCountry'],
                'shippingState' => $formData['billingState'],
                'shippingZip' => $formData['billingZip'],
                'billingFirstName' => $formData['firstName'],
                'billingLastName' => $formData['lastName'],
                'billingAddress1' => $formData['shippingAddress1'],
                'billingCity' => $formData['shippingCity'],
                'billingCountry' => $formData['shippingCountry'],
                'billingState' => $formData['shippingState'],
                'billingZip' => $formData['shippingZip'],
            )
        );
        
    }

    
}
