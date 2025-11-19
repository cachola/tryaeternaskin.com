<?php
require_once 'library' . DIRECTORY_SEPARATOR . 'app.php';
use Application\Session;
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg" );
// $prospect = !empty(Session::get('queryParams.prospect_id')) ? Session::get('queryParams.prospect_id') : '';
// $method = !empty($prospect) ? 'new_order_prospect' : 'downsell1';
// $form_name = !empty($prospect) ? 'checkout_form' : 'downsell_form1';
// $prospectId = rand(10000, 99999);
// Session::set('steps.1.prospectId',$prospectId);

$sessionData = Session::all();

$customer_data = $sessionData['customer'];

App::run(array(
    'config_id' => 1,
    'step'      => 1,
    'tpl'       => 'checkout.tpl',
    'go_to'     => 'upsell1.php',
    'version'   => 'desktop',
    'tpl_vars'  => array(
		'customer_data'  => $customer_data,
    ),
    'pageType'  => 'checkoutPage',
));
