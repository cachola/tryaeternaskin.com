<?php
use Application\Session;

require_once('library' . DIRECTORY_SEPARATOR . 'app.php');
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg");

// Session::set('forcedUpsellMethod','newOrderOrig');

App::run(array(
    'config_id'    => 1,
    'step'         => 2,
    'tpl'          => 'upsell1',
    'go_to'        => 'upsell2',
    'version'      => 'desktop',
    'tpl_vars'     => array(),
    'pageType'     => 'upsell',
));
