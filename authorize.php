<?php

require_once 'library' . DIRECTORY_SEPARATOR . 'app.php';


use Application\Helper\Provider;
use Application\Session;
use Application\CrmPayload;

$inSequence = (Session::has('steps.4'));
if (!$inSequence) {
    header('Location: ./index.php');
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


// $sessionData = Session::all();
// $customer_data = $sessionData['customer'];
// $steps = Session::get('steps');
// $delay_orders = array();
// // Session::set('forcedUpsellMethod','newOrderOrig');

// $order_data = array();
// if (!empty($steps['1']['products'])) {
//     array_push($delay_orders, $steps['1']['products'][0]);
// }

// if (!empty($steps['2']['products'])) {
//     array_push($delay_orders, $steps['2']['products'][0]);
// }


// if (!empty($steps['3']['products'])) {
//     array_push($delay_orders, $steps['3']['products'][0]);
// }

// if (!empty($steps['4']['products'])) {
//     array_push($delay_orders, $steps['4']['products'][0]);
// }

// if (!empty($delay_orders)){

// $orderIDs = [];

// foreach ($sessionData['steps'] as $key => $value) {
//     if ($key == 1 || $key == 2) {
//         if (!empty($sessionData['steps'][$key]['orderId'])) {
//             array_push($orderIDs, $sessionData['steps'][$key]['orderId']);
//         }
//     }
// }


// $declined = false;
// $makeOrder = true;
// if ( ! Session::get('in_trasansaction_attemp')){
//     Session::set('max_attemps', 3);

// $inSequence = (Session::has('steps.6')) ;
// if (!$inSequence) {
//     header('Location: /');
// }
// if (!Session::get('transaction_success')) {
//     Session::set('in_trasansaction_attemp',true);
//     $transactionAttemp = is_null(Session::get('trasansaction_attemp')) || !$makeOrder ? 0 : Session::get('trasansaction_attemp');
//     if ($transactionAttemp > 0) {
//         $makeOrder = (!Session::get('transaction_success') && $transactionAttemp < Session::get('max_attemps'));
//         $declined = !Session::get('transaction_success');
//     }
//     if ($makeOrder) {
//         Session::set('trasansaction_attemp', ++$transactionAttemp);
    
//         $crm=new \Application\Controller\CrmsController;
//         $crm->setDelayedOrdersProducts($delay_orders);
//         $crm->newOrderDelayed();
//         $success = $crm->isApproved();
//         Session::set('transaction_success', $success);
//         $declined = !$success;
//         if ($success) {
//             $orderId = $crm->getOrderId();
//             if (!empty($steps['1']['products'])) {
//                 Session::set('steps.1.orderId', $orderId);
//             }
//             if (!empty($steps['2']['products'])) {
//                 Session::set('steps.2.orderId', $orderId);
//             }
//             if (!empty($steps['3']['products'])) {
//                 Session::set('steps.3.orderId', $orderId);
//             }
            
//             if (!empty($steps['4']['products'])) {
//                 Session::set('steps.4.orderId', $orderId);
//             }
            
//          }
//     }
// }
// }
// } else {
//     Session::set('transaction_success', true);
// }


//     header('Location: thankyou.php');
