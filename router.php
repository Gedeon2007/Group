<?php
declare(strict_types=1);

header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$file = __DIR__ . $path;

// L’API, les fichiers réels et les assets passent directement au serveur PHP.
if ($path !== '/' && is_file($file)) {
    return false;
}

// Toutes les autres routes publiques sont rendues par la SPA.
readfile(__DIR__ . '/index.html');
