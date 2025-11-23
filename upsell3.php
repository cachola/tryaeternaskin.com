<?php
use Application\Session;

require_once('library' . DIRECTORY_SEPARATOR . 'app.php');
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg");


// Session::remove('forcedUpsellMethod');
App::run(array(
    'config_id'    => 1,
    'step'         => 4,
    'tpl'          => 'upsell3',
    'go_to'        => 'upsell4',
    'version'      => 'desktop',
    'tpl_vars'     => array(),
    'pageType'     => 'upsell',
));
