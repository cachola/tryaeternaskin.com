<?php
require (dirname(__FILE__) . '/library/app.php');
use Application\Session;
use Application\Model\clickApi;
if (isset($_POST['tid'])){

     $affiliates = Session::get('affiliates');

    $affiliates['clickId']=$_POST['tid'];
    $_SESSION['tidSession']= $_POST['tid'];

    Session::set('affiliates', $affiliates);
    $ck=new clickApi;
    $ck->sendEclick();
    $ret=array('responseCode'=> '100');
    echo json_encode($ret);


}