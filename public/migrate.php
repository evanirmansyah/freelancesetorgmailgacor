<?php
/**
 * Web-based migration runner for Vercel deployment
 * DELETE THIS FILE after first run!
 */

// Simple security: require a token
$token = $_GET['token'] ?? '';
$expectedToken = 'setor2026deploy';

if ($token !== $expectedToken) {
    http_response_code(403);
    die('<h1>403 Forbidden</h1><p>Missing or invalid token. Usage: /migrate.php?token=setor2026deploy</p>');
}

set_time_limit(120);
define('LARAVEL_START', microtime(true));

echo '<!DOCTYPE html><html><head><title>Migration Runner</title>';
echo '<style>body{font-family:monospace;background:#1a1a2e;color:#00ff88;padding:20px;} pre{background:#0a0a1a;padding:15px;border-radius:8px;white-space:pre-wrap;} .error{color:#ff4444;} .success{color:#00ff88;} h1{color:#fff;}</style>';
echo '</head><body>';
echo '<h1>🚀 Laravel Migration Runner</h1><pre>';

try {
    chdir(__DIR__);

    if (!file_exists('vendor/autoload.php')) {
        throw new Exception('vendor/autoload.php not found! Composer install may have failed.');
    }

    require 'vendor/autoload.php';

    $app = require_once 'bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    echo "DB_CONNECTION: " . env('DB_CONNECTION') . "\n";
    echo "DATABASE_URL: " . (env('DATABASE_URL') ? '✓ SET' : '✗ NOT SET') . "\n\n";

    echo "Running: config:clear\n";
    $kernel->call('config:clear');

    echo "Running: migrate --force\n";
    $exitCode = $kernel->call('migrate', ['--force' => true]);
    echo $kernel->output();

    if ($exitCode === 0) {
        echo "\n<span class='success'>✅ Migration completed successfully!</span>\n";

        // Run seeders if needed
        echo "\nRunning: db:seed --force\n";
        $kernel->call('db:seed', ['--force' => true]);
        echo $kernel->output();
    } else {
        echo "\n<span class='error'>❌ Migration failed with exit code: $exitCode</span>\n";
    }

    echo "\n\n<span class='success'>⚠️  IMPORTANT: Delete this file immediately after running!</span>\n";
    echo "<a href='/' style='color:#00aaff;'>→ Go to website</a>";

} catch (Exception $e) {
    echo "<span class='error'>ERROR: " . htmlspecialchars($e->getMessage()) . "</span>\n\n";
    echo htmlspecialchars($e->getTraceAsString());
}

echo '</pre></body></html>';
