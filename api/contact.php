<?php
declare(strict_types=1);

// API optionnelle : le front utilise Firebase tant que CONFIG_SITE.phpEndpoint reste vide.
// Sur Render, configure ALLOWED_ORIGIN, CONTACT_EMAIL et éventuellement CONTACT_TRANSPORT=log.
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store, max-age=0');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

$allowedOrigin = trim((string) getenv('ALLOWED_ORIGIN'));
$requestOrigin = trim((string) ($_SERVER['HTTP_ORIGIN'] ?? ''));
if ($allowedOrigin !== '' && $requestOrigin === $allowedOrigin) {
    header('Access-Control-Allow-Origin: ' . $allowedOrigin);
    header('Vary: Origin');
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
    http_response_code(204);
    exit;
}
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    respond(405, false, 'Méthode non autorisée.');
}

$contentLength = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);
if ($contentLength > 100000) {
    respond(413, false, 'Message trop volumineux.');
}

$raw = file_get_contents('php://input');
$data = json_decode($raw ?: '', true);
if (!is_array($data)) {
    respond(400, false, 'JSON invalide.');
}

// Le champ invisible protège contre les robots qui remplissent tous les champs.
if (trim((string) ($data['website'] ?? '')) !== '') {
    respond(400, false, 'Requête refusée.');
}

$name = cleanText($data['name'] ?? '', 80);
$whatsapp = cleanText($data['whatsapp'] ?? '', 30);
$message = cleanText($data['message'] ?? '', 2000);
if ($name === '' || $message === '') {
    respond(422, false, 'Le nom et le message sont obligatoires.');
}
if (textLength($name) < 2 || textLength($message) < 8) {
    respond(422, false, 'Le nom ou le message est trop court.');
}
if ($whatsapp !== '' && !preg_match('/^[0-9+() .-]{7,30}$/', $whatsapp)) {
    respond(422, false, 'Le numéro WhatsApp n’est pas valide.');
}

// Limitation simple par IP. En production multi-instance, remplacer par Redis ou un WAF.
$ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
$rateFile = sys_get_temp_dir() . '/tg360-rate-' . hash('sha256', $ip);
$lastRequest = is_file($rateFile) ? (int) @file_get_contents($rateFile) : 0;
if ($lastRequest > 0 && (time() - $lastRequest) < 45) {
    respond(429, false, 'Attends quelques secondes avant de renvoyer un message.');
}
@file_put_contents($rateFile, (string) time(), LOCK_EX);

$transport = strtolower(trim((string) getenv('CONTACT_TRANSPORT')));
$contactEmail = trim((string) getenv('CONTACT_EMAIL'));
$subject = 'TOTAL GROUP 360 · nouveau message de contact';
$body = "Nom/Pseudo : {$name}\nWhatsApp : " . ($whatsapp ?: 'non fourni') . "\nIP : {$ip}\n\nMessage :\n{$message}\n";

if ($transport === 'log') {
    $logFile = sys_get_temp_dir() . '/tg360-contact.log';
    @file_put_contents($logFile, date('c') . "\n" . $body . "\n---\n", FILE_APPEND | LOCK_EX);
    respond(200, true, 'Message reçu.');
}
if ($contactEmail === '' || !filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
    respond(503, false, 'Le service de contact n’est pas encore configuré.');
}

$headers = [
    'From: TOTAL GROUP 360 <no-reply@localhost>',
    'Reply-To: no-reply@localhost',
    'Content-Type: text/plain; charset=UTF-8',
];
if (@mail($contactEmail, $subject, $body, implode("\r\n", $headers))) {
    respond(200, true, 'Message reçu.');
}
respond(503, false, 'Le message n’a pas pu être transmis.');

function cleanText(mixed $value, int $maxLength): string {
    $text = trim(strip_tags((string) $value));
    $text = preg_replace('/[\x00-\x1F\x7F]/u', ' ', $text) ?? '';
    return function_exists('mb_substr') ? mb_substr($text, 0, $maxLength) : substr($text, 0, $maxLength);
}

function textLength(string $text): int {
    return function_exists('mb_strlen') ? mb_strlen($text) : strlen($text);
}

function respond(int $status, bool $ok, string $message): never {
    http_response_code($status);
    echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
