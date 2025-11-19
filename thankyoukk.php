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

// $encodedString = json_encode($orders_details);
 
//Save the JSON string to a text file.
// file_put_contents('orderView3.txt', $encodedString);
// $orders_details=json_decode(file_get_contents('orderView3.txt'), true);
$items = [];
foreach ($orders_details as $key => $value) {
    foreach ($orders_details[$key]['products'] as $key => $value) {
        $product['name'] = $value['name'];
        $product['product_id'] = $value['product_id'];
        $product['price'] = $value['price'];
        $product['qty'] = $value['product_qty'];
        $product['subtotal'] = number_format($value['price'] * $value['product_qty'], 2);
        $total = $total + ($value['price'] * $value['product_qty']);
        array_push($items, $product);
    }
}

$productsDesc = [
    '626' => array('Keto Fire','Keto Fire Gummies','1 Bottle','chk-prodketo.png'),
    '627' => array('Keto Fire','Keto Fire Gummies','3 Bottle','chk-prodketo.png'),
    '628' => array('Keto Fire','Keto Fire Gummies','5 Bottle','chk-prodketo.png'),
    '629' => array('Keto Fire','Keto Fire Gummies','1 Bottle Subscription','chk-prodketo.png'),
    '630' => array('Keto Fire','Keto Fire Gummies','3 Bottle Subscription','chk-prodketo.png'),
    '631' => array('Keto Fire','Keto Fire Gummies','5 Bottle Subscription','chk-prodketo.png'),
    '633' => array('My Super Gummies','Immunity Gummies','1 Bottle Special','chk-prodimm.png'),
    '632' => array('My Super Gummies','ACV Gummies','1 Bottle Special','chk-prodacv.png'),
    '634' => array('Rush Processing','','','up3-prod.png'),
    '424' => array('Neobod','7-Day Free Trial','','up4-prod.png'),
];

foreach ($items as $key => $value) {
    $items[$key]['name'] = $productsDesc[$value['product_id']][0];
    $items[$key]['name1'] = $productsDesc[$value['product_id']][1];
    $items[$key]['name2'] = $productsDesc[$value['product_id']][2];

    $items[$key]['image'] = $productsDesc[$value['product_id']][3];
}

$customer_data = $sessionData['customer'];
$adv2=$adv3=$adv4=$adv5='';
$adv2=trim(strtolower($customer_data['email']));
$adv3=trim(strtolower($customer_data['firstName']));
$adv4=trim(strtolower($customer_data['lastName']));
$adv5=trim(strtolower($customer_data['shippingZip']));

$order_id = $orders_details[0]['order_id'] ;
$order_total= $orders_details[0]['order_total'];



$pixel='';
if (!(Session::get('isScrapFlow') === true || Session::get('steps.meta.isPrepaidFlow') === true)) {
    $pixel='<script id="adtrk" type="text/javascript" src="https://advibe.io/direct_link.min.js" data-conversion="true" data-tid="click_id" data-affid="C1" data-sub2="C2" data-sub3="C3" data-adv1="' . $order_id . '" data-amount="' . $order_total .'"  data-adv2="' . $adv2 . '" data-adv3="' . $adv3 . '" data-adv4="' . $adv4 . '" data-adv5="' . $adv5 . '"> </script>'  ;
}
Session::set('orderIdCustom', $order_id);
Session::set('orderTotalCustom', $order_total);

$affiliates=Session::get('affiliates', array());
$C1=isset($affiliates['c1'])?$affiliates['c1']:'';
    $hidethk=($order_id==null);

App::run(array(
    'config_id' => 1,
    'version'   => 'desktop',
    'tpl'       => 'thank-you.tpl',
    'go_to'     => '',
    'tpl_vars'  => array(
        'order_id'       => $order_id,
        'products'     => $items,
        'customer_data' => $customer_data,
        'total' => $total,
        'order_details'=> $orders_details[0],
        'C1' => $C1,
        'pixel'=> $pixel,
        'hidethk' => $hidethk,
    ),
    'pageType'  => 'thankyouPage',
));
