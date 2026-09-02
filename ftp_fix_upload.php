<?php
$server = "ftpupload.net";
$user   = "if0_42650085";
$pass   = "Orangertiuw1";
$base   = "ftp://{$user}:{$pass}@{$server}/freelancesetorgmailratetinggi.gamer.gd/htdocs";

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

// 1. Restore .htaccess yang benar
$correctHtaccess = 'Options -Indexes

<IfModule mod_rewrite.c>
    RewriteEngine On

    # If the requested file exists in root, serve it directly
    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^ - [L]

    # Otherwise, route to public/
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
';

echo "=== 1. Restore .htaccess ===\n";
echo ftpUploadContent("$base/.htaccess", $correctHtaccess) . "\n";

// 2. Upload make_admin.php ke public/ folder
$adminScript = '<?php
// Script darurat buat admin - HAPUS SETELAH SELESAI
require __DIR__ . "/../vendor/autoload.php";
$app = require __DIR__ . "/../bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$email    = "evanirmansyah123@gmail.com";
$password = "Admin@2024!";

$user = App\Models\User::where("email", $email)->first();
if ($user) {
    $user->password = Illuminate\Support\Facades\Hash::make($password);
    $user->role     = "admin";
    $user->save();
    echo json_encode(["status"=>"UPDATED","email"=>$email,"password"=>$password,"pesan"=>"Password direset! Segera hapus file ini."]);
} else {
    App\Models\User::create([
        "name"     => "Admin Setoran",
        "email"    => $email,
        "password" => Illuminate\Support\Facades\Hash::make($password),
        "role"     => "admin",
    ]);
    echo json_encode(["status"=>"CREATED","email"=>$email,"password"=>$password,"pesan"=>"Akun baru dibuat! Segera hapus file ini."]);
}
';

echo "=== 2. Upload make_admin.php ke public/ ===\n";
$result = ftpUploadContent("$base/public/make_admin.php", $adminScript);
echo $result . "\n";

if (strpos($result, 'OK') !== false) {
    echo "\n✅ SELESAI! Buka di browser:\n";
    echo "https://jualgmail.my.id/make_admin.php\n\n";
    echo "Login dengan:\n";
    echo "Email   : evanirmansyah123@gmail.com\n";
    echo "Password: Admin\@2024!\n";
}
