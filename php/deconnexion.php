<?php
include 'bootstrap.php';

// Déconnexion sécurisée : POST + token CSRF obligatoires
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf_token'] ?? '')) {
    header('Location: connexion.php');
    exit;
}

// Supprime toutes les variables de session
$_SESSION = [];

// Détruit le cookie de session si nécessaire
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();
header('Location: connexion.php');
exit;
