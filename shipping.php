<?php
require_once('library' . DIRECTORY_SEPARATOR . 'app.php');
// define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg" );
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg" );

App::run(array(
    'config_id'    => 3,
    'step'         => 1,
    'tpl'          => 'shipping.tpl',
    'go_to'        => 'checkout.php',
    'version'      => 'desktop',
    'tpl_vars'     => array(),
    'pageType'     => 'leadPage',
));
