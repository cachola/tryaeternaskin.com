<?php

namespace Application;
use Exception;
use DateInterval;
use DateTime;
class TmpLogger
{


    private function __construct()
    {

        return;
    }

    public static function logdev($tofile, $content)
    {
        $tt = self::getLogFilename($tofile);
        if (env('IS_DEV', false)) {
            file_put_contents(self::getLogFilename($tofile), self::getDateMicro() . PHP_EOL .  $content . PHP_EOL, FILE_APPEND);
        }
    }

    public static function log($tofile, $content)
    {
        $tt = self::getLogFilename($tofile);
        file_put_contents(self::getLogFilename($tofile), self::getDateMicro() . PHP_EOL .  $content . PHP_EOL, FILE_APPEND);
    }

    private static function getLogFilename($name)
    {
        $tmpLogDir = dirname(__FILE__) . "/../../tmp/logfiles";
                if (!file_exists($tmpLogDir)) {
                    mkdir($tmpLogDir, 0755, true);
                }
        return $tmpLogDir . '/' . $name . str_replace('/', '_', realpath(dirname(__FILE__) . '/../../')) . '.txt';
    }

    public static function checkLogs()
    {
        try {
            if (env('IS_DEV', false)) {
                $tmpLogDir = dirname(__FILE__) . "/../../tmp/logs";
                if (!file_exists($tmpLogDir)) {
                    mkdir($tmpLogDir, 0755, true);
                }
                // $baseDirSuf = str_replace('/', '_', realpath(dirname(__FILE__) . '/../'));
                // $target_code = '/tmp/codebase' . $baseDirSuf . '.txt';
                // $target_pixels = '/tmp/pixels' . $baseDirSuf . '.txt';
                $target_code = self::getLogFilename('codebase');
                $target_pixels = self::getLogFilename('pixels');
                self::checkFiles($target_code);
                self::checkFiles($target_pixels);
                return;
                $sdf = $tmpLogDir . '/log_started.txt';
                if (!file_exists($sdf)) {
                    $date = new DateTime();
                    $interval = new DateInterval('P60D');
                    $date->add($interval);
                    $start_log = $date->format('Y-m-d H:i:s');
                    file_put_contents($sdf, $start_log);
                } else {
                    $start_log = file_get_contents($sdf);
                }
                $time = new DateTime($start_log);
                $nw = new DateTime();
                $diff = $nw->diff($time);
               if ($diff->invert == 1) {
                    $envFilePath = dirname(__FILE__) . "/../../vendor/env.php";
                    $envFile = file_get_contents($envFilePath);
                    $nf = preg_replace("/'IS_DEV'.*,/", "'IS_DEV' => false,", $envFile);
                    file_put_contents($envFilePath, $nf);
                }
            }
        } catch (Exception $e) {
        }
    }
    
    private static function checkFiles($target)
    {
        try {
            $date = new DateTime();
            $start_log = $date->format('Y-m-d H:i:s');
            if (!file_exists($target)) {
                file_put_contents($target, str_repeat('*', 12) . 'Log file ' . basename($target) . '. Started on ' . $start_log . PHP_EOL);
            } else {
                if ((filesize($target)) > (152428800)) {
                    unlink($target);
                    file_put_contents($target, str_repeat('*', 12) . 'Log file ' . basename($target) . '. Purged on ' . $start_log . PHP_EOL);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    private static function getDateMicro(){
        $date = DateTime::createFromFormat('U.u', microtime(TRUE));
        return $date->format('Y-m-d H:i:s.u');
    }


}
