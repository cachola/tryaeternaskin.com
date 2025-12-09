<?php
use Application\Session;

require_once('library' . DIRECTORY_SEPARATOR . 'app.php');
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg");
use Detection\MobileDetect;
// Session::set('forcedUpsellMethod','newOrderOrig');
        $detect                       = new MobileDetect;
       $isMobile    = $detect->isMobile() ? true : false;
$tpl='upsell2';
if($isMobile){
    $tpl='upsell2_mob';
}
App::run(array(
    'config_id'    => 1,
    'step'         => 3,
    'tpl'          => $tpl,
    'go_to'        => 'upsell3',
    'version'      => 'desktop',
    'tpl_vars'     => array(),
    'pageType'     => 'upsell',
));
