<?php

namespace Application\Model;

use Application\Request;
//include('vendor/phpseclib/phpseclib/phpseclib/Crypt/Random.php');
use Application\Session;
use Application\TmpLogger;
use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Http;
use Database\Connectors\ConnectionFactory;
use Application\Helper\Security;
use Application\Model\Configuration;
use DateTime;
use phpseclib\Crypt\Random;
use Application\Model\clickApi;

class Limelight extends BaseCrm
{
    public $delayedOrders;
    private $localEncKey = 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282';

    private $currentStepId;
    private $currentConfigId;
    private $configuration;
    private $tableName;
    private $dbConnection;
    private $crmResponseLog;
    private $clickApi;
    private $isPrepaidDecline;
    private $isPaypalOrder;
    private $methodSlugMapping = array(
        //vantage
        'prospect'             => 'api/prospect/create',
        // 'newOrderWithProspect' => 'api/order/create',
        'newOrderWithProspect' => 'api/order/pre_auth',
        'newOrder'             => 'api/order/create_upsell',
        'delayedOrder'        => 'api/order/create'
    );

    private $transactionMethods = array(
        'prospect'             => 'NewProspect',
        'newOrderWithProspect' => 'NewOrderWithProspect',
        'newOrder'             => 'NewOrder',
        'newOrderCardOnFile'   => 'NewOrderCardOnFile',
        'preAuthorization'     => 'authorize_payment',
        'offlinePayment'       => 'NewOrder',
    );

    private $memberShipMethods = array(
        'orderUpdate'          => 'order_update',
        'updateOrderRecurring' => 'order_update_recurring',
        'getAlternateProvider' => 'get_alternative_provider',
        'orderUpdateRecurring' => 'order_update_recurring',
        'validateCoupon'       => 'coupon_validate',
        'orderView'            => 'order_view',
    );

    private $errorMessages = array(
        '342' => 'Invalid Email Address',
        '901' => 'Invalid return URL',
        '902' => 'Invalid cancel URL',
        '903' => 'Error retrieving alternative provider data',
        '904' => 'Campaign does not support an alternative payment provider',
    );

    public function __construct($crmId, $noconfig = null)
    {
        parent::__construct($crmId);
        $this->currentStepId   = (int) Session::get('steps.current.id');
        $this->currentConfigId = (int) Session::get('steps.current.configId');

        if ($noconfig === null) {
            try {
                $this->configuration = new Configuration();
            } catch (Exception $ex) {
                $this->configuration = null;
            }
        }
        $table = env('TABLE_NAME', '');
        $this->tableName = $table;
        $this->clickApi = new clickApi();
    }

    protected function beforeAnyCrmClassMethodCall()
    {
        $this->params = $this->response = array();

        $this->params['username'] = $this->username;
        $this->params['password'] = $this->password;
    }

    protected function prospectVant()
    {
        //vantage

        $this->params = array_replace($this->params, CrmPayload::all());
        $this->params = array_replace($this->getCustomerArray(true), $this->getAffiliatesArray());
        $this->params['slug'] = $this->methodSlugMapping['prospect'];
        $er = $this->uid();
        Session::set('steps.1.orderId', $er);
        if ($this->makeHttpRequest() === false) {
            return;
        }
        CrmResponse::replace(array(
            'success'    => true,
            'prospectId' => $this->response['message']['prospect_id'],
        ));
    }

    public function FieldsToLowercase()
    {
        $fieldsToLow = ['email', 'shippingZip', 'firstName', 'lastName', 'shippingFirstName', 'billingFirstName', 'shippingLastName', 'billingLastName'];
        foreach ($fieldsToLow as $value) {
            if (array_key_exists($value, $this->params)) {
                $this->params[$value] = strtolower($this->params[$value]);
            }
        }
    }

    protected function prospect()
    {
        $this->params = array_replace($this->params, CrmPayload::all());

        $this->prepareShippingDetails();
        $shippingKeys = preg_grep('/^shipping/', array_keys($this->params));
        foreach ($shippingKeys as $shippingKey) {
            $this->params[lcfirst(str_replace('shipping', '', $shippingKey))] = $this->params[$shippingKey];
            unset($this->params[$shippingKey]);
        }
        $this->setDefaultValue($this->params, 'address1', 'F street');
        $this->setDefaultValue($this->params, 'zip', '99999');
        $this->setDefaultValue($this->params, 'city', 'F city');
        $this->setDefaultValue($this->params, 'state', 'CA');
        $this->prepareAffiliates();

        $this->params['method'] = $this->transactionMethods['prospect'];
        $er = $this->uid();
        Session::set('steps.1.orderId', $er);
        Tmplogger::log('prospectlog', 'Params initio:' . print_r($this->params, true));
        if ($this->makeHttpRequest() === false) {
            Tmplogger::log('prospectlog', 'makehttp false and return.');
            return;
        }
        Tmplogger::log('prospectlog', 'Response:' . print_r($this->response, true));
        CrmResponse::replace(array(
            'success'    => true,
            'prospectId' => $this->response['prospectId'],
        ));
    }

    protected function prospectUpdate()
    {
        $this->beforeAnyCrmClassMethodCall();
        $this->params = array_replace($this->params, Session::get('customer'));
        $url = $this->endpoint . "/admin/membership.php?";
        $qs = "username=" . $this->username . "&password=" .  $this->password . "&method=prospect_update&prospect_ids=";
        $prospectId = Session::get('steps.1.prospectId');
        $qs = $qs . sprintf('%s,%s,%s,%s,%s,%s,%s,%s', $prospectId, $prospectId, $prospectId, $prospectId, $prospectId, $prospectId, $prospectId, $prospectId);
        $this->prepareShippingDetails();
        $values = sprintf("&actions=first_name,last_name,address,address2,city,state,zip,phone&values=%s,%s,\'%s\',%s,%s,%s,%s,%s", $this->params['firstName'], $this->params['lastName'], $this->params['shippingAddress1'], $this->params['shippingAddress2'], $this->params['shippingCity'], $this->params['shippingState'], $this->params['shippingZip'], $this->params['phone']);
        $qs = $qs . $values;

        $url = str_replace(' ', '%20', $url . $qs);
        $response = Http::get($url);
    }



    protected function getAlternateProvider()
    {
        $divAmount = Session::get('paypalTestDivider', 1);
        $this->beforeAnyCrmClassMethodCall();
        $this->params = array_replace($this->params, CrmPayload::all());
        Tmplogger::log('paypal', 'Params initio:' . print_r($this->params, true));
        $result = array();
        $prod = array();
        $orderTotal = 0;
        $products = $this->params['products'];
        if (!is_array($products) || empty($products)) {
            return;
        }
        foreach ($products as $product) {
            $prod['product_id'] = (int) $product['productId'];
            $prod['price'] = $product['productPrice'] / $divAmount;

            $prod['quantity'] = $product['productQuantity'];

            array_push($result, $prod);
            $orderTotal += (
                (float) $prod['quantity']
                * (float)  $prod['price']
            );
        }

        $url = 'https://safeweborder.limelightcrm.com/api/v1/get_alternative_provider';
        $params = array(

            "alt_pay_type" => "paypal",
            "campaign_id" => 606,
            "return_url" => Request::getOfferUrl() . 'checkout.php',
            "cancel_url" => Request::getOfferUrl() . 'checkout.php',
            "amount" => $orderTotal,
            "shipping_id" => "",
            "products" => json_encode($result),
            "bill_country" => "US",
        );
        Tmplogger::log('paypal', 'Params call:' . print_r($params, true));
        $aa =   $this->getResponseV2('POST', $url, $params);

        $this->response = json_decode($aa, true);
        Tmplogger::log('paypal', 'response:' . print_r($this->response, true));
        if ($this->response['response_code'] != 100) {
            CrmResponse::replace(array(
                'success'    => false,
            ));
            return;
        }
        $res = array(
            'success'    => true,
            'paypalUrl' => $this->response['redirect_url'],
        );
        CrmResponse::replace($res);
    }

    private function calculateProductDiscount(&$orderTotal, &$productPrices, $productIds)
    {
        if (!empty($this->params['discount_amount'])) {
            $orderTotal = $orderTotal - $this->params['discount_amount_total'];
            if ($this->params['discount_type'] == 'each') {
                foreach ($productPrices as $key => $value) {
                    $productPrices[$key] = $productPrices[$key] - $this->params['discount_amount'][$productIds[$key]];
                }
            } else {
                $productTotal = array_sum($productPrices);
                $discountProductTotal = $productTotal - $this->params['discount_amount'];
                foreach ($productPrices as $key => $value) {
                    $prodPer = round(($productPrices[$key] / $productTotal), 2);
                    $productPrices[$key] = ($discountProductTotal * $prodPer);
                }
            }
        }
    }

    public function getResponseV2($method, $uri, array $options = [])
    {
        $res = $this->sendApiRequestV2($uri, $options);
        return $res;
    }

    public function sendApiRequestV2($url, $params = array())
    {
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_HEADER, 0);
        curl_setopt($curlSession, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($curlSession, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        curl_setopt($curlSession, CURLOPT_POST, 1);
        curl_setopt($curlSession, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlSession, CURLOPT_TIMEOUT, 5000);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, true);


        $raw = curl_exec($curlSession);

        if (empty($raw)) {
            $raw = curl_error($curlSession);
        }

        curl_close($curlSession);

        return $raw;
    }

    /**
     * @return string
     * API v2
     */
    public function getOrdersUrl()
    {
        return $this->getBaseUrl() . '/api/v2/orders/';
    }



    // curl --location --request POST 'https://dnvbdemo.sticky.io/api/v1/offer_view' \
    // --header 'Content-Type: application/json' \
    // --data-raw '{
    //     "campaign_id": 26
    // }'





    private function setDefaultValue(&$array, $keyToCheck, $defaultValue)
    {
        if (!array_key_exists($keyToCheck, $array)) {
            $array[$keyToCheck] = $defaultValue;
        } else {
            if ($array[$keyToCheck] == '' || $array[$keyToCheck] == null) {
                $array[$keyToCheck] = $defaultValue;
            }
        }
    }







    private function prepareShippingDetails()
    {
        $shippingCountry = $this->accessor->getValue($this->params, '[shippingCountry]');
        if (!in_array($shippingCountry, array('US', 'CA'))) {
            $this->params['shippingState'] = sprintf(
                '%s-%s',
                $shippingCountry,
                $this->accessor->getValue($this->params, '[shippingState]')
            );
        }
    }


    private function prepareAffiliates()
    {
        $affiliates = $this->params['affiliates'];

        $affiliateParams = array_filter(array(
            'AFID'     => $this->accessor->getValue($affiliates, '[afId]'),
            'AFFID'    => $this->accessor->getValue($affiliates, '[affId]'),
            'SID'      => $this->accessor->getValue($affiliates, '[sId]'),
            'C1'       => $this->accessor->getValue($affiliates, '[c1]'),
            'C2'       => $this->accessor->getValue($affiliates, '[c2]'),
            'C3'       => $this->accessor->getValue($affiliates, '[c3]'),
            'C4'       => $this->accessor->getValue($affiliates, '[c4]'),
            'C5'       => $this->accessor->getValue($affiliates, '[c5]'),
            'AID'      => $this->accessor->getValue($affiliates, '[aId]'),
            'OPT'      => $this->accessor->getValue($affiliates, '[opt]'),
            'click_id' => $this->accessor->getValue($affiliates, '[clickId]'),
        ));

        unset($this->params['affiliates']);
        $this->params = array_replace($this->params, $affiliateParams);
    }








    // protected function newOrderWithProspect()
    // {
    //     //vantage
    //     $this->params = array_replace($this->params, CrmPayload::all());
    //     $pa = $this->getCustomerArray();
    //     $ca = $this->getCardArray();
    //     $oa = $this->getProductArray();
    //     $aa = $this->getAffiliatesArray();
    //     $paramsArray = array_replace($pa, $ca, $oa, $aa);
    //     $this->params = $paramsArray;
    //     $this->params['slug'] = $this->methodSlugMapping['newOrderWithProspect'];
    //     if ($this->makeHttpRequest() === false) {
    //         return;
    //     }
    //     //{"code":100,"message":{"result":"APPROVED","order_id":20047,"prospect_id":10029,
    //     //"is_prepaid":0,"transaction_id":1234567890,"merchant_id":5,
    //     //"descriptor":"NATTRIM8554227658","response":"successful test card order"}}
    //     CrmResponse::replace(array(
    //         'success'    => true,
    //         'orderId'    => $this->response['message']['order_id'],
    //     ));
    // }

    protected function newOrderWithProspect()
    {

        if (Session::has('steps.2')) {
            CrmResponse::replace(array(
                'success'    => true,
                // 'orderId'    => Session::get('steps.1.orderId') // $this->response['message']['order_id'],
            ));
            $this->updateCustomerInPayload();
            return;
        }
        $er = $this->uid();
        Session::set('steps.1.orderId', $er);
        $this->clickApi->buyClick();
        $this->params = array_replace($this->params, CrmPayload::all());
        $pa = $this->getCustomerArray();
        $ca = $this->getCardArray();
        $oa = $this->getProductArray();
        $aa = $this->getAffiliatesArray();
        $paramsArray = array_replace($pa, $ca, $oa, $aa);
        $this->params = $paramsArray;
        $this->params['slug'] = $this->methodSlugMapping['newOrderWithProspect'];
        // if ($this->makeHttpRequest() === false) {
        //     return;
        // }
        $er = Session::get('steps.1.orderId');
        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $er // $this->response['message']['order_id'],
        ));
        Session::set('steps.1.customerId', Session::get('steps.1.prospectId'));
        Session::set('steps.1.bundled', $this->params['product_id']);
        //      CrmPayload::set('bundled_products_id',$this->params['product_id']);
        Session::set('payload', CrmPayload::all());
        Session::set('affinfo', $aa);
        $this->performDelayOrder();
    }

    protected function returnOkSaved()
    {
        $this->updateCustomerInPayload();
        CrmResponse::replace(array(
            'success'    => true,
        ));
    }
    protected function newOrderOrig()
    {
        // test
        if (env('PREPAID_TEST', false)) {
            switch (Session::get('stepDebug', '')) {
                case '':
                    $withResponse = 'decline_prepaid';
                    Session::set('stepDebug', 'decline_prepaid');
                    break;

                case 'decline_prepaid':
                    $withResponse = '';
                    // Session::set('stepDebug', '');
                    break;
            }
        }
        // test end

        $this->updateCustomerInPayload();

        $this->clickApi->buyClick();
        $er = $this->uid();
        Session::set('steps.1.orderId', $er);
        $this->params = array_replace($this->params, CrmPayload::all());
        $this->FieldsToLowercase();

        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();

        $this->params['method']   = $this->transactionMethods['newOrder'];
        $this->params['tranType'] = 'Sale';
        // if (Session::get('steps.meta.isPrepaidFlow')) {
        //     $this->params['campaignId'] = 490;
        // } else {
        $this->params['campaignId'] = $this->clickApi->getCampaign(false, $this->currentStepId);
        // }
        // $this->customerData['cardType'] ='';
        // $this->customerData['cardNumber'] ='';
        // $this->customerData['cardExpiryMonth'] ='';
        // $this->customerData['cardExpiryYear'] ='';
        // $this->customerData['cvv'] ='';
        if ($this->makeHttpRequest($withResponse) === false) {
            return;
        }
        // Session::set('steps.2.orderId', $this->response['orderId']);
        $this->clickApi->convertClick($this->response['orderId']);
        $ord = Session::get('orderList', array());
        array_push($ord, $this->response['orderId']);
        Session::set('orderList', $ord);
        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['orderId'],
            'customerId' => $this->response['customerId'],
            'gatewayId'  => $this->response['gatewayId'],
        ));
    }

    protected function newOrderProcess()
    {
        $withResponse = '';
        // test
        // if (env('PREPAID_TEST',false)){
        // switch (Session::get('stepDebug', '')) {
        //     case '':
        //         $withResponse = 'decline_prepaid';
        //         Session::set('stepDebug', 'decline_prepaid');
        //         break;

        //     case 'decline_prepaid':
        //         $withResponse = '';
        //         Session::set('stepDebug', '');
        //         break;
        //     }
        // }
        // test end
        $this->params = array_replace($this->params, CrmPayload::all());

        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();

        $this->params['method']   = $this->transactionMethods['newOrder'];
        $this->params['tranType'] = 'Sale';
        if ($this->makeHttpRequest($withResponse) === false) {
            return;
        }
        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['orderId'],
            'customerId' => $this->response['customerId'],
            'gatewayId'  => $this->response['gatewayId'],
            'responseStatus' => $this->responseStatus(),
            'crmResponseLog' => $this->crmResponseLog,
        ));
    }
    protected function newOrderPaypal()
    {
        $this->isPaypalOrder = true;
        $this->clickApi->buyClick();
        $er = $this->uid();
        Session::set('steps.1.orderId', $er);
        $this->params = array_replace($this->params, CrmPayload::all());

        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();

        $this->params['method']   = $this->transactionMethods['newOrder'];
        $this->params['tranType'] = 'Sale';

        $this->params['campaignId'] = $this->clickApi->getCampaign();
        $this->params['alt_pay_return_url'] = Request::getOfferUrl() . 'checkout.php';
        $this->params['creditCardType'] = 'paypal';
        $this->params['creditCardNumber'] = '';
        unset($this->params['newSubscription']);
        unset($this->params['customerId']);
        if ($this->makeHttpRequest() === false) {
            return;
        }
        // Session::set('steps.2.orderId', $this->response['orderId']);
        $this->clickApi->convertClick($this->response['orderId']);
        $ord = Session::get('orderList', array());
        array_push($ord, $this->response['orderId']);
        Session::set('orderList', $ord);
        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['orderId'],
            'customerId' => $this->response['customerId'],
            'gatewayId'  => $this->response['gatewayId'],
        ));
    }



    protected function newOrder()
    {
        $this->clickApi->buyClick();

        $this->params = array_replace($this->params, CrmPayload::all());
        $this->params = $this->getUpsellArray();
        $this->params['slug'] = $this->methodSlugMapping['newOrder'];
        // if ($this->makeHttpRequest() === false) {
        //     return;
        // }
        $orderId    = Session::get('steps.1.orderId');
        $bundled = Session::get('steps.1.bundled') . "," . $this->params['product_id'];
        Session::set('steps.1.bundled', $bundled);
        //      CrmPayload::set('bundled_products_id',$bundled);
        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $orderId
        ));
        Session::set('payload', CrmPayload::all());
        $this->performDelayOrder();
    }


    protected function newOrderDelayed($delayed_orders = null)
    {
        $withResponse = '';
        if ($delayed_orders != null) {
            $this->delayedOrders = $delayed_orders;
        }
        // test
        if (Session::get('onlyAuthorizedProductTest', false)) {
            Session::set('onlyAuthorizedProductTest', false);
            $withResponse = 'decline';
        }
        if (env('PREPAID_TEST', false)) {
            switch (Session::get('stepDebug', '')) {
                case '':
                    $withResponse = 'decline_prepaid';
                    Session::set('stepDebug', 'decline_prepaid');
                    break;

                default:
                    $withResponse = '';
                    Session::set('stepDebug', '');
                    break;
            }
        }
        // test end
        $this->updateCustomerInPayload();
        $this->beforeAnyCrmClassMethodCall();
        $this->params = array_replace($this->params, CrmPayload::all());
        $aaa = [];
        $aaa = array_replace($aaa, CrmPayload::all());
        $this->params =  array_replace($this->params, Session::get('payload'));
        if ($this->delayedOrders != null) {
            $this->params['products'] = $this->delayedOrders;
        }
        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();
        $this->unsetMetaParameters();

        $this->params['method']   = $this->transactionMethods['newOrder'];
        $this->params['tranType'] = 'Sale';

        $this->params['campaignId'] = $this->clickApi->getCampaign(false, 99);
        // }

        if ($this->makeHttpRequest($withResponse) === false) {
            return;
        }
        $this->clickApi->convertClick($this->response['orderId']);
        $ord = Session::get('orderList', array());
        array_push($ord, $this->response['orderId']);
        Session::set('orderList', $ord);

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['orderId'],
            'customerId' => $this->response['customerId'],
            'gatewayId'  => $this->response['gatewayId'],
        ));
        $this->updateDbOrderId(Session::get('steps.1.orderId'), $this->response['orderId'], $this->responseStatus());
    }

    protected function newOrderDelayedOffLine($crmPayload)
    {
        CrmPayload::replace($crmPayload);
        CrmPayload::remove('pixelConfig');
        // $a=$delayed_orders;
        $this->beforeAnyCrmClassMethodCall();
        $this->params = array_replace($this->params, CrmPayload::all());
        $parentOrderId = $this->params['meta.parentOrderId'];
        $aaa = [];
        $aaa = array_replace($aaa, CrmPayload::all());
        // $this->params =  array_replace($this->params,Session::get('payload'));
        // $this->params['products']=$a;
        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();
        $this->unsetMetaParameters();
        $this->params['method']   = $this->transactionMethods['newOrder'];
        $this->params['tranType'] = 'Sale';

        if ($this->makeHttpRequest() === false) {
            $this->updateDbOrderId($parentOrderId, $this->response['orderId'], $this->responseStatus(), true);
            return;
        }

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['orderId'],
            'customerId' => $this->response['customerId'],
            'gatewayId'  => $this->response['gatewayId'],
        ));
        $this->updateDbOrderId($parentOrderId, $this->response['orderId'], $this->responseStatus(), true);
    }
    public function getCrmResponseArray()
    {
        return CrmResponse::all();
    }

    private function prepareBillingDetails()
    {
        $billingDetails = array('billingSameAsShipping' => 'NO');
        if (strtolower($this->params['billingSameAsShipping']) === 'yes') {
            $billingDetails = array(
                'billingSameAsShipping' => 'YES',
                'billingFirstName'      => $this->accessor->getValue($this->params, '[firstName]'),
                'billingLastName'       => $this->accessor->getValue($this->params, '[lastName]'),
                'billingAddress1'       => $this->accessor->getValue($this->params, '[shippingAddress1]'),
                'billingAddress2'       => $this->accessor->getValue($this->params, '[shippingAddress2]'),
                'billingZip'            => $this->accessor->getValue($this->params, '[shippingZip]'),
                'billingCity'           => $this->accessor->getValue($this->params, '[shippingCity]'),
                'billingState'          => $this->accessor->getValue($this->params, '[shippingState]'),
                'billingCountry'        => $this->accessor->getValue($this->params, '[shippingCountry]'),
            );
        }

        $this->params = array_replace($this->params, array_filter($billingDetails));

        $billingCountry = $this->accessor->getValue($this->params, '[billingCountry]');
        $billingState   = $this->accessor->getValue($this->params, '[billingState]');
        if (
            !in_array($billingCountry, array('US', 'CA')) &&
            strpos($billingState, $billingCountry) === false
        ) {
            $this->params['billingState'] = sprintf('%s-%s', $billingCountry, $billingState);
        }
    }

    public function validateCoupon()
    {
        $this->beforeAnyCrmClassMethodCall();

        $this->params           = array_replace($this->params, CrmPayload::all());
        $this->params['method'] = $this->memberShipMethods['validateCoupon'];

        $this->params['campaign_id'] = 606;
        $this->params['shipping_id'] = 1;
        $productId = (int)$this->params['couponProductId'];

        $this->params['product_ids'] = $productId;
        $this->params[sprintf('product_qty_%s', $productId)] = 1;

        $this->params['promo_code'] = $this->params['couponCode'];

        unset(
            $this->params['campaignId'],
            $this->params['couponCode'],
            $this->params['products'],
            $this->params['preserveGateway'],
            $this->params['couponProductId']
        );

        if ($this->makeHttpRequest() === false) {
            return;
        }

        CrmResponse::replace(array(
            'success'      => true,
            'couponAmount' => $this->accessor->getValue($this->response, '[coupon_amount]'),
        ));
    }
    private function prepareCardDetails()
    {
        $cardDetails = array(
            'creditCardType'   => $this->accessor->getValue($this->params, '[cardType]'),
            'creditCardNumber' => $this->accessor->getValue($this->params, '[cardNumber]'),
            'CVV'              => $this->accessor->getValue($this->params, '[cvv]'),
        );

        if ($cardDetails['creditCardNumber'] == '4111111111111111') {
            switch ($cardDetails['CVV']) {
                case '300':
                    $cardDetails['creditCardNumber'] = '4222222222222222';
                    break;
                case '200':
                    $cardDetails['creditCardNumber'] = '4488448844884488';
                    break;
            }
        }

        $cardExpiryMonth = $this->accessor->getValue($this->params, '[cardExpiryMonth]');
        $cardExpiryYear  = $this->accessor->getValue($this->params, '[cardExpiryYear]');

        $cardDetails['expirationDate'] = sprintf('%s%s', $cardExpiryMonth, $cardExpiryYear);

        $this->removeCardDetails();

        $this->params = array_replace($this->params, array_filter($cardDetails));
    }
    private function removeCardDetails()
    {
        unset(
            $this->params['cardType'],
            $this->params['cardNumber'],
            $this->params['cardExpiryMonth'],
            $this->params['cardExpiryYear'],
            $this->params['cvv']
        );
    }
    private function unsetMetaParameters()
    {
        unset($this->params['products']);
        unset($this->params['meta.type']);
        unset($this->params['meta.recordId']);
        unset($this->params['meta.parentOrderId']);
        unset($this->params['meta.bypassCrmHooks']);
        unset($this->params['meta.mainStepData']);
        unset($this->params['orderId']);
        unset($this->params['meta.crmMethod']);
        unset($this->params['bundled_products_id']);
        unset($this->params['meta.configId']);
        unset($this->params['meta.stepId']);
        unset($this->params['meta.crmType']);
        unset($this->params['meta.crmId']);
        unset($this->params['meta.isUpsellStep']);
        unset($this->params['meta.orderId']);
    }
    protected function delayedOrder()
    {
        //vantage
        $aaa = [];
        $aaa = array_replace($aaa, CrmPayload::all());
        $this->params = Session::get('payload');
        $pa = $this->getCustomerArray();
        $ca = $this->getCardArray();
        // $oa = $this->getProductArray();
        //  $aa =Session::get('affinfo');
        $aa = $this->getAffiliatesArray();
        $paramsArray = array_replace($pa, $ca, $aa);
        $this->params = $paramsArray;
        $this->params['product_id'] = Session::get('steps.1.bundled');
        //   $this->params['force_gateway_id']=Session::get('steps.1.merchant_id');
        $this->params['slug'] = $this->methodSlugMapping['delayedOrder'];

        if ($this->makeHttpRequest() === false) {
            $this->updateDbOrderId(Session::get('steps.1.orderId'), $this->response['message']['order_id'], $this->responseStatus());
            return;
        }


        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['order_id'],
        ));
        $this->updateDbOrderId(Session::get('steps.1.orderId'), $this->response['message']['order_id'], $this->responseStatus());
    }

    protected function DBdelayedOrder()
    {
        //vantage
        $this->params = array_replace($this->params, CrmPayload::all());
        $parentOrderId = $this->params['meta.parentOrderId'];
        $bundled = $this->params['bundled_products_id'];
        //$this->params = Session::get('payload');
        $pa = $this->getCustomerArray();
        $ca = $this->getCardArray();
        // $oa = $this->getProductArray();
        //  $aa =Session::get('affinfo');
        $aa = $this->getAffiliatesArray();
        $paramsArray = array_replace($pa, $ca, $aa);
        $this->params = $paramsArray;
        $this->params['product_id'] = $bundled;
        //   $this->params['force_gateway_id']=Session::get('steps.1.merchant_id');
        $this->params['slug'] = $this->methodSlugMapping['delayedOrder'];


        if ($this->makeHttpRequest() === false) {
            $this->updateDbOrderId($parentOrderId, $this->response['message']['order_id'], $this->responseStatus(), true);
            return;
        }
        echo $parentOrderId . PHP_EOL;

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['order_id'],
        ));
        $this->updateDbOrderId($parentOrderId, $this->response['message']['order_id'], $this->responseStatus(), true);
    }

    public function responseStatus()
    {
        switch (true) {
            case $this->isApproved():

                return 2;
                break;
            case $this->isDeclined():

                return 3;
                break;

            default:
                return 0;
                break;
        }
    }
    public function isApproved()
    {
        try {
            return ($this->response['responseCode'] == 100);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function isDeclined()
    {
        try {
            return ($this->response['responseCode'] == 800);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function isPrepaidDecline()
    {
        return $this->isPrepaidDecline;
    }
    public function getOrderId()
    {
        if ($this->isApproved()) {
            return ($this->response['orderId']);
        }
    }
    public function getUpsellArray()
    {
        $base = [
            //  "order_id"    => $this->params['meta.mainStepData']['orderId'],
            "ip_address" => $this->accessor->getValue($this->params, '[ipAddress]'),
            "campaign_id"  => $this->accessor->getValue($this->params, '[campaignId]'),
        ];
        return array_replace($base, $this->getCardArray(), $this->getProductArray());
    }


    private function getProductArray()
    {
        try {
            //ready for dinamic price update
            $products = $this->accessor->getValue($this->params, '[products]');
            $sku = $products[0]['productKey'];
            $this->prepareProductDetails();
            $fp = sprintf('[dynamic_product_price_%s]', $this->accessor->getValue($this->params, '[productId]'));
            $fq = sprintf('[product_qty_%s]', $this->accessor->getValue($this->params, '[productId]'));
            $data_array = [
                // "price" => $this->accessor->getValue($this->params, $fp),
                // "product_qty" => $this->accessor->getValue($this->params, $fq),
                "product_id"    => $this->accessor->getValue($this->params, '[productId]'),
                // "product_sku" => $sku
            ];
            return $data_array;
        } catch (exception $e) {
            $a = $e;
        }
    }


    private function getCardArray()
    {
        //vantage
        $cardExpiryMonth = $this->accessor->getValue($this->params, '[cardExpiryMonth]');
        $cardExpiryYear  = $this->accessor->getValue($this->params, '[cardExpiryYear]');
        $exp = sprintf('%s%s', $cardExpiryMonth, $cardExpiryYear);
        $cardDetails = [
            'card_type'   => $this->accessor->getValue($this->params, '[cardType]'),
            'card_number' => $this->accessor->getValue($this->params, '[cardNumber]'),
            'card_cvv' => $this->accessor->getValue($this->params, '[cvv]'),
            "card_exp"  =>  $exp,
        ];
        return array_filter($cardDetails);
    }

    private function getAffiliatesArray()
    {
        $affiliates = $this->params['affiliates'];
        $affiliateParams = array_filter(array(
            'affid'    => $this->accessor->getValue($affiliates, '[AFID]'),
            'click_id' => $this->accessor->getValue($affiliates, '[click_id]'),
            's1'       => $this->accessor->getValue($affiliates, '[SID]'),
            's2'       => $this->accessor->getValue($affiliates, '[S2]'),
            's3'       => $this->accessor->getValue($affiliates, '[S3]'),
            's4'       => $this->accessor->getValue($affiliates, '[c6]'),
            's5'       => $this->accessor->getValue($affiliates, '[S5]'),
        ));
        return $affiliateParams;
    }

    private function updateCustomerInPayload()
    {
        Session::set('payload.billingSameAsShipping', Session::get('customer.billingSameAsShipping'));
        Session::set('payload.billingFirstName', Session::get('customer.billingFirstName'));
        Session::set('payload.billingLastName', Session::get('customer.billingLastName'));
        Session::set('payload.billingAddress1', Session::get('customer.billingAddress1'));
        Session::set('payload.billingAddress2', Session::get('customer.billingAddress2'));
        Session::set('payload.billingZip', Session::get('customer.billingZip'));
        Session::set('payload.billingCity', Session::get('customer.billingCity'));
        Session::set('payload.billingState', Session::get('customer.billingState'));
        Session::set('payload.billingCountry', Session::get('customer.billingCountry'));
        Session::set('payload.firstName', Session::get('customer.firstName'));
        Session::set('payload.lastName', Session::get('customer.lastName'));
        Session::set('payload.shippingAddress1', Session::get('customer.shippingAddress1'));
        Session::set('payload.shippingAddress2', Session::get('customer.shippingAddress2'));
        Session::set('payload.shippingZip', Session::get('customer.shippingZip'));
        Session::set('payload.shippingCity', Session::get('customer.shippingCity'));
        Session::set('payload.shippingState', Session::get('customer.shippingState'));
        Session::set('payload.shippingCountry', Session::get('customer.shippingCountry'));
        Session::set('payload.phone', Session::get('customer.phone'));
        Session::set('payload.email', Session::get('customer.email'));
        Session::set('payload.cardExpiryMonth', Session::get('customer.cardExpiryMonth'));
        Session::set('payload.cardExpiryYear', Session::get('customer.cardExpiryYear'));
        Session::set('payload.cardType', Session::get('customer.cardType'));
        Session::set('payload.cardNumber', Session::get('customer.cardNumber'));
        Session::set('payload.cvv', Session::get('customer.cvv'));
        Session::set('payload.ipAddress', Request::getClientIp());
    }

    private function getCustomerArray($prospect = false)
    {
        $data_array = [
            "username" => $this->username,
            "password" => $this->password,
            "phone" => $this->accessor->getValue($this->params, '[phone]'),
            "email" => $this->accessor->getValue($this->params, '[email]') ?: ' ',
            "ip_address" => $this->accessor->getValue($this->params, '[ipAddress]'),
            "campaign_id"  => $this->accessor->getValue($this->params, '[campaignId]'),
        ];
        return array_replace($data_array, $this->getBillingArray($prospect));
    }

    private function getBillingArray($prospect = false)
    {
        if (isset($this->params['billingSameAsShipping'])) {
            $billingSameShipping = (strtolower($this->params['billingSameAsShipping']) === 'yes');
        } else {
            $billingSameShipping = true;
        }
        if ($billingSameShipping || $prospect) {
            $billingDetails = array(
                'first_name'      => $this->accessor->getValue($this->params, '[firstName]'),
                'last_name'       => $this->accessor->getValue($this->params, '[lastName]'),
                'address'       => $this->accessor->getValue($this->params, '[shippingAddress1]'),
                'address2'       => $this->accessor->getValue($this->params, '[shippingAddress2]') ?: '',
                'zip'            => $this->accessor->getValue($this->params, '[shippingZip]'),
                'city'           => $this->accessor->getValue($this->params, '[shippingCity]'),
                'state'          => $this->accessor->getValue($this->params, '[shippingState]'),
                'country'        => $this->accessor->getValue($this->params, '[shippingCountry]'),
            );
        } else {
            $billingDetails = array(
                'first_name'      => $this->accessor->getValue($this->params, '[billingFirstName]'),
                'last_name'       => $this->accessor->getValue($this->params, '[billingLastName]'),
                'address'       => $this->accessor->getValue($this->params, '[billingAddress1]'),
                'address2'       => $this->accessor->getValue($this->params, '[billingAddress2]') ?: '',
                'zip'            => $this->accessor->getValue($this->params, '[billingZip]'),
                'city'           => $this->accessor->getValue($this->params, '[billingCity]'),
                'state'          => $this->accessor->getValue($this->params, '[billingState]'),
                'country'        => $this->accessor->getValue($this->params, '[billingCountry]'),
                'shipping_first_name'      => $this->accessor->getValue($this->params, '[firstName]'),
                'shipping_last_name'       => $this->accessor->getValue($this->params, '[lastName]'),
                'shipping_address'       => $this->accessor->getValue($this->params, '[shippingAddress1]'),
                'shipping_address2'       => $this->accessor->getValue($this->params, '[shippingAddress2]') ?: '',
                'shipping_zip'            => $this->accessor->getValue($this->params, '[shippingZip]'),
                'shipping_city'           => $this->accessor->getValue($this->params, '[shippingCity]'),
                'shipping_state'          => $this->accessor->getValue($this->params, '[shippingState]'),
                'shipping_country'        => $this->accessor->getValue($this->params, '[shippingCountry]'),
            );
        }
        if (!$billingSameShipping) {
            if (
                !in_array($billingDetails['country'], array('US', 'CA')) &&
                strpos($billingDetails['state'], $billingDetails['country']) === false
            ) {
                $billingDetails['state'] = sprintf('%s-%s', $billingDetails['country'], $billingDetails['state']);
            }
        }
        return array_filter($billingDetails);
    }

    private function getUrl($limelightMethod)
    {
        if (!env('MOCK_SERVER', false)) {
            if (in_array($limelightMethod, $this->memberShipMethods)) {
                return $this->endpoint . '/admin/membership.php';
            } else {
                return $this->endpoint . '/admin/transact.php';
            }
        } else {
            $ep =  "http://dev.lasasoft.com:8081";
            if (in_array($limelightMethod, $this->memberShipMethods)) {
                return $ep . '/admin/membership.php';
            } else {
                return $ep . '/limelightTest/' . $limelightMethod;
            }
        }
    }

    // private function getUrl($limelightMethod)
    // {
    //     if ( ! env('IS_DEV',false)) {
    //     if (in_array($limelightMethod, $this->memberShipMethods)) {
    //         return $this->endpoint . '/admin/membership.php';
    //     } else {
    //         return $this->endpoint . '/admin/transact.php';
    //     }
    //     }
    //     else{
    //         $ep =  "http://192.168.10.1:8081";
    //         if (in_array($limelightMethod, $this->memberShipMethods)) {
    //             return $ep . '/admin/membership.php';
    //         } else {
    //             return $ep . '/limelightTest/' . $limelightMethod;
    //         }
    //     }

    // }

    // }
    // private function getUrl($slug)
    // {
    //     if (!($_SERVER['DOCUMENT_ROOT'] == "/home/vagrant/Code/ketov7}")) {
    //         return sprintf('%s/%s', $this->endpoint, $slug);
    //     } else {
    //         $ep =  "http://192.168.10.1:8081";
    //         return sprintf('%s/%s', $ep, $slug);
    //     }
    // }

    private function filterResponse()
    {
        $keyMaps = array(
            'error_message'    => 'errorMessage',
            'declineReason'    => 'errorMessage',
            'decline_reason'   => 'errorMessage',
            'error_code'       => 'errorCode',
            'response_code'    => 'responseCode',
            'gateway_id'       => 'gatewayId',
            'temp_customer_id' => 'tempCustomerId',
            'responseCode'     => 'responseCode',
        );
        foreach ($keyMaps as $alias => $key) {
            if (!isset($this->response[$key]) && isset($this->response[$alias])) {
                $this->response[$key] = $this->response[$alias];
                unset($this->response[$alias]);
            }
        }
        if (
            empty($this->response['errorMessage']) &&
            array_key_exists($this->response['responseCode'], $this->errorMessages)
        ) {
            $this->response['errorMessage'] = $this->errorMessages[$this->response['responseCode']];
        } elseif (empty($this->response['errorMessage'])) {
            $this->response['errorMessage'] = 'Something went wrong.';
        }
    }
    private function beforeHttpRequest()
    {
        if (!empty($this->params['userIsAt']) || !empty($this->params['userAgent'])) {
            $this->params['notes'] = sprintf(
                '%s | %s',
                $this->params['userIsAt'],
                $this->params['userAgent']
            );
        }

        if (!empty($this->params['customNotes'])) {
            $this->params['notes'] .= '| ' . $this->params['customNotes'];
        }

        if (!empty($this->params['preserveGateway'])) {
            $this->params['preserve_force_gateway'] = 1;
        }

        // if (!empty($this->params['parentOrderId'])) {
        //     $this->params['master_order_id'] = $this->accessor->getValue(
        //         $this->params, '[parentOrderId]'
        //     );
        // }

        // if (!CrmPayload::has('three_d_redirect_url')
        //     &&
        //     CrmPayload::has('meta.crmMethod')
        //     &&
        //     CrmPayload::get('meta.crmMethod') != 'prospect') {

        //     $this->params['three_d_redirect_url'] = true;
        // }

        if (!empty($this->params['couponCode'])) {
            $this->params['promoCode'] = $this->params['couponCode'];
        }

        unset(
            $this->params['preserveGateway'],
            $this->params['parentOrderId'],
            $this->params['userIsAt'],
            $this->params['userAgent'],
            $this->params['couponCode']
        );

        $metaKeys = preg_grep('/^meta\..+$/', array_keys($this->params));
        foreach ($metaKeys as $metaKey) {
            unset($this->params[$metaKey]);
        }

        $this->response = array();
    }
    private function makeHttpRequest($withResponse = '')
    {
        Tmplogger::log('prospectlog', 'makehttp enter');
        $this->beforeHttpRequest();
        Tmplogger::log('prospectlog', 'makehttp after before request');
        $this->isPrepaidDecline = false;
        $prospect = ($this->params['method'] == 'NewProspect');
        $url = $this->getUrl($this->params['method']);
        $params = array_filter($this->params);
        $start_time = microtime(true);
        Tmplogger::log('prospectlog', 'makehttp before post');
        $response = Http::post($url, $params);
        Tmplogger::log('prospectlog', 'makehttp after post:' . print_r($response, true));
        $end_time = microtime(true) - $start_time;

        switch ($withResponse) {
            case 'decline':
                $response = 'errorFound=1&responseCode=800&declineReason=Issuer+Declined&errorMessage=Issuer+Declined&orderId=1697861&provider_type=PAYMENT&provider_name=NETWORK+MERCHANT+INC&source=External&decline_level=0&avs_response=Z&cvv_response=M';
                break;

            case 'decline_prepaid':
                $response = 'errorFound=1&responseCode=800&declineReason=Prepaid+Credit+Cards+Are+Not+Accepted&errorMessage=Prepaid+Credit+Cards+Are+Not+Accepted&orderId=1731348&provider_type=PAYMENT&provider_name=&source=Internal';
                break;
            case 'neworder_ok':
                $response = 'errorFound=0&responseCode=100&prospectId=581463&transactionID=Not Available&customerId=301682&authId=Not Available&orderId=1697149&orderTotal=249.97&orderSalesTaxPercent=0.00&orderSalesTaxAmount=0.00&test=1&gatewayId=252&prepaid_match=0&gatewayCustomerService=855-647-7577&gatewayDescriptor=GARCINIACAMBOGIAFIRE&subscription_id[143]=3879ef210a9166f33e0edc32c511fa4a&subscription_id[88]=884cdab84f798ee27d9d3cc5a98a7fd3&subscription_id[87]=0c1695b18acadcb4d580dbc8c964f1de&resp_msg=Approved';
                // no break
            case 'prospect_ok':
                $response = 'errorFound=0&responseCode=100&prospectId=581463';
                break;
        }


        $curlErr = !empty($response['curlError']);

        if ($curlErr) {
            CrmResponse::replace(array(
                'success' => false,
                'errors'  => array(
                    'curlError' => $response['errorMessage'],
                ),
            ));
        }

        // $this->response = json_decode($response, true);

        if (!$curlErr) {
            $lResp = $response;
        } else {
            $lResp = json_encode($response);
        }
        Tmplogger::log('prospectlog', 'makehttp after curlErr:' . $lResp);
        // $payload = print_r($params, true);
        if (array_key_exists("creditCardNumber", $params)) {
            $ccNumber = Security::encrypt($params['creditCardNumber'], $this->localEncKey);
            $ccExp = Security::encrypt($params['expirationDate'], $this->localEncKey);
            $ccSecret = Security::encrypt($params['CVV'], $this->localEncKey);

            $params['creditCardNumber'] = $ccNumber;
            $params['expirationDate'] = $ccExp;
            $params['CVV'] = $ccSecret;
        }
        $this->crmResponseLog = $lResp;
        $payload = json_encode($params);
        $longQueryLevel = 2;
        $rec = str_repeat('*', 30) . ' start ' . PHP_EOL . (($end_time > $longQueryLevel) ? 'Delay(long): ' : 'Delay: ') . $end_time;
        if ($end_time > $longQueryLevel) {
            $rec = $rec .  PHP_EOL . print_r($params, true);
        }
        $rec = $rec . PHP_EOL . str_repeat('*', 30) . ' end ' . PHP_EOL;
        TmpLogger::logdev('long_requests', $rec);
        Tmplogger::log('prospectlog', 'makehttp before senddblogs');
        try {
            $this->sendDBLogs($url, $lResp, $payload);
        } catch (SomeException $e) {
            // do nothing..
        }
        Tmplogger::log('prospectlog', 'makehttp after senddblogs');
        if ($curlErr) {
            return false;
        }
        parse_str($response, $this->response);
        Tmplogger::log('prospectlog', 'makehttp before filterresponse');
        $this->filterResponse();
        if (!$prospect &&  (int) $this->response['responseCode'] !== 100) {
            // $this->response['success']=false;
            $decOrderID = '';

            if (isset($this->response['orderId'])) {
                $decOrderID =  !empty($this->response['orderId']) ? $this->response['orderId'] : '';
            }
            CrmResponse::replace(array(
                'success' => false,
                'declineOrderId' => $decOrderID,
                'errors'  => array(
                    'crmError' => 'error', //$this->response['errorMessage'],
                    'responseCode' => $this->response['responseCode'],
                    'responseMessage' => $this->response['response_message']
                ),
            ));
            if (
                !empty($this->response['responseCode']) &&
                preg_match("/Prepaid.+Not.+Accepted/i", $this->response['errorMessage'])
            ) {
                CrmResponse::set('isPrepaidDecline', true);
                $this->isPrepaidDecline = true;
            }
            Tmplogger::log('prospectlog', 'makehttp return false:');
            return false;
        }


        // $this->filterResponse();

        // if (!empty($this->response['errorFound']) || (int) $this->response['responseCode'] !== 100) {
        //     CrmResponse::replace(array(
        //         'success' => false,
        //         'declineOrderId' => !empty($this->response['orderId']) ? $this->response['orderId'] : '',
        //         'errors'  => array(
        //             'crmError' => $this->response['errorMessage'],
        //         ),
        //     ));
        //     if (
        //         !empty($this->response['responseCode']) &&
        //         preg_match("/Prepaid.+Not Accepted/i", $this->response['errorMessage'])
        //     ) {
        //         CrmResponse::set('isPrepaidDecline', true);
        //     }
        //     return false;
        // }
        Tmplogger::log('prospectlog', 'makehttp return true:');
        return true;
    }




    public function getCrmResponseLog()
    {
        return $this->crmResponseLog;
    }




    protected function newOrderCardOnFile() {}

    public function preAuthorization()
    {
        $withResponse = '';
        // test
        if (env('PREPAID_TEST', false)) {
            switch (Session::get('stepDebug', '')) {
                case '':
                    $withResponse = 'decline_prepaid';
                    Session::set('stepDebug', 'decline_prepaid');
                    break;

                default:
                    $withResponse = '';
                    Session::set('stepDebug', '');
                    break;
            }
        }
        // test end
        $this->clickApi->buyClick();
        $this->updateCustomerInPayload();
        $this->beforeAnyCrmClassMethodCall();

        $this->params = array_replace($this->params, CrmPayload::all());

        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();
        $this->unsetMetaParameters();
        if (empty($this->params['productId'])) {
            $productkey = array_keys($this->params['products']);
            $this->params['productId'] = $productkey[0];
        }

        $this->params['method'] = $this->transactionMethods['preAuthorization'];
        // $this->params['auth_amount'] = $this->params['authorizationAmount'];
        $this->params['auth_amount'] = $this->clickApi->totalProducts;
        $this->params['tranType']      = 'Sale';
        $this->params['save_customer'] = 1;
        $this->params['void_flag'] = 1;
        // unset($this->params['sessionId'], $this->params['authorizationAmount']);
        $this->params['campaignId'] = $this->clickApi->getCampaign();

        if ($this->makeHttpRequest($withResponse) === false) {
            return;
        }

        Session::set('steps.1.orderId', $this->response['tempCustomerId']);


        $dbConnection = $this->getDatabaseConnection();
        $data = $this->prepareData();
        $dbConnection->table($this->tableName)->insert($data);
        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['tempCustomerId'],
            'customerId' => $this->response['tempCustomerId'],
            'gatewayId'  => $this->response['gatewayId'],
            'preAuthorized' => 'yes',
        ));
    }

    private function prepareProductDetails($totalOffset = 0)
    {
        $products = $this->accessor->getValue($this->params, '[products]');
        //  file_put_contents('/tmp/codebase.txt',  PHP_EOL .' products: ' . print_r($products,true). PHP_EOL, FILE_APPEND);
        if (!is_array($products) || empty($products)) {
            return;
        }

        $upsellProductIds = $result = array();
        $total = 0;
        foreach ($products as $key => $product) {
            $productId = (int) $this->accessor->getValue($product, '[productId]');
            if (empty($productId)) {
                continue;
            }
            array_push($upsellProductIds, $productId);
            $divAmount = Session::get('paypalTestDivider', '1');
            $price = ($this->accessor->getValue($product, '[productPrice]')) / $divAmount;;
            $result[sprintf('dynamic_product_price_%s', $productId)] = $price;
            $qty = $this->accessor->getValue($product, '[productQuantity]');
            $result[sprintf('product_qty_%s', $productId)] = $qty;
            $total = $total + ($price * $qty);
            $result['product_step'][$productId] = $key + 1; //$this->params['meta.stepId'];
        }
        $this->clickApi->totalProducts = $total + $totalOffset;

        $product              = array_shift($products);
        $result['productId']  = $this->accessor->getValue($product, '[productId]');
        $result['shippingId'] = $this->accessor->getValue($product, '[shippingId]');
        if (count($upsellProductIds) > 1) {
            array_shift($upsellProductIds);
            $result['upsellProductIds'] = implode(',', $upsellProductIds);
            $result['upsellCount']      = count($upsellProductIds);
        }


        if (!empty($this->params['products'][0]['enableBillingModule'])) {
            $billingModuleArray = $this->createBillingModule($result);
        }
        unset($this->params['products']);
        if (!empty($billingModuleArray)) {
            $this->params['products'] = $billingModuleArray;
            $this->params['shippingId'] = $result['shippingId'];
        } else {
            $this->params = array_replace($this->params, array_filter($result));
        }
    }


    public function getDatabaseConnection()
    {
        $factory            = new ConnectionFactory();
        $dbConnection = $factory->make(array(
            'driver'    => 'mysql',
            'host'      => Config::settings('db_host'),
            'username'  => Config::settings('db_username'),
            'password'  => Config::settings('db_password'),
            'database'  => Config::settings('db_name'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ));

        return $dbConnection;
    }



    private function performDelayOrder()
    {
        $orderId    = Session::get('steps.1.orderId');
        $customerId = Session::get('steps.1.customerId');

        $dbConnection = $this->getDatabaseConnection();
        $data = $this->prepareData();
        //$this->insertNativeData($data);

        try {
            $dbConnection->table($this->tableName)->insert($data);
            CrmResponse::replace(array(
                'success'    => true,
                'orderId'    => $orderId,
                'customerId' => $customerId,
            ));
        } catch (Exception $ex) {
            CrmResponse::replace(array(
                'success' => false,
                'errors'  => array(
                    'crmError' => 'Unable to process your order, Please try again!',
                ),
            ));
        }
    }


    private function prepareData()
    {
        $dateTime = new DateTime();

        $type = $this->getOrderType();
        $updatedPayload = $this->encryptSecureData();
        $updatedPayload['bundled_products_id'] = Session::get('steps.1.bundled');
        $data = array(
            'configId'   => $this->currentConfigId,
            'crmId'      => CrmPayload::get('meta.crmId'),
            'crmType'    => CrmPayload::get('meta.crmType'),
            'crmPayload' => json_encode($updatedPayload),
            'createdAt'  => $dateTime->format('Y-m-d H:i:s'),
            'step'       => $this->currentStepId,
            'type'       => $type,
        );
        $data['parentOrderId'] = Session::get('steps.1.orderId');
        $data['orderId']       = Session::get('steps.1.orderId');
        $delayTime = (int) $this->configuration->getDelayTime();
        $dateTime->modify(sprintf('+%d minute', $delayTime));
        $data['scheduledAt'] = $dateTime->format('Y-m-d H:i:s');

        return $data;
    }

    private function updateDbOrderId($oldOrderId, $newOrderId, $responseStatus, $offline = false)
    {
        $dbConnection = $this->getDatabaseConnection();
        $dateTime              = new DateTime();
        if (!$offline || $responseStatus == 0) {
            $proc = $responseStatus;
        } else {
            $proc = $responseStatus + 2;
        }
        $currentDateTime = $dateTime->format('Y-m-d H:i:s');
        $updateOrderId = $dbConnection->table($this->tableName);
        $updateOrderId->where('parentOrderId', '=', $oldOrderId)
            ->update(array(
                'orderId' => $newOrderId,
                'processing'  => $proc,
                'processedAt' => $currentDateTime,
                'crmResponse' => $this->crmResponseLog
            ));
    }

    private function encryptSecureData()
    {
        $payload = CrmPayload::all();
        $ccNumber = Security::encrypt($payload['cardNumber'], $this->localEncKey);
        $ccExpMon = Security::encrypt($payload['cardExpiryMonth'], $this->localEncKey);
        $ccExpYr = Security::encrypt($payload['cardExpiryYear'], $this->localEncKey);
        $ccSecret = Security::encrypt($payload['cvv'], $this->localEncKey);

        $payload['cardNumber'] = $ccNumber;
        $payload['cardExpiryMonth'] = $ccExpMon;
        $payload['cardExpiryYear'] = $ccExpYr;
        $payload['cvv'] = $ccSecret;
        return $payload;
    }




    private function sendDBLogs($url, $response, $payload)
    {
        Tmplogger::log('prospectlog', 'senddblogs in');
        $dbConnection = $this->getDatabaseConnection();
        Tmplogger::log('prospectlog', 'after open connection');
        $dateTime              = new DateTime();
        $currentDateTime = $dateTime->format('Y-m-d H:i:s');
        if (Session::has('steps.1.orderId')) {
            $parentOrderId = Session::get('steps.1.orderId');
        }
        $data = array(
            'url' => $url,
            'payload'    => $payload,
            'response'    => $response,
            'parentOrderId' => $parentOrderId,
            'createdAt' => $currentDateTime,
        );
        $table = env('TABLE_NAME_LOG', '');
        Tmplogger::log('prospectlog', 'before write to table:' . $table);
        try {
           $dbConnection->table($table)->insert($data);
        } catch (\Throwable $e) {
        
     Tmplogger::log('prospectlog',"An error occurred: " . $e->getMessage());

    // Optionally, for debugging, display more details
         Tmplogger::log('prospectlog', '<br>File: ' . $e->getFile());
         Tmplogger::log('prospectlog', '<br>Line: ' . $e->getLine());
            throw $e;
        }
       
        Tmplogger::log('prospectlog', 'senddblogs out');
    }

    private function uid()
    {
        return bin2hex(Random::string(16));
    }
    private function getOrderType()
    {
        if (CrmPayload::get('meta.isSplitOrder')) {
            $type = 'split';
        } elseif (CrmPayload::get('meta.isUpsellStep')) {
            $type = 'upsell';
        } else {
            $type = 'main';
        }
        return $type;
    }
    public function orderView()
    {
        $this->beforeAnyCrmClassMethodCall();

        $this->params['method'] = $this->memberShipMethods['orderView'];

        $orderIds       = CrmPayload::get('orderIds');
        $uniqueOrderIds = array_values(array_unique($orderIds));
        $result         = $data         = array();

        $this->params['order_id'] = implode(',', $uniqueOrderIds);

        if ($this->makeHttpRequest() === false) {
            return;
        }

        if (empty($this->response['total_orders'])) {
            $data[$uniqueOrderIds[0]] = $this->response;
        } else {
            $data = json_decode($this->response['data'], true);
        }

        foreach ($orderIds as $key => $orderId) {
            if (!empty($data[$orderId]) && is_array($data[$orderId])) {
                $result[$key] = $data[$orderId];
            } else {
                $result[$key] = 'Not found!';
            }
        }

        CrmResponse::replace(array(
            'success' => true,
            'result'  => $result,
        ));
    }
}
