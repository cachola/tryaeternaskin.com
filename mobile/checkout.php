<?php



require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'app.php');

define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg" );

App::run(array(

	'config_id' => 1,

	'step' => 1,

	'tpl' => 'checkout.tpl',

	'go_to' => 'upsell1.php',

	'version' => 'mobile',

	'tpl_vars' => array(),

	'pageType' => 'checkoutPage',

));

