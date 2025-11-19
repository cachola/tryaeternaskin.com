<?php

namespace Extension\LimelightUtilPack;

use Application\Config;
use Application\CrmPayload;
use Application\Http;

class DisableNote
{
    public function removeNote()
    {
        if (
                CrmPayload::get('meta.crmType') !== 'limelight' ||
                Config::extensionsConfig('LimelightUtilPack.remove_note') !== true
        )
        {
            return;
        }

        CrmPayload::remove('userIsAt');
        CrmPayload::remove('userAgent');
    }

    public function removeOfferUrlFromNote()
    {
        if (
                CrmPayload::get('meta.crmType') !== 'limelight' ||
                Config::extensionsConfig('LimelightUtilPack.remove_offer_url_from_note') !== true
        )
        {
            return;
        }

        CrmPayload::remove('userIsAt');
    }

    public function encryptNote()
    {
        if (
                CrmPayload::get('meta.crmType') !== 'limelight' ||
                Config::extensionsConfig('LimelightUtilPack.encrypt_note') !== true
        )
        {
            return;
        }
        $crmPayload = Http::getOptions();
        $crmArray = array();
        if (!empty($crmPayload[10015]))
        {
            if(!is_array($crmPayload[10015]))
            {               
                parse_str($crmPayload[10015], $crmPayload[10015]);
            }
            foreach ($crmPayload[10015] as $key => $val)
            {
                if ($key == 'notes')
                {
                    $notes = base64_encode($crmPayload[10015][$key]);
                    $crmPayload[10015][$key] = wordwrap($notes, 50, "\n", true);
                }
                $crmArray[$key] = $crmPayload[10015][$key];
            }
            Http::updateOptions(array('10015' => $crmArray));
        }
    }

}
