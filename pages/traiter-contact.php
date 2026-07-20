<?php
session_set_cookie_params(['lifetime' => 7200, 'httponly' => true, 'samesite' => 'Lax']);
session_start();

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) { die('Session invalide.'); }

$now = time();
$contactHistory = $_SESSION['contact_history'] ?? [];
$contactHistory = array_filter($contactHistory, fn($t) => $now - $t < 600);
if (count($contactHistory) >= 3) {
    $_SESSION['contact_error'] = 'Trop de tentatives. Réessayez dans 10 minutes.';
    header('Location: contact.php?error=1');
    exit;
}
$contactHistory[] = $now;
$_SESSION['contact_history'] = $contactHistory;

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$sujet   = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '') $_SESSION['contact_error'] = 'Nom requis.';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $_SESSION['contact_error'] = 'Email invalide.';
elseif (strlen($message) < 10) $_SESSION['contact_error'] = 'Message trop court (min. 10 caractères).';
else {
    $to = 'contact@ecodrive.tn';
    $subject = '[EcoDrive Contact] ' . ($sujet ?: 'Sans sujet');
    $body  = "Nom : $name\n";
    $body .= "Email : $email\n";
    $body .= "Téléphone : " . ($phone ?: 'Non renseigné') . "\n";
    $body .= "Sujet : " . ($sujet ?: 'Non renseigné') . "\n\n";
    $body .= "Message :\n$message\n";
    $headers  = "From: no-reply@ecodrive.tn\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $sent = @mail($to, $subject, $body, $headers);

    $log  = "[" . date('Y-m-d H:i:s') . "]\n";
    $log .= "Nom : $name\nEmail : $email\nTél : $phone\nSujet : $sujet\nMessage : $message\nMail envoyé : " . ($sent ? 'Oui' : 'Non (mail() a échoué)') . "\n---\n";
    @file_put_contents(__DIR__ . '/../private/logs/mail_log.txt', $log, FILE_APPEND | LOCK_EX);
}

header('Location: contact.php' . (isset($_SESSION['contact_error']) ? '?error=1' : '?success=1'));
exit;
