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

// Session menggunakan database (persisten di Aiven MySQL)
$_ENV['SESSION_DRIVER'] = 'database';
$_SERVER['SESSION_DRIVER'] = 'database';
putenv('SESSION_DRIVER=database');

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

$_ENV['APP_DEBUG'] = 'false';
$_SERVER['APP_DEBUG'] = 'false';
putenv('APP_DEBUG=false');

// Force HTTPS untuk Vercel agar asset/CSS tidak terblokir (Mixed Content)
$_SERVER['HTTPS'] = 'on';
$_ENV['HTTPS'] = 'on';
putenv('HTTPS=on');

// ── Database: Semua credential dibaca dari Environment Variables Vercel ──
// Tidak perlu hardcode — set di Vercel Dashboard:
//   DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
//   APP_KEY, APP_URL

try {
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    // Log error ke Vercel Function Logs
    error_log('Laravel Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

    http_response_code(500);
    echo '<h1>Server Error</h1>';
    echo '<p>Terjadi kesalahan internal. Silakan coba lagi nanti.</p>';
}
