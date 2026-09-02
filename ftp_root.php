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

echo "=== FTP ROOT / ===\n";
echo ftpList("$root/") . "\n";

echo "=== /freelancesetorgmailratetinggi.gamer.gd/ ===\n";
echo ftpList("$root/freelancesetorgmailratetinggi.gamer.gd/") . "\n";

// Coba path jualgmail.my.id langsung
echo "=== /jualgmail.my.id/ ===\n";
echo ftpList("$root/jualgmail.my.id/") . "\n";

echo "=== /jualgmail/ ===\n";
echo ftpList("$root/jualgmail/") . "\n";
