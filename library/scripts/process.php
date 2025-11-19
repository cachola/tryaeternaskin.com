
<?php
date_default_timezone_set('UTC');
require dirname(__FILE__) . '/../bootstrap.php';

use Database\Connectors\ConnectionFactory;
use Application\Helper\Security;
use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Http;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Application\TmpLogger;



Bootstrap::initialize();
session_start();
$a = new offLineProcess();
$a->processOrders();

class offLineProcess
{
    const LOCK_FILE_NAME          = '.offline_process';
    const MAX_LOCK_CHECKING_LIMIT = 20;
    private static $lockingCheckCount = 0;
    private $dbConnection;
    protected $endpoint;
    protected $username;
    protected $password;
    protected  $accessor;
    private $tableName;
    private $tableNameLog;
    private $params;
    private $localEncKey;
    private $currentDateTime;


    public function __construct()
    {
        try {
            $this->dbConnection = $this->getDatabaseConnection();
        } catch (\Throwable $th) {
            echo "<pre>\nCan't connect to database.\n";
        }
        $dateTime              = new DateTime();
        $this->currentDateTime = $dateTime->format('Y-m-d H:i:s');
        $this->tableName = env('TABLE_NAME');
        $this->tableNameLog = env('TABLE_NAME_LOG');
        $this->localEncKey = 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282';
        $this->params = [];
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $crmId = 1;
        $crmDetails     = Config::crms(sprintf('%d', (int)$crmId));
        if (!is_array($crmDetails)) {
            throw new Exception(
                sprintf('CRM not found with id %d', (int)$crmId),
                1001
            );
        }
        $this->endpoint  = $crmDetails['endpoint'];
        $this->username  = $crmDetails['username'];
        $this->password  = $crmDetails['password'];
    }

    function getDatabaseConnection()
    {
        $factory            = new ConnectionFactory();
        try {
            $dbConnectionl = $factory->make(array(
                'driver'    => 'mysql',
                'host'      => Config::settings('db_host'),
                'username'  => Config::settings('db_username'),
                'password'  => Config::settings('db_password'),
                'database'  => Config::settings('db_name'),
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
            ));
            return $dbConnectionl;
        } catch (\Throwable $th) {
            echo "Error while connecting to database!";
            die;
        }
    }

    function processOrders()
    {

        TmpLogger::log('process',  date("Y-m-d H:i:s") . ". Delayed order processing started. Please wait...\n");
        echo   date("Y-m-d H:i:s") . ". Delayed order processing started. Please wait...\n";
        $candidateRecords = $this->getCandidateRecords();
        if (!empty($candidateRecords)) {
            // TmpLogger::log('process', 'records to process:    ' . print_r(($candidateRecords)));
            if (!empty($candidateRecords)) {
                $first = '';
                foreach ($candidateRecords as $cand) {
                    if (!($first == $cand['parentOrderId'])) {
                        // array_push($candidateRecordIds, $cand['id']);
                        $first = $cand['parentOrderId'];
                        TmpLogger::log('process', 'processing :    ' . $first);
                        $delay_orders=array();
                        $firstStep = $cand['step'];
                        $crmPayload = $this->prepareCrmPayload($cand);
                        // $this->makeCrmRequestAndUpdateDatabase($crmPayload, $firstStep);
                        // if (CrmResponse::get('responseStatus') != 2 && $firstStep <> 1) {
                            $filteredItem = array_filter($candidateRecords, function ($elem) use ($first) {
                                return ($elem['parentOrderId'] == $first );
                            });
                             foreach ($filteredItem as $item) {
                                array_push($delay_orders,$item['crmPayload']['products'][0]);
                             }
                             $crmPayload['products']=$delay_orders;
                             echo 'before makeCrmRequestAndUpdateDatabase';
                             $this->makeCrmRequestAndUpdateDatabase($crmPayload, 0);
                        }
                    }
                }
            
        } else {
            echo "No records to process." . PHP_EOL;
        }
        TmpLogger::log('process', "Delay order processing completed. Thank you.\n</pre>");
        echo "Delay order processing completed. Thank you.\n</pre>";
    }

    function makeCrmRequestAndUpdateDatabase($crmPayload, $step)
    {

        $crmPayload['meta.terminateCrmRequest'] = false;
        $crmPayload['meta.bypassCrmHooks']      = true;
        $decryptCC = Security::decrypt($crmPayload['cardNumber'], $this->localEncKey);
        $decryptEM = Security::decrypt($crmPayload['cardExpiryMonth'], $this->localEncKey);
        $decryptEY = Security::decrypt($crmPayload['cardExpiryYear'], $this->localEncKey);
        $decryptCV = Security::decrypt($crmPayload['cvv'], $this->localEncKey);
        $crmPayload['cardNumber']      = !empty($decryptCC) ? $decryptCC : $crmPayload['cardNumber'];
        $crmPayload['cardExpiryMonth'] = !empty($decryptEM) ? $decryptEM : $crmPayload['cardExpiryMonth'];
        $crmPayload['cardExpiryYear']  = !empty($decryptEY) ? $decryptEY : $crmPayload['cardExpiryYear'];
        $crmPayload['cvv']             = !empty($decryptCV) ? $decryptCV : $crmPayload['cvv'];
        unset($crmPayload['recordId'], $crmPayload['crmId'], $crmPayload['combined']);
        CrmPayload::replace($crmPayload);
        CrmPayload::remove('pixelConfig');
        $this->params = array_replace($this->params, CrmPayload::all());
        $parentOrderId = $this->params['meta.parentOrderId'];
        TmpLogger::log('process', $parentOrderId . PHP_EOL . 'Params: ' . print_r($this->params,true));
        print_r($this->params);
        echo 'before create crm instance';
        $crmInstance = new \Application\Model\Limelight(1, true);
        echo 'after create crm instance';
        TmpLogger::log('process', $parentOrderId . PHP_EOL . 'Before call newOrderProcess: ');
        echo 'Before call newOrderProcess: ';
        call_user_func_array(array($crmInstance, 'newOrderProcess'), array());
        echo 'after call newOrderProcess: ';
        TmpLogger::log('process', $parentOrderId . PHP_EOL . 'after call newOrderProcess: ');
        $crmResponse=$crmInstance->getCrmResponseArray();
        TmpLogger::log('process', 'Response: ' . print_r($crmResponse,true));
        print_r($crmResponse);
        $status = $this->updateDbOrderId($parentOrderId,$crmResponse['orderId'], $step, $crmResponse['responseStatus'], true,$crmResponse['crmResponseLog']);

        if ($this->params['firepixel'] && $status == 4) {
            $tid = $crmPayload['affiliates']['c3'];
            $url = 'https://www.mal1iaks.com/?nid=461&transaction_id=' . $tid;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($curl);

            //If you need to check result, use this:
            if (!curl_errno($curl)) {
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($http_code === 200) {
                    TmpLogger::log('process', 'Pixel sent Ok' . PHP_EOL );
                } else {
                    TmpLogger::log('process', 'Pixel sent. Unexpected HTTP code: ' . $http_code . PHP_EOL ); 
                }
            }
            curl_close($curl);
            unset($result);
        }
    }

    function getCandidateRecords()
    {
        TmpLogger::log('process',   "Checking for another running process");
        while ($this->runningAnotherProcess()) {

            sleep(1);
        }

        $query = $this->dbConnection->table($this->tableName)
            ->select(
                'id',
                'parentOrderId',
                'orderId',
                'step',
                'type',
                'crmId',
                'crmType',
                'combined',
                'crmPayload',
                'scheduledAt'
            )
            ->where('processing', '=', 0);
        $query->where(
            'scheduledAt',
            '<',
            $this->currentDateTime
        )->limit(10);
        $candidateRecords = $query->orderBy('parentOrderId')->orderBy('id', 'desc')->get();
        if (empty($candidateRecords)) {
            return array();
        }
        $candidateRecordIds = array_column($candidateRecords, 'id');

        $this->dbConnection->table($this->tableName)
            ->whereIn('id', $candidateRecordIds)
            ->update(array(
                'processing'  => 1,
                'processedAt' => $this->currentDateTime,
            ));

        if (file_exists(STORAGE_DIR . DS . self::LOCK_FILE_NAME)) {
            file_put_contents(STORAGE_DIR . DS . self::LOCK_FILE_NAME, 0, LOCK_EX);
        }

        return array_map(function ($value) {
            $value['crmPayload'] = json_decode($value['crmPayload'], true);
            return $value;
        }, $candidateRecords);
    }

    function getCandidateRecordIds()
    {
        try {
            $query = $this->dbConnection->table($this->tableName)
                ->select('id', 'parentOrderId', 'combined')
                ->where('processing', '=', 0);
            $query->where(
                'scheduledAt',
                '<',
                $this->currentDateTime
            )->limit(10);
            $candidateRecords = $query->orderBy('parentOrderId')->orderBy('id', 'desc')->get();
            $first = '';
            $candidateRecordIds = [];
            foreach ($candidateRecords as $can) {
                if (!($first == $can['parentOrderId'])) {
                    array_push($candidateRecordIds, $can['id']);
                    $first = $can['parentOrderId'];
                }
            }
            return $candidateRecordIds;
        } catch (\Throwable $th) {
            //throw $th;
            $dea = $th;
        }
    }

    function prepareCrmPayload($candidateRecord)
    {

        $crmPayload = $candidateRecord['crmPayload'];

        $crmPayload['meta.crmType']       = $candidateRecord['crmType'];
        $crmPayload['meta.type']          = $candidateRecord['type'];
        $crmPayload['meta.orderId']       = $candidateRecord['orderId'];
        $crmPayload['meta.recordId']      = $candidateRecord['id'];
        $crmPayload['meta.crmId']         = $candidateRecord['crmId'];
        $crmPayload['meta.combined']      = $candidateRecord['combined'];
        $crmPayload['meta.parentOrderId'] = $candidateRecord['parentOrderId'];

        return $crmPayload;
    }

    function runningAnotherProcess()
    {
        $lockFile = STORAGE_DIR . DS . self::LOCK_FILE_NAME;

        if (!is_writable(STORAGE_DIR)) {
            TmpLogger::log(
                'process',
                "Locking not supported, Please check storage dir permission."
            );
            return false;
        }
        if (!file_exists($lockFile)) {
            file_put_contents($lockFile, 1, LOCK_EX);
            return false;
        }
        $flag = (int)file_get_contents($lockFile);
        if (
            self::$lockingCheckCount > self::MAX_LOCK_CHECKING_LIMIT ||
            $flag === 0
        ) {
            file_put_contents($lockFile, 1, LOCK_EX);
            return false;
        }
        self::$lockingCheckCount++;
        return false;
    }



    // private function getUrl($slug)
    // {
    //     $a = php_uname('n');
    //     if (env('MOCK_SERVER', false)) {
    //         $ep =  "http://192.168.10.1:8081";
    //         return sprintf('%s/%s', $ep, $slug);
    //     } else {
    //         return sprintf('%s/%s', $this->endpoint, $slug);
    //     }
    // }



    // private  function sendDBLogs($url, $response, $payload, $parentOrderId)
    // {
    //     $dateTime              = new DateTime();
    //     $currentDateTime = $dateTime->format('Y-m-d H:i:s');
    //     $data = array(
    //         'url' => $url,
    //         'payload'    => $payload,
    //         'response'    => $response,
    //         'parentOrderId' => $parentOrderId,
    //         'createdAt' => $currentDateTime,
    //     );
    //     $this->dbConnection->table($this->tableNameLog)->insert($data);
    // }

    private function updateDbOrderId($oldOrderId, $newOrderId, $step, $responseStatus, $offline = false,$responseLog='')
    {
        $dateTime              = new DateTime();
        if (!$offline || $responseStatus == 0) {
            $proc = $responseStatus;
        } else {
            $proc = $responseStatus + 2;
        }
        $currentDateTime = $dateTime->format('Y-m-d H:i:s');
        $updateOrderId = $this->dbConnection->table($this->tableName);
        if($step!=0){
        $updateOrderId->where([
            'parentOrderId' => $oldOrderId,
            'step' => $step
        ])
            ->update(array(
                'orderId' => $newOrderId,
                'processing'  => $proc,
                'processedAt' => $currentDateTime,
                'crmResponse' => $responseLog,
            ));
        } else {
                $updateOrderId->where([
            'parentOrderId' => $oldOrderId,
        ])
            ->update(array(
                'orderId' => $newOrderId,
                'processing'  => $proc,
                'processedAt' => $currentDateTime,
                'crmResponse' => $responseLog,
            ));
        }


        // if ($proc == 4) {
            // $updateOrderId = $this->dbConnection->table($this->tableName);
            // $updateOrderId->where('parentOrderId', '=', $oldOrderId)
            //     ->update(array(
            //         'orderId' => $newOrderId,
            //         'processing'  => $proc,
            //         'processedAt' => $currentDateTime,

            //     ));
        // }
        return $proc;
    }
}
