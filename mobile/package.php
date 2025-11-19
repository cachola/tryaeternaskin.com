<?php

require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'app.php');
// use Application\Helper\Provider;
use Application\Session;
define("GOOGLE_PLACES_API_ID", "AIzaSyDjjpkGKvAiYmdXc5XelM3Rf45Hm4IeIsg" );


$fname=$lname=$email='';
if(isset($_REQUEST['firstName']) && isset($_REQUEST['lastName']) && isset($_REQUEST['email'])){
	$fname=$_REQUEST['firstName'];
	$lname=$_REQUEST['lastName'];
	$email=$_REQUEST['email'];
}

App::run(array(

	'config_id' => 1,
	'step' => 1,

	'tpl' => 'package.tpl',

	'go_to' => 'shipping.php',

	'tpl_vars' => array(
		'fname'=>$fname,
		'lname'=>$lname,
		'email'=>$email,

	),

	'version' => 'mobile',

	'pageType' => 'upsellPage4',

));

