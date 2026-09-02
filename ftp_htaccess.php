<?php
$server = "ftpupload.net";
$user   = "if0_42650085";
$pass   = "Orangertiuw1";
$base   = "ftp://{$user}:{$pass}@{$server}/freelancesetorgmailratetinggi.gamer.gd/htdocs";

function ftpGet($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $res = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    return $err ? "ERROR: $err" : $res;
}

function ftpUploadContent($url, $content) {
    $tmp = tempnam(sys_get_temp_dir(), 'ftp_');
    file_put_contents($tmp, $content);
    $fp   = fopen($tmp, 'r');
    $size = filesize($tmp);
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
    unlink($tmp);
    return $err ? "❌ $err" : "✅ OK";
}

// Baca .htaccess di server
echo "=== .htaccess di server ===\n";
echo ftpGet("$base/.htaccess") . "\n\n";

// Sekarang upload .htaccess baru yang allow make_admin.php
$newHtaccess = '<IfModule mod_rewrite.c>
    <FilesMatch "make_admin\.php$">
        RewriteEngine Off
    </FilesMatch>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !make_admin\.php
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
';

echo "=== Upload .htaccess baru ===\n";
echo ftpUploadContent("$base/.htaccess", $newHtaccess) . "\n";
