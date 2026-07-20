<?php
// Central bootstrap: load env, start session, DB connection and helpers
if (session_status() === PHP_SESSION_NONE) {
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'secure'   => $isSecure,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Load .env if present
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2) + [null, null]);
        if ($k !== null && getenv($k) === false) putenv("$k=$v");
    }
}

// DB configuration from environment
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbName = getenv('DB_NAME') ?: 'ecodrive';
$dbCharset = getenv('DB_CHARSET') ?: 'utf8mb4';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
$conn->set_charset($dbCharset);

// Generic error handler for DB connection
if ($conn->connect_error) {
    error_log('DB connection error: ' . $conn->connect_error);
    exit('Erreur de connexion Ã  la base de donnÃ©es.');
}

// CSRF helpers
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_verify($token) {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

// Small helper to escape output
function e($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

?>
