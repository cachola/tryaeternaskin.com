<?php

namespace Application\Controller;

use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Extension;
use Application\Form\CheckoutForm;
use Application\Form\FullForm;
use Application\Form\ProspectForm;
use Application\Form\FullProspectForm;
use Application\Form\UpsellForm;
use Application\Form\ShippingForm;
use Application\Model\Campaign;
use Application\Model\Configuration;
use Application\Request;
use Application\Response;
use Application\Session;
use Application\TmpLogger;
use Application\Http;

use Exception;

class CrmsController
{
    private $crmInstance;
    private $configuration;
    private $customerData;
    private $currentConfigId;
    private $currentStepId;
    private $crmId;
    private $delayedOrdersProducts;
    private $isAuthorize;
    private $backFromPaypal;

    public function __construct()
    {
        $this->currentConfigId = (int) Session::get('steps.current.configId');
        $this->currentStepId   = (int) Session::get('steps.current.id');
        TmpLogger::logdev('log', "******CrmsController******** "  .  date("Y-m-d h:i:sa") . PHP_EOL . print_r($_REQUEST, true)
            . PHP_EOL . print_r($_SESSION, true)
            . PHP_EOL . "******CrmsController end******** "  .  date("Y-m-d h:i:sa")  . PHP_EOL);
        $this->configuration = new Configuration();
        $this->crmId         = (int) $this->configuration->getCrmId();

        $crmClass = sprintf(
            '\Application\Model\%s',
            ucfirst($this->configuration->getCrmType())
        );

        $this->crmInstance  = new $crmClass($this->crmId);
        $this->customerData = array();
        $this->extension    = Extension::getInstance();
    }

    public function prospect()
    {
        $prospectForm       = new ProspectForm();
        $this->customerData = $prospectForm->getSafeData();

        $this->preparePayload();

        CrmPayload::set('meta.crmMethod', 'prospect');

        $this->crmInstance->prospect();
        Tmplogger::log('paypal', 'customer data crmcontroller neworderpaypal:'. print_r($this->customerData, true));
        if (CrmResponse::has('success') && CrmResponse::get('success')) {
            $crmResponse = CrmResponse::all();
            foreach ($crmResponse as $key => $value) {
                if ($key === 'success') {
                    continue;
                }
                Session::set(
                    sprintf(
                        'steps.%d.%s',
                        $this->currentStepId,
                        $key
                    ),
                    $value
                );
            }
        }

        CrmResponse::set('data', Request::form()->all());
        CrmResponse::set('redirect', Session::get('steps.next.link'));

        Response::send(CrmResponse::all());
    }

    public function prospectupdate()
    {
        $prospectForm       = new FullProspectForm();
        $this->customerData = $prospectForm->getSafeData();

        $this->preparePayload();

        CrmPayload::set('meta.crmMethod', 'prospectUpdate');

        $this->crmInstance->prospectUpdate();

        if (CrmResponse::has('success') && CrmResponse::get('success')) {
            $crmResponse = CrmResponse::all();
            // foreach ($crmResponse as $key => $value) {
            //     if ($key === 'success') {
            //         continue;
            //     }
            //     Session::set(
            //         sprintf(
            //             'steps.%d.%s',
            //             $this->currentStepId,
            //             $key
            //         ),
            //         $value
            //     );
            // }
        }

        CrmResponse::set('data', Request::form()->all());
        // CrmResponse::set('redirect', Session::get('steps.next.link'));

        Response::send(CrmResponse::all());
    }


    public function fullprospect()
    {
        $prospectForm       = new FullProspectForm();
        $this->customerData = $prospectForm->getSafeData();

        $this->preparePayload();

        CrmPayload::set('meta.crmMethod', 'prospect');

        $this->crmInstance->prospect();

        if (CrmResponse::has('success') && CrmResponse::get('success')) {
           
            $crmResponse = CrmResponse::all();
            Tmplogger::log('prospectlog', 'Response in crmcontroller:'. print_r($this->$crmResponse, true));
            foreach ($crmResponse as $key => $value) {
                if ($key === 'success') {
                    continue;
                }
                Session::set(
                    sprintf(
                        'steps.%d.%s',
                        $this->currentStepId,
                        $key
                    ),
                    $value
                );
            }
            Tmplogger::log('prospectlog', 'ProspectId in Session after set:'. Session::get('steps.1.prospectId'));
            Tmplogger::log('prospectlog', 'Response:'. print_r(Session::get('steps'), true));
        }

        CrmResponse::set('data', Request::form()->all());
        CrmResponse::set('redirect', Session::get('steps.next.link'));

        Response::send(CrmResponse::all());
    }

    public function checkout()
    {
        // Session::set('isPaypalCheckout', true);
        if (!Session::has('steps.1.prospectId')) {
            Response::send(array(
                'success' => false,
                'errors'  => array(
                    'prospectId' => 'Prospect Id not found!',
                ),
                'data'    => Request::form()->all(),
            ));
        }

        $checkoutForm       = new CheckoutForm();
        $formData           = $checkoutForm->getSafeData();
        $prospectData       = ProspectForm::getSessionData();
        $this->customerData = array_replace_recursive($prospectData, $formData);
        $this->customerData = array_replace_recursive($this->customerData, Session::get('customer', array()));
        $this->placeOrder('preAuthorization');
    }

    public function upsell()
    {
        if (!Session::has('steps.1.orderId')) {
            Response::send(array(
                'success' => false,
                'errors'  => array(
                    'orderId' => 'Order Id not found!',
                ),
                'data'    => Request::form()->all(),
            ));
        }

        $upsellForm         = new UpsellForm();
        $formData           = $upsellForm->getSafeData();
        $fullFormData       = FullForm::getSessionData();

      

        $this->customerData = array_replace_recursive($fullFormData, $formData);
        $this->customerData = array_replace_recursive($this->customerData, Session::get('customer', array()));
        $forcedUpsellMethod = Session::get('forcedUpsellMethod');
        Session::remove('forcedUpsellMethod');
        $upsellPreferredMethod =   empty($forcedUpsellMethod) ? $this->configuration->getUpsellPreferredMethod() : $forcedUpsellMethod;

        $this->placeOrder(
            empty($upsellPreferredMethod) ? 'newOrder' : $upsellPreferredMethod
        );
    }

    public function downsell()
    {
        // $vip_update = Request::form()->get('vip_update', '');
        $this->backFromPaypal = (Request::form()->get('backFromPaypal', '')==true);
        // if ($vip_update!='') {
        //     $_SESSION['vip_update']=$vip_update;
        //     $PreferredMethod = 'newOrderOrig';
        // }
        if ($this->backFromPaypal) {
            $PreferredMethod = 'newOrderOrig';
        }

        Session::set('isPaypalCheckout', false);
        $fullForm           = new FullForm();
        $this->customerData = $fullForm->getSafeData();
        $this->customerData = array_replace_recursive($this->customerData, Session::get('customer', array()));
        $this->placeOrder(
            empty($PreferredMethod) ? 'preAuthorization' : $PreferredMethod
        );

        // $this->placeOrder($PreferredMethod);
    }

    public function verify()
    {
        $fullForm           = new FullForm();
        $this->customerData = $fullForm->getSafeData();

        $this->placeOrder('returnOkSaved');
    }

    public function shipping()
    {
        $shippingForm           = new ShippingForm();
        $this->customerData = $shippingForm->getSafeData();

        $this->placeOrder('returnOkSaved');
    }

    public function getAlternateProvider()
    {
        Session::set('isPaypalCheckout', true);
        $fullForm           = new FullForm();
        $this->customerData = $fullForm->getSafeData();
        $this->customerData = array_replace_recursive($this->customerData, Session::get('customer', array()));
        $this->placeOrder('getAlternateProvider');
    }

    public function newOrderPaypal($params)
    {
        Session::set('isPaypalCheckout', true);
        $_SESSION['httpRequestNoFilter']=true;
        $this->isAuthorize=true;
        $fullForm           = new FullForm();
        $this->customerData = $fullForm->getSafeData();
        $this->customerData = array_replace_recursive($this->customerData, Session::get('customer', array()), $params);
        Tmplogger::log('paypal', 'customer data crmcontroller neworderpaypal:'. print_r($this->customerData, true));
        return $this->placeOrder('newOrderPaypal');
    }

    public function validateCoupon()
    {
        $this->preparePayload(false);
        $couponCode = Request::form()->get('couponCode', '');
        $couponProductId = Request::form()->get('productId', '');

        CrmPayload::update(array(
            'email'      => Request::form()->get(
                'email',
                Session::get('customer.email', '')
            ),
            'couponCode' => $couponCode,
            'couponProductId' => $couponProductId,
        ));

        $this->crmInstance->validateCoupon();
        if (CrmResponse::get('success') === true) {
            CrmResponse::set('couponCode', $couponCode);
         
            Session::set(sprintf(
                'steps.%d.%s',
                $this->currentStepId,
                'couponCode'
            ), $couponCode);

            Session::set(sprintf(
                'steps.%d.%s',
                $this->currentStepId,
                'couponProductId'
            ), $couponProductId);


            Session::set(sprintf(
                'steps.%d.%s',
                $this->currentStepId,
                'couponAmount'
            ), CrmResponse::get('couponAmount'));
        }

        Response::send(CrmResponse::all());
    }
    public function authorize($delay_orders=array())
    {
        $postedProducts=Session::get('postedProducts', array());
        $only_authorized_product= Session::get('onlyAuthorizedProduct',false);
        $this->isAuthorize=true;
        if(!$only_authorized_product){
        $this->delayedOrdersProducts= $postedProducts;
        } else {
            $this->delayedOrdersProducts=array_slice($postedProducts,0,1,true);
        }
        $fullForm           = new FullForm();
        $this->customerData = $fullForm->getSafeData();

        return $this->placeOrder('newOrderDelayed');
    }

        public function newOrderDelayed()
    {

        if (!Session::has('steps.1.orderId')) {
            Response::send(array(
                'success' => false,
                'errors'  => array(
                    'orderId' => 'Order Id not found!',
                ),
                'data'    => Request::form()->all(),
            ));
        }

        $upsellForm         = new UpsellForm();
        $formData           = $upsellForm->getSafeData();
        $fullFormData       = FullForm::getSessionData();
        $this->customerData = array_replace_recursive($fullFormData, $formData);

        $this->placeOrder(
            'newOrderDelayed'
        );
    }
    
    public function isApproved()
    {
      return  $this->crmInstance->isApproved();
    }

       public function getOrderId()
    {
        return  $this->crmInstance->getOrderId();
    }

        public function setDelayedOrdersProducts($delayedOrdersProducts)
    {
        $this->delayedOrdersProducts = $delayedOrdersProducts;
    }

    private function placeOrder($orderPlacementMethod)
    {

        $this->makeCrmRequest($orderPlacementMethod);
        // Session::set('user_has_prepaid_card', true);
        if (CrmResponse::get('success') === false) {
            $this->retryWithPrepaidConfig($orderPlacementMethod);
            if (CrmResponse::get('success') === true) {
                Session::set('user_has_prepaid_card', true);
            }
        }

        $mainOrderResponse = CrmResponse::all();
        if (!empty($mainOrderResponse['success'])) {
            foreach ($mainOrderResponse as $key => $value) {
                if ($key === 'success') {
                    continue;
                }
                Session::set(sprintf(
                    'steps.%d.%s',
                    $this->currentStepId,
                    $key
                ), $value);
            }

            Session::set(
                sprintf('steps.%d.products', $this->currentStepId),
                CrmPayload::get('products', array())
            );

            if (Config::configurations(
                sprintf('%d.split_charge', $this->currentConfigId)
            )) {
                $splitOrderResponse              = $this->placeSplitOrder();
                $mainOrderResponse['splitOrder'] = $splitOrderResponse;
            }
        }
        if ($orderPlacementMethod != 'newOrderDelayed') {
            $mainOrderResponse['data']     = Request::form()->all();
            $mainOrderResponse['redirect'] = Session::get('steps.next.link');

            Response::send($mainOrderResponse);
        }
    }

    private function placeSplitOrder()
    {
        $splitCampaigns = Request::form()->get('splitCampaigns', null);
        if (Request::form()->has('splitCampaigns') && empty($splitCampaigns)) {
            Session::set(sprintf(
                'steps.%d.splitOrder.status',
                $this->currentStepId
            ), 'Split is disabled!');
            return array('status' => 'Split is disabled!');
        }

        $splitPreferredMethod = $this->configuration->getSplitPreferredMethod();

        $this->makeCrmRequest(
            empty($splitPreferredMethod) ? 'newOrder' : $splitPreferredMethod,
            true
        );

        $splitOrderResponse = CrmResponse::all();
        if (!empty($splitOrderResponse['success'])) {
            foreach ($splitOrderResponse as $key => $value) {
                if ($key === 'success') {
                    continue;
                }
                Session::set(sprintf(
                    'steps.%d.splitOrder.%s',
                    $this->currentStepId,
                    $key
                ), $value);
            }
            Session::set(sprintf(
                'steps.%d.splitOrder.products',
                $this->currentStepId,
                $key
            ), CrmPayload::get('products', array()));
        }
        return $splitOrderResponse;
    }

    private function retryWithPrepaidConfig($orderPlacementMethod)
    {
        if (
            Session::get('steps.meta.isPrepaidFlow') !== true &&
            CrmResponse::get('success') === false &&
            CrmResponse::has('isPrepaidDecline') &&
            CrmResponse::get('isPrepaidDecline') &&
            Config::configurations(sprintf(
                '%s.accept_prepaid_cards',
                $this->currentConfigId
            ))
        ) {
            Session::set('steps.meta.isPrepaidFlow', true);
            $this->makeCrmRequest($orderPlacementMethod);
        }
    }

    private function beforeMakeRequest($orderPlacementMethod, $isSplitOrder = false)
    {
        $this->preparePayload($isSplitOrder);

        $selecteProducts = CrmPayload::get('products');
        if ($isSplitOrder === true && empty($selecteProducts)) {
            CrmResponse::replace(array('success' => false));
            return;
        }

        if (Request::attributes()->get('action') !== 'downsell') {
            CrmPayload::set('customerId', Session::get('steps.1.customerId'));
        }

        if ($orderPlacementMethod === 'newOrderWithProspect') {
            CrmPayload::set('prospectId', Session::get('steps.1.prospectId'));
        }

        if (in_array($orderPlacementMethod, array('newOrderCardOnFile', 'importUpsell'))) {
            CrmPayload::set('previousOrderId', Session::get('steps.1.orderId'));
        }

        CrmPayload::set('meta.mainStepData', $this->getMainStepMetaData());

        if ($isSplitOrder === true) {
            if (true === $this->configuration->getLinkWithParent()) {
                CrmPayload::set('parentOrderId', Session::get(
                    sprintf('steps.%d.orderId', $this->currentStepId)
                ));
            }
        }
    }

    private function getMainStepMetaData()
    {
        $mainStepData = Session::get('steps.1', array());
        if (empty($mainStepData) || !is_array($mainStepData)) {
            return array();
        }

        $requiredKeys = array('prospectId', 'cardId', 'orderId');
        $mainStepMeta = array();
        foreach ($requiredKeys as $requiredKey) {
            if (!empty($mainStepData[$requiredKey])) {
                $mainStepMeta[$requiredKey] = $mainStepData[$requiredKey];
            }
        }
        return $mainStepMeta;
    }

    private function makeCrmRequest($orderPlacementMethod, $isSplitOrder = false)
    {
        $this->beforeMakeRequest($orderPlacementMethod, $isSplitOrder);

        $isDownsellStep = (Request::attributes()->get('action') === 'downsell' ? true : false);

        $isUpsellStep = (Request::attributes()->get('action') === 'upsell' ? true : false);

        $isPrepaidFlow = Session::get('steps.meta.isPrepaidFlow', false);

        CrmPayload::update(array(
            'meta.isDownsellStep' => $isDownsellStep,
            'meta.isUpsellStep'   => $isUpsellStep,
            'meta.isSplitOrder'   => $isSplitOrder,
            'meta.isPrepaidFlow'  => empty($isPrepaidFlow) ? false : true,
            'meta.crmMethod'      => $orderPlacementMethod,
        ));

        $this->extension->performEventActions('afterCrmPayloadReady');

        if (CrmPayload::get('meta.crmMethod') !== $orderPlacementMethod) {
            $orderPlacementMethod = CrmPayload::get('meta.crmMethod');
        }
        if($orderPlacementMethod=='newOrderDelayed'){
            call_user_func_array(array($this->crmInstance, 'newOrderDelayed'), array($this->delayedOrdersProducts));
        } else {

        call_user_func(array($this->crmInstance, $orderPlacementMethod));
        }
       
    }

    private function makeResponse()
    {
        if (CrmResponse::has('success') && CrmResponse::get('success')) {
            $currentResponse = CrmResponse::all();
            foreach ($currentResponse as $key => $value) {
                if ($key === 'success') {
                    continue;
                }
                Session::set(
                    sprintf(
                        'steps.%d.%s',
                        $this->currentStepId,
                        $key
                    ),
                    $value
                );
            }
        }

        CrmResponse::set('data', Request::form()->all());
        CrmResponse::set('redirect', Session::get('goto'));

        Response::send(CrmResponse::all());
    }

    private function preparePayload($isSplitOrder = false)
    {
        CrmPayload::replace($this->customerData);
        CrmPayload::set('meta.configId', $this->currentConfigId);
        CrmPayload::set('meta.stepId', $this->currentStepId);
        CrmPayload::set('meta.crmType', $this->configuration->getCrmType());
        CrmPayload::set('meta.crmId', $this->crmId);
        // CrmPayload::set('ipAddress', Request::getClientIp());
        // $ips='181.167.175.250, 43.249.74.21';
        $ips=Request::getClientIp();
        $ipsex=explode(',',$ips);
        CrmPayload::set('ipAddress', $ipsex[0]);
        CrmPayload::set('userAgent', Request::headers()->get('HTTP_USER_AGENT'));
        CrmPayload::set('affiliates', Session::get('affiliates', array()));
        CrmPayload::set('newSubscription', $this->configuration->getInitializeNewSubscription());

        if ($isSplitOrder) {
            CrmPayload::set('newSubscription', $this->configuration->getSplitInitializeNewSubscription());
        }
        if (($this->isAuthorize || Session::has('backFromPaypal'))) {
            $products=Session::get('postedProducts', array());
        } else {
            $products = $this->getProducts($isSplitOrder);
        }
       

        if (empty($products) || !is_array($products)) {
            if (DEV_MODE) {
                Session::set('lastException.message', sprintf(
                    'Empty product set found in configuration # %d',
                    $this->currentConfigId
                ));
            }
            throw new Exception('General config error', 1001);
        }

        CrmPayload::set('products', $products);

        CrmPayload::set('campaignId', $products[0]['campaignId']);

        if (Request::attributes()->get('action') === 'prospect'  || Request::attributes()->get('action') === 'fullprospect' || Request::attributes()->get('action') === 'prospectupdate') {
            CrmPayload::remove('products');
            if (Session::get('crmType') == 'konnektive') {
                CrmPayload::set('sessionId', Session::get('KSDK')['sessionId']);
            }
            return;
        }

        if (Request::form()->has('funnelBoxId')) {
            CrmPayload::set(
                'funnelBoxId',
                Request::form()->get('funnelBoxId')
            );
        }

        if (Request::form()->has('cardHolderName')) {
            CrmPayload::set(
                'cardHolderName',
                Request::form()->get('cardHolderName')
            );
        }

        if (!$isSplitOrder && Request::form()->has('couponCode')) {
            CrmPayload::set('couponCode', Request::form()->get('couponCode'));
        } elseif ($isSplitOrder && Request::form()->has('splitCouponCode')) {
            CrmPayload::set(
                'couponCode',
                Request::form()->get('splitCouponCode')
            );
        }

        $this->setForceGatewayIdIfRequired($isSplitOrder);
        $this->setProductAttributes($isSplitOrder, $products);
    }

    private function countdim($array)
    {
        if (is_array(reset($array))) {
            $return = $this->countdim(reset($array)) + 1;
        } else {
            $return = 1;
        }

        return $return;
    }

    private function setProductAttributes($isSplitOrder, $products)
    {
        if (!$isSplitOrder && Request::form()->has('product_attribute')) {
            $productAttribute = Request::form()->get('product_attribute');
            $proAttArray = array();
            if ($this->countdim($productAttribute) == 2) {
                foreach ($products as $value) {
                    $proAttArray['product_attribute'][$value['productId']][$productAttribute[$value['productId']]['name']] = $productAttribute[$value['productId']]['value'];
                }
            } else {
                $proAttArray = $this->mapMultiVariants($productAttribute, $products, $proAttArray);
            }
            CrmPayload::update($proAttArray);
        } elseif ($isSplitOrder && Request::form()->has('split_product_attribute')) {
            $productAttribute = Request::form()->get('split_product_attribute');
            $proSplitAttArray = array();
            if ($this->countdim($productAttribute) == 2) {
                foreach ($products as $value) {
                    $proSplitAttArray['product_attribute'][$value['productId']][$productAttribute[$value['productId']]['name']] = $productAttribute[$value['productId']]['value'];
                }
            } else {
                $proSplitAttArray = $this->mapMultiVariants($productAttribute, $products, $proSplitAttArray);
            }
            CrmPayload::update($proSplitAttArray);
        }
    }

    private function mapMultiVariants($productAttribute, $products, $proAttArray)
    {
        foreach ($productAttribute as $value1) {
            foreach ($products as $value2) {
                $proAttArray['product_attribute'][$value2['productId']][$value1[$value2['productId']]['name']] = $value1[$value2['productId']]['value'];
            }
        }
        return $proAttArray;
    }

    private function setForceGatewayIdIfRequired($isSplitOrder)
    {
        $forceGatewayId = $this->configuration->getForceGatewayId();
        if (!empty($forceGatewayId)) {
            CrmPayload::set('forceGatewayId', $forceGatewayId);
        }

        if (!empty($forceGatewayId) && $this->configuration->getPreserveGateway()) {
            CrmPayload::set('preserveGateway', true);
        }

        if (!$isSplitOrder || !$this->configuration->getSplitForceParentGateway()) {
            return;
        }

        if (Session::has(sprintf('steps.%d.gatewayId', $this->currentStepId))) {
            CrmPayload::set('forceGatewayId', Session::get(
                sprintf('steps.%d.gatewayId', $this->currentStepId)
            ));
            return;
        }

        CrmPayload::set('forceGatewayId', array(
            'evaluate' => true,
            'orderId'  => Session::get(
                sprintf('steps.%d.orderId', $this->currentStepId)
            ),
        ));
    }

    private function getProducts($isSplitOrder = false)
    {
        if ($isSplitOrder === false) {
            $campaignIds = $this->configuration->getCampaignIds();
        } else {
            $campaignIds = $this->configuration->getSplitCampaignIds();
        }

        $inputCampaigns = $this->getInputCampaigns($isSplitOrder);
        if (!empty($inputCampaigns)) {
            $requestedCampaignIds = array_keys($inputCampaigns);
        }

        if (!empty($requestedCampaignIds)) {
            $campaignIds = $requestedCampaignIds;
        }
        $products = array();
        foreach ($campaignIds as $campaignId) {
            $product = Campaign::find($campaignId);
            if (!empty($inputCampaigns[$campaignId]['quantity'])) {
                $productQuantity = (int) $inputCampaigns[$campaignId]['quantity'];

                $product['productQuantity'] = $productQuantity;
            }
            if (!empty($inputCampaigns[$campaignId]['step'])) {
                $productStep = (int) $inputCampaigns[$campaignId]['step'];

                $product['productStep'] = $productStep;
            } else {
                $product['productStep'] =$this->currentStepId;
            }

            array_push($products, $product);
        }
        // $isProspect=Request::attributes()->get('action') == 'prospect';
        // $isProspectUpdate=Request::attributes()->get('action') == 'prospectupdate';
        $isUpsell=Request::attributes()->get('action') == 'upsell' || Request::attributes()->get('action') == 'checkout';
        $isDownsell = Request::attributes()->get('action') == 'downsell';
        if ($isUpsell || ($isDownsell && (!($this->backFromPaypal ||Session::get('steps.meta.isPrepaidFlow'))))) {
            $postedProducts = Session::get('postedProducts', array());
            // $added=array_merge($postedProducts, $products);
            foreach ($products as $product) {
                $postedProducts[ $product['productStep']]=$product;
            }
            Session::set('postedProducts', $postedProducts);
        }
        return $products;
    }

    private function getInputCampaigns($isSplitOrder = false)
    {
        if ($isSplitOrder === false) {
            $inputCampaigns = Request::form()->get('campaigns', array());
        } else {
            $inputCampaigns = Request::form()->get('splitCampaigns', array());
        }
        if (empty($inputCampaigns) || !is_array($inputCampaigns)) {
            return array();
        }
        $filteredInputCampaigns = array();
        foreach ($inputCampaigns as $campaign) {
            $campaign['id'] = (int) $campaign['id'];
            if (!empty($campaign['id'])) {
                $filteredInputCampaigns[$campaign['id']] = $campaign;
            }
        }
        return $filteredInputCampaigns;
    }
}
