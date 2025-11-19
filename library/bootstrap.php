<?php
error_reporting(0);
ini_set('display_errors', false);

if (
    !empty($_COOKIE['CB_DEBUG_MODE']) &&
    $_COOKIE['CB_DEBUG_MODE'] === 'ENABLE_DEBUGGER'
) {
    error_reporting(E_ALL);
    ini_set('display_errors', true);
}

$vendor_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor';
require_once $vendor_dir . DIRECTORY_SEPARATOR . 'autoload.php';
require_once $vendor_dir . DIRECTORY_SEPARATOR . 'envloader.php';

use Application\Config;
use Application\Extension;
use Application\Framework;
use Application\Lang;
use Application\Request;
use Application\Router;

class Bootstrap
{
    public static function initialize($requestPageType = 'static')
    {
        if ($requestPageType === 'ajax') {
            set_exception_handler(
                array(get_called_class(), 'exceptionHandler')
            );
        }

        static::defineConstants();
        date_default_timezone_set(Config::settings('app_timezone'));

        if (php_sapi_name() !== 'cli' && !defined('STDIN')) {
            $request = Request::getInstance();
            Request::attributes()->set(
                'requestPageType',
                $requestPageType
            );
            Extension::initializeEngine();
            if ($requestPageType !== 'admin') {
                $domainName = $request->getHost();
            }
        }

        if ($requestPageType === 'ajax') {
            set_time_limit(100);
            static::defineSystemRoutes();
            $framework = new Framework();
            $framework->handle($request);
        }
    }

    public static function exceptionHandler($exception)
    {
        switch ($exception->getCode()) {
            case 1001:
                $errors = array(
                    'configError' => Lang::get('exceptions.config_error'),
                );
                break;
            case 1002:
                $errors = array(
                    'configFileMissing' => Lang::get('exceptions.config_file_missing'),
                );
                break;
            default:
                $errors = array(
                    'unknownError' => Lang::get('exceptions.generic_error'),
                );
        }
        $response = array(
            'success' => false,
            'errors'  => $errors,
            'data'    => Request::form()->all(),
        );
        if (DEV_MODE) {
            $response['traces'] = $exception->getTrace();
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit(1);
    }

    public static function defineSystemRoutes()
    {
        Router::add('/prospect', 'CrmsController@prospect', 'POST');

        Router::add('/fullprospect', 'CrmsController@fullprospect', 'POST');

        Router::add('/prospectupdate', 'CrmsController@prospectupdate', 'POST');

        Router::add('/checkout', 'CrmsController@checkout', 'POST');

        Router::add('/upsell', 'CrmsController@upsell', 'POST');

        Router::add('/downsell', 'CrmsController@downsell', 'POST');

        Router::add('/verify', 'CrmsController@verify', 'POST');

        Router::add('/shipping', 'CrmsController@shipping', 'POST');

        Router::add('/getAlternateProvider', 'CrmsController@getAlternateProvider', 'POST');

        Router::add('/authorize', 'CrmsController@authorize', 'POST');

        Router::add('/validate_coupon', 'CrmsController@validateCoupon', 'POST');
        
        Router::add('/app-config', 'ConfigsController@appConfig');
    }

    public static function defineConstants()
    {
        if (!defined('BASE_DIR')) {
            define('BASE_DIR', dirname(dirname(__FILE__)));
        }
        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }
        if (!defined('APP_DIR')) {
            define('APP_DIR', BASE_DIR . DS . 'app');
        }
        if (!defined('PS')) {
            define('PS', PATH_SEPARATOR);
        }
        if (!defined('LIB_DIR')) {
            define('LIB_DIR', BASE_DIR . DS . 'library');
        }
        if (!defined('STORAGE_DIR')) {
            define('STORAGE_DIR', BASE_DIR . DS . 'storage');
        }
        if (!defined('ADMIN_DIR')) {
            define('ADMIN_DIR', BASE_DIR . DS . 'admin');
        }
        if (!defined('LAZER_DATA_PATH')) {
            define('LAZER_DATA_PATH', STORAGE_DIR . DS . 'admin' . DS);
        }
        if (!defined('LAZER_BACKUP_PATH')) {
            define('LAZER_BACKUP_PATH', LAZER_DATA_PATH . 'backups');
        }
        if (!defined('LANG_DIR')) {
            define('LANG_DIR', BASE_DIR . DS . 'langs');
        }
        if (!defined('EXTENSION_DIR')) {
            define('EXTENSION_DIR', BASE_DIR . DS . 'extensions');
        }
        if (!defined('DEV_MODE')) {
            define('DEV_MODE', Config::settings('development_mode') ? true : false);
        }
        if (!defined('AJAX_PATH')) {
            define('AJAX_PATH', self::isNginxServer()
                ? 'ajax.php?route=/'
                : 'ajax.php/');
        }
        if (!defined('REST_API_PATH')) {
            define('REST_API_PATH', self::isNginxServer()
                ? 'restapi.php?route=/'
                : 'restapi.php/');
        }
    }

    public static function isNginxServer()
    {
        return preg_match('/nginx/i', Request::server()->get('SERVER_SOFTWARE'));
    }
}
