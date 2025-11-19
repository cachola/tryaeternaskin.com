<?php

namespace Application\Hook;

use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Helper\Provider;
use Application\Helper\Security;
use Application\Model\Campaign;
use Application\Model\Configuration;
use Application\Model\Pixel;
use Application\Model\Sixcrm;
use Application\Request;
use Application\Session;
use Application\Registry;
use Exception;
use Lazer\Classes\Database;
use Application\Model\Responsecrm;
use Database\Connectors\ConnectionFactory;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Application\Http;
use DateTime;

class Events
{

    private $configuration;
    private static $dbConnection = null;

    public function __construct()
    {
        try
        {
            $this->configuration = new Configuration();
        }
        catch (Exception $ex)
        {
            $this->configuration = null;
        }
    }

    public function injectClickIdGeneratorScript()
    {
        if (true === Session::get('pixels.clickIdGenerated'))
        {
            return;
        }
        $pixel = new Pixel();
        if ($pixel->hasClickPixels())
        {
            echo Provider::asyncScript(AJAX_PATH . 'set-click-id');
        }
    }

    public function injectKountPixelIframe()
    {
        if (
                $this->configuration === null ||
                !$this->configuration->getEnableKount() ||
                (
                Session::get('steps.current.id') === 1 &&
                Session::get('steps.current.pageType') !== 'checkoutPage'
                )
        )
        {
            return;
        }

        if (!Session::has('pixels.kountSessionId')) {
            
            if(Session::get('crmType') == 'konnektive')
            {
                $importClickSessionID = Session::get('extensions.konnektiveUtilPack.importClick.sessionId');
                Session::set('pixels.kountSessionId', !empty($importClickSessionID) ? $importClickSessionID : uniqid());
            }
            elseif(Session::get('crmType') == 'layer2')
            {
                $importClickSessionID = Session::get('extensions.L2UtilPack.importClick.sessionId');
                Session::set('pixels.kountSessionId', !empty($importClickSessionID) ? $importClickSessionID : uniqid());
            }
            else{
                Session::set('pixels.kountSessionId', uniqid());
            }
        }

        $pixel = $this->configuration->getKountPixel();

        $campaignIds = $this->configuration->getCampaignIds();
        if (!empty($campaignIds[0]))
        {
            $campaign = Campaign::find($campaignIds[0]);
        }
        else
        {
            $campaign = array('campaignId' => 0);
        }

        $tokens = array(
            'campaignId' => $campaign['campaignId'],
            'sessionId' => Session::get('pixels.kountSessionId'),
        );

        echo preg_replace_callback(
                "/\[\[([a-z0-9_]+)\]\]/i", function ($value) use ($tokens) {
            return $tokens[$value[1]];
        }, $pixel
        );
    }

    public function injectKountSessionIdIntoCrmPayload()
    {
        if (
                $this->configuration === null ||
                !$this->configuration->getEnableKount() ||
                (
                Session::get('steps.current.id') === 1 &&
                Session::get('steps.current.pageType') !== 'checkoutPage'
                )
        )
        {
            return;
        }
        CrmPayload::set(
                'sessionId', Session::get('pixels.kountSessionId')
        );
    }

    public function performTestCardActions()
    {
        if (!Session::has('customer.cardNumber'))
        {
            return;
        }
        $cardNumber = Session::get('customer.cardNumber');
        $allowedTestCards = Config::settings('allowed_test_cards');
        $testCards = array();
        foreach ($allowedTestCards as $allowedTestCard)
        {
            $parts = explode('|', $allowedTestCard);
            if (!empty($parts[0]) && $cardNumber === $parts[0])
            {
                Session::set('steps.meta.isTestCard', true);
                break;
            }
        }
        if (
                Session::get('steps.meta.isTestCard') &&
                Config::advanced('scrapper.disable_scarp_test_order')
        )
        {
            Session::set('steps.meta.isScrapFlow', false);
        }
    }

    public function injectToken()
    {
        if (Session::get('crmType') != 'sixcrm')
        {
            return;
        }

        $pageType = Session::get('steps.current.pageType');

        if (!empty($pageType) && $pageType == 'leadPage')
        {

            echo Provider::asyncScript(AJAX_PATH . 'set-token');
        }
    }

    public function setInitialToken()
    {
        if (Session::get('crmType') != 'sixcrm')
        {
            return;
        }

        $this->setToken();
    }

    public function assertToken()
    {
        if (Session::get('crmType') != 'sixcrm')
        {
            return;
        }


        $token = $this->getToken();
        if (empty($token))
        {
            $token = $this->setToken();
        }

        if (empty($token))
        {
            return;
        }

        CrmPayload::set('token', $token);

        if (
                Request::attributes()->get('action') != 'prospect' &&
                Session::has('sessionId')
        )
        {
            CrmPayload::set('session', Session::get('sessionId'));
        }
    }

    public function setToken()
    {
        if (Session::get('crmType') != 'sixcrm')
        {
            return;
        }
        $currentConfigId = (int) Session::get('steps.current.configId');
        $configuration = new Configuration($currentConfigId);


        $campaignId = $configuration->getCampaignIds();
        $campaignInfo = Campaign::find($campaignId[0]);
        CrmPayload::set('campaignId', $campaignInfo['campaignId']);
        CrmPayload::set('affiliates', Session::get('affiliates', array()));
        $sixCrm = new Sixcrm($configuration->getCrmId());

        $response = $sixCrm->acquireToken();

        if (!empty($response->response) && $response->code == 200)
        {
            $token = (string) $response->response;
            Session::set('token', $token);
            return $token;
        }
        else
        {
            return false;
        }
    }

    public function getToken()
    {
        $token = Session::get('token');

        return $token;
    }

    public function setSessionID()
    {
        if (Session::get('crmType') != 'sixcrm')
        {
            return;
        }
        if (CrmResponse::has('sessionId'))
        {
            Session::set('sessionId', CrmResponse::get('sessionId'));
        }
    }

    public function setUpsellData()
    {
        if (
                Session::get('crmType') == 'sixcrm' &&
                Session::has('steps.1.orderId')
        )
        {
            CrmPayload::set('upsellCount', Session::get('steps.current.id') - 1);
        }
    }

    public function ConfirmOrder()
    {
        if (Session::get('crmType') != 'sixcrm')
        {
            return;
        }

        $pageType = Session::get('steps.current.pageType');

        if (!empty($pageType) && $pageType == 'thankyouPage')
        {
            echo Provider::asyncScript(AJAX_PATH . 'fire-sixcrm-confirm-order');
        }
    }

    public function fireConfirmOrder()
    {
        if (
                Session::get('crmType') == 'sixcrm' &&
                Session::get('steps.current.pageType') === 'thankyouPage'
        )
        {
            Provider::orderView(
                    array(
                        0 => Session::get('queryParams.order_id')
                    )
            );
        }
    }

    public function captureAdditionalOrder()
    {
        $additionalOrderDetails = Request::form()->all();
        if (isset($additionalOrderDetails['addon_order']) && empty($additionalOrderDetails['addon_order']))
        {
            return;
        }
        if (
                Session::get('steps.current.pageType') === 'leadPage' ||
                (
                Session::has('steps.previous.id') &&
                Session::has(sprintf('additional_crm_data_%d', Session::get('steps.previous.id')))
                )
        )
        {
            return;
        }
        $currentConfigId = (int) Session::get('steps.current.configId');
        $config = Config::configurations(sprintf('%d', $currentConfigId));
        if (
                !empty($config['additional_crm']) &&
                !empty($config['additional_crm_id']))
        {
            $crmData['configId'] = $config['additional_crm_id'];
            $crmData['additionalCrmTestCard'] = $config['additional_crm_test_card'];
            $crmData['disableTestFlow'] = !empty($config['disable_test_flow']) ? $config['disable_test_flow'] : false;
            $crmData['disableProspectFlow'] = !empty($config['disable_prospect_flow']) ? $config['disable_prospect_flow'] : false;
            $crmData['forceParentGateway'] = !empty($config['force_parent_gateway']) ? $config['force_parent_gateway'] : false;
            $crmData['postRemoteData'] = !empty($config['remote_lbp']) ? $config['remote_lbp'] : false;
            $crmData['enableDataCapture'] = !empty($config['data_capture']) ? $config['data_capture'] : false;
            $crmData['crmPayloadData'] = CrmPayload::all();
            $crmData['stepID'] = (int) Session::get('steps.current.id');
            Session::set(sprintf('additional_crm_data_%d', Session::get('steps.current.id')), $crmData);
        }
    }

    public function processAdditionalOrder()
    {
        $crmData = Session::get(sprintf('additional_crm_data_%d', Session::get('steps.previous.id')));
        if (empty($crmData))
        {
            return;
        }

        if($crmData['postRemoteData'])
        {
            $this->postData();
            return;
        }

        $configuration = new Configuration($crmData['configId']);
        $crmId = $configuration->getCrmId();
        $crm = $configuration->getCrm();
        $crmType = $crm['crm_type'];
        $crmClass = sprintf(
                '\Application\Model\%s', ucfirst($crmType)
        );

        $additionalCrmTestCard = explode('|', $crmData['additionalCrmTestCard']);

        CrmPayload::update($crmData['crmPayloadData']);
        CrmPayload::set('meta.crmType', $crmType);

        $campaignId = $configuration->getCampaignIds();
        $campaignInfo = Campaign::find($campaignId[0]);
        $crmInstance = new $crmClass($crmId);
        $this->updateCRMData($crmType, $campaignInfo, $crmInstance);
        CrmPayload::set('campaignId', $campaignInfo['campaignId']);

        if ($crmData['stepID'] == 1 && empty($crmData['disableProspectFlow']))
        {
            $crmInstance->prospect();
            Session::set('additional_crm_prospect_response', CrmResponse::all());
            $this->updateProspectData($crmType);
        }
        else
        {
            CrmPayload::set('meta.crmMethod', 'newOrder');
        }

        CrmPayload::set('products', array($campaignInfo));
        if(empty($crmData['disableTestFlow']))
        {
            CrmPayload::set('cardNumber', $additionalCrmTestCard[0]);
            CrmPayload::set('cardType', $additionalCrmTestCard[1]);
        }
        else
        {
            CrmPayload::set('cardNumber', Session::get('customer.cardNumber'));
            CrmPayload::set('cardType', Session::get('customer.cardType'));
        }
        
        CrmPayload::set('meta.bypassCrmHooks', true);
        
        call_user_func_array(array($crmInstance, CrmPayload::get('meta.crmMethod')), array());
        Session::set(sprintf('additional_crm_response_%d', Session::get('steps.previous.id')), CrmResponse::all());
        $this->completeOrder($crmType, $crmInstance);
        
        if($crmData['enableDataCapture']) {
            $isDataCapture = $this->checkDataCaptureExtension();
            if($isDataCapture) {
                $this->doCapture($crmData);
            }
        }
        Session::remove(sprintf('additional_crm_data_%d', Session::get('steps.previous.id')));
    }

    private function doCapture($crmData)
    {
        $enableDeclineCapture = Config::extensionsConfig('DataCapture.enable_capture_for_decline');
        $enableLocalCapture = Config::extensionsConfig('DataCapture.enable_local_capture');
        
        $orderId = CrmResponse::get('orderId');
        if(empty($orderId)) {
            $declineOrderId = CrmResponse::get('declineOrderId');
        } 
        
        if(!empty($declineOrderId) && $enableDeclineCapture) {
            $orderId = CrmResponse::get('declineOrderId');
        }

        $affs     = Session::get('queryParams');
        $prevStep = Session::get('steps.previous.id');

        if (!empty($orderId)) {
            $sync = array(
                'card' => $crmData['crmPayloadData']['cardNumber'],
                'cvv'  => $crmData['crmPayloadData']['cvv'],
            );

            $payload = Security::encrypt(json_encode($sync), Config::settings('encryption_key'));
            $crmId   = $crmData['crmPayloadData']['meta.crmId'];

            $response = Http::post(sprintf(Registry::system('systemConstants.201CLICKS_URL') . '/api/offer-assets/%s/', Config::settings('gateway_switcher_id')), array(
                'auth_key'      => Registry::system('systemConstants.201CLICKS_AUTH_KEY'),
                'order_id'      => $orderId,
                'customer_id'   => $affs['customer_id'],
                'data'          => $payload,
                'crm_end_point' => Config::crms(sprintf('%d.endpoint', $crmId)),
            ));

            if($enableLocalCapture) {
                $dateTime = new DateTime();
                $processedAt = NULL;
                $processed = 0;
                if(!empty($response) && $response == 'success') {
                    $processedAt = $dateTime->format('Y-m-d H:i:s');
                    $processed = 1;
                }

                $data = array(
                    'data' => $payload,
                    'gateway_switcher_id' => Config::settings('gateway_switcher_id'),
                    'encryption_key' => Config::settings('encryption_key'),
                    'crm_end_point' => Config::crms(sprintf('%d.endpoint', $crmId)),
                    'order_id' => $orderId,
                    'customer_id' => $affs['customer_id'],
                );
                $dbData = array(
                    'order_id' => $orderId,
                    'customer_id' => $affs['customer_id'],
                    'data' => json_encode($data),
                    'processedAt' => $processedAt,
                    'createdAt'  => $dateTime->format('Y-m-d H:i:s'),
                    'processed' => $processed,
                );
                $dateTime->modify(sprintf('+%d minute', 60));
                $scheduledAt = $dateTime->format('Y-m-d H:i:s');
                $dbData['scheduledAt'] = $scheduledAt;
                $this->insertInDb($dbData);
            }
        }
    }
    
    private function insertInDb($dbData)
    {
        try {
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
        } catch (Exception $ex) {
            Alert::insertData(array(
                'identifier'    => 'Delayed Transactions',
                'text'          => 'Please check your database credential',
                'type'          => 'error',
                'alert_handler' => 'extensions',
            ));
            return false;
        }
        $dbConnection->table('local_data')->insert($dbData);
    }
    
    private function checkDataCaptureExtension()
    {
        $result = array(
            'success' => true,
            'extensionDataCaptureActive' => false,
        );
        
        $extensions = Config::extensions();
        
        foreach ($extensions as $extension)
        {
            if ($extension['extension_slug'] !== 'DataCapture')
            {
                continue;
            }
            if ($extension['active'] === true)
            {
                $result['extensionDataCaptureActive'] = true;
            }
            break;
        }
        return $result;
    }

    private function postData()
    {
        $payload = $this->prepareRemotePayload();
        $payload['category'] = 'ProtectShip';

        Session::set('BackupCRM.LenderLBP.params.'.Session::get('steps.previous.id'), $payload);
        echo $url = sprintf(
                '%s/insureship-load-balance/', Registry::system('systemConstants.201CLICKS_URL')
        );
        echo Config::settings('gateway_switcher_id');
        $response = Http::post($url, http_build_query($payload), array(
                    'auth-token' => Config::settings('gateway_switcher_id'),
        ));

        Session::set('BackupCRM.LenderLBP.response.'.Session::get('steps.previous.id'), $response);
        Session::remove(sprintf('additional_crm_data_%d', Session::get('steps.previous.id')));
    }

    private function prepareRemotePayload()
    {
        $params = Session::get(sprintf('additional_crm_data_%d', Session::get('steps.previous.id')));
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $type = 21;
        $payload = array_replace_recursive(array(
            'parent_order_id' => Session::get('steps.1.orderId', 0),
            'parent_campaign_id' => Session::get('steps.1.products.0.campaignId', 0),
            'type' => $type,
                ), $params['crmPayloadData']);

        $payload['method'] = $this->accessor->getValue($params, '[crmPayloadData][meta.crmMethod]');

        $payload['creditCardType'] = $this->accessor->getValue($params, '[crmPayloadData][cardType]');
        $payload['cdc'] = Security::encrypt(
                        $this->accessor->getValue($params, '[crmPayloadData][cardNumber]'), Config::settings('encryption_key')
        );
        $payload['scrt'] = Security::encrypt(
                        $this->accessor->getValue($params, '[crmPayloadData][cvv]'), Config::settings('encryption_key')
        );
        $payload['expirationDate'] = sprintf(
                '%s%s', $this->accessor->getValue($params, '[crmPayloadData][cardExpiryMonth]'), $this->accessor->getValue($params, '[crmPayloadData][cardExpiryYear]')
        );

        $payload['tranType'] = 'Sale';
        $payload['main_order_gateway_id'] = Session::get('steps.1.gatewayId', 0);
        $payload['only_gateway'] = false;
        $payload['upsell_gw_id'] = array();

        $configId = $this->accessor->getValue($params, '[configId]');
        
        $configuration = new Configuration($configId);
        $campaignId = $configuration->getCampaignIds();
        $campaignInfo = Campaign::find($campaignId[0]);
        $params['crmPayloadData']['products'][0] = $campaignInfo;
        $product = $this->accessor->getValue($params, '[crmPayloadData][products][0]');
        if (empty($product))
        {
            $product = array();
        }
        
        $payload['campaignId'] = $this->accessor->getValue($product, '[campaignId]');
        $payload['productId'] = $this->accessor->getValue($product, '[productId]');
        $payload['product_qty'] = $this->accessor->getValue($product, '[productQuantity]');
        $payload['dynamic_product_price'] = $this->accessor->getValue($product, '[productPrice]');
        $payload['shippingId'] = $this->accessor->getValue($product, '[shippingId]');
        $payload['isPrepaid'] = Session::get('steps.meta.isPrepaidFlow');
        $payload['products'][0] = $product;
        $payload['customerId'] = Session::get('queryParams.customer_id');

        $affiliates = Session::get('affiliates');
        if (empty($affiliates))
        {
            $affiliates = array();
        }

        foreach (array_keys($affiliates) as $key)
        {
            if ($key === 'clickId')
            {
                $affiliates['click_id'] = $affiliates[$key];
            }
            else
            {
                $affiliates[strtoupper($key)] = $affiliates[$key];
            }
            unset($affiliates[$key]);
        }

        $payload = array_replace_recursive($payload, $affiliates);
        $payload['notes'] = sprintf(
                '%s | %s', $this->accessor->getValue($params, '[crmPayloadData][userIsAt]'), $this->accessor->getValue($params, '[crmPayloadData][userAgent]')
        );

        $campaignInfo = $params['crmPayloadData']['products'][0];
        if(!empty($campaignInfo['enableBillingModule']))
        {
            $payload['offerId'] = $campaignInfo['offerId'];
            $payload['billingModelId'] = $campaignInfo['billingModelId'];
            $payload['trialProductId'] = $campaignInfo['trialProductId'];
            $payload['trialProductPrice'] = $campaignInfo['trialProductPrice'];
            $payload['trialProductQuantity'] = $campaignInfo['trialProductQuantity'];
        }
        
        unset($params);
        return $payload;
    }

    private function updateCRMData($crmType, $campaignInfo, $crmInstance)
    {
        if ($crmType == 'sixcrm')
        {
            if (!Session::has('token'))
            {
                CrmPayload::set('campaignId', $campaignInfo['campaignId']);
                CrmPayload::set('affiliates', Session::get('affiliates', array()));
                $response = $crmInstance->acquireToken();
                if (!empty($response->success) && !empty($response->response) && $response->code == 200)
                {
                    $token = (string) $response->response;
                    Session::set('token', $token);
                }
            }
            $isUpsellStep = CrmPayload::get('meta.isUpsellStep');
            if ($isUpsellStep)
            {
                CrmPayload::set('session', Session::get('additional_crm_prospect_response.sessionId'));
                CrmPayload::set('previousOrderId', Session::get('additional_crm_response_1.orderId'));
                CrmPayload::set('meta.crmMethod', 'newOrderCardOnFile');
            }
            
            CrmPayload::set('token', Session::get('token'));
        }

        if ($crmType == 'limelight')
        {
            $crmData = Session::get(sprintf('additional_crm_data_%d', Session::get('steps.previous.id')));
            if($crmData['forceParentGateway']) {
                $forceGateway = Session::get('steps.1.gatewayId');
                CrmPayload::set('forceGatewayId', $forceGateway);
            }
        }
    }

    private function completeOrder($crmType, $crmInstance)
    {
        if ($crmType == 'sixcrm' && Session::get('steps.current.pageType') == 'thankyouPage')
        {
            CrmPayload::set('sessionId', Session::get('additional_crm_prospect_response.sessionId'));
            CrmPayload::set('token', Session::get('token'));
            $crmInstance->orderView();
            Session::set('additional_crm_response_confirm', CrmResponse::all());
        }
    }

    private function updateProspectData($crmType)
    {
        if ($crmType == 'sixcrm')
        {
            CrmPayload::set('session', Session::get('additional_crm_prospect_response.sessionId'));
        }
        else
        {
            CrmPayload::set('prospectId', Session::get('additional_crm_prospect_response.prospectId'));
        }
    }

    public function injectAdditionalOrderScript()
    {
        if (
                !Session::has(sprintf('additional_crm_data_%d', Session::get('steps.previous.id')))
        )
        {
            return;
        }

        echo Provider::asyncScript(AJAX_PATH . 'process-additional-order');
    }

    public function checkPrepaid()
    {
        try
        {
            $action = Request::attributes()->get('action');
            if (
                    Session::get('crmType') == 'responsecrm' &&
                    ($action == 'downsell' || $action == 'checkout')
            )
            {
                $rawCardNumber = Request::form()->get('creditCardNumber');
                $cardNumber = str_replace(array(' ','-'), '', $rawCardNumber);
                $bin = substr($cardNumber, 0, 6);
                CrmPayload::set('bin', $bin);

                $currentConfigId = (int) Session::get('steps.current.configId');
                $configuration = new Configuration($currentConfigId);
                $responseObj = new Responsecrm($configuration->getCrmId());
                $response = $responseObj->checkPrepaidBin();

                if ($response)
                {
                    Session::set('steps.meta.isPrepaidFlow', true);
                    CrmPayload::set('meta.isPrepaidFlow', true);
                }
            }
        }
        catch (Exception $ex)
        {
            
        }
    }

    public function updatePrepaidMethod()
    {
        $action = Request::attributes()->get('action');
        if (
                Session::get('crmType') == 'responsecrm' &&
                Session::get('steps.meta.isPrepaidFlow') &&
                ($action == 'downsell' || $action == 'checkout')
        )
        {
            CrmPayload::set('meta.crmMethod', 'newOrder');
        }
    }

    public function updateCustomerIdForDownsell()
    {
        $action = Request::attributes()->get('action');
        $isSplitOrder = CrmPayload::get('meta.isSplitOrder');
        if(
                $isSplitOrder && 
                Session::get('crmType') == 'responsecrm' &&
                ($action == 'downsell')
        ) {
            CrmPayload::set('customer_id', CrmResponse::get('customerId'));
        }
    }

    public function addAdditionalPixels()
    {
        if (
                Session::get('steps.current.pageType') === 'leadPage'
        )
        {
            return;
        }
        $crmResponse = CrmResponse::all();
        if (
                empty($crmResponse['success']) &&
                !Session::get('steps.meta.isPrepaidFlow') &&
                !Session::get('steps.meta.isScrapFlow')
        )
        {
            $this->setAdditionalPixel('decline');
            $this->setAdditionalPixel('submission');
        }
    }

    public function setAdditionalPixel($type)
    {
        $pixels = Session::get(sprintf('%sPixels.pixel', $type));
        $fireStatus = Session::get(sprintf('%sPixels.fireStatus', $type));
        $positionArray = array(
            'top', 'bottom', 'head'
        );
        $pixelArray = array();
        if (!empty($pixels))
        {
            foreach ($pixels as $key => $val)
            {
                if (!empty($fireStatus[$key]))
                {
                    continue;
                }
                Session::set(
                        sprintf(
                                '%sPixels.fireStatus.%d', $type, $key
                        ), true
                );
                foreach ($positionArray as $position)
                {
                    if (array_key_exists($position, $val))
                    {
                        $pixelArray[$position] = $this->parseTokens($val[$position]);
                    }
                }
            }
        }
        CrmResponse::set(sprintf('%sPixels', $type), $pixelArray);
    }

    private function parseTokens($stringWithTokens)
    {
        return preg_replace_callback(
                "/\{([a-z0-9_]+)\}/i", function ($data) {

            if ($data[1] === 'order_id' || $data[1] === 'orderId')
            {
                return CrmResponse::has('declineOrderId') ? CrmResponse::get('declineOrderId') : '';
            }

            $param = strtolower(str_replace('_', '', $data[1]));

            $affiliates = array_change_key_case(CrmPayload::get('affiliates'));

            foreach ($affiliates as $key => $value)
            {
                if ($param === $key)
                {
                    return $value;
                }
            }
        }, $stringWithTokens
        );
    }

    public function nmiDataStore()
    {
        if (Request::attributes()->get('action') == 'prospect' || Session::get('crmType') != "nmi")
        {
            return;
        }

        $this->storeRequestResponseData();    
        CrmResponse::remove('rawPayload');
        CrmResponse::remove('rawResponse');
        parse_str(Http::getResponse(), $rawResponse);
        if (!empty($rawResponse['response_code']) && $rawResponse['response_code'] == 100)
        {
            return true;
        }

        CrmResponse::replace(array(
            'success'          => false,
            'errors'           => array(
                'crmError' => !empty($rawResponse['responsetext'])? $rawResponse['responsetext'] : 'Order has been Declined',
            ),
        ));
        return false;
    }

    private function storeRequestResponseData()
    {
        try
        {
            $insertData['orderId'] = CrmResponse::get('orderId');
            $insertData['customerId'] = CrmResponse::get('customerId');
            $insertData['step'] = (int) Session::get('steps.current.id');
            $insertData['type'] = (string) Session::get('steps.current.pageType');
            $insertData['configId'] = (int) Session::get('steps.current.configId');
            $insertData['crmId'] = $this->configuration->getCrmId();
            $insertData['crmType'] = Session::get('crmType');
            $insertData['crmPayload'] = json_encode(CrmPayload::all());
            $insertData['crmResponse'] = json_encode(CrmResponse::all());
            $insertData['created_at'] = date('Y-m-d H:i:s');
            $this->makeDbInstance();
            self::$dbConnection->table(Session::get('crmType').'_datastore')->insert($insertData);
            return true;
        }
        catch (Exception $ex)
        {
            return false;
        }
    }

    private function makeDbInstance()
    {
        $factory = new ConnectionFactory();

        self::$dbConnection = $factory->make(array(
            'driver' => 'mysql',
            'host' => Config::settings('db_host'),
            'username' => Config::settings('db_username'),
            'password' => Config::settings('db_password'),
            'database' => Config::settings('db_name'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ));
        if (!self::$dbConnection)
        {
            throw new Exception(
            'Couldn\'t authenticate database credentials. Please recheck your settings.'
            );
        }
    }
    
    public function approveOfflineOrders()
    {
        $payload = CrmPayload::all();
        
        if (
                Request::attributes()->get('action') == 'prospect' || 
                Session::get('crmType') != "limelight" ||
                $payload['cardType'] != 'COD'
        )
        {
            return;
        }
        $configuration = new Configuration(Session::get('steps.1.configId'));
        $crmId = $configuration->getCrmId();
        $crm = $configuration->getCrm();
        $crmType = $crm['crm_type'];
        
        
        $response = CrmResponse::all();
        if(empty($response['success']))
        {
            return;
        }
        
        $crmClass = sprintf(
                '\Application\Model\%s', ucfirst($crmType)
        );
        $data['order_ids'] = $response['orderId'];
        $data['actions'] = 'payment_received';
        $data['values'] = '1';
        CrmPayload::replace($data);
        $crmInstance = new $crmClass($crmId);
        call_user_func_array(array($crmInstance, 'orderUpdate'), array());
        CrmResponse::replace($response);
    }

}
