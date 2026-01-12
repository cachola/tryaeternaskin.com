<?php

require_once('library' . DIRECTORY_SEPARATOR . 'app.php');

use Application\Helper\Provider;
use Application\Session;
use Application\Config;

$sessionData = Session::all();
$items = array();
$total = 0;
$orderIDs = Session::get('orderList', array());

$delay_orders = [];
$steps = Session::get('steps');
$orders_details = Provider::orderView($orderIDs);

$encodedString = json_encode($orders_details);

//Save the JSON string to a text file.
// file_put_contents('orderView3.txt', $encodedString);
// $orders_details=json_decode(file_get_contents('orderView3.txt'), true);
$items = [];
foreach ($orders_details as $key => $value) {
    foreach ($orders_details[$key]['products'] as $key => $value) {
        $product['name'] = $value['name'];
        $product['product_id'] = $value['product_id'];
        $product['price'] = 0;
        $product['subtotal'] = 0;
        $product['qty'] = $value['product_qty'];
        if ($value['product_id'] != "969") {
            $product['price'] = $value['price'];
            $product['subtotal'] = number_format($value['price'] * $value['product_qty'], 2);
            $total = $total + ($value['price'] * $value['product_qty']);
        };
        array_push($items, $product);
    }
}

$productsDesc = [
    '969' => array('Aeterna Skincare Age Defying Cream', 'Sample Pack', 'image.png', 1),
    '971' => array('Aeterna Skincare Hyaluronic Acid + Collagen Anti Age Serum', 'Sample Pack', 'up1-image.png', 2),
    '973' => array('Aeterna Skincare Advanced Eye Cream', '1 Bottle Special', 'up2-image.png', 3),
    '974' => array('Aeterna Skincare Vitamin C Cleanser', '1 Bottle Special', 'up3-image.png', 4),
    '924' => array('Rush Processing', '', 'up3-prod.png', 4),
    // '776' => array('FitnessXr Free Trial', '', 'up4-prod.png'),
    // '774' => array('USADC Free Trial', '', 'up4-prod.png'),
];
foreach ($items as $key => $value) {
    $items[$key]['name'] = $productsDesc[$value['product_id']][0];
    $items[$key]['name1'] = $productsDesc[$value['product_id']][1];
    $items[$key]['image'] = $productsDesc[$value['product_id']][2];
    $items[$key]['sort_order'] = $productsDesc[$value['product_id']][3];
}


function sortArrayBy($array, $column_name, $sort = SORT_DESC)
{

    foreach ($array as $key => $row) {
        $column[$key]  = $row[$column_name];
    }

    array_multisort($column, $sort, $array);
    return $array;
}

$items = sortArrayBy($items, "sort_order", SORT_ASC);

$customer_data = $sessionData['customer'];

$order_id = $orders_details[0]['order_id'];
$order_total = $orders_details[0]['order_total'];
$shipping_amount = $orders_details[0]['shipping_amount'];

$pixel = '';

Session::set('orderIdCustom', $order_id);
Session::set('orderTotalCustom', $order_total);

$affiliates = Session::get('affiliates', array());
$hidethk = ($order_id == null);


// $query = Session::get('queryParams');




if (!$hidethk) {

    if (!(Session::get('isScrapFlow') === true || Session::get('steps.meta.isPrepaidFlow') === true)) {
        $pixel = '<script id="adtrk" type="text/javascript" src="https://advibe.io/direct_link.min.js" data-conversion="true" data-tid="click_id" data-affid="C1" data-adv1="' . $order_id . '" data-amount="' . $order_total . '" ';
        $only_authorized_product =   Session::get('onlyAuthorizedProduct', false);
        if (!empty($steps['2']['products']) && !$only_authorized_product) {
            $pixel = $pixel . 'data-adv-event-id=14';
            $shipping_amount = "19.90";
        }
        $pixel = $pixel . '> </script>';
        // $iframe = '';

//         switch ($affiliates['c1']) {
//             case '11':
//                 $transaction_id = $affiliates['clickId'];
//                 $sub3           = $affiliates['c3'];

//                 $iframe = <<<HTML
// <iframe src="https://gencracking.com/p.ashx?o=7344&e=1111&fb=1&t={$transaction_id}&r={$sub3}" height="1" width="1" frameborder="0"></iframe>
// HTML;

//                 break;
//     //             case '463':
//     //                 $transaction_id = $affiliates['clickId'];
//     //                 $sub3           = $affiliates['c3'];
    
//     //                 $iframe = <<<HTML
//     // <iframe src="https://copilot.lasasoft.com/testpostback?p.ashx?o=7344&e=1111&fb=1&t={$transaction_id}&r={$sub3}" height="1" width="1" frameborder="0"></iframe>
//     // HTML;
    
//     //                 break;
//             default:
//                 break;
//         }
        // $pixel=$iframe . PHP_EOL . $pixel;
    }
}
App::run(array(
    'config_id' => 1,
    'version'   => 'desktop',
    'tpl'       => 'thankyou.tpl',
    'go_to'     => '',
    'tpl_vars'  => array(
        'order_id'       => $order_id,
        'products'     => $items,
        'customer_data' => $customer_data,
        'total' => $total,
        'order_details' => $orders_details[0],
        // 'C1' => $C1,
        'pixel' => $pixel,
        'hidethk' => $hidethk,
        'shipping_amount' => $shipping_amount
    ),
    'pageType'  => 'thankyouPage',
));
