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

// Baca isi setup.php di server
echo "=== Isi setup.php di server ===\n";
echo ftpGet("$base/setup.php") . "\n\n";

// Baca isi api/index.php
echo "=== Cek api/index.php ===\n";
echo substr(ftpGet("$base/api/index.php"), 0, 500) . "\n\n";

// Upload script admin creator ke htdocs root sebagai make_admin.php
$adminScript = '<?php
require __DIR__ . "/vendor/autoload.php";
$app = require __DIR__ . "/bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$email    = "evanirmansyah123@gmail.com";
$password = "Admin@2024!";

$user = App\Models\User::where("email", $email)->first();
if ($user) {
    $user->password = Illuminate\Support\Facades\Hash::make($password);
    $user->role     = "admin";
    $user->save();
    echo json_encode(["status"=>"UPDATED","email"=>$email,"password"=>$password,"pesan"=>"Password direset!"]);
} else {
    App\Models\User::create([
        "name"     => "Admin Setoran",
        "email"    => $email,
        "password" => Illuminate\Support\Facades\Hash::make($password),
        "role"     => "admin",
    ]);
    echo json_encode(["status"=>"CREATED","email"=>$email,"password"=>$password,"pesan"=>"Akun baru dibuat!"]);
}
';

echo "=== Upload make_admin.php ke server ===\n";
$result = ftpUploadContent("$base/make_admin.php", $adminScript);
echo $result . "\n";
if (strpos($result, 'OK') !== false) {
    echo "\n✅ Berhasil! Sekarang buka:\n";
    echo "https://jualgmail.my.id/make_admin.php\n";
}
