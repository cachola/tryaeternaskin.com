<?php
$log_file = "./errors.log";
  

try {
    error_log('POST:' . $url . PHP_EOL . print_r($_POST, true) . PHP_EOL, 3, $log_file);
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $ip = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
    $dateSubs = date('Y-m-d h:i:s');
    $line = array($fname, $lname, $email, $ip, $dateSubs);

    $handle = fopen("yummysubscribe.csv", "a");
    fputcsv($handle, $line);
    fclose($handle);
    $st = 'done';
    $ret=array('responseCode'=> '100','couponCode'=>'YUMMY10','couponEmail'=> $email);
    echo json_encode($ret);
} catch (Exception $e) {
    error_log($e->getMessage(), 3, $log_file);
}
