<?php
use Application\Session;
use Detection\MobileDetect;
require_once('library' . DIRECTORY_SEPARATOR . 'app.php');
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg");


// Session::remove('forcedUpsellMethod');
        $detect                       = new MobileDetect;
       $isMobile    = $detect->isMobile() ? true : false;
$tpl='upsell3';
if($isMobile){
    $tpl='upsell3_mob';
}
App::run(array(
    'config_id'    => 1,
    'step'         => 4,
    'tpl'          => $tpl,
    'go_to'        => 'upsell4',
    'version'      => 'desktop',
    'tpl_vars'     => array(),
    'pageType'     => 'upsell',
));
