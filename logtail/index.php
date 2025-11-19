<?php
require_once('authenticate.php');
require_once('config.php');
initViewer();
$logStatus = getLoggingStatus();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tail Log Viewer</title>

    <meta charset="utf-8">

    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="logtail.js"></script>
    <link href="logtail.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="navbar">
        <a id="pause" href='javascript:void(0);'>Pause</a>
        <a id="status" href='javascript:void(0);'>Log Stopped. Start log</a>
        <a id="deleteLog" href='javascript:void(0);'>Delete Log Files</a>
        <label for="interval" style="color:white;">Poll Interval:</label>
        <input id="interval" style="margin-top: 12px;" type="number" min="1" max="10" value=3>
    </div>
    <div class="titlebar">
        <div style="width: 50%;float:left;text-align: center;padding-top: 6px;">
            Code Log
        </div>
        <div style="width: 50%;float:right;text-align: center;padding-top: 6px;">
            Pixels Log
        </div>
    </div>
    <div class="main leftpanel">
        <textarea spellcheck="false" class="textarea1" id="data">Loading...


        </textarea>

    </div>
    <div class="main rightpanel">
        <textarea spellcheck="false" class="textarea2" id="data1">Loading...


        </textarea>

    </div>

</body>
<script>
    var logStatus = <?php echo $logStatus; ?>
</script>

</html>