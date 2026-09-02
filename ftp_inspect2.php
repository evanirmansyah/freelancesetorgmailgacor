<?php
$server = "ftpupload.net";
$user   = "if0_42650085";
$pass   = "Orangertiuw1";
$base   = "ftp://{$user}:{$pass}@{$server}/freelancesetorgmailratetinggi.gamer.gd/htdocs";

function ftpList($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FTPLISTONLY, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    return $err ? "ERROR: $err" : $res;
}

function ftpUpload($url, $localFile) {
    $fp   = fopen($localFile, 'r');
    $size = filesize($localFile);
    $ch   = curl_init($url);
    curl_setopt($ch, CURLOPT_UPLOAD, 1);
    curl_setopt($ch, CURLOPT_INFILE, $fp);
    curl_setopt($ch, CURLOPT_INFILESIZE, $size);
    curl_setopt($ch, CURLOPT_FTP_USE_EPSV, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $result = curl_exec($ch);
    $err    = curl_error($ch);
    curl_close($ch);
    fclose($fp);
    return $err ? "ERROR: $err" : "OK";
}

echo "=== ROOT htdocs ===\n";
echo ftpList("$base/") . "\n";

echo "\n=== routes/ folder ===\n";
echo ftpList("$base/routes/") . "\n";
