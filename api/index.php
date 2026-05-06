<?php

define('LARAVEL_START', microtime(true));

// Directorios necesarios en /tmp (único escribible en Vercel)
$dirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/testing',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Base de datos SQLite
if (!file_exists('/tmp/database.sqlite')) {
    touch('/tmp/database.sqlite');
}

// Variables de entorno mínimas si no están definidas
$defaults = [
    'APP_NAME'       => 'Admin Coto',
    'APP_ENV'        => 'production',
    'APP_DEBUG'      => 'false',
    'APP_KEY'        => 'base64:9VhEIDiKIcvh8hwsImlu8aG4wC5UaAXXi9FcuWQebUY=',
    'DB_CONNECTION'  => 'sqlite',
    'DB_DATABASE'    => '/tmp/database.sqlite',
    'CACHE_DRIVER'   => 'file',
    'SESSION_DRIVER' => 'file',
    'LOG_CHANNEL'    => 'stderr',
    'CACHE_STORE'    => 'file',
];
foreach ($defaults as $key => $value) {
    if (empty($_ENV[$key]) && empty(getenv($key))) {
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Marcar entorno Vercel
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Ejecutar migraciones si la BD está vacía
try {
    $db = new PDO('sqlite:/tmp/database.sqlite');
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'")->fetchAll();
    if (empty($tables)) {
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('migrate', ['--force' => true]);
        $kernel->call('db:seed', ['--force' => true]);
    }
} catch (\Throwable $e) {
    // Continuar aunque falle la migración automática
    error_log('Migration error: ' . $e->getMessage());
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
