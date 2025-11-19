<?php

require_once (dirname(__DIR__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'app.php');



use Application\Helper\Provider;
use Application\Session;
use Application\CrmPayload;
$inSequence = (Session::has('steps.4')) ;
if (!$inSequence) {
    header('Location:./index.php');
    exit();
}
$crm = new \Application\Controller\CrmsController;
// test

// Session::set('onlyAuthorizedProductTest', true);
$crm->authorize();
if (!$crm->isApproved()) {
    Session::set('onlyAuthorizedProduct', true);
    $crm->authorize();
}

$success = $crm->isApproved();
Session::set('transaction_success', $success);
$declined = !$success;
if ($success) {
    if (!Session::get('onlyAuthorizedProduct', false)) {
    $orderId = $crm->getOrderId();
    if (!empty($steps['1']['products'])) {
        Session::set('steps.1.orderId', $orderId);
    }
    if (!empty($steps['2']['products'])) {
        Session::set('steps.2.orderId', $orderId);
    }
    if (!empty($steps['3']['products'])) {
        Session::set('steps.3.orderId', $orderId);
    }

    if (!empty($steps['4']['products'])) {
        Session::set('steps.4.orderId', $orderId);
    }
} else {
    Session::set('steps.1.orderId', $orderId);
}
}



header('Location: thankyou.php');
