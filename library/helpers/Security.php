<?php

namespace Application\Helper;

use Application\Http;
use Application\Registry;

class Security
{

    private function __construct()
    {
        return;
    }

    public static function isValidLicenseKey($domain, $licenseKey)
    {
        // $url = sprintf(
        //     '%s/api/token/', Registry::system('systemConstants.201CLICKS_URL')
        // );
        // $response = Http::post(
        //     $url, array(
        //         'auth_key'    => Registry::system(
        //             'systemConstants.201CLICKS_AUTH_KEY'
        //         ),
        //         'license_key' => $licenseKey,
        //         'domain_name' => $domain,
        //     )
        // );
        
        // if (!empty($response['curlError']) || (int) $response === 201) {            
        //     return true;
        // }
  
        //return false;
        return true;
    }

    public static function isDomainChanged($currentDomain)
    {
        $registryFile = STORAGE_DIR . DS . '.domain_registry';
        if (!file_exists($registryFile)) {
            return true;
        }
        $registeredDomain = file_get_contents($registryFile);
        if ($registeredDomain === $currentDomain) {
            return false;
        }
        return true;
    }

    public static function registerDomain($currentDomain)
    {
        $registryFile     = STORAGE_DIR . DS . '.domain_registry';
        $registeredDomain = file_put_contents($registryFile, $currentDomain, LOCK_EX);
    }

    public static function encrypt($content, $secureKey)
    {
        $plainText = serialize($content);
        $iv        = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM
        );

        $key = substr(pack('H*', $secureKey), 0, 32);

        $mac         = hash_hmac('sha256', $plainText, substr(bin2hex($key), -32));
        $chipherText = mcrypt_encrypt(
            MCRYPT_RIJNDAEL_256, $key, $plainText . $mac, MCRYPT_MODE_CBC, $iv
        );

        return base64_encode($chipherText) . '|' . base64_encode($iv);
    }

    public static function decrypt($content = null, $secureKey = null)
    {
        $contentParts = explode('|', $content . '|');
        $chipherText  = base64_decode($contentParts[0]);
        $iv           = base64_decode($contentParts[1]);

        if (strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)) {
            return false;
        }

        $key = substr(pack('H*', $secureKey), 0, 32);

        $decoded = trim(
            mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $chipherText, MCRYPT_MODE_CBC, $iv)
        );
        $mac           = substr($decoded, -64);
        $plainText     = substr($decoded, 0, -64);
        $calculatedMac = hash_hmac('sha256', $plainText, substr(bin2hex($key), -32));

        if ($calculatedMac !== $mac) {
            return false;
        }

        return unserialize($plainText);
    }
}
