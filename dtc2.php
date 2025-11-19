<?php
require_once 'library' . DIRECTORY_SEPARATOR . 'app.php';
use Application\Session;
$prospect = !empty(Session::get('queryParams.prospect_id')) ? Session::get('queryParams.prospect_id') : '';
$prospectId = rand(10000, 99999);
Session::set('steps.1.prospectId',$prospectId);
$_SESSION['addFreeShipping']=true;
$_SESSION['dtcNoFilter']=true;
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg" );
App::run(array(
    'config_id' => 3,
    'step'      => 1,
    'tpl'       => 'dtc2.tpl',
    'go_to'     => 'thank-you.php',
    'version'   => 'desktop',
    'tpl_vars'  => array(),
    'pageType'  => 'checkoutPage',
    'resetSession' => true,
));
