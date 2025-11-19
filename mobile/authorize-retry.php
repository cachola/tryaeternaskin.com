<?php
error_reporting(0);
require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'app.php');

use Application\Helper\Provider;
use Application\Session;
use Application\CrmPayload;
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg" );
$sessionData = Session::all();


$customer_data = $sessionData['customer'];

$transactionAttemp = is_null(Session::get('trasansaction_attemp'))  ? 0 : Session::get('trasansaction_attemp');
$tooManyAttempts = false;
if ($transactionAttemp >=  Session::get('max_attemps'))
{
    $tooManyAttempts = true;
    session_destroy();
 }

 Session::set('in_trasansaction_attemp',false);
 App::run(array(
    'config_id' => 9,
    'version'   => 'mobile',
    'tpl'       => 'authorize-retry.tpl',
    'go_to'     => 'authorize.php',
    'tpl_vars'  => array(
        'customer' => $customer_data,
        'tooManyAttempts' => $tooManyAttempts,
    ),
    'pageType'  =>  'checkoutPage' ,
));
