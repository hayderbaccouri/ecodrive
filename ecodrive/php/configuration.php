<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ecodrive';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset('utf8mb4');

if ($conn->connect_error) {
    die('Erreur de connexion à la base de données : ' . $conn->connect_error);
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
