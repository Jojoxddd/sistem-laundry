<?php

// Buat direktori sementara di /tmp (karena Vercel bersifat read-only)
$directories = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
    '/tmp/views',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Redirect path storage Laravel ke /tmp
putenv('APP_STORAGE=/tmp/storage');
putenv('VIEW_COMPILED_PATH=/tmp/views');

// Jalankan Laravel
require __DIR__ . '/../public/index.php';
