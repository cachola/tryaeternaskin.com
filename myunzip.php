<?php
$name = 'v1.zip';
$userDestination = '';

$zip = new ZipArchive;
$archiveName = $name; //'myarchive.zip';
if (isset ($userDestination) && $userDestination = '')
{
    $destination = $userDestination;
}
else
{
    $destination = str_replace ('.zip', '', $archiveName);
}
//echo $destination;
//echo $destination;
$res = $zip->open ($archiveName);
if ($res === TRUE)
{
    $zip->extractTo ($destination);
    $zip->close ();
    echo 'ok';
}
else
{
    echo 'failed';
}
?>