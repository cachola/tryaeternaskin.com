<?php

namespace Extension\AsyncSplit;

use Application\CrmPayload;
use Application\CrmResponse;
use Application\Helper\Provider;
use Application\Response;
use Application\Session;
use Application\Config;
use Application\Http;

class AsyncSplit
{

    public function __construct()
    {
        $this->currentStepId = (int) Session::get('steps.current.id');
        $this->enableNativeDataCapture = Config::extensionsConfig(
            'AsyncSplit.enable_native_datacapture'
        );
    }

    public function captureCrmPayload()
    {

        if (CrmPayload::get('meta.isSplitOrder') === false) {
            return;
        }
        
        $products = CrmPayload::get('products');
        if(
                !empty($products) && count($products) > 1 && 
                Session::get('crmType') == 'konnektive' &&
                CrmPayload::get('meta.crmMethod') == 'importUpsell'
            )
        {
            $crmPayload = array();
            foreach ($products as $k => $product)
            {
                CrmPayload::set('products', array($product));
                $crmPayload[$k] = CrmPayload::all();
            }
            Session::set(
                'extensions.asyncSplit', array(
                    'crmPayload' => $crmPayload,
                )
            );
        }
        else
        {
            Session::set(
                'extensions.asyncSplit', array(
                    'crmPayload' => CrmPayload::all(),
                )
            );
        }
        
        CrmPayload::update(array(
            'meta.bypassCrmHooks'      => true,
            'meta.terminateCrmRequest' => true,
        ));

        CrmResponse::replace(array(
            'success' => true,
        ));

    }

    public function placeOrder()
    {
        if (!Session::has('extensions.asyncSplit')) {
            return;
        }
        
        $asyncData = Session::get('extensions.asyncSplit.crmPayload');
        
        if(!empty($asyncData[0]))
        {
            foreach ($asyncData as $k => $data)
            {
                $this->processOrder($data, $k+1);
            }
        }
        else
        {
            $this->processOrder($asyncData);
        }
        
        $splitOrderResponse = CrmResponse::all();
        
        if ($this->enableNativeDataCapture) {
            $parentOrderId = $asyncData['meta.mainStepData']['orderId'];
            $this->nativeDataCapture($parentOrderId);
        }
        
        Session::remove('extensions.asyncSplit');
        Response::send($splitOrderResponse);
    }
    
    public function processOrder($asyncData , $multiKey = false)
    {
        CrmPayload::replace($asyncData);
        CrmPayload::set('meta.bypassCrmHooks', true);
        CrmPayload::set('meta.terminateCrmRequest', false);

        $crmClass = sprintf(
            '\Application\Model\%s', ucfirst(CrmPayload::get('meta.crmType'))
        );

        $crmInstance = new $crmClass(CrmPayload::get('meta.crmId'));
        $crmMethod   = CrmPayload::get('meta.crmMethod');

        call_user_func(array($crmInstance, $crmMethod));

        $splitOrderResponse = CrmResponse::all();
        if (!empty($splitOrderResponse['success'])) {
            foreach ($splitOrderResponse as $key => $value) {
                if ($key === 'success') {
                    continue;
                }
                if(!empty($multiKey))
                {
                    Session::set(sprintf(
                        'steps.%d.splitOrder.%s.%d', $this->currentStepId - 1, $key, $multiKey - 1
                    ), $value);
                }
                else
                {
                    Session::set(sprintf(
                            'steps.%d.splitOrder.%s', $this->currentStepId - 1, $key
                        ), $value);
                }
                
            }
            if(!empty($multiKey))
            {
                Session::set(sprintf(
                    'steps.%d.splitOrder.products.%d', $this->currentStepId - 1, $multiKey - 1
                ), CrmPayload::get('products', array()));
            }
            else
            {
                Session::set(sprintf(
                    'steps.%d.splitOrder.products', $this->currentStepId - 1, $key
                ), CrmPayload::get('products', array()));
            }
        }
        
    }
    
    public function injectScript()
    {
        if (!Session::has('extensions.asyncSplit')) {
            return;
        }
        echo Provider::asyncScript(
            AJAX_PATH . 'extensions/asyncsplit/place-order'
        );
    }
    
    private function nativeDataCapture($parentOrderId)
    {
        $dbConnection = Helper::getDatabaseConnection();
        try
        {
            $responseData = CrmResponse::all();
            $rawData = Http::getResponse();
            $data['orderId'] = $responseData['orderId'];
            $data['customerId'] = !empty($responseData['customerId']) ? $responseData['customerId'] : '';
            $data['crmResponse'] = json_encode($rawData);
            $nativeTableName = Config::extensionsConfig('AsyncSplit.native_datacapture_table');
            
            $prevData = $dbConnection->table($nativeTableName)
                            ->select('id')
                            ->where('parentOrderId', $parentOrderId)
                            ->where('type', 'split')
                            ->where('crmResponse', NULL)
                            ->orderBy('id')
                            ->first();
                    
            $dbConnection->table($nativeTableName)
                ->where('id', $prevData['id'])
                ->update($data);
            
        } catch (Exception $ex) {
            
        }
        
    }
}
