<?php

namespace Extension\TrafficLoadBalancer;

use Application\Request;
use Exception;

class Actions
{

    public function save()
    {
        $this->createProductOrderFilter();

        if (!extension_loaded('pdo_sqlite') && !extension_loaded('pdo_sqlite')) {
            throw new Exception("Sqlite PDO extension is not installed.");
        }

        if ('timestamp' !== Request::form()->get('scrapping_method')) {
            return;
        }

        $startTime = Request::form()->get('start_time');
        $endTime   = Request::form()->get('end_time');
        if (empty($startTime) || empty($endTime)) {
            throw new Exception('Start and End time can\'t be empty');
        }

        if (
            !$this->isValidTimeFormat($endTime) ||
            !$this->isValidTimeFormat($startTime)
        ) {
            throw new Exception('Enter valid Start and End time');
        }
    }

    private function isValidTimeFormat($timeString)
    {
        if (preg_match('/^\d{2}:\d{2}$/', $timeString)) {
            if (
                preg_match(
                    "/(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])/", $timeString
                )
            ) {
                return true;
            }
        }
        return false;
    }

    private function UniqueRandomNumbersWithinRange($min, $max, $quantity)
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    private function createProductOrderFilter()
    {
        $enableProductOrderFilter = Request::form()->get('enable_product_orderfilter');
        if (!$enableProductOrderFilter) {
            return;
        }
        $productOrderFilterConfig            = Request::form()->get('product_orderfilter_configuration');
        $productOrderFilterMethod            = Request::form()->get('product_orderfilter_scrapping_method');
        $productOrderFilterCampiagnId        = Request::form()->get('product_orderfilter_campaignid');
        $productOrderFilterConfigurationFlat = Request::form()->get('product_orderfilter_configuration_flat');
        $fileName                            = BASE_DIR . DS . 'storage/productOrderFilter';
        $jsonArray                           = array();
        if ($productOrderFilterMethod == 'flat') {
            $campaignArray = preg_split("/\\r\\n|\\r|\\n/", $productOrderFilterCampiagnId);
            $configArray   = preg_split("/\\r\\n|\\r|\\n/", $productOrderFilterConfigurationFlat);
            foreach ($configArray as $key => $val) {
                $productOrderFilterInfo = explode('|', $val);
                $randomNo               = $this->flatLogic($productOrderFilterInfo);
                $jsonArray              = $this->prepareData($jsonArray, $campaignArray[$key], $fileName, $randomNo);
            }
            $this->insertData($jsonArray, $fileName);
        } else {
            $configs = preg_split("/\\r\\n|\\r|\\n/", $productOrderFilterConfig);
            foreach ($configs as $val) {
                $productRange = explode('|', $val);
                $randomNo     = $this->UniqueRandomNumbersWithinRange(1, 100, $productRange[1]);
                $jsonArray    = $this->prepareData($jsonArray, $productRange[0], $fileName, $randomNo);
            }
            $this->insertData($jsonArray, $fileName);
        }
    }

    private function prepareData($jsonArray, $val, $fileName, $randomNo)
    {
        $productArray = array();
        if (!file_exists($fileName)) {
            $productArray[$val]['count'] = 1;
        } else {
            $fp       = fopen($fileName, 'r');
            $contents = fread($fp, filesize($fileName));
            fclose($fp);
            if ($contents) {
                $data = json_decode($contents, true);
                foreach ($data as $key => $value) {
                    if (array_key_exists($val, $value)) {
                        $count                       = $value[$val]['count'];
                        $productArray[$val]['count'] = $count;
                        break;
                    }
                }
            }
        }
        $productArray[$val]['random_numbers'] = $randomNo;
        array_push($jsonArray, $productArray);
        return $jsonArray;
    }

    private function insertData($jsonArray, $fileName)
    {
        $jsonData = json_encode($jsonArray);

        try {
            $fp = fopen($fileName, 'r+');
            file_put_contents($fileName, $jsonData);
            fclose($fp);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    private function flatLogic($productOrderFilterInfo)
    {
        $flatArray           = array();
        $orderFilterInterval = $productOrderFilterInfo[0];
        $orderFilterCount    = $productOrderFilterInfo[1];
        $nonOrderFilterCount = $productOrderFilterInfo[2];
        for ($i = 1, $j = 1; $i <= 100; $i++) {
            if (($i % $orderFilterInterval != 0) && ($j <= $orderFilterCount)) {
                array_push($flatArray, $i);
                $j++;
            } elseif ($i % $orderFilterInterval == 0) {
                $j = 1;
            } else {
                $j++;
            }
        }
        return $flatArray;
    }
}
