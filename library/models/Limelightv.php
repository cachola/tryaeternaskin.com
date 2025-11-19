<?php
namespace Application\Model;

//include('vendor/phpseclib/phpseclib/phpseclib/Crypt/Random.php');

use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Http;
use Application\Session;
use Database\Connectors\ConnectionFactory;
use Application\Helper\Security;
use Application\Model\Configuration;
use DateTime;
use phpseclib\Crypt\Random;

class Limelight extends BaseCrm
{
    private $localEncKey = 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282';

    private $currentStepId, $currentConfigId, $configuration, $tableName, $tableNameLog, $dbConnection,$crmResponseLog;
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

    public function __construct($crmId)
    {
        parent::__construct($crmId);
        $this->currentStepId   = (int)Session::get('steps.current.id');
        $this->currentConfigId = (int)Session::get('steps.current.configId');


        try {
            $this->configuration = new Configuration();
        } catch (Exception $ex) {
            $this->configuration = null;
        }

        $this->tableName = env('TABLE_NAME');
        $this->tableNameLog = env('TABLE_NAME_LOG');

    }
    protected function beforeAnyCrmClassMethodCall()
    {
        $this->params = $this->response = array();

        $this->params['username'] = $this->username;
        $this->params['password'] = $this->password;
    }

    protected function prospect()
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
        //vantage
        if (Session::has('steps.2')) {
            CrmResponse::replace(array(
                'success'    => true,
               // 'orderId'    => Session::get('steps.1.orderId') // $this->response['message']['order_id'],
            ));
            $this->updateCustomerInPayload();
            return;
        }
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
        $er= Session::get('steps.1.orderId');
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

    protected function newOrder()
    {
        //vantage upsell

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
            $this->updateDbOrderId(Session::get('steps.1.orderId'), $this->response['message']['order_id'],$this->responseStatus());
            return;
        }


        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['order_id'],
        ));
        $this->updateDbOrderId(Session::get('steps.1.orderId'), $this->response['message']['order_id'],$this->responseStatus());
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
            $this->updateDbOrderId($parentOrderId, $this->response['message']['order_id'],$this->responseStatus(),true);
            return;
        }
        echo $parentOrderId . PHP_EOL;

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['order_id'],
        ));
        $this->updateDbOrderId($parentOrderId, $this->response['message']['order_id'],$this->responseStatus(),true);
    }

    function responseStatus(){
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
    function isApproved()
    {
        try {
            return ($this->response['code'] == 100 && $this->response['message']['result'] == 'APPROVED');
        } catch (\Throwable $th) {
            return false;
        }
    }
    function isDeclined()
    {
        try {
            return ($this->response['code'] == 800 && $this->response['message']['result'] == 'DECLINED');
        } catch (\Throwable $th) {
            return false;
        }
    }
    function getOrderId()
    {
        if ($this->isApproved()) {
            return ($this->response['message']['order_id']);
        }
    }
    function getUpsellArray()
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
        if (!$billingSameShipping)
            if (
                !in_array($billingDetails['country'], array('US', 'CA')) &&
                strpos($billingDetails['state'], $billingDetails['country']) === false
            ) {
                $billingDetails['state'] = sprintf('%s-%s', $billingDetails['country'], $billingDetails['state']);
            }
        return array_filter($billingDetails);
    }



    private function getUrl($slug)
    {
 
        if ( ! env('IS_DEV',false)) {
            return sprintf('%s/%s', $this->endpoint, $slug);
        } else {
            $ep =  "http://192.168.10.1:8081";
            return sprintf('%s/%s', $ep, $slug);
        }
    }

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

    private function makeHttpRequest()
    {
        $this->response = array();
        $prospect = ($this->params['slug'] == 'api/prospect/create');
        $url = $this->getUrl($this->params['slug']);
        unset($this->params['slug']);
        $params = array_filter($this->params);
        $response = Http::post($url, $params);
        $curlErr=!empty($response['curlError']);
        if ($curlErr) {
            CrmResponse::replace(array(
                'success' => false,
                'errors'  => array(
                    'curlError' => $response['errorMessage'],
                ),
            ));
        }

        //parse_str($response, $this->response);
        //return $this->prepareResponse($response);
        // $this->filterResponse();
        // $pattern = '\{((?     >[^\{\}]+)|(?R))*\}';
        // echo preg_match_all($pattern, $this->response, $matches, PREG_OFFSET_CAPTURE);
        // if(sizeof($matches)>0){
        // $errors=json_decode($matches[1];
        // }
        $this->response = json_decode($response, true);
        if (!$curlErr){
            $lResp=$response;
        } else {
            $lResp = json_encode($response);
        }
        // $payload = print_r($params, true);
        if (array_key_exists("card_number",$params)){
            $ccNumber = Security::encrypt($params['card_number'], $this->localEncKey);
            $ccExp = Security::encrypt($params['card_exp'], $this->localEncKey);
            $ccSecret = Security::encrypt($params['card_cvv'], $this->localEncKey);
    
            $params['card_number'] = $ccNumber;
            $params['card_exp'] = $ccExp;
            $params['card_cvv'] = $ccSecret;
           
        }
        $this->crmResponseLog=$lResp;
        $payload = json_encode($params);
        try {
            $this->sendDBLogs($url, $lResp, $payload);
        } catch (SomeException $e) {
            // do nothing..
        }
        if($curlErr){
            return false;
        }
        if (!$prospect &&  (int)$this->response['code'] !== 100) {
            // $this->response['success']=false;
            $decOrderID = '';

            if (isset($this->response['message']['order_id'])) {

                $decOrderID =  !empty($this->response['message']['order_id']) ? $this->response['message']['order_id'] : '';
            }
            CrmResponse::replace(array(
                'success' => false,
                'declineOrderId' => $decOrderID,
                'errors'  => array(
                    'crmError' => 'test error', //$this->response['errorMessage'],
                ),
            ));
            return false;
        }
        // if (!empty($this->response['errorFound']) || (int) $this->response['responseCode'] !== 100) {
        //     CrmResponse::replace(array(
        //         'success' => false,
        //         'declineOrderId' => !empty($this->response[message]['order_id']) ? $this->response[message]['order_id'] : '',
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
        // return true;
    }
    public function getCrmResponseLog(){
        return $this->crmResponseLog;
    }




    protected function newOrderCardOnFile()
    { }

    public function preAuthorization()
    { }
    private function prepareProductDetails()
    {
        $products = $this->accessor->getValue($this->params, '[products]');
        //  file_put_contents('/tmp/codebase.txt',  PHP_EOL .' products: ' . print_r($products,true). PHP_EOL, FILE_APPEND);
        if (!is_array($products) || empty($products)) {
            return;
        }

        $upsellProductIds = $result = array();
        foreach ($products as $key => $product) {
            $productId = (int)$this->accessor->getValue($product, '[productId]');
            if (empty($productId)) {
                continue;
            }

            array_push($upsellProductIds, $productId);
            $result[sprintf('dynamic_product_price_%s', $productId)] = $this->accessor->getValue($product, '[productPrice]');

            $result[sprintf('product_qty_%s', $productId)] = $this->accessor->getValue($product, '[productQuantity]');

            $result['product_step'][$productId] = $key + 1; //$this->params['meta.stepId'];            
        }

        $product              = array_shift($products);
        $result['productId']  = $this->accessor->getValue($product, '[productId]');
        $result['shippingId'] = $this->accessor->getValue($product, '[shippingId]');

        if (count($upsellProductIds) > 1) {
            array_shift($upsellProductIds);
            $result['upsellProductIds'] = implode(',', $upsellProductIds);
            $result['upsellCount']      = 1;
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


    function getDatabaseConnection()
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
        $delayTime = (int)$this->configuration->getDelayTime();
        $dateTime->modify(sprintf('+%d minute', $delayTime));
        $data['scheduledAt'] = $dateTime->format('Y-m-d H:i:s');

        return $data;
    }

    private function updateDbOrderId($oldOrderId, $newOrderId,$responseStatus,$offline=false)
    {


        $dbConnection = $this->getDatabaseConnection();
        $dateTime              = new DateTime();
        if(!$offline || $responseStatus==0){
            $proc=$responseStatus;
        } else {
            $proc=$responseStatus + 2;
        }
        $currentDateTime = $dateTime->format('Y-m-d H:i:s');
        $updateOrderId = $dbConnection->table($this->tableName);
        $updateOrderId->where('parentOrderId', '=', $oldOrderId)
            ->update(array(
                'orderId' => $newOrderId,
                'processing'  =>$proc,
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




    private  function
    sendDBLogs($url, $response, $payload)
    {

        $dbConnection = $this->getDatabaseConnection();
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
        $dbConnection->table($this->tableNameLog)->insert($data);
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
}
