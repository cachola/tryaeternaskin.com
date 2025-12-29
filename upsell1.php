<?php

use Application\Session;
use Detection\MobileDetect;

require_once('library' . DIRECTORY_SEPARATOR . 'app.php');
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg");

// Session::set('forcedUpsellMethod','newOrderOrig');
$detect                       = new MobileDetect;
$isMobile    = $detect->isMobile() ? true : false;
$tpl = 'upsell1';
$isMobile=false;
if ($isMobile) {
    $tpl = 'upsell1_mob';
}
App::run(array(
    'config_id'    => 1,
    'step'         => 2,
    'tpl'          => $tpl,
    'go_to'        => 'upsell2',
    'version'      => 'desktop',
    'tpl_vars'     => array(),
    'pageType'     => 'upsell',
));
