<?php
$server = "ftpupload.net";
$user   = "if0_42650085";
$pass   = "Orangertiuw1";

function ftpList($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FTPLISTONLY, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    return $err ? "ERROR: $err" : $res;
}

$root = "ftp://$user:$pass@$server";

// Cek isi htdocs di root langsung
echo "=== /htdocs/ (root) ===\n";
echo ftpList("$root/htdocs/") . "\n";

// Cek isi freelancesetorgmail htdocs
echo "=== /freelancesetorgmailratetinggi.gamer.gd/htdocs/ ===\n";
echo ftpList("$root/freelancesetorgmailratetinggi.gamer.gd/htdocs/") . "\n";
