<?php



require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'app.php');



App::run(array(

    'config_id'    => 3,

    'step'         => 1,

    'tpl'          => 'confirm.tpl',

    'go_to'        => 'shipping.php',

    'version'      => 'mobile',

    'tpl_vars'     => array(),

    'pageType'     => 'ConfirmPage',

    // 'resetSession' => true,

    // 'ajaxDelay'    => 10, //In seconsds,

));

