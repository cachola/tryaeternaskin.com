<?php

namespace Extension\AsyncSplit;

use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Helper\Alert;
use Database\Connectors\ConnectionFactory;
use Exception;

class Helper
{
    private static $dbConnection = null;

    private function __construct()
    {
        return;
    }

    public static function getDatabaseConnection()
    {
        if (self::$dbConnection === null) {
            try {
                $factory            = new ConnectionFactory();
                self::$dbConnection = $factory->make(array(
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
                    'identifier'    => 'Native Data Capture Transactions in Async Split',
                    'text'          => 'Please check your database credential',
                    'type'          => 'error',
                    'alert_handler' => 'extensions',
                ));
                return false;
            }
        }
        return self::$dbConnection;
    }

}
