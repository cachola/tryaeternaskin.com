<?php

$baseDirSuf = str_replace('/', '_', realpath('../'));
$target_code = '/tmp/codebase' . $baseDirSuf . '.txt';
$target_pixels = '/tmp/pixels' . $baseDirSuf . '.txt';

function initViewer()
{
    $tmplogdir = "../tmp/logs";
    if (!file_exists($tmplogdir)) {
        mkdir($tmplogdir, 0755, true);
    }
    $sdf = $tmplogdir . '/log_started.txt';
    $date = new DateTime();
    $date->add(new DateInterval('P2D'));
    file_put_contents($sdf, $date->format('Y-m-d H:i:s'));
}

checkFiles($target_code);
checkFiles($target_pixels);

function deleteLogs()
{
    global $target_code, $target_pixels;
    file_put_contents($target_code, str_repeat('*', 12) . 'Log file ' . basename($target_code) . ' Started.' . PHP_EOL);
    file_put_contents($target_pixels, str_repeat('*', 12) . 'Log file ' . basename($target_pixels) . ' Started.' . PHP_EOL);
}
function checkFiles($target)
{
    if (!file_exists($target)) {
        file_put_contents($target, str_repeat('*', 12) . 'Log file ' . basename($target) . ' Started.' . PHP_EOL);
    }
}

function getLoggingStatus()
{
    $envFilePath = "../vendor/env.php";
    $envFile = file_get_contents($envFilePath);
    $matches = array();
    $retmatch = preg_match("/'IS_DEV'\s?=>\s?(.*),/", $envFile, $matches);
    return ($matches[1]);
}

function setLoggingStatus($newStatus=false)
{
    $newStatus=true;//ever start log for test
    $envFilePath = "../vendor/env.php";
    $envFile = file_get_contents($envFilePath);
    $nf = preg_replace("/'IS_DEV'.*,/", "'IS_DEV' => $newStatus,", $envFile);
    file_put_contents($envFilePath, $nf);
    return true;
}
