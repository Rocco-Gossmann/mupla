<?php
header("content-type: audio/mpeg");
$sFile = "/opt/music/" . $_GET['track'];

ob_implicit_flush(true);

$f = fopen($sFile, "r");
if (!$f) {
    http_response_code(404);
    exit;
}

header("content-length: " . filesize($sFile));

while (!feof($f))
    echo fread($f, 256);

fclose($f);
