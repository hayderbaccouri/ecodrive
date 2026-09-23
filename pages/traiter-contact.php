<?php
include __DIR__ . '/../php/bootstrap.php';

// Traitement du formulaire de contact — pages/contact.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['contact_form'])) {
    header('Location: contact.php');
    exit;
}

if (!csrf_verify($_POST['csrf_token'] ?? '')) {
    $_SESSION['contact_error'] = 'Session invalide, veuillez réessayer.';
    header('Location: contact.php');
    exit;
}

// Rate limiting : max 3 messages / 10 min / IP
$bucket = 'contact:' . rate_limit_ip();
if (rate_limit_check($conn, $bucket, 3, 600)) {
    $_SESSION['contact_error'] = 'Trop de tentatives. Réessayez dans 10 minutes.';
    header('Location: contact.php');
    exit;
}
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$sujet   = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '') $_SESSION['contact_error'] = 'Nom requis.';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $_SESSION['contact_error'] = 'Email invalide.';
elseif (strlen($message) < 10) $_SESSION['contact_error'] = 'Message trop court (min. 10 caractères).';
else {
    // Persistance en base
    $stmt = $conn->prepare("INSERT INTO contact_message (nom, email, telephone, sujet, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $sujet, $message);
    $stmt->execute();
    $stmt->close();
    rate_limit_hit($conn, $bucket);

    $to = 'contact@ecodrive.tn';
    $subject = '[EcoDrive Contact] ' . ($sujet ?: 'Sans sujet');
    $body  = "Nom : $name\n";
    $body .= "Email : $email\n";
    $body .= "Téléphone : " . ($phone ?: 'Non renseigné') . "\n";
    $body .= "Sujet : " . ($sujet ?: 'Non renseigné') . "\n\n";
    $body .= "Message :\n$message\n";
    $headers  = "From: noreply@ecodrive.tn\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $sent = @mail($to, $subject, $body, $headers);

    $logDir = private_storage_path('logs');
    if (!is_dir($logDir)) { @mkdir($logDir, 0700, true); }
    $log  = "[" . date('Y-m-d H:i:s') . "]\n";
    $log .= "Nom : $name\nEmail : $email\nTél : $phone\nSujet : $sujet\nMessage : $message\nMail envoyé : " . ($sent ? 'Oui' : 'Non (mail() a échoué)') . "\n---\n";
    @file_put_contents($logDir . '/mail_log.txt', $log, FILE_APPEND | LOCK_EX);
}

header('Location: contact.php' . (isset($_SESSION['contact_error']) ? '?error=1' : '?success=1'));
exit;
