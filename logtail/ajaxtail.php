<?php
require_once('authenticate.php');
require_once('config.php');
if (!isset($_POST["req"]) ) {
    die();
}
try {
    switch ($_POST['req']) {
        case 'getLog':
            # code...

            $initial_lenght = 200000;
            if (!isset($_POST["name"]) || !isset($_POST["log_file_size"])) {
                die();
            }

            $name = $_POST['name'];
            $log_file_size = $_POST["log_file_size"];

            $baseDirSuf = str_replace('/', '_', realpath('../'));

            switch ($name) {
                case 'code':
                    $filename = '/tmp/codebase' . $baseDirSuf . '.txt';
                    break;
                case 'pixels':
                    $filename = '/tmp/pixels' . $baseDirSuf . '.txt';
                    break;
            }

            $filesize = (filesize($filename));
            if ($filesize > $log_file_size) {
                if ($log_file_size == 0) {
                    $isize = $log_file_size >= $initial_lenght ? $initial_lenght : $filesize;
                    $chunk = file_get_contents($filename, false, null, -1 * $isize);
                } else {
                    $chunk = file_get_contents($filename, false, null, $log_file_size);
                }
            } else {
                $chunk = '';
            }

            if (empty($errorMSG)) {
                $msg = "status:ok ";
                echo json_encode(['code' => 200, 'log_file_size' => $filesize, 'chunk' => $chunk, 'msg' => $msg]);
                exit;
            }
            echo json_encode(['code' => 404, 'msg' => $errorMSG]);
            break;
        case 'deleteLogs':
            return;
            deleteLogs();
            echo json_encode(['code' => 200, 'result' => 'ok']);
            break;

        case 'setLogStatus':
                $newStatus = $_POST['logStatus'];
                $ret=setLoggingStatus($newStatus);
                echo json_encode(['code' => 200, 'result' => $ret ?'ok':'error']);
            break;
    }
} catch (Exception $e) {
}
