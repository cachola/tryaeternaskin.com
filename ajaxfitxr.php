<?php
require dirname(__FILE__) . '/library/app.php';
use Application\Session;
use Application\TmpLogger;
$payload = Session::get('payload');
// $payload=[];
// $payload['firstName']="TestFirst";
// $payload['lastName']="Test";
// $payload['shippingAddress1']="4844 NW 18th Avenue";
// $payload['shippingZip']="33064";
// $payload['shippingCity']="Pompano Beach";
// $payload['phone']="9547690444";
// $payload['email']="testpythonmail2018@gmail.com";
// $payload['billingFirstName']="TestFirstBill";
// $payload['billingSameAsShipping']="yes";
// $payload['billingLastName']="TestBill";
// $payload['billingAddress1']="4844 NW 18th Bill Avenue ";
// $payload['billingZip']="33065";
// $payload['billingCity']="Pompano Bill";
// $payload['billingCountry']="US";
// $payload['billingState']="FL";
// $payload['cardType']="visa";
// $payload['cardNumber']="4111111111111111";
// $payload['cvv']="357";
// $payload['cardExpiryYear']="22";
// $payload['cardExpiryMonth']="08";
// $payload['shippingState']="FL";
// $payload['shippingCountry']="US";
// $payload['affiliates']['affId']="1000";
// $payload['affiliates']['c1']="463";

function getResponseV2($method, $uri, array $options = [])
{
    $res = sendApiRequestV2($uri, $options);
    return $res;
}

function sendApiRequestV2($url, $params = array())
{

    $curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, $url);
    curl_setopt($curlSession, CURLOPT_HEADER, 0);
    curl_setopt($curlSession, CURLOPT_USERPWD,  "ketofiregummies_fxr_api:jU9FGMuteAnaJ");
    curl_setopt($curlSession, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    curl_setopt($curlSession, CURLOPT_POST, 1);
    curl_setopt($curlSession, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlSession, CURLOPT_TIMEOUT, 5000);
    curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, true);
    $raw = curl_exec($curlSession);

    if (empty($raw)) {
        $raw = curl_error($curlSession);
    }

    curl_close($curlSession);

    return $raw;
}

function importOrder($params)
{
    Tmplogger::log('requestsneo', 'Params:'. print_r($params, true));
    $res = getResponseV2('POST', 'https://api.fxr-core.com/api/v1/new_order', $params);
    Tmplogger::log('requestsfitxr', print_r($res, true));
    $parsed = json_decode($res, true);
     return $parsed;
}
function parseResponse($response)
{
    $array = [];
    $exploded = explode('&', $response);
    foreach ($exploded as $explode) {
        $line = explode('=', $explode);
        if (isset($line[1])) {
            $array[$line[0]] = urldecode($line[1]);
        } else {
            $array[] = $explode;
        }
    }
    return $array;
}

$params = array(
    // "firstName" => $payload['firstName'],
    // "lastName" => $payload['lastName'],
    "billingFirstName" => $payload['firstName'],
    "billingLastName" => $payload['lastName'],
    "billingAddress1" => $payload['billingSameAsShipping'] != 'yes' ? $payload['billingAddress1'] : $payload['shippingAddress1'],
    "billingAddress2" => $payload['billingSameAsShipping'] != 'yes' ? $payload['billingAddress2'] : $payload['shippingAddress2'],
    "billingCity" => $payload['billingSameAsShipping'] != 'yes'  ? $payload['billingCity'] : $payload['shippingCity'],
    "billingState" => $payload['billingSameAsShipping'] != 'yes'  ? $payload['billingState'] : $payload['shippingState'],
    "billingZip" => $payload['billingSameAsShipping'] != 'yes'  ? $payload['billingZip'] : $payload['shippingZip'],
    "billingCountry" => $payload['billingSameAsShipping'] != 'yes' ? $payload['billingCountry'] : $payload['shippingCountry'],
    "phone" => $payload['phone'],
    "email" => $payload['email'],
    "creditCardType" => $payload['cardType'],
    "creditCardNumber" => $payload['cardNumber'],
    "CVV"              => $payload['cvv'],
    "expirationDate" => sprintf('%s%s', $payload['cardExpiryMonth'], $payload['cardExpiryYear']),
    // "shippingId" => "1",
    // "tranType" => "Sale",
    "ipAddress" => $payload['ipAddress'],
    "campaignId" => "949",
    "product_id" => "968",
    "notes" => "",
    "AFID" => isset($payload['affiliates']['afId']) ? $payload['affiliates']['afId'] : '',
    "SID" => isset($payload['affiliates']['sId']) ? $payload['affiliates']['sId'] : '',
    "AFFID" => isset($payload['affiliates']['affId']) ? $payload['affiliates']['affId'] : '',
    "C1" => isset($payload['affiliates']['c1']) ? $payload['affiliates']['c1'] : '',
    "C2" => isset($payload['affiliates']['c2']) ? $payload['affiliates']['c2'] : '',
    "C3" => isset($payload['affiliates']['c3']) ? $payload['affiliates']['c3'] : '',
    "C4" => isset($payload['affiliates']['c3']) ? $payload['affiliates']['c4'] : '',
    // "AID" => isset($payload['affiliates']['aId']) ? $payload['affiliates']['aId'] : '',
    // "OPT" => isset($payload['affiliates']['opt']) ? $payload['affiliates']['opt'] : '',
    // "click_id" => isset($payload['affiliates']['clickId']) ? $payload['affiliates']['clickId'] : ''
);
$a = $params;
$apiResult = importOrder($params);


if ($apiResult['response_code'] == 100 && empty($apiResult['errorFound'])) {
    $ret = array('responseCode' => '100', 'success' => 'true');
    Session::set('upsell4',true);
} else {
    $ret = array('success' => 'false','apiResult' => $apiResult );
}
echo json_encode($ret);
