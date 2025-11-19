<?php

namespace Extension\TrafficLoadBalancer;

use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Helper\Provider;
use Application\Logger;
use Application\Request;
use Application\Response;
use Application\Session;
use Database\Connectors\ConnectionFactory;
use DateTime;
use Exception;

class Scrapper
{

    private $config, $tableName, $scrapperStepId, $rule, $dbConnection;

    public function __construct()
    {
        $this->config            = Config::advanced('scrapper');
        $this->tableName         = 'scrapper';
        $currentStepId           = Session::get('steps.current.id');
        $this->scrapperStepId    = $currentStepId > 1 ? 2 : 1;
        $this->rule              = array();
        $this->dbConnection      = null;
        $this->pageType          = Session::get('steps.current.pageType');
        $this->disableOrderCount = Config::extensionsConfig('TrafficLoadBalancer.disable_orderfilter_count');
        $this->fileName          = BASE_DIR . DS . 'extensions/TrafficLoadBalancer/OrderFilter.txt';
    }

    public function initialize()
    {
        if (!empty($_COOKIE['skipCount'])) {
            return;
        }

        if (Session::has(
            sprintf('extensions.trafficLoadBalancer.%d', $this->scrapperStepId)
        )) {
            Response::send(array(
                'success' => true,
                'message' => 'Already evaluated for this step.',
            ));
        }

        if (!empty($this->config['remote'])) {
            $settings = Settings::getRemote();
        } else {
            $settings = Settings::getLocal();
        }

        if (empty($settings['percentage'])) {
            Response::send(array(
                'success' => false,
                'errors'  => array(
                    'settings' => 'No percentage is defined. Please check your settings.',
                ),
            ));
        }

        Logger::write('Scrapper Settings', $settings);

        if ((int) $settings['percentage'][1] === (int) $settings['percentage'][2]) {
            $settings['percentage'][2] = 0;
        }

        $this->config = $settings;

        $this->dbConnection = $this->getDatabaseConnection();

        $this->rule = $this->getCurrentStepRule();

        if (empty($this->rule)) {
            Response::send(array(
                'success' => false,
                'errors'  => array(
                    'rule' => 'No rule found or generated for this step.',
                ),
            ));
        }

        $isScrapped = $this->isScrapped();

        Session::set(
            sprintf('extensions.trafficLoadBalancer.%d', $this->scrapperStepId),
            array(
                'scrapped'  => $isScrapped,
                'ruleId'    => $this->rule['id'],
                'committed' => false,
            )
        );
        Session::set('steps.meta.isScrapFlow', $isScrapped);

        Response::send(array('success' => true));

    }

    private function isScrapped()
    {

        if ($this->scrapperStepId > 1) {
            if (Session::get('extensions.trafficLoadBalancer.1.scrapped')) {
                return true;
            }
        }

        $scrappingMethod = Config::extensionsConfig('TrafficLoadBalancer.scrapping_method');
        switch ($scrappingMethod) {
            case 'timestamp':return $this->determineByTimestampScrapper();
            case 'flat':return $this->determineByFlatScrapper();
            case 'random':
            default:return $this->determineByRandomScrapper();
        }

    }

    protected function determineByFlatScrapper()
    {
        $upperLimit = (int) $this->getUpperLimit($this->rule['percentage']);
        if ((int) $this->rule['percentage'] === 0) {
            return false;
        }

        $scrappedStep = (int) ceil($upperLimit / $this->rule['percentage']);
        for ($step = $scrappedStep; $step <= 100; $step = $step + $scrappedStep) {
            if ((int) $this->rule['hitsCount'] === $step - 1) {
                return true;
            }
        }
        return false;
    }

    protected function determineByTimestampScrapper()
    {

        $startTime = Config::extensionsConfig('TrafficLoadBalancer.start_time');
        $endTime   = Config::extensionsConfig('TrafficLoadBalancer.end_time');

        $startDateTime   = DateTime::createFromFormat('H:i', $startTime);
        $endDateTime     = DateTime::createFromFormat('H:i', $endTime);
        $currentDateTime = new DateTime();

        if (
            $startDateTime <= $currentDateTime &&
            $endDateTime >= $currentDateTime
        ) {
            return true;
        }

        return false;

    }

    protected function determineByRandomScrapper()
    {
        if (empty($this->rule['percentage'])) {
            return false;
        }
        $upperLimit = $this->getUpperLimit($this->rule['percentage']);
        Logger::write('Upper Limit', $upperLimit);
        $maxScrapLimit = (float) (($upperLimit * $this->rule['percentage']) / 100.00);
        Logger::write('Max Scrap Limit', $maxScrapLimit);
        $pendingScrap = (float) ($maxScrapLimit - $this->rule['scrappedCount']);
        Logger::write('Pending Scrap', $pendingScrap);
        $currentCounter = (float) $this->rule['hitsCount'];
        Logger::write('Current Counter', $currentCounter);
        $pr = (float) ($pendingScrap / ($upperLimit - $currentCounter));
        Logger::write('Probability', $pr);

        if (((float) mt_rand(1, $upperLimit) / (float) $upperLimit) <= $pr) {
            return true;
        } else {

            return false;
        }
    }

    protected function getUpperLimit($percentage)
    {

        $scrappingMethod = Config::extensionsConfig('TrafficLoadBalancer.scrapping_method');
        switch ($scrappingMethod) {
            case 'timestamp':return 100;
            case 'flat':return 100;
            case 'random':
            default:break;
        }

        if ((int) $percentage === 100 || (int) $percentage === 0) {
            return 100;
        }
        $number2 = 100 - (int) $percentage;
        $number1 = (int) $percentage;
        $gcd     = $this->gcd($number1, $number2);
        return (int) ($number1 / $gcd) + (int) ($number2 / $gcd);
    }

    protected function gcd($number1, $number2)
    {
        while ($number2) {
            $temp    = $number2;
            $number2 = $number1 % $number2;
            $number1 = $temp;
        }
        return $number1;
    }

    public function incrementHit()
    {

        if (!empty($this->disableOrderCount) && !empty($_COOKIE['skipCount'])) {
            if (CrmResponse::has('orderId') !== true) {
                try
                {
                    $fp       = fopen($this->fileName, 'r');
                    $contents = fread($fp, filesize($this->fileName));
                    fclose($fp);
                    if (!empty($contents)) {
                        $data            = explode(',', $contents);
                        $countPerDay     = $data[0];
                        $currentDateTime = new DateTime();
                        $currentDate     = strtotime($currentDateTime->format('Y-m-d'));
                        $this->increaseOrderFilterFile($this->fileName, $currentDate, $countPerDay - 1);
                    }
                } catch (Exception $ex) {
                    throw ($ex);
                }
            }
        }

        try {
            if (empty($this->config['enable'])) {
                return;
            }

            if (Session::get(
                sprintf(
                    'extensions.trafficLoadBalancer.%d.committed', $this->scrapperStepId
                )
            ) === true) {
                return;
            }
            if (CrmResponse::has('orderId') !== true) {
                return;
            }

            $currentLoadBalancer = Session::get(
                sprintf('extensions.trafficLoadBalancer.%d', $this->scrapperStepId)
            );

            if (!empty($currentLoadBalancer['committed'])) {
                return;
            }

            $this->dbConnection = $this->getDatabaseConnection();

            $this->rule = $this->getRuleById($currentLoadBalancer['ruleId']);

            if (empty($this->rule)) {
                return;
            }

            $upperLimit = $this->getUpperLimit($this->rule['percentage']);

            $data = array(
                'hitsCount' => ($this->rule['hitsCount'] + 1) % $upperLimit,
                'hits'      => $this->rule['hits'] + 1,
            );

            $isDisablePrepaidOrderFiler = Config::extensionsConfig('TrafficLoadBalancer.disable_prepaid_orderfilter');

            if (
                $currentLoadBalancer['scrapped'] && !$isDisablePrepaidOrderFiler && Session::has('steps.meta.isPrepaidFlow')
                ||
                $currentLoadBalancer['scrapped'] && !Session::has('steps.meta.isPrepaidFlow')
            ) {
                $data['scrappedCount'] = $this->rule['scrappedCount'] + 1;
                $data['scrapped']      = $this->rule['scrapped'] + 1;
            }

            if ($data['hitsCount'] === 0) {
                $data['scrappedCount'] = 0;
            }

            $this->dbConnection->table($this->tableName)
                ->where('id', $currentLoadBalancer['ruleId'])
                ->update($data);

            $currentLoadBalancer['committed'] = true;
            Session::set(
                sprintf(
                    'extensions.trafficLoadBalancer.%d', $this->scrapperStepId
                ), $currentLoadBalancer
            );

        } catch (Exception $ex) {}
    }

    private function getCurrentStepRule($id = null)
    {
        $rule = $this->dbConnection->table($this->tableName)
            ->select('id', 'percentage')
            ->where('scrapStep', $this->scrapperStepId)
            ->where($this->config['affiliates'])
            ->first();
        if ($rule !== null && is_array($rule)) {
            $rule['percentage'] = (int) $rule['percentage'];
        }
        if ($rule === null) {
            $this->insertRule(array_merge(
                array(
                    'percentage' => $this->config['percentage'][$this->scrapperStepId],
                ), $this->config['affiliates']));
        } else if (
            $rule['percentage'] !== $this->config['percentage'][$this->scrapperStepId]
        ) {
            $this->updateRule($rule['id'], array(
                'scrappedCount' => 0,
                'hitsCount'     => 0,
                'percentage'    => $this->config['percentage'][$this->scrapperStepId],
            ));
        }
        $rule = $this->dbConnection->table($this->tableName)
            ->select(
                'id', 'scrappedCount', 'hitsCount', 'percentage', 'scrapped', 'hits'
            )
            ->where('scrapStep', $this->scrapperStepId)
            ->where($this->config['affiliates'])
            ->first();
        $rule['percentage'] = (int) $rule['percentage'];
        return $rule;
    }

    private function getRuleById($id)
    {
        return $this->dbConnection->table($this->tableName)
            ->select(
                'id', 'scrappedCount', 'hitsCount', 'percentage', 'scrapped', 'hits'
            )->find($id);
    }

    private function updateRule($id, $data = array())
    {
        $this->dbConnection->table($this->tableName)
            ->where('id', $id)->update($data);
    }

    private function insertRule($data = array())
    {
        $affiliates = Settings::initializeAffiliates();
        $rule       = array_merge(array(
            'scrappedCount' => 0,
            'hitsCount'     => 0,
            'scrapped'      => 0,
            'hits'          => 0,
            'percentage'    => 0,
            'scrapStep'     => $this->scrapperStepId,
        ), $data);
        $this->dbConnection->table($this->tableName)->insert($rule);
    }

    protected function loadBalance()
    {
        return in_array(
            $this->rule['hitsCount'], explode(',', $this->rule['randomNumbers'])
        );
    }

    private function getDatabaseConnection()
    {
        $factory = new ConnectionFactory();
        return $factory->make(array(
            'driver'   => 'sqlite',
            'database' => STORAGE_DIR . DS . 'trafficlb.sqlite',
        ));
    }

    public function injectScript()
    {
        if (empty($this->config['enable'])) {
            return;
        }

        if (!$this->isEligibleForAdvancedActions()) {
            return;
        }

        echo Provider::asyncScript(
            AJAX_PATH . 'extensions/trafficloadbalancer/initialize'
        );
    }

    public function isDisableOrderFilter()
    {
        if (empty($this->disableOrderCount) || !empty($_COOKIE['skipCount'])) {
            return;
        }
        try
        {
            $fp       = fopen($this->fileName, 'r');
            $contents = fread($fp, filesize($this->fileName));
            fclose($fp);
            if (!empty($contents)) {
                $data            = explode(',', $contents);
                $countPerDay     = $data[0];
                $timeStamp       = $data[1];
                $currentDateTime = new DateTime();
                $currentDate     = strtotime($currentDateTime->format('Y-m-d'));
                if ($currentDate != $timeStamp) {
                    $this->increaseOrderFilterFile($this->fileName, $currentDate, 1);
                    setcookie("skipCount", true, time() + (86400 * 20));
                } else {
                    if ($countPerDay < $this->disableOrderCount) {
                        $this->increaseOrderFilterFile($this->fileName, $currentDate, $countPerDay + 1);
                        setcookie("skipCount", true, time() + (86400 * 20));
                    }
                }
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function increaseOrderFilterFile($fileName, $currentDate, $count)
    {
        try {
            $fp = fopen($fileName, 'r+');
            flock($fp, LOCK_EX);
            file_put_contents($fileName, $count . ',' . $currentDate);
            flock($fp, LOCK_UN);
            fclose($fp);
        } catch (Exception $ex) {
            print_r($ex);
            throw ($ex);
        }
    }

    public function isEligibleForAdvancedActions()
    {
        $allowedConfig = Config::extensionsConfig('TrafficLoadBalancer.allowed_config');
        $currentConfig = Session::get('steps.current.configId');
        if (!empty($allowedConfig) && !empty($currentConfig)) {
            $configs = explode(',', $allowedConfig);
            if (!in_array($currentConfig, $configs)) {
                return false;
            }
        }

        return true;
    }

    public function switchMethod()
    {
        if (
            Session::get(
                'extensions.trafficLoadBalancer.1.scrapped'
            ) === true ||
            Request::attributes()->get('action') !== 'upsell' ||
            CrmPayload::get('meta.crmMethod') === 'newOrder' ||
            Session::get('steps.meta.isScrapFlow') !== true
        ) {
            return;
        }
        CrmPayload::remove('previousOrderId');
        CrmPayload::remove('customerId');
        CrmPayload::set('meta.crmMethod', 'newOrder');
    }

}
