<?php



require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'app.php');
use Application\Session;

$sessionData = Session::all();
$user_has_prepaid_card = Session::get('user_has_prepaid_card',false);


App::run(array(

	'config_id' => 1,

	'step' => 3,

	'tpl' => 'upsell2.tpl',

	'go_to' => 'upsell3.php',

	'tpl_vars' => array(
		'user_has_prepaid_card' => $user_has_prepaid_card,
	),

	'version' => 'mobile',

	'pageType' => 'upsellPage2',

));

