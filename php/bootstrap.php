<?php
// Central bootstrap: load env, start session, DB connection and helpers
define('CACHE_VERSION', '29');
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
$dbPort = (int) (getenv('DB_PORT') ?: 3306);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    $conn->set_charset($dbCharset);
} catch (mysqli_sql_exception $e) {
    error_log('DB connection error: ' . $e->getMessage());
    http_response_code(503);
    exit('Erreur de connexion à la base de données. Veuillez réessayer dans quelques instants.');
}

// Table rate_limits (auto-créée si absente — utilisé par les helpers de rate limiting)
$conn->query("CREATE TABLE IF NOT EXISTS rate_limits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bucket VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_bucket_created (bucket, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// Table admin_audit (auto-créée si absente — journal des actions admin)
$conn->query("CREATE TABLE IF NOT EXISTS admin_audit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT UNSIGNED NULL,
    admin_name VARCHAR(255) NOT NULL,
    action VARCHAR(100) NOT NULL,
    details VARCHAR(255) DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_audit_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// Migration auto : colonnes de vérification d'email (si table utilisateur sans ces colonnes)
$hasVerified = $conn->query("SHOW COLUMNS FROM utilisateur LIKE 'email_verified'");
if ($hasVerified && $hasVerified->num_rows === 0) {
    $conn->query("ALTER TABLE utilisateur
        ADD COLUMN email_verified TINYINT(1) NOT NULL DEFAULT 0,
        ADD COLUMN verification_token VARCHAR(64) DEFAULT NULL,
        ADD COLUMN verification_expires DATETIME DEFAULT NULL");
    // Comptes existants considérés comme vérifiés
    $conn->query("UPDATE utilisateur SET email_verified = 1");
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

// Rate limiting générique basé sur une table rate_limits
function rate_limit_check($conn, $bucket, $max, $windowSeconds) {
    $windowSeconds = (int) $windowSeconds;
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM rate_limits WHERE bucket = ? AND created_at > DATE_SUB(NOW(), INTERVAL ? SECOND)");
    $stmt->bind_param("si", $bucket, $windowSeconds);
    $stmt->execute();
    $cnt = (int) $stmt->get_result()->fetch_assoc()['cnt'];
    $stmt->close();
    return $cnt >= (int) $max;
}

function rate_limit_hit($conn, $bucket) {
    $stmt = $conn->prepare("INSERT INTO rate_limits (bucket) VALUES (?)");
    $stmt->bind_param("s", $bucket);
    $stmt->execute();
    $stmt->close();
}

function rate_limit_ip() {
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// Small helper to escape output
function e($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Stockage hors de la racine publique : les journaux peuvent contenir des e-mails
// et des liens de vérification temporaires. APP_PRIVATE_DIR permet de le déplacer
// encore plus loin en production.
function private_storage_path($relativePath = '') {
    $base = getenv('APP_PRIVATE_DIR') ?: dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'ecodrive-private';
    $base = rtrim($base, DIRECTORY_SEPARATOR);
    return $relativePath === '' ? $base : $base . DIRECTORY_SEPARATOR . ltrim($relativePath, DIRECTORY_SEPARATOR);
}

function site_url($path = '') {
    $configured = getenv('APP_URL') ?: getenv('SITE_URL');
    if (!empty($configured)) {
        $base = rtrim($configured, '/');
        $path = ltrim((string) $path, '/');
        return $base . ($path !== '' ? '/' . $path : '');
    }

    // En l'absence de configuration, le repli est exclusivement local. Ne jamais
    // fabriquer d'URL sensible à partir de HTTP_HOST, contrôlable par le client.
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = 'localhost';

    $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $basePath = preg_replace('#/[^/]+$#', '', $script);
    if (preg_match('#/(php|pages|bornes|voitures)$#', $basePath)) {
        $basePath = preg_replace('#/(php|pages|bornes|voitures)$#', '', $basePath);
    }
    if ($basePath === '' || $basePath === '.') {
        $basePath = '';
    }

    $path = ltrim((string) $path, '/');
    return $scheme . '://' . $host . $basePath . ($path !== '' ? '/' . $path : '');
}

function app_url($path = '') {
    return site_url($path);
}

// Global user state — available to all pages that include bootstrap.php
$user     = $_SESSION['user'] ?? null;
$loggedIn = $user !== null;
$prenom   = $user['prenom'] ?? 'Visiteur';

?>
