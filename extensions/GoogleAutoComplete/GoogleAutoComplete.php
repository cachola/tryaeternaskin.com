<?php

namespace Extension\GoogleAutoComplete;

use Application\Http;
use Application\Config;
use Exception;
use Application\Session;

class GoogleAutoComplete
{
	public function googleLoadScripts()
	{
            $this->pageType = Session::get('steps.current.pageType');
            if($this->pageType == 'thankyouPage')
            {
                return;
            }
            $bypassExtension = Session::get('extensions.bypass.avoidExtension');
            if(!empty($bypassExtension))
            {
                return;
            }
            $googleApiKey = Config::extensionsConfig('GoogleAutoComplete.google_api_key');
            $event_type = Config::extensionsConfig('GoogleAutoComplete.event_type');
            $autopopulate_by = Config::extensionsConfig('GoogleAutoComplete.autopopulate_by');
            $disable_component_restriction = Config::extensionsConfig('GoogleAutoComplete.disable_component_restriction');
            $googleApiKey = explode("\n", $googleApiKey);

            shuffle($googleApiKey);
		
        echo $export = "\n<script async defer src=\"https://maps.googleapis.com/maps/api/js?key={$googleApiKey[0]}\"></script>\n<script>var event_type= '" . $event_type . "';var autopopulate_by= '" . $autopopulate_by . "';var disable_component_restriction= '" . $disable_component_restriction . "';</script>\n";
	}
}
