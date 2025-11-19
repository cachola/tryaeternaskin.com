<?php

namespace Application\Model;
use Application\Request;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Http;
use Application\Registry;
use Application\Response;
use Application\Session;
use Application\Config;
use Exception;
use Application\TmpLogger;
use Application\Model\clickApi;
class Konnektive extends BaseCrm
{

    private $methodSlugMapping = array(
        'prospect'             => 'leads/import/',
        'newOrderWithProspect' => 'order/import/',
        'newOrder'             => 'order/import/',
        'newOrderCardOnFile'   => 'order/import/',
        'confirmOrder'         => 'order/confirm/',
        'importClick'          => 'landers/clicks/import/',
        'importUpsell'         => 'upsale/import/',
        'preAuthorization'     => 'order/preauth/',
        'addCustomerNote'      => 'customer/addnote/',
        'orderView'            => 'order/query/',
        'campaignQuery'        => 'campaign/query/',
        'transactionQuery'     => 'transactions/query/',
        'confirmPaypal'        => 'transactions/confirmPaypal/',
        'offlinePayment'       => 'order/import/',
        'orderQa'              => 'order/qa/'
    );
    private $skipFilterParams,$clickApi,$method;

    public function __construct($crmId)
    {
        parent::__construct($crmId);

        $this->endpoint = rtrim(
            Registry::system('systemConstants.KONNEKTIVE_API_BASE_URL'),
            '/'
        );
        $this->skipFilterParams=false;
        $this->clickApi = new clickApi();
        $this->method = '';
    }

    protected function beforeAnyCrmClassMethodCall()
    {
        $this->params = $this->response = array();
        $this->params['loginId']  = $this->username;
        $this->params['password'] = $this->password;

        $forceGatewayId = CrmPayload::get('forceGatewayId');

        if (
            !empty($forceGatewayId['evaluate']) && !empty($forceGatewayId['orderId'])
        ) {
            $currentCrmPayload = CrmPayload::all();
            $gatewayId         = $this->getGatewayIdFromOrderId($forceGatewayId['orderId']);
            CrmPayload::replace($currentCrmPayload);
            if ($gatewayId === false) {
                CrmPayload::remove('forceGatewayId');
            } else {
                CrmPayload::set('forceGatewayId', $gatewayId);
            }
        }
    }

    private function getGatewayIdFromOrderId($orderId = null)
    {
        if (empty($orderId)) {
            return false;
        }

        CrmPayload::replace(array('orderId' => $orderId));

        $this->transactionQuery();

        $transactionInfo = CrmResponse::get('transactionInfo');
        if (empty($transactionInfo['data']) || !is_array($transactionInfo['data'])) {
            return false;
        }

        $lastIndex = $lastTransactionId = 0;
        foreach ($transactionInfo['data'] as $index => $transaction) {
            if (
                !empty($transaction['transactionId']) &&
                $transaction['transactionId'] > $lastTransactionId
            ) {
                $lastTransactionId = $transaction['transactionId'];
                $lastIndex         = $index;
            }
        }

        if (!empty($transactionInfo['data'][$lastIndex])) {
            return $transactionInfo['data'][$lastIndex]['merchantId'];
        }

        return false;
    }

    protected function prospect()
    {
        $this->params = array_replace($this->params, CrmPayload::all());

        $this->prepareShippingDetails();
        $this->prepareAffiliates();

        $this->params['slug'] = $this->methodSlugMapping['prospect'];

        unset($this->params['userAgent']);

        if ($this->makeHttpRequest() === false) {
            return false;
        }

        CrmResponse::replace(array(
            'success'    => true,
            'prospectId' => $this->response['message']['orderId'],
        ));
    }

    protected function newOrderWithProspect()
    {

        $this->params = array_replace($this->params, CrmPayload::all());

        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();

        $this->params['orderId']   = $this->params['prospectId'];
        $this->params['slug'] = $this->methodSlugMapping['newOrderWithProspect'];

        unset($this->params['prospectId'], $this->params['userAgent']);

        if ($this->makeHttpRequest() === false) {
            return false;
        }

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['orderId'],
            'customerId' => $this->response['message']['customerId'],
        ));
    }

    protected function newOrder()
    {
        $this->params = array_replace($this->params, CrmPayload::all());
        $this->params ['sessionId'] = Session::get('KSDK')['sessionId'];
        $this->clickApi->buyClick();
        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();
        $paypal=array();
        $paypal['paySource']= 'PAYPAL';
        $paypal['paypalBillerId']=Session::get('paypalBillerId');
        $paypal['salesUrl']=Request::getOfferUrl() . 'checkout.php';
        $this->params = array_replace($this->params, $paypal);
        $this->params['cardNumber']=null;
        unset($this->params['parentOrderId']);
        $this->params['slug']      = $this->methodSlugMapping['newOrder'];

        unset($this->params['userAgent']);
        $this->params['campaignId'] = $this->clickApi->getCampaign();
        TmpLogger::logdev('codebase', 'neworder before request $params:' . print_r($this->params, true) . PHP_EOL);
        $this->skipFilterParams=true;
        if ($this->makeHttpRequest() === false) {
            return false;
        }
        Session::set('orderDetails',$this->response['message']);
        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['orderId'],
            'customerId' => $this->response['message']['customerId'],
            'paypalUrl' => $this->response['message']['paypalUrl'],
        ));
    }
    protected function newOrderOrig()
    {
        $this->method = 'newOrderOrig';
        $this->params = array_replace($this->params, CrmPayload::all());
        $this->updateCustomerInPayload();
        $this->params ['sessionId'] = Session::get('KSDK')['sessionId'];
        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();

        unset($this->params['orderId'], $this->params['parentOrderId']);
        $this->params['slug']      = $this->methodSlugMapping['newOrder'];

        unset($this->params['userAgent']);
        $this->params['campaignId'] = $this->clickApi->getCampaign();
        TmpLogger::logdev('codebase', 'neworder before request $params:' . print_r($this->params, true) . PHP_EOL);
        $this->skipFilterParams=true;
        if ($this->makeHttpRequest() === false) {
            return false;
        }
        Session::set('orderDetails',$this->response['message']);
        $orderId = $this->response['message']['orderId'];
        $convertAt = $this->response['message']['dateCreated'];
        $this->clickApi->convertClick($orderId,$convertAt);
        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['orderId'],
            'customerId' => $this->response['message']['customerId'],
        ));
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
    }




    protected function newOrderCardOnFile()
    {
        $this->params = array_replace($this->params, CrmPayload::all());

        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareAffiliates();

        $this->params['paySource'] = 'ACCTONFILE';
        $this->params['slug']      = $this->methodSlugMapping['newOrderCardOnFile'];
        unset($this->params['cardNumber'], $this->params['cardType'],
        $this->params['cardExpiryYear'], $this->params['cardExpiryMonth'],
        $this->params['cvv'], $this->params['userAgent']);

        if ($this->makeHttpRequest() === false) {
            return false;
        }

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['orderId'],
            'customerId' => $this->response['message']['customerId'],
        ));
    }

    protected function importUpsell()
    {
        $this->params = array_replace($this->params, CrmPayload::all(),$_POST,Session::get('Paypal'));

        //  $this->prepareAffiliates();
        for ($i=1; $i < 7 ; $i++) { 

            if (!in_array( $this->params['productfld' . $i], array('187','206','207'))) {


            unset($this->params['productfld' . $i]);
            unset($this->params['quantityfld' . $i]);
            unset($this->params['pricefld' . $i]);
     
        }
    }
        $this->prepareProductDetails();

        $this->params['slug'] = $this->methodSlugMapping['importUpsell'];

        unset($this->params['userAgent']);

        if ($this->makeHttpRequest() === false) {
            return false;
        }

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $this->response['message']['orderId'],
            'customerId' => $this->response['message']['customerId'],
        ));
    }

    public function preAuthorization()
    {

        $this->beforeAnyCrmClassMethodCall();

        $this->params = array_replace($this->params, CrmPayload::all());

        $this->prepareShippingDetails();
        $this->prepareBillingDetails();
        $this->prepareProductDetails();
        $this->prepareCardDetails();
        $this->prepareAffiliates();

        $this->params['slug']      = $this->methodSlugMapping['preAuthorization'];
        unset($this->params['customerId'], $this->params['userAgent']);

        if ($this->makeHttpRequest() === false) {
            return;
        }

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => strtoupper(uniqid()),
            'customerId' => strtoupper(uniqid()),
            'gatewayId'  => CrmPayload::get('forceGatewayId'),
        ));
    }

    public function importClick()
    {
        $this->clickApi->buyClick();
        $this->beforeAnyCrmClassMethodCall();
        $this->params = array_replace($this->params, CrmPayload::all());
        $this->params['campaignId'] = $this->clickApi->getCampaign();
        $this->params['slug'] = $this->methodSlugMapping['importClick'];
        if ($this->makeHttpRequest() === false) {
            return;
        }
        CrmResponse::replace(array(
            'success'   => true,
            'sessionId' => $this->accessor->getValue($this->response, '[message][sessionId]'),
        ));

    }

    public function confirmOrder()
    {

        $this->beforeAnyCrmClassMethodCall();

        $this->params = array_replace($this->params, CrmPayload::all());
        $orderDetails=Session::get('orderDetails');
        $this->params['orderId']=$orderDetails['orderId'];
        $this->params['slug'] = $this->methodSlugMapping['confirmOrder'];

        if ($this->makeHttpRequest() === false) {
            return;
        }

        CrmResponse::replace(array('success' => true));
    }

    public function addCustomerNote()
    {

        $this->beforeAnyCrmClassMethodCall();

        $this->params = array_replace($this->params, CrmPayload::all());

        $this->params['slug'] = $this->methodSlugMapping['addCustomerNote'];

        if ($this->makeHttpRequest() === false) {
            return;
        }

        CrmResponse::replace(array('success' => true));
    }

    public function orderView()
    {

        $this->beforeAnyCrmClassMethodCall();

        $orderIds       = CrmPayload::get('orderIds');
        $uniqueOrderIds = array_unique($orderIds);
        $result         = $data         = array();
        foreach ($uniqueOrderIds as $orderId) {
            $this->params['slug']    = $this->methodSlugMapping['orderView'];
            $this->params['orderId'] = $orderId;
            if ($this->makeHttpRequest() === false) {
                $data[$orderId] = 'Not Found';
                continue;
            }
            if (!empty($this->response['message'])) {
                $data[$orderId] = $this->response['message'];
            } else {
                $data[$orderId] = 'Unexpected error';
            }
        }

        foreach ($orderIds as $key => $orderId) {
            $result[$key] = $data[$orderId];
        }

        CrmResponse::replace(array(
            'success' => true,
            'result'  => $result,
        ));
    }

    public function campaignQuery()
    {

        $this->beforeAnyCrmClassMethodCall();

        $this->params['campaignId'] = CrmPayload::get('campaignId');
        $this->params['slug']       = $this->methodSlugMapping['campaignQuery'];

        if ($this->makeHttpRequest() === false) {
            return;
        }

        CrmResponse::replace(array(
            'success' => true, 'campaignInfo' => $this->response['message'],
        ));
    }

    public function validateCoupon()
    {

        $this->beforeAnyCrmClassMethodCall();

        $campaignId = CrmPayload::get('campaignId');
        $couponCode = CrmPayload::get('couponCode');

        $this->campaignQuery();

        if (CrmResponse::get('success') !== true) {
            return;
        }

        $campaignInfo = CrmResponse::get('campaignInfo');

        if (
            empty($campaignInfo['data'][$campaignId]['coupons']) ||
            !is_array($campaignInfo['data'][$campaignId]['coupons'])
        ) {
            CrmResponse::replace(array(
                'success' => false,
                'errors'  => array(
                    'crmError' => 'No coupons available!',
                ),
            ));
            return;
        }

        $couponInfo = array();

        foreach ($campaignInfo['data'][$campaignId]['coupons'] as $coupon) {
            if ($coupon['couponCode'] === $couponCode) {
                $couponInfo = $coupon;
            }
        }

        if (empty($couponInfo)) {
            CrmResponse::replace(array(
                'success' => false,
                'errors'  => array(
                    'couponCode' => 'Invalid coupon!',
                ),
            ));
            return;
        }

        CrmResponse::replace(array(
            'success' => true, 'couponInfo' => $couponInfo,
        ));
    }

    public function transactionQuery()
    {
        $this->params['orderId'] = CrmPayload::get('orderId');
        $this->params['slug']    = $this->methodSlugMapping['transactionQuery'];
        $this->params['loginId']  = $this->username;
        $this->params['password'] = $this->password;

        if ($this->makeHttpRequest() === false) {
            return;
        }

        CrmResponse::replace(array(
            'success' => true, 'transactionInfo' => $this->response['message'],
        ));
    }

    public function confirmPaypal()
    {
        $this->beforeAnyCrmClassMethodCall();
        $this->params = array_replace($this->params, CrmPayload::all());
        $this->params ['sessionId'] = Session::get('KSDK')['sessionId'];
        $this->params ['paypalBillerId'] = Session::get('paypalBillerId');
        $this->params['slug']   = $this->methodSlugMapping['confirmPaypal'];
        if (!empty($this->params['prospectId'])) {
            $this->params['orderId']   = $this->params['prospectId'];
        }
        $this->prepareProductDetails();
        $this->params['campaignId'] = $this->clickApi->getCampaign();
        if ($this->makeHttpRequest() === false) {
            return;
        }
        Session::set('orderDetails',$this->response['message']);
        $orderId = $this->response['message']['orderId'];
        $this->clickApi->convertClick($orderId);
        Session::set('confirm_paypal_order_id',$orderId);
        CrmResponse::replace(array(
            'success'    => true,
        ));
    }

    private function beforeHttpRequest()
    {
        if (!empty($this->params['forceGatewayId'])) {
            $this->params['forceMerchantId'] = trim($this->params['forceGatewayId']);
        }
        unset($this->params['forceGatewayId'], $this->params['preserveGateway'],
        $this->params['parentOrderId'], $this->params['userIsAt'], $this->params['billingSameAsShipping']);
        $metaKeys = preg_grep('/^meta\..+$/', array_keys($this->params));
        foreach ($metaKeys as $metaKey) {
            unset($this->params[$metaKey]);
        }
        $this->response = array();
    }

    private function makeHttpRequest()
    {

        $this->beforeHttpRequest();

        $url = $this->getUrl($this->params['slug']);

        unset($this->params['slug']);
        if(isset($_SESSION['dtcNoFilter'])){
            $params=$this->params;
      
        } else{
            $params = array_filter($this->params);
        }
        TmpLogger::logdev('codebase', 'makeHttpRequest after filter $params:' . print_r($params, true) . PHP_EOL);
        $response = Http::post($url, $params);

        if (!empty($response['curlError'])) {
            CrmResponse::replace(array(
                'success' => false,
                'errors'  => array(
                    'curlError' => $response['errorMessage'],
                ),
            ));
            return false;
        }

        return $this->prepareResponse($response);
    }

    private function prepareResponse($response)
    {
        $this->response = json_decode($response, true);

        if (!empty($this->response['result']) && !empty($this->response['message']['paypalUrl'])) {
            CrmResponse::update(array(
                'success'  => true,
                'paypalUrl' => $this->response['message']['paypalUrl'],
            ));
            return true;
        }

        if (!empty($this->response['result']) && $this->response['result'] === 'MERC_REDIRECT') {
            CrmResponse::replace(array(
                'success'               => false,
                'isMerchantRedirection' => true,
                'script'                => $this->response['message']['script'],
            ));
            return false;
        }

        if (empty($this->response['result']) || $this->response['result'] !== 'SUCCESS') {
            if (is_array($this->response['message'])) {
                $this->response['message'] = sprintf(
                    '%s: %s',
                    key($this->response['message']),
                    $this->response['message'][key($this->response['message'])]
                );
            }
            $isPrepaidDecline = false;
            if (
                !empty($this->response['message']) &&
                preg_match("/Prepaid.+Not Accepted/i", $this->response['message'])
            ) {
                $isPrepaidDecline = true;
            }
            CrmResponse::replace(array(
                'success'          => false,
                'isPrepaidDecline' => $isPrepaidDecline,
                'errors'           => array(
                    'crmError' => $this->response['message'],
                ),
            ));
            return false;
        }

        return true;
    }

    private function getUrl($slug)
    { {
            if (!env('MOCK_SERVER', false)) {
                return sprintf('%s/%s', $this->endpoint, $slug);
            } else {
                if( !Session::get('isPaypalCheckout',false)){
                 $ep =  "http://192.168.10.1:8081";
                 $aa = sprintf('%s/%s', $ep . '/konnektiveTest', $slug);
                 return $aa;
                } else {
                $ep =  "http://konn.local/";
                $aa = $ep . 'konnektiveTest.php';
                $this->params['method']=array_search($this->params['slug'],$this->methodSlugMapping);
                return $aa;
                }
            }
        }
    }

    private function prepareShippingDetails()
    {
        $shippingDetails = array(
            'emailAddress' => $this->accessor->getValue($this->params, '[email]'),
            'phoneNumber'  => $this->accessor->getValue($this->params, '[phone]'),
            'address1'     => $this->accessor->getValue($this->params, '[shippingAddress1]'),
            'address2'     => $this->accessor->getValue($this->params, '[shippingAddress2]'),
            'postalCode'   => $this->accessor->getValue($this->params, '[shippingZip]'),
            'city'         => $this->accessor->getValue($this->params, '[shippingCity]'),
            'state'        => $this->accessor->getValue($this->params, '[shippingState]'),
            'country'      => $this->accessor->getValue($this->params, '[shippingCountry]'),
        );

        unset($this->params['email'], $this->params['phone'],
        $this->params['shippingAddress1'], $this->params['shippingAddress2'],
        $this->params['shippingZip'], $this->params['shippingCity'],
        $this->params['shippingState'], $this->params['shippingCountry']);

        $this->params = array_replace($this->params, array_filter($shippingDetails));
    }

    private function prepareBillingDetails()
    {
        $billingDetails = array('billShipSame' => '1');

        if (strtolower($this->params['billingSameAsShipping']) !== 'yes') {
            $billingDetails = array(
                'billShipSame'   => '0',
                'firstName'      => $this->accessor->getValue($this->params, '[billingFirstName]'),
                'lastName'       => $this->accessor->getValue($this->params, '[billingLastName]'),
                'address1'       => $this->accessor->getValue($this->params, '[billingAddress1]'),
                'address2'       => $this->accessor->getValue($this->params, '[billingAddress2]'),
                'postalCode'     => $this->accessor->getValue($this->params, '[billingZip]'),
                'city'           => $this->accessor->getValue($this->params, '[billingCity]'),
                'state'          => $this->accessor->getValue($this->params, '[billingState]'),
                'country'        => $this->accessor->getValue($this->params, '[billingCountry]'),
                'shipFirstName'  => $this->accessor->getValue($this->params, '[firstName]'),
                'shipLastName'   => $this->accessor->getValue($this->params, '[lastName]'),
                'shipAddress1'   => $this->accessor->getValue($this->params, '[address1]'),
                'shipAddress2'   => $this->accessor->getValue($this->params, '[address2]'),
                'shipPostalCode' => $this->accessor->getValue($this->params, '[postalCode]'),
                'shipCity'       => $this->accessor->getValue($this->params, '[city]'),
                'shipState'      => $this->accessor->getValue($this->params, '[state]'),
                'shipCountry'    => $this->accessor->getValue($this->params, '[country]'),
            );
        }

        unset($this->params['billingFirstName'], $this->params['billingLastName'],
        $this->params['billingAddress1'], $this->params['billingAddress2'],
        $this->params['billingCity'], $this->params['billingState'],
        $this->params['billingZip'], $this->params['billingCountry']);

        $this->params = array_replace($this->params, array_filter($billingDetails));
    }

    private function prepareProductDetails()
    {
        $result = array();

        $products = array_filter($this->params, function ($k) {
            if ((strpos($k, 'productfld')===false && strpos($k, 'quantityfld')===false && strpos($k, 'pricefld')===false) ===false) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY);
        TmpLogger::logdev('codebase', 'prepareProductDetails $products:' . print_r($products, true) . PHP_EOL);
        $total=0;
        for ($i=1; $i < 8 ; $i++) { 

            if ($products['productfld' . $i]!="") {

            $result[sprintf('product%s_id', $i )] = $products['productfld' . $i];
            $result[sprintf('product%s_qty', $i )] = $products['quantityfld' . $i];
            $result[sprintf('product%s_price', $i )] =$products['pricefld' . $i];
            $result[sprintf('product%s_shipPrice', $i )] = "0";
            $total = $total + ($result[sprintf('product%s_price', $i )] *  $result[sprintf('product%s_qty', $i )] );
        }
            unset($this->params['productfld' . $i]);
            unset($this->params['quantityfld' . $i]);
            unset($this->params['pricefld' . $i]);
     
        }
        TmpLogger::logdev('codebase', 'prepareProductDetails $result:' . print_r($result, true) . PHP_EOL);
        $this->clickApi->totalProducts = $total;


        unset($this->params['products']);

        // $this->params = array_replace($this->params, array_filter($result));
          $this->params = array_replace($this->params,$result);
          TmpLogger::logdev('codebase', 'prepareProductDetails $params:' . print_r($result, true) . PHP_EOL);

    }

    private function prepareCardDetails()
    {
        $cardDetails = array(
            'cardType'         => $this->accessor->getValue($this->params, '[cardType]'),
            'cardMonth'        => $this->accessor->getValue($this->params, '[cardExpiryMonth]'),
            'cardYear'         => !empty($this->params['cardExpiryYear']) ? '20' . $this->accessor->getValue($this->params, '[cardExpiryYear]') : '',
            'cardSecurityCode' => $this->accessor->getValue($this->params, '[cvv]'),
            'paySource'        => $this->accessor->getValue($this->params, '[paySource]'),
        );

        if (empty($cardDetails['paySource'])) {
            $cardDetails['paySource'] = 'CREDITCARD';
        }

        $cardDetails['cardType'] = strtoupper($cardDetails['cardType']);
        if ($cardDetails['cardType'] === 'MASTER') {
            $cardDetails['cardType'] .= 'CARD';
        }

        if (!empty($this->params['cardType']) && $this->params['cardType'] == 'COD') {
            $cardDetails['paySource'] = 'COD';
            unset($cardDetails['cardType']);
            unset($this->params['cardType']);
        }

        if (!empty($this->params['cardType']) && $this->params['cardType'] == 'DIRECTDEBIT') {
            unset($cardDetails['cardType']);
            unset($this->params['cardType']);
        }

        unset($this->params['cardExpiryMonth'], $this->params['cardExpiryYear'], $this->params['cvv']);

        $this->params = array_replace($this->params, array_filter($cardDetails));
    }

    private function prepareAffiliates()
    {
        $affiliates = $this->params['affiliates'];

        $affiliateParams = array_filter(array(
            'affId'        => $this->accessor->getValue($affiliates, '[affId]'),
            'sourceValue1' => $this->accessor->getValue($affiliates, '[c1]'),
            'sourceValue2' => $this->accessor->getValue($affiliates, '[c2]'),
            'sourceValue3' => $this->accessor->getValue($affiliates, '[c3]'),
            'sourceValue4' => $this->accessor->getValue($affiliates, '[c4]'),
            'sourceValue5' => $this->accessor->getValue($affiliates, '[c5]'),
        ));

        unset($this->params['affiliates']);

        $this->params = array_replace($this->params, $affiliateParams);
    }

    public static function isValidCredential($credential)
    {
        if (is_array($credential) && !empty($credential)) {
            $params = array(
                'loginId'        => $credential['username'],
                'password'       => $credential['password'],
                'resultsPerPage' => 1,
            );
            $endpoint = rtrim(
                Registry::system('systemConstants.KONNEKTIVE_API_BASE_URL'),
                '/'
            );
            $url      = sprintf('%s/campaign/query/', $endpoint);
            $response = Http::post($url, $params);
            $response = json_decode($response);
            if (
                $response->result == 'ERROR' &&
                preg_match(
                    "/Could not authenticate credentials/i",
                    $response->message
                )
            ) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function updatePaypalData()
    {
        $this->params['address1'] = $this->accessor->getValue($this->params['currentOrderData'], '[line1]');
        $this->params['city'] = $this->accessor->getValue($this->params['currentOrderData'], '[city]');
        $this->params['postalCode'] = $this->accessor->getValue($this->params['currentOrderData'], '[postal_code]');
        $this->params['state'] = $this->accessor->getValue($this->params['currentOrderData'], '[state]');
        $this->params['country'] = $this->accessor->getValue($this->params['currentOrderData'], '[country_code]');
        $this->params['creditCardType'] = 'offline';
    }

    public function offlinePayment()
    {
        $this->beforeAnyCrmClassMethodCall();

        $this->params = array_replace($this->params, CrmPayload::all());

        $prevCrmMethod = !empty($this->params['prevCrmMethod']) ? $this->params['prevCrmMethod'] : 'offlinePayment';

        if ($prevCrmMethod == 'newOrder') {
            $this->params['is_upsell'] = false;
        }

        if (empty($this->params['is_upsell'])) {
            $this->prepareShippingDetails();
            $this->prepareBillingDetails();
            $this->prepareProductDetails();
            $this->prepareCardDetails();
            $this->prepareAffiliates();
            $this->updatePaypalData();
            $this->params['paySource'] = 'PREPAID';
            $this->params['slug']      = $this->methodSlugMapping[$prevCrmMethod];
            $this->params['skipQA'] = true;
            if (!empty($this->params['prospectId'])) {
                $this->params['orderId']   = $this->params['prospectId'];
                unset($this->params['prospectId']);
            }
        } else {
            $this->prepareAffiliates();
            $this->prepareUpsellProduct();
            $prevCrmMethod = !empty($this->params['prevCrmMethod']) ? $this->params['prevCrmMethod'] : 'importUpsell';
            $this->params['slug']      = $this->methodSlugMapping[$prevCrmMethod];
            $this->params['skipQA'] = true;
        }

        unset($this->params['cardType'],  $this->params['cardNumber'], $this->params['prevCrmMethod']);

        if ($this->makeHttpRequest() === false) {
            return false;
        }

        if (!empty($this->params['is_upsell'])) {
            $this->orderQa($this->params['orderId']);
        }

        $prevPayload = CrmPayload::all();
        $prevResponse = $this->response;
        $this->addOfflineNote();

        CrmResponse::replace(array(
            'success'    => true,
            'orderId'    => $prevResponse['message']['orderId'],
            'customerId' => $prevResponse['message']['customerId'],
        ));
    }

    public function orderQa($orderId)
    {
        try {
            $params['slug'] = $this->methodSlugMapping['orderQa'];
            $url = $this->getUrl($params['slug']);
            $params['loginId']  = $this->username;
            $params['password'] = $this->password;
            $params['orderId']  = $orderId;
            $params['action']   = 'APPROVE';

            return Http::post($url, $params);
        } catch (Exception $ex) {
        }
    }

    public function addOfflineNote()
    {
        try {
            CrmPayload::update(array(
                'customerId' => $this->response['message']['customerId'],
                'message' => 'Order proceesed via Offline method. Reference ID: ' . $this->params['currentOrderData']['id']
            ));
            $this->addCustomerNote();
        } catch (Exception $ex) {
        }
    }

    public function prepareUpsellProduct()
    {
        $this->params['productId'] = $this->accessor->getValue(
            $this->params,
            '[products][0][productId]'
        );
        $this->params['productQty'] = $this->accessor->getValue(
            $this->params,
            '[products][0][productQuantity]'
        );
        $this->params['productPrice'] = $this->accessor->getValue(
            $this->params,
            '[products][0][productPrice]'
        );
        $this->params['productShipPrice'] = $this->accessor->getValue(
            $this->params,
            '[products][0][shippingPrice]'
        );

        $this->params['orderId'] = $this->accessor->getValue(
            $this->params,
            '[previousOrderId]'
        );
        unset($this->params['products'], $this->params['previousOrderId']);
    }
}
