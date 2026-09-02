<?php
$server = "ftpupload.net";
$user   = "if0_42650085";
$pass   = "Orangertiuw1";
$base   = "ftp://{$user}:{$pass}@{$server}/freelancesetorgmailratetinggi.gamer.gd/htdocs";

function ftpCheck($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_exec($ch);
    $err  = curl_error($ch);
    $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    curl_close($ch);
    return $err ? "❌ $err" : "✅ Ada (size: $size bytes)";
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
    curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    fclose($fp);
    return $err ? "❌ $err" : "✅ Upload OK";
}

// Cek kemungkinan lokasi routes/web.php
$paths = [
    "routes/web.php",
    "laravel_app/routes/web.php",
    "app/routes/web.php",
];

echo "=== Cek lokasi routes/web.php ===\n";
foreach ($paths as $p) {
    echo "$p : " . ftpCheck("$base/$p") . "\n";
}

// Cek top-level structure
echo "\n=== File PHP di root htdocs ===\n";
$ch = curl_init("$base/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FTPLISTONLY, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$res = curl_exec($ch);
curl_close($ch);
echo $res;
