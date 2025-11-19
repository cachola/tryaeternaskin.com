<?php
require_once('library' . DIRECTORY_SEPARATOR . 'app.php');
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg" );
App::run(array(
    'config_id'    => 1,
    'step'         => 1,
    'tpl'          => 'cart.tpl',
    'go_to'        => 'shipping.php',
    'version'      => 'desktop',
    'tpl_vars'     => array(),
    'pageType'     => 'ConfirmPage',
));
