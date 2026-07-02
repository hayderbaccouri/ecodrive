<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ecodrive';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset('utf8mb4');

if ($conn->connect_error) {
    // Log detailed error but show a generic message to users
    error_log('DB connection error: ' . $conn->connect_error);
    exit('Erreur de connexion à la base de données. Veuillez réessayer plus tard.');
}

// CSRF : générer un token
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// CSRF : vérifier le token
function csrf_verify($token) {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}
?>
