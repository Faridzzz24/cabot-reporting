<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Atur error reporting agar error muncul di log Vercel
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// Atur folder storage ke /tmp karena Vercel bersifat Read-Only
$storagePath = '/tmp/storage';
$app->useStoragePath($storagePath);

// Buat struktur direktori yang dibutuhkan Laravel secara dinamis
foreach (['app', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $dir) {
    if (!is_dir("$storagePath/$dir")) {
        mkdir("$storagePath/$dir", 0777, true);
    }
}

// ── Konfigurasi Serverless (Vercel) ─────────────────────────

// Cache menggunakan array (tidak butuh persistence di serverless)
$_ENV['CACHE_STORE'] = 'array';
$_SERVER['CACHE_STORE'] = 'array';
putenv('CACHE_STORE=array');

// Log ke stderr agar muncul di Vercel Function Logs
$_ENV['LOG_CHANNEL'] = 'errorlog';
$_SERVER['LOG_CHANNEL'] = 'errorlog';
putenv('LOG_CHANNEL=errorlog');

// Production mode
$_ENV['APP_ENV'] = 'production';
$_SERVER['APP_ENV'] = 'production';
putenv('APP_ENV=production');

$_ENV['APP_DEBUG'] = 'true';
$_SERVER['APP_DEBUG'] = 'true';
putenv('APP_DEBUG=true');

// Force HTTPS untuk Vercel agar asset/CSS tidak terblokir (Mixed Content)
$_SERVER['HTTPS'] = 'on';
$_ENV['HTTPS'] = 'on';
putenv('HTTPS=on');

// Set APP_KEY langsung (karena .env tidak terbaca di Vercel)
$_ENV['APP_KEY'] = 'base64:CYyVf2RfIYtdDB+cv9llBTcrnGOa5IwOdvUhV3rWnUA=';
$_SERVER['APP_KEY'] = 'base64:CYyVf2RfIYtdDB+cv9llBTcrnGOa5IwOdvUhV3rWnUA=';
putenv('APP_KEY=base64:CYyVf2RfIYtdDB+cv9llBTcrnGOa5IwOdvUhV3rWnUA=');

// ── Database: Aiven MySQL (dari Environment Variables Vercel) ──
// Cek apakah credential Aiven sudah di-set di Vercel Dashboard
$dbHost = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? null);

if ($dbHost && $dbHost !== 'your-mysql-host.aiven.io') {
    // ✅ Aiven MySQL sudah dikonfigurasi — gunakan MySQL
    $_ENV['DB_CONNECTION'] = 'mysql';
    $_SERVER['DB_CONNECTION'] = 'mysql';
    putenv('DB_CONNECTION=mysql');

    // Session bisa pakai database karena MySQL persisten
    $_ENV['SESSION_DRIVER'] = 'database';
    $_SERVER['SESSION_DRIVER'] = 'database';
    putenv('SESSION_DRIVER=database');
} else {
    // ⚠️ Aiven belum dikonfigurasi — fallback ke SQLite sementara
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_SERVER['DB_CONNECTION'] = 'sqlite';
    putenv('DB_CONNECTION=sqlite');
    $_ENV['DB_DATABASE'] = '/tmp/database.sqlite';
    $_SERVER['DB_DATABASE'] = '/tmp/database.sqlite';
    putenv('DB_DATABASE=/tmp/database.sqlite');

    // Session pakai cookie (SQLite di /tmp tidak persisten)
    $_ENV['SESSION_DRIVER'] = 'cookie';
    $_SERVER['SESSION_DRIVER'] = 'cookie';
    putenv('SESSION_DRIVER=cookie');

    // Auto-migrate & seed saat cold start (SQLite baru dibuat di /tmp)
    $dbFile = '/tmp/database.sqlite';
    $migrated = '/tmp/.migrated';

    if (!file_exists($dbFile) || !file_exists($migrated)) {
        if (!file_exists($dbFile)) {
            touch($dbFile);
        }

        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);

        file_put_contents($migrated, date('Y-m-d H:i:s'));
    }
}

try {
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    error_log('Laravel Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

    http_response_code(500);
    echo '<h1>Laravel Error</h1>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . "\n\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>';
}
