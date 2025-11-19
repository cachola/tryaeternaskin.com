<?php



require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'app.php');
use Application\Session;

$sessionData = Session::all();
$user_has_prepaid_card = Session::get('user_has_prepaid_card',false);


App::run(array(

	'config_id' => 1,

	'step' => 2,

	'tpl' => 'upsell1.tpl',

	'go_to' => 'upsell2.php',

	'tpl_vars' => array(
		'user_has_prepaid_card' => $user_has_prepaid_card,
	),

	'version' => 'mobile',

	'pageType' => 'upsellPage1',

));


