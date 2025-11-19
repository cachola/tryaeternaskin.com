<?php
use Application\Session;

require_once('library' . DIRECTORY_SEPARATOR . 'app.php');
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg");



App::run(array(
    'config_id'    => 1,
    'step'         => 1,
    'tpl'          => 'index',
    'go_to'        => 'checkout',
    'version'      => 'desktop',
    // 'tpl_vars'     => array('divAmount'=> $divAmount),
    'pageType'     => 'landingPage',
    'resetSession' => true,
    // 'ajaxDelay'    => 10, //In seconsds,
));
