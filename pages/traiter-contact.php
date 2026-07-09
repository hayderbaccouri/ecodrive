<?php
session_start();

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$sujet   = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '') $_SESSION['contact_error'] = 'Nom requis.';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $_SESSION['contact_error'] = 'Email invalide.';
elseif (strlen($message) < 10) $_SESSION['contact_error'] = 'Message trop court (min. 10 caractères).';
else {
    $log  = "[" . date('Y-m-d H:i:s') . "]\n";
    $log .= "Nom : $name\nEmail : $email\nTél : $phone\nSujet : $sujet\nMessage : $message\n---\n";
    file_put_contents(__DIR__ . '/../mail_log.txt', $log, FILE_APPEND | LOCK_EX);
}

header('Location: contact.php?success=1');
exit;
