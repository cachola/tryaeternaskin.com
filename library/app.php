<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';

use Application\Config;
use Application\CrmPayload;
use Application\CrmResponse;
use Application\Extension;
use Application\Helper\Provider;
use Application\Helper\View;
use Application\Registry;
use Application\Request;
use Application\Resource;
use Application\Session;
use Application\TmpLogger;
use Detection\MobileDetect;
use Application\Model\clickApi;

class App
{
    private static $options = array();

    public static function initialize()
    {
        self::$options = array(
            'config_id' => 0, 'version'  => 'desktop', 'resetSession'  => false,
            'step'      => 0, 'pageType' => 'landingPage', 'ajaxDelay' => 0,
        );
        Bootstrap::initialize('static');
    }

    private function __construct()
    {
        return;
    }

    public static function run($options)
    {
        try {
            // $ip = Request::getClientIp();
            // if (env('IS_DEV', false)) {
            //     file_put_contents('/tmp/codebase.txt', PHP_EOL . '$ip:' . $ip . PHP_EOL, FILE_APPEND);
            // }
            // // $ip='2a00:23c5:51a4:2d01:2d3f:2693:3594:c7d1';// ipv6 url of uk for test
            // $ip_array = unserialize(file_get_contents('ip_array.txt'));
            // if (!is_array($ip_array)) {
            //     $ip_array = array();
            // }
            // if (!isset($ip_array[$ip])) {
            //     $curl = curl_init();
            //     curl_setopt_array($curl, [
            //         CURLOPT_CONNECTTIMEOUT => 1,
            //         CURLOPT_TIMEOUT => 1,
            //         CURLOPT_RETURNTRANSFER => 1,
            //         CURLOPT_URL => 'http://ipwhois.pro/json/' . $ip . '?key=4cHWkgQaXfJY6UCN ',
            //     ]);
            //     $resp = curl_exec($curl);
            //     curl_close($curl);
            //     $rj = json_decode($resp);
            //     $country = $rj->country_code;
            //     $ip_array[$ip] = $country;
            //     while (count($ip_array) > 100) {
            //         array_shift($ip_array);
            //     }
            //     file_put_contents('ip_array.txt', serialize($ip_array));

            //     if (env('IS_DEV', false)) {
            //         file_put_contents('/tmp/codebase.txt', ' response : ' . $resp . PHP_EOL, FILE_APPEND);
            //     }
            // } else {
            //     if (env('IS_DEV', false)) {
            //         file_put_contents('/tmp/codebase.txt', PHP_EOL . ' from cache country:' . $ip_array[$ip] . PHP_EOL, FILE_APPEND);
            //     }
            // }

            // $country = $ip_array[$ip];

            // $country = $ip_array[$ip];
            // $latinCountries = [
            //     'AR', 'BO', 'BR', 'CL', 'CO', 'CR', 'CU', 'DO', 'EC', 'SV', 'GY', 'GP', 'GT', 'HT', 'HN', 'MX', 'NI',
            //     'PA', 'PY', 'PE', 'PR', 'BL', 'MF', 'UY', 'VE'
            // ];
            // $fromlatam= in_array($country, $latinCountries);
            // if (isset($_GET['noredirect']) || isset($_GET['noRedirect']) ||  Session::get('noredirect', false)) {
            //     $noredir=true;
            // }

            // if ($fromlatam &&  ($noredir==false) &&    ($ip!='181.168.34.198') && ($ip!='152.171.212.188')) {
            //     if (env('IS_DEV', false)) {
            //         file_put_contents('/tmp/codebase.txt', 'Redirected to mx. '  . PHP_EOL, FILE_APPEND);
            //     }
            //     header("Location: https://www.neopodz.com.mx/");
            //     exit();
            // }

            self::$options = array_replace_recursive(
                self::$options,
                $options
            );
            self::updateRequiredSessionDataForCurrentStep();
            Extension::getInstance()->performEventActions('beforeViewRender');
            $appVersion = Session::get('extensions.TemplateSwitcher.version');
            if (!empty($appVersion)) {
                self::$options['version'] = $appVersion;
            }

            self::decideRedirectionBasedOnConfigRules();
            Extension::getInstance()->performEventActions('pageLoad');
            self::registerScripts();

            if (
                empty(self::$options['tpl_vars']) ||
                !is_array(self::$options['tpl_vars'])
            ) {
                self::$options['tpl_vars'] = array();
            }
            Session::set('extensions.bypass', self::$options['tpl_vars']);
            $systemTokens      = self::getSystemTokens();
            $configTokens      = self::getConfigTokens();
            $transactionTokens = self::getTransactionTokens();
            $orderDataTokens   = self::getOrderDataTokens();
            self::importClick();
            View::getInstance()->load(
                sprintf(
                    '%s%s%s',
                    self::$options['version'],
                    DS,
                    self::$options['tpl']
                ),
                array_replace_recursive(
                    $systemTokens,
                    $configTokens,
                    $transactionTokens,
                    $orderDataTokens,
                    self::$options['tpl_vars']
                )
            );
            exit(0);
        } catch (Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    private static function getConfigTokens()
    {
        $cardTypes        = Config::settings('allowed_card_types');
        $allowedCardTypes = array();
        foreach ($cardTypes as $cardType) {
            $allowedCardTypes[$cardType] = $cardType;
            if ($cardType === 'master') {
                $allowedCardTypes[$cardType] = 'Master Card';
            }
        }
        $config = array(
            'offer_path'         => sprintf('%s/', rtrim(Request::getOfferPath(), '/')),
            'allowed_card_types' => $allowedCardTypes,
        );
        return array('config' => $config);
    }


    public static function getDelayPixels()
    {
        $fired = Session::get('extensions.delayedTransactions.delaypixels.fired');
        $pixels = Session::get('extensions.delayedTransactions.pixels');
        $isEnabled = Config::extensionsConfig('DelayedTransactions.allow_pixel_fire_for_delay');
        $pString = '';
        if (!empty($pixels) && empty($fired) && !empty($isEnabled)) {
            foreach ($pixels  as  $value) {
                $pString .= $value . "\n";
            }
            Session::set('extensions.delayedTransactions.delaypixels.fired', true);
        }
        return $pString;
    }

    private static function getSystemTokens()
    {
        return array(
            'path' => self::getResourcePaths(),
        );
    }

    private static function getTransactionTokens()
    {
        $tokens = array();
        if (Session::has('customer')) {
            $tokens['customer'] = Session::get('customer');
        }
        if (Session::has('steps')) {
            $tokens['steps'] = Session::get('steps');
        }
        return $tokens;
    }

    private static function getResourcePaths()
    {
        $paths      = array();
        $appVersion = self::$options['version'];

        $localDirs = glob(APP_DIR . DS . $appVersion . DS . '*', GLOB_ONLYDIR);
        if (empty($localDirs) && !is_array($localDirs)) {
            $localDirs = array();
        }

        foreach ($localDirs as $dirPath) {
            $dirName = str_replace(
                APP_DIR . DS . $appVersion . DS,
                '',
                $dirPath
            );
            $paths[$dirName] = sprintf(
                '%s/app/%s/%s',
                Provider::getResourceBasePath($dirName),
                $appVersion,
                $dirName
            );
        }

        $assetsDirs = glob(BASE_DIR . DS . 'assets' . DS . '*', GLOB_ONLYDIR);
        if (empty($assetsDirs) && !is_array($assetsDirs)) {
            $assetsDirs = array();
        }

        foreach ($assetsDirs as $dirPath) {
            $dirName = str_replace(
                BASE_DIR . DS . 'assets' . DS,
                '',
                $dirPath
            );
            $paths[sprintf('assets_%s', $dirName)] = sprintf(
                '%s/assets/%s',
                Provider::getResourceBasePath($dirName),
                $dirName
            );
        }
        $paths['alternative_cdn_path'] = Provider::getAlternativeCdnPath();
        return $paths;
    }

    private static function getOrderDataTokens()
    {
        $shippingData = array(
            'shipping_first_name'     => Session::get('customer.firstName', ''),
            'shipping_last_name'      => Session::get('customer.lastName', ''),
            'email_address'           => Session::get('customer.email', ''),
            'customers_telephone'     => Session::get('customer.phone', ''),
            'shipping_street_address' => Session::get('customer.shippingAddress1', ''),
            'shipping_postcode'       => Session::get('customer.shippingZip', ''),
            'shipping_city'           => Session::get('customer.shippingCity', ''),
            'shipping_state'          => Session::get('customer.shippingState', ''),
            'shipping_country'        => Session::get('customer.shippingCountry', ''),
        );

        $billingData = array_filter(array(
            'billing_first_name'     => Session::get('customer.billingFirstName', ''),
            'billing_last_name'      => Session::get('customer.billingLastName', ''),
            'billing_street_address' => Session::get('customer.billingAddress1', ''),
            'billing_postcode'       => Session::get('customer.billingZip', ''),
            'billing_city'           => Session::get('customer.billingCity', ''),
            'billing_state'          => Session::get('customer.billingState', ''),
            'billing_country'        => Session::get('customer.billingCountry', ''),
        ));

        if (empty($billingData)) {
            foreach ($shippingData as $key => $value) {
                if (strpos($key, 'shipping_') === 0) {
                    $billingKey               = str_replace('shipping_', 'billing_', $key);
                    $billingData[$billingKey] = $value;
                }
            }
        }

        return array(
            'order_data' => array_replace($shippingData, $billingData),
        );
    }

    private static function updateRequiredSessionDataForCurrentStep()
    {
        TmpLogger::logdev('log', PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL
            . "******app updateRequiredSessionDataForCurrentStep start******** " .  date("Y-m-d h:i:sa") . $_SERVER['REQUEST_URI'] . " " . $_SERVER['PHP_SELF'] . " " . PHP_EOL
            .  print_r($_REQUEST, true)  . PHP_EOL);
        if (isset($_SESSION)) {
            TmpLogger::logdev('log', print_r($_SESSION, true) . PHP_EOL);
        }
        TmpLogger::logdev('log', "******app updateRequiredSessionDataForCurrentStep start end******** "
            .  date("Y-m-d h:i:sa")  . PHP_EOL);

        self::checkAndResetSessionIfRequired();
        if (isset($_GET['noredirect']) || isset($_GET['noRedirect'])) {
            Session::set('noredirect', true);
        }

        if (!Session::has('appVersion')) {
            Session::set('appVersion', self::$options['version']);
        }

        $currentStep = self::getCurrentStepInformation();

        $crm = Config::crms(sprintf('%d', $currentStep['crmId']));
        if (!Session::has('crmType') && !empty($crm['crm_type'])) {
            Session::set('crmType', $crm['crm_type']);
        }

        $currentStepId = (int) Session::get('steps.current.id', 1);

        if (
            (strpos($currentStep['pageType'], 'upsellPage') === 0 ||
                $currentStep['pageType'] === 'thankyouPage') &&
            $currentStepId !== $currentStep['id']
        ) {
            Session::set(
                'steps.previous',
                Session::get('steps.current', array())
            );
        }

        unset($currentStep['crmId']);
        Session::set('steps.current', $currentStep);

        if ($currentStep['pageType'] !== 'thankyouPage') {
            Session::set('steps.next.link', $currentStep['goto']);
        } else {
            Session::remove('steps.next');
        }

        $previousData = Session::get(sprintf('steps.%d', $currentStep['id']));
        if (is_array($previousData)) {
            $currentStep = array_replace_recursive($previousData, $currentStep);
        }
        Session::set(sprintf('steps.%d', $currentStep['id']), $currentStep);
        TmpLogger::logdev('log', "******app updateRequiredSessionDataForCurrentStep exit******** "
            .  date("Y-m-d h:i:sa") . PHP_EOL
            .  print_r($_REQUEST, true)  . PHP_EOL
            . print_r($_SESSION, true) . PHP_EOL
            . "******app updateRequiredSessionDataForCurrentStep exit end******** "
            .  date("Y-m-d h:i:sa") . PHP_EOL);
    }

    private static function checkAndResetSessionIfRequired()
    {
        $clearAndResetSession = false;

        if (self::$options['resetSession'] === true) {
            $clearAndResetSession = true;
        } else {
            $currentUrl = preg_replace('/^https?:\/\//', '', trim(str_replace(
                '/index.php',
                '',
                strtok(Request::getUri(), '?')
            ), '/'));

            $baseUrl = preg_replace(
                '/^https?:\/\//',
                '',
                trim(Request::getBaseUrl(), '/')
            );

            if ($currentUrl === $baseUrl) {
                $clearAndResetSession = true;
            }
        }

        $sesCartData = '';
        if (!empty(Session::get('extensions.cart'))) {
            $sesCartData = Session::get('extensions.cart');
        }
        if ($clearAndResetSession === true) {
            Session::clear();
            Session::set('queryParams', Request::query()->all());
            self::updateRequiredSessionDataForAffiliates();
        }
        if (!empty($sesCartData)) {
            Session::set('extensions.cart', $sesCartData);
        }
    }

    private static function getCurrentStepInformation()
    {
        $currentStep = array(
            'id'        => (int) self::$options['step'],
            'configId'  => (int) self::$options['config_id'],
            'goto'      => (string) self::$options['go_to'],
            'pageType'  => (string) self::$options['pageType'],
            'ajaxDelay' => (int) self::$options['ajaxDelay'],
        );

        if (strpos(strrev($currentStep['goto']), 'php.') !== 0) {
            $currentStep['goto'] = sprintf('%s.php', $currentStep['goto']);
        }

        $config = Config::configurations(sprintf('%d', $currentStep['configId']));

        $currentStep['crmId'] = empty($config['crm_id']) ? 0 : (int) $config['crm_id'];
        $currentStep['link']  = basename(Request::server()->get('SCRIPT_NAME'));

        return $currentStep;
    }

    private static function updateRequiredSessionDataForAffiliates()
    {
        $affiliatesMapping = array(
            'afId'    => array('AFID', 'afid', 'af_id'),
            'affId'   => array('AFFID', 'affid', 'aff_id'),
            'sId'     => array('SID', 'sid'),
            'c1'      => array('C1','S1', 'sourceValue1','subid', 's1'),
            'c2'      => array('C2','S2', 'sourceValue2', 's2'),
            'c3'      => array('C3','S3', 'sourceValue3', 's3'),
            'c4'      => array('C4','S4', 'sourceValue4', 's4'),
            'c5'      => array('C5','S5', 'sourceValue5', 's5'),
            'c6'      => array('C6','S6', 'sourceValue6', 's6'),
            'aId'     => array('AID', 'aid'),
            'opt'     => array('OPT', 'opt'),
            'clickId' => array('click_id'),
        );
        $queryKeys  = array_keys(Request::query()->all());
        $affiliates = array();
        foreach (array_keys($affiliatesMapping) as $key) {
            if (in_array($key, $queryKeys)) {
                $affiliates[$key] = Request::query()->get($key);
                continue;
            }
            foreach ($affiliatesMapping[$key] as $alias) {
                if (in_array($alias, $queryKeys)) {
                    $affiliates[$key] = Request::query()->get($alias);
                    break;
                }
            }
        }
        Session::set('affiliates', $affiliates);
        $_SESSION['httpReferer'] =  $_SERVER['HTTP_REFERER'];
    }

    private static function decideRedirectionBasedOnConfigRules()
    {
        if (
            !Config::settings('enable_mobile_version') &&
            self::$options['version'] === 'desktop'
        ) {
            return;
        } elseif (!Config::settings('enable_mobile_version')) {
            self::redirectToDevice('desktop');
        }

        if (Config::settings('allow_direct_access')) {
            return;
        }

        if (
            Config::settings('mobile_version_only') &&
            self::$options['version'] !== 'mobile'
        ) {
            self::redirectToDevice('mobile');
        } elseif (Config::settings('mobile_version_only')) {
            return;
        }

        $detector = new MobileDetect();
        $device   = $detector->isMobile() ? 'mobile' : 'desktop';

        if ($detector->isTablet() && Config::settings('redirect_tablet_screen')) {
            $device = 'desktop';
        } elseif ($detector->isTablet()) {
            $device = 'mobile';
        }

        if ($device !== self::$options['version']) {
            self::redirectToDevice($device);
        }
    }

    private static function redirectToDevice($device = 'desktop')
    {
        $getOfferPath = sprintf('%s/', rtrim(Request::getOfferPath(), '/'));
        if ($device === 'desktop') {
            $url = $getOfferPath;
        } else {
            $url = sprintf(
                '%s%s',
                $getOfferPath,
                Config::settings('mobile_path')
            );
        }
        $queryParams = http_build_query(Request::query()->all());
        $queryString = empty($queryParams) ? '/' : '/?' . $queryParams;
        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, 'promo.php') !== false) {
            $addr = rtrim($url) . "promo.php" . ltrim(rtrim($queryString, '/'), '/');
            header(sprintf('Location: %s', $addr));
            exit();
        }
        if (strpos($uri, 'index2.php') !== false) {
            $addr = rtrim($url) . "index2.php" . ltrim(rtrim($queryString, '/'), '/');
            header(sprintf('Location: %s', $addr));
            exit();
        }
        if (strpos($uri, 'dtc.php') !== false) {
            $addr = rtrim($url) . "dtc.php" . ltrim(rtrim($queryString, '/'), '/');
            header(sprintf('Location: %s', $addr));
            exit();
        }
        header(sprintf('Location: %s', rtrim($url, '/') . $queryString));
        exit();
    }

    private static function registerScripts()
    {
        if (is_array(Registry::system('scripts'))) {
            foreach (Registry::system('scripts') as $key => $path) {
                Resource::register('script', $key, $path);
            }
        }

        if (is_array(Registry::extension('scripts'))) {
            foreach (Registry::extension('scripts') as $extensionName => $scripts) {
                foreach ($scripts as $key => $relativePath) {
                    $path = sprintf(
                        'extensions/%s/%s',
                        $extensionName,
                        $relativePath
                    );
                    Resource::register('script', $key, $path);
                }
            }
        }
    }

    private static function importClick()
    {
        // if (!Session::get('crmType') == 'konnektive') {
        //     return;
        // }
        // $crm=new \Application\Controller\CrmsController;
        // $crm->importClick();
        $ck=new clickApi();
        $ck->buyClick();
    }
}

App::initialize();
